<?php
namespace App\Controllers\Admin;

class MessageController extends AdminController {
    public function index() {
        include __DIR__ . '/../../../views/admin/messages.php';
    }
}
