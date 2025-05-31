<?php
session_start();

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/Database.php';
require_once __DIR__ . '/../models/Post.php';

// Zajistí, že uživatel je přihlášen
if (!isset($_SESSION['user_id'])) {
    header("Location: " . BASE_URL . "auth/login.php");
    exit();
}

// Zpracování akce "create"
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
    $title = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $user_id = $_SESSION['user_id'];

    if (empty($title) || empty($content)) {
        die("Nadpis i obsah jsou povinné.");
    }

    $db = (new Database())->getConnection();
    $postModel = new Post($db);

    $success = $postModel->create($title, $content, $user_id);

    if ($success) {
        header("Location: " . BASE_URL . "views/posts/list.php");
        exit();
    } else {
        die("Nepodařilo se uložit příspěvek.");
    }
} else {
    header("Location: " . BASE_URL . "public/index.php");
    exit();
}
