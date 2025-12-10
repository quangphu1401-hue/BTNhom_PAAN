<?php
echo "OK - File index.php tồn tại!<br>";
echo "Current directory: " . __DIR__ . "<br>";
echo "Script name: " . $_SERVER['SCRIPT_NAME'] . "<br>";
echo "Request URI: " . $_SERVER['REQUEST_URI'] . "<br>";
echo "Document root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";

if (file_exists(__DIR__ . '/index.php')) {
    echo "index.php exists: YES ✅<br>";
} else {
    echo "index.php exists: NO ❌<br>";
}

echo "<hr>";
echo "<h2>Thử truy cập trực tiếp:</h2>";
echo '<a href="index.php">index.php</a><br>';
echo '<a href="index.php?url=home">index.php?url=home</a>';
?>

