<?php
$page_title = "Duyệt phê duyệt khóa học";
?>

<div class="container">
    <h1>Duyệt phê duyệt khóa học</h1>
    
    <?php if (isset($error) && !empty($error)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <?php if (isset($success) && !empty($success)): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>
    
    <?php if (!empty($pendingCourses)): ?>
        <div class="pending-courses-list">
            <?php foreach ($pendingCourses as $course): ?>
                <div class="course-card-pending">
                    <div class="course-header">
                        <h3><?php echo htmlspecialchars($course['title']); ?></h3>
                        <span class="badge badge-pending">Chờ duyệt</span>
                    </div>
                    
                    <div class="course-info">
                        <div class="info-row">
                            <strong>Giảng viên:</strong>
                            <span><?php echo htmlspecialchars($course['instructor_name'] ?? 'N/A'); ?></span>
                            <span class="email">(<?php echo htmlspecialchars($course['instructor_email'] ?? ''); ?>)</span>
                        </div>
                        
                        <div class="info-row">
                            <strong>Danh mục:</strong>
                            <span><?php echo htmlspecialchars($course['category_name'] ?? 'Chưa phân loại'); ?></span>
                        </div>
                        
                        <div class="info-row">
                            <strong>Mức độ:</strong>
                            <span><?php echo htmlspecialchars($course['level'] ?? 'Beginner'); ?></span>
                        </div>
                        
                        <div class="info-row">
                            <strong>Giá:</strong>
                            <span><?php echo number_format($course['price'] ?? 0, 0, ',', '.'); ?> VNĐ</span>
                        </div>
                        
                        <div class="info-row">
                            <strong>Thời lượng:</strong>
                            <span><?php echo $course['duration_weeks'] ?? 0; ?> tuần</span>
                        </div>
                        
                        <div class="info-row">
                            <strong>Ngày tạo:</strong>
                            <span><?php echo formatDate($course['created_at']); ?></span>
                        </div>
                    </div>
                    
                    <?php if (!empty($course['description'])): ?>
                        <div class="course-description">
                            <strong>Mô tả:</strong>
                            <p><?php echo nl2br(htmlspecialchars($course['description'])); ?></p>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($course['image'])): ?>
                        <div class="course-image">
                            <img src="<?php echo getBasePath(); ?>/<?php echo htmlspecialchars($course['image']); ?>" 
                                 alt="<?php echo htmlspecialchars($course['title']); ?>">
                        </div>
                    <?php endif; ?>
                    
                    <div class="course-actions">
                        <form method="POST" action="<?php echo function_exists('url') ? url('admin/approveCourses') : (getBasePath() . '/index.php?url=admin/approveCourses'); ?>" 
                              style="display: inline;"
                              onsubmit="return confirm('Bạn có chắc chắn muốn phê duyệt khóa học này?');">
                            <input type="hidden" name="action" value="approve">
                            <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                            <button type="submit" class="btn btn-success">✅ Phê duyệt</button>
                        </form>
                        
                        <form method="POST" action="<?php echo function_exists('url') ? url('admin/approveCourses') : (getBasePath() . '/index.php?url=admin/approveCourses'); ?>" 
                              style="display: inline;"
                              onsubmit="return confirm('Bạn có chắc chắn muốn từ chối khóa học này?');">
                            <input type="hidden" name="action" value="reject">
                            <input type="hidden" name="course_id" value="<?php echo $course['id']; ?>">
                            <button type="submit" class="btn btn-danger">❌ Từ chối</button>
                        </form>
                        
                        <a href="<?php echo function_exists('url') ? url('course/detail/' . $course['id']) : (getBasePath() . '/index.php?url=course/detail/' . $course['id']); ?>" 
                           class="btn btn-secondary" target="_blank">👁️ Xem chi tiết</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="no-pending">
            <p>Không có khóa học nào chờ duyệt.</p>
        </div>
    <?php endif; ?>
</div>

<style>
.pending-courses-list {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.course-card-pending {
    background: white;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    border-left: 4px solid #f39c12;
}

.course-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #ecf0f1;
}

.course-header h3 {
    margin: 0;
    color: #2c3e50;
    flex: 1;
}

.badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
}

.badge-pending {
    background: #fff3cd;
    color: #856404;
    border: 1px solid #ffeaa7;
}

.course-info {
    margin-bottom: 1.5rem;
}

.info-row {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 0.75rem;
    align-items: center;
}

.info-row strong {
    min-width: 120px;
    color: #34495e;
}

.info-row .email {
    color: #7f8c8d;
    font-size: 0.875rem;
}

.course-description {
    margin: 1.5rem 0;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 4px;
}

.course-description strong {
    display: block;
    margin-bottom: 0.5rem;
    color: #2c3e50;
}

.course-description p {
    margin: 0;
    color: #555;
    line-height: 1.6;
}

.course-image {
    margin: 1.5rem 0;
}

.course-image img {
    max-width: 100%;
    height: auto;
    border-radius: 4px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.course-actions {
    display: flex;
    gap: 1rem;
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid #ecf0f1;
    flex-wrap: wrap;
}

.btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 1rem;
    text-decoration: none;
    display: inline-block;
    transition: all 0.3s;
}

.btn-success {
    background: #27ae60;
    color: white;
}

.btn-success:hover {
    background: #229954;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(39, 174, 96, 0.3);
}

.btn-danger {
    background: #e74c3c;
    color: white;
}

.btn-danger:hover {
    background: #c0392b;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(231, 76, 60, 0.3);
}

.btn-secondary {
    background: #95a5a6;
    color: white;
}

.btn-secondary:hover {
    background: #7f8c8d;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(149, 165, 166, 0.3);
}

.no-pending {
    background: white;
    padding: 3rem;
    border-radius: 8px;
    text-align: center;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.no-pending p {
    font-size: 1.2rem;
    color: #7f8c8d;
    margin: 0;
}
</style>

