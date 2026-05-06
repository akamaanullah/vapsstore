<?php
namespace App\Traits;

trait Sluggable {
    /**
     * Generate a URL-safe slug from text.
     * 
     * @param string $text The text to convert
     * @return string The generated slug
     */
    protected function generateSlug($text) {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);
        return empty($text) ? 'n-a' : $text;
    }

    /**
     * Generate a unique slug by checking the database.
     */
    public function generateUniqueSlug($text, $currentId = null) {
        $slug = $this->generateSlug($text);
        $originalSlug = $slug;
        $count = 1;

        while (true) {
            $sql = "SELECT COUNT(*) FROM {$this->table} WHERE custom_url = ?";
            $params = [$slug];
            
            if ($currentId) {
                $sql .= " AND id != ?";
                $params[] = $currentId;
            }

            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            
            if ($stmt->fetchColumn() == 0) {
                break;
            }

            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }
}
