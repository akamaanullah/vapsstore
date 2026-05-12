<?php
namespace App\Controllers\Front;

use App\Core\Controller;

class PageController extends Controller {
    
    public function show($slug = null, $filters = null) {
        if (!$slug) {
            $this->redirect('/');
            return;
        }

        $pageModel = $this->model('Page');

        // Find page by custom_url_path
        $db = \App\Core\Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM pages WHERE custom_url_path = ? AND is_active = 1 LIMIT 1");
        $stmt->execute([$slug]);
        $page = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$page) {
            $this->redirect('/');
            return;
        }

        // Get UI Sections for this page (section builder content)
        $uiModel = $this->model('UISection');
        $sections = $uiModel->getSections('page', $page['id']);

        $this->view('front/page', [
            'pageTitle' => ($page['meta_title'] ?: $page['title']) . ' | The Perfect Vape',
            'metaDescription' => $page['meta_desc'] ?? '',
            'page' => $page,
            'sections' => $sections
        ]);
    }
}
