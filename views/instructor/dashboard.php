<?php
$page_title = "Dashboard Giảng viên";
?>

<div class="container">
    <h1>Dashboard Giảng viên</h1>
    
    <div class="dashboard-stats">
        <div class="stat-card">
            <h3>Số khóa học</h3>
            <p class="stat-number"><?php echo count($courses); ?></p>
        </div>
    </div>
    
    <div class="action-buttons">
        <a href="/onlinecourse/instructor/createCourse" class="btn btn-primary">Tạo khóa học mới</a>
        <a href="/onlinecourse/instructor/myCourses" class="btn btn-secondary">Xem tất cả khóa học</a>
    </div>
    
    <h2>Khóa học của tôi</h2>
    <div class="courses-grid">
        <?php if (!empty($courses)): ?>
            <?php foreach ($courses as $course): ?>
                <div class="course-card">
                    <?php if ($course['image']): ?>
                        <img src="/onlinecourse/<?php echo htmlspecialchars($course['image']); ?>" alt="<?php echo htmlspecialchars($course['title']); ?>">
                    <?php endif; ?>
                    <div class="course-card-body">
                        <h3><a href="/onlinecourse/course/detail/<?php echo $course['id']; ?>"><?php echo htmlspecialchars($course['title']); ?></a></h3>
                        <p>Số học viên: <?php echo $course['student_count'] ?? 0; ?></p>
                        <div class="course-actions">
                            <a href="/onlinecourse/instructor/course/manage/<?php echo $course['id']; ?>" class="btn btn-sm">Quản lý</a>
                            <a href="/onlinecourse/instructor/course/edit/<?php echo $course['id']; ?>" class="btn btn-sm">Chỉnh sửa</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Bạn chưa có khóa học nào. <a href="/onlinecourse/instructor/createCourse">Tạo khóa học đầu tiên</a></p>
        <?php endif; ?>
    </div>
</div>

