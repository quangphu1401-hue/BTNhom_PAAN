<?php
$page_title = "Dashboard Admin";
?>

<div class="container">
    <h1>Dashboard Quản trị viên</h1>
    
    <div class="dashboard-stats">
        <div class="stat-card">
            <h3>Tổng số người dùng</h3>
            <p class="stat-number"><?php echo $totalUsers; ?></p>
        </div>
        <div class="stat-card">
            <h3>Tổng số khóa học</h3>
            <p class="stat-number"><?php echo $totalCourses; ?></p>
        </div>
    </div>
    
    <div class="admin-menu">
        <a href="<?php echo function_exists('url') ? url('admin/users') : (getBasePath() . '/index.php?url=admin/users'); ?>" class="btn btn-primary">Quản lý người dùng</a>
        <a href="<?php echo function_exists('url') ? url('admin/categories') : (getBasePath() . '/index.php?url=admin/categories'); ?>" class="btn btn-primary">Quản lý danh mục</a>
        <a href="<?php echo function_exists('url') ? url('admin/statistics') : (getBasePath() . '/index.php?url=admin/statistics'); ?>" class="btn btn-primary">Thống kê hệ thống</a>
        <a href="<?php echo function_exists('url') ? url('admin/approveCourses') : (getBasePath() . '/index.php?url=admin/approveCourses'); ?>" class="btn btn-warning">Duyệt khóa học</a>
    </div>
</div>

