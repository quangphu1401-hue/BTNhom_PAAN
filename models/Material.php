<?php
require_once __DIR__ . '/../config/Database.php';

class Material {
    private $conn;
    private $table = 'materials';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Lấy tất cả materials của một lesson
    public function getByLesson($lesson_id) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE lesson_id = :lesson_id 
                  ORDER BY uploaded_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':lesson_id', $lesson_id);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    // Lấy material theo ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch();
    }

    // Tạo material mới
    public function create($lesson_id, $filename, $file_path, $file_type) {
        $query = "INSERT INTO " . $this->table . " 
                  (lesson_id, filename, file_path, file_type) 
                  VALUES (:lesson_id, :filename, :file_path, :file_type)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':lesson_id', $lesson_id);
        $stmt->bindParam(':filename', $filename);
        $stmt->bindParam(':file_path', $file_path);
        $stmt->bindParam(':file_type', $file_type);
        
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        
        return false;
    }

    // Xóa material
    public function delete($id) {
        // Lấy thông tin file trước khi xóa
        $material = $this->getById($id);
        
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        
        if ($stmt->execute() && $material) {
            // Xóa file vật lý
            $file_path = __DIR__ . '/../assets/uploads/materials/' . basename($material['file_path']);
            if (file_exists($file_path)) {
                unlink($file_path);
            }
            return true;
        }
        
        return false;
    }
}
?>

