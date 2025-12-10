<?php
$page_title = "Quản lý danh mục";
?>

<div class="container">
    <h1>Quản lý danh mục</h1>
    
    <div class="category-form-section">
        <h2>Thêm danh mục mới</h2>
        <form method="POST" action="/onlinecourse/admin/categories" class="category-form">
            <input type="hidden" name="action" value="create">
            <div class="form-row">
                <div class="form-group">
                    <input type="text" name="name" placeholder="Tên danh mục" required>
                </div>
                <div class="form-group">
                    <input type="text" name="description" placeholder="Mô tả">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Thêm</button>
                </div>
            </div>
        </form>
    </div>
    
    <div class="categories-list">
        <h2>Danh sách danh mục</h2>
        <?php if (!empty($categories)): ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Mô tả</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category): ?>
                        <tr>
                            <td><?php echo $category['id']; ?></td>
                            <td><?php echo htmlspecialchars($category['name']); ?></td>
                            <td><?php echo htmlspecialchars($category['description'] ?? ''); ?></td>
                            <td>
                                <form method="POST" action="/onlinecourse/admin/categories" style="display: inline;">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?php echo $category['id']; ?>">
                                    <button type="submit" class="btn btn-sm btn-danger" data-delete>Xóa</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Chưa có danh mục nào.</p>
        <?php endif; ?>
    </div>
</div>

