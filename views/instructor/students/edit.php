<?php
$page_title = "Chỉnh sửa học viên";
require_once __DIR__ . '/../../url_helper.php';
?>

<div class="container">
    <h1>Chỉnh sửa thông tin học viên</h1>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>
    
    <div class="student-info">
        <h2>Thông tin học viên</h2>
        <p><strong>Tên:</strong> <?php echo htmlspecialchars($enrollment['fullname']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($enrollment['email']); ?></p>
        <p><strong>Khóa học:</strong> <?php echo htmlspecialchars($enrollment['course_title']); ?></p>
        <p><strong>Ngày đăng ký:</strong> <?php echo formatDate($enrollment['enrolled_date']); ?></p>
    </div>
    
    <form method="POST" action="<?php echo url('instructor/students/edit/' . $enrollment['id']); ?>" class="student-edit-form">
        <div class="form-group">
            <label for="progress">Tiến độ học tập (%) *</label>
            <input type="number" id="progress" name="progress" min="0" max="100" 
                   value="<?php echo htmlspecialchars($enrollment['progress']); ?>" required>
            <small>Nhập số từ 0 đến 100</small>
        </div>
        
        <div class="form-group">
            <label for="status">Trạng thái *</label>
            <select id="status" name="status" required>
                <option value="active" <?php echo $enrollment['status'] == 'active' ? 'selected' : ''; ?>>Đang học</option>
                <option value="completed" <?php echo $enrollment['status'] == 'completed' ? 'selected' : ''; ?>>Hoàn thành</option>
                <option value="dropped" <?php echo $enrollment['status'] == 'dropped' ? 'selected' : ''; ?>>Đã bỏ học</option>
            </select>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="<?php echo url('instructor/students/' . $enrollment['course_id']); ?>" class="btn btn-secondary">Hủy</a>
        </div>
    </form>
</div>
