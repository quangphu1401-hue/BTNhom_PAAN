<?php
require_once __DIR__ . '/../config/Database.php';

class Lesson {
    private $conn;
    private $table = 'lessons';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Lấy tất cả lessons của một khóa học
    public function getByCourse($course_id) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE course_id = :course_id 
                  ORDER BY `order` ASC, created_at ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':course_id', $course_id);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    // Lấy lesson theo ID
    public function getById($id) {
        $query = "SELECT l.*, c.title as course_title, c.instructor_id
                  FROM " . $this->table . " l
                  JOIN courses c ON l.course_id = c.id
                  WHERE l.id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch();
    }

    // Tạo lesson mới
    public function create($data) {
        $query = "INSERT INTO " . $this->table . " 
                  (course_id, title, content, video_url, `order`) 
                  VALUES (:course_id, :title, :content, :video_url, :order)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':course_id', $data['course_id']);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':content', $data['content']);
        $stmt->bindParam(':video_url', $data['video_url']);
        $stmt->bindParam(':order', $data['order']);
        
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        
        return false;
    }

    // Cập nhật lesson
    public function update($id, $data) {
        $fields = [];
        foreach ($data as $key => $value) {
            if ($key !== 'id' && $key !== 'course_id') {
                $fields[] = "$key = :$key";
            }
        }
        
        $query = "UPDATE " . $this->table . " SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        
        foreach ($data as $key => $value) {
            if ($key !== 'id' && $key !== 'course_id') {
                $stmt->bindValue(":$key", $value);
            }
        }
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }

    // Xóa lesson
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }
}
?>

