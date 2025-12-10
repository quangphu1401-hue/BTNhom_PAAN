<?php
/**
 * Script tạo password hash cho tài khoản admin
 * 
 * Cách sử dụng:
 * 1. Mở file này trong trình duyệt: http://localhost/onlinecourse/create_admin_password.php
 * 2. Nhập password bạn muốn
 * 3. Copy hash được tạo ra
 * 4. Dùng hash đó để tạo tài khoản admin trong phpMyAdmin
 */

// Kiểm tra xem có yêu cầu tạo hash không
if (isset($_POST['password']) && !empty($_POST['password'])) {
    $password = $_POST['password'];
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $success = true;
} else {
    $success = false;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tạo Password Hash cho Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #2980b9;
        }
        .result {
            margin-top: 20px;
            padding: 15px;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            border-radius: 4px;
        }
        .hash-output {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 4px;
            word-break: break-all;
            font-family: monospace;
            margin-top: 10px;
        }
        .sql-command {
            margin-top: 20px;
            padding: 15px;
            background-color: #e9ecef;
            border-radius: 4px;
        }
        .sql-command pre {
            margin: 0;
            font-family: monospace;
            font-size: 14px;
        }
        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffc107;
            padding: 15px;
            border-radius: 4px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔐 Tạo Password Hash cho Admin</h1>
        
        <form method="POST">
            <div class="form-group">
                <label for="password">Nhập password cho admin:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Tạo Hash</button>
        </form>
        
        <?php if ($success): ?>
            <div class="result">
                <h3>✅ Hash đã được tạo thành công!</h3>
                <p>Password hash:</p>
                <div class="hash-output"><?php echo htmlspecialchars($hash); ?></div>
                
                <div class="sql-command">
                    <h4>📋 Lệnh SQL để tạo tài khoản admin:</h4>
                    <pre>
INSERT INTO users (username, email, password, fullname, role) 
VALUES (
    'admin',
    'admin@example.com',
    '<?php echo htmlspecialchars($hash); ?>',
    'Administrator',
    2
);
                    </pre>
                    <p><strong>Lưu ý:</strong> Thay đổi email và username nếu cần!</p>
                </div>
                
                <div class="warning">
                    <strong>⚠️ Cảnh báo bảo mật:</strong>
                    <ul>
                        <li>Sau khi tạo tài khoản admin, hãy xóa file này khỏi server!</li>
                        <li>Đổi password ngay sau khi đăng nhập lần đầu!</li>
                        <li>Không chia sẻ password hash này!</li>
                    </ul>
                </div>
            </div>
        <?php endif; ?>
        
        <div class="warning" style="margin-top: 30px;">
            <strong>ℹ️ Hướng dẫn:</strong>
            <ol>
                <li>Nhập password bạn muốn cho tài khoản admin</li>
                <li>Click "Tạo Hash"</li>
                <li>Copy hash hoặc lệnh SQL được tạo ra</li>
                <li>Mở phpMyAdmin → chọn database "onlinecourse" → tab SQL</li>
                <li>Paste lệnh SQL và click "Go"</li>
                <li><strong>XÓA FILE NÀY SAU KHI DÙNG!</strong></li>
            </ol>
        </div>
    </div>
</body>
</html>

