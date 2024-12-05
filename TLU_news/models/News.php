<?php
class News {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    // Lấy danh sách tin tức
    public function getAllNews() {
        $query = "SELECT news.*, categories.name AS category_name 
                  FROM news 
                  LEFT JOIN categories ON news.category_id = categories.id";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy tin tức theo ID
    public function getNewsById($id) {
        $query = "SELECT * FROM news WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Thêm tin tức
    public function addNews($title, $content, $category_id, $image) {
        $query = "INSERT INTO news (title, content, image, category_id, created_at) 
                  VALUES (:title, :content, :image, :category_id, NOW())"; //now lấy thời gian hiện tại của hệ thống
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':image', $image);
        return $stmt->execute();
    }

    // Sửa tin tức
    public function updateNews($id, $title, $content, $category_id) {
        $query = "UPDATE news SET title = :title, content = :content, category_id = :category_id WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':category_id', $category_id);
        return $stmt->execute();
    }

    // Xóa tin tức
    public function deleteNews($id) {
        $query = "DELETE FROM news WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>

