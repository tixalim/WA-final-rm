<?php

class User {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    // Zjistí, jestli uživatel už existuje
    public function existsByUsername($username) {
        $stmt = $this->db->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch() !== false;
    }

    // Registrace nového uživatele
    public function register($username, $email, $passwordHash) {
        $stmt = $this->db->prepare("
            INSERT INTO users (username, email, password_hash)
            VALUES (?, ?, ?)
        ");
        return $stmt->execute([$username, $email, $passwordHash]);
    }

    // Vrátí uživatele podle jména
    public function findByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Vrátí uživatele podle ID (volitelné, může se hodit např. pro profil)
    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // (Volitelné) Mazání uživatele (pouze pro admina)
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
