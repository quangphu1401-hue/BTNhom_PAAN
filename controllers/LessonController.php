<?php
require_once __DIR__ . '/../config/helper.php';
require_once __DIR__ . '/../models/Lesson.php';
require_once __DIR__ . '/../models/Course.php';
require_once __DIR__ . '/../models/Material.php';
require_once __DIR__ . '/../models/Enrollment.php';

class LessonController {
    
    // Xem bài học (cho học viên đã đăng ký)
    public function view($lesson_id) {
        requireAuth();
        
        $lessonModel = new Lesson();
        $materialModel = new Material();
        $enrollmentModel = new Enrollment();
        
        $lesson = $lessonModel->getById($lesson_id);
        
        if (!$lesson) {
            http_response_code(404);
            require_once __DIR__ . '/../views/errors/404.php';
            return;
        }
        
        // Kiểm tra quyền truy cập
        $user_id = getUserId();
        $userRole = $_SESSION['role'];
        
        // Instructor của khóa học hoặc admin có thể xem
        // Học viên phải đã đăng ký khóa học
        if ($userRole != 1 && $userRole != 2) {
            if (!$enrollmentModel->isEnrolled($lesson['course_id'], $user_id)) {
                $_SESSION['error'] = 'Bạn cần đăng ký khóa học để xem bài học này';
                redirect_to('course/detail/' . $lesson['course_id']);
                return;
            }
        } elseif ($userRole == 1 && $lesson['instructor_id'] != $user_id) {
            $_SESSION['error'] = 'Bạn không có quyền xem bài học này';
            redirect_to('home');
            return;
        }
        
        $materials = $materialModel->getByLesson($lesson_id);
        
        // Lấy danh sách bài học của khóa học
        require_once __DIR__ . '/../models/Lesson.php';
        $lessons = $lessonModel->getByCourse($lesson['course_id']);
        
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/student/lesson_view.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
}
?>

