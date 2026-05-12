<?php
namespace App\Models;

use App\Core\Model;
use PDO;

class UISection extends Model {
    protected $table = 'ui_sections';

    /**
     * Get all sections for a specific entity (e.g. collection, page)
     */
    public function getSections($entityType, $entityId) {
        $sql = "SELECT * FROM ui_sections 
                WHERE entity_type = ? AND entity_id = ? 
                ORDER BY sort_order ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$entityType, $entityId]);
        $sections = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($sections as &$section) {
            $section['items'] = $this->getSectionItems($section['id']);
        }

        return $sections;
    }

    /**
     * Get all sections for a global entity type (e.g. global_home)
     */
    public function getGlobalSections($entityType) {
        $sql = "SELECT * FROM ui_sections 
                WHERE entity_type = ? AND entity_id IS NULL 
                ORDER BY sort_order ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$entityType]);
        $sections = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($sections as &$section) {
            $section['items'] = $this->getSectionItems($section['id']);
        }

        return $sections;
    }

    /**
     * Get items for a specific section
     */
    public function getSectionItems($sectionId) {
        $sql = "SELECT i.*, 
                p.name as live_product_name,
                p.short_desc as live_product_desc,
                p.base_price as live_product_price,
                p.custom_url as live_product_slug,
                p.option_names as live_product_options,
                (SELECT image_url FROM product_images WHERE product_id = p.id ORDER BY sort_order ASC LIMIT 1) as live_product_image
                FROM ui_section_items i
                LEFT JOIN products p ON (i.entity_type = 'product' AND i.entity_id = p.id)
                WHERE i.section_id = ? 
                ORDER BY i.sort_order ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$sectionId]);
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Override with live data for products
        foreach ($items as &$item) {
            if ($item['entity_type'] === 'product' && !empty($item['live_product_name'])) {
                $item['title'] = $item['live_product_name'];
                $item['image_url'] = $item['live_product_image'];
                $item['price'] = $item['live_product_price'];
                $item['product_slug'] = $item['live_product_slug'];
                $item['short_desc'] = $item['live_product_desc'];
                $item['option_names'] = json_decode($item['live_product_options'], true);
                
                // Fetch Variants
                $vStmt = $this->db->prepare("SELECT * FROM product_variants WHERE product_id = ? ORDER BY id ASC");
                $vStmt->execute([$item['entity_id']]);
                $item['variants'] = $vStmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        
        return $items;
    }

    /**
     * Save/Update sections for an entity
     */
    public function syncSections($entityType, $entityId, $sectionsData) {
        try {
            $this->db->beginTransaction();

            // 1. Get current section IDs to know what to delete
            $sql = "SELECT id FROM ui_sections WHERE entity_type = ? AND " . ($entityId === null ? "entity_id IS NULL" : "entity_id = ?");
            $stmt = $this->db->prepare($sql);
            $params = [$entityType];
            if ($entityId !== null) $params[] = $entityId;
            $stmt->execute($params);
            $existingIds = array_map('intval', array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'id'));

            $newSectionIds = [];

            foreach ($sectionsData as $index => $data) {
                if (!empty($data['id']) && (int)$data['id'] > 0) {
                    // Update existing section
                    $sql = "UPDATE ui_sections SET entity_type = ?, entity_id = ?, type = ?, title = ?, button_text = ?, button_url = ?, sort_order = ?, is_active = ? WHERE id = ?";
                    $this->db->prepare($sql)->execute([
                        $entityType,
                        $entityId,
                        $data['type'],
                        $data['title'] ?? null,
                        $data['button_text'] ?? null,
                        $data['button_url'] ?? null,
                        $index,
                        $data['is_active'] ?? 1,
                        $data['id']
                    ]);
                    $sectionId = $data['id'];
                    $newSectionIds[] = $sectionId;
                } else {
                    // Create new section
                    $sql = "INSERT INTO ui_sections (entity_type, entity_id, type, title, button_text, button_url, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?)";
                    $this->db->prepare($sql)->execute([
                        $entityType,
                        $entityId,
                        $data['type'],
                        $data['title'] ?? null,
                        $data['button_text'] ?? null,
                        $data['button_url'] ?? null,
                        $index
                    ]);
                    $sectionId = $this->db->lastInsertId();
                    $newSectionIds[] = $sectionId;
                }

                // Sync items for this section
                $this->syncSectionItems($sectionId, $data['items'] ?? []);
            }

            // Delete sections that are no longer present
            $toDelete = array_diff($existingIds, $newSectionIds);
            if (!empty($toDelete)) {
                $placeholders = implode(',', array_fill(0, count($toDelete), '?'));
                // Items will be deleted via DB foreign keys or manual delete
                $this->db->prepare("DELETE FROM ui_section_items WHERE section_id IN ($placeholders)")->execute(array_values($toDelete));
                $this->db->prepare("DELETE FROM ui_sections WHERE id IN ($placeholders)")->execute(array_values($toDelete));
            }

            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            if ($this->db->inTransaction()) $this->db->rollBack();
            error_log("SyncSections failed: " . $e->getMessage());
            throw $e;
        }
    }

    private function syncSectionItems($sectionId, $items) {
        // 1. Get existing item IDs to know what to delete
        $stmt = $this->db->prepare("SELECT id FROM ui_section_items WHERE section_id = ?");
        $stmt->execute([$sectionId]);
        $existingItemIds = array_map('intval', array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'id'));

        $newItemIds = [];

        foreach ($items as $index => $item) {
            if (!empty($item['id']) && (int)$item['id'] > 0) {
                // Update existing item
                $isProduct = ($item['entity_type'] ?? null) === 'product';
                $sql = "UPDATE ui_section_items SET 
                        entity_id = ?, entity_type = ?,
                        title = ?, content = ?, image_url = ?, video_url = ?, 
                        button_text = ?, button_url = ?, sort_order = ? 
                        WHERE id = ?";
                $this->db->prepare($sql)->execute([
                    $item['entity_id'] ?? null,
                    $item['entity_type'] ?? null,
                    $isProduct ? null : ($item['title'] ?? null),
                    $item['content'] ?? null,
                    $isProduct ? null : ($item['image_url'] ?? null),
                    $item['video_url'] ?? null,
                    $item['button_text'] ?? null,
                    $item['button_url'] ?? null,
                    $index,
                    $item['id']
                ]);
                $newItemIds[] = (int)$item['id'];
            } else {
                // Insert new item
                $isProduct = ($item['entity_type'] ?? null) === 'product';
                $sql = "INSERT INTO ui_section_items (section_id, entity_id, entity_type, title, content, image_url, video_url, button_text, button_url, sort_order) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $this->db->prepare($sql)->execute([
                    $sectionId,
                    $item['entity_id'] ?? null,
                    $item['entity_type'] ?? null,
                    $isProduct ? null : ($item['title'] ?? null),
                    $item['content'] ?? null,
                    $isProduct ? null : ($item['image_url'] ?? null),
                    $item['video_url'] ?? null,
                    $item['button_text'] ?? null,
                    $item['button_url'] ?? null,
                    $index
                ]);
                $newItemIds[] = (int)$this->db->lastInsertId();
            }
        }

        // Delete items that are no longer present
        $toDelete = array_diff($existingItemIds, $newItemIds);
        if (!empty($toDelete)) {
            $placeholders = implode(',', array_fill(0, count($toDelete), '?'));
            $this->db->prepare("DELETE FROM ui_section_items WHERE id IN ($placeholders)")->execute(array_values($toDelete));
        }
    }
}
