<?php
$db = new PDO('mysql:host=localhost;dbname=vapestore', 'root', '');
echo "SECTIONS FOR BLOG 1:\n";
$stmt = $db->query("SELECT * FROM ui_sections WHERE entity_type = 'blog' AND entity_id = 1");
$sections = $stmt->fetchAll(PDO::FETCH_ASSOC);
print_r($sections);

foreach ($sections as $section) {
    echo "\nITEMS FOR SECTION " . $section['id'] . ":\n";
    $stmt = $db->query("SELECT * FROM ui_section_items WHERE section_id = " . $section['id']);
    print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
}
