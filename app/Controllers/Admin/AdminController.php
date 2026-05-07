<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Session;

class AdminController extends Controller {
    
    public function __construct() {
        // Authenticate admin
        if (!Session::isAdminLoggedIn()) {
            Session::setFlash('error', 'Unauthorized access. Please login first.');
            $this->redirect('/admin/login');
            exit;
        }

        // Global CSRF Protection for admin POST requests
        $this->validateCsrf();
    }
}
