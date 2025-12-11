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
        $users = $userModel->getAllUsers();
        
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
            
            redirect_to('admin/categories');
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
        
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/admin/reports/statistics.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
}
?>

