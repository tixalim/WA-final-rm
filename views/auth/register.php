<?php
session_start();
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Registrace uživatele</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS (volitelně) -->
    <link rel="stylesheet" href="../../public/css/styles.css">
</head>
<body class="bg-light">
<?php include_once __DIR__ . '/../partials/navbar.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
        


            <div class="card shadow">
                <div class="card-header text-white text-center" style="background-color:rgb(100, 184, 118);">
                    <h3 class="mb-0">Registrace</h3>
                </div>
                <div class="card-body">
                    <form action="../../controllers/register.php" method="POST" novalidate>
                        <div class="mb-3">
                            <label for="username" class="form-label">Uživatelské jméno <span class="text-danger">*</span></label>
                            <input type="text" name="username" id="username" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail (nepovinný)</label>
                            <input type="email" name="email" id="email" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Heslo <span class="text-danger">*</span></label>
                            <input type="password" name="password" id="password" class="form-control" required
                                   pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$"
                                   title="Minimálně 8 znaků, alespoň jedno velké písmeno a jedno číslo">
                        </div>

                        <div class="mb-3">
                            <label for="password_confirm" class="form-label">Potvrzení hesla <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirm" id="password_confirm" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-success w-100">Registrovat se</button>
                    </form>
                </div>
            </div>

            <div class="text-center mt-3">
                <a href="login.php">Už máte účet? Přihlaste se</a>
            </div>

        </div>
    </div>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Volitelně: klientská kontrola hesla -->
<script>
    const form = document.querySelector('form');
    const pass = document.getElementById('password');
    const confirm = document.getElementById('password_confirm');

    form.addEventListener('submit', function (e) {
        if (pass.value !== confirm.value) {
            e.preventDefault();
            alert('Hesla se neshodují.');
        }
    });
</script>

</body>
</html>
