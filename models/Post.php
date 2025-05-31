<?php

class Post {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    // Vytvoří nový příspěvek
    public function create(string $title, string $content, int $user_id): bool {
        $stmt = $this->db->prepare("
            INSERT INTO posts (title, content, user_id)
            VALUES (:title, :content, :user_id)
        ");
        return $stmt->execute([
            ':title' => $title,
            ':content' => $content,
            ':user_id' => $user_id
        ]);
    }

    // Získá všechny příspěvky
    public function getAll(): array {
        $stmt = $this->db->prepare("
            SELECT posts.*, users.username 
            FROM posts
            JOIN users ON posts.user_id = users.id
            ORDER BY created_at DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // (Volitelně) Detail příspěvku – můžeš použít později
    public function getById($id): ?array {
        $stmt = $this->db->prepare("
            SELECT posts.*, users.username
            FROM posts
            JOIN users ON posts.user_id = users.id
            WHERE posts.id = :id
        ");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    // (Volitelně) Smazání příspěvku, pokud budeš chtít CRUD
    public function delete(int $id, int $user_id, bool $isAdmin = false): bool {
        if ($isAdmin) {
            $stmt = $this->db->prepare("DELETE FROM posts WHERE id = :id");
            return $stmt->execute([':id' => $id]);
        }
    
        $stmt = $this->db->prepare("DELETE FROM posts WHERE id = :id AND user_id = :user_id");
        return $stmt->execute([
            ':id' => $id,
            ':user_id' => $user_id
        ]);
    }

    public function update(int $id, string $title, string $content): bool {
        $stmt = $this->db->prepare("
            UPDATE posts 
            SET title = :title, content = :content 
            WHERE id = :id
        ");
        return $stmt->execute([
            ':id' => $id,
            ':title' => $title,
            ':content' => $content
        ]);
    }
    
    
}
