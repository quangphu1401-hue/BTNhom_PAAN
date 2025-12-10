<?php
$page_title = "Tạo bài học mới";
?>

<div class="container">
    <h1>Tạo bài học mới</h1>
    
    <form method="POST" action="/onlinecourse/instructor/lessons/create/<?php echo $course['id']; ?>" class="lesson-form">
        <div class="form-group">
            <label for="title">Tiêu đề bài học *</label>
            <input type="text" id="title" name="title" required>
        </div>
        
        <div class="form-group">
            <label for="content">Nội dung bài học</label>
            <textarea id="content" name="content" rows="10"></textarea>
        </div>
        
        <div class="form-group">
            <label for="video_url">URL Video (YouTube, Vimeo, etc.)</label>
            <input type="url" id="video_url" name="video_url" placeholder="https://www.youtube.com/watch?v=...">
        </div>
        
        <div class="form-group">
            <label for="order">Thứ tự bài học</label>
            <input type="number" id="order" name="order" min="0" value="0">
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Tạo bài học</button>
            <a href="/onlinecourse/instructor/lessons/<?php echo $course['id']; ?>" class="btn btn-secondary">Hủy</a>
        </div>
    </form>
</div>

