<?php
namespace App\Controllers\Front;

use App\Core\Controller;
use App\Core\Session;

class AccountController extends Controller {
    
    public function __construct() {
        // Ensure user is logged in for all account methods
        if (!Session::get('user_id')) {
            $this->redirect('/login');
            exit;
        }
    }

    public function index() {
        $userModel = $this->model('User');
        $user = $userModel->findByEmail(Session::get('user_email'));

        $orderModel = $this->model('Order');
        $recentOrders = array_slice($orderModel->getByUser(Session::get('user_id')), 0, 3);

        $this->view('front/account/dashboard', [
            'pageTitle' => 'Account Dashboard | The Perfect Vape',
            'user' => $user,
            'recentOrders' => $recentOrders,
            'defaultAddress' => $this->model('UserAddress')->getDefault(Session::get('user_id')),
            'activeTab' => 'dashboard'
        ]);
    }

    public function addresses() {
        $addressModel = $this->model('UserAddress');
        $addresses = $addressModel->getByUser(Session::get('user_id'));

        $this->view('front/account/addresses', [
            'pageTitle' => 'Manage Addresses | The Perfect Vape',
            'addresses' => $addresses,
            'activeTab' => 'addresses'
        ]);
    }

    public function addAddress() {
        $this->validateCsrf();

        $addressModel = $this->model('UserAddress');
        $data = [
            'user_id' => Session::get('user_id'),
            'first_name' => strip_tags(trim($_POST['first_name'] ?? '')),
            'last_name' => strip_tags(trim($_POST['last_name'] ?? '')),
            'phone' => strip_tags(trim($_POST['phone'] ?? '')),
            'street' => strip_tags(trim($_POST['street'] ?? '')),
            'city' => strip_tags(trim($_POST['city'] ?? '')),
            'state' => strip_tags(trim($_POST['state'] ?? '')),
            'zip' => strip_tags(trim($_POST['zip'] ?? '')),
            'country' => strip_tags(trim($_POST['country'] ?? 'United Kingdom')),
            'is_default' => isset($_POST['is_default']) ? 1 : 0
        ];

        if ($data['is_default']) {
            // Logic to unset other defaults is inside setDefault or similar
            // But here we are creating. If is_default is 1, we should unset others first.
            if ($data['is_default']) {
                $addressModel->setDefault(0, $data['user_id']); // This unsets all
            }
        }

        if ($addressModel->create($data)) {
            $this->jsonResponse(['success' => true, 'message' => 'Address added successfully!']);
        } else {
            $this->jsonResponse(['success' => false, 'message' => 'Failed to add address.'], 500);
        }
    }

    public function deleteAddress() {
        $id = $_POST['id'] ?? null;
        if ($id) {
            $addressModel = $this->model('UserAddress');
            if ($addressModel->delete($id, Session::get('user_id'))) {
                $this->jsonResponse(['success' => true, 'message' => 'Address deleted successfully!']);
                return;
            }
        }
        $this->jsonResponse(['success' => false, 'message' => 'Failed to delete address.'], 500);
    }

    public function setDefaultAddress() {
        $id = $_POST['id'] ?? null;
        if ($id) {
            $addressModel = $this->model('UserAddress');
            if ($addressModel->setDefault($id, Session::get('user_id'))) {
                $this->jsonResponse(['success' => true, 'message' => 'Default address updated!']);
                return;
            }
        }
        $this->jsonResponse(['success' => false, 'message' => 'Failed to update default address.'], 500);
    }

    public function orders() {
        $orderModel = $this->model('Order');
        $orders = $orderModel->getByUser(Session::get('user_id'));

        $this->view('front/account/orders', [
            'pageTitle' => 'My Orders | The Perfect Vape',
            'orders' => $orders,
            'userEmail' => Session::get('user_email'),
            'activeTab' => 'orders'
        ]);
    }

    public function profile() {
        $userModel = $this->model('User');
        $user = $userModel->findByEmail(Session::get('user_email'));

        $this->view('front/account/profile', [
            'pageTitle' => 'Profile Settings | The Perfect Vape',
            'user' => $user,
            'activeTab' => 'profile'
        ]);
    }

    public function updateProfile() {
        $this->validateCsrf();

        $fname = strip_tags(trim($_POST['fname'] ?? ''));
        $lname = strip_tags(trim($_POST['lname'] ?? ''));
        $password = $_POST['new_password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';

        if (!$fname || !$lname) {
            $this->jsonResponse(['success' => false, 'message' => 'First name and Last name are required.'], 400);
            return;
        }

        $updateData = [
            'id' => Session::get('user_id'),
            'first_name' => $fname,
            'last_name' => $lname
        ];

        if (!empty($password)) {
            if (strlen($password) < 6) {
                $this->jsonResponse(['success' => false, 'message' => 'Password must be at least 6 characters.'], 400);
                return;
            }
            if ($password !== $confirm) {
                $this->jsonResponse(['success' => false, 'message' => 'Passwords do not match.'], 400);
                return;
            }
            $updateData['password_hash'] = password_hash($password, PASSWORD_BCRYPT);
        }

        // Logic to update user in DB would go here. 
        // Let's ensure User model has an update method.
        $userModel = $this->model('User');
        if ($userModel->update($updateData)) {
            Session::set('user_name', $fname . ' ' . $lname);
            $this->jsonResponse(['success' => true, 'message' => 'Profile updated successfully!']);
        } else {
            $this->jsonResponse(['success' => false, 'message' => 'Failed to update profile.'], 500);
        }
    }
}
