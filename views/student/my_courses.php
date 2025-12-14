<?php
$page_title = "Khóa học của tôi";
?>

<div class="container">
    <h1>Khóa học của tôi</h1>
    
    <div class="courses-grid">
        <?php if (!empty($courses)): ?>
            <?php foreach ($courses as $course): ?>
                <div class="course-card">
                    <?php if ($course['image']): ?>
                        <img src="<?php echo getBasePath(); ?>/<?php echo htmlspecialchars($course['image']); ?>" alt="<?php echo htmlspecialchars($course['title']); ?>">
                    <?php endif; ?>
                    <div class="course-card-body">
                        <h3><a href="<?php echo function_exists('url') ? url('course/detail/' . $course['course_id']) : (getBasePath() . '/index.php?url=course/detail/' . $course['course_id']); ?>"><?php echo htmlspecialchars($course['title']); ?></a></h3>
                        <p>Đăng ký: <?php echo formatDate($course['enrolled_date']); ?></p>
                        <p>Trạng thái: <?php echo htmlspecialchars($course['status']); ?></p>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: <?php echo $course['progress']; ?>%"></div>
                        </div>
                        <p>Tiến độ: <?php echo $course['progress']; ?>%</p>
                        <a href="<?php echo function_exists('url') ? url('enrollment/progress/' . $course['course_id']) : (getBasePath() . '/index.php?url=enrollment/progress/' . $course['course_id']); ?>" class="btn btn-primary">Vào học</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Bạn chưa đăng ký khóa học nào.</p>
        <?php endif; ?>
    </div>
</div>

