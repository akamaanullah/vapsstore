<?php
namespace App\Controllers\Admin;

class ReviewController extends AdminController {
    public function index() {
        $this->view('admin/reviews');
    }
}
