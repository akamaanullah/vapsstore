<?php
namespace App\Controllers\Admin;

use App\Models\Setting;

class SettingController extends AdminController {
    public function index() {
        $settingModel = new Setting();
        $settings = $settingModel->all();
        $this->view('admin/settings', ['settings' => $settings]);
    }

    public function update() {
        try {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            
            if (!$data) {
                throw new \Exception("Invalid data received.");
            }

            // CSRF Validation
            if (!\App\Core\Session::validateCsrfToken($data['csrf_token'] ?? '')) {
                throw new \Exception("Invalid CSRF token.");
            }

            $settingModel = new Setting();
            $success = $settingModel->updateMultiple($data);

            header('Content-Type: application/json');
            echo json_encode([
                'success' => $success,
                'message' => $success ? 'Settings updated successfully' : 'Failed to update database'
            ]);
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode([
                'success' => false, 
                'message' => $e->getMessage()
            ]);
        }
    }
}
