<?php
namespace App\Models;

use App\Core\Database;

class Order {
    protected $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Create an order atomically — order row, order items, inventory deduction,
     * and both address rows all live inside ONE transaction.
     * If anything fails the whole thing rolls back with no orphaned data.
     *
     * @param array $orderData  Scalar order fields
     * @param array $items      Cart items from session
     * @param array $shippingAddress  Address fields for shipping
     * @param array|null $billingAddress  Address fields for billing (null = same as shipping)
     * @return int|false  New order ID on success, false on failure
     */
    public function create(array $orderData, array $items, array $shippingAddress, ?array $billingAddress = null) {
        try {
            $this->db->beginTransaction();

            // ── 1. PRE-VALIDATE STOCK (with row-level lock inside transaction) ────
            foreach ($items as $item) {
                $lockStmt = $this->db->prepare(
                    "SELECT stock_quantity FROM product_variants WHERE id = ? FOR UPDATE"
                );
                $lockStmt->execute([$item['variant_id']]);
                $row = $lockStmt->fetch(\PDO::FETCH_ASSOC);

                if (!$row || $row['stock_quantity'] < $item['quantity']) {
                    $this->db->rollBack();
                    throw new \RuntimeException(
                        "OUT_OF_STOCK:{$item['variant_id']}"
                    );
                }
            }

            // ── 2. INSERT ORDER (with retry loop for order number race conditions) ─
            $maxRetries = 3;
            $attempt = 0;
            $orderId = null;

            while ($attempt < $maxRetries) {
                try {
                    $sql = "INSERT INTO orders (
                                order_number, user_id,
                                customer_email, customer_first_name, customer_last_name, customer_phone,
                                subtotal, tax_amount, shipping_cost, discount_amount, total_amount,
                                payment_status, shipping_status, customer_notes,
                                shipping_address_id, billing_address_id,
                                created_at, updated_at
                            ) VALUES (
                                ?, ?,
                                ?, ?, ?, ?,
                                ?, ?, ?, ?, ?,
                                ?, ?, ?,
                                NULL, NULL,
                                NOW(), NOW()
                            )";

                    $stmt = $this->db->prepare($sql);
                    $stmt->execute([
                        $orderData['order_number'],
                        $orderData['user_id'] ?? null,
                        $orderData['customer_email'],
                        $orderData['customer_first_name'],
                        $orderData['customer_last_name'],
                        $orderData['customer_phone'],
                        $orderData['subtotal'],
                        $orderData['tax_amount'] ?? 0.00,
                        $orderData['shipping_cost'] ?? 0.00,
                        $orderData['discount_amount'] ?? 0.00,
                        $orderData['total_amount'],
                        $orderData['payment_status'] ?? 'pending',
                        $orderData['shipping_status'] ?? 'pending',
                        $orderData['customer_notes'] ?? '',
                    ]);
                    $orderId = (int) $this->db->lastInsertId();
                    break; // Success!
                } catch (\PDOException $e) {
                    // Check if it's a unique constraint violation on order_number
                    if ($e->getCode() == 23000 && strpos($e->getMessage(), 'order_number') !== false) {
                        $attempt++;
                        if ($attempt >= $maxRetries) throw $e;
                        // Regenerate order number and try again
                        $orderData['order_number'] = $this->generateOrderNumber();
                        continue;
                    }
                    throw $e; // Other DB error
                }
            }

            // ── 3. SAVE ADDRESSES (inside the same transaction) ──────────────────
            $shippingAddress['order_id'] = $orderId;
            $shippingAddress['address_type'] = 'shipping';
            $shippingAddrId = $this->insertAddress($shippingAddress);

            if ($billingAddress !== null) {
                $billingAddress['order_id'] = $orderId;
                $billingAddress['address_type'] = 'billing';
                $billingAddrId = $this->insertAddress($billingAddress);
            } else {
                $billingAddrId = $shippingAddrId; // same address
            }

            // ── 4. LINK ADDRESSES BACK TO ORDER ──────────────────────────────────
            $this->db->prepare(
                "UPDATE orders SET shipping_address_id = ?, billing_address_id = ?, updated_at = NOW() WHERE id = ?"
            )->execute([$shippingAddrId, $billingAddrId, $orderId]);

            // ── 5. INSERT ORDER ITEMS + DEDUCT STOCK (atomic, concurrency-safe) ──
            $itemStmt = $this->db->prepare(
                "INSERT INTO order_items (order_id, product_id, variant_id, quantity, price_at_purchase)
                 VALUES (?, ?, ?, ?, ?)"
            );

            foreach ($items as $item) {
                $itemStmt->execute([
                    $orderId,
                    $item['product_id'],
                    $item['variant_id'],
                    $item['quantity'],
                    $item['price'],
                ]);

                // Concurrency-safe stock deduction: only succeeds if stock is still sufficient
                $stockStmt = $this->db->prepare(
                    "UPDATE product_variants
                        SET stock_quantity = stock_quantity - ?
                      WHERE id = ? AND stock_quantity >= ?"
                );
                $stockStmt->execute([$item['quantity'], $item['variant_id'], $item['quantity']]);

                if ($stockStmt->rowCount() === 0) {
                    // Another request beat us — rollback everything
                    $this->db->rollBack();
                    throw new \RuntimeException("OUT_OF_STOCK:{$item['variant_id']}");
                }

                // Inventory audit log
                $this->db->prepare(
                    "INSERT INTO inventory_logs (variant_id, order_id, change_amount, reason, created_at)
                     VALUES (?, ?, ?, 'order_sale', NOW())"
                )->execute([$item['variant_id'], $orderId, -$item['quantity']]);
            }

            $this->db->commit();
            return $orderId;

        } catch (\RuntimeException $e) {
            // Already rolled back — just re-throw so the controller can surface it
            throw $e;
        } catch (\Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            error_log("[Order::create] " . $e->getMessage());
            return false;
        }
    }

    /**
     * Insert a single address row and return its new ID.
     * Called only from within an active transaction.
     */
    private function insertAddress(array $addr): int {
        $stmt = $this->db->prepare(
            "INSERT INTO user_addresses
                (user_id, order_id, first_name, last_name, phone,
                 address_type, street, city, state, zip, country, is_default)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $addr['user_id']       ?? null,
            $addr['order_id']      ?? null,
            $addr['first_name']    ?? null,
            $addr['last_name']     ?? null,
            $addr['phone']         ?? null,
            $addr['address_type']  ?? 'shipping',
            $addr['street']        ?? '',
            $addr['city']          ?? '',
            $addr['state']         ?? '',
            $addr['zip']           ?? '',
            $addr['country']       ?? 'United Kingdom',
            $addr['is_default']    ?? 0,
        ]);
        return (int) $this->db->lastInsertId();
    }

    /**
     * Get summary stats for the dashboard
     */
    public function getDashboardStats() {
        $stats = [];
        
        // Total Revenue (Paid orders)
        $stats['total_revenue'] = (float) $this->db->query("SELECT SUM(total_amount) FROM orders WHERE payment_status = 'paid'")->fetchColumn();
        
        // Total Orders
        $stats['total_orders'] = (int) $this->db->query("SELECT COUNT(*) FROM orders")->fetchColumn();
        
        // Total Customers (Unique emails)
        $stats['total_customers'] = (int) $this->db->query("SELECT COUNT(DISTINCT customer_email) FROM orders")->fetchColumn();
        
        // Total Products
        $stats['total_products'] = (int) $this->db->query("SELECT COUNT(*) FROM products")->fetchColumn();

        // Recent Orders
        $stmt = $this->db->query("SELECT * FROM orders ORDER BY created_at DESC LIMIT 5");
        $stats['recent_orders'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        return $stats;
    }

    /**
     * Generate a sequential order number: ORD-YYYY-XXXX
     * Uses MAX(id) so it never duplicates even if rows are deleted.
     */
    public function generateOrderNumber(): string {
        $year = date('Y');
        $stmt = $this->db->prepare(
            "SELECT COALESCE(MAX(id), 0) + 1 AS next_num FROM orders WHERE YEAR(created_at) = ?"
        );
        $stmt->execute([$year]);
        $nextNum = (int) $stmt->fetchColumn();
        return 'ORD-' . $year . '-' . str_pad($nextNum, 4, '0', STR_PAD_LEFT);
    }
    /**
     * Get a paginated list of orders for the admin dashboard.
     */
    public function getAdminList($page = 1, $perPage = 10, $filters = []) {
        $offset = ($page - 1) * $perPage;
        $where = [];
        $params = [];

        if (!empty($filters['search'])) {
            $where[] = "(order_number LIKE ? OR customer_email LIKE ? OR customer_first_name LIKE ? OR customer_last_name LIKE ?)";
            $search = "%{$filters['search']}%";
            $params = array_merge($params, [$search, $search, $search, $search]);
        }

        if (!empty($filters['payment_status']) && $filters['payment_status'] !== 'all') {
            $where[] = "payment_status = ?";
            $params[] = $filters['payment_status'];
        }

        if (!empty($filters['shipping_status']) && $filters['shipping_status'] !== 'all') {
            $where[] = "shipping_status = ?";
            $params[] = $filters['shipping_status'];
        }

        $whereClause = !empty($where) ? " WHERE " . implode(" AND ", $where) : "";

        // Get total count
        $countStmt = $this->db->prepare("SELECT COUNT(*) FROM orders $whereClause");
        $countStmt->execute($params);
        $total = (int) $countStmt->fetchColumn();

        // Get orders
        $sql = "SELECT *, 
                (SELECT COUNT(*) FROM order_items WHERE order_id = orders.id) as items_count 
                FROM orders $whereClause 
                ORDER BY created_at DESC 
                LIMIT ? OFFSET ?";
        
        $stmt = $this->db->prepare($sql);
        $pIndex = 1;
        foreach ($params as $p) {
            $stmt->bindValue($pIndex++, $p);
        }
        $stmt->bindValue($pIndex++, (int)$perPage, \PDO::PARAM_INT);
        $stmt->bindValue($pIndex++, (int)$offset, \PDO::PARAM_INT);
        $stmt->execute();
        $orders = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return [
            'data' => $orders,
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => $page,
            'last_page' => ceil($total / $perPage)
        ];
    }

    /**
     * Get full details for a single order.
     */
    public function getDetail($orderNumber) {
        // 1. Get Order Row
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE order_number = ?");
        $stmt->execute([$orderNumber]);
        $order = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$order) return null;

        // 2. Get Items with variant details
        $stmt = $this->db->prepare("
            SELECT oi.*, p.name as product_name, p.custom_url, v.variant_name, v.sku,
                   (SELECT image_url FROM product_images WHERE product_id = p.id ORDER BY sort_order ASC LIMIT 1) as featured_image
            FROM order_items oi
            JOIN product_variants v ON oi.variant_id = v.id
            JOIN products p ON oi.product_id = p.id
            WHERE oi.order_id = ?
        ");
        $stmt->execute([$order['id']]);
        $order['items'] = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // 3. Get Addresses
        $stmt = $this->db->prepare("SELECT * FROM user_addresses WHERE id = ?");
        
        $stmt->execute([$order['shipping_address_id']]);
        $order['shipping_address'] = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($order['billing_address_id'] === $order['shipping_address_id']) {
            $order['billing_address'] = $order['shipping_address'];
        } else {
            $stmt->execute([$order['billing_address_id']]);
            $order['billing_address'] = $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        return $order;
    }

    /**
     * Get full details for a single order by ID
     */
    public function getDetailById($id) {
        $stmt = $this->db->prepare("SELECT order_number FROM orders WHERE id = ?");
        $stmt->execute([$id]);
        $orderNumber = $stmt->fetchColumn();
        return $orderNumber ? $this->getDetail($orderNumber) : null;
    }

    /**
     * Update order status
     */
    public function updateStatus($id, $type, $status, $trackingNumber = null) {
        $column = ($type === 'payment') ? 'payment_status' : 'shipping_status';
        
        if ($type === 'fulfillment' && $trackingNumber !== null) {
            $stmt = $this->db->prepare("UPDATE orders SET $column = ?, tracking_number = ?, updated_at = NOW() WHERE id = ?");
            return $stmt->execute([$status, $trackingNumber, $id]);
        }

        $stmt = $this->db->prepare("UPDATE orders SET $column = ?, updated_at = NOW() WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }

    /**
     * Get all orders for a specific user
     */
    public function getByUser($userId) {
        $stmt = $this->db->prepare("
            SELECT * FROM orders 
            WHERE user_id = ? 
            ORDER BY created_at DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
