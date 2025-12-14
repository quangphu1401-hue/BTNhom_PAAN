<?php
$page_title = "Tiến độ học tập";
?>

<div class="container">
    <div class="course-progress-header">
        <h1><?php echo htmlspecialchars($course['title']); ?></h1>
        <div class="progress-overview">
            <div class="progress-bar-large">
                <div class="progress-fill" style="width: <?php echo $enrollment['progress']; ?>%"></div>
            </div>
            <p>Tiến độ: <?php echo $enrollment['progress']; ?>%</p>
        </div>
    </div>
    
    <div class="lessons-list">
        <h2>Danh sách bài học</h2>
        <?php if (!empty($lessons)): ?>
            <ul class="lesson-list">
                <?php foreach ($lessons as $lesson): ?>
                    <li class="lesson-item">
                        <div class="lesson-info">
                            <span class="lesson-order">Bài <?php echo $lesson['order'] + 1; ?></span>
                            <span class="lesson-title"><?php echo htmlspecialchars($lesson['title']); ?></span>
                        </div>
                        <a href="/onlinecourse/lesson/view/<?php echo $lesson['id']; ?>" class="btn btn-primary">Xem bài học</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Khóa học chưa có bài học nào.</p>
        <?php endif; ?>
    </div>
</div>

