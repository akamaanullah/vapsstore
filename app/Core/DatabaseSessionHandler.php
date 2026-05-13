<?php
namespace App\Core;

use SessionHandlerInterface;
use PDO;

class DatabaseSessionHandler implements SessionHandlerInterface {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function open($savePath, $sessionName): bool {
        return true;
    }

    public function close(): bool {
        return true;
    }

    public function read($id): string {
        $stmt = $this->db->prepare("SELECT data FROM sessions WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['data'] : '';
    }

    public function write($id, $data): bool {
        $lastAccess = time();
        $stmt = $this->db->prepare("REPLACE INTO sessions (id, data, last_access) VALUES (:id, :data, :last_access)");
        return $stmt->execute([
            'id' => $id,
            'data' => $data,
            'last_access' => $lastAccess
        ]);
    }

    public function destroy($id): bool {
        $stmt = $this->db->prepare("DELETE FROM sessions WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function gc($maxlifetime): int|false {
        $old = time() - $maxlifetime;
        $stmt = $this->db->prepare("DELETE FROM sessions WHERE last_access < :old");
        $stmt->execute(['old' => $old]);
        return $stmt->rowCount();
    }
}
