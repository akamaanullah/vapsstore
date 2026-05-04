<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Session;

class AdminController extends Controller {
    
    public function __construct() {
        // This constructor runs automatically before any child controller methods.
        // It acts as a strict Middleware for security.
        if (!Session::isAdminLoggedIn()) {
            Session::setFlash('error', 'Unauthorized access. Please login first.');
            $this->redirect('/admin/login');
            exit;
        }
    }
}
