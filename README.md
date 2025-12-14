# BTNhom_PAAN - Hệ thống Quản lý Khóa học Trực tuyến

Hệ thống quản lý khóa học trực tuyến được xây dựng bằng PHP thuần, áp dụng mô hình MVC (Model-View-Controller).

## ✨ Tính năng

- **Quản lý người dùng**: Học viên, Giảng viên, Quản trị viên
- **Quản lý khóa học**: Tạo, sửa, xóa, tìm kiếm khóa học
- **Quản lý bài học**: Tạo bài học và tài liệu cho khóa học
- **Đăng ký khóa học**: Học viên có thể đăng ký và theo dõi tiến độ
- **Phân quyền**: Hệ thống phân quyền rõ ràng cho từng vai trò

## 🛠️ Yêu cầu hệ thống

- PHP >= 7.4
- MySQL >= 5.7 hoặc MariaDB >= 10.2
- Apache với mod_rewrite hoặc Nginx
- PDO extension cho PHP

## 📦 Cài đặt

### 1. Clone repository

```bash
git clone https://github.com/quangphu1401-hue/BTNhom_PAAN.git
cd BTNhom_PAAN
```

### 2. Cấu hình database

#### Tạo database:
```sql
CREATE DATABASE onlinecourse CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

#### Import schema:
```bash
mysql -u root -p onlinecourse < database.sql
```

#### (Tùy chọn) Import dữ liệu mẫu:
```bash
mysql -u root -p onlinecourse < insert_sample_courses.sql
```

### 3. Cấu hình ứng dụng

#### Tạo file `.env` từ template:
```bash
cp .env.example .env
```

#### Chỉnh sửa file `.env`:
```env
DB_HOST=localhost
DB_NAME=onlinecourse
DB_USER=root
DB_PASS=your_password

APP_ENV=development
APP_DEBUG=true
APP_URL=http://localhost
```

**Lưu ý**: Nếu không tạo file `.env`, hệ thống sẽ sử dụng giá trị mặc định trong `config/Database.php`.

### 4. Cấu hình web server

#### Apache
Đảm bảo mod_rewrite đã được bật:
```bash
# Ubuntu/Debian
sudo a2enmod rewrite
sudo systemctl restart apache2

# XAMPP: Bật mod_rewrite trong httpd.conf
```

File `.htaccess` đã được cấu hình sẵn.

#### Nginx
Thêm vào cấu hình:
```nginx
location / {
    try_files $uri $uri/ /index.php?url=$uri&$args;
}
```

### 5. Tạo tài khoản admin

#### Cách 1: Sử dụng file utility (Khuyến nghị)
1. Truy cập: `http://localhost/BTNhom_PAAN/create_admin_password.php`
2. Nhập password cho admin
3. Copy SQL được tạo
4. Chạy SQL trong phpMyAdmin
5. **⚠️ XÓA FILE `create_admin_password.php` SAU KHI DÙNG!**

#### Cách 2: Tạo trực tiếp trong phpMyAdmin
```sql
INSERT INTO users (username, email, password, fullname, role) 
VALUES (
    'admin',
    'admin@example.com',
    '$2y$10$...', -- Hash password bằng password_hash('your_password', PASSWORD_DEFAULT)
    'Administrator',
    2
);
```

## 📁 Cấu trúc thư mục

```
BTNhom_PAAN/
├── assets/              # CSS, JS, images
│   ├── css/
│   └── js/
├── config/              # Cấu hình
│   ├── Database.php     # Kết nối database
│   └── helper.php       # Helper functions
├── controllers/         # Controllers (xử lý logic)
│   ├── AdminController.php
│   ├── AuthController.php
│   ├── CourseController.php
│   └── ...
├── models/              # Models (tương tác database)
│   ├── User.php
│   ├── Course.php
│   └── ...
├── views/               # Views (giao diện)
│   ├── admin/          # Views cho admin
│   ├── auth/           # Views đăng nhập/đăng ký
│   ├── courses/        # Views khóa học
│   ├── errors/         # Views lỗi
│   ├── home/           # Trang chủ
│   ├── instructor/     # Views cho giảng viên
│   ├── layouts/        # Layout chung
│   └── student/        # Views cho học viên
├── .env.example        # Template cấu hình
├── .gitignore          # Git ignore rules
├── .htaccess           # Apache rewrite rules
├── index.php           # Entry point
├── database.sql        # Database schema
└── insert_sample_courses.sql  # Dữ liệu mẫu
```

## 🔐 Vai trò người dùng

- **Học viên (role = 0)**: Đăng ký khóa học, xem bài học, theo dõi tiến độ
- **Giảng viên (role = 1)**: Tạo/quản lý khóa học, bài học, tài liệu
- **Quản trị viên (role = 2)**: Quản lý toàn bộ hệ thống

## 🚀 Sử dụng

### Development Mode
Trong file `index.php`, đảm bảo:
```php
define('APP_ENV', 'development');
define('APP_DEBUG', true);
```

Hoặc trong file `.env`:
```env
APP_ENV=development
APP_DEBUG=true
```

### Production Mode
```php
define('APP_ENV', 'production');
define('APP_DEBUG', false);
```

Hoặc trong file `.env`:
```env
APP_ENV=production
APP_DEBUG=false
```

## 🔒 Bảo mật

### ✅ Đã thực hiện:
- Password hashing với bcrypt
- Prepared statements (chống SQL Injection)
- Input sanitization
- Session management
- Error logging trong production

### ⚠️ Khuyến nghị cải thiện:
- CSRF protection
- Rate limiting cho login
- File upload validation
- Security headers (X-Frame-Options, etc.)

## 🐛 Xử lý lỗi

- **404**: Trang không tồn tại → `views/errors/404.php`
- **Database errors**: Log vào error log (production) hoặc hiển thị (development)
- **PHP errors**: Tùy theo `APP_DEBUG` setting

## 📝 Ghi chú quan trọng

1. **File `.env`** không được commit vào Git (đã có trong `.gitignore`)
2. **File `create_admin_password.php`** nên được xóa sau khi tạo tài khoản admin
3. Đổi password admin ngay sau khi tạo tài khoản
4. Trong production, đảm bảo `APP_DEBUG=false` để ẩn thông tin lỗi

## 👥 Đóng góp

1. Fork repository
2. Tạo branch mới (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Tạo Pull Request

## 📄 License

[Thêm license nếu có]

---

**Lưu ý**: Đây là dự án học tập. Vui lòng kiểm tra và cải thiện bảo mật trước khi sử dụng trong môi trường production.
