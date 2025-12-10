<?php
require_once __DIR__ . '/../config/helper.php';
require_once __DIR__ . '/../models/Course.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/Enrollment.php';
require_once __DIR__ . '/../models/Lesson.php';

class CourseController {
    
    // Hiển thị danh sách khóa học
    public function index() {
        $courseModel = new Course();
        $categoryModel = new Category();
        
        $keyword = sanitize($_GET['keyword'] ?? '');
        $category_id = isset($_GET['category']) && !empty($_GET['category']) ? (int)$_GET['category'] : null;
        $level = sanitize($_GET['level'] ?? '');
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 12;
        $offset = ($page - 1) * $limit;
        
        // Luôn dùng search để hỗ trợ filter
        $courses = $courseModel->search($keyword, $category_id, $level, $limit, $offset);
        
        $categories = $categoryModel->getAll();
        
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/courses/index.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
    
    // Xem chi tiết khóa học
    public function detail($id) {
        $courseModel = new Course();
        $enrollmentModel = new Enrollment();
        $lessonModel = new Lesson();
        
        $course = $courseModel->getById($id);
        
        if (!$course) {
            http_response_code(404);
            require_once __DIR__ . '/../views/errors/404.php';
            return;
        }
        
        $lessons = $lessonModel->getByCourse($id);
        $isEnrolled = false;
        
        if (isLoggedIn()) {
            $isEnrolled = $enrollmentModel->isEnrolled($id, getUserId());
        }
        
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/courses/detail.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
    
    // Đăng ký khóa học
    public function enroll($course_id) {
        requireAuth();
        requireRole('student');
        
        $enrollmentModel = new Enrollment();
        $courseModel = new Course();
        
        $course = $courseModel->getById($course_id);
        
        if (!$course) {
            http_response_code(404);
            require_once __DIR__ . '/../views/errors/404.php';
            return;
        }
        
        $student_id = getUserId();
        
        if ($enrollmentModel->enroll($course_id, $student_id)) {
            $_SESSION['success'] = 'Đăng ký khóa học thành công!';
            redirect('/onlinecourse/course/detail/' . $course_id);
        } else {
            $_SESSION['error'] = 'Đăng ký thất bại. Có thể bạn đã đăng ký khóa học này rồi.';
            redirect('/onlinecourse/course/detail/' . $course_id);
        }
    }
}
?>

