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
    $imagePath = null;

    if (empty($title) || empty($content)) {
        die("Nadpis i obsah jsou povinné.");
    }

    // Zpracování nahraného obrázku
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

    $db = (new Database())->getConnection();
    $postModel = new Post($db);

    $success = $postModel->create($title, $content, $user_id, $imagePath);

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
