<?php
class Comment {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($post_id, $user_id, $content) {
        $sql = "INSERT INTO comments (post_id, user_id, content) VALUES (:post_id, :user_id, :content)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':post_id' => $post_id,
            ':user_id' => $user_id,
            ':content' => $content
        ]);
    }

    public function getByPostId($post_id) {
        $sql = "SELECT comments.*, users.username FROM comments JOIN users ON comments.user_id = users.id WHERE post_id = :post_id ORDER BY created_at ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':post_id' => $post_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
