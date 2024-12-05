<?php
$host = 'localhost'; // Địa chỉ máy chủ MySQL
$dbname = 'tintuc';  // Tên cơ sở dữ liệu mà bạn đã tạo trong phpMyAdmin
$username = 'root';  // Tên đăng nhập MySQL (thường là 'root' với máy cục bộ)
$password = '';      // Mật khẩu MySQL (để trống nếu bạn không đặt mật khẩu)

try {
    // Kết nối PDO
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Kết nối cơ sở dữ liệu thành công!";
} catch (PDOException $e) {
    echo "Kết nối thất bại: " . $e->getMessage();
}
?>
