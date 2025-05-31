<?php
session_start();
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/Database.php';
require_once __DIR__ . '/../models/Comment.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Neplatný požadavek.");
}

$id = (int)($_POST['id'] ?? 0);
$content = trim($_POST['content'] ?? '');
$postId = (int)($_POST['post_id'] ?? 0);

if ($id <= 0 || $postId <= 0 || empty($content)) {
    die("Neplatné údaje.");
}

$db = (new Database())->getConnection();
$commentModel = new Comment($db);
$comment = $commentModel->getById($id);

if (!$comment) {
    die("Komentář nenalezen.");
}

$currentUserId = $_SESSION['user_id'] ?? null;
$isAdmin = ($_SESSION['role'] ?? '') === 'admin';

if (!$isAdmin && $comment['user_id'] !== $currentUserId) {
    die("Nemáte oprávnění upravit tento komentář.");
}

$success = $commentModel->update($id, $content);

if ($success) {
    header("Location: " . BASE_URL . "views/posts/detail.php?id=" . $postId);
    exit();
} else {
    die("Nepodařilo se aktualizovat komentář.");
}
