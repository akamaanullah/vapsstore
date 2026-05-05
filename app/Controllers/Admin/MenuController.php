<?php
namespace App\Controllers\Admin;

class MenuController extends AdminController {
    public function index() {
        $menuModel = new \App\Models\Menu();
        $menus = $menuModel->all();
        $this->view('admin/menus', ['menus' => $menus]);
    }

    public function edit($id) {
        $menuModel = new \App\Models\Menu();
        $itemModel = new \App\Models\MenuItem();
        
        $menu = $menuModel->find($id);
        if (!$menu) {
            header('Location: ' . BASE_URL . '/admin/menus');
            exit;
        }

        $items = $itemModel->getTree($id);
        $this->view('admin/edit-menu', [
            'menu' => $menu,
            'items' => $items
        ]);
    }

    public function store() {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (empty($data['name']) || empty($data['location'])) {
            echo json_encode(['success' => false, 'message' => 'Missing name or location']);
            return;
        }

        $menuModel = new \App\Models\Menu();
        
        // Check if location exists
        $exists = $menuModel->getByLocation($data['location']);
        if ($exists) {
            echo json_encode(['success' => false, 'message' => 'Location handle already in use']);
            return;
        }

        $id = $menuModel->create($data);
        if ($id) {
            // Re-fetch the ID (Model::create should ideally return ID)
            $newMenu = $menuModel->getByLocation($data['location']);
            echo json_encode(['success' => true, 'id' => $newMenu['id']]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error']);
        }
    }

    public function update($id) {
        header('Content-Type: application/json');
        $data = json_decode(file_get_contents('php://input'), true);
        $items = $data['items'] ?? [];

        $itemModel = new \App\Models\MenuItem();
        
        // Clear existing items and re-sync
        $itemModel->clearMenu($id);
        $this->saveItemsRecursive($items, $id);

        echo json_encode(['success' => true]);
    }

    private function saveItemsRecursive($items, $menuId, $parentId = null) {
        $itemModel = new \App\Models\MenuItem();
        foreach ($items as $index => $item) {
            $itemData = [
                'menu_id' => (int)$menuId,
                'parent_id' => $parentId,
                'title' => $item['title'],
                'link_type' => $item['link_type'],
                'link_value' => $item['link_value'],
                'image_url' => !empty($item['image_url']) ? $item['image_url'] : null,
                'sort_order' => (int)$index
            ];
            
            // Insert item
            $itemModel->add($itemData);
            
            // Get last inserted ID for children
            $db = \App\Core\Database::getInstance();
            $lastId = $db->getConnection()->lastInsertId();

            if (!empty($item['children'])) {
                $this->saveItemsRecursive($item['children'], $menuId, $lastId);
            }
        }
    }

    public function search() {
        header('Content-Type: application/json');
        $query = $_GET['q'] ?? '';
        $type = $_GET['type'] ?? 'collection';
        $results = [];

        if (empty($query) && $query !== 'all') {
            echo json_encode([]);
            return;
        }

        switch ($type) {
            case 'collection':
                $model = new \App\Models\Collection();
                $items = $model->search($query);
                foreach ($items as $item) {
                    $results[] = [
                        'title' => $item['name'],
                        'url' => '/collections/' . ($item['custom_url_path'] ?? '')
                    ];
                }
                if ($query === 'all' || strpos(strtolower('all collections'), strtolower($query)) !== false) {
                    array_unshift($results, ['title' => 'All Collections', 'url' => '/collections']);
                }
                break;
            case 'brand':
                $model = new \App\Models\Brand();
                $items = $model->search($query);
                foreach ($items as $item) {
                    $results[] = [
                        'title' => $item['name'],
                        'url' => '/brands/' . ($item['slug'] ?? '')
                    ];
                }
                if ($query === 'all' || strpos(strtolower('all brands'), strtolower($query)) !== false) {
                    array_unshift($results, ['title' => 'All Brands', 'url' => '/brands']);
                }
                break;
            case 'page':
                $model = new \App\Models\Page();
                $items = $model->search($query);
                foreach ($items as $item) {
                    $results[] = [
                        'title' => $item['title'],
                        'url' => '/pages/' . ($item['custom_url_path'] ?? '')
                    ];
                }
                break;
        }

        echo json_encode($results);
    }

    public function delete($id) {
        header('Content-Type: application/json');
        
        $menuModel = new \App\Models\Menu();
        $itemModel = new \App\Models\MenuItem();
        
        // 1. Delete all items first
        $itemModel->clearMenu($id);
        
        // 2. Delete the menu itself
        $success = $menuModel->delete($id);
        
        if ($success) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error']);
        }
    }
}
