<?php

class Comment {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    // Vytvoří nový komentář
    public function create(string $content, int $userId, int $postId): bool {
        $stmt = $this->db->prepare("
            INSERT INTO comments (content, user_id, post_id, created_at)
            VALUES (:content, :user_id, :post_id, NOW())
        ");
        return $stmt->execute([
            ':content' => $content,
            ':user_id' => $userId,
            ':post_id' => $postId
        ]);
    }

    // Získá komentáře k danému příspěvku
    public function getByPostId(int $postId): array {
        $stmt = $this->db->prepare("
            SELECT comments.*, users.username 
            FROM comments 
            JOIN users ON comments.user_id = users.id
            WHERE post_id = :post_id
            ORDER BY created_at ASC
        ");
        $stmt->execute([':post_id' => $postId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM comments WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
    
    public function update(int $id, string $content): bool {
        $stmt = $this->db->prepare("UPDATE comments SET content = :content WHERE id = :id");
        return $stmt->execute([
            ':id' => $id,
            ':content' => $content
        ]);
    }

    public function delete(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM comments WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
    
    

}
