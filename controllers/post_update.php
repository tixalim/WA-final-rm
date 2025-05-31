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

$success = $postModel->update($id, $title, $content);

if ($success) {
    header("Location: " . BASE_URL . "views/posts/detail.php?id=$id");
    exit();
} else {
    die("Nepodařilo se upravit příspěvek.");
}
