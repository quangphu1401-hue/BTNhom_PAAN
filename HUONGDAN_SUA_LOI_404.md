# HƯỚNG DẪN SỬA LỖI 404

## 🔍 VẤN ĐỀ

Chỉ truy cập được trang chủ `/` nhưng tất cả các trang khác đều bị lỗi 404.

## ✅ CÁC BƯỚC KIỂM TRA VÀ SỬA

### Bước 1: Kiểm tra .htaccess

Mở file `.htaccess` và đảm bảo `RewriteBase` đúng với đường dẫn của bạn:

**Nếu dự án ở:** `localhost/CNW/onlinecourse/`
```apache
RewriteBase /CNW/onlinecourse/
```

**Nếu dự án ở:** `localhost/onlinecourse/`
```apache
RewriteBase /onlinecourse/
```

### Bước 2: Kiểm tra mod_rewrite đã bật chưa

1. Tạo file `info.php` trong thư mục onlinecourse:
```php
<?php
phpinfo();
?>
```

2. Truy cập: `http://localhost/CNW/onlinecourse/info.php`
3. Tìm "mod_rewrite" - phải là "enabled"
4. **Xóa file info.php sau khi kiểm tra xong**

### Bước 3: Test routing

1. Truy cập: `http://localhost/CNW/onlinecourse/test_route.php?url=auth/login`
2. Xem kết quả để biết:
   - Controller nào sẽ được gọi
   - Method nào sẽ được gọi
   - File có tồn tại không
   - Class và method có tồn tại không

### Bước 4: Kiểm tra đường dẫn trong config

Mở file `config/helper.php` và kiểm tra các đường dẫn redirect:

```php
// Nếu dự án ở /CNW/onlinecourse/
header('Location: /CNW/onlinecourse/auth/login');

// Nếu dự án ở /onlinecourse/
header('Location: /onlinecourse/auth/login');
```

### Bước 5: Kiểm tra file controller có tồn tại

Kiểm tra các file controller:
- ✅ `controllers/AuthController.php`
- ✅ `controllers/CourseController.php`
- ✅ `controllers/HomeController.php`

## 🔧 CÁCH SỬA NHANH

### Nếu RewriteBase sai:

1. Mở file `.htaccess`
2. Thay đổi dòng `RewriteBase` cho đúng với đường dẫn của bạn
3. Lưu file
4. Refresh trình duyệt

### Nếu mod_rewrite chưa bật:

**Trên XAMPP/MAMP:**
1. Mở file cấu hình Apache (`httpd.conf`)
2. Tìm dòng: `#LoadModule rewrite_module modules/mod_rewrite.so`
3. Bỏ dấu `#` ở đầu
4. Restart Apache

**Trên Mac với MAMP:**
- MAMP thường đã bật sẵn mod_rewrite

### Nếu router logic có vấn đề:

File `index.php` đã được cập nhật với logic routing đơn giản và rõ ràng hơn. 

## 📝 TEST CÁC URL SAU KHI SỬA

1. Trang chủ: `http://localhost/CNW/onlinecourse/`
2. Đăng nhập: `http://localhost/CNW/onlinecourse/auth/login`
3. Đăng ký: `http://localhost/CNW/onlinecourse/auth/register`
4. Danh sách khóa học: `http://localhost/CNW/onlinecourse/course`

## 🐛 DEBUG

Nếu vẫn lỗi, mở file `index.php` và bỏ comment dòng debug:

```php
// Bỏ comment dòng này để xem log
error_log("Controller: $controller_name, Method: $method, Params: " . print_r($params, true));
```

Sau đó kiểm tra log file của Apache để xem router đang xử lý như thế nào.

## ⚠️ LƯU Ý

1. **Luôn dùng URL không có .php:**
   - ✅ `auth/login`
   - ❌ `auth/login.php`

2. **Kiểm tra đường dẫn trong helper.php:**
   - Tất cả các hàm `redirect()` và `header()` phải có đường dẫn đúng

3. **Xóa file test sau khi debug:**
   - `test_route.php`
   - `info.php` (nếu tạo)

## 📞 KIỂM TRA NHANH

Chạy lệnh này trong terminal để kiểm tra:

```bash
cd /Users/tophu/onlinecourse
ls -la controllers/
```

Nếu thấy đầy đủ các file controller, thì vấn đề nằm ở routing hoặc .htaccess.

---

**Sau khi sửa xong, refresh trình duyệt và thử lại!**

