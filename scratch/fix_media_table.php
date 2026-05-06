<?php
$host = 'localhost';
$db   = 'vapestore';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
     $pdo = new PDO($dsn, $user, $pass, $options);
     $sql = "CREATE TABLE IF NOT EXISTS media (
        id INT AUTO_INCREMENT PRIMARY KEY, 
        filename VARCHAR(255) NOT NULL, 
        original_name VARCHAR(255) NOT NULL, 
        file_path VARCHAR(255) NOT NULL, 
        file_type VARCHAR(50), 
        file_size INT, 
        dimensions VARCHAR(50), 
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
     $pdo->exec($sql);
     echo "SUCCESS: Media table created/verified.";
} catch (\PDOException $e) {
     echo "ERROR: " . $e->getMessage();
}
