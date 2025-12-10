# CÁCH TRUY CẬP ĐÚNG - WEBSITE MVC

## ❌ SAI - KHÔNG ĐƯỢC TRUY CẬP TRỰC TIẾP FILE PHP

```
localhost/CNW/onlinecourse/auth/login.php  ❌ SAI
localhost/CNW/onlinecourse/views/auth/login.php  ❌ SAI
```

**Lý do:** Với mô hình MVC, tất cả request phải đi qua router (index.php)

---

## ✅ ĐÚNG - TRUY CẬP QUA ROUTER

### 1. Trang chủ
```
http://localhost/CNW/onlinecourse/
http://localhost/CNW/onlinecourse/home
```

### 2. Đăng nhập
```
http://localhost/CNW/onlinecourse/auth/login
```

### 3. Đăng ký
```
http://localhost/CNW/onlinecourse/auth/register
```

### 4. Danh sách khóa học
```
http://localhost/CNW/onlinecourse/course
http://localhost/CNW/onlinecourse/course/index
```

### 5. Chi tiết khóa học (thay {id} bằng số)
```
http://localhost/CNW/onlinecourse/course/detail/1
```

### 6. Dashboard học viên
```
http://localhost/CNW/onlinecourse/student/dashboard
```

### 7. Dashboard giảng viên
```
http://localhost/CNW/onlinecourse/instructor/dashboard
```

### 8. Dashboard admin
```
http://localhost/CNW/onlinecourse/admin/dashboard
```

---

## 🔧 CẤU HÌNH .HTACCESS

File `.htaccess` cần có RewriteBase đúng với đường dẫn của bạn:

```apache
RewriteBase /CNW/onlinecourse/
```

Nếu dự án của bạn ở đường dẫn khác, hãy thay đổi RewriteBase cho phù hợp:

- Nếu ở: `localhost/onlinecourse/` → `RewriteBase /onlinecourse/`
- Nếu ở: `localhost/CNW/onlinecourse/` → `RewriteBase /CNW/onlinecourse/`
- Nếu ở: `localhost/projects/onlinecourse/` → `RewriteBase /projects/onlinecourse/`

---

## 📝 QUY TẮC URL TRONG MVC

### Cấu trúc URL:
```
http://localhost/CNW/onlinecourse/{controller}/{method}/{params}
```

### Ví dụ:
- `auth/login` 
  - Controller: `AuthController`
  - Method: `login()`
  
- `course/detail/5`
  - Controller: `CourseController`
  - Method: `detail()`
  - Param: `5`

- `instructor/course/manage/10`
  - Controller: `InstructorController`
  - Method: `manageCourse()`
  - Param: `10`

---

## 🛠️ KIỂM TRA VÀ SỬA LỖI

### 1. Kiểm tra .htaccess có hoạt động không

Tạo file `test.php` trong thư mục onlinecourse:
```php
<?php
echo "OK";
?>
```

Truy cập: `http://localhost/CNW/onlinecourse/test.php`
- Nếu thấy "OK" → .htaccess chưa hoạt động
- Nếu thấy lỗi 404 → .htaccess đang hoạt động (tốt)

**Lưu ý:** Sau khi test xong, hãy xóa file test.php

### 2. Kiểm tra mod_rewrite đã bật chưa

Tạo file `info.php`:
```php
<?php
phpinfo();
?>
```

Truy cập và tìm "mod_rewrite" - phải là "enabled"

### 3. Kiểm tra RewriteBase

Mở file `.htaccess` và đảm bảo RewriteBase đúng với đường dẫn của bạn:
```
RewriteBase /CNW/onlinecourse/
```

### 4. Kiểm tra file index.php có tồn tại không

```
http://localhost/CNW/onlinecourse/index.php
```

Nếu không thấy lỗi, file tồn tại.

---

## 🚨 XỬ LÝ LỖI 404

### Lỗi: "Object not found!"

**Nguyên nhân:**
1. RewriteBase trong .htaccess sai
2. mod_rewrite chưa bật
3. Đang truy cập trực tiếp file PHP thay vì qua router

**Giải pháp:**

1. **Sửa RewriteBase:**
   - Mở file `.htaccess`
   - Đổi `RewriteBase /onlinecourse/` thành `RewriteBase /CNW/onlinecourse/`

2. **Bật mod_rewrite:**
   - Mở `httpd.conf` hoặc file cấu hình Apache
   - Tìm dòng `#LoadModule rewrite_module modules/mod_rewrite.so`
   - Bỏ dấu `#` ở đầu
   - Restart Apache

3. **Truy cập đúng URL:**
   - Không truy cập trực tiếp file `.php`
   - Luôn truy cập qua router: `auth/login` (không có .php)

---

## 📋 DANH SÁCH URL ĐẦY ĐỦ

### PUBLIC (Không cần đăng nhập)
```
/                               → Trang chủ
/home                           → Trang chủ
/course                         → Danh sách khóa học
/course/index                   → Danh sách khóa học
/course/detail/{id}             → Chi tiết khóa học
/auth/login                     → Đăng nhập
/auth/register                  → Đăng ký
```

### HỌC VIÊN (Cần đăng nhập, role = 0)
```
/student/dashboard              → Dashboard học viên
/enrollment/myCourses           → Khóa học của tôi
/enrollment/progress/{id}       → Tiến độ học tập
/lesson/view/{id}               → Xem bài học
```

### GIẢNG VIÊN (Cần đăng nhập, role = 1)
```
/instructor/dashboard           → Dashboard giảng viên
/instructor/myCourses           → Khóa học của tôi
/instructor/createCourse        → Tạo khóa học mới
/instructor/course/edit/{id}    → Sửa khóa học
/instructor/course/manage/{id}  → Quản lý khóa học
/instructor/lessons/{id}        → Quản lý bài học
/instructor/students/{id}       → Danh sách học viên
```

### ADMIN (Cần đăng nhập, role = 2)
```
/admin/dashboard                → Dashboard admin
/admin/users                    → Quản lý người dùng
/admin/categories               → Quản lý danh mục
/admin/statistics               → Thống kê
```

---

## 💡 LƯU Ý QUAN TRỌNG

1. **KHÔNG truy cập trực tiếp file PHP:**
   - ❌ `auth/login.php`
   - ✅ `auth/login`

2. **URL không có extension:**
   - ❌ `.php`, `.html`
   - ✅ Không có đuôi

3. **Viết thường:**
   - Controller: `auth`, `course`, `instructor`
   - Method: `login`, `register`, `dashboard`

4. **Params là số hoặc chuỗi:**
   - `/course/detail/1` → id = 1
   - `/course/detail/abc` → id = "abc"

---

## 🎯 BẮT ĐẦU NGAY

1. Mở trình duyệt
2. Truy cập: `http://localhost/CNW/onlinecourse/`
3. Hoặc: `http://localhost/CNW/onlinecourse/auth/login`

**Nếu vẫn lỗi, kiểm tra lại:**
- File `.htaccess` có RewriteBase đúng chưa?
- mod_rewrite đã bật chưa?
- File `index.php` có tồn tại không?

---

**Chúc bạn thành công! 🎉**

