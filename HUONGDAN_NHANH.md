# HƯỚNG DẪN NHANH

## 🚀 Bắt đầu nhanh

### 1. Cài đặt Database
```sql
-- Chạy file database.sql trong MySQL
mysql -u root -p < database.sql
```

### 2. Cấu hình
Mở file `config/Database.php` và cập nhật:
```php
private $host = "localhost";
private $db_name = "onlinecourse";
private $username = "root";        // Thay đổi nếu cần
private $password = "";            // Thay đổi nếu cần
```

### 3. Quyền thư mục
```bash
chmod 755 assets/uploads/courses
chmod 755 assets/uploads/materials
chmod 755 assets/uploads/avatars
```

### 4. Truy cập
Mở trình duyệt: `http://localhost/onlinecourse`

---

## 📝 Tài khoản mặc định

Sau khi import database, bạn cần tạo tài khoản:

1. **Đăng ký học viên**: Truy cập `/onlinecourse/auth/register`
2. **Đăng ký giảng viên**: Đăng ký với role = 1
3. **Tạo admin**: Chạy SQL:
```sql
INSERT INTO users (username, email, password, fullname, role) 
VALUES ('admin', 'admin@example.com', '$2y$10$...', 'Admin User', 2);
```

Hoặc đăng ký bình thường rồi update role trong database:
```sql
UPDATE users SET role = 2 WHERE email = 'your-email@example.com';
```

---

## 🗂️ Cấu trúc chính

### Controllers (8 files)
- `HomeController` - Trang chủ
- `AuthController` - Đăng nhập/đăng ký
- `CourseController` - Quản lý khóa học (public)
- `InstructorController` - Quản lý của giảng viên
- `StudentController` - Dashboard học viên
- `EnrollmentController` - Đăng ký khóa học
- `LessonController` - Xem bài học
- `AdminController` - Quản trị hệ thống

### Models (6 files)
- `User` - Người dùng
- `Course` - Khóa học
- `Category` - Danh mục
- `Enrollment` - Đăng ký
- `Lesson` - Bài học
- `Material` - Tài liệu

### Views (30+ files)
- `layouts/` - Header, Footer
- `home/` - Trang chủ
- `auth/` - Đăng nhập, đăng ký
- `courses/` - Danh sách, chi tiết
- `student/` - Dashboard học viên
- `instructor/` - Quản lý giảng viên
- `admin/` - Quản trị

---

## 🔐 Routes chính

### Public
- `/onlinecourse/home` - Trang chủ
- `/onlinecourse/course` - Danh sách khóa học
- `/onlinecourse/course/detail/{id}` - Chi tiết khóa học
- `/onlinecourse/auth/login` - Đăng nhập
- `/onlinecourse/auth/register` - Đăng ký

### Học viên
- `/onlinecourse/student/dashboard` - Dashboard
- `/onlinecourse/enrollment/myCourses` - Khóa học của tôi
- `/onlinecourse/enrollment/progress/{course_id}` - Tiến độ
- `/onlinecourse/lesson/view/{lesson_id}` - Xem bài học

### Giảng viên
- `/onlinecourse/instructor/dashboard` - Dashboard
- `/onlinecourse/instructor/myCourses` - Khóa học của tôi
- `/onlinecourse/instructor/createCourse` - Tạo khóa học
- `/onlinecourse/instructor/course/edit/{id}` - Sửa khóa học
- `/onlinecourse/instructor/course/manage/{id}` - Quản lý khóa học
- `/onlinecourse/instructor/lessons/{course_id}` - Quản lý bài học
- `/onlinecourse/instructor/students/{course_id}` - Danh sách học viên

### Admin
- `/onlinecourse/admin/dashboard` - Dashboard
- `/onlinecourse/admin/users` - Quản lý người dùng
- `/onlinecourse/admin/categories` - Quản lý danh mục

---

## ✅ Checklist trước khi chạy

- [ ] Import database.sql thành công
- [ ] Cấu hình Database.php
- [ ] Thư mục uploads có quyền ghi
- [ ] Apache có mod_rewrite enabled
- [ ] PHP >= 7.4
- [ ] PHP extensions: PDO, PDO_MySQL

---

## 🐛 Xử lý lỗi thường gặp

### Lỗi 404
- Kiểm tra .htaccess đã được load
- Kiểm tra mod_rewrite đã bật
- Kiểm tra RewriteBase trong .htaccess đúng đường dẫn

### Lỗi kết nối database
- Kiểm tra thông tin trong Database.php
- Đảm bảo database đã được tạo
- Kiểm tra MySQL đang chạy

### Lỗi upload file
- Kiểm tra quyền thư mục uploads
- Kiểm tra upload_max_filesize trong php.ini
- Kiểm tra post_max_size trong php.ini

### Session không hoạt động
- Kiểm tra session_start() ở đầu index.php
- Kiểm tra quyền ghi của thư mục session

---

## 📦 File quan trọng

- `index.php` - Entry point, router chính
- `config/Database.php` - Cấu hình database
- `config/helper.php` - Helper functions
- `.htaccess` - URL rewriting
- `database.sql` - Database schema

---

## 🔄 Quy trình làm việc nhóm

1. **Fork/Clone repository**
2. **Tạo branch cho nhóm:**
   ```bash
   git checkout -b nhom1-auth
   ```
3. **Làm việc và commit:**
   ```bash
   git add .
   git commit -m "Nhóm 1: Hoàn thành chức năng X"
   ```
4. **Push và tạo Pull Request:**
   ```bash
   git push origin nhom1-auth
   ```
5. **Review và merge vào main**

---

## 📚 Tài liệu tham khảo

- `README.md` - Hướng dẫn chi tiết
- `PHANCHIA_CONGVIEC.md` - Phân chia công việc đầy đủ
- Video hướng dẫn MVC: #5. Hướng dẫn code PHP MVC cơ bản

---

**Chúc bạn thành công! 🎉**

