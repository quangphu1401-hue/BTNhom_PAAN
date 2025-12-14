<?php
require_once __DIR__ . '/../config/helper.php';

class HomeController {
    
    public function index() {
        require_once __DIR__ . '/../models/Course.php';
        require_once __DIR__ . '/../models/Category.php';
        
        $courseModel = new Course();
        $categoryModel = new Category();
        
        // Lấy 6 khóa học mới nhất
        $latestCourses = $courseModel->getAll(6);
        $categories = $categoryModel->getAll();
        
        require_once __DIR__ . '/../views/layouts/header.php';
        require_once __DIR__ . '/../views/home/index.php';
        require_once __DIR__ . '/../views/layouts/footer.php';
    }
}
?>

