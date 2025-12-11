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
        <a href="/onlinecourse/admin/users" class="btn btn-primary">Quản lý người dùng</a>
        <a href="/onlinecourse/admin/categories" class="btn btn-primary">Quản lý danh mục</a>
        <a href="/onlinecourse/admin/statistics" class="btn btn-primary">Thống kê</a>
    </div>
</div>

