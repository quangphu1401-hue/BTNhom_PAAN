-- =====================================================
-- CHÈN 15 KHÓA HỌC MẪU VÀO DATABASE
-- =====================================================
-- Lưu ý: Bạn cần có ít nhất 1 giảng viên (instructor) trong bảng users
-- với role = 1 trước khi chạy script này
-- =====================================================

USE onlinecourse;

-- =====================================================
-- TẠO 5 GIẢNG VIÊN MẪU
-- =====================================================
-- Password mặc định cho tất cả: "instructor123"
-- Hash password: $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi

-- Tạo giảng viên 1
INSERT INTO users (username, email, password, fullname, role)
SELECT 'instructor1', 'instructor1@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Nguyễn Văn An', 1
WHERE NOT EXISTS (SELECT 1 FROM users WHERE username = 'instructor1');

-- Tạo giảng viên 2
INSERT INTO users (username, email, password, fullname, role)
SELECT 'instructor2', 'instructor2@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Trần Thị Bình', 1
WHERE NOT EXISTS (SELECT 1 FROM users WHERE username = 'instructor2');

-- Tạo giảng viên 3
INSERT INTO users (username, email, password, fullname, role)
SELECT 'instructor3', 'instructor3@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Lê Văn Cường', 1
WHERE NOT EXISTS (SELECT 1 FROM users WHERE username = 'instructor3');

-- Tạo giảng viên 4
INSERT INTO users (username, email, password, fullname, role)
SELECT 'instructor4', 'instructor4@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Phạm Thị Dung', 1
WHERE NOT EXISTS (SELECT 1 FROM users WHERE username = 'instructor4');

-- Tạo giảng viên 5
INSERT INTO users (username, email, password, fullname, role)
SELECT 'instructor5', 'instructor5@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Hoàng Văn Em', 1
WHERE NOT EXISTS (SELECT 1 FROM users WHERE username = 'instructor5');

-- Lấy ID các giảng viên để phân bổ khóa học
SET @instructor1_id = (SELECT id FROM users WHERE username = 'instructor1');
SET @instructor2_id = (SELECT id FROM users WHERE username = 'instructor2');
SET @instructor3_id = (SELECT id FROM users WHERE username = 'instructor3');
SET @instructor4_id = (SELECT id FROM users WHERE username = 'instructor4');
SET @instructor5_id = (SELECT id FROM users WHERE username = 'instructor5');

-- Lấy ID các danh mục
SET @cat_laptrinh = (SELECT id FROM categories WHERE name LIKE '%Lập trình%' LIMIT 1);
SET @cat_thietke = (SELECT id FROM categories WHERE name LIKE '%Thiết kế%' LIMIT 1);
SET @cat_marketing = (SELECT id FROM categories WHERE name LIKE '%Marketing%' LIMIT 1);
SET @cat_kinhdoanh = (SELECT id FROM categories WHERE name LIKE '%Kinh doanh%' LIMIT 1);

-- =====================================================
-- CHÈN 15 KHÓA HỌC
-- =====================================================

INSERT INTO courses (title, description, instructor_id, category_id, price, duration_weeks, level, image, created_at) VALUES

-- KHÓA HỌC LẬP TRÌNH (5 khóa)
(
    'Lập trình PHP từ cơ bản đến nâng cao',
    'Khóa học toàn diện về PHP, từ cú pháp cơ bản đến xây dựng ứng dụng web hoàn chỉnh với PHP và MySQL. Học cách sử dụng OOP, MVC pattern, và các framework phổ biến.',
    @instructor1_id,
    @cat_laptrinh,
    500000.00,
    12,
    'Beginner',
    NULL,
    NOW()
),

(
    'JavaScript và jQuery cho người mới bắt đầu',
    'Học JavaScript từ đầu, từ các khái niệm cơ bản đến DOM manipulation, events, AJAX và sử dụng thư viện jQuery để tạo website tương tác và động.',
    @instructor1_id,
    @cat_laptrinh,
    450000.00,
    10,
    'Beginner',
    NULL,
    DATE_ADD(NOW(), INTERVAL -5 DAY)
),

(
    'React.js - Xây dựng ứng dụng web hiện đại',
    'Khóa học React.js chuyên sâu, học cách xây dựng Single Page Application (SPA) với React, Hooks, Redux, và tích hợp với RESTful API.',
    @instructor2_id,
    @cat_laptrinh,
    1200000.00,
    16,
    'Intermediate',
    NULL,
    DATE_ADD(NOW(), INTERVAL -10 DAY)
),

(
    'Laravel Framework - Phát triển web với PHP',
    'Khóa học Laravel framework, từ cài đặt, routing, database migration, Eloquent ORM đến xây dựng API và authentication. Phù hợp cho developer đã biết PHP.',
    @instructor2_id,
    @cat_laptrinh,
    800000.00,
    14,
    'Intermediate',
    NULL,
    DATE_ADD(NOW(), INTERVAL -7 DAY)
),

(
    'Node.js và Express.js - Backend Development',
    'Học Node.js từ cơ bản đến nâng cao, xây dựng RESTful API với Express.js, làm việc với database MongoDB, và triển khai ứng dụng lên server.',
    @instructor3_id,
    @cat_laptrinh,
    900000.00,
    15,
    'Advanced',
    NULL,
    DATE_ADD(NOW(), INTERVAL -12 DAY)
),

-- KHÓA HỌC THIẾT KẾ (4 khóa)
(
    'Thiết kế UI/UX với Figma',
    'Khóa học thiết kế giao diện người dùng chuyên nghiệp với Figma. Học nguyên tắc thiết kế, wireframe, prototype, và tạo design system hoàn chỉnh.',
    @instructor3_id,
    @cat_thietke,
    600000.00,
    10,
    'Beginner',
    NULL,
    DATE_ADD(NOW(), INTERVAL -3 DAY)
),

(
    'Adobe Photoshop cho người mới bắt đầu',
    'Học Photoshop từ đầu, từ các công cụ cơ bản đến chỉnh sửa ảnh chuyên nghiệp, tạo banner, poster và các sản phẩm đồ họa khác.',
    @instructor4_id,
    @cat_thietke,
    400000.00,
    8,
    'Beginner',
    NULL,
    DATE_ADD(NOW(), INTERVAL -6 DAY)
),

(
    'Thiết kế logo và thương hiệu',
    'Học cách thiết kế logo chuyên nghiệp, xây dựng bộ nhận diện thương hiệu hoàn chỉnh bao gồm logo, màu sắc, typography và các ứng dụng thực tế.',
    @instructor4_id,
    @cat_thietke,
    550000.00,
    9,
    'Intermediate',
    NULL,
    DATE_ADD(NOW(), INTERVAL -8 DAY)
),

(
    'Web Design với HTML, CSS và Bootstrap',
    'Khóa học thiết kế website responsive từ đầu với HTML5, CSS3 và Bootstrap. Học cách tạo layout đẹp, responsive trên mọi thiết bị.',
    @instructor4_id,
    @cat_thietke,
    500000.00,
    11,
    'Beginner',
    NULL,
    DATE_ADD(NOW(), INTERVAL -4 DAY)
),

-- KHÓA HỌC MARKETING (3 khóa)
(
    'Digital Marketing cơ bản',
    'Khóa học tổng quan về Digital Marketing, học SEO, Google Ads, Facebook Ads, Email Marketing và các kênh marketing online hiệu quả.',
    @instructor5_id,
    @cat_marketing,
    700000.00,
    12,
    'Beginner',
    NULL,
    DATE_ADD(NOW(), INTERVAL -9 DAY)
),

(
    'Facebook Ads - Quảng cáo Facebook hiệu quả',
    'Học cách chạy quảng cáo Facebook từ A-Z, từ tạo tài khoản, thiết lập chiến dịch, target đối tượng, tối ưu ngân sách đến đo lường hiệu quả.',
    @instructor5_id,
    @cat_marketing,
    850000.00,
    8,
    'Intermediate',
    NULL,
    DATE_ADD(NOW(), INTERVAL -11 DAY)
),

(
    'SEO - Tối ưu hóa công cụ tìm kiếm',
    'Khóa học SEO chuyên sâu, học keyword research, on-page SEO, off-page SEO, technical SEO và cách đo lường kết quả với Google Analytics.',
    @instructor5_id,
    @cat_marketing,
    750000.00,
    10,
    'Intermediate',
    NULL,
    DATE_ADD(NOW(), INTERVAL -13 DAY)
),

-- KHÓA HỌC KINH DOANH (3 khóa)
(
    'Khởi nghiệp từ con số 0',
    'Học cách khởi nghiệp thành công, từ ý tưởng, lập kế hoạch kinh doanh, tìm nguồn vốn, xây dựng đội ngũ đến marketing và bán hàng.',
    @instructor1_id,
    @cat_kinhdoanh,
    950000.00,
    14,
    'Beginner',
    NULL,
    DATE_ADD(NOW(), INTERVAL -2 DAY)
),

(
    'Quản lý tài chính cá nhân',
    'Khóa học về quản lý tài chính cá nhân, học cách lập ngân sách, tiết kiệm, đầu tư thông minh và xây dựng tự do tài chính.',
    @instructor2_id,
    @cat_kinhdoanh,
    600000.00,
    8,
    'Beginner',
    NULL,
    DATE_ADD(NOW(), INTERVAL -14 DAY)
),

(
    'E-commerce - Bán hàng online thành công',
    'Học cách bán hàng online hiệu quả, từ chọn sản phẩm, setup shop online, marketing, customer service đến logistics và quản lý đơn hàng.',
    @instructor3_id,
    @cat_kinhdoanh,
    1100000.00,
    13,
    'Intermediate',
    NULL,
    DATE_ADD(NOW(), INTERVAL -1 DAY)
);

-- =====================================================
-- KIỂM TRA KẾT QUẢ
-- =====================================================

SELECT 
    COUNT(*) as total_courses,
    COUNT(CASE WHEN category_id = @cat_laptrinh THEN 1 END) as courses_laptrinh,
    COUNT(CASE WHEN category_id = @cat_thietke THEN 1 END) as courses_thietke,
    COUNT(CASE WHEN category_id = @cat_marketing THEN 1 END) as courses_marketing,
    COUNT(CASE WHEN category_id = @cat_kinhdoanh THEN 1 END) as courses_kinhdoanh
FROM courses;

-- =====================================================
-- KẾT THÚC
-- =====================================================
-- Đã chèn thành công 15 khóa học mẫu!
-- =====================================================

