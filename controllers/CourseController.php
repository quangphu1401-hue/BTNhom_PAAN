<?php
require_once __DIR__ . '/../config/helper.php';
require_once __DIR__ . '/../models/Course.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/Enrollment.php';
require_once __DIR__ . '/../models/Lesson.php';

class CourseController {

    // =========================
    // Danh sách khóa học
    // =========================
    public function index() {
        $courseModel   = new Course();
        $categoryModel = new Category();

        $keyword     = sanitize($_GET['keyword'] ?? '');
        $category_id = isset($_GET['category']) && $_GET['category'] !== '' ? (int)$_GET['category'] : null;
        $level       = sanitize($_GET['level'] ?? '');

        $page   = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $limit  = 12;
        $offset = ($page - 1) * $limit;

        // Lấy danh sách khóa học (có filter)
        $courses    = $courseModel->search($keyword, $category_id, $level, $limit, $offset);
        $categories = $categoryModel->getAll();

        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/courses/index.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }

    // =========================
    // Chi tiết khóa học
    // =========================
    public function detail() {

        // 👉 LẤY ID TỪ QUERY STRING
        $id = $_GET['id'] ?? null;

        if (!$id) {
            http_response_code(404);
            require_once __DIR__ . '/../views/errors/404.php';
            return;
        }

        $courseModel     = new Course();
        $enrollmentModel = new Enrollment();
        $lessonModel     = new Lesson();

        $course = $courseModel->getById($id);

        if (!$course) {
            http_response_code(404);
            require_once __DIR__ . '/../views/errors/404.php';
            return;
        }

        $lessons    = $lessonModel->getByCourse($id);
        $isEnrolled = false;

        if (isLoggedIn()) {
            $isEnrolled = $enrollmentModel->isEnrolled($id, getUserId());
        }

        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/courses/detail.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }

    // =========================
    // Đăng ký khóa học
    // =========================
    public function enroll() {
        requireAuth();
        requireRole('student');

        // 👉 LẤY ID TỪ QUERY STRING
        $course_id = $_GET['id'] ?? null;

        if (!$course_id) {
            http_response_code(404);
            require_once __DIR__ . '/../views/errors/404.php';
            return;
        }

        $courseModel     = new Course();
        $enrollmentModel = new Enrollment();

        $course = $courseModel->getById($course_id);

        if (!$course) {
            http_response_code(404);
            require_once __DIR__ . '/../views/errors/404.php';
            return;
        }

        $student_id = getUserId();

        if ($enrollmentModel->enroll($course_id, $student_id)) {
            $_SESSION['success'] = 'Đăng ký khóa học thành công!';
        } else {
            $_SESSION['error'] = 'Bạn đã đăng ký khóa học này rồi!';
        }

        // 👉 Redirect đúng theo router hiện tại (KHÔNG dùng URL đẹp)
        redirect('/BTNhom_PAAN/index.php?url=course/detail&id=' . $course_id);
    }
}
