<?php
session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/Database.php';
require_once __DIR__ . '/../models/Comment.php';

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    die("Přístup zamítnut.");
}

$id = (int)($_GET['id'] ?? 0);
$postId = (int)($_GET['post_id'] ?? 0);

if ($id <= 0 || $postId <= 0) {
    die("Neplatné parametry.");
}

$db = (new Database())->getConnection();
$commentModel = new Comment($db);
$comment = $commentModel->getById($id);

if (!$comment) {
    die("Komentář nenalezen.");
}

$success = $commentModel->delete($id);

if ($success) {
    header("Location: " . BASE_URL . "views/posts/detail.php?id=$postId");
    exit();
} else {
    die("Nepodařilo se smazat komentář.");
}
