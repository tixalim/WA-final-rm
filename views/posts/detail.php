<?php
session_start();
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../models/Database.php';
require_once __DIR__ . '/../../models/Post.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Neplatné ID příspěvku.");
}

$db = (new Database())->getConnection();
$postModel = new Post($db);
$post = $postModel->getById((int)$_GET['id']);

if (!$post) {
    die("Příspěvek nebyl nalezen.");
}

$currentUserId = $_SESSION['user_id'] ?? null;
$isAdmin = ($_SESSION['role'] ?? '') === 'admin';
$ownsPost = $currentUserId === $post['user_id'];
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Detail příspěvku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/styles.css">
</head>
<body class="green-bg">
<?php include_once __DIR__ . '/../partials/navbar.php'; ?>

<div class="container mt-5">
    <div class="card shadow bg-light rounded-4">
        <div class="card-body">
            <h2 class="card-title"><?= htmlspecialchars($post['title']) ?></h2>
            <p class="text-muted">Autor: <?= htmlspecialchars($post['username']) ?> | <?= date('d.m.Y H:i', strtotime($post['created_at'])) ?></p>
            <p class="card-text"><?= nl2br(htmlspecialchars($post['content'])) ?></p>

            <?php if ($currentUserId && ($ownsPost || $isAdmin)): ?>
                <div class="mt-4">
                    <a href="<?= BASE_URL ?>views/posts/edit.php?id=<?= $post['id'] ?>" class="btn btn-edit btn-sm">Upravit</a>
                    <a href="<?= BASE_URL ?>controllers/post_delete.php?id=<?= $post['id'] ?>" class="btn btn-delete btn-sm" onclick="return confirm('Opravdu chcete smazat tento příspěvek?');">Smazat</a>
                </div>
            <?php endif; ?>


            <a href="<?= BASE_URL ?>views/posts/list.php" class="btn btn-outline-secondary mt-3">Zpět na seznam</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
