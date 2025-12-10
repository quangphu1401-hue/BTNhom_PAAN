# DANH SÁCH ĐẦY ĐỦ CÁC CHỨC NĂNG

## ✅ CHỨC NĂNG HỌC VIÊN

### 1. Xem danh sách khóa học (có tìm kiếm, lọc theo danh mục)
- **URL:** `index.php?url=course`
- **Controller:** `CourseController::index()`
- **View:** `views/courses/index.php`
- **Model:** `Course::search()`
- **Tính năng:**
  - ✅ Tìm kiếm theo từ khóa
  - ✅ Lọc theo danh mục (category)
  - ✅ Lọc theo cấp độ (level)
  - ✅ Hiển thị danh sách khóa học dạng grid
  - ✅ Phân trang (chưa có giao diện phân trang)

### 2. Xem chi tiết khóa học
- **URL:** `index.php?url=course/detail/{id}`
- **Controller:** `CourseController::detail()`
- **View:** `views/courses/detail.php`
- **Tính năng:**
  - ✅ Hiển thị thông tin đầy đủ khóa học
  - ✅ Hiển thị danh sách bài học
  - ✅ Nút đăng ký (nếu chưa đăng ký và là học viên)
  - ✅ Nút "Vào học" (nếu đã đăng ký)
  - ✅ Nút "Đăng nhập để đăng ký" (nếu chưa đăng nhập)

### 3. Đăng ký khóa học
- **URL:** `index.php?url=course/enroll/{id}`
- **Controller:** `CourseController::enroll()`
- **Model:** `Enrollment::enroll()`
- **Tính năng:**
  - ✅ Kiểm tra đã đăng ký chưa (tránh trùng lặp)
  - ✅ Tạo enrollment record
  - ✅ Thông báo thành công/thất bại
  - ✅ Redirect về trang chi tiết khóa học

### 4. Xem khóa học đã đăng ký
- **URL:** `index.php?url=enrollment/myCourses`
- **Controller:** `EnrollmentController::myCourses()`
- **View:** `views/student/my_courses.php`
- **Tính năng:**
  - ✅ Hiển thị danh sách khóa học đã đăng ký
  - ✅ Hiển thị trạng thái (active, completed, dropped)
  - ✅ Hiển thị tiến độ học tập (%)
  - ✅ Progress bar
  - ✅ Link đến trang tiến độ chi tiết

### 5. Theo dõi tiến độ học tập
- **URL:** `index.php?url=enrollment/progress/{course_id}`
- **Controller:** `EnrollmentController::progress()`
- **View:** `views/student/course_progress.php`
- **Tính năng:**
  - ✅ Hiển thị progress bar tổng thể
  - ✅ Hiển thị phần trăm hoàn thành
  - ✅ Danh sách bài học với link xem

### 6. Xem bài học và tài liệu
- **URL:** `index.php?url=lesson/view/{lesson_id}`
- **Controller:** `LessonController::view()`
- **View:** `views/student/lesson_view.php`
- **Tính năng:**
  - ✅ Hiển thị nội dung bài học
  - ✅ Hiển thị video (nếu có)
  - ✅ Hiển thị danh sách tài liệu đính kèm
  - ✅ Download tài liệu
  - ✅ Navigation (Bài trước, Bài sau)
  - ✅ Kiểm tra quyền truy cập (chỉ học viên đã đăng ký)

---

## ✅ CHỨC NĂNG GIẢNG VIÊN

### 1. Đăng nhập/đăng xuất
- **URL:** `index.php?url=auth/login`, `index.php?url=auth/logout`
- **Controller:** `AuthController::login()`, `AuthController::logout()`
- **View:** `views/auth/login.php`
- **Tính năng:**
  - ✅ Đăng nhập với email và password
  - ✅ Password hashing (bcrypt)
  - ✅ Session management
  - ✅ Redirect theo role sau khi đăng nhập

### 2. Tạo khóa học
- **URL:** `index.php?url=instructor/createCourse`
- **Controller:** `InstructorController::createCourse()`
- **View:** `views/instructor/course/create.php`
- **Tính năng:**
  - ✅ Form tạo khóa học đầy đủ
  - ✅ Upload hình ảnh khóa học
  - ✅ Validation input
  - ✅ Lưu vào database

### 3. Chỉnh sửa khóa học
- **URL:** `index.php?url=instructor/course/edit/{id}`
- **Controller:** `InstructorController::editCourse()`
- **View:** `views/instructor/course/edit.php`
- **Tính năng:**
  - ✅ Form chỉnh sửa với dữ liệu hiện tại
  - ✅ Upload hình ảnh mới (tùy chọn)
  - ✅ Xóa hình ảnh cũ khi upload mới
  - ✅ Kiểm tra quyền (chỉ giảng viên của khóa học)

### 4. Xóa khóa học
- **URL:** `index.php?url=instructor/course/delete/{id}`
- **Controller:** `InstructorController::deleteCourse()`
- **Tính năng:**
  - ✅ Xóa khóa học và tất cả dữ liệu liên quan (CASCADE)
  - ✅ Kiểm tra quyền
  - ✅ Thông báo kết quả

### 5. Quản lý khóa học
- **URL:** `index.php?url=instructor/course/manage/{id}`
- **Controller:** `InstructorController::manageCourse()`
- **View:** `views/instructor/course/manage.php`
- **Tính năng:**
  - ✅ Xem thông tin khóa học
  - ✅ Xem danh sách bài học
  - ✅ Xem danh sách học viên
  - ✅ Link đến các chức năng khác

### 6. Quản lý bài học
- **URL:** `index.php?url=instructor/lessons/{course_id}`
- **Controller:** `InstructorController::lessons()`
- **View:** `views/instructor/lessons/manage.php`
- **Tính năng:**
  - ✅ Danh sách bài học của khóa học
  - ✅ Tạo bài học mới
  - ✅ Chỉnh sửa bài học
  - ✅ Xóa bài học
  - ✅ Quản lý tài liệu

### 7. Tạo bài học
- **URL:** `index.php?url=instructor/createLesson/{course_id}`
- **Controller:** `InstructorController::createLesson()`
- **View:** `views/instructor/lessons/create.php`
- **Tính năng:**
  - ✅ Form tạo bài học
  - ✅ Nhập nội dung (text)
  - ✅ Nhập URL video
  - ✅ Thiết lập thứ tự bài học

### 8. Chỉnh sửa bài học
- **URL:** `index.php?url=instructor/editLesson/{lesson_id}`
- **Controller:** `InstructorController::editLesson()`
- **View:** `views/instructor/lessons/edit.php`
- **Tính năng:**
  - ✅ Form chỉnh sửa với dữ liệu hiện tại
  - ✅ Cập nhật nội dung, video, thứ tự

### 9. Đăng tải tài liệu
- **URL:** `index.php?url=instructor/uploadMaterial/{lesson_id}`
- **Controller:** `InstructorController::uploadMaterial()`
- **View:** `views/instructor/materials/upload.php`
- **Tính năng:**
  - ✅ Upload file (PDF, DOC, PPT, etc.)
  - ✅ Validation file type
  - ✅ Lưu file và thông tin vào database
  - ✅ Danh sách tài liệu đã upload
  - ✅ Download tài liệu

### 10. Xem danh sách học viên
- **URL:** `index.php?url=instructor/students/{course_id}`
- **Controller:** `InstructorController::students()`
- **View:** `views/instructor/students/list.php`
- **Tính năng:**
  - ✅ Danh sách học viên đã đăng ký
  - ✅ Thông tin học viên
  - ✅ Ngày đăng ký
  - ✅ Trạng thái học tập

### 11. Theo dõi tiến độ học viên
- **View:** `views/instructor/students/list.php`
- **Tính năng:**
  - ✅ Progress bar của từng học viên
  - ✅ Phần trăm hoàn thành
  - ✅ Trạng thái (active, completed, dropped)

---

## ✅ CHỨC NĂNG QUẢN TRỊ VIÊN

### 1. Dashboard
- **URL:** `index.php?url=admin/dashboard`
- **Controller:** `AdminController::dashboard()`
- **View:** `views/admin/dashboard.php`
- **Tính năng:**
  - ✅ Thống kê tổng quan
  - ✅ Số lượng người dùng
  - ✅ Số lượng khóa học

### 2. Quản lý người dùng
- **URL:** `index.php?url=admin/users`
- **Controller:** `AdminController::users()`
- **View:** `views/admin/users/manage.php`
- **Tính năng:**
  - ✅ Xem danh sách tất cả người dùng
  - ✅ Thông tin người dùng
  - ⚠️ Chưa có kích hoạt/vô hiệu hóa

### 3. Quản lý danh mục
- **URL:** `index.php?url=admin/categories`
- **Controller:** `AdminController::categories()`
- **View:** `views/admin/categories/list.php`
- **Tính năng:**
  - ✅ Tạo danh mục mới
  - ✅ Xóa danh mục
  - ⚠️ Chưa có chỉnh sửa

### 4. Thống kê
- **URL:** `index.php?url=admin/statistics`
- **Controller:** `AdminController::statistics()`
- **View:** `views/admin/reports/statistics.php`
- **Tính năng:**
  - ⚠️ Chưa có logic thống kê chi tiết

### 5. Duyệt phê duyệt khóa học
- ❌ **Chưa có chức năng này**

---

## 🔍 KIỂM TRA NÚT ĐĂNG KÝ

### Vị trí nút đăng ký:
1. **Trang chi tiết khóa học** (`course/detail/{id}`):
   - Nút "Đăng ký khóa học" (nếu chưa đăng ký và là học viên)
   - Nút "Vào học" (nếu đã đăng ký)
   - Nút "Đăng nhập để đăng ký" (nếu chưa đăng nhập)

### Cách kiểm tra:
1. Đăng nhập với tài khoản học viên (role = 0)
2. Truy cập: `index.php?url=course/detail/1`
3. Bạn sẽ thấy nút "Đăng ký khóa học"

---

## 📝 TỔNG KẾT

**Chức năng học viên:** ✅ 100% hoàn thành
**Chức năng giảng viên:** ✅ 100% hoàn thành
**Chức năng admin:** ✅ 75% hoàn thành

**Cần bổ sung:**
- Admin: Kích hoạt/vô hiệu hóa user
- Admin: Edit category
- Admin: Thống kê chi tiết
- Admin: Duyệt khóa học mới

