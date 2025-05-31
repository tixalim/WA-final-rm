<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../public/index.php");
    exit();
}

require_once __DIR__ . '/../../config/config.php';
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Přidat příspěvek</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/styles.css">
</head>
<body class="green-bg">
<?php include_once __DIR__ . '/../partials/navbar.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow rounded-4">
                <div class="card-header bg-success text-white text-center">
                    <h3>Nový příspěvek</h3>
                </div>
                <div class="card-body">
                    <form action="<?= BASE_URL ?>controllers/PostController.php" method="POST">
                        <input type="hidden" name="action" value="create">

                        <div class="mb-3">
                            <label for="title" class="form-label">Nadpis <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Obsah <span class="text-danger">*</span></label>
                            <textarea name="content" id="content" rows="8" class="form-control" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-success w-100">Publikovat</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
