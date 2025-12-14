<?php
$page_title = "Dashboard Admin";
include 'db.php';

$result  = mysqli_query($conn, $sql);
$courses = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<h1><?php echo $page_title; ?></h1>
<p>Tổng số khóa học trong hệ thống: <?php echo count($courses); ?></p>

<table border="1">
    <tr>
        <th>Tên khóa học</th>
        <th>Danh mục</th>
        <th>Cấp độ</th>
    </tr>
    <?php foreach ($courses as $course): ?>
    <tr>
        <td><?php echo $course['title']; ?></td>
        <td><?php echo $course['category_name']; ?></td>
        <td><?php echo $course['level']; ?></td>
    </tr>
    <?php endforeach; ?>
</table>
