<?php
namespace App\Controllers\Admin;

use App\Core\Session;
use App\Helpers\ImageHelper;

class MediaController extends AdminController {
    
    public function index() {
        $mediaModel = $this->model('Media');
        $media = $mediaModel->getAll(100); // Get last 100 items for now
        $this->view('admin/media', ['media' => $media]);
    }

    public function upload() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_FILES['files'])) {
            $mediaModel = $this->model('Media');
            $uploadDir = ROOT_DIR . '/public/uploads/media/';
            
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $results = [];
            foreach ($_FILES['files']['tmp_name'] as $key => $tmpName) {
                if ($_FILES['files']['error'][$key] !== UPLOAD_ERR_OK) continue;

                $originalName = $_FILES['files']['name'][$key];
                $nameWithoutExt = pathinfo($originalName, PATHINFO_FILENAME);
                $cleanName = time() . '_' . preg_replace('/[^A-Za-z0-9_-]/', '', $nameWithoutExt);
                $newFilename = $cleanName . '.webp';
                $targetPath = $uploadDir . $newFilename;

                // Convert to WebP using Helper
                if (ImageHelper::convertToWebP($tmpName, $targetPath, 80)) {
                    // Create Thumbnail
                    $thumbDir = $uploadDir . 'thumbs/';
                    if (!is_dir($thumbDir)) mkdir($thumbDir, 0777, true);
                    ImageHelper::createThumbnail($targetPath, $thumbDir . $newFilename, 150, 150);

                    // Save to DB
                    $fileSize = filesize($targetPath);
                    $info = getimagesize($targetPath);
                    $dimensions = $info[0] . 'x' . $info[1];

                    $mediaModel->create([
                        'filename' => $newFilename,
                        'original_name' => $originalName,
                        'file_path' => 'uploads/media/' . $newFilename,
                        'file_type' => 'image/webp',
                        'file_size' => $fileSize,
                        'dimensions' => $dimensions
                    ]);
                    $results[] = ['success' => true, 'name' => $originalName];
                } else {
                    $results[] = ['success' => false, 'name' => $originalName];
                }
            }

            header('Content-Type: application/json');
            echo json_encode(['results' => $results]);
            exit;
        }
    }

    public function delete($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $mediaModel = $this->model('Media');
            $item = $mediaModel->find($id);
            if ($item) {
                $filePath = ROOT_DIR . '/public/' . $item['file_path'];
                $thumbPath = ROOT_DIR . '/public/uploads/media/thumbs/' . $item['filename'];
                
                if (file_exists($filePath)) @unlink($filePath);
                if (file_exists($thumbPath)) @unlink($thumbPath);
                
                $mediaModel->delete($id);
            }
            header('Content-Type: application/json');
            echo json_encode(['success' => true]);
            exit;
        }
    }

    public function apiSearch() {
        $q = $_GET['q'] ?? '';
        $mediaModel = $this->model('Media');
        $results = $mediaModel->search($q);
        header('Content-Type: application/json');
        echo json_encode($results);
        exit;
    }
}
