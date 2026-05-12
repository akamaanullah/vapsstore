<?php
namespace App\Controllers\Admin;

use App\Models\UISection;

class ThemeController extends AdminController {
    public function index() {
        $uiModel = new UISection();
        $sections = array_filter($uiModel->getGlobalSections('global_home'), function($s) {
            return $s['type'] !== 'starter_cta';
        });
        $sections = array_values($sections); // Reset indices
        
        $collectionModel = $this->model('Collection');
        $collections = $collectionModel->all();

        $this->view('admin/theme', [
            'sections' => $sections,
            'collections' => $collections
        ]);
    }

    public function update() {
        try {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            
            if (!$data || !isset($data['sections'])) {
                throw new \Exception("Invalid data received.");
            }

            // CSRF Validation
            if (!\App\Core\Session::validateCsrfToken($data['csrf_token'] ?? '')) {
                throw new \Exception("Invalid CSRF token.");
            }

            $uiModel = new UISection();
            $success = $uiModel->syncSections('global_home', null, $data['sections']);

            header('Content-Type: application/json');
            echo json_encode([
                'success' => $success,
                'message' => $success ? 'Homepage updated successfully' : 'Failed to update database'
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
