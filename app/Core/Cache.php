<?php
namespace App\Core;

class Cache {
    private static $cacheDir = __DIR__ . '/../../storage/cache';

    public static function set($key, $value, $duration = 3600) {
        if (!is_dir(self::$cacheDir)) {
            mkdir(self::$cacheDir, 0777, true);
        }

        $file = self::$cacheDir . '/' . md5($key) . '.cache';
        $data = [
            'expires' => time() + $duration,
            'content' => $value
        ];

        file_put_contents($file, serialize($data));
    }

    public static function get($key) {
        $file = self::$cacheDir . '/' . md5($key) . '.cache';

        if (!file_exists($file)) return null;

        $data = unserialize(file_get_contents($file));

        if (time() > $data['expires']) {
            unlink($file);
            return null;
        }

        return $data['content'];
    }

    public static function delete($key) {
        $file = self::$cacheDir . '/' . md5($key) . '.cache';
        if (file_exists($file)) unlink($file);
    }
}
