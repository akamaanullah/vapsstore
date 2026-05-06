<?php
namespace App\Controllers\Admin;

use App\Core\Session;

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
            // CSRF Validation
            if (!Session::validateCsrfToken($_POST['csrf_token'] ?? '')) {
                $this->redirect('/admin/collections/create?error=Invalid CSRF token');
            }

            $collectionModel = $this->model('Collection');
            
            $headerImage = null;
            if (!empty($_POST['header_image_url'])) {
                $headerImage = $_POST['header_image_url'];
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

            if ($id = $collectionModel->createCollection($data)) {
                // Sync UI Sections
                if (isset($_POST['sections'])) {
                    $uiModel = $this->model('UISection');
                    $uiModel->syncSections('collection', $id, $_POST['sections']);
                }
                $this->redirect('/admin/collections?success=Collection created successfully');
            } else {
                $this->redirect('/admin/collections/create?error=Failed to create collection');
            }
        }
    }

    public function edit($id = null) {
        if (!$id) $this->redirect('/admin/collections');
        
        $collectionModel = $this->model('Collection');
        $uiModel = $this->model('UISection');
        
        $collection = $collectionModel->find($id);
        $allCollections = $collectionModel->all();
        $sections = $uiModel->getSections('collection', $id);

        if (!$collection) $this->redirect('/admin/collections');

        $this->view('admin/edit-collection', [
            'collection' => $collection,
            'allCollections' => $allCollections,
            'sections' => $sections
        ]);
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // CSRF Validation
            if (!Session::validateCsrfToken($_POST['csrf_token'] ?? '')) {
                $this->redirect('/admin/collections/edit/' . $id . '?error=Invalid CSRF token');
            }

            $collectionModel = $this->model('Collection');
            $uiModel = $this->model('UISection');
            
            $headerImage = $_POST['existing_image'] ?? null;
            if (isset($_POST['header_image_url'])) {
                $headerImage = $_POST['header_image_url'];
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
                // Sync UI Sections
                if (isset($_POST['sections'])) {
                    $uiModel->syncSections('collection', $id, $_POST['sections']);
                }
                $this->redirect('/admin/collections?success=Collection updated successfully');
            } else {
                $this->redirect('/admin/collections/edit/' . $id . '?error=Failed to update collection');
            }
        }
    }

    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // CSRF Validation
            if (!Session::validateCsrfToken($_POST['csrf_token'] ?? '')) {
                $this->redirect('/admin/collections?error=Invalid CSRF token');
            }

            $collectionModel = $this->model('Collection');
            $collection = $collectionModel->find($id);

            if ($collection) {
                // No longer deleting physical image here as it's part of the global media gallery

                if ($collectionModel->delete($id)) {
                    $this->redirect('/admin/collections?success=Collection deleted');
                }
            }
        }
        $this->redirect('/admin/collections?error=Delete failed');
    }
}
