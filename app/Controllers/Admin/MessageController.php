<?php
namespace App\Controllers\Admin;

class MessageController extends AdminController {
    public function index() {
        $this->view('admin/messages');
    }
}
