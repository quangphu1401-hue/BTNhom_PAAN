<?php
$page_title = "Quản lý khóa học";
?>

<div class="container">
    <div class="manage-header">
        <h1><?php echo htmlspecialchars($course['title']); ?></h1>
        <div class="manage-actions">
            <a href="/onlinecourse/instructor/course/edit/<?php echo $course['id']; ?>" class="btn btn-primary">Chỉnh sửa</a>
            <a href="/onlinecourse/instructor/students/<?php echo $course['id']; ?>" class="btn btn-secondary">Xem học viên</a>
            <a href="/onlinecourse/instructor/lessons/<?php echo $course['id']; ?>" class="btn btn-secondary">Quản lý bài học</a>
        </div>
    </div>
    
    <div class="course-info">
        <h2>Thông tin khóa học</h2>
        <p><strong>Danh mục:</strong> <?php echo htmlspecialchars($course['category_name'] ?? 'N/A'); ?></p>
        <p><strong>Cấp độ:</strong> <?php echo htmlspecialchars($course['level']); ?></p>
        <p><strong>Giá:</strong> <?php echo number_format($course['price'], 0); ?> VNĐ</p>
        <p><strong>Số học viên:</strong> <?php echo count($students); ?></p>
    </div>
    
    <div class="lessons-section">
        <h2>Danh sách bài học (<?php echo count($lessons); ?>)</h2>
        <a href="/onlinecourse/instructor/lessons/create/<?php echo $course['id']; ?>" class="btn btn-primary">Thêm bài học mới</a>
        
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
                                <a href="/onlinecourse/instructor/lessons/delete/<?php echo $lesson['id']; ?>" class="btn btn-sm btn-danger" data-delete>Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Chưa có bài học nào. <a href="/onlinecourse/instructor/lessons/create/<?php echo $course['id']; ?>">Thêm bài học đầu tiên</a></p>
        <?php endif; ?>
    </div>
    
    <div class="students-section">
        <h2>Danh sách học viên (<?php echo count($students); ?>)</h2>
        <?php if (!empty($students)): ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Tên học viên</th>
                        <th>Email</th>
                        <th>Ngày đăng ký</th>
                        <th>Tiến độ</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($student['fullname']); ?></td>
                            <td><?php echo htmlspecialchars($student['email']); ?></td>
                            <td><?php echo formatDate($student['enrolled_date']); ?></td>
                            <td><?php echo $student['progress']; ?>%</td>
                            <td><?php echo htmlspecialchars($student['status']); ?></td>
                            <td>
                                <a href="/onlinecourse/instructor/students/edit/<?php echo $student['id']; ?>" class="btn btn-sm">Chỉnh sửa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Chưa có học viên nào đăng ký khóa học này.</p>
        <?php endif; ?>
    </div>
</div>

