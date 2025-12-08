<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Check if helper files exist
if (!file_exists(__DIR__ . '/config/helper.php')) {
    die('Error: config/helper.php not found! Path: ' . __DIR__);
}

require_once __DIR__ . '/config/helper.php';

if (file_exists(__DIR__ . '/url_helper.php')) {
    require_once __DIR__ . '/url_helper.php';
}

// Autoload classes
spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/config/' . $class . '.php',
        __DIR__ . '/controllers/' . $class . '.php',
        __DIR__ . '/models/' . $class . '.php'
    ];
    
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

// Get URL parameter
$url = isset($_GET['url']) ? $_GET['url'] : 'home';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url_parts = explode('/', $url);

// Route handling
$controller_name = 'HomeController';
$method = 'index';
$params = [];

// Xử lý URL: auth/login, course/detail/1, instructor/dashboard, etc.
if (!empty($url_parts[0])) {
    // Controller name (first part)
    $controller_name = ucfirst($url_parts[0]) . 'Controller';
    
    // Method name (second part) or default to 'index'
    if (isset($url_parts[1]) && !empty($url_parts[1])) {
        $method = $url_parts[1];
        
        // Params (remaining parts)
        if (count($url_parts) > 2) {
            $params = array_slice($url_parts, 2);
        }
    }
}

// Debug (comment out in production)
// error_log("Controller: $controller_name, Method: $method, Params: " . print_r($params, true));

// Check if controller exists
$controller_file = __DIR__ . '/controllers/' . $controller_name . '.php';
if (file_exists($controller_file)) {
    require_once $controller_file;
    
    if (class_exists($controller_name)) {
        $controller = new $controller_name();
        
        if (method_exists($controller, $method)) {
            call_user_func_array([$controller, $method], $params);
        } else {
            // Method not found
            http_response_code(404);
            require_once __DIR__ . '/views/errors/404.php';
        }
    } else {
        // Controller class not found
        http_response_code(404);
        require_once __DIR__ . '/views/errors/404.php';
    }
} else {
    // Controller file not found
    http_response_code(404);
    require_once __DIR__ . '/views/errors/404.php';
}
?>
