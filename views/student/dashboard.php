<?php
$page_title = "Dashboard Học viên";

include 'db.php';

/* Lấy danh sách khóa học */
$sql = "
SELECT 
    c.id,
    c.title,
    c.description,
    c.level,
    cat.name AS category_name
FROM courses c
JOIN categories cat ON c.category_id = cat.id
";

$result  = mysqli_query($conn, $sql);
$courses = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $page_title; ?></title>
    <style>
        .course-card { border:1px solid #ccc; padding:15px; margin-bottom:15px }
    </style>
</head>
<body>

<div class="container">
    <h1>Dashboard của tôi</h1>

    <div class="dashboard-stats">
        <div class="stat-card">
            <h3>Số khóa học</h3>
            <p class="stat-number"><?php echo count($courses); ?></p>
        </div>
    </div>

    <h2>Danh sách khóa học</h2>

    <?php if (!empty($courses)): ?>
        <?php foreach ($courses as $course): ?>
            <div class="course-card">
                <h3><?php echo htmlspecialchars($course['title']); ?></h3>

                <p><?php echo htmlspecialchars($course['description']); ?></p>

                <p>
                    <strong>Danh mục:</strong>
                    <?php echo htmlspecialchars($course['category_name']); ?>
                </p>

                <p>
                    <strong>Cấp độ:</strong>
                    <?php echo htmlspecialchars($course['level']); ?>
                </p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Chưa có khóa học nào.</p>
    <?php endif; ?>
</div>

</body>
</html>
