<?php
session_start();

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/Database.php';
require_once __DIR__ . '/../models/Comment.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: " . BASE_URL . "auth/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Neplatný požadavek.");
}

$content = trim($_POST['content'] ?? '');
$postId = (int)($_POST['post_id'] ?? 0);
$userId = $_SESSION['user_id'];

if (empty($content) || $postId <= 0) {
    die("Komentář nemůže být prázdný.");
}

$db = (new Database())->getConnection();
$commentModel = new Comment($db);

$success = $commentModel->create($content, $userId, $postId);

if ($success) {
    header("Location: " . BASE_URL . "views/posts/detail.php?id=$postId");
    exit();
} else {
    die("Nepodařilo se uložit komentář.");
}
