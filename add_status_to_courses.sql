-- Migration: Thêm cột status vào bảng courses để quản lý phê duyệt khóa học
-- Chạy file này trong MySQL để thêm cột status vào bảng courses

-- Kiểm tra và thêm cột status (MySQL không hỗ trợ IF NOT EXISTS cho ALTER TABLE, nên cần kiểm tra thủ công)
-- Nếu cột đã tồn tại, bỏ qua lệnh này

ALTER TABLE courses 
ADD COLUMN status VARCHAR(50) DEFAULT 'pending' 
COMMENT 'pending: chờ duyệt, approved: đã duyệt, rejected: từ chối';

-- Cập nhật các khóa học hiện có thành 'approved' (coi như đã được duyệt trước đó)
UPDATE courses SET status = 'approved' WHERE status IS NULL OR status = '';

-- Tạo index cho cột status để tối ưu query
CREATE INDEX idx_status ON courses(status);

