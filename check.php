<?php
echo "<h1>Kiểm tra cấu hình Apache và mod_rewrite</h1>";

echo "<h2>1. Kiểm tra mod_rewrite:</h2>";
if (function_exists('apache_get_modules')) {
    $modules = apache_get_modules();
    if (in_array('mod_rewrite', $modules)) {
        echo "<p style='color:green;'>✅ mod_rewrite: ENABLED</p>";
    } else {
        echo "<p style='color:red;'>❌ mod_rewrite: DISABLED</p>";
        echo "<p>Cần bật mod_rewrite trong Apache!</p>";
    }
    echo "<p>All Apache modules:</p><pre>";
    print_r($modules);
    echo "</pre>";
} else {
    echo "<p style='color:orange;'>⚠️ Không thể kiểm tra mod_rewrite</p>";
    echo "<p>Có thể bạn đang dùng PHP built-in server (không hỗ trợ .htaccess)</p>";
}

echo "<h2>2. Thông tin server:</h2>";
echo "Server Software: " . ($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown') . "<br>";
echo "Document Root: " . ($_SERVER['DOCUMENT_ROOT'] ?? 'Unknown') . "<br>";
echo "Script Name: " . ($_SERVER['SCRIPT_NAME'] ?? 'Unknown') . "<br>";
echo "Request URI: " . ($_SERVER['REQUEST_URI'] ?? 'Unknown') . "<br>";

echo "<h2>3. Kiểm tra file:</h2>";
echo ".htaccess exists: " . (file_exists(__DIR__ . '/.htaccess') ? '✅ YES' : '❌ NO') . "<br>";
echo "index.php exists: " . (file_exists(__DIR__ . '/index.php') ? '✅ YES' : '❌ NO') . "<br>";

echo "<h2>4. Test routing trực tiếp:</h2>";
echo '<ul>';
echo '<li><a href="index.php?url=home">index.php?url=home</a></li>';
echo '<li><a href="index.php?url=auth/login">index.php?url=auth/login</a></li>';
echo '<li><a href="index.php?url=course">index.php?url=course</a></li>';
echo '</ul>';

echo "<h2>5. Test URL đẹp (cần mod_rewrite):</h2>";
echo '<ul>';
echo '<li><a href="home">home</a></li>';
echo '<li><a href="auth/login">auth/login</a></li>';
echo '<li><a href="course">course</a></li>';
echo '</ul>';

echo "<hr>";
echo "<h2>Full PHP Info:</h2>";
echo '<a href="?phpinfo=1">Xem phpinfo()</a>';

if (isset($_GET['phpinfo'])) {
    phpinfo();
}
?>

