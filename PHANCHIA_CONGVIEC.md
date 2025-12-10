# PHÂN CHIA CÔNG VIỆC - WEBSITE QUẢN LÝ KHÓA HỌC ONLINE

## Tổng quan
Dự án được chia thành 4 nhóm làm việc theo mô hình MVC OOP với PHP & MySQL.

---

## NHÓM 1: XÂY DỰNG CHỨC NĂNG ĐĂNG NHẬP, ĐĂNG KÝ, QUẢN LÝ TÀI KHOẢN

### Models
- ✅ `models/User.php`
  - register(): Đăng ký user mới với password hashing
  - login(): Xác thực đăng nhập
  - getUserById(): Lấy thông tin user
  - emailExists(), usernameExists(): Kiểm tra trùng lặp
  - getAllUsers(): Lấy danh sách users (cho admin)
  - updateUser(): Cập nhật thông tin user

### Controllers
- ✅ `controllers/AuthController.php`
  - login(): Hiển thị form và xử lý đăng nhập
  - register(): Hiển thị form và xử lý đăng ký
  - logout(): Đăng xuất và xóa session

### Views
- ✅ `views/auth/login.php` - Form đăng nhập
- ✅ `views/auth/register.php` - Form đăng ký

### Helper Functions
- ✅ `config/helper.php`
  - isLoggedIn(): Kiểm tra đăng nhập
  - hasRole(): Kiểm tra vai trò
  - requireAuth(): Yêu cầu đăng nhập
  - requireRole(): Yêu cầu vai trò cụ thể
  - sanitize(): Làm sạch input
  - redirect(): Chuyển hướng
  - formatDate(): Định dạng ngày

### Chức năng đã hoàn thành
- ✅ Đăng ký tài khoản mới (học viên, giảng viên)
- ✅ Đăng nhập với email và password
- ✅ Hash password bằng bcrypt
- ✅ Validate input và kiểm tra trùng lặp
- ✅ Phân quyền theo role (0: học viên, 1: giảng viên, 2: admin)
- ✅ Session management

---

## NHÓM 2: XÂY DỰNG CHỨC NĂNG QUẢN LÝ KHÓA HỌC VÀ BÀI HỌC CHO GIẢNG VIÊN

### Models
- ✅ `models/Course.php`
  - getAll(): Lấy tất cả khóa học
  - getById(): Lấy chi tiết khóa học
  - getByInstructor(): Lấy khóa học của giảng viên
  - create(): Tạo khóa học mới
  - update(): Cập nhật khóa học
  - delete(): Xóa khóa học
  - search(): Tìm kiếm khóa học

- ✅ `models/Lesson.php`
  - getByCourse(): Lấy bài học theo khóa học
  - getById(): Lấy chi tiết bài học
  - create(): Tạo bài học mới
  - update(): Cập nhật bài học
  - delete(): Xóa bài học

- ✅ `models/Material.php`
  - getByLesson(): Lấy tài liệu theo bài học
  - create(): Thêm tài liệu
  - delete(): Xóa tài liệu (cả file vật lý)

### Controllers
- ✅ `controllers/InstructorController.php`
  - dashboard(): Dashboard giảng viên
  - myCourses(): Danh sách khóa học của giảng viên
  - createCourse(): Tạo khóa học mới (với upload ảnh)
  - editCourse(): Chỉnh sửa khóa học
  - manageCourse(): Quản lý khóa học (xem bài học, học viên)
  - deleteCourse(): Xóa khóa học
  - lessons(): Quản lý bài học
  - createLesson(): Tạo bài học mới
  - editLesson(): Chỉnh sửa bài học
  - deleteLesson(): Xóa bài học
  - uploadMaterial(): Đăng tải tài liệu
  - students(): Xem danh sách học viên

### Views
- ✅ `views/instructor/dashboard.php`
- ✅ `views/instructor/my_courses.php`
- ✅ `views/instructor/course/create.php`
- ✅ `views/instructor/course/edit.php`
- ✅ `views/instructor/course/manage.php`
- ✅ `views/instructor/lessons/manage.php`
- ✅ `views/instructor/lessons/create.php`
- ✅ `views/instructor/lessons/edit.php`
- ✅ `views/instructor/materials/upload.php`
- ✅ `views/instructor/students/list.php`

### Chức năng đã hoàn thành
- ✅ Tạo, chỉnh sửa, xóa khóa học
- ✅ Upload hình ảnh khóa học
- ✅ Quản lý bài học (CRUD)
- ✅ Đăng tải tài liệu (PDF, DOC, PPT, etc.)
- ✅ Xem danh sách học viên đã đăng ký
- ✅ Theo dõi tiến độ học viên

---

## NHÓM 3: XÂY DỰNG CHỨC NĂNG HIỂN THỊ KHÓA HỌC, ĐĂNG KÝ, THEO DÕI TIẾN ĐỘ

### Models
- ✅ `models/Enrollment.php`
  - enroll(): Đăng ký khóa học
  - isEnrolled(): Kiểm tra đã đăng ký
  - getEnrolledCourses(): Lấy khóa học đã đăng ký
  - getCourseStudents(): Lấy học viên của khóa học
  - updateProgress(): Cập nhật tiến độ
  - updateStatus(): Cập nhật trạng thái
  - getEnrollment(): Lấy thông tin đăng ký

- ✅ `models/Category.php`
  - getAll(): Lấy tất cả danh mục
  - getById(): Lấy chi tiết danh mục
  - create(): Tạo danh mục mới
  - update(): Cập nhật danh mục
  - delete(): Xóa danh mục

### Controllers
- ✅ `controllers/HomeController.php`
  - index(): Trang chủ với khóa học mới nhất

- ✅ `controllers/CourseController.php`
  - index(): Danh sách khóa học (tìm kiếm, lọc)
  - detail(): Chi tiết khóa học
  - enroll(): Đăng ký khóa học

- ✅ `controllers/EnrollmentController.php`
  - myCourses(): Khóa học đã đăng ký
  - progress(): Tiến độ học tập

- ✅ `controllers/LessonController.php`
  - view(): Xem bài học (chỉ cho học viên đã đăng ký)

- ✅ `controllers/StudentController.php`
  - dashboard(): Dashboard học viên

### Views
- ✅ `views/home/index.php` - Trang chủ
- ✅ `views/courses/index.php` - Danh sách khóa học
- ✅ `views/courses/detail.php` - Chi tiết khóa học
- ✅ `views/student/dashboard.php` - Dashboard học viên
- ✅ `views/student/my_courses.php` - Khóa học của tôi
- ✅ `views/student/course_progress.php` - Tiến độ học tập
- ✅ `views/student/lesson_view.php` - Xem bài học

### Chức năng đã hoàn thành
- ✅ Hiển thị danh sách khóa học
- ✅ Tìm kiếm và lọc khóa học (theo danh mục, cấp độ)
- ✅ Xem chi tiết khóa học
- ✅ Đăng ký khóa học
- ✅ Xem khóa học đã đăng ký
- ✅ Theo dõi tiến độ học tập (progress bar)
- ✅ Xem bài học và tài liệu
- ✅ Điều hướng giữa các bài học

---

## NHÓM 4: XÂY DỰNG GIAO DIỆN WEBSITE VÀ TÍCH HỢP UPLOAD FILE

### Layouts
- ✅ `views/layouts/header.php`
  - Navigation bar với menu động theo role
  - Hiển thị thông báo (success/error)
  - Dropdown menu cho user

- ✅ `views/layouts/footer.php`
  - Footer với copyright

### CSS
- ✅ `assets/css/style.css`
  - Responsive design
  - Modern UI với gradient và shadows
  - Styling cho forms, buttons, tables
  - Course cards, progress bars
  - Mobile-friendly

### JavaScript
- ✅ `assets/js/script.js`
  - Auto-hide alerts
  - Form validation
  - Confirm delete actions

### Upload Handlers
- ✅ Upload hình ảnh khóa học (trong InstructorController)
  - Validation file type (jpg, jpeg, png, gif)
  - Rename file với uniqid
  - Lưu vào `assets/uploads/courses/`

- ✅ Upload tài liệu (trong InstructorController)
  - Validation file type (pdf, doc, docx, ppt, pptx, txt, zip, rar)
  - Lưu vào `assets/uploads/materials/`
  - Thông tin file lưu vào database

### Views khác
- ✅ `views/errors/404.php` - Trang lỗi 404

### Chức năng đã hoàn thành
- ✅ Responsive giao diện đẹp mắt
- ✅ Navigation bar động theo role
- ✅ Form validation
- ✅ Upload file an toàn
- ✅ Progress bars
- ✅ Data tables
- ✅ Alert messages

---

## QUẢN TRỊ VIÊN (Bổ sung)

### Controllers
- ✅ `controllers/AdminController.php`
  - dashboard(): Dashboard admin với thống kê
  - users(): Quản lý người dùng
  - categories(): Quản lý danh mục (CRUD)
  - statistics(): Thống kê hệ thống

### Views
- ✅ `views/admin/dashboard.php`
- ✅ `views/admin/users/manage.php`
- ✅ `views/admin/categories/list.php`
- ✅ `views/admin/reports/statistics.php`

### Chức năng
- ✅ Xem danh sách người dùng
- ✅ Quản lý danh mục khóa học (thêm, xóa)
- ✅ Dashboard thống kê

---

## CẤU HÌNH VÀ DATABASE

### Config
- ✅ `config/Database.php` - Kết nối PDO
- ✅ `config/helper.php` - Helper functions

### Router
- ✅ `index.php` - Router chính hỗ trợ nested routes
- ✅ `.htaccess` - URL rewriting

### Database
- ✅ `database.sql` - Schema đầy đủ
  - Bảng users
  - Bảng categories
  - Bảng courses
  - Bảng enrollments
  - Bảng lessons
  - Bảng materials
  - Dữ liệu mẫu categories

---

## TỔNG KẾT

### Đã hoàn thành 100%
- ✅ Cấu trúc MVC đầy đủ
- ✅ Tất cả Models (6 models)
- ✅ Tất cả Controllers (8 controllers)
- ✅ Tất cả Views (30+ views)
- ✅ Giao diện responsive
- ✅ Upload file
- ✅ Phân quyền đầy đủ
- ✅ Database schema
- ✅ Helper functions
- ✅ Router với nested routes

### Bảo mật
- ✅ Password hashing (bcrypt)
- ✅ Prepared statements (chống SQL injection)
- ✅ Input sanitization
- ✅ File upload validation
- ✅ Role-based access control

### Sẵn sàng cho:
- ✅ Import database và chạy
- ✅ Làm việc nhóm với Git
- ✅ Mở rộng tính năng
- ✅ Deploy production

---

## HƯỚNG DẪN SỬ DỤNG GIT

1. **Clone repository**
   ```bash
   git clone <repo-url>
   cd onlinecourse
   ```

2. **Tạo branch cho nhóm**
   ```bash
   git checkout -b nhom1-auth
   git checkout -b nhom2-instructor
   git checkout -b nhom3-student
   git checkout -b nhom4-ui
   ```

3. **Commit và push**
   ```bash
   git add .
   git commit -m "Nhóm 1: Hoàn thành đăng nhập, đăng ký"
   git push origin nhom1-auth
   ```

4. **Tạo Pull Request** trên GitHub để merge vào main

---

## GHI CHÚ QUAN TRỌNG

1. Cần cấu hình database trong `config/Database.php`
2. Đảm bảo thư mục uploads có quyền ghi
3. Apache cần bật mod_rewrite
4. PHP cần extension PDO và PDO_MySQL
5. Upload limit: 50MB (đã cấu hình trong .htaccess)

---

**Dự án đã hoàn thành và sẵn sàng để sử dụng!** 🎉

