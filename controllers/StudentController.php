<?php
require_once __DIR__ . '/../config/helper.php';

class StudentController {
    
    public function dashboard() {
        requireRole('student');
        
        require_once __DIR__ . '/../models/Enrollment.php';
        $enrollmentModel = new Enrollment();
        $courses = $enrollmentModel->getEnrolledCourses(getUserId());
        
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/student/dashboard.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
}
?>

