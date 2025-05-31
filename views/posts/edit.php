<?php
session_start();
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../models/Database.php';
require_once __DIR__ . '/../../models/Post.php';

// Uživatelská autentizace
if (!isset($_SESSION['user_id'])) {
    header("Location: " . BASE_URL . "auth/login.php");
    exit();
}

// Kontrola ID v URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: " . BASE_URL . "views/posts/list.php");
    exit();
}

$postId = (int) $_GET['id'];

$db = (new Database())->getConnection();
$postModel = new Post($db);
$post = $postModel->getById($postId);

if (!$post) {
    die("Příspěvek nebyl nalezen.");
}

// Kontrola oprávnění
$isAdmin = ($_SESSION['role'] ?? '') === 'admin';
$isOwner = $_SESSION['user_id'] === $post['user_id'];

if (!$isAdmin && !$isOwner) {
    die("Nemáte oprávnění upravit tento příspěvek.");
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Upravit příspěvek</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/styles.css">
</head>
<body class="green-bg d-flex flex-column min-vh-100">
<?php include_once __DIR__ . '/../partials/navbar.php'; ?>

    <main class="flex-grow-1">
        <div class="container py-4">
            <div class="row justify-content-center">
                <div class="col-md-8">

                    <div class="card shadow bg-light rounded-4">
                        <div class="card-header bg-success text-white text-center">
                            <h4>Upravit příspěvek</h4>
                        </div>
                        <div class="card-body">
                            <form action="<?= BASE_URL ?>controllers/post_update.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($post['id']) ?>">

                                <div class="mb-3">
                                    <label for="title" class="form-label">Název</label>
                                    <input type="text" id="title" name="title" class="form-control" required
                                        value="<?= htmlspecialchars($post['title']) ?>">
                                </div>

                                <div class="mb-3">
                                    <label for="content" class="form-label">Obsah</label>
                                    <textarea id="content" name="content" class="form-control" rows="8" required><?= htmlspecialchars($post['content']) ?></textarea>
                                </div>

                                <!-- Aktuální obrázek -->
                                <?php if (!empty($post['image_path'])): ?>
                                    <div class="mb-3">
                                        <p>Aktuální obrázek:</p>
                                        <img src="<?= BASE_URL . 'public/' . $post['image_path'] ?>" class="img-fluid rounded" style="max-width: 300px;">
                                    </div>
                                <?php endif; ?>

                                <!-- Nový obrázek -->
                                <div class="mb-3">
                                    <label for="image" class="form-label">Změnit obrázek (volitelné)</label>
                                    <input type="file" name="image" id="image" class="form-control" accept="image/*">
                                </div>

                                <button type="submit" class="btn btn-success w-100">Uložit změny</button>
                            </form>
                        </div>
                    </div>

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

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
