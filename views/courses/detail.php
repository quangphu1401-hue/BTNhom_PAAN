<?php
$page_title = htmlspecialchars($course['title']);
?>

<div class="container">
    <div class="course-detail">
        <div class="course-detail-header">
            <?php if ($course['image']): ?>
                        <img src="<?php echo getBasePath(); ?>/<?php echo htmlspecialchars($course['image']); ?>" alt="<?php echo htmlspecialchars($course['title']); ?>" class="course-detail-image">
            <?php endif; ?>
            
            <div class="course-detail-info">
                <h1><?php echo htmlspecialchars($course['title']); ?></h1>
                <p class="course-instructor">Giảng viên: <?php echo htmlspecialchars($course['instructor_name'] ?? 'N/A'); ?></p>
                <p class="course-category">Danh mục: <?php echo htmlspecialchars($course['category_name'] ?? 'N/A'); ?></p>
                <p class="course-level">Cấp độ: <?php echo htmlspecialchars($course['level']); ?></p>
                <p class="course-price">Giá: <?php echo number_format($course['price'], 0); ?> VNĐ</p>
                
                <?php if (isLoggedIn() && hasRole('student') && !$isEnrolled): ?>
                    <a href="<?php echo url('course/enroll/' . $course['id']); ?>" class="btn btn-primary">Đăng ký khóa học</a>
                <?php elseif ($isEnrolled): ?>
                    <a href="<?php echo url('enrollment/progress/' . $course['id']); ?>" class="btn btn-success">Vào học</a>
                <?php elseif (!isLoggedIn()): ?>
                    <a href="<?php echo url('auth/login'); ?>" class="btn btn-primary">Đăng nhập để đăng ký</a>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="course-detail-content">
            <h2>Mô tả khóa học</h2>
            <p><?php echo nl2br(htmlspecialchars($course['description'] ?? '')); ?></p>
            
            <?php if (!empty($lessons)): ?>
                <h2>Nội dung khóa học (<?php echo count($lessons); ?> bài học)</h2>
                <ul class="lesson-list">
                    <?php foreach ($lessons as $lesson): ?>
                        <li>
                            <span class="lesson-order"><?php echo $lesson['order'] + 1; ?></span>
                            <span class="lesson-title"><?php echo htmlspecialchars($lesson['title']); ?></span>
                            <?php if ($isEnrolled): ?>
                                <a href="<?php echo url('lesson/view/' . $lesson['id']); ?>" class="btn btn-sm">Xem</a>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Khóa học chưa có bài học nào.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

