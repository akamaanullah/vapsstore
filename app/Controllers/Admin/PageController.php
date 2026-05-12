<?php
namespace App\Controllers\Admin;

use App\Core\Session;

class PageController extends AdminController {
    public function index() {
        $pageModel = $this->model('Page');
        $pages = $pageModel->getAllPages();
        $this->view('admin/pages', ['pages' => $pages]);
    }

    public function create() {
        $this->view('admin/create-page');
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Session::validateCsrfToken($_POST['csrf_token'] ?? '')) {
                $this->redirect($_SERVER['HTTP_REFERER'] ?? '/admin');
            }

            $pageModel = $this->model('Page');
            $data = [
                'title' => $_POST['title'],
                'custom_url_path' => $_POST['custom_url_path'],
                'meta_title' => $_POST['meta_title'],
                'meta_desc' => $_POST['meta_desc'],
                'is_active' => isset($_POST['status']) && $_POST['status'] === 'active' ? 1 : 0
            ];

            if ($id = $pageModel->createPage($data)) {
                // Sync UI Sections
                if (isset($_POST['sections'])) {
                    $uiModel = $this->model('UISection');
                    $uiModel->syncSections('page', $id, $_POST['sections']);
                }
                $this->redirect('/admin/pages?success=Page created successfully');
            } else {
                $this->redirect('/admin/pages/create?error=Failed to create page');
            }
        }
    }

    public function edit($id = null) {
        if (!$id) $this->redirect('/admin/pages');
        
        $pageModel = $this->model('Page');
        $page = $pageModel->getPageById($id);
        
        if (!$page) $this->redirect('/admin/pages');

        // Fetch UI Sections
        $uiModel = $this->model('UISection');
        $sections = $uiModel->getSections('page', $id);
        
        $this->view('admin/edit-page', [
            'page' => $page,
            'sections' => $sections
        ]);
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Session::validateCsrfToken($_POST['csrf_token'] ?? '')) {
                $this->redirect($_SERVER['HTTP_REFERER'] ?? '/admin');
            }

            $pageModel = $this->model('Page');
            $data = [
                'title' => $_POST['title'],
                'custom_url_path' => $_POST['custom_url_path'],
                'meta_title' => $_POST['meta_title'],
                'meta_desc' => $_POST['meta_desc'],
                'is_active' => isset($_POST['status']) && $_POST['status'] === 'active' ? 1 : 0
            ];

            if ($pageModel->updatePage($id, $data)) {
                // Sync UI Sections
                if (isset($_POST['sections'])) {
                    $uiModel = $this->model('UISection');
                    $uiModel->syncSections('page', $id, $_POST['sections']);
                }
                $this->redirect('/admin/pages?success=Page updated successfully');
            } else {
                $this->redirect('/admin/pages/edit/' . $id . '?error=Failed to update page');
            }
        }
    }

    public function delete($id) {
        $pageModel = $this->model('Page');
        if ($pageModel->delete($id)) {
            $this->redirect('/admin/pages?success=Page deleted successfully');
        } else {
            $this->redirect('/admin/pages?error=Failed to delete page');
        }
    }
}
