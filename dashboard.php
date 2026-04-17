<?php
session_start();
if (!isset($_SESSION['adminId'])) { header("Location: login.php"); exit(); }
require 'db.php';

// Handle Upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
    $title = trim($_POST['title']);
    $file = $_FILES['image'];
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

    if (in_array($file['type'], $allowedTypes) && $file['error'] == 0) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir);
        
        $targetPath = $uploadDir . time() . "_" . basename($file['name']);
        
        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            $stmt = $db->prepare("INSERT INTO gallery_images (title, imagePath) VALUES (?, ?)");
            $stmt->execute([$title, $targetPath]);
            echo "Image uploaded!";
        }
    } else {
        echo "Invalid file type or upload error.";
    }
}

// Fetch Images
$images = $db->query("SELECT * FROM gallery_images")->fetchAll();
?>

<h2>Admin Gallery</h2>
<form method="POST" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Image Title" required>
    <input type="file" name="image" required>
    <button type="submit">Upload</button>
</form>

<hr>
<div style="display: flex; flex-wrap: wrap;">
    <?php foreach ($images as $img): ?>
        <div style="margin: 10px; border: 1px solid #ccc; padding: 10px;">
            <p><?php echo htmlspecialchars($img['title']); ?></p>
            <img src="<?php echo $img['imagePath']; ?>" width="150"><br>
            <a href="delete.php?id=<?php echo $img['imageId']; ?>" onclick="return confirm('Delete this?')">Delete</a>
        </div>
    <?php endforeach; ?>
</div>
<a href="logout.php">Logout</a>
