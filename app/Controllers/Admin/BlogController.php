<?php
namespace App\Controllers\Admin;

class BlogController extends AdminController {
    public function index() {
        $this->view('admin/blogs');
    }

    public function create() {
        $this->view('admin/add-blog');
    }

    public function categories() {
        $this->view('admin/blog-categories');
    }

    public function edit($id = null) {
        $this->view('admin/edit-blog');
    }
}
