<?php
namespace App\Controllers\Admin;

class ProductController extends AdminController {
    
    public function index() {
        $productModel = $this->model('Product');
        $products = $productModel->getAdminList();
        $this->view('admin/products', ['products' => $products]);
    }

    public function create() {
        $brandModel = $this->model('Brand');
        $collectionModel = $this->model('Collection');
        
        $brands = $brandModel->all();
        $collections = $collectionModel->all();

        $this->view('admin/add-product', [
            'brands' => $brands,
            'collections' => $collections
        ]);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productModel = $this->model('Product');
            
            $data = [
                'name' => $_POST['name'],
                'base_price' => $_POST['price'],
                'status' => $_POST['status'],
                'custom_url' => $_POST['custom_url'] ?? null,
                'description' => $_POST['description'] ?? '',
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
                // Handle Image Uploads
                if (!empty($_FILES['images']['name'][0])) {
                    $uploadDir = ROOT_DIR . '/public/uploads/products/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }

                    foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
                        $fileName = time() . '_' . $_FILES['images']['name'][$key];
                        $targetPath = $uploadDir . $fileName;

                        if (move_uploaded_file($tmpName, $targetPath)) {
                            $imageUrl = 'uploads/products/' . $fileName;
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
                'seo_description' => $_POST['seo_description'] ?? null
            ];

            if ($productModel->updateProduct($id, $data)) {
                // Sync collections
                $productModel->syncCollections($id, $_POST['collection_ids'] ?? []);

                // Handle new image uploads
                if (!empty($_FILES['images']['name'][0])) {
                    $uploadDir = ROOT_DIR . '/public/uploads/products/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0777, true);
                    }
                    foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
                        $fileName = time() . '_' . $_FILES['images']['name'][$key];
                        $targetPath = $uploadDir . $fileName;
                        if (move_uploaded_file($tmpName, $targetPath)) {
                            $imageUrl = 'uploads/products/' . $fileName;
                            $productModel->addImage($id, $imageUrl, $key);
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
        $productModel = $this->model('Product');
        if ($productModel->delete($id)) {
            $this->redirect('/admin/products?success=Product deleted');
        } else {
            $this->redirect('/admin/products?error=Delete failed');
        }
    }
}
