<?php
try {
    $host = 'localhost';
    $dbname = 'your_db_name';
    $username = 'your_username';
    $password = 'your_password';

    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 
catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
