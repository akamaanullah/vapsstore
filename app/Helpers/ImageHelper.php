<?php
namespace App\Helpers;

class ImageHelper {
    /**
     * Convert and optimize an image to WebP
     */
    public static function convertToWebP($sourcePath, $destinationPath, $quality = 80) {
        $info = \getimagesize($sourcePath);
        if (!$info) return false;

        $mime = $info['mime'];
        switch ($mime) {
            case 'image/jpeg':
                $image = \imagecreatefromjpeg($sourcePath);
                break;
            case 'image/png':
                $image = \imagecreatefrompng($sourcePath);
                // Preserve transparency for PNG
                \imagepalettetotruecolor($image);
                \imagealphablending($image, true);
                \imagesavealpha($image, true);
                break;
            case 'image/webp':
                $image = \imagecreatefromwebp($sourcePath);
                break;
            default:
                return false;
        }

        if (!$image) return false;

        $result = \imagewebp($image, $destinationPath, $quality);
        \imagedestroy($image);
        
        return $result;
    }

    /**
     * Create a thumbnail from an image
     */
    public static function createThumbnail($sourcePath, $destinationPath, $width = 150, $height = 150) {
        $info = \getimagesize($sourcePath);
        if (!$info) return false;

        $mime = $info['mime'];
        $srcWidth = $info[0];
        $srcHeight = $info[1];

        switch ($mime) {
            case 'image/jpeg': $srcImage = \imagecreatefromjpeg($sourcePath); break;
            case 'image/png': $srcImage = \imagecreatefrompng($sourcePath); break;
            case 'image/webp': $srcImage = \imagecreatefromwebp($sourcePath); break;
            default: return false;
        }

        $thumbImage = \imagecreatetruecolor($width, $height);
        
        // Handle transparency
        if ($mime == 'image/png' || $mime == 'image/webp') {
            \imagealphablending($thumbImage, false);
            \imagesavealpha($thumbImage, true);
            $transparent = \imagecolorallocatealpha($thumbImage, 255, 255, 255, 127);
            \imagefilledrectangle($thumbImage, 0, 0, $width, $height, $transparent);
        }

        // Center crop logic
        $srcX = 0; $srcY = 0;
        $srcW = $srcWidth; $srcH = $srcHeight;

        $aspectRatio = $srcWidth / $srcHeight;
        $thumbRatio = $width / $height;

        if ($aspectRatio > $thumbRatio) {
            $srcW = $srcHeight * $thumbRatio;
            $srcX = ($srcWidth - $srcW) / 2;
        } else {
            $srcH = $srcWidth / $thumbRatio;
            $srcY = ($srcHeight - $srcH) / 2;
        }

        \imagecopyresampled($thumbImage, $srcImage, 0, 0, $srcX, $srcY, $width, $height, $srcW, $srcH);
        
        $result = \imagewebp($thumbImage, $destinationPath, 80);
        
        \imagedestroy($srcImage);
        \imagedestroy($thumbImage);

        return $result;
    }
}
