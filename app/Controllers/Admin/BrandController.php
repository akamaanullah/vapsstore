<?php
namespace App\Controllers\Admin;

use App\Core\Session;

class BrandController extends AdminController {
    public function index() {
        $brandModel = $this->model('Brand');
        $brands = $brandModel->getAllBrands();
        $this->view('admin/brands', ['brands' => $brands]);
    }

    public function create() {
        $this->view('admin/create-brand');
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Session::validateCsrfToken($_POST['csrf_token'] ?? '');

            $brandModel = $this->model('Brand');
            $data = [
                'name' => $_POST['name'],
                'slug' => $_POST['slug'] ?: strtolower(str_replace(' ', '-', $_POST['name'])),
                'is_active' => isset($_POST['status']) && $_POST['status'] === 'active' ? 1 : 0
            ];

            // Image handling (Placeholder for now, similar to collections)
            if (isset($_FILES['logo']) && $_FILES['logo']['error'] === 0) {
                $targetDir = "uploads/brands/";
                if (!file_exists($targetDir)) mkdir($targetDir, 0777, true);
                
                $fileName = time() . '_' . basename($_FILES['logo']['name']);
                $targetFile = $targetDir . $fileName;
                
                if (move_uploaded_file($_FILES['logo']['tmp_name'], $targetFile)) {
                    $data['logo_url'] = $targetFile;
                }
            }

            if ($brandModel->createBrand($data)) {
                $this->redirect('/admin/brands?success=Brand created successfully');
            } else {
                $this->redirect('/admin/brands/create?error=Failed to create brand');
            }
        }
    }

    public function edit($id = null) {
        if (!$id) $this->redirect('/admin/brands');
        
        $brandModel = $this->model('Brand');
        $brand = $brandModel->getBrandById($id);
        
        if (!$brand) $this->redirect('/admin/brands');
        
        $this->view('admin/edit-brand', ['brand' => $brand]);
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Session::validateCsrfToken($_POST['csrf_token'] ?? '');

            $brandModel = $this->model('Brand');
            $brand = $brandModel->getBrandById($id);
            
            $data = [
                'name' => $_POST['name'],
                'slug' => $_POST['slug'],
                'logo_url' => $brand['logo_url'],
                'is_active' => isset($_POST['status']) && $_POST['status'] === 'active' ? 1 : 0
            ];

            if (isset($_FILES['logo']) && $_FILES['logo']['error'] === 0) {
                $targetDir = "uploads/brands/";
                if (!file_exists($targetDir)) mkdir($targetDir, 0777, true);
                $fileName = time() . '_' . basename($_FILES['logo']['name']);
                $targetFile = $targetDir . $fileName;
                if (move_uploaded_file($_FILES['logo']['tmp_name'], $targetFile)) {
                    $data['logo_url'] = $targetFile;
                }
            }

            if ($brandModel->updateBrand($id, $data)) {
                $this->redirect('/admin/brands?success=Brand updated successfully');
            } else {
                $this->redirect('/admin/brands/edit/' . $id . '?error=Failed to update brand');
            }
        }
    }

    public function delete($id) {
        $brandModel = $this->model('Brand');
        if ($brandModel->deleteBrand($id)) {
            $this->redirect('/admin/brands?success=Brand deleted successfully');
        } else {
            $this->redirect('/admin/brands?error=Failed to delete brand');
        }
    }
}
