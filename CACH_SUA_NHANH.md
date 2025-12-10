# CÁCH SỬA NHANH LỖI 404

## 🔍 VẤN ĐỀ

Bạn chỉ vào được `localhost/onlinecourse/` nhưng các trang khác đều lỗi 404.

## ✅ GIẢI PHÁP NHANH

### Cách 1: Xóa RewriteBase trong .htaccess (Khuyến nghị)

1. Mở file `.htaccess`
2. **XÓA hoặc COMMENT dòng RewriteBase:**
   ```apache
   # RewriteBase /CNW/onlinecourse/
   # Hoặc xóa dòng này đi
   ```
3. Lưu file
4. Refresh trình duyệt

File `.htaccess` sẽ tự động detect đường dẫn.

### Cách 2: Dùng file .htaccess_auto

1. Xóa hoặc đổi tên file `.htaccess` hiện tại:
   ```bash
   mv .htaccess .htaccess.old
   ```

2. Đổi tên file `.htaccess_auto` thành `.htaccess`:
   ```bash
   mv .htaccess_auto .htaccess
   ```

3. Refresh trình duyệt

### Cách 3: Sửa RewriteBase cho đúng

**Nếu bạn truy cập:** `localhost/onlinecourse/`
```apache
RewriteBase /onlinecourse/
```

**Nếu bạn truy cập:** `localhost/CNW/onlinecourse/`
```apache
RewriteBase /CNW/onlinecourse/
```

## 🧪 TEST NHANH

1. Truy cập: `http://localhost/onlinecourse/test_route.php?url=auth/login`
2. Xem kết quả để biết:
   - Controller nào được gọi
   - File có tồn tại không
   - Method có tồn tại không

## 📋 KIỂM TRA

Sau khi sửa, test các URL này:

1. ✅ `http://localhost/onlinecourse/` - Trang chủ
2. ✅ `http://localhost/onlinecourse/auth/login` - Đăng nhập
3. ✅ `http://localhost/onlinecourse/auth/register` - Đăng ký
4. ✅ `http://localhost/onlinecourse/course` - Danh sách khóa học
5. ✅ `http://localhost/onlinecourse/home` - Trang chủ

## ⚠️ LƯU Ý

- URL không có `.php` ở cuối
- URL viết thường
- Không có dấu `/` ở cuối (trừ trang chủ)

## 🐛 NẾU VẪN LỖI

1. Kiểm tra mod_rewrite đã bật chưa:
   - Tạo file `info.php`: `<?php phpinfo(); ?>`
   - Truy cập và tìm "mod_rewrite"
   - Phải là "enabled"

2. Kiểm tra file controller có tồn tại:
   ```bash
   ls controllers/AuthController.php
   ```

3. Kiểm tra quyền file:
   ```bash
   chmod 644 controllers/*.php
   chmod 755 controllers/
   ```

---

**Thử cách 1 trước - đơn giản nhất!**

