<?php
require_once __DIR__ . '/../config/Database.php';

class Course {
    private $conn;
    private $table = 'courses';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Lấy tất cả courses
    public function getAll($limit = null, $offset = 0) {
        $query = "SELECT c.*, u.fullname as instructor_name, cat.name as category_name 
                  FROM " . $this->table . " c
                  LEFT JOIN users u ON c.instructor_id = u.id
                  LEFT JOIN categories cat ON c.category_id = cat.id
                  ORDER BY c.created_at DESC";
        
        if ($limit) {
            $query .= " LIMIT :limit OFFSET :offset";
        }
        
        $stmt = $this->conn->prepare($query);
        if ($limit) {
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        }
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    // Lấy course theo ID
    public function getById($id) {
        $query = "SELECT c.*, u.fullname as instructor_name, cat.name as category_name 
                  FROM " . $this->table . " c
                  LEFT JOIN users u ON c.instructor_id = u.id
                  LEFT JOIN categories cat ON c.category_id = cat.id
                  WHERE c.id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch();
    }

    // Tìm kiếm courses
    public function search($keyword = '', $category_id = null, $level = null, $limit = 20, $offset = 0) {
        $query = "SELECT c.*, u.fullname as instructor_name, cat.name as category_name 
                  FROM " . $this->table . " c
                  LEFT JOIN users u ON c.instructor_id = u.id
                  LEFT JOIN categories cat ON c.category_id = cat.id
                  WHERE 1=1";
        
        $params = [];
        
        if (!empty($keyword)) {
            $query .= " AND (c.title LIKE :keyword OR c.description LIKE :keyword)";
            $params[':keyword'] = "%$keyword%";
        }
        
        if ($category_id) {
            $query .= " AND c.category_id = :category_id";
            $params[':category_id'] = $category_id;
        }
        
        if (!empty($level)) {
            $query .= " AND c.level = :level";
            $params[':level'] = $level;
        }
        
        $query .= " ORDER BY c.created_at DESC LIMIT :limit OFFSET :offset";
        
        $stmt = $this->conn->prepare($query);
        
        // Bind các parameters
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        
        // Bind limit và offset luôn
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    // Lấy courses của instructor
    public function getByInstructor($instructor_id) {
        $query = "SELECT c.*, cat.name as category_name,
                  (SELECT COUNT(*) FROM enrollments WHERE course_id = c.id) as student_count
                  FROM " . $this->table . " c
                  LEFT JOIN categories cat ON c.category_id = cat.id
                  WHERE c.instructor_id = :instructor_id
                  ORDER BY c.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':instructor_id', $instructor_id);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    // Tạo course mới
    public function create($data) {
        $query = "INSERT INTO " . $this->table . " 
                  (title, description, instructor_id, category_id, price, duration_weeks, level, image) 
                  VALUES (:title, :description, :instructor_id, :category_id, :price, :duration_weeks, :level, :image)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':instructor_id', $data['instructor_id']);
        $stmt->bindParam(':category_id', $data['category_id']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':duration_weeks', $data['duration_weeks']);
        $stmt->bindParam(':level', $data['level']);
        $stmt->bindParam(':image', $data['image']);
        
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        
        return false;
    }

    // Cập nhật course
    public function update($id, $data) {
        $fields = [];
        foreach ($data as $key => $value) {
            if ($key !== 'id') {
                $fields[] = "$key = :$key";
            }
        }
        
        $query = "UPDATE " . $this->table . " SET " . implode(', ', $fields) . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }

    // Xóa course
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }
}
?>

