# COPY DỰ ÁN VÀO XAMPP

## 📍 VỊ TRÍ HIỆN TẠI

- Dự án đang ở: `/Users/tophu/onlinecourse/`
- XAMPP htdocs ở: `/Applications/XAMPP/htdocs/`
- Cần copy vào: `/Applications/XAMPP/htdocs/onlinecourse/`

## ✅ CÁCH COPY

### Cách 1: Copy toàn bộ thư mục

Mở Terminal và chạy:

```bash
# Copy toàn bộ dự án vào XAMPP
cp -r /Users/tophu/onlinecourse /Applications/XAMPP/htdocs/

# Kiểm tra đã copy thành công
ls -la /Applications/XAMPP/htdocs/onlinecourse/
```

### Cách 2: Tạo symlink (nhanh hơn, tự động sync)

```bash
# Tạo symlink
ln -s /Users/tophu/onlinecourse /Applications/XAMPP/htdocs/onlinecourse

# Kiểm tra
ls -la /Applications/XAMPP/htdocs/onlinecourse/
```

## 🔍 KIỂM TRA SAU KHI COPY

1. Kiểm tra file index.php có ở đúng chỗ:
   ```bash
   ls -la /Applications/XAMPP/htdocs/onlinecourse/index.php
   ```

2. Kiểm tra thư mục controllers:
   ```bash
   ls -la /Applications/XAMPP/htdocs/onlinecourse/controllers/
   ```

3. Truy cập trong trình duyệt:
   ```
   http://localhost/onlinecourse/
   http://localhost/onlinecourse/index.php
   http://localhost/onlinecourse/test_simple.php
   ```

## ⚠️ LƯU Ý

- Nếu đã có thư mục `onlinecourse` trong htdocs, xóa hoặc đổi tên trước
- Đảm bảo XAMPP đang chạy (Apache và MySQL)
- Kiểm tra port Apache (thường là 80 hoặc 8080)

## 🚀 SAU KHI COPY XONG

1. Truy cập: `http://localhost/onlinecourse/`
2. Nếu vẫn lỗi, thử: `http://localhost/onlinecourse/test_simple.php`
3. Kiểm tra error log của Apache nếu có lỗi

---

**Chạy lệnh copy và cho tôi biết kết quả!**

