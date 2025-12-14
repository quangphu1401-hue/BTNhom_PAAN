<?php
$page_title = "Chỉnh sửa bài học";
?>

<div class="container">
    <h1>Chỉnh sửa bài học</h1>
    
    <form method="POST" action="/onlinecourse/instructor/lessons/edit/<?php echo $lesson['id']; ?>" class="lesson-form">
        <div class="form-group">
            <label for="title">Tiêu đề bài học *</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($lesson['title']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="content">Nội dung bài học</label>
            <textarea id="content" name="content" rows="10"><?php echo htmlspecialchars($lesson['content'] ?? ''); ?></textarea>
        </div>
        
        <div class="form-group">
            <label for="video_url">URL Video</label>
            <input type="url" id="video_url" name="video_url" value="<?php echo htmlspecialchars($lesson['video_url'] ?? ''); ?>">
        </div>
        
        <div class="form-group">
            <label for="order">Thứ tự bài học</label>
            <input type="number" id="order" name="order" min="0" value="<?php echo $lesson['order']; ?>">
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="/onlinecourse/instructor/lessons/<?php echo $lesson['course_id']; ?>" class="btn btn-secondary">Hủy</a>
        </div>
    </form>
</div>

