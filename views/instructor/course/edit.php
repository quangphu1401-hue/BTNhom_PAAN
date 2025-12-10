<?php
$page_title = "Chỉnh sửa khóa học";
?>

<div class="container">
    <h1>Chỉnh sửa khóa học</h1>
    
    <form method="POST" action="/onlinecourse/instructor/course/edit/<?php echo $course['id']; ?>" enctype="multipart/form-data" class="course-form">
        <div class="form-group">
            <label for="title">Tiêu đề khóa học *</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($course['title']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="description">Mô tả khóa học</label>
            <textarea id="description" name="description" rows="6"><?php echo htmlspecialchars($course['description'] ?? ''); ?></textarea>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="category_id">Danh mục</label>
                <select id="category_id" name="category_id">
                    <option value="">Chọn danh mục</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['id']; ?>" <?php echo ($course['category_id'] == $category['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($category['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="level">Cấp độ</label>
                <select id="level" name="level">
                    <option value="Beginner" <?php echo ($course['level'] == 'Beginner') ? 'selected' : ''; ?>>Beginner</option>
                    <option value="Intermediate" <?php echo ($course['level'] == 'Intermediate') ? 'selected' : ''; ?>>Intermediate</option>
                    <option value="Advanced" <?php echo ($course['level'] == 'Advanced') ? 'selected' : ''; ?>>Advanced</option>
                </select>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="price">Giá (VNĐ)</label>
                <input type="number" id="price" name="price" min="0" step="0.01" value="<?php echo $course['price']; ?>">
            </div>
            
            <div class="form-group">
                <label for="duration_weeks">Thời lượng (tuần)</label>
                <input type="number" id="duration_weeks" name="duration_weeks" min="1" value="<?php echo $course['duration_weeks'] ?? ''; ?>">
            </div>
        </div>
        
        <?php if ($course['image']): ?>
            <div class="form-group">
                <label>Hình ảnh hiện tại</label>
                <img src="/onlinecourse/<?php echo htmlspecialchars($course['image']); ?>" alt="Current image" style="max-width: 200px;">
            </div>
        <?php endif; ?>
        
        <div class="form-group">
            <label for="image">Thay đổi hình ảnh</label>
            <input type="file" id="image" name="image" accept="image/*">
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="/onlinecourse/instructor/course/manage/<?php echo $course['id']; ?>" class="btn btn-secondary">Hủy</a>
        </div>
    </form>
</div>

