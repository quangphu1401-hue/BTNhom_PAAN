<?php
require_once __DIR__ . '/../config/helper.php';
require_once __DIR__ . '/../models/Course.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/Lesson.php';
require_once __DIR__ . '/../models/Material.php';
require_once __DIR__ . '/../models/Enrollment.php';

class InstructorController {
    
    public function dashboard() {
        requireRole('instructor');
        
        $courseModel = new Course();
        $courses = $courseModel->getByInstructor(getUserId());
        
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/instructor/dashboard.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
    
    // Danh sách khóa học của giảng viên
    public function myCourses() {
        requireRole('instructor');
        
        $courseModel = new Course();
        $courses = $courseModel->getByInstructor(getUserId());
        
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/instructor/my_courses.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
    
    // Tạo khóa học mới
    public function createCourse() {
        requireRole('instructor');
        
        $categoryModel = new Category();
        $categories = $categoryModel->getAll();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $courseModel = new Course();
            
            // Handle file upload
            $image = '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $upload_dir = __DIR__ . '/../assets/uploads/courses/';
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }
                
                $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
                
                if (in_array(strtolower($file_extension), $allowed_extensions)) {
                    $new_filename = uniqid() . '_' . time() . '.' . $file_extension;
                    $upload_path = $upload_dir . $new_filename;
                    
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                        $image = 'assets/uploads/courses/' . $new_filename;
                    }
                }
            }
            
            $data = [
                'title' => sanitize($_POST['title'] ?? ''),
                'description' => sanitize($_POST['description'] ?? ''),
                'instructor_id' => getUserId(),
                'category_id' => isset($_POST['category_id']) ? (int)$_POST['category_id'] : null,
                'price' => isset($_POST['price']) ? (float)$_POST['price'] : 0,
                'duration_weeks' => isset($_POST['duration_weeks']) ? (int)$_POST['duration_weeks'] : null,
                'level' => sanitize($_POST['level'] ?? 'Beginner'),
                'image' => $image
            ];
            
            $course_id = $courseModel->create($data);
            
            if ($course_id) {
                $_SESSION['success'] = 'Tạo khóa học thành công!';
                redirect('/onlinecourse/instructor/course/manage/' . $course_id);
            } else {
                $_SESSION['error'] = 'Tạo khóa học thất bại. Vui lòng thử lại.';
            }
        }
        
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/instructor/course/create.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
    
    // Chỉnh sửa khóa học
    public function editCourse($course_id) {
        requireRole('instructor');
        
        $courseModel = new Course();
        $categoryModel = new Category();
        
        $course = $courseModel->getById($course_id);
        
        if (!$course || $course['instructor_id'] != getUserId()) {
            http_response_code(403);
            echo 'Bạn không có quyền chỉnh sửa khóa học này';
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Handle file upload if new image provided
            $image = $course['image'];
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $upload_dir = __DIR__ . '/../assets/uploads/courses/';
                $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
                
                if (in_array(strtolower($file_extension), $allowed_extensions)) {
                    $new_filename = uniqid() . '_' . time() . '.' . $file_extension;
                    $upload_path = $upload_dir . $new_filename;
                    
                    if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                        // Delete old image
                        if ($image && file_exists(__DIR__ . '/../' . $image)) {
                            unlink(__DIR__ . '/../' . $image);
                        }
                        $image = 'assets/uploads/courses/' . $new_filename;
                    }
                }
            }
            
            $data = [
                'title' => sanitize($_POST['title'] ?? ''),
                'description' => sanitize($_POST['description'] ?? ''),
                'category_id' => isset($_POST['category_id']) ? (int)$_POST['category_id'] : null,
                'price' => isset($_POST['price']) ? (float)$_POST['price'] : 0,
                'duration_weeks' => isset($_POST['duration_weeks']) ? (int)$_POST['duration_weeks'] : null,
                'level' => sanitize($_POST['level'] ?? 'Beginner'),
                'image' => $image
            ];
            
            if ($courseModel->update($course_id, $data)) {
                $_SESSION['success'] = 'Cập nhật khóa học thành công!';
                redirect('/onlinecourse/instructor/course/manage/' . $course_id);
            } else {
                $_SESSION['error'] = 'Cập nhật khóa học thất bại.';
            }
        }
        
        $categories = $categoryModel->getAll();
        
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/instructor/course/edit.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
    
    // Quản lý khóa học
    public function manageCourse($course_id) {
        requireRole('instructor');
        
        $courseModel = new Course();
        $lessonModel = new Lesson();
        $enrollmentModel = new Enrollment();
        
        $course = $courseModel->getById($course_id);
        
        if (!$course || $course['instructor_id'] != getUserId()) {
            http_response_code(403);
            echo 'Bạn không có quyền quản lý khóa học này';
            return;
        }
        
        $lessons = $lessonModel->getByCourse($course_id);
        $students = $enrollmentModel->getCourseStudents($course_id);
        
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/instructor/course/manage.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
    
    // Xóa khóa học
    public function deleteCourse($course_id) {
        requireRole('instructor');
        
        $courseModel = new Course();
        $course = $courseModel->getById($course_id);
        
        if (!$course || $course['instructor_id'] != getUserId()) {
            http_response_code(403);
            echo 'Bạn không có quyền xóa khóa học này';
            return;
        }
        
        if ($courseModel->delete($course_id)) {
            $_SESSION['success'] = 'Xóa khóa học thành công!';
        } else {
            $_SESSION['error'] = 'Xóa khóa học thất bại.';
        }
        
        redirect('/onlinecourse/instructor/myCourses');
    }
    
    // Quản lý bài học - xử lý cả nested routes: instructor/lessons/{course_id} và instructor/lessons/{action}/{id}
    public function lessons($course_id_or_action = null, $id = null) {
        requireRole('instructor');
        
        // Nếu có 2 tham số, đó là action và id (route: instructor/lessons/{action}/{id})
        if ($id !== null) {
            $action = $course_id_or_action;
            switch ($action) {
                case 'edit':
                    if ($id) {
                        $this->editLesson($id);
                    } else {
                        http_response_code(404);
                        require_once __DIR__ . '/../views/errors/404.php';
                    }
                    return;
                case 'delete':
                    if ($id) {
                        $this->deleteLesson($id);
                    } else {
                        http_response_code(404);
                        require_once __DIR__ . '/../views/errors/404.php';
                    }
                    return;
                default:
                    http_response_code(404);
                    require_once __DIR__ . '/../views/errors/404.php';
                    return;
            }
        }
        
        // Nếu chỉ có 1 tham số, đó là course_id (route: instructor/lessons/{course_id})
        $course_id = $course_id_or_action;
        
        if (!$course_id || !is_numeric($course_id)) {
            http_response_code(404);
            require_once __DIR__ . '/../views/errors/404.php';
            return;
        }
        
        $courseModel = new Course();
        $lessonModel = new Lesson();
        
        $course = $courseModel->getById($course_id);
        
        if (!$course || $course['instructor_id'] != getUserId()) {
            http_response_code(403);
            echo 'Bạn không có quyền quản lý bài học của khóa học này';
            return;
        }
        
        $lessons = $lessonModel->getByCourse($course_id);
        
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/instructor/lessons/manage.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
    
    // Tạo bài học mới
    public function createLesson($course_id) {
        requireRole('instructor');
        
        $courseModel = new Course();
        $course = $courseModel->getById($course_id);
        
        if (!$course || $course['instructor_id'] != getUserId()) {
            http_response_code(403);
            echo 'Bạn không có quyền tạo bài học cho khóa học này';
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $lessonModel = new Lesson();
            
            $data = [
                'course_id' => $course_id,
                'title' => sanitize($_POST['title'] ?? ''),
                'content' => $_POST['content'] ?? '',
                'video_url' => sanitize($_POST['video_url'] ?? ''),
                'order' => isset($_POST['order']) ? (int)$_POST['order'] : 0
            ];
            
            $lesson_id = $lessonModel->create($data);
            
            if ($lesson_id) {
                $_SESSION['success'] = 'Tạo bài học thành công!';
                redirect('/onlinecourse/instructor/lessons/' . $course_id);
            } else {
                $_SESSION['error'] = 'Tạo bài học thất bại.';
            }
        }
        
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/instructor/lessons/create.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
    
    // Chỉnh sửa bài học
    public function editLesson($lesson_id) {
        requireRole('instructor');
        
        $lessonModel = new Lesson();
        $lesson = $lessonModel->getById($lesson_id);
        
        if (!$lesson) {
            http_response_code(404);
            require_once __DIR__ . '/../views/errors/404.php';
            return;
        }
        
        $courseModel = new Course();
        $course = $courseModel->getById($lesson['course_id']);
        
        if ($course['instructor_id'] != getUserId()) {
            http_response_code(403);
            echo 'Bạn không có quyền chỉnh sửa bài học này';
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => sanitize($_POST['title'] ?? ''),
                'content' => $_POST['content'] ?? '',
                'video_url' => sanitize($_POST['video_url'] ?? ''),
                'order' => isset($_POST['order']) ? (int)$_POST['order'] : 0
            ];
            
            if ($lessonModel->update($lesson_id, $data)) {
                $_SESSION['success'] = 'Cập nhật bài học thành công!';
                redirect('/onlinecourse/instructor/lessons/' . $lesson['course_id']);
            } else {
                $_SESSION['error'] = 'Cập nhật bài học thất bại.';
            }
        }
        
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/instructor/lessons/edit.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
    
    // Xóa bài học
    public function deleteLesson($lesson_id) {
        requireRole('instructor');
        
        $lessonModel = new Lesson();
        $lesson = $lessonModel->getById($lesson_id);
        
        if (!$lesson) {
            http_response_code(404);
            return;
        }
        
        $courseModel = new Course();
        $course = $courseModel->getById($lesson['course_id']);
        
        if ($course['instructor_id'] != getUserId()) {
            http_response_code(403);
            return;
        }
        
        if ($lessonModel->delete($lesson_id)) {
            $_SESSION['success'] = 'Xóa bài học thành công!';
        } else {
            $_SESSION['error'] = 'Xóa bài học thất bại.';
        }
        
        redirect('/onlinecourse/instructor/lessons/' . $lesson['course_id']);
    }
    
    // Đăng tải tài liệu
    public function uploadMaterial($lesson_id) {
        requireRole('instructor');
        
        $lessonModel = new Lesson();
        $materialModel = new Material();
        
        $lesson = $lessonModel->getById($lesson_id);
        
        if (!$lesson) {
            http_response_code(404);
            return;
        }
        
        $courseModel = new Course();
        $course = $courseModel->getById($lesson['course_id']);
        
        if ($course['instructor_id'] != getUserId()) {
            http_response_code(403);
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
            if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
                $upload_dir = __DIR__ . '/../assets/uploads/materials/';
                if (!file_exists($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }
                
                $file_extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                $allowed_extensions = ['pdf', 'doc', 'docx', 'ppt', 'pptx', 'txt', 'zip', 'rar'];
                
                if (in_array(strtolower($file_extension), $allowed_extensions)) {
                    $new_filename = uniqid() . '_' . time() . '.' . $file_extension;
                    $upload_path = $upload_dir . $new_filename;
                    
                    if (move_uploaded_file($_FILES['file']['tmp_name'], $upload_path)) {
                        $file_path = 'assets/uploads/materials/' . $new_filename;
                        $file_type = strtolower($file_extension);
                        
                        if ($materialModel->create($lesson_id, $_FILES['file']['name'], $file_path, $file_type)) {
                            $_SESSION['success'] = 'Đăng tải tài liệu thành công!';
                        } else {
                            $_SESSION['error'] = 'Đăng tải tài liệu thất bại.';
                        }
                    }
                } else {
                    $_SESSION['error'] = 'Định dạng file không được hỗ trợ.';
                }
            }
            
            redirect('/onlinecourse/instructor/lessons/' . $lesson['course_id']);
            return;
        }
        
        $materials = $materialModel->getByLesson($lesson_id);
        
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/instructor/materials/upload.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
    
    // Xem danh sách học viên - xử lý cả nested routes: instructor/students/{course_id} và instructor/students/{action}/{id}
    public function students($course_id_or_action = null, $id = null) {
        requireRole('instructor');
        
        // Nếu có 2 tham số, đó là action và id (route: instructor/students/{action}/{id})
        if ($id !== null) {
            $action = $course_id_or_action;
            switch ($action) {
                case 'edit':
                    if ($id) {
                        $this->editStudent($id);
                    } else {
                        http_response_code(404);
                        require_once __DIR__ . '/../views/errors/404.php';
                    }
                    return;
                default:
                    http_response_code(404);
                    require_once __DIR__ . '/../views/errors/404.php';
                    return;
            }
        }
        
        // Nếu chỉ có 1 tham số, đó là course_id (route: instructor/students/{course_id})
        $course_id = $course_id_or_action;
        
        if (!$course_id || !is_numeric($course_id)) {
            http_response_code(404);
            require_once __DIR__ . '/../views/errors/404.php';
            return;
        }
        
        $courseModel = new Course();
        $enrollmentModel = new Enrollment();
        
        $course = $courseModel->getById($course_id);
        
        if (!$course || $course['instructor_id'] != getUserId()) {
            http_response_code(403);
            echo 'Bạn không có quyền xem danh sách học viên của khóa học này';
            return;
        }
        
        $students = $enrollmentModel->getCourseStudents($course_id);
        
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/instructor/students/list.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
    
    // Xử lý nested routes: instructor/course/{action}/{id}
    public function course() {
        requireRole('instructor');
        
        // Lấy params từ arguments
        $args = func_get_args();
        $action = isset($args[0]) ? $args[0] : '';
        $id = isset($args[1]) ? $args[1] : null;
        
        switch ($action) {
            case 'edit':
                if ($id) {
                    $this->editCourse($id);
                } else {
                    http_response_code(404);
                    require_once __DIR__ . '/../views/errors/404.php';
                }
                break;
            case 'manage':
                if ($id) {
                    $this->manageCourse($id);
                } else {
                    http_response_code(404);
                    require_once __DIR__ . '/../views/errors/404.php';
                }
                break;
            case 'delete':
                if ($id) {
                    $this->deleteCourse($id);
                } else {
                    http_response_code(404);
                    require_once __DIR__ . '/../views/errors/404.php';
                }
                break;
            default:
                http_response_code(404);
                require_once __DIR__ . '/../views/errors/404.php';
        }
    }
    
    // Chỉnh sửa thông tin học viên (tiến độ, trạng thái)
    public function editStudent($enrollment_id) {
        requireRole('instructor');
        
        $enrollmentModel = new Enrollment();
        $enrollment = $enrollmentModel->getById($enrollment_id);
        
        if (!$enrollment) {
            http_response_code(404);
            require_once __DIR__ . '/../views/errors/404.php';
            return;
        }
        
        // Kiểm tra quyền - chỉ giảng viên của khóa học mới được chỉnh sửa
        if ($enrollment['instructor_id'] != getUserId()) {
            http_response_code(403);
            echo 'Bạn không có quyền chỉnh sửa thông tin học viên này';
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'progress' => isset($_POST['progress']) ? (int)$_POST['progress'] : 0,
                'status' => sanitize($_POST['status'] ?? 'active')
            ];
            
            // Validate progress (0-100)
            if ($data['progress'] < 0) $data['progress'] = 0;
            if ($data['progress'] > 100) $data['progress'] = 100;
            
            // Validate status
            $allowed_statuses = ['active', 'completed', 'dropped'];
            if (!in_array($data['status'], $allowed_statuses)) {
                $data['status'] = 'active';
            }
            
            if ($enrollmentModel->update($enrollment_id, $data)) {
                $_SESSION['success'] = 'Cập nhật thông tin học viên thành công!';
                redirect('/onlinecourse/instructor/students/' . $enrollment['course_id']);
            } else {
                $_SESSION['error'] = 'Cập nhật thông tin học viên thất bại.';
            }
        }
        
        $courseModel = new Course();
        $course = $courseModel->getById($enrollment['course_id']);
        
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/instructor/students/edit.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
}
?>

