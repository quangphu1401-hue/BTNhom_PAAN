<?php
$page_title = "Chỉnh sửa danh mục";
?>

<div class="container">
    <h1>Chỉnh sửa danh mục</h1>
    
    <form method="POST" action="/onlinecourse/admin/categories" class="category-form">
        <input type="hidden" name="action" value="edit">
        <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
        <div class="form-group">
            <label for="name">Tên danh mục *</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($category['name']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="description">Mô tả</label>
            <textarea id="description" name="description" rows="4"><?php echo htmlspecialchars($category['description'] ?? ''); ?></textarea>
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="/onlinecourse/admin/categories" class="btn btn-secondary">Hủy</a>
        </div>
    </form>
</div>