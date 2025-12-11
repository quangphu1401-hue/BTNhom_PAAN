<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - ' : ''; ?>Online Course</title>
    <link rel="stylesheet" href="<?php echo getBasePath(); ?>/assets/css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="nav-brand">
                <a href="<?php echo url('home'); ?>">Online Course</a>
            </div>
            <ul class="nav-menu">
                <li><a href="<?php echo url('home'); ?>">Trang chủ</a></li>
                <li><a href="<?php echo url('course'); ?>">Khóa học</a></li>
                <?php if (isLoggedIn()): ?>
                    <?php if (hasRole('student')): ?>
                        <li><a href="<?php echo url('student/dashboard'); ?>">Dashboard</a></li>
                        <li><a href="<?php echo url('enrollment/myCourses'); ?>">Khóa học của tôi</a></li>
                    <?php elseif (hasRole('instructor')): ?>
                        <li><a href="<?php echo url('instructor/dashboard'); ?>">Dashboard</a></li>
                        <li><a href="<?php echo url('instructor/myCourses'); ?>">Khóa học của tôi</a></li>
                    <?php elseif (hasRole('admin')): ?>
                        <li><a href="<?php echo url('admin/dashboard'); ?>">Dashboard</a></li>
                        <li><a href="<?php echo url('admin/users'); ?>">Quản lý</a></li>
                    <?php endif; ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle">
                            <?php echo htmlspecialchars($_SESSION['fullname'] ?? $_SESSION['username']); ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo url('auth/logout'); ?>">Đăng xuất</a></li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li><a href="<?php echo url('auth/login'); ?>">Đăng nhập</a></li>
                    <li><a href="<?php echo url('auth/register'); ?>">Đăng ký</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error">
            <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <main class="main-content">
