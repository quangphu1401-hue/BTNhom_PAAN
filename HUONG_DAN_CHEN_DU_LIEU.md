# HƯỚNG DẪN CHÈN DỮ LIỆU MẪU

## 📋 File SQL đã tạo

File `insert_sample_courses.sql` bao gồm:
- ✅ Tạo 5 giảng viên mẫu
- ✅ Tạo 15 khóa học đa dạng
- ✅ Phân bổ khóa học cho các giảng viên

## 👨‍🏫 5 GIẢNG VIÊN MẪU

1. **Nguyễn Văn An**
   - Username: `instructor1`
   - Email: `instructor1@example.com`
   - Password: `instructor123`

2. **Trần Thị Bình**
   - Username: `instructor2`
   - Email: `instructor2@example.com`
   - Password: `instructor123`

3. **Lê Văn Cường**
   - Username: `instructor3`
   - Email: `instructor3@example.com`
   - Password: `instructor123`

4. **Phạm Thị Dung**
   - Username: `instructor4`
   - Email: `instructor4@example.com`
   - Password: `instructor123`

5. **Hoàng Văn Em**
   - Username: `instructor5`
   - Email: `instructor5@example.com`
   - Password: `instructor123`

## 📚 15 KHÓA HỌC MẪU

### Lập trình (5 khóa):
1. Lập trình PHP từ cơ bản đến nâng cao
2. JavaScript và jQuery cho người mới bắt đầu
3. React.js - Xây dựng ứng dụng web hiện đại
4. Laravel Framework - Phát triển web với PHP
5. Node.js và Express.js - Backend Development

### Thiết kế (4 khóa):
6. Thiết kế UI/UX với Figma
7. Adobe Photoshop cho người mới bắt đầu
8. Thiết kế logo và thương hiệu
9. Web Design với HTML, CSS và Bootstrap

### Marketing (3 khóa):
10. Digital Marketing cơ bản
11. Facebook Ads - Quảng cáo Facebook hiệu quả
12. SEO - Tối ưu hóa công cụ tìm kiếm

### Kinh doanh (3 khóa):
13. Khởi nghiệp từ con số 0
14. Quản lý tài chính cá nhân
15. E-commerce - Bán hàng online thành công

## 🚀 CÁCH SỬ DỤNG

### Bước 1: Mở phpMyAdmin
Truy cập: `http://localhost/phpmyadmin`

### Bước 2: Chọn database
Click vào database `onlinecourse` ở sidebar bên trái

### Bước 3: Import file SQL
1. Click tab **"SQL"** ở menu trên
2. Mở file `insert_sample_courses.sql`
3. Copy toàn bộ nội dung
4. Paste vào khung SQL trong phpMyAdmin
5. Click nút **"Go"** để thực thi

### Hoặc Import từ file:
1. Click tab **"Import"**
2. Chọn file `insert_sample_courses.sql`
3. Click **"Go"**

## ✅ KIỂM TRA KẾT QUẢ

Sau khi import, kiểm tra:

1. **Kiểm tra giảng viên:**
   ```sql
   SELECT * FROM users WHERE role = 1;
   ```
   → Phải có 5 giảng viên

2. **Kiểm tra khóa học:**
   ```sql
   SELECT COUNT(*) FROM courses;
   ```
   → Phải có 15 khóa học

3. **Xem danh sách khóa học:**
   ```sql
   SELECT c.title, u.fullname as instructor, cat.name as category 
   FROM courses c
   LEFT JOIN users u ON c.instructor_id = u.id
   LEFT JOIN categories cat ON c.category_id = cat.id;
   ```

## 🔐 ĐĂNG NHẬP THỬ

Bạn có thể đăng nhập với bất kỳ giảng viên nào:

- Email: `instructor1@example.com` (hoặc instructor2, 3, 4, 5)
- Password: `instructor123`

Sau khi đăng nhập, bạn sẽ vào Dashboard giảng viên và thấy các khóa học đã được phân bổ.

## ⚠️ LƯU Ý

- Password của tất cả giảng viên là: `instructor123`
- Nếu giảng viên đã tồn tại (username trùng), script sẽ bỏ qua (không tạo lại)
- Khóa học sẽ được phân bổ ngẫu nhiên cho các giảng viên
- Giá khóa học từ 400,000 - 1,200,000 VNĐ
- Cấp độ: Beginner, Intermediate, Advanced

---

**Sau khi import xong, refresh trang web và bạn sẽ thấy các khóa học!**

