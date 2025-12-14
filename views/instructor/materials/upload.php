<?php
$page_title = "Quản lý tài liệu";
?>

<div class="container">
    <h1>Quản lý tài liệu - <?php echo htmlspecialchars($lesson['title']); ?></h1>
    
    <div class="upload-section">
        <h2>Đăng tải tài liệu mới</h2>
        <form method="POST" action="/onlinecourse/instructor/materials/upload/<?php echo $lesson['id']; ?>" enctype="multipart/form-data">
            <div class="form-group">
                <label for="file">Chọn file (PDF, DOC, PPT, etc.)</label>
                <input type="file" id="file" name="file" required accept=".pdf,.doc,.docx,.ppt,.pptx,.txt,.zip,.rar">
            </div>
            <button type="submit" class="btn btn-primary">Đăng tải</button>
        </form>
    </div>
    
    <div class="materials-list">
        <h2>Danh sách tài liệu (<?php echo count($materials); ?>)</h2>
        <?php if (!empty($materials)): ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Tên file</th>
                        <th>Loại</th>
                        <th>Ngày đăng</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($materials as $material): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($material['filename']); ?></td>
                            <td><?php echo htmlspecialchars($material['file_type']); ?></td>
                            <td><?php echo formatDate($material['uploaded_at']); ?></td>
                            <td>
                                <a href="/onlinecourse/<?php echo htmlspecialchars($material['file_path']); ?>" download class="btn btn-sm">Tải về</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Chưa có tài liệu nào.</p>
        <?php endif; ?>
    </div>
    
    <a href="/onlinecourse/instructor/lessons/<?php echo $lesson['course_id']; ?>" class="btn btn-secondary">Quay lại</a>
</div>

