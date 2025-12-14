<?php
$page_title = "Quản lý người dùng";
?>

<div class="container">
    <h1>Quản lý người dùng</h1>
    
    <?php if (isset($error) && !empty($error)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <?php if (isset($success) && !empty($success)): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>
    
    <!-- Form thêm/sửa người dùng -->
    <div class="user-form-section">
        <h2><?php echo isset($editUser) ? 'Sửa người dùng' : 'Thêm người dùng mới'; ?></h2>
        <form method="POST" action="<?php 
            if (function_exists('url')) {
                $actionUrl = url('admin/users');
            } else {
                $actionUrl = getBasePath() . '/index.php?url=admin/users';
            }
            if (isset($editUser)) {
                $actionUrl .= '&edit=' . $editUser['id'];
            }
            echo $actionUrl;
        ?>" class="user-form">
            <input type="hidden" name="action" value="<?php echo isset($editUser) ? 'update' : 'create'; ?>">
            <?php if (isset($editUser)): ?>
                <input type="hidden" name="id" value="<?php echo $editUser['id']; ?>">
            <?php endif; ?>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Username *</label>
                    <input type="text" name="username" 
                           value="<?php echo isset($editUser) ? htmlspecialchars($editUser['username']) : ''; ?>" 
                           placeholder="Username" required>
                </div>
                <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="email" 
                           value="<?php echo isset($editUser) ? htmlspecialchars($editUser['email']) : ''; ?>" 
                           placeholder="Email" required>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Họ tên *</label>
                    <input type="text" name="fullname" 
                           value="<?php echo isset($editUser) ? htmlspecialchars($editUser['fullname']) : ''; ?>" 
                           placeholder="Họ và tên" required>
                </div>
                <div class="form-group">
                    <label>Mật khẩu <?php echo isset($editUser) ? '(để trống nếu không đổi)' : '*'; ?></label>
                    <input type="password" name="password" 
                           placeholder="Mật khẩu" <?php echo !isset($editUser) ? 'required' : ''; ?>>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Vai trò *</label>
                    <select name="role" required>
                        <?php
                        $roles = [0 => 'Học viên', 1 => 'Giảng viên', 2 => 'Quản trị viên'];
                        $selectedRole = isset($editUser) ? $editUser['role'] : 0;
                        foreach ($roles as $value => $label):
                        ?>
                            <option value="<?php echo $value; ?>" <?php echo $selectedRole == $value ? 'selected' : ''; ?>>
                                <?php echo $label; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>&nbsp;</label>
                    <div>
                        <button type="submit" class="btn btn-primary">
                            <?php echo isset($editUser) ? 'Cập nhật' : 'Thêm'; ?>
                        </button>
                        <?php if (isset($editUser)): ?>
                            <a href="<?php echo function_exists('url') ? url('admin/users') : (getBasePath() . '/index.php?url=admin/users'); ?>" class="btn btn-secondary">Hủy</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </form>
    </div>
    
    <!-- Danh sách người dùng -->
    <div class="users-list">
        <h2>Danh sách người dùng</h2>
        <?php if (!empty($users)): ?>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Vai trò</th>
                        <th>Ngày tạo</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['fullname']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td>
                                <?php
                                $roles = [0 => 'Học viên', 1 => 'Giảng viên', 2 => 'Quản trị viên'];
                                echo $roles[$user['role']] ?? 'N/A';
                                ?>
                            </td>
                            <td><?php echo formatDate($user['created_at']); ?></td>
                            <td>
                                <a href="<?php 
                                    $editUrl = function_exists('url') ? url('admin/users') : (getBasePath() . '/index.php?url=admin/users');
                                    echo $editUrl . '&edit=' . $user['id']; 
                                ?>" 
                                   class="btn btn-sm btn-primary">Sửa</a>
                                <?php if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != $user['id']): ?>
                                    <form method="POST" action="<?php echo function_exists('url') ? url('admin/users') : (getBasePath() . '/index.php?url=admin/users'); ?>" 
                                          style="display: inline;" 
                                          onsubmit="return confirm('Bạn có chắc chắn muốn xóa người dùng này?');">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                                        <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                    </form>
                                <?php else: ?>
                                    <span class="text-muted">(Tài khoản của bạn)</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Chưa có người dùng nào.</p>
        <?php endif; ?>
    </div>
</div>

<style>
.user-form-section {
    background: white;
    padding: 2rem;
    border-radius: 8px;
    margin-bottom: 2rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.user-form-section h2 {
    margin-bottom: 1.5rem;
    color: #2c3e50;
}

.user-form .form-row {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
}

.user-form .form-group {
    flex: 1;
}

.user-form .form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: #333;
}

.user-form .form-group input,
.user-form .form-group select {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 1rem;
}

.users-list {
    background: white;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.users-list h2 {
    margin-bottom: 1.5rem;
    color: #2c3e50;
}

.btn-sm {
    padding: 0.4rem 0.8rem;
    font-size: 0.875rem;
}

.text-muted {
    color: #6c757d;
    font-size: 0.875rem;
}
</style>

