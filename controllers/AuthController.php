<?php
require_once __DIR__ . '/../config/helper.php';
require_once __DIR__ . '/../models/User.php';

class AuthController {
    
    public function login() {
        if (isLoggedIn()) {
            $base_path = getBasePath();
            redirect($base_path . '/index.php?url=home');
            return;
        }
        
        $error = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = sanitize($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            
            if (empty($email) || empty($password)) {
                $error = 'Vui lòng điền đầy đủ thông tin';
            } else {
                $userModel = new User();
                $user = $userModel->login($email, $password);
                
                if ($user) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['fullname'] = $user['fullname'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['email'] = $user['email'];
                    
                    $base_path = getBasePath();
                    // Redirect based on role
                    if ($user['role'] == 1) {
                        redirect($base_path . '/index.php?url=instructor/dashboard');
                    } elseif ($user['role'] == 2) {
                        redirect($base_path . '/index.php?url=admin/dashboard');
                    } else {
                        redirect($base_path . '/index.php?url=student/dashboard');
                    }
                    return;
                } else {
                    $error = 'Email hoặc mật khẩu không đúng';
                }
            }
        }
        
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/auth/login.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
    
    public function register() {
        if (isLoggedIn()) {
            $base_path = getBasePath();
            redirect($base_path . '/index.php?url=home');
            return;
        }
        
        $error = '';
        $success = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = sanitize($_POST['username'] ?? '');
            $email = sanitize($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            $fullname = sanitize($_POST['fullname'] ?? '');
            $role = isset($_POST['role']) ? (int)$_POST['role'] : 0;
            
            // Validate
            if (empty($username) || empty($email) || empty($password) || empty($fullname)) {
                $error = 'Vui lòng điền đầy đủ thông tin';
            } elseif ($password !== $confirm_password) {
                $error = 'Mật khẩu xác nhận không khớp';
            } elseif (strlen($password) < 6) {
                $error = 'Mật khẩu phải có ít nhất 6 ký tự';
            } else {
                $userModel = new User();
                
                // Kiểm tra email và username đã tồn tại
                if ($userModel->emailExists($email)) {
                    $error = 'Email đã được sử dụng';
                } elseif ($userModel->usernameExists($username)) {
                    $error = 'Username đã được sử dụng';
                } else {
                    // Chỉ cho phép đăng ký role 0 (học viên) hoặc 1 (giảng viên)
                    // Admin chỉ có thể tạo từ admin panel
                    if ($role > 1) {
                        $role = 0;
                    }
                    
                    $user_id = $userModel->register($username, $email, $password, $fullname, $role);
                    
                    if ($user_id) {
                        $success = 'Đăng ký thành công! Vui lòng đăng nhập.';
                        // Redirect to login after 2 seconds
                        $base_path = getBasePath();
                        header('Refresh: 2; url=' . $base_path . '/index.php?url=auth/login');
                    } else {
                        $error = 'Đăng ký thất bại. Vui lòng thử lại.';
                    }
                }
            }
        }
        
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/auth/register.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
    
    public function logout() {
        session_destroy();
        $base_path = getBasePath();
        redirect($base_path . '/index.php?url=home');
    }
}
?>

