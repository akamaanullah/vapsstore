<?php
namespace App\Controllers\Admin;

use App\Core\Session;

class ProductController extends AdminController {
    
    public function export() {
        $productModel = $this->model('Product');
        $products = $productModel->getExportData();

        $filename = "products_export_" . date('Y-m-d') . ".csv";

        // Clean any output buffer to prevent warnings in CSV
        if (ob_get_length()) ob_end_clean();

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);

        $output = fopen('php://output', 'w');

        // CSV Headers
        fputcsv($output, ['ID', 'Product Name', 'Status', 'Base Price', 'Total Stock', 'Brand', 'Collections', 'Variants (Price)', 'Tags', 'Created At']);

        foreach ($products as $product) {
            fputcsv($output, [
                $product['id'],
                $product['name'],
                ucfirst($product['status']),
                $product['base_price'],
                $product['total_stock'] ?? 0,
                $product['brand_name'] ?? 'N/A',
                $product['collections'] ?? 'None',
                $product['variants'] ?? 'None',
                $product['tags'] ?? '',
                $product['created_at']
            ]);
        }

        fclose($output);
        exit;
    }

    public function index() {
        $productModel = $this->model('Product');
        $products = $productModel->getAdminList();
        $this->view('admin/products', ['products' => $products]);
    }

    public function create() {
        $brandModel = $this->model('Brand');
        $collectionModel = $this->model('Collection');
        
        $brands = $brandModel->getAllBrands();
        $collections = $collectionModel->getAllWithParent();

        $this->view('admin/add-product', [
            'brands' => $brands,
            'collections' => $collections
        ]);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // CSRF Validation
            if (!Session::validateCsrfToken($_POST['csrf_token'] ?? '')) {
                $this->redirect('/admin/products/create?error=Invalid CSRF token');
            }

            $productModel = $this->model('Product');
            
            $data = [
                'name' => $_POST['name'],
                'base_price' => $_POST['price'],
                'status' => $_POST['status'],
                'custom_url' => $_POST['custom_url'] ?? null,
                'short_desc' => $_POST['short_desc'] ?? null,
                'long_desc' => $_POST['description'] ?? '',
                'stock' => $_POST['stock'] ?? 0,
                'sku' => $_POST['sku'] ?? null,
                'brand_id' => !empty($_POST['brand_id']) ? $_POST['brand_id'] : null,
                'collection_ids' => $_POST['collection_ids'] ?? [],
                'variants' => $_POST['variants'] ?? [],
                'tags' => $_POST['tags'] ?? '',
                'seo_title' => $_POST['seo_title'] ?? null,
                'seo_description' => $_POST['seo_description'] ?? null
            ];

            $productId = $productModel->createProduct($data);

            if ($productId) {
                // Handle Image URLs from Media Picker
                if (!empty($_POST['image_urls']) && is_array($_POST['image_urls'])) {
                    foreach ($_POST['image_urls'] as $key => $imageUrl) {
                        if (!empty($imageUrl)) {
                            $productModel->addImage($productId, $imageUrl, $key);
                        }
                    }
                }

                $this->redirect('/admin/products?success=Product created successfully');
            } else {
                $this->redirect('/admin/products/create?error=Failed to create product');
            }
        }
    }

    public function edit($id = null) {
        if (!$id) $this->redirect('/admin/products');

        $productModel = $this->model('Product');
        $product = $productModel->getProductForEdit($id);

        if (!$product) $this->redirect('/admin/products');

        $brandModel = $this->model('Brand');
        $collectionModel = $this->model('Collection');

        $this->view('admin/edit-product', [
            'product' => $product,
            'brands' => $brandModel->all(),
            'collections' => $collectionModel->all()
        ]);
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // CSRF Validation
            if (!Session::validateCsrfToken($_POST['csrf_token'] ?? '')) {
                $this->redirect('/admin/products/edit/' . $id . '?error=Invalid CSRF token');
            }

            $productModel = $this->model('Product');

            $data = [
                'name' => $_POST['name'],
                'base_price' => $_POST['price'],
                'status' => $_POST['status'],
                'custom_url' => $_POST['custom_url'] ?? null,
                'short_desc' => $_POST['short_desc'] ?? null,
                'long_desc' => $_POST['description'] ?? '',
                'brand_id' => !empty($_POST['brand_id']) ? $_POST['brand_id'] : null,
                'tags' => $_POST['tags'] ?? '',
                'seo_title' => $_POST['seo_title'] ?? null,
                'seo_description' => $_POST['seo_description'] ?? null,
                'collection_ids' => $_POST['collection_ids'] ?? []
            ];

            if ($productModel->updateProduct($id, $data)) {
                // Sync Images (Remove deleted ones and update sort_order)
                $imagesToKeep = $_POST['existing_images'] ?? [];
                $productModel->syncImages($id, $imagesToKeep);
                $productModel->updateImageOrder($id, $imagesToKeep);

                // Handle new image URLs from Media Picker
                if (!empty($_POST['image_urls']) && is_array($_POST['image_urls'])) {
                    $startOrder = count($imagesToKeep);
                    foreach ($_POST['image_urls'] as $key => $imageUrl) {
                        if (!empty($imageUrl)) {
                            $productModel->addImage($id, $imageUrl, $startOrder + $key);
                        }
                    }
                }

                $this->redirect('/admin/products?success=Product updated successfully');
            } else {
                $this->redirect('/admin/products/edit/' . $id . '?error=Failed to update product');
            }
        }
    }

    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // CSRF Validation
            if (!Session::validateCsrfToken($_POST['csrf_token'] ?? '')) {
                $this->redirect('/admin/products?error=Invalid CSRF token');
            }

            $productModel = $this->model('Product');
            $product = $productModel->getProductForEdit($id);

            if ($product) {
                // Physical images are no longer deleted here because they reside in the global Media Gallery.
                // productModel->delete() will cascade and remove product_images records.

                if ($productModel->delete($id)) {
                    $this->redirect('/admin/products?success=Product deleted');
                }
            }
        }
        $this->redirect('/admin/products?error=Delete failed');
    }

    public function apiSearch() {
        $query = $_GET['q'] ?? '';
        $productModel = $this->model('Product');
        $products = $productModel->search($query);
        
        header('Content-Type: application/json');
        echo json_encode($products);
        exit;
    }

    public function apiByCollection() {
        $collectionId = $_GET['collection_id'] ?? null;
        if (!$collectionId) {
            echo json_encode([]);
            exit;
        }
        $productModel = $this->model('Product');
        $products = $productModel->getByCollectionId($collectionId);
        
        header('Content-Type: application/json');
        echo json_encode($products);
        exit;
    }
}
