<?php
session_start();
if (!isset($_SESSION['adminId'])) { exit(); }
require 'db.php';

if (isset($_GET['id'])) {
    // Optional: Delete physical file first
    $stmt = $db->prepare("SELECT imagePath FROM gallery_images WHERE imageId = ?");
    $stmt->execute([$_GET['id']]);
    $img = $stmt->fetch();
    if ($img) unlink($img['imagePath']);

    $stmt = $db->prepare("DELETE FROM gallery_images WHERE imageId = ?");
    $stmt->execute([$_GET['id']]);
}
header("Location: dashboard.php");
