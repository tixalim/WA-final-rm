<?php
session_start();
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../models/Database.php';
require_once __DIR__ . '/../../models/Comment.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Neplatné ID komentáře.");
}

$db = (new Database())->getConnection();
$commentModel = new Comment($db);
$comment = $commentModel->getById((int)$_GET['id']);

if (!$comment) {
    header("Location: " . BASE_URL . "views/posts/list.php");
    exit();
}

$currentUserId = $_SESSION['user_id'] ?? null;
$isAdmin = ($_SESSION['role'] ?? '') === 'admin';

if (!$isAdmin && $comment['user_id'] !== $currentUserId) {
    die("Nemáte oprávnění upravit tento komentář.");
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Úprava komentáře</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="green-bg d-flex flex-column min-vh-100">
<?php include_once __DIR__ . '/../partials/navbar.php'; ?>

<main class="flex-grow-1">
    <div class="container py-5">
        <div class="card shadow bg-white rounded-4 p-4">
            <h3 class="mb-4">Upravit komentář</h3>
            <form action="<?= BASE_URL ?>controllers/comment_update.php" method="POST">
                <div class="mb-3">
                    <textarea name="content" class="form-control" rows="4" required><?= htmlspecialchars($comment['content']) ?></textarea>
                </div>
                <input type="hidden" name="id" value="<?= $comment['id'] ?>">
                <input type="hidden" name="post_id" value="<?= $comment['post_id'] ?>">
                <button type="submit" class="btn btn-success">Uložit změny</button>
                <a href="<?= BASE_URL ?>views/posts/detail.php?id=<?= $comment['post_id'] ?>" class="btn btn-secondary">Zpět</a>
            </form>
        </div>
    </div>
</main>
</body>
</html>
