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
<body class="bg-light green-bg">

    <!-- HERO SEKCE -->
    <section class="hero-box rounded-4 shadow p-5 mb-5 mx-auto text-center text-dark">
        <img src="images/solarpunk-house.png" alt="Solární dům" class="img-fluid mb-4" style="max-height: 200px;">
        <h1 class="display-5 fw-semibold">Welcome to the future</h1>
        <p class="lead">Lorem ipsum dolor sit amet, consectetur issam eliet, sed úo aliquam equa ulisse edum uisem.</p>
        <a href="about.php" class="btn btn-success btn-lg rounded-pill mt-3">Read More</a>
    </section>

    <!-- OBSAH (POSTY + KOMUNITA) -->
    <section class="container">
        <div class="row g-4">

            <!-- POSTY -->
            <div class="col-md-8">
                <div class="p-4 rounded-4 bg-white shadow-sm">
                    <h2 class="text-success mb-4">Latest Posts</h2>

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
                            <a href="/views/posts/detail.php?id=<?= $post['id'] ?>" class="btn btn-outline-success btn-sm rounded-pill">Read More</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- KOMUNITA -->
            <div class="col-md-4">
                <div class="p-4 rounded-4 bg-white shadow-sm">
                    <h2 class="text-success mb-4">Community</h2>

                    <div class="d-flex align-items-center mb-3">
                        <img src="images/avatar1.png" alt="Alice" class="rounded-circle me-3" width="50">
                        <div>
                            <strong>Alice</strong>
                            <p class="mb-0 text-muted small">Lorem ipsum dolor sit amet.</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <img src="images/avatar2.png" alt="David" class="rounded-circle me-3" width="50">
                        <div>
                            <strong>David</strong>
                            <p class="mb-0 text-muted small">Lorem ipsum dolor sit amet.</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <img src="images/avatar3.png" alt="Eve" class="rounded-circle me-3" width="50">
                        <div>
                            <strong>Eve</strong>
                            <p class="mb-0 text-muted small">Lorem ipsum dolor sit amet.</p>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
