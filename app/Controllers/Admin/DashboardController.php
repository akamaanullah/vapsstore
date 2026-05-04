<?php
namespace App\Controllers\Admin;

class DashboardController extends AdminController {
    
    public function index() {
        // Load the actual migrated admin dashboard template
        $this->view('admin/index');
    }
}
