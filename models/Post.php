<?php

class Post {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    // Vytvoří nový příspěvek
    public function create(string $title, string $content, int $userId, ?string $imagePath = null): bool {
        $stmt = $this->db->prepare("
            INSERT INTO posts (title, content, user_id, image_path)
            VALUES (:title, :content, :user_id, :image_path)
        ");
        return $stmt->execute([
            ':title' => $title,
            ':content' => $content,
            ':user_id' => $userId,
            ':image_path' => $imagePath
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

    //Detail příspěvku
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

    //Příspěvky podle uživatele
    public function getByUserId(int $userId): array {
        $stmt = $this->db->prepare("
            SELECT posts.*, users.username 
            FROM posts 
            JOIN users ON posts.user_id = users.id 
            WHERE posts.user_id = :user_id 
            ORDER BY created_at DESC
        ");
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function delete(int $id, ?int $user_id = null): bool {
        if ($user_id === null) {
            // Admin maže bez kontroly user_id
            $stmt = $this->db->prepare("DELETE FROM posts WHERE id = :id");
            return $stmt->execute([':id' => $id]);
        } else {
            // Běžný uživatel – může smazat jen svůj příspěvek
            $stmt = $this->db->prepare("DELETE FROM posts WHERE id = :id AND user_id = :user_id");
            return $stmt->execute([
                ':id' => $id,
                ':user_id' => $user_id
            ]);
        }
    }
    

    //update
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

    public function updateWithImage(int $id, string $title, string $content, ?string $imagePath): bool {
        $stmt = $this->db->prepare("
            UPDATE posts
            SET title = :title,
                content = :content,
                image_path = :image_path
            WHERE id = :id
        ");
        return $stmt->execute([
            ':title' => $title,
            ':content' => $content,
            ':image_path' => $imagePath,
            ':id' => $id
        ]);
    }
    
    
    
}
