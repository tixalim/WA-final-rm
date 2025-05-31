<?php
session_start();

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/Database.php';
require_once __DIR__ . '/../models/Post.php';

// Kontrola přihlášení
if (!isset($_SESSION['user_id'])) {
    header("Location: " . BASE_URL . "auth/login.php");
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Neplatný požadavek.");
}

$postId = (int)$_GET['id'];
$userId = $_SESSION['user_id'];
$isAdmin = ($_SESSION['role'] ?? '') === 'admin';

$db = (new Database())->getConnection();
$postModel = new Post($db);
$post = $postModel->getById($postId);

if (!$post) {
    die("Příspěvek nenalezen.");
}

// Ověření oprávnění
if (!$isAdmin && $post['user_id'] != $userId) {
    die("Nemáte oprávnění smazat tento příspěvek.");
}

if ($isAdmin) {
    $success = $postModel->delete($postId, null); // Admin nepotřebuje user_id
} else {
    $success = $postModel->delete($postId, $userId); // Uživatelská kontrola
}


if ($success) {
    header("Location: " . BASE_URL . "views/posts/list.php");
    exit();
} else {
    die("Chyba při mazání příspěvku.");
}
