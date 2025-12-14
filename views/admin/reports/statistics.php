<?php
$page_title = "Thống kê hệ thống";
?>

<div class="container">
    <h1>Thống kê hệ thống</h1>
    
    <?php if (isset($error) && !empty($error)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <?php if (isset($success) && !empty($success)): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>
    
    <!-- Thống kê tổng quan -->
    <div class="stats-overview">
        <h2>Tổng quan hệ thống</h2>
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">👥</div>
                <div class="stat-content">
                    <h3>Tổng số người dùng</h3>
                    <p class="stat-number"><?php echo $totalUsers; ?></p>
                    <div class="stat-details">
                        <span>Học viên: <?php echo $totalStudents; ?></span>
                        <span>Giảng viên: <?php echo $totalInstructors; ?></span>
                        <span>Admin: <?php echo $totalAdmins; ?></span>
                    </div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">📚</div>
                <div class="stat-content">
                    <h3>Tổng số khóa học</h3>
                    <p class="stat-number"><?php echo $totalCourses; ?></p>
                    <div class="stat-details">
                        <span>Đã duyệt: <?php echo $courseStats['approved_courses'] ?? 0; ?></span>
                        <span>Chờ duyệt: <?php echo $courseStats['pending_courses'] ?? 0; ?></span>
                        <span>Từ chối: <?php echo $courseStats['rejected_courses'] ?? 0; ?></span>
                    </div>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">📖</div>
                <div class="stat-content">
                    <h3>Tổng số bài học</h3>
                    <p class="stat-number"><?php echo $totalLessons; ?></p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">✅</div>
                <div class="stat-content">
                    <h3>Tổng số đăng ký</h3>
                    <p class="stat-number"><?php echo $totalEnrollments; ?></p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Thống kê đăng ký theo tháng -->
    <?php if (!empty($monthlyEnrollments)): ?>
    <div class="stats-section">
        <h2>Đăng ký theo tháng</h2>
        <div class="chart-container">
            <table class="stats-table">
                <thead>
                    <tr>
                        <th>Tháng</th>
                        <th>Số lượng đăng ký</th>
                        <th>Biểu đồ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $maxEnrollments = max($monthlyEnrollments);
                    foreach ($monthlyEnrollments as $month => $count): 
                        $percentage = $maxEnrollments > 0 ? ($count / $maxEnrollments) * 100 : 0;
                    ?>
                        <tr>
                            <td><?php echo date('m/Y', strtotime($month . '-01')); ?></td>
                            <td><?php echo $count; ?></td>
                            <td>
                                <div class="progress-bar-horizontal">
                                    <div class="progress-fill" style="width: <?php echo $percentage; ?>%"></div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Thống kê khóa học theo danh mục -->
    <?php if (!empty($coursesByCategory)): ?>
    <div class="stats-section">
        <h2>Khóa học theo danh mục</h2>
        <div class="category-stats">
            <table class="stats-table">
                <thead>
                    <tr>
                        <th>Danh mục</th>
                        <th>Số lượng khóa học</th>
                        <th>Tỷ lệ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $maxCategoryCount = max(array_column($coursesByCategory, 'count'));
                    foreach ($coursesByCategory as $category): 
                        $percentage = $maxCategoryCount > 0 ? ($category['count'] / $maxCategoryCount) * 100 : 0;
                        $categoryName = $category['name'] ?? 'Chưa phân loại';
                    ?>
                        <tr>
                            <td><?php echo htmlspecialchars($categoryName); ?></td>
                            <td><?php echo $category['count']; ?></td>
                            <td>
                                <div class="progress-bar-horizontal">
                                    <div class="progress-fill" style="width: <?php echo $percentage; ?>%"></div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
.stats-overview {
    margin-bottom: 2rem;
}

.stats-overview h2 {
    margin-bottom: 1.5rem;
    color: #2c3e50;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: transform 0.3s, box-shadow 0.3s;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.stat-icon {
    font-size: 3rem;
    line-height: 1;
}

.stat-content {
    flex: 1;
}

.stat-content h3 {
    margin: 0 0 0.5rem 0;
    color: #7f8c8d;
    font-size: 0.9rem;
    font-weight: normal;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: bold;
    color: #2c3e50;
    margin: 0.5rem 0;
}

.stat-details {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
    margin-top: 0.5rem;
    font-size: 0.875rem;
    color: #7f8c8d;
}

.stats-section {
    background: white;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-bottom: 2rem;
}

.stats-section h2 {
    margin-bottom: 1.5rem;
    color: #2c3e50;
    border-bottom: 2px solid #3498db;
    padding-bottom: 0.5rem;
}

.stats-table {
    width: 100%;
    border-collapse: collapse;
}

.stats-table th {
    background: #f8f9fa;
    padding: 1rem;
    text-align: left;
    font-weight: 600;
    color: #2c3e50;
    border-bottom: 2px solid #dee2e6;
}

.stats-table td {
    padding: 1rem;
    border-bottom: 1px solid #dee2e6;
}

.stats-table tr:hover {
    background: #f8f9fa;
}

.progress-bar-horizontal {
    width: 100%;
    height: 20px;
    background: #e9ecef;
    border-radius: 10px;
    overflow: hidden;
    position: relative;
}

.progress-bar-horizontal .progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #3498db, #2980b9);
    transition: width 0.3s ease;
}

.chart-container {
    overflow-x: auto;
}

.category-stats {
    margin-top: 1rem;
}
</style>
