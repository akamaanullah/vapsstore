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
        $page = $_GET['page'] ?? 1;
        $perPage = $_GET['per_page'] ?? 10;
        $search = $_GET['search'] ?? '';
        $status = $_GET['status'] ?? '';
        
        $productModel = $this->model('Product');
        $pagination = $productModel->getAdminList($page, $perPage, [
            'search' => $search,
            'status' => $status
        ]);

        $data = [
            'products' => $pagination['data'],
            'pagination' => $pagination,
            'filters' => [
                'search' => $search,
                'status' => $status
            ]
        ];
        
        // Detect AJAX request
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $this->view('admin/partials/products-table', $data);
            return;
        }

        $this->view('admin/products', $data);
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
            
            // Basic Validation
            if (empty($_POST['name']) || empty($_POST['price'])) {
                $this->redirect('/admin/products/create?error=Product name and price are required');
            }

            $data = [
                'name' => trim($_POST['name']),
                'base_price' => (float)$_POST['price'],
                'status' => $_POST['status'] ?? 'draft',
                'custom_url' => $_POST['custom_url'] ?? null,
                'short_desc' => $_POST['short_desc'] ?? null,
                'long_desc' => $_POST['description'] ?? '',
                'stock' => (int)($_POST['stock'] ?? 0),
                'sku' => $_POST['sku'] ?? null,
                'brand_id' => !empty($_POST['brand_id']) ? $_POST['brand_id'] : null,
                'collection_ids' => $_POST['collection_ids'] ?? [],
                'variants' => $_POST['variants'] ?? [],
                'tags' => $_POST['tags'] ?? '',
                'seo_description' => $_POST['seo_description'] ?? null,
                'option_names' => $_POST['option_names'] ?? []
            ];

            $productId = $productModel->createProduct($data);

            if ($productId) {
                // Unified Image Sync (Preserving order from DOM)
                $allImages = $_POST['product_images'] ?? [];
                $productModel->syncAllImages($productId, $allImages);

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

            // Basic Validation
            if (empty($_POST['name']) || empty($_POST['price'])) {
                $this->redirect('/admin/products/edit/' . $id . '?error=Product name and price are required');
            }

            $data = [
                'name' => trim($_POST['name']),
                'base_price' => (float)$_POST['price'],
                'status' => $_POST['status'] ?? 'draft',
                'custom_url' => $_POST['custom_url'] ?? null,
                'short_desc' => $_POST['short_desc'] ?? null,
                'long_desc' => $_POST['description'] ?? '',
                'brand_id' => !empty($_POST['brand_id']) ? $_POST['brand_id'] : null,
                'tags' => $_POST['tags'] ?? '',
                'seo_title' => $_POST['seo_title'] ?? null,
                'seo_description' => $_POST['seo_description'] ?? null,
                'collection_ids' => $_POST['collection_ids'] ?? [],
                'variants' => $_POST['variants'] ?? [],
                'option_names' => $_POST['option_names'] ?? []
            ];

            if ($productModel->updateProduct($id, $data)) {
                // Unified Image Sync (Preserving order from DOM)
                $allImages = $_POST['product_images'] ?? [];
                $productModel->syncAllImages($id, $allImages);

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
