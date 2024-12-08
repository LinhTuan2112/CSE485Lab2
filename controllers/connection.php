<?php
        function connectDatabase($servername, $username, $password, $dbname) {
        try {
            // Tạo kết nối
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            // Thiết lập chế độ báo lỗi
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn; // Trả về đối tượng kết nối
        } catch (PDOException $e) {
            die("Kết nối thất bại: " . $e->getMessage());
        }
    }
    // Ví dụ sử dụng hàm
    $servername = "localhost"; // Địa chỉ máy chủ
    $username = "root"; // Tên người dùng MySQL
    $password = ""; // Mật khẩu MySQL
    $dbname = "tlunews"; // Tên cơ sở dữ liệu
    $conn = connectDatabase($servername, $username, $password, $dbname);
    // Đừng quên đóng kết nối khi không cần thiết
     $conn = null;
?>