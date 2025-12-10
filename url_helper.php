<?php
/**
 * Helper để tạo URL đúng với hoặc không có .htaccess
 */

function url($path) {
    $base_path = getBasePath();
    $path = ltrim($path, '/');
    
    // Nếu .htaccess hoạt động, dùng URL đẹp
    // Nếu không, dùng index.php?url=
    
    // Kiểm tra xem có thể dùng URL đẹp không (test bằng cách kiểm tra REQUEST_URI)
    // Tạm thời luôn dùng index.php?url= để đảm bảo hoạt động
    return $base_path . '/index.php?url=' . $path;
}

// Alias cho url()
function base_url($path = '') {
    return getBasePath() . ($path ? '/' . ltrim($path, '/') : '');
}

function asset_url($path) {
    $base_path = getBasePath();
    return $base_path . '/assets/' . ltrim($path, '/');
}
?>

