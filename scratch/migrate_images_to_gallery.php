<?php
/**
 * Migration Script: Centralize all scattered images into Media Gallery
 * - Scans brands, collections, products upload folders
 * - Converts to WebP + generates thumbnail
 * - Inserts into media table
 * - Updates original DB table paths to new centralized paths
 * Run once via: php scratch/migrate_images_to_gallery.php
 */

require_once __DIR__ . '/../config/config.php';

$host    = DB_HOST;
$db      = DB_NAME;
$user    = DB_USER;
$pass    = DB_PASS;
$charset = 'utf8mb4';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("DB Error: " . $e->getMessage() . "\n");
}

$rootDir   = dirname(__DIR__);
$publicDir = $rootDir . '/public';
$mediaDir  = $publicDir . '/uploads/media/';
$thumbDir  = $mediaDir . 'thumbs/';

// Ensure directories exist
foreach ([$mediaDir, $thumbDir] as $dir) {
    if (!is_dir($dir)) mkdir($dir, 0777, true);
}

// Folders to scan and their corresponding DB table/column info
$scanTargets = [
    [
        'folder'  => $publicDir . '/uploads/products/',
        'label'   => 'products',
        'table'   => null, // products use product_images table — just migrate to gallery
        'col'     => null,
        'oldBase' => 'uploads/products/',
    ],
    [
        'folder'  => $publicDir . '/uploads/collections/',
        'label'   => 'collections',
        'table'   => 'collections',
        'col'     => 'header_image_url',
        'oldBase' => 'uploads/collections/',
    ],
    [
        'folder'  => $publicDir . '/uploads/brands/',
        'label'   => 'brands',
        'table'   => 'brands',
        'col'     => 'logo_url',
        'oldBase' => 'uploads/brands/',
    ],
];

$validExts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
$migrated  = 0;
$skipped   = 0;
$errors    = [];

foreach ($scanTargets as $target) {
    $folder = $target['folder'];
    if (!is_dir($folder)) {
        echo "⚠️  Folder not found, skipping: $folder\n";
        continue;
    }

    $files = scandir($folder);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;

        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        if (!in_array($ext, $validExts)) continue;

        $sourcePath = $folder . $file;
        $nameBase   = pathinfo($file, PATHINFO_FILENAME);
        $cleanBase  = preg_replace('/[^A-Za-z0-9_-]/', '', $nameBase);
        $newFilename = time() . '_' . $cleanBase . '.webp';
        $destPath    = $mediaDir . $newFilename;
        $thumbPath   = $thumbDir . $newFilename;

        // Check if already migrated (same original_name)
        $check = $pdo->prepare("SELECT id FROM media WHERE original_name = ?");
        $check->execute([$file]);
        if ($check->fetch()) {
            echo "⏭️  Already migrated: $file\n";
            $skipped++;
            continue;
        }

        // Convert to WebP
        if (!convertToWebP($sourcePath, $destPath, 82)) {
            // If conversion fails, just copy as-is
            copy($sourcePath, str_replace('.webp', '.' . $ext, $destPath));
            $newFilename = time() . '_' . $cleanBase . '.' . $ext;
            $destPath    = $mediaDir . $newFilename;
            copy($sourcePath, $destPath);
            echo "⚠️  WebP conversion failed for $file, copied as-is.\n";
        }

        // Generate thumbnail
        createThumbnail($destPath ?: $sourcePath, $thumbPath, 300, 300);

        $fileSize   = file_exists($destPath) ? filesize($destPath) : 0;
        $imgInfo    = @getimagesize($destPath ?: $sourcePath);
        $dimensions = $imgInfo ? $imgInfo[0] . 'x' . $imgInfo[1] : '0x0';
        $newPath    = 'uploads/media/' . $newFilename;

        // Insert into media table
        $stmt = $pdo->prepare("INSERT INTO media (filename, original_name, file_path, file_type, file_size, dimensions, created_at) VALUES (?, ?, ?, 'image/webp', ?, ?, NOW())");
        $stmt->execute([$newFilename, $file, $newPath, $fileSize, $dimensions]);

        // Update the original DB record to point to new path
        $updatedRows = 0;
        if ($target['table'] && $target['col']) {
            $oldPath = $target['oldBase'] . $file;
            $upd = $pdo->prepare("UPDATE `{$target['table']}` SET `{$target['col']}` = ? WHERE `{$target['col']}` = ?");
            $upd->execute([$newPath, $oldPath]);
            $updatedRows = $upd->rowCount();
        }

        echo "✅ Migrated [$target[label]]: $file → $newFilename (DB rows updated: $updatedRows)\n";
        $migrated++;
        usleep(1000); // Small delay to avoid timestamp collision
    }
}

echo "\n========================================\n";
echo "Migration Complete!\n";
echo "  Migrated : $migrated\n";
echo "  Skipped  : $skipped\n";
if (!empty($errors)) {
    echo "  Errors   : " . implode("\n", $errors) . "\n";
}
echo "========================================\n";

// ── Image Processing Helpers ──────────────────────────────────

function convertToWebP($src, $dest, $quality = 82) {
    $info = @getimagesize($src);
    if (!$info) return false;
    $mime = $info['mime'];
    switch ($mime) {
        case 'image/jpeg': $img = imagecreatefromjpeg($src); break;
        case 'image/png':
            $img = imagecreatefrompng($src);
            imagepalettetotruecolor($img);
            imagealphablending($img, true);
            imagesavealpha($img, true);
            break;
        case 'image/webp': $img = imagecreatefromwebp($src); break;
        case 'image/gif':  $img = imagecreatefromgif($src);  break;
        default: return false;
    }
    if (!$img) return false;
    $result = imagewebp($img, $dest, $quality);
    imagedestroy($img);
    return $result;
}

function createThumbnail($src, $dest, $w = 300, $h = 300) {
    $info = @getimagesize($src);
    if (!$info) return false;
    $mime = $info['mime'];
    $sw = $info[0]; $sh = $info[1];
    switch ($mime) {
        case 'image/jpeg': $sImg = imagecreatefromjpeg($src); break;
        case 'image/png':  $sImg = imagecreatefrompng($src);  break;
        case 'image/webp': $sImg = imagecreatefromwebp($src); break;
        default: return false;
    }
    $thumb = imagecreatetruecolor($w, $h);
    imagealphablending($thumb, false);
    imagesavealpha($thumb, true);
    $transparent = imagecolorallocatealpha($thumb, 255, 255, 255, 127);
    imagefilledrectangle($thumb, 0, 0, $w, $h, $transparent);

    $ar  = $sw / $sh;
    $tar = $w  / $h;
    if ($ar > $tar) { $cw = $sh * $tar; $cx = ($sw - $cw) / 2; $cy = 0; $ch = $sh; }
    else            { $ch = $sw / $tar; $cy = ($sh - $ch) / 2; $cx = 0; $cw = $sw; }
    imagecopyresampled($thumb, $sImg, 0, 0, $cx, $cy, $w, $h, $cw, $ch);
    $r = imagewebp($thumb, $dest, 80);
    imagedestroy($sImg);
    imagedestroy($thumb);
    return $r;
}
