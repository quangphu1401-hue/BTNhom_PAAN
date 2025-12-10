# KIỂM TRA VÀ SỬA LỖI .HTACCESS

## 🔍 VẤN ĐỀ

Tất cả các trang đều bị lỗi 404, có nghĩa là `.htaccess` không hoạt động hoặc mod_rewrite chưa bật.

## ✅ GIẢI PHÁP TỪNG BƯỚC

### Bước 1: Kiểm tra mod_rewrite đã bật chưa

Tạo file `check.php` trong thư mục onlinecourse:

```php
<?php
if (function_exists('apache_get_modules')) {
    $modules = apache_get_modules();
    if (in_array('mod_rewrite', $modules)) {
        echo "mod_rewrite: ENABLED ✅<br>";
    } else {
        echo "mod_rewrite: DISABLED ❌<br>";
        echo "Cần bật mod_rewrite trong Apache!<br>";
    }
} else {
    echo "Không thể kiểm tra mod_rewrite<br>";
    echo "Có thể bạn đang dùng PHP built-in server (không hỗ trợ .htaccess)<br>";
}
phpinfo();
?>
```

Truy cập: `http://localhost/onlinecourse/check.php`

### Bước 2: Nếu mod_rewrite DISABLED

**Trên XAMPP/MAMP:**

1. Mở file cấu hình Apache:
   - XAMPP: `xampp/apache/conf/httpd.conf`
   - MAMP: `/Applications/MAMP/conf/apache/httpd.conf`

2. Tìm dòng:
   ```apache
   #LoadModule rewrite_module modules/mod_rewrite.so
   ```

3. Bỏ dấu `#` ở đầu:
   ```apache
   LoadModule rewrite_module modules/mod_rewrite.so
   ```

4. Tìm và sửa:
   ```apache
   <Directory />
       Options FollowSymLinks
       AllowOverride None  ← Đổi thành AllowOverride All
       Require all denied
   </Directory>
   
   <Directory "/path/to/htdocs">
       Options Indexes FollowSymLinks
       AllowOverride None  ← Đổi thành AllowOverride All
       Require all granted
   </Directory>
   ```

5. Restart Apache

### Bước 3: Nếu đang dùng PHP built-in server

PHP built-in server KHÔNG hỗ trợ .htaccess!

**Giải pháp:** Dùng XAMPP, MAMP, hoặc Laragon

### Bước 4: Kiểm tra .htaccess có được đọc không

Tạo file `.htaccess` với nội dung:

```apache
# Test .htaccess
ErrorDocument 404 "HTACCESS WORKS!"
```

Nếu thấy thông báo "HTACCESS WORKS!" khi truy cập URL không tồn tại, nghĩa là .htaccess đang hoạt động.

### Bước 5: Sửa lại .htaccess

File `.htaccess` đã được cập nhật với cấu hình đơn giản hơn.

Nếu vẫn không được, thử cách này:

```apache
RewriteEngine On
RewriteBase /onlinecourse/

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php?url=$1 [L,QSA]
```

### Bước 6: Test trực tiếp với index.php

Thay vì dùng URL đẹp, test trực tiếp:

```
http://localhost/onlinecourse/index.php?url=auth/login
http://localhost/onlinecourse/index.php?url=course
http://localhost/onlinecourse/index.php?url=home
```

Nếu các URL này hoạt động, vấn đề nằm ở .htaccess.

## 🚨 GIẢI PHÁP TẠM THỜI

Nếu .htaccess không hoạt động, bạn có thể:

1. **Truy cập trực tiếp qua index.php:**
   - `index.php?url=auth/login`
   - `index.php?url=course`

2. **Hoặc tạo các file PHP redirect trong thư mục gốc:**
   - `login.php` → redirect đến `index.php?url=auth/login`
   - `register.php` → redirect đến `index.php?url=auth/register`

## 📋 CHECKLIST

- [ ] mod_rewrite đã bật?
- [ ] AllowOverride All trong httpd.conf?
- [ ] .htaccess có đúng định dạng?
- [ ] Apache đã restart sau khi sửa?
- [ ] File .htaccess có quyền đọc?

---

**Sau khi kiểm tra, hãy cho tôi biết kết quả!**

