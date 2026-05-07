<?php
namespace App\Models;

use App\Core\Database;
use PDO;

class BlogPost {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function all() {
        $stmt = $this->db->query("
            SELECT b.*, c.name as category_name 
            FROM blog_posts b 
            LEFT JOIN blog_categories c ON b.category_id = c.id 
            ORDER BY b.published_at DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM blog_posts WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $sql = "INSERT INTO blog_posts (title, custom_url_path, category_id, featured_image_url, excerpt, meta_title, meta_desc, is_active, published_at) 
                VALUES (:title, :custom_url_path, :category_id, :featured_image_url, :excerpt, :meta_title, :meta_desc, :is_active, :published_at)";
        
        $stmt = $this->db->prepare($sql);
        if ($stmt->execute($data)) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    public function update($id, $data) {
        $fields = "";
        foreach ($data as $key => $value) {
            $fields .= "$key = :$key, ";
        }
        $fields = rtrim($fields, ", ");
        
        $sql = "UPDATE blog_posts SET $fields WHERE id = :id";
        $data['id'] = $id;
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($data);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM blog_posts WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getCategories() {
        return $this->db->query("
            SELECT c.*, COUNT(b.id) as post_count 
            FROM blog_categories c 
            LEFT JOIN blog_posts b ON c.id = b.category_id 
            GROUP BY c.id
        ")->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function createCategory($name, $slug) {
        $stmt = $this->db->prepare("INSERT INTO blog_categories (name, slug) VALUES (?, ?)");
        return $stmt->execute([$name, $slug]);
    }

    public function updateCategory($id, $name, $slug) {
        $stmt = $this->db->prepare("UPDATE blog_categories SET name = ?, slug = ? WHERE id = ?");
        return $stmt->execute([$name, $slug, $id]);
    }

    public function deleteCategory($id) {
        $stmt = $this->db->prepare("DELETE FROM blog_categories WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
