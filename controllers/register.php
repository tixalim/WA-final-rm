<?php
require_once '../models/Database.php';
require_once '../models/User.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $passwordConfirm = $_POST['password_confirm'] ?? '';

    if (empty($username) || empty($password) || empty($passwordConfirm)) {
        die('Vyplňte všechna povinná pole.');
    }

    if ($password !== $passwordConfirm) {
        die('Hesla se neshodují.');
    }

    $db = (new Database())->getConnection();
    $userModel = new User($db);

    if ($userModel->existsByUsername($username)) {
        die('Toto uživatelské jméno je již obsazené.');
    }

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    if ($userModel->register($username, $email, $passwordHash)) {
        header('Location: ../views/auth/login.php');
        exit();
    } else {
        die('Registrace se nezdařila. Zkuste to později.');
    }
} else {
    die('Neplatný požadavek.');
}
