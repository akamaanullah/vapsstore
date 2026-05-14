<?php
namespace App\Controllers\Front;

use App\Core\Controller;
use App\Core\Session;

class AuthController extends Controller {
    
    public function login() {
        $this->validateCsrf();

        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'] ?? '';

        if (!$email || !$password) {
            $this->jsonResponse(['success' => false, 'message' => 'Please provide both email and password.'], 400);
            return;
        }

        $userModel = $this->model('User');
        $user = $userModel->authenticate($email, $password);

        if ($user) {
            // Set session data
            Session::set('user_id', $user['id']);
            Session::set('user_email', $user['email']);
            Session::set('user_name', $user['first_name'] . ' ' . $user['last_name']);
            Session::set('user_role', $user['role']);
            
            // Merge session wishlist to DB
            $this->mergeWishlist($user['id']);

            $this->jsonResponse([
                'success' => true,
                'message' => 'Welcome back, ' . $user['first_name'] . '!',
                'redirect' => BASE_URL . '/'
            ]);
        } else {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid email or password.'], 401);
        }
    }

    public function signup() {
        $this->validateCsrf();

        $fname = strip_tags(trim($_POST['fname'] ?? ''));
        $lname = strip_tags(trim($_POST['lname'] ?? ''));
        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        if (!$fname || !$lname || !$email || !$password) {
            $this->jsonResponse(['success' => false, 'message' => 'All fields are required.'], 400);
            return;
        }

        if ($password !== $confirm) {
            $this->jsonResponse(['success' => false, 'message' => 'Passwords do not match.'], 400);
            return;
        }

        if (strlen($password) < 6) {
            $this->jsonResponse(['success' => false, 'message' => 'Password must be at least 6 characters long.'], 400);
            return;
        }

        $userModel = $this->model('User');
        
        // Check if user exists
        if ($userModel->findByEmail($email)) {
            $this->jsonResponse(['success' => false, 'message' => 'An account with this email already exists.'], 409);
            return;
        }

        $userId = $userModel->create([
            'first_name' => $fname,
            'last_name' => $lname,
            'email' => $email,
            'password' => $password
        ]);

        if ($userId) {
            // Auto-login after signup
            Session::set('user_id', $userId);
            Session::set('user_email', $email);
            Session::set('user_name', $fname . ' ' . $lname);
            Session::set('user_role', 'customer');

            // Merge session wishlist to DB
            $this->mergeWishlist($userId);

            $this->jsonResponse([
                'success' => true,
                'message' => 'Account created successfully! Welcome aboard.',
                'redirect' => BASE_URL . '/'
            ]);
        } else {
            $this->jsonResponse(['success' => false, 'message' => 'Failed to create account. Please try again later.'], 500);
        }
    }

    private function mergeWishlist($userId) {
        $sessionWishlist = Session::get('wishlist') ?: [];
        if (!empty($sessionWishlist)) {
            $wishlistModel = $this->model('Wishlist');
            foreach ($sessionWishlist as $productId) {
                $wishlistModel->add($userId, (int)$productId);
            }
            Session::set('wishlist', []);
        }
    }

    public function logout() {
        Session::destroy();
        $this->redirect('/');
    }
}
