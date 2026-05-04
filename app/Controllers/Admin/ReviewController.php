<?php
namespace App\Controllers\Admin;

class ReviewController extends AdminController {
    public function index() {
        include __DIR__ . '/../../../views/admin/reviews.php';
    }
}
