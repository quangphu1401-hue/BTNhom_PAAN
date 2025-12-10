<?php
$page_title = "Đăng nhập";
?>

<div class="container">
    <div class="auth-container">
        <div class="auth-card">
            <h2>Đăng nhập</h2>
            
            <?php if (!empty($error)): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <form method="POST" action="<?php echo url('auth/login'); ?>">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Mật khẩu</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
            </form>
            
            <p class="text-center mt-2">
                Chưa có tài khoản? <a href="<?php echo url('auth/register'); ?>">Đăng ký ngay</a>
            </p>
        </div>
    </div>
</div>

