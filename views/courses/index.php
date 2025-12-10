<?php
$page_title = "Danh sách khóa học";
?>

<div class="container">
    <h1>Danh sách khóa học</h1>
    
    <div class="course-filter">
        <form method="GET" action="<?php echo url('course'); ?>" class="filter-form">
            <input type="text" name="keyword" placeholder="Tìm kiếm..." value="<?php echo htmlspecialchars($keyword ?? ''); ?>">
            
            <select name="category">
                <option value="">Tất cả danh mục</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?php echo $cat['id']; ?>" <?php echo (isset($category_id) && $category_id == $cat['id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($cat['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            <select name="level">
                <option value="">Tất cả cấp độ</option>
                <option value="Beginner" <?php echo (isset($level) && $level == 'Beginner') ? 'selected' : ''; ?>>Beginner</option>
                <option value="Intermediate" <?php echo (isset($level) && $level == 'Intermediate') ? 'selected' : ''; ?>>Intermediate</option>
                <option value="Advanced" <?php echo (isset($level) && $level == 'Advanced') ? 'selected' : ''; ?>>Advanced</option>
            </select>
            
            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
        </form>
    </div>
    
    <div class="courses-grid">
        <?php if (!empty($courses)): ?>
            <?php foreach ($courses as $course): ?>
                <div class="course-card">
                    <?php if ($course['image']): ?>
                        <img src="<?php echo getBasePath(); ?>/<?php echo htmlspecialchars($course['image']); ?>" alt="<?php echo htmlspecialchars($course['title']); ?>">
                    <?php else: ?>
                        <div class="course-image-placeholder">No Image</div>
                    <?php endif; ?>
                    <div class="course-card-body">
                        <h3><a href="<?php echo url('course/detail/' . $course['id']); ?>"><?php echo htmlspecialchars($course['title']); ?></a></h3>
                        <p class="course-description"><?php echo htmlspecialchars(substr($course['description'] ?? '', 0, 100)); ?>...</p>
                        <p class="course-instructor">Giảng viên: <?php echo htmlspecialchars($course['instructor_name'] ?? 'N/A'); ?></p>
                        <div class="course-meta">
                            <span class="course-level"><?php echo htmlspecialchars($course['level']); ?></span>
                            <span class="course-price"><?php echo number_format($course['price'], 0); ?> VNĐ</span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Không tìm thấy khóa học nào.</p>
        <?php endif; ?>
    </div>
</div>

