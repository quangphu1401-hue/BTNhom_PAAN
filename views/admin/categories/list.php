<?php
$page_title = "Quản lý danh mục";
?>

<div class="container">
    <h1>Quản lý danh mục</h1>
    
    <div class="category-actions">
        <a href="/onlinecourse/admin/categories/create" class="btn btn-primary">Thêm danh mục mới</a>
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
                                <a href="/onlinecourse/admin/categories/edit/<?php echo $category['id']; ?>" class="btn btn-sm btn-warning">Sửa</a>
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

