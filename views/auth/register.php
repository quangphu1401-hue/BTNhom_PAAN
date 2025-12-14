<?php
$page_title = "Đăng ký";
?>

<div class="container">
    <div class="auth-container">
        <div class="auth-card">
            <h2>Đăng ký tài khoản</h2>
            
            <?php if (!empty($error)): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <?php if (!empty($success)): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>
            
            <form method="POST" action="<?php echo url('auth/register'); ?>">
                <div class="form-group">
                    <label for="fullname">Họ và tên</label>
                    <input type="text" id="fullname" name="fullname" required>
                </div>
                
                <div class="form-group">
                    <label for="username">Tên đăng nhập</label>
                    <input type="text" id="username" name="username" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <input type="password" id="password" name="password" required minlength="6">
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Xác nhận mật khẩu</label>
                    <input type="password" id="confirm_password" name="confirm_password" required minlength="6">
                </div>
                
                <div class="form-group">
                    <label for="role">Vai trò</label>
                    <select id="role" name="role">
                        <option value="0">Học viên</option>
                        <option value="1">Giảng viên</option>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block">Đăng ký</button>
            </form>
            
            <p class="text-center mt-2">
                Đã có tài khoản? <a href="<?php echo url('auth/login'); ?>">Đăng nhập ngay</a>
            </p>
        </div>
    </div>
</div>

