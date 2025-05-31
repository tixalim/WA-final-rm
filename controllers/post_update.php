<?php
session_start();

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/Database.php';
require_once __DIR__ . '/../models/Post.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: " . BASE_URL . "auth/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Neplatný požadavek.");
}

$id = (int)($_POST['id'] ?? 0);
$title = trim($_POST['title'] ?? '');
$content = trim($_POST['content'] ?? '');
$userId = $_SESSION['user_id'];
$isAdmin = ($_SESSION['role'] ?? '') === 'admin';

if ($id <= 0 || empty($title) || empty($content)) {
    die("Chybné nebo neúplné údaje.");
}

$db = (new Database())->getConnection();
$postModel = new Post($db);
$post = $postModel->getById($id);

if (!$post) {
    die("Příspěvek nenalezen.");
}

if (!$isAdmin && $post['user_id'] != $userId) {
    die("Nemáte oprávnění upravit tento příspěvek.");
}

// Pokud je nahrán nový obrázek
$imagePath = $post['image_path']; // výchozí - zachová aktuální obrázek
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = __DIR__ . '/../public/uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $filename = uniqid() . '_' . basename($_FILES['image']['name']);
    $targetPath = $uploadDir . $filename;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
        $imagePath = 'uploads/' . $filename;
    }
}

$success = $postModel->updateWithImage($id, $title, $content, $imagePath);

if ($success) {
    header("Location: " . BASE_URL . "views/posts/detail.php?id=$id");
    exit();
} else {
    die("Nepodařilo se upravit příspěvek.");
}
