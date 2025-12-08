<?php
$page_title = "Quản lý bài học";
?>

<div class="container">
    <div class="manage-header">
        <h1>Quản lý bài học - <?php echo htmlspecialchars($course['title']); ?></h1>
        <a href="/onlinecourse/instructor/createLesson/<?php echo $course['id']; ?>" class="btn btn-primary">Thêm bài học mới</a>
    </div>
    
    <?php if (!empty($lessons)): ?>
        <table class="data-table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tiêu đề</th>
                    <th>Ngày tạo</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($lessons as $lesson): ?>
                    <tr>
                        <td><?php echo $lesson['order'] + 1; ?></td>
                        <td><?php echo htmlspecialchars($lesson['title']); ?></td>
                        <td><?php echo formatDate($lesson['created_at']); ?></td>
                        <td>
                            <a href="/onlinecourse/instructor/lessons/edit/<?php echo $lesson['id']; ?>" class="btn btn-sm">Sửa</a>
                            <a href="/onlinecourse/instructor/materials/upload/<?php echo $lesson['id']; ?>" class="btn btn-sm">Tài liệu</a>
                            <a href="/onlinecourse/instructor/lessons/delete/<?php echo $lesson['id']; ?>" class="btn btn-sm btn-danger" data-delete>Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Chưa có bài học nào. <a href="/onlinecourse/instructor/createLesson/<?php echo $course['id']; ?>">Thêm bài học đầu tiên</a></p>
    <?php endif; ?>
</div>

