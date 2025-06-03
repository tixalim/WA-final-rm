<?php
require_once __DIR__ . '/../../config/config.php';
?>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar navbar-expand-lg navbar-light eco-navbar">
    <div class="container">
    <a class="navbar-brand d-flex align-items-center fw-semibold text-success" href="<?= BASE_URL ?>public/index.php">
    <img src="<?= BASE_URL ?>public/images/logo.png" alt="Logo" width="60" height="60" class="me-2">
    Solarpunk
</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav" aria-controls="navbarNav"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <!-- Levá část -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>public/about.php">O tématu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>views/posts/list.php">Příspěvky</a>
                </li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= BASE_URL ?>views/posts/create.php">Přidat příspěvek</a>
                    </li>
                <?php endif; ?>
                <?php if (isset($_SESSION['user_id'])): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= BASE_URL ?>views/posts/my_posts.php">Moje příspěvky</a>
                </li>
            <?php endif; ?>

            </ul>

            <!-- Pravá část -->
            <ul class="navbar-nav ms-auto">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <span class="nav-link">Přihlášen jako: <strong><?= htmlspecialchars($_SESSION['username']) ?></strong></span>
                    </li>
                    <li class="nav-item">
                        <a href="<?= BASE_URL ?>controllers/logout.php" class="nav-link">Odhlásit se</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a href="<?= BASE_URL ?>views/auth/login.php" class="nav-link">Přihlášení</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= BASE_URL ?>views/auth/register.php" class="nav-link">Registrace</a>
                    </li>
                <?php endif; ?>
            </ul>

        </div>
    </div>
</nav>
