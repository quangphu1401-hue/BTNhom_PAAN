<?php
/**
 * File debug để kiểm tra cấu hình
 */
echo "<h1>Debug Information</h1>";

echo "<h2>1. PHP Info:</h2>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "Script Name: " . $_SERVER['SCRIPT_NAME'] . "<br>";
echo "Request URI: " . $_SERVER['REQUEST_URI'] . "<br>";
echo "Current Directory: " . __DIR__ . "<br>";

echo "<h2>2. File exists check:</h2>";
echo "index.php exists: " . (file_exists(__DIR__ . '/index.php') ? 'YES ✅' : 'NO ❌') . "<br>";
echo ".htaccess exists: " . (file_exists(__DIR__ . '/.htaccess') ? 'YES ✅' : 'NO ❌') . "<br>";

echo "<h2>3. Controller files:</h2>";
$controllers = ['AuthController', 'HomeController', 'CourseController'];
foreach ($controllers as $ctrl) {
    $file = __DIR__ . '/controllers/' . $ctrl . '.php';
    echo $ctrl . ": " . (file_exists($file) ? 'YES ✅' : 'NO ❌') . "<br>";
}

echo "<h2>4. GET Parameters:</h2>";
echo "<pre>";
print_r($_GET);
echo "</pre>";

echo "<h2>5. URL routing test:</h2>";
$url = isset($_GET['url']) ? $_GET['url'] : 'home';
echo "URL from GET: " . htmlspecialchars($url) . "<br>";
$url_parts = explode('/', $url);
echo "URL parts:<br><pre>";
print_r($url_parts);
echo "</pre>";

if (!empty($url_parts[0])) {
    $controller_name = ucfirst($url_parts[0]) . 'Controller';
    $method = isset($url_parts[1]) ? $url_parts[1] : 'index';
    
    echo "Controller: <strong>" . $controller_name . "</strong><br>";
    echo "Method: <strong>" . $method . "</strong><br>";
    
    $controller_file = __DIR__ . '/controllers/' . $controller_name . '.php';
    echo "Controller file: " . $controller_file . "<br>";
    echo "File exists: " . (file_exists($controller_file) ? 'YES ✅' : 'NO ❌') . "<br>";
}

echo "<h2>6. Test links:</h2>";
echo '<ul>';
echo '<li><a href="index.php">index.php</a></li>';
echo '<li><a href="index.php?url=home">index.php?url=home</a></li>';
echo '<li><a href="index.php?url=auth/login">index.php?url=auth/login</a></li>';
echo '<li><a href="?url=auth/login">?url=auth/login</a></li>';
echo '</ul>';

echo "<h2>7. mod_rewrite check:</h2>";
if (function_exists('apache_get_modules')) {
    $modules = apache_get_modules();
    echo "mod_rewrite: " . (in_array('mod_rewrite', $modules) ? 'ENABLED ✅' : 'DISABLED ❌') . "<br>";
    echo "All modules:<br><pre>";
    print_r($modules);
    echo "</pre>";
} else {
    echo "Cannot check Apache modules (might not be Apache or function disabled)<br>";
}
?>

