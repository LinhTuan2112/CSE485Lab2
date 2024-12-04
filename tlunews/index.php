<?php
// Bắt đầu session (nếu chưa bắt đầu)
session_start();

// Lấy giá trị route từ URL (nếu không có thì mặc định là 'admin/login')
$route = $_GET['route'] ?? 'admin/login';

// Kiểm tra điều kiện đăng nhập
if ($route != 'admin/login' && !isset($_SESSION['admin_logged_in'])) {
    // Nếu chưa đăng nhập và đang truy cập các trang khác, chuyển về trang login
    header("Location: index.php?route=admin/login");
    exit;
}

// Xử lý route
switch ($route) {
    case 'admin/login':
        // Bao gồm file login.php
        require 'views/admin/login.php';
        break;

    case 'admin/dashboard':
        // Bao gồm file dashboard.php (dành cho quản trị viên)
        require 'views/admin/dashboard.php';
        break;

    case 'admin/logout':
        // Xử lý đăng xuất
        session_destroy();
        header("Location: index.php?route=admin/login");
        exit;
        break;

    default:
        // Trang không hợp lệ
        echo "404 - Trang không tìm thấy!";
        break;
}
?>
