<?php
$page_title = "Khóa học của tôi";
?>

<div class="container">
    <h1>Khóa học của tôi</h1>
    
    <div class="action-buttons">
        <a href="/onlinecourse/instructor/createCourse" class="btn btn-primary">Tạo khóa học mới</a>
    </div>
    
    <div class="courses-grid">
        <?php if (!empty($courses)): ?>
            <?php foreach ($courses as $course): ?>
                <div class="course-card">
                    <?php if ($course['image']): ?>
                        <img src="/onlinecourse/<?php echo htmlspecialchars($course['image']); ?>" alt="<?php echo htmlspecialchars($course['title']); ?>">
                    <?php endif; ?>
                    <div class="course-card-body">
                        <h3><a href="/onlinecourse/course/detail/<?php echo $course['id']; ?>"><?php echo htmlspecialchars($course['title']); ?></a></h3>
                        <p>Danh mục: <?php echo htmlspecialchars($course['category_name'] ?? 'N/A'); ?></p>
                        <p>Số học viên: <?php echo $course['student_count'] ?? 0; ?></p>
                        <div class="course-actions">
                            <a href="/onlinecourse/instructor/course/manage/<?php echo $course['id']; ?>" class="btn btn-sm">Quản lý</a>
                            <a href="/onlinecourse/instructor/course/edit/<?php echo $course['id']; ?>" class="btn btn-sm">Chỉnh sửa</a>
                            <a href="/onlinecourse/instructor/students/<?php echo $course['id']; ?>" class="btn btn-sm">Học viên</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Bạn chưa có khóa học nào.</p>
        <?php endif; ?>
    </div>
</div>

