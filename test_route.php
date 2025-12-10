<?php
/**
 * File test để kiểm tra routing
 * Truy cập: http://localhost/CNW/onlinecourse/test_route.php
 */

echo "<h1>Test Routing</h1>";

echo "<h2>GET Parameters:</h2>";
echo "<pre>";
print_r($_GET);
echo "</pre>";

echo "<h2>URL từ \$_GET['url']:</h2>";
$url = isset($_GET['url']) ? $_GET['url'] : 'home';
echo "URL: " . htmlspecialchars($url) . "<br>";

$url_parts = explode('/', $url);
echo "URL Parts: <br>";
echo "<pre>";
print_r($url_parts);
echo "</pre>";

echo "<h2>Controller và Method sẽ được gọi:</h2>";
$controller_name = 'HomeController';
$method = 'index';

if (!empty($url_parts[0])) {
    $controller_name = ucfirst($url_parts[0]) . 'Controller';
    if (isset($url_parts[1]) && !empty($url_parts[1])) {
        $method = $url_parts[1];
    }
}

echo "Controller: <strong>" . $controller_name . "</strong><br>";
echo "Method: <strong>" . $method . "</strong><br>";

$controller_file = __DIR__ . '/controllers/' . $controller_name . '.php';
echo "<br>Controller file: " . $controller_file . "<br>";
echo "File exists: " . (file_exists($controller_file) ? "YES ✅" : "NO ❌") . "<br>";

if (file_exists($controller_file)) {
    require_once $controller_file;
    echo "Class exists: " . (class_exists($controller_name) ? "YES ✅" : "NO ❌") . "<br>";
    
    if (class_exists($controller_name)) {
        $controller = new $controller_name();
        echo "Method exists: " . (method_exists($controller, $method) ? "YES ✅" : "NO ❌") . "<br>";
    }
}

echo "<hr>";
echo "<h2>Test các URL:</h2>";
echo '<ul>';
echo '<li><a href="?url=home">home</a></li>';
echo '<li><a href="?url=auth/login">auth/login</a></li>';
echo '<li><a href="?url=auth/register">auth/register</a></li>';
echo '<li><a href="?url=course">course</a></li>';
echo '<li><a href="?url=course/index">course/index</a></li>';
echo '<li><a href="?url=course/detail/1">course/detail/1</a></li>';
echo '</ul>';

echo "<hr>";
echo "<h2>Kiểm tra .htaccess:</h2>";
echo "<p>Nếu bạn thấy file này, có nghĩa là .htaccess đang hoạt động (vì nó không redirect file này về index.php).</p>";
echo "<p>Nếu bạn không thấy file này khi truy cập trực tiếp, có nghĩa là .htaccess đang redirect về index.php (tốt!).</p>";
?>

