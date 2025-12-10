# HƯỚNG DẪN TẠO DATABASE VỚI PHPMYADMIN

## 📋 Bước 1: Truy cập phpMyAdmin

1. Mở trình duyệt và truy cập: `http://localhost/phpmyadmin`
2. Đăng nhập với thông tin MySQL của bạn:
   - Username: `root` (hoặc username của bạn)
   - Password: (để trống hoặc nhập password)
   - Server: `localhost`

---

## 🗄️ Bước 2: Tạo Database mới

### Cách 1: Tạo database thủ công

1. Click vào tab **"Databases"** ở menu trên
2. Trong phần **"Create database"**:
   - Database name: `onlinecourse`
   - Collation: Chọn `utf8mb4_unicode_ci`
3. Click nút **"Create"**

### Cách 2: Tạo database bằng SQL

1. Click vào tab **"SQL"** ở menu trên
2. Nhập lệnh sau:
```sql
CREATE DATABASE IF NOT EXISTS onlinecourse CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```
3. Click nút **"Go"** để thực thi

---

## 📥 Bước 3: Import file SQL

### Cách 1: Import từ file (Khuyến nghị)

1. Chọn database `onlinecourse` ở sidebar bên trái
2. Click vào tab **"Import"** ở menu trên
3. Trong phần **"File to import"**:
   - Click nút **"Choose File"** hoặc **"Browse"**
   - Tìm và chọn file `database.sql` trong thư mục dự án
4. Đảm bảo các tùy chọn:
   - Format: `SQL`
   - Character set: `utf8mb4`
5. Click nút **"Go"** ở cuối trang để import

### Cách 2: Copy và paste SQL

1. Chọn database `onlinecourse` ở sidebar bên trái
2. Click vào tab **"SQL"** ở menu trên
3. Mở file `database.sql` bằng Notepad/TextEdit
4. Copy toàn bộ nội dung file
5. Paste vào khung SQL trong phpMyAdmin
6. Click nút **"Go"** để thực thi

---

## ✅ Bước 4: Kiểm tra kết quả

1. Sau khi import thành công, bạn sẽ thấy thông báo:
   - "Import has been successfully finished"
   - Số lượng queries đã thực thi

2. Kiểm tra các bảng đã được tạo:
   - Click vào database `onlinecourse` ở sidebar
   - Bạn sẽ thấy 6 bảng:
     - `categories`
     - `courses`
     - `enrollments`
     - `lessons`
     - `materials`
     - `users`

3. Kiểm tra dữ liệu mẫu:
   - Click vào bảng `categories`
   - Click tab **"Browse"**
   - Bạn sẽ thấy 4 danh mục mẫu đã được thêm

---

## 🔍 Bước 5: Xem cấu trúc bảng

Để xem cấu trúc của từng bảng:

1. Click vào tên bảng (ví dụ: `users`)
2. Click tab **"Structure"**
3. Bạn sẽ thấy:
   - Tên các cột
   - Kiểu dữ liệu
   - Khóa chính (Primary Key)
   - Khóa ngoại (Foreign Key)
   - Indexes

---

## 🛠️ Bước 6: Tạo tài khoản Admin đầu tiên (Tùy chọn)

Nếu muốn tạo tài khoản admin ngay từ đầu:

1. Click vào tab **"SQL"**
2. Nhập lệnh sau (thay đổi thông tin nếu cần):

```sql
-- Tạo tài khoản admin
-- Password: admin123 (bạn nên đổi sau khi đăng nhập)
INSERT INTO users (username, email, password, fullname, role) 
VALUES (
    'admin',
    'admin@example.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'Administrator',
    2
);
```

Hoặc tạo password mới:

1. Mở file PHP tạo hash password (tạm thời):
   ```php
   <?php
   echo password_hash('your_password_here', PASSWORD_DEFAULT);
   ?>
   ```
2. Chạy file này để lấy hash
3. Thay hash vào lệnh SQL trên

---

## 📝 Bước 7: Cập nhật cấu hình Database

Mở file `config/Database.php` và đảm bảo thông tin đúng:

```php
private $host = "localhost";
private $db_name = "onlinecourse";
private $username = "root";        // Thay đổi nếu bạn dùng username khác
private $password = "";            // Thay đổi nếu bạn có password
```

**Lưu ý:**
- Nếu bạn dùng XAMPP/WAMP, thường là `root` và password để trống
- Nếu bạn dùng MAMP (Mac), có thể cần username `root` và password `root`
- Nếu bạn dùng Laragon, có thể password để trống

---

## 🐛 Xử lý lỗi thường gặp

### Lỗi: "#1044 - Access denied for user"
- **Nguyên nhân**: User không có quyền tạo database
- **Giải pháp**: 
  - Dùng tài khoản root
  - Hoặc yêu cầu admin cấp quyền

### Lỗi: "#1064 - Syntax error"
- **Nguyên nhân**: File SQL có lỗi cú pháp
- **Giải pháp**: 
  - Kiểm tra lại file `database.sql`
  - Đảm bảo chọn đúng encoding UTF-8 khi import

### Lỗi: "#1050 - Table already exists"
- **Nguyên nhân**: Bảng đã tồn tại
- **Giải pháp**: 
  - Xóa database và tạo lại
  - Hoặc chọn "Add IF NOT EXISTS" trong file SQL

### Lỗi: "#1215 - Cannot add foreign key constraint"
- **Nguyên nhân**: Engine bảng không phải InnoDB hoặc thứ tự tạo bảng sai
- **Giải pháp**: 
  - File SQL đã được tối ưu với ENGINE=InnoDB
  - Đảm bảo import đúng thứ tự

### Lỗi khi import file lớn
- **Nguyên nhân**: Giới hạn upload size của phpMyAdmin
- **Giải pháp**:
  1. Tăng `upload_max_filesize` trong php.ini
  2. Tăng `post_max_size` trong php.ini
  3. Hoặc copy-paste SQL thay vì import file

---

## 📋 Checklist hoàn thành

- [ ] Đã tạo database `onlinecourse`
- [ ] Đã import file `database.sql` thành công
- [ ] Đã kiểm tra 6 bảng được tạo
- [ ] Đã kiểm tra dữ liệu mẫu trong `categories`
- [ ] Đã cập nhật thông tin trong `config/Database.php`
- [ ] Đã tạo tài khoản admin (nếu cần)

---

## 🎯 Bước tiếp theo

1. Cấu hình file `config/Database.php`
2. Set quyền thư mục uploads:
   ```bash
   chmod 755 assets/uploads/courses
   chmod 755 assets/uploads/materials
   ```
3. Truy cập website: `http://localhost/onlinecourse`
4. Đăng ký tài khoản đầu tiên!

---

## 💡 Mẹo hữu ích

### Xem dữ liệu nhanh
- Click vào bảng → Tab "Browse" để xem dữ liệu
- Click vào tab "Search" để tìm kiếm

### Sửa dữ liệu trực tiếp
- Click vào bảng → Tab "Browse"
- Click icon bút chì để sửa
- Click icon thùng rác để xóa

### Export database
- Chọn database → Tab "Export"
- Chọn "Quick" hoặc "Custom" để tùy chỉnh
- Chọn format SQL và click "Go"

### Sao lưu (Backup)
- Nên export database định kỳ
- Lưu file backup ở nơi an toàn

---

**Chúc bạn thành công! 🎉**

Nếu gặp vấn đề, hãy kiểm tra phần "Xử lý lỗi thường gặp" ở trên.

