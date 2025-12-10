<?php
$page_title = htmlspecialchars($lesson['title']);
?>

<div class="container">
    <div class="lesson-view">
        <div class="lesson-header">
            <h1><?php echo htmlspecialchars($lesson['title']); ?></h1>
            <p>Khóa học: <a href="/onlinecourse/course/detail/<?php echo $lesson['course_id']; ?>"><?php echo htmlspecialchars($lesson['course_title']); ?></a></p>
        </div>
        
        <?php if ($lesson['video_url']): ?>
            <div class="lesson-video">
                <iframe src="<?php echo htmlspecialchars($lesson['video_url']); ?>" frameborder="0" allowfullscreen></iframe>
            </div>
        <?php endif; ?>
        
        <div class="lesson-content">
            <?php echo nl2br(htmlspecialchars($lesson['content'] ?? '')); ?>
        </div>
        
        <?php if (!empty($materials)): ?>
            <div class="lesson-materials">
                <h2>Tài liệu học tập</h2>
                <ul>
                    <?php foreach ($materials as $material): ?>
                        <li>
                            <a href="/onlinecourse/<?php echo htmlspecialchars($material['file_path']); ?>" download>
                                <?php echo htmlspecialchars($material['filename']); ?>
                            </a>
                            <span class="file-type">(<?php echo htmlspecialchars($material['file_type']); ?>)</span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <div class="lesson-navigation">
            <?php if (!empty($lessons)): ?>
                <?php
                $current_index = array_search($lesson['id'], array_column($lessons, 'id'));
                if ($current_index !== false):
                    if ($current_index > 0):
                        $prev_lesson = $lessons[$current_index - 1];
                ?>
                    <a href="/onlinecourse/lesson/view/<?php echo $prev_lesson['id']; ?>" class="btn">← Bài trước</a>
                <?php
                    endif;
                    if ($current_index < count($lessons) - 1):
                        $next_lesson = $lessons[$current_index + 1];
                ?>
                    <a href="/onlinecourse/lesson/view/<?php echo $next_lesson['id']; ?>" class="btn">Bài sau →</a>
                <?php
                    endif;
                endif;
                ?>
            <?php endif; ?>
        </div>
    </div>
</div>

