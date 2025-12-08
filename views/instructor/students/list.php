<?php
$page_title = "Danh sách học viên";
?>

<div class="container">
    <h1>Danh sách học viên - <?php echo htmlspecialchars($course['title']); ?></h1>
    
    <?php if (!empty($students)): ?>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Tên học viên</th>
                    <th>Email</th>
                    <th>Ngày đăng ký</th>
                    <th>Tiến độ</th>
                    <th>Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($student['fullname']); ?></td>
                        <td><?php echo htmlspecialchars($student['email']); ?></td>
                        <td><?php echo formatDate($student['enrolled_date']); ?></td>
                        <td>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: <?php echo $student['progress']; ?>%"></div>
                            </div>
                            <?php echo $student['progress']; ?>%
                        </td>
                        <td><?php echo htmlspecialchars($student['status']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Chưa có học viên nào đăng ký khóa học này.</p>
    <?php endif; ?>
    
    <a href="/onlinecourse/instructor/course/manage/<?php echo $course['id']; ?>" class="btn btn-secondary">Quay lại</a>
</div>

