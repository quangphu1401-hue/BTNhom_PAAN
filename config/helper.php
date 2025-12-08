<?php
// Helper functions

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Check user role
function hasRole($role) {
    if (!isLoggedIn()) {
        return false;
    }
    
    $userRole = $_SESSION['role'] ?? -1;
    
    if ($role === 'student') return $userRole == 0;
    if ($role === 'instructor') return $userRole == 1;
    if ($role === 'admin') return $userRole == 2;
    
    return false;
}

// Require authentication
function requireAuth() {
    if (!isLoggedIn()) {
        $base_path = getBasePath();
        $login_url = $base_path . '/index.php?url=auth/login';
        header('Location: ' . $login_url);
        exit;
    }
}

// Require role
function requireRole($role) {
    requireAuth();
    
    if (!hasRole($role)) {
        $base_path = getBasePath();
        $home_url = $base_path . '/index.php?url=home';
        header('Location: ' . $home_url);
        exit;
    }
}

// Get base URL dynamically
function getBaseUrl() {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $script = $_SERVER['SCRIPT_NAME'];
    
    // Get directory of script
    $path = dirname($script);
    
    // Remove trailing slash except root
    $path = rtrim($path, '/');
    
    return $protocol . '://' . $host . $path;
}

// Get base path for assets and links
function getBasePath() {
    $script = $_SERVER['SCRIPT_NAME'];
    $path = dirname($script);
    $path = rtrim($path, '/');
    return $path ?: '';
}

// Sanitize input
function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Redirect
function redirect($url) {
    header('Location: ' . $url);
    exit;
}

// Get user ID from session
function getUserId() {
    return $_SESSION['user_id'] ?? null;
}

// Format date
function formatDate($date) {
    return date('d/m/Y H:i', strtotime($date));
}
?>
