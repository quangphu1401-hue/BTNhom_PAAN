<?php
$page_title = "Thêm danh mục mới";
?>

<div class="container">
    <h1>Thêm danh mục mới</h1>
    
    <form method="POST" action="/onlinecourse/admin/categories" class="category-form">
        <input type="hidden" name="action" value="create">
        <div class="form-group">
            <label for="name">Tên danh mục *</label>
            <input type="text" id="name" name="name" required>
        </div>
        
        <div class="form-group">
            <label for="description">Mô tả</label>
            <textarea id="description" name="description" rows="4"></textarea>
        </div>
        
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Thêm danh mục</button>
            <a href="/onlinecourse/admin/categories" class="btn btn-secondary">Hủy</a>
        </div>
    </form>
</div>