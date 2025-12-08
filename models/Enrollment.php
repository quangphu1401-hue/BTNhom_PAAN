<?php
require_once __DIR__ . '/../config/Database.php';

class Enrollment {
    private $conn;
    private $table = 'enrollments';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Đăng ký khóa học
    public function enroll($course_id, $student_id) {
        // Kiểm tra đã đăng ký chưa
        if ($this->isEnrolled($course_id, $student_id)) {
            return false;
        }
        
        $query = "INSERT INTO " . $this->table . " (course_id, student_id, status, progress) 
                  VALUES (:course_id, :student_id, 'active', 0)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':course_id', $course_id);
        $stmt->bindParam(':student_id', $student_id);
        
        return $stmt->execute();
    }

    // Kiểm tra đã đăng ký chưa
    public function isEnrolled($course_id, $student_id) {
        $query = "SELECT id FROM " . $this->table . " 
                  WHERE course_id = :course_id AND student_id = :student_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':course_id', $course_id);
        $stmt->bindParam(':student_id', $student_id);
        $stmt->execute();
        
        return $stmt->rowCount() > 0;
    }

    // Lấy khóa học đã đăng ký của học viên
    public function getEnrolledCourses($student_id) {
        $query = "SELECT e.*, c.title, c.description, c.image, c.level, 
                  u.fullname as instructor_name, cat.name as category_name
                  FROM " . $this->table . " e
                  JOIN courses c ON e.course_id = c.id
                  LEFT JOIN users u ON c.instructor_id = u.id
                  LEFT JOIN categories cat ON c.category_id = cat.id
                  WHERE e.student_id = :student_id
                  ORDER BY e.enrolled_date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':student_id', $student_id);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    // Lấy danh sách học viên của khóa học
    public function getCourseStudents($course_id) {
        $query = "SELECT e.*, u.fullname, u.email, u.username
                  FROM " . $this->table . " e
                  JOIN users u ON e.student_id = u.id
                  WHERE e.course_id = :course_id
                  ORDER BY e.enrolled_date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':course_id', $course_id);
        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    // Cập nhật tiến độ
    public function updateProgress($enrollment_id, $progress) {
        $query = "UPDATE " . $this->table . " SET progress = :progress WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':progress', $progress);
        $stmt->bindParam(':id', $enrollment_id);
        
        return $stmt->execute();
    }

    // Cập nhật trạng thái
    public function updateStatus($enrollment_id, $status) {
        $query = "UPDATE " . $this->table . " SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $enrollment_id);
        
        return $stmt->execute();
    }

    // Lấy thông tin enrollment
    public function getEnrollment($course_id, $student_id) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE course_id = :course_id AND student_id = :student_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':course_id', $course_id);
        $stmt->bindParam(':student_id', $student_id);
        $stmt->execute();
        
        return $stmt->fetch();
    }
}
?>

