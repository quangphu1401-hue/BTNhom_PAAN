<?php
/**
 * URL Helper Functions
 * 
 * Helper để tạo URL đúng với hoặc không có .htaccess
 */

/**
 * Tạo URL cho route
 * @param string $path Route path (e.g., 'home', 'auth/login', 'course/detail/1')
 * @return string Full URL
 */
function url($path) {
    $base_path = getBasePath();
    $path = ltrim($path, '/');
    
    // Luôn dùng index.php?url= để đảm bảo hoạt động với hoặc không có .htaccess
    return $base_path . '/index.php?url=' . $path;
}

/**
 * Alias cho url()
 * @param string $path Route path
 * @return string Full URL
 */
function route($path) {
    return url($path);
}

/**
 * Get base URL
 * @param string $path Optional path to append
 * @return string Base URL
 */
function base_url($path = '') {
    return getBasePath() . ($path ? '/' . ltrim($path, '/') : '');
}

/**
 * Get asset URL (CSS, JS, images)
 * @param string $path Asset path
 * @return string Full asset URL
 */
function asset_url($path) {
    $base_path = getBasePath();
    return $base_path . '/assets/' . ltrim($path, '/');
}

/**
 * Redirect helper - improved version
 * @param string $path Route path or full URL
 */
function redirect_to($path) {
    // If it's already a full URL, use it
    if (strpos($path, 'http://') === 0 || strpos($path, 'https://') === 0) {
        header('Location: ' . $path);
        exit;
    }
    
    // If it starts with /, assume it's a full path
    if (strpos($path, '/') === 0 && strpos($path, '/index.php') !== 0) {
        $base_path = getBasePath();
        header('Location: ' . $base_path . $path);
        exit;
    }
    
    // Otherwise, treat as route
    header('Location: ' . url($path));
    exit;
}
?>

