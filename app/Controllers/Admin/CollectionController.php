<?php
namespace App\Controllers\Admin;

class CollectionController extends AdminController {
    
    public function index() {
        $collectionModel = $this->model('Collection');
        $collections = $collectionModel->getAllWithParent();
        $this->view('admin/collections', ['collections' => $collections]);
    }

    public function create() {
        $collectionModel = $this->model('Collection');
        $allCollections = $collectionModel->all();
        $this->view('admin/add-collection', ['allCollections' => $allCollections]);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $collectionModel = $this->model('Collection');
            
            $headerImage = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = ROOT_DIR . '/public/uploads/collections/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                
                $fileName = time() . '_' . $_FILES['image']['name'];
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $fileName)) {
                    $headerImage = 'uploads/collections/' . $fileName;
                }
            }

            $data = [
                'name' => $_POST['name'],
                'parent_id' => $_POST['parent_id'],
                'short_description' => $_POST['description'] ?? '',
                'custom_url_path' => $_POST['custom_url'] ?? null,
                'header_image_url' => $headerImage,
                'meta_title' => $_POST['seo_title'] ?? null,
                'meta_desc' => $_POST['seo_description'] ?? null,
                'is_active' => isset($_POST['status']) && $_POST['status'] === 'active' ? 1 : 0
            ];

            if ($collectionModel->createCollection($data)) {
                $this->redirect('/admin/collections?success=Collection created successfully');
            } else {
                $this->redirect('/admin/collections/create?error=Failed to create collection');
            }
        }
    }

    public function edit($id = null) {
        if (!$id) $this->redirect('/admin/collections');
        
        $collectionModel = $this->model('Collection');
        $collection = $collectionModel->find($id);
        $allCollections = $collectionModel->all();

        if (!$collection) $this->redirect('/admin/collections');

        $this->view('admin/edit-collection', [
            'collection' => $collection,
            'allCollections' => $allCollections
        ]);
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $collectionModel = $this->model('Collection');
            
            $headerImage = $_POST['existing_image'] ?? null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = ROOT_DIR . '/public/uploads/collections/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
                
                $fileName = time() . '_' . $_FILES['image']['name'];
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $fileName)) {
                    $headerImage = 'uploads/collections/' . $fileName;
                }
            }

            $data = [
                'name' => $_POST['name'],
                'parent_id' => $_POST['parent_id'],
                'short_description' => $_POST['description'] ?? '',
                'custom_url_path' => $_POST['custom_url'] ?? null,
                'header_image_url' => $headerImage,
                'meta_title' => $_POST['seo_title'] ?? null,
                'meta_desc' => $_POST['seo_description'] ?? null,
                'is_active' => isset($_POST['status']) && $_POST['status'] === 'active' ? 1 : 0
            ];

            if ($collectionModel->updateCollection($id, $data)) {
                $this->redirect('/admin/collections?success=Collection updated successfully');
            } else {
                $this->redirect('/admin/collections/edit/' . $id . '?error=Failed to update collection');
            }
        }
    }

    public function delete($id) {
        $collectionModel = $this->model('Collection');
        if ($collectionModel->delete($id)) {
            $this->redirect('/admin/collections?success=Collection deleted');
        } else {
            $this->redirect('/admin/collections?error=Delete failed');
        }
    }
}
