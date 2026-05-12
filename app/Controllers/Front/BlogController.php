<?php
namespace App\Controllers\Front;

use App\Core\Controller;
use PDO;

class BlogController extends Controller {
    
    public function index() {
        $blogModel = new \App\Models\BlogPost();
        
        // Get active posts with category info
        $db = \App\Core\Database::getInstance()->getConnection();
        $stmt = $db->query("
            SELECT b.*, c.name as category_name, c.slug as category_slug
            FROM blog_posts b 
            LEFT JOIN blog_categories c ON b.category_id = c.id 
            WHERE b.is_active = 1
            ORDER BY b.published_at DESC
        ");
        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Get categories with post counts (active posts only)
        $catStmt = $db->query("
            SELECT c.*, COUNT(b.id) as post_count 
            FROM blog_categories c 
            LEFT JOIN blog_posts b ON c.id = b.category_id AND b.is_active = 1
            GROUP BY c.id
            HAVING post_count > 0
            ORDER BY c.name ASC
        ");
        $categories = $catStmt->fetchAll(PDO::FETCH_ASSOC);

        $this->view('front/blog', [
            'pageTitle' => 'Vape Insights & News | The Perfect Vape',
            'posts' => $posts,
            'categories' => $categories
        ]);
    }

    public function show($slug = null, $filters = null) {
        if (!$slug) {
            $this->redirect('/blog');
            return;
        }

        $db = \App\Core\Database::getInstance()->getConnection();

        // Find post by slug
        $stmt = $db->prepare("
            SELECT b.*, c.name as category_name, c.slug as category_slug
            FROM blog_posts b 
            LEFT JOIN blog_categories c ON b.category_id = c.id 
            WHERE b.custom_url_path = ? AND b.is_active = 1 
            LIMIT 1
        ");
        $stmt->execute([$slug]);
        $post = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$post) {
            $this->redirect('/blog');
            return;
        }

        // Get UI Sections for this blog post (section builder content)
        $uiModel = $this->model('UISection');
        $sections = $uiModel->getSections('blog', $post['id']);

        // Get recent posts (exclude current)
        $recentStmt = $db->prepare("
            SELECT b.*, c.name as category_name 
            FROM blog_posts b 
            LEFT JOIN blog_categories c ON b.category_id = c.id 
            WHERE b.is_active = 1 AND b.id != ?
            ORDER BY b.published_at DESC 
            LIMIT 3
        ");
        $recentStmt->execute([$post['id']]);
        $recentPosts = $recentStmt->fetchAll(PDO::FETCH_ASSOC);

        // Get categories for sidebar
        $catStmt = $db->query("
            SELECT c.*, COUNT(b.id) as post_count 
            FROM blog_categories c 
            LEFT JOIN blog_posts b ON c.id = b.category_id AND b.is_active = 1
            GROUP BY c.id
            HAVING post_count > 0
        ");
        $categories = $catStmt->fetchAll(PDO::FETCH_ASSOC);

        // Get related posts (same category, exclude current)
        $relatedPosts = [];
        if (!empty($post['category_id'])) {
            $relStmt = $db->prepare("
                SELECT b.*, c.name as category_name 
                FROM blog_posts b 
                LEFT JOIN blog_categories c ON b.category_id = c.id 
                WHERE b.is_active = 1 AND b.category_id = ? AND b.id != ?
                ORDER BY b.published_at DESC 
                LIMIT 3
            ");
            $relStmt->execute([$post['category_id'], $post['id']]);
            $relatedPosts = $relStmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // If not enough related posts, fill with recent
        if (count($relatedPosts) < 3) {
            $excludeIds = array_merge([$post['id']], array_column($relatedPosts, 'id'));
            $placeholders = implode(',', array_fill(0, count($excludeIds), '?'));
            $fillStmt = $db->prepare("
                SELECT b.*, c.name as category_name 
                FROM blog_posts b 
                LEFT JOIN blog_categories c ON b.category_id = c.id 
                WHERE b.is_active = 1 AND b.id NOT IN ($placeholders)
                ORDER BY b.published_at DESC 
                LIMIT ?
            ");
            $fillStmt->execute(array_merge($excludeIds, [3 - count($relatedPosts)]));
            $relatedPosts = array_merge($relatedPosts, $fillStmt->fetchAll(PDO::FETCH_ASSOC));
        }

        $this->view('front/blog-detail', [
            'pageTitle' => ($post['meta_title'] ?: $post['title']) . ' | The Perfect Vape',
            'metaDescription' => $post['meta_desc'] ?? '',
            'post' => $post,
            'recentPosts' => $recentPosts,
            'relatedPosts' => $relatedPosts,
            'categories' => $categories,
            'sections' => $sections
        ]);
    }
}
