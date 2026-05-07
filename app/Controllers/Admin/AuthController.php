<?php
namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Session;

class AuthController extends Controller {
    
    public function showLoginForm() {
        // If already logged in, redirect to dashboard
        if (Session::isAdminLoggedIn()) {
            $this->redirect('/admin');
        }

        $flash = Session::getFlash();
        // We will pass the flash message to the view
        $this->view('admin/login', ['flash' => $flash]);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCsrf();
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                Session::setFlash('error', 'Please fill in all fields.');
                $this->redirect('/admin/login');
            }

            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("SELECT * FROM users WHERE email = ? AND role = 'admin' LIMIT 1");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            // Verify password using password_verify
            if ($user && password_verify($password, $user['password_hash'])) {
                // Secure login
                session_regenerate_id(true); // Prevent session fixation
                Session::set('is_logged_in', true);
                Session::set('user_id', $user['id']);
                Session::set('user_role', $user['role']);
                Session::set('user_name', $user['first_name'] . ' ' . $user['last_name']);
                Session::set('user_email', $user['email']);

                $this->redirect('/admin');
            } else {
                Session::setFlash('error', 'Invalid email or password, or unauthorized access.');
                $this->redirect('/admin/login');
            }
        }
    }

    public function logout() {
        Session::destroy();
        $this->redirect('/admin/login');
    }
}
