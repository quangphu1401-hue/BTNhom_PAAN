# Hướng dẫn Cài đặt Nhanh

## Bước 1: Cấu hình Database

```sql
CREATE DATABASE onlinecourse CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

```bash
mysql -u root -p onlinecourse < database.sql
```

## Bước 2: Cấu hình Ứng dụng

Tạo file `.env`:
```bash
cp .env.example .env
```

Chỉnh sửa `.env` với thông tin database của bạn.

## Bước 3: Tạo Tài khoản Admin

Truy cập: `http://localhost/BTNhom_PAAN/create_admin_password.php`

**⚠️ XÓA FILE `create_admin_password.php` SAU KHI DÙNG!**

## Bước 4: Kiểm tra

Truy cập: `http://localhost/BTNhom_PAAN/`

Xem chi tiết trong [README.md](README.md)
