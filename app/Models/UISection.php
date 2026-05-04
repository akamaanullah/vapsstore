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
     * Get items for a specific section
     */
    public function getSectionItems($sectionId) {
        $sql = "SELECT * FROM ui_section_items 
                WHERE section_id = ? 
                ORDER BY sort_order ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$sectionId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Save/Update sections for an entity
     */
    public function syncSections($entityType, $entityId, $sectionsData) {
        try {
            $this->db->beginTransaction();

            // 1. Get current section IDs to know what to delete
            $stmt = $this->db->prepare("SELECT id FROM ui_sections WHERE entity_type = ? AND entity_id = ?");
            $stmt->execute([$entityType, $entityId]);
            $existingIds = array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'id');

            $newSectionIds = [];

            foreach ($sectionsData as $index => $data) {
                if (!empty($data['id'])) {
                    // Update existing section
                    $sql = "UPDATE ui_sections SET type = ?, sort_order = ?, is_active = ? WHERE id = ?";
                    $this->db->prepare($sql)->execute([
                        $data['type'],
                        $index,
                        $data['is_active'] ?? 1,
                        $data['id']
                    ]);
                    $sectionId = $data['id'];
                    $newSectionIds[] = $sectionId;
                } else {
                    // Create new section
                    $sql = "INSERT INTO ui_sections (entity_type, entity_id, type, sort_order) VALUES (?, ?, ?, ?)";
                    $this->db->prepare($sql)->execute([
                        $entityType,
                        $entityId,
                        $data['type'],
                        $index
                    ]);
                    $sectionId = $this->db->lastInsertId();
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
            $this->db->rollBack();
            error_log("SyncSections failed: " . $e->getMessage());
            return false;
        }
    }

    private function syncSectionItems($sectionId, $items) {
        // 1. Get existing item IDs to know what to delete
        $stmt = $this->db->prepare("SELECT id FROM ui_section_items WHERE section_id = ?");
        $stmt->execute([$sectionId]);
        $existingItemIds = array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'id');

        $newItemIds = [];

        foreach ($items as $index => $item) {
            if (!empty($item['id'])) {
                // Update existing item
                $sql = "UPDATE ui_section_items SET 
                        title = ?, content = ?, image_url = ?, video_url = ?, 
                        button_text = ?, button_url = ?, sort_order = ? 
                        WHERE id = ?";
                $this->db->prepare($sql)->execute([
                    $item['title'] ?? null,
                    $item['content'] ?? null,
                    $item['image_url'] ?? null,
                    $item['video_url'] ?? null,
                    $item['button_text'] ?? null,
                    $item['button_url'] ?? null,
                    $index,
                    $item['id']
                ]);
                $newItemIds[] = $item['id'];
            } else {
                // Insert new item
                $sql = "INSERT INTO ui_section_items (section_id, title, content, image_url, video_url, button_text, button_url, sort_order) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $this->db->prepare($sql)->execute([
                    $sectionId,
                    $item['title'] ?? null,
                    $item['content'] ?? null,
                    $item['image_url'] ?? null,
                    $item['video_url'] ?? null,
                    $item['button_text'] ?? null,
                    $item['button_url'] ?? null,
                    $index
                ]);
                $newItemIds[] = $this->db->lastInsertId();
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
