<?php
$page_title = "Tạo khóa học mới";
?>

<div class="container">
    <h1>Tạo khóa học mới</h1>
    
    <form method="POST" action="/onlinecourse/instructor/createCourse" enctype="multipart/form-data" class="course-form">
        <div class="form-group">
            <label for="title">Tiêu đề khóa học *</label>
            <input type="text" id="title" name="title" required>
        </div>
        
        <div class="form-group">
            <label for="description">Mô tả khóa học</label>
            <textarea id="description" name="description" rows="6"></textarea>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="category_id">Danh mục</label>
                <select id="category_id" name="category_id">
                    <option value="">Chọn danh mục</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="level">Cấp độ</label>
                <select id="level" name="level">
                    <option value="Beginner">Beginner</option>
                    <option value="Intermediate">Intermediate</option>
                    <option value="Advanced">Advanced</option>
                </select>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="price">Giá (VNĐ)</label>
                <input type="number" id="price" name="price" min="0" step="0.01" value="0">
            </div>
            
            <div class="form-group">
                <label for="duration_weeks">Thời lượng (tuần)</label>
                <input type="number" id="duration_weeks" name="duration_weeks" min="1">
            </div>
        </div>
        
        <div class="form-group">
            <label for="image">Hình ảnh khóa học</label>
            <input type="file" id="image" name="image" accept="image/*">
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Tạo khóa học</button>
            <a href="/onlinecourse/instructor/myCourses" class="btn btn-secondary">Hủy</a>
        </div>
    </form>
</div>

