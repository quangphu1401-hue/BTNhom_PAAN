#!/bin/bash

# Script copy dự án vào XAMPP htdocs

SOURCE="/Users/tophu/onlinecourse"
DEST="/Applications/XAMPP/htdocs/onlinecourse"

echo "========================================="
echo "Copy dự án vào XAMPP htdocs"
echo "========================================="
echo ""
echo "Source: $SOURCE"
echo "Dest:   $DEST"
echo ""

# Kiểm tra thư mục source có tồn tại không
if [ ! -d "$SOURCE" ]; then
    echo "❌ Thư mục source không tồn tại: $SOURCE"
    exit 1
fi

# Kiểm tra thư mục XAMPP có tồn tại không
if [ ! -d "/Applications/XAMPP/htdocs" ]; then
    echo "❌ Thư mục XAMPP htdocs không tồn tại!"
    echo "Kiểm tra lại đường dẫn XAMPP"
    exit 1
fi

# Hỏi xác nhận nếu thư mục đích đã tồn tại
if [ -d "$DEST" ]; then
    echo "⚠️  Thư mục $DEST đã tồn tại!"
    read -p "Bạn có muốn xóa và copy lại? (y/n): " confirm
    if [ "$confirm" = "y" ] || [ "$confirm" = "Y" ]; then
        echo "Đang xóa thư mục cũ..."
        rm -rf "$DEST"
    else
        echo "Hủy bỏ. Thoát."
        exit 0
    fi
fi

# Copy file
echo "Đang copy file..."
cp -r "$SOURCE" "$DEST"

if [ $? -eq 0 ]; then
    echo ""
    echo "✅ Copy thành công!"
    echo ""
    echo "Kiểm tra file:"
    ls -la "$DEST/index.php"
    echo ""
    echo "========================================="
    echo "Bây giờ bạn có thể truy cập:"
    echo "http://localhost/onlinecourse/"
    echo "http://localhost/onlinecourse/index.php?url=home"
    echo "========================================="
else
    echo ""
    echo "❌ Copy thất bại!"
    exit 1
fi

