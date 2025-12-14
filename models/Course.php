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
        $hasStatus = $this->hasStatusColumn();
        
        if ($hasStatus) {
            // Mặc định status = 'pending' nếu không được chỉ định
            $status = $data['status'] ?? 'pending';
            
            $query = "INSERT INTO " . $this->table . " 
                      (title, description, instructor_id, category_id, price, duration_weeks, level, image, status) 
                      VALUES (:title, :description, :instructor_id, :category_id, :price, :duration_weeks, :level, :image, :status)";
            
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':title', $data['title']);
            $stmt->bindParam(':description', $data['description']);
            $stmt->bindParam(':instructor_id', $data['instructor_id']);
            $stmt->bindParam(':category_id', $data['category_id']);
            $stmt->bindParam(':price', $data['price']);
            $stmt->bindParam(':duration_weeks', $data['duration_weeks']);
            $stmt->bindParam(':level', $data['level']);
            $stmt->bindParam(':image', $data['image']);
            $stmt->bindParam(':status', $status);
        } else {
            // Nếu chưa có cột status, không thêm vào query
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
        }
        
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

    // Kiểm tra xem cột status có tồn tại không
    private function hasStatusColumn() {
        try {
            $query = "SHOW COLUMNS FROM " . $this->table . " LIKE 'status'";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            return false;
        }
    }

    // Lấy khóa học chờ duyệt (pending)
    public function getPendingCourses() {
        $hasStatus = $this->hasStatusColumn();
        
        if ($hasStatus) {
            $query = "SELECT c.*, u.fullname as instructor_name, u.email as instructor_email, 
                      cat.name as category_name
                      FROM " . $this->table . " c
                      LEFT JOIN users u ON c.instructor_id = u.id
                      LEFT JOIN categories cat ON c.category_id = cat.id
                      WHERE c.status = 'pending' OR c.status IS NULL
                      ORDER BY c.created_at ASC";
        } else {
            // Nếu chưa có cột status, trả về tất cả khóa học mới nhất (giả định là chờ duyệt)
            $query = "SELECT c.*, u.fullname as instructor_name, u.email as instructor_email, 
                      cat.name as category_name
                      FROM " . $this->table . " c
                      LEFT JOIN users u ON c.instructor_id = u.id
                      LEFT JOIN categories cat ON c.category_id = cat.id
                      ORDER BY c.created_at DESC
                      LIMIT 20";
        }
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    // Phê duyệt khóa học
    public function approveCourse($id) {
        $hasStatus = $this->hasStatusColumn();
        
        if ($hasStatus) {
            $query = "UPDATE " . $this->table . " SET status = 'approved' WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } else {
            // Nếu chưa có cột status, chỉ cần trả về true (coi như đã duyệt)
            return true;
        }
    }

    // Từ chối khóa học
    public function rejectCourse($id) {
        $hasStatus = $this->hasStatusColumn();
        
        if ($hasStatus) {
            $query = "UPDATE " . $this->table . " SET status = 'rejected' WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } else {
            // Nếu chưa có cột status, xóa khóa học hoặc đánh dấu bằng cách khác
            // Tạm thời chỉ trả về true
            return true;
        }
    }

    // Lấy thống kê khóa học
    public function getStatistics() {
        $stats = [];
        $hasStatus = $this->hasStatusColumn();
        
        // Tổng số khóa học
        $query = "SELECT COUNT(*) as total FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();
        $stats['total_courses'] = $result['total'] ?? 0;
        
        if ($hasStatus) {
            // Khóa học đã duyệt
            $query = "SELECT COUNT(*) as total FROM " . $this->table . " WHERE status = 'approved'";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch();
            $stats['approved_courses'] = $result['total'] ?? 0;
            
            // Khóa học chờ duyệt
            $query = "SELECT COUNT(*) as total FROM " . $this->table . " WHERE status = 'pending' OR status IS NULL";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch();
            $stats['pending_courses'] = $result['total'] ?? 0;
            
            // Khóa học bị từ chối
            $query = "SELECT COUNT(*) as total FROM " . $this->table . " WHERE status = 'rejected'";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch();
            $stats['rejected_courses'] = $result['total'] ?? 0;
        } else {
            // Nếu chưa có cột status, coi tất cả là đã duyệt
            $stats['approved_courses'] = $stats['total_courses'];
            $stats['pending_courses'] = 0;
            $stats['rejected_courses'] = 0;
        }
        
        return $stats;
    }
}
?>

