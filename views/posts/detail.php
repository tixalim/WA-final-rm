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

require_once __DIR__ . '/../../models/Comment.php';
$commentModel = new Comment($db);
$comments = $commentModel->getByPostId($post['id']);

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
<body class="green-bg d-flex flex-column min-vh-100">
<?php include_once __DIR__ . '/../partials/navbar.php'; ?>

<main class="flex-grow-1">
    <div class="container py-4">
        <div class="card shadow bg-light rounded-4">
            <div class="card-body">
                <h2 class="card-title"><?= htmlspecialchars($post['title']) ?></h2>
                <p class="text-muted">
                    Autor: <?= htmlspecialchars($post['username']) ?> |
                    <?= date('d.m.Y H:i', strtotime($post['created_at'])) ?>
                </p>

                <?php if (!empty($post['image_path'])): ?>
                    <img src="<?= BASE_URL . 'public/' . $post['image_path'] ?>"
                         class="img-fluid rounded-4 mb-3"
                         alt="Obrázek příspěvku"
                         style="max-height: 400px; object-fit: cover; width: 100%;">
                <?php endif; ?>

                <p class="card-text"><?= nl2br(htmlspecialchars($post['content'])) ?></p>

                <?php if ($currentUserId && ($ownsPost || $isAdmin)): ?>
                    <div class="mt-4">
                        <a href="<?= BASE_URL ?>views/posts/edit.php?id=<?= $post['id'] ?>" class="btn btn-edit btn-sm">Upravit</a>
                        <a href="<?= BASE_URL ?>controllers/post_delete.php?id=<?= $post['id'] ?>"
                           class="btn btn-delete btn-sm"
                           onclick="return confirm('Opravdu chcete smazat tento příspěvek?');">Smazat</a>
                    </div>
                <?php endif; ?>

                <hr class="my-4">
                <h4>Komentáře</h4>

                <?php if (!empty($comments)): ?>
                    <?php foreach ($comments as $comment): ?>
                        <div class="mb-3 p-3 bg-white rounded-3 border">
                            <p class="mb-1"><?= nl2br(htmlspecialchars($comment['content'])) ?></p>
                            <small class="text-muted">
                                <?= htmlspecialchars($comment['username']) ?> &middot;
                                <?= date('d.m.Y H:i', strtotime($comment['created_at'])) ?>
                            </small>

                            <?php
                            $ownsComment = $comment['user_id'] === $currentUserId;
                            if ($isAdmin || $ownsComment):
                            ?>
                                <?php if ($isAdmin): ?>
                                    <a href="<?= BASE_URL ?>controllers/comment_delete.php?id=<?= $comment['id'] ?>&post_id=<?= $post['id'] ?>"
                                       class="btn btn-sm btn-delete ms-2"
                                       onclick="return confirm('Opravdu chcete smazat tento komentář?');">Smazat</a>
                                <?php endif; ?>
                                <a href="<?= BASE_URL ?>views/comments/edit.php?id=<?= $comment['id'] ?>"
                                   class="btn btn-sm btn-edit ms-2">Upravit</a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted">Zatím žádné komentáře.</p>
                <?php endif; ?>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <form action="<?= BASE_URL ?>controllers/comment_create.php" method="POST" class="mt-4">
                        <div class="mb-3">
                            <label for="content" class="form-label">Přidat komentář</label>
                            <textarea name="content" id="content" rows="3" class="form-control" required></textarea>
                        </div>
                        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                        <button type="submit" class="btn btn-success">Odeslat</button>
                    </form>
                <?php else: ?>
                    <p class="text-muted">
                        Pro přidání komentáře se prosím
                        <a href="<?= BASE_URL ?>views/auth/login.php">přihlaste</a>.
                    </p>
                <?php endif; ?>

                <a href="<?= BASE_URL ?>views/posts/list.php" class="btn btn-outline-secondary mt-3">Zpět na seznam</a>
            </div>
        </div>
    </div>
</main>

<footer class="text-center py-4 mt-5 border-top bg-white">
    <div class="container">
        <small class="text-muted">
            &copy; <?= date('Y') ?> Solarpunk Blog. Všechna práva vyhrazena.
        </small>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
