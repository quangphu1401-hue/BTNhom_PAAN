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
    
    <div class="course-content">
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
                            <a href="<?php echo function_exists('url') ? url('lesson/view/' . $lesson['id']) : (getBasePath() . '/index.php?url=lesson/view/' . $lesson['id']); ?>" class="btn btn-primary">Xem bài học</a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Khóa học chưa có bài học nào.</p>
            <?php endif; ?>
        </div>

        <div class="course-materials">
            <h2>Tài liệu khóa học</h2>
            <?php if (!empty($materials) && is_array($materials) && count($materials) > 0): ?>
                <div class="materials-container">
                    <?php 
                    // Nhóm tài liệu theo bài học (nếu có lesson_title)
                    $materialsByLesson = [];
                    $hasLessonInfo = false;
                    
                    foreach ($materials as $material) {
                        if (!isset($material['lesson_id'])) continue;
                        
                        $lesson_key = $material['lesson_id'];
                        $lesson_title = isset($material['lesson_title']) ? $material['lesson_title'] : 'Bài học';
                        $lesson_order = isset($material['lesson_order']) ? (int)$material['lesson_order'] : 0;
                        
                        if (!isset($materialsByLesson[$lesson_key])) {
                            $materialsByLesson[$lesson_key] = [
                                'lesson_title' => $lesson_title,
                                'lesson_order' => $lesson_order,
                                'materials' => []
                            ];
                            if ($lesson_title != 'Bài học') {
                                $hasLessonInfo = true;
                            }
                        }
                        $materialsByLesson[$lesson_key]['materials'][] = $material;
                    }
                    
                    // Sắp xếp theo lesson_order
                    uasort($materialsByLesson, function($a, $b) {
                        return $a['lesson_order'] - $b['lesson_order'];
                    });
                    ?>
                    
                    <?php if (!empty($materialsByLesson)): ?>
                        <?php foreach ($materialsByLesson as $lesson_id => $lessonData): ?>
                            <div class="material-section">
                                <?php if ($hasLessonInfo): ?>
                                    <h3>
                                        <span class="lesson-badge">Bài <?php echo $lessonData['lesson_order'] + 1; ?></span>
                                        <?php echo htmlspecialchars($lessonData['lesson_title']); ?>
                                    </h3>
                                <?php endif; ?>
                                <ul class="material-list">
                                    <?php foreach ($lessonData['materials'] as $material): ?>
                                        <li class="material-item">
                                            <div class="material-info">
                                                <span class="material-icon">
                                                    <?php
                                                    $filename = $material['filename'] ?? 'file';
                                                    $file_ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                                                    $icon = '📄';
                                                    if (in_array($file_ext, ['pdf'])) $icon = '📕';
                                                    elseif (in_array($file_ext, ['doc', 'docx'])) $icon = '📘';
                                                    elseif (in_array($file_ext, ['xls', 'xlsx'])) $icon = '📊';
                                                    elseif (in_array($file_ext, ['ppt', 'pptx'])) $icon = '📽️';
                                                    elseif (in_array($file_ext, ['zip', 'rar'])) $icon = '📦';
                                                    elseif (in_array($file_ext, ['jpg', 'jpeg', 'png', 'gif'])) $icon = '🖼️';
                                                    echo $icon;
                                                    ?>
                                                </span>
                                                <span class="material-name"><?php echo htmlspecialchars($filename); ?></span>
                                                <span class="material-type">(<?php echo htmlspecialchars($material['file_type'] ?? $file_ext); ?>)</span>
                                            </div>
                                            <a href="<?php 
                                                $filePath = htmlspecialchars($material['file_path']);
                                                $basePath = function_exists('getBasePath') ? getBasePath() : '/onlinecourse';
                                                // Đảm bảo không có double slash
                                                $basePath = rtrim($basePath, '/');
                                                $filePath = ltrim($filePath, '/');
                                                echo $basePath . '/' . $filePath;
                                            ?>" 
                                               class="btn btn-sm btn-download" 
                                               download
                                               target="_blank">
                                                <span>⬇️</span> Tải xuống
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="no-materials">Khóa học chưa có tài liệu nào.</p>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <p class="no-materials">Khóa học chưa có tài liệu nào. Giảng viên sẽ tải tài liệu lên trong các bài học.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.course-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
    margin-top: 2rem;
}

@media (max-width: 768px) {
    .course-content {
        grid-template-columns: 1fr;
    }
}

.lessons-list, .course-materials {
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.lessons-list h2, .course-materials h2 {
    margin-bottom: 1.5rem;
    color: #2c3e50;
    border-bottom: 2px solid #3498db;
    padding-bottom: 0.5rem;
}

.lesson-list {
    list-style: none;
    padding: 0;
}

.lesson-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    margin-bottom: 0.5rem;
    background: #f8f9fa;
    border-radius: 4px;
    border-left: 4px solid #3498db;
}

.lesson-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.lesson-order {
    font-weight: bold;
    color: #3498db;
    font-size: 0.875rem;
}

.lesson-title {
    color: #333;
    font-weight: 500;
}

.materials-container {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    max-height: 600px;
    overflow-y: auto;
}

.material-section {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 6px;
    border-left: 4px solid #27ae60;
}

.material-section h3 {
    margin: 0 0 1rem 0;
    color: #2c3e50;
    font-size: 1.1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.lesson-badge {
    background: #27ae60;
    color: white;
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.875rem;
    font-weight: bold;
}

.material-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.material-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem;
    margin-bottom: 0.5rem;
    background: white;
    border-radius: 4px;
    border: 1px solid #e0e0e0;
    transition: all 0.3s;
}

.material-item:hover {
    border-color: #3498db;
    box-shadow: 0 2px 4px rgba(52, 152, 219, 0.2);
}

.material-info {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex: 1;
}

.material-icon {
    font-size: 1.25rem;
}

.material-name {
    font-weight: 500;
    color: #333;
}

.material-type {
    color: #7f8c8d;
    font-size: 0.875rem;
}

.btn-download {
    background: #27ae60;
    color: white;
    padding: 0.4rem 0.8rem;
    text-decoration: none;
    border-radius: 4px;
    font-size: 0.875rem;
    transition: background 0.3s;
}

.btn-download:hover {
    background: #229954;
    color: white;
}

.no-materials {
    color: #7f8c8d;
    font-style: italic;
    text-align: center;
    padding: 2rem;
}
</style>

