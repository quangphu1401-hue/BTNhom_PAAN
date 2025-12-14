<?php
require_once __DIR__ . '/../config/helper.php';
require_once __DIR__ . '/../models/Enrollment.php';
require_once __DIR__ . '/../models/Course.php';

class EnrollmentController {
    
    // Danh sách khóa học đã đăng ký của học viên
    public function myCourses() {
        requireAuth();
        requireRole('student');
        
        $enrollmentModel = new Enrollment();
        $courses = $enrollmentModel->getEnrolledCourses(getUserId());
        
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/student/my_courses.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
    
    // Xem tiến độ học tập
    public function progress($course_id) {
        requireAuth();
        requireRole('student');
        
        // Đảm bảo course_id là số
        $course_id = (int)$course_id;
        if (!$course_id) {
            $_SESSION['error'] = 'Khóa học không tồn tại.';
            redirect(function_exists('url') ? url('enrollment/myCourses') : (getBasePath() . '/index.php?url=enrollment/myCourses'));
            return;
        }
        
        $enrollmentModel = new Enrollment();
        $courseModel = new Course();
        
        $course = $courseModel->getById($course_id);
        $enrollment = $enrollmentModel->getEnrollment($course_id, getUserId());
        
        if (!$course) {
            $_SESSION['error'] = 'Khóa học không tồn tại.';
            redirect(function_exists('url') ? url('enrollment/myCourses') : (getBasePath() . '/index.php?url=enrollment/myCourses'));
            return;
        }
        
        if (!$enrollment) {
            $_SESSION['error'] = 'Bạn chưa đăng ký khóa học này.';
            redirect(function_exists('url') ? url('course/detail/' . $course_id) : (getBasePath() . '/index.php?url=course/detail/' . $course_id));
            return;
        }
        
        require_once __DIR__ . '/../models/Lesson.php';
        require_once __DIR__ . '/../models/Material.php';
        
        $lessonModel = new Lesson();
        $materialModel = new Material();
        
        $lessons = $lessonModel->getByCourse($course_id);
        $materials = $materialModel->getByCourse($course_id);
        
        // Đảm bảo $materials là array
        if (!is_array($materials)) {
            $materials = [];
        }
        
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/student/course_progress.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
}
?>

