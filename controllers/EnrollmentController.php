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
        
        $enrollmentModel = new Enrollment();
        $courseModel = new Course();
        
        $course = $courseModel->getById($course_id);
        $enrollment = $enrollmentModel->getEnrollment($course_id, getUserId());
        
        if (!$course || !$enrollment) {
            http_response_code(404);
            require_once __DIR__ . '/../views/errors/404.php';
            return;
        }
        
        require_once __DIR__ . '/../models/Lesson.php';
        $lessonModel = new Lesson();
        $lessons = $lessonModel->getByCourse($course_id);
        
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/student/course_progress.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
}
?>

