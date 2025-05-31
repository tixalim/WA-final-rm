<?php include_once '../views/partials/navbar.php'; ?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Solarpunk Blog</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Vlastní CSS -->
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="green-bg d-flex flex-column min-vh-100">
    <main class="flex-grow-1">
        <!-- HORNÍ SEKCE -->
        <section class="hero-section text-white text-center d-flex align-items-center" style="background: url('images/city.png') center/cover no-repeat; min-height: 500px;">
            <div class="container">
                <div class="bg-dark bg-opacity-50 p-5 rounded-4">
                    <h1 class="display-4 fw-bold mb-3">Vítej v budoucnosti</h1>
                    <p class="lead mb-4">Zatímco jiné žánry říkají “tohle se může stát pokud nic nezměníme”, solarpunk říká “tohle může být budoucnost, pokud začneme jednat”</p>
                    <a href="<?= BASE_URL ?>public/about.php" class="btn btn-success btn-lg rounded-pill px-4">Zjisti více</a>
                </div>
            </div>
        </section>


        <!-- OBSAH (POSTY + KOMUNITA) -->
        <section class="container mt-5">
            <div class="row g-4">

            <!-- POSTY -->
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="p-4 rounded-4 bg-white shadow-sm">
                        <h2 class="text-success mb-4">Nejnovější články</h2>

                        <?php
                        // Připojení k DB a načtení posledních 3 článků
                        require_once '../models/Database.php';
                        $db = (new Database())->getConnection();
                        $stmt = $db->query("SELECT id, title, content FROM posts ORDER BY created_at DESC LIMIT 3");
                        $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($posts as $post): ?>
                            <div class="mb-4 p-3 rounded-3 border bg-light">
                                <h5 class="fw-bold"><?= htmlspecialchars($post['title']) ?></h5>
                                <p><?= htmlspecialchars(mb_substr($post['content'], 0, 100)) ?>...</p>
                                <a href="<?= BASE_URL ?>views/posts/detail.php?id=<?= $post['id'] ?>" class="btn btn-outline-success btn-sm rounded-pill">Číst dále</a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

        </section>
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
