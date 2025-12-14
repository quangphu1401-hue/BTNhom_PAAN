<?php
require_once __DIR__ . '/../config/helper.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/Course.php';
require_once __DIR__ . '/../models/Enrollment.php';

class AdminController {
    
    public function dashboard() {
        requireRole('admin');
        
        // Lấy thống kê
        $userModel = new User();
        $courseModel = new Course();
        $enrollmentModel = new Enrollment();
        
        $totalUsers = count($userModel->getAllUsers());
        $totalCourses = count($courseModel->getAll());
        
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/admin/dashboard.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
    
    // Quản lý người dùng
    public function users() {
        requireRole('admin');
        
        $userModel = new User();
        $error = '';
        $success = '';
        
        // Hiển thị thông báo từ session
        if (isset($_SESSION['success'])) {
            $success = $_SESSION['success'];
            unset($_SESSION['success']);
        }
        
        // Xử lý POST requests
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';
            
            if ($action === 'create') {
                $username = sanitize($_POST['username'] ?? '');
                $email = sanitize($_POST['email'] ?? '');
                $password = $_POST['password'] ?? '';
                $fullname = sanitize($_POST['fullname'] ?? '');
                $role = (int)($_POST['role'] ?? 0);
                
                // Validation
                if (empty($username) || empty($email) || empty($password) || empty($fullname)) {
                    $error = 'Vui lòng điền đầy đủ thông tin';
                } elseif (strlen($password) < 6) {
                    $error = 'Mật khẩu phải có ít nhất 6 ký tự';
                } elseif ($userModel->emailExists($email)) {
                    $error = 'Email đã được sử dụng';
                } elseif ($userModel->usernameExists($username)) {
                    $error = 'Username đã được sử dụng';
                } else {
                    $user_id = $userModel->register($username, $email, $password, $fullname, $role);
                    if ($user_id) {
                        $_SESSION['success'] = 'Thêm người dùng thành công';
                        redirect(url('admin/users'));
                        return;
                    } else {
                        $error = 'Thêm người dùng thất bại';
                    }
                }
            } elseif ($action === 'update') {
                $id = (int)$_POST['id'];
                $username = sanitize($_POST['username'] ?? '');
                $email = sanitize($_POST['email'] ?? '');
                $password = $_POST['password'] ?? '';
                $fullname = sanitize($_POST['fullname'] ?? '');
                $role = (int)($_POST['role'] ?? 0);
                
                // Validation
                if (empty($username) || empty($email) || empty($fullname)) {
                    $error = 'Vui lòng điền đầy đủ thông tin';
                } elseif ($userModel->emailExistsExcept($email, $id)) {
                    $error = 'Email đã được sử dụng bởi người dùng khác';
                } elseif ($userModel->usernameExistsExcept($username, $id)) {
                    $error = 'Username đã được sử dụng bởi người dùng khác';
                } else {
                    $data = [
                        'username' => $username,
                        'email' => $email,
                        'fullname' => $fullname,
                        'role' => $role
                    ];
                    
                    // Chỉ cập nhật password nếu có nhập
                    if (!empty($password)) {
                        if (strlen($password) < 6) {
                            $error = 'Mật khẩu phải có ít nhất 6 ký tự';
                        } else {
                            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
                        }
                    }
                    
                    if (empty($error)) {
                        if ($userModel->updateUser($id, $data)) {
                            $_SESSION['success'] = 'Cập nhật người dùng thành công';
                            redirect(url('admin/users'));
                            return;
                        } else {
                            $error = 'Cập nhật người dùng thất bại';
                        }
                    }
                }
            } elseif ($action === 'delete') {
                $id = (int)$_POST['id'];
                
                // Không cho phép xóa chính mình
                if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $id) {
                    $error = 'Không thể xóa chính tài khoản của bạn';
                } else {
                    if ($userModel->deleteUser($id)) {
                        $_SESSION['success'] = 'Xóa người dùng thành công';
                        redirect(url('admin/users'));
                        return;
                    } else {
                        $error = 'Xóa người dùng thất bại';
                    }
                }
            }
        }
        
        // Lấy danh sách users
        $users = $userModel->getAllUsers();
        
        // Lấy user để edit (nếu có)
        $editUser = null;
        if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
            $editUser = $userModel->getUserById((int)$_GET['edit']);
        }
        
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/admin/users/manage.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
    
    // Quản lý danh mục
    public function categories() {
        requireRole('admin');
        
        $categoryModel = new Category();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';
            
            if ($action === 'create') {
                $name = sanitize($_POST['name'] ?? '');
                $description = sanitize($_POST['description'] ?? '');
                
                if ($name) {
                    $categoryModel->create($name, $description);
                    $_SESSION['success'] = 'Tạo danh mục thành công';
                }
            } elseif ($action === 'update') {
                $id = (int)$_POST['id'];
                $name = sanitize($_POST['name'] ?? '');
                $description = sanitize($_POST['description'] ?? '');
                
                if ($name) {
                    $categoryModel->update($id, $name, $description);
                    $_SESSION['success'] = 'Cập nhật danh mục thành công';
                }
            } elseif ($action === 'delete') {
                $id = (int)$_POST['id'];
                $categoryModel->delete($id);
                $_SESSION['success'] = 'Xóa danh mục thành công';
            }
            
            redirect('/onlinecourse/admin/categories');
            return;
        }
        
        $categories = $categoryModel->getAll();
        
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/admin/categories/list.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
    
    // Thống kê
    public function statistics() {
        requireRole('admin');
        
        require_once __DIR__ . '/../config/Database.php';
        $userModel = new User();
        $courseModel = new Course();
        $enrollmentModel = new Enrollment();
        require_once __DIR__ . '/../models/Lesson.php';
        $lessonModel = new Lesson();
        
        $database = new Database();
        $conn = $database->getConnection();
        
        // Thống kê người dùng
        $allUsers = $userModel->getAllUsers(1000);
        $totalUsers = count($allUsers);
        $totalStudents = count(array_filter($allUsers, function($u) { return $u['role'] == 0; }));
        $totalInstructors = count(array_filter($allUsers, function($u) { return $u['role'] == 1; }));
        $totalAdmins = count(array_filter($allUsers, function($u) { return $u['role'] == 2; }));
        
        // Thống kê khóa học
        $courseStats = $courseModel->getStatistics();
        $allCourses = $courseModel->getAll(1000);
        $totalCourses = count($allCourses);
        
        // Thống kê đăng ký
        $query = "SELECT * FROM enrollments ORDER BY enrolled_date DESC";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $allEnrollments = $stmt->fetchAll();
        $totalEnrollments = count($allEnrollments);
        
        // Thống kê bài học
        $query = "SELECT COUNT(*) as total FROM lessons";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();
        $totalLessons = $result['total'] ?? 0;
        
        // Thống kê theo tháng (đăng ký mới)
        $monthlyEnrollments = [];
        foreach ($allEnrollments as $enrollment) {
            $date = $enrollment['enrolled_date'] ?? date('Y-m-d');
            $month = date('Y-m', strtotime($date));
            if (!isset($monthlyEnrollments[$month])) {
                $monthlyEnrollments[$month] = 0;
            }
            $monthlyEnrollments[$month]++;
        }
        ksort($monthlyEnrollments);
        
        // Thống kê khóa học theo danh mục
        $query = "SELECT cat.name, COUNT(c.id) as count 
                  FROM courses c 
                  LEFT JOIN categories cat ON c.category_id = cat.id 
                  GROUP BY cat.id, cat.name";
        $stmt = $conn->prepare($query);
        $stmt->execute();
        $coursesByCategory = $stmt->fetchAll();
        
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/admin/reports/statistics.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
    
    // Duyệt phê duyệt khóa học
    public function approveCourses() {
        requireRole('admin');
        
        $courseModel = new Course();
        $error = '';
        $success = '';
        
        // Hiển thị thông báo từ session
        if (isset($_SESSION['success'])) {
            $success = $_SESSION['success'];
            unset($_SESSION['success']);
        }
        
        if (isset($_SESSION['error'])) {
            $error = $_SESSION['error'];
            unset($_SESSION['error']);
        }
        
        // Xử lý POST requests
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';
            $course_id = (int)($_POST['course_id'] ?? 0);
            
            if ($action === 'approve' && $course_id) {
                if ($courseModel->approveCourse($course_id)) {
                    $_SESSION['success'] = 'Phê duyệt khóa học thành công';
                } else {
                    $_SESSION['error'] = 'Phê duyệt khóa học thất bại';
                }
                redirect(function_exists('url') ? url('admin/approveCourses') : (getBasePath() . '/index.php?url=admin/approveCourses'));
                return;
            } elseif ($action === 'reject' && $course_id) {
                if ($courseModel->rejectCourse($course_id)) {
                    $_SESSION['success'] = 'Từ chối khóa học thành công';
                } else {
                    $_SESSION['error'] = 'Từ chối khóa học thất bại';
                }
                redirect(function_exists('url') ? url('admin/approveCourses') : (getBasePath() . '/index.php?url=admin/approveCourses'));
                return;
            }
        }
        
        // Lấy danh sách khóa học chờ duyệt
        $pendingCourses = $courseModel->getPendingCourses();
        
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/admin/courses/approve.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
}
?>

