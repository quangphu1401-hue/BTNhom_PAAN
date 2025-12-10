<?php
$page_title = "Trang chủ";
?>

<section class="hero">
    <div class="container">
        <h1>Chào mừng đến với Online Course</h1>
        <p>Nền tảng học tập trực tuyến hàng đầu</p>
        <a href="/onlinecourse/course" class="btn btn-primary">Khám phá khóa học</a>
    </div>
</section>

<section class="courses-section">
    <div class="container">
        <h2>Khóa học mới nhất</h2>
        <div class="courses-grid">
            <?php if (!empty($latestCourses)): ?>
                <?php foreach ($latestCourses as $course): ?>
                    <div class="course-card">
                        <?php if ($course['image']): ?>
                            <img src="/onlinecourse/<?php echo htmlspecialchars($course['image']); ?>" alt="<?php echo htmlspecialchars($course['title']); ?>">
                        <?php else: ?>
                            <div class="course-image-placeholder">No Image</div>
                        <?php endif; ?>
                        <div class="course-card-body">
                            <h3><a href="/onlinecourse/course/detail/<?php echo $course['id']; ?>"><?php echo htmlspecialchars($course['title']); ?></a></h3>
                            <p class="course-instructor">Giảng viên: <?php echo htmlspecialchars($course['instructor_name'] ?? 'N/A'); ?></p>
                            <p class="course-category">Danh mục: <?php echo htmlspecialchars($course['category_name'] ?? 'N/A'); ?></p>
                            <div class="course-meta">
                                <span class="course-level"><?php echo htmlspecialchars($course['level']); ?></span>
                                <span class="course-price"><?php echo number_format($course['price'], 0); ?> VNĐ</span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Chưa có khóa học nào.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="categories-section">
    <div class="container">
        <h2>Danh mục khóa học</h2>
        <div class="categories-grid">
            <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $category): ?>
                    <div class="category-card">
                        <h3><?php echo htmlspecialchars($category['name']); ?></h3>
                        <p><?php echo htmlspecialchars($category['description'] ?? ''); ?></p>
                        <a href="/onlinecourse/course?category=<?php echo $category['id']; ?>" class="btn btn-outline">Xem khóa học</a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

