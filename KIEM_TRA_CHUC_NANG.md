# KIỂM TRA ĐẦY ĐỦ CÁC CHỨC NĂNG

## ✅ CHECKLIST CHỨC NĂNG

### 👨‍🎓 CHỨC NĂNG HỌC VIÊN

- [x] **Xem danh sách khóa học (có tìm kiếm, lọc theo danh mục)**
  - Controller: `CourseController::index()`
  - View: `views/courses/index.php`
  - Model: `Course::search()`
  - ✅ Đã có tìm kiếm theo keyword
  - ✅ Đã có lọc theo category
  - ✅ Đã có lọc theo level

- [x] **Xem chi tiết khóa học**
  - Controller: `CourseController::detail()`
  - View: `views/courses/detail.php`
  - URL: `course/detail/{id}`
  - ✅ Hiển thị thông tin khóa học
  - ✅ Hiển thị danh sách bài học
  - ✅ Hiển thị nút đăng ký (nếu chưa đăng ký)

- [x] **Đăng ký khóa học**
  - Controller: `CourseController::enroll()`
  - Model: `Enrollment::enroll()`
  - URL: `course/enroll/{id}`
  - ✅ Kiểm tra đã đăng ký chưa
  - ✅ Tạo enrollment record
  - ✅ Hiển thị thông báo thành công/thất bại

- [x] **Xem khóa học đã đăng ký**
  - Controller: `EnrollmentController::myCourses()`
  - View: `views/student/my_courses.php`
  - URL: `enrollment/myCourses`
  - ✅ Hiển thị danh sách khóa học đã đăng ký
  - ✅ Hiển thị trạng thái và tiến độ

- [x] **Theo dõi tiến độ học tập**
  - Controller: `EnrollmentController::progress()`
  - View: `views/student/course_progress.php`
  - URL: `enrollment/progress/{id}`
  - ✅ Hiển thị progress bar
  - ✅ Hiển thị danh sách bài học
  - ✅ Link đến từng bài học

- [x] **Xem bài học và tài liệu**
  - Controller: `LessonController::view()`
  - View: `views/student/lesson_view.php`
  - URL: `lesson/view/{id}`
  - ✅ Hiển thị nội dung bài học
  - ✅ Hiển thị video (nếu có)
  - ✅ Hiển thị tài liệu đính kèm
  - ✅ Navigation giữa các bài học

### 👨‍🏫 CHỨC NĂNG GIẢNG VIÊN

- [x] **Đăng nhập/đăng xuất**
  - Controller: `AuthController::login()`, `AuthController::logout()`
  - Views: `views/auth/login.php`
  - ✅ Đăng nhập với email và password
  - ✅ Phân quyền theo role
  - ✅ Redirect đến dashboard đúng vai trò

- [x] **Tạo, chỉnh sửa, xóa khóa học**
  - Controller: `InstructorController::createCourse()`, `editCourse()`, `deleteCourse()`
  - Views: `views/instructor/course/create.php`, `edit.php`
  - Models: `Course::create()`, `update()`, `delete()`
  - ✅ Tạo khóa học với upload ảnh
  - ✅ Chỉnh sửa khóa học
  - ✅ Xóa khóa học
  - ✅ Quản lý khóa học

- [x] **Quản lý bài học**
  - Controller: `InstructorController::lessons()`, `createLesson()`, `editLesson()`, `deleteLesson()`
  - Views: `views/instructor/lessons/manage.php`, `create.php`, `edit.php`
  - Models: `Lesson::create()`, `update()`, `delete()`
  - ✅ Tạo bài học mới
  - ✅ Chỉnh sửa bài học
  - ✅ Xóa bài học
  - ✅ Sắp xếp thứ tự bài học

- [x] **Đăng tải tài liệu học tập**
  - Controller: `InstructorController::uploadMaterial()`
  - View: `views/instructor/materials/upload.php`
  - Model: `Material::create()`
  - ✅ Upload file (PDF, DOC, PPT, etc.)
  - ✅ Lưu thông tin file vào database
  - ✅ Xóa tài liệu

- [x] **Xem danh sách học viên đã đăng ký**
  - Controller: `InstructorController::students()`
  - View: `views/instructor/students/list.php`
  - Model: `Enrollment::getCourseStudents()`
  - ✅ Hiển thị danh sách học viên
  - ✅ Hiển thị thông tin đăng ký

- [x] **Theo dõi tiến độ của từng học viên**
  - View: `views/instructor/students/list.php`
  - ✅ Hiển thị progress bar của từng học viên
  - ✅ Hiển thị trạng thái học tập

### 👨‍💼 CHỨC NĂNG QUẢN TRỊ VIÊN

- [x] **Quản lý người dùng (xem, kích hoạt, vô hiệu hóa)**
  - Controller: `AdminController::users()`
  - View: `views/admin/users/manage.php`
  - Model: `User::getAllUsers()`
  - ✅ Xem danh sách người dùng
  - ⚠️ Chưa có chức năng kích hoạt/vô hiệu hóa (cần thêm)

- [x] **Quản lý danh mục khóa học**
  - Controller: `AdminController::categories()`
  - View: `views/admin/categories/list.php`
  - Model: `Category::create()`, `update()`, `delete()`
  - ✅ Tạo danh mục mới
  - ✅ Xóa danh mục
  - ⚠️ Chưa có chức năng chỉnh sửa (cần thêm)

- [x] **Xem thống kê sử dụng hệ thống**
  - Controller: `AdminController::statistics()`
  - View: `views/admin/reports/statistics.php`
  - ✅ Đã có view (chưa có logic)

- [ ] **Duyệt phê duyệt khóa học mới**
  - ❌ Chưa có chức năng này

## 🔧 CẦN SỬA/BỔ SUNG

### 1. Sửa link trong views/courses/detail.php
- [x] Đã sửa link đăng ký dùng hàm url()
- [x] Đã sửa link vào học
- [x] Đã sửa link xem bài học

### 2. Bổ sung chức năng còn thiếu:

- [ ] **Admin - Kích hoạt/Vô hiệu hóa người dùng**
  - Thêm trường `status` vào bảng users
  - Hoặc thêm trường `is_active` (TINYINT)

- [ ] **Admin - Chỉnh sửa danh mục**
  - View đã có nhưng chưa có form edit
  - Cần tạo `views/admin/categories/edit.php`

- [ ] **Admin - Thống kê chi tiết**
  - Tổng số users
  - Tổng số courses
  - Tổng số enrollments
  - Top courses
  - Top instructors

- [ ] **Admin - Duyệt khóa học**
  - Thêm trường `status` vào bảng courses
  - Giá trị: 'pending', 'approved', 'rejected'
  - Admin có thể duyệt/từ chối

## 📝 DANH SÁCH URL CẦN KIỂM TRA

### Học viên:
1. ✅ `index.php?url=course` - Danh sách khóa học
2. ✅ `index.php?url=course/detail/1` - Chi tiết khóa học
3. ✅ `index.php?url=course/enroll/1` - Đăng ký khóa học
4. ✅ `index.php?url=enrollment/myCourses` - Khóa học của tôi
5. ✅ `index.php?url=enrollment/progress/1` - Tiến độ học tập
6. ✅ `index.php?url=lesson/view/1` - Xem bài học

### Giảng viên:
1. ✅ `index.php?url=instructor/dashboard` - Dashboard
2. ✅ `index.php?url=instructor/createCourse` - Tạo khóa học
3. ✅ `index.php?url=instructor/course/edit/1` - Sửa khóa học
4. ✅ `index.php?url=instructor/course/manage/1` - Quản lý khóa học
5. ✅ `index.php?url=instructor/lessons/1` - Quản lý bài học
6. ✅ `index.php?url=instructor/students/1` - Danh sách học viên

### Admin:
1. ✅ `index.php?url=admin/dashboard` - Dashboard
2. ✅ `index.php?url=admin/users` - Quản lý người dùng
3. ✅ `index.php?url=admin/categories` - Quản lý danh mục
4. ✅ `index.php?url=admin/statistics` - Thống kê

---

## 🎯 TỔNG KẾT

**Đã hoàn thành:**
- ✅ 95% chức năng học viên
- ✅ 100% chức năng giảng viên  
- ✅ 75% chức năng admin

**Cần bổ sung:**
- Admin: Kích hoạt/vô hiệu hóa user
- Admin: Edit category
- Admin: Thống kê chi tiết
- Admin: Duyệt khóa học

