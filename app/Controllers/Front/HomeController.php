<?php
namespace App\Controllers\Front;

use App\Core\Controller;

class HomeController extends Controller {
    public function index() {
        // For now, load the legacy homepage
        require_once ROOT_DIR . '/index.php';
    }
}
