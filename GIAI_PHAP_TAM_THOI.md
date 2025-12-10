# GIẢI PHÁP TẠM THỜI - TRUY CẬP TRỰC TIẾP

## 🔧 Vì .htaccess không hoạt động, dùng URL trực tiếp:

### ✅ Các URL hoạt động (không cần .htaccess):

1. **Trang chủ:**
   ```
   http://localhost/onlinecourse/index.php?url=home
   ```

2. **Đăng nhập:**
   ```
   http://localhost/onlinecourse/index.php?url=auth/login
   ```

3. **Đăng ký:**
   ```
   http://localhost/onlinecourse/index.php?url=auth/register
   ```

4. **Danh sách khóa học:**
   ```
   http://localhost/onlinecourse/index.php?url=course
   ```

5. **Chi tiết khóa học:**
   ```
   http://localhost/onlinecourse/index.php?url=course/detail/1
   ```

6. **Dashboard học viên:**
   ```
   http://localhost/onlinecourse/index.php?url=student/dashboard
   ```

7. **Dashboard giảng viên:**
   ```
   http://localhost/onlinecourse/index.php?url=instructor/dashboard
   ```

---

## 🛠️ HOẶC TẠO CÁC FILE REDIRECT

Tạo các file PHP trong thư mục gốc để redirect:

### File: `login.php`
```php
<?php
header('Location: index.php?url=auth/login');
exit;
?>
```

### File: `register.php`
```php
<?php
header('Location: index.php?url=auth/register');
exit;
?>
```

### File: `courses.php`
```php
<?php
header('Location: index.php?url=course');
exit;
?>
```

Sau đó truy cập:
- `http://localhost/onlinecourse/login.php`
- `http://localhost/onlinecourse/register.php`
- `http://localhost/onlinecourse/courses.php`

---

## 🔍 KIỂM TRA NGUYÊN NHÂN

1. **Truy cập:** `http://localhost/onlinecourse/check.php`
   - Xem mod_rewrite đã bật chưa
   - Xem thông tin server

2. **Nếu mod_rewrite DISABLED:**
   - Cần bật trong Apache config
   - Xem file `SUA_LOI_HTACCESS.txt` để biết cách bật

3. **Nếu đang dùng PHP built-in server:**
   - PHP built-in server KHÔNG hỗ trợ .htaccess
   - Cần dùng XAMPP, MAMP, hoặc Laragon

---

## ✅ GIẢI PHÁP LÂU DÀI

Sau khi bật được mod_rewrite và .htaccess hoạt động:

1. Truy cập: `http://localhost/onlinecourse/auth/login` (không cần index.php?url=)
2. Tất cả URL sẽ đẹp hơn

---

**Bây giờ hãy thử:** `http://localhost/onlinecourse/index.php?url=auth/login`

