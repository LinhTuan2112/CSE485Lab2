<?php
session_start();
require 'config/database.php'; // Kết nối CSDL

$route = $_GET['route'] ?? 'admin/login';

switch ($route) {
    case 'admin/login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Truy vấn CSDL kiểm tra tài khoản
            $query = $db->prepare("SELECT * FROM admins WHERE username = ? AND password = MD5(?)");
            $query->execute([$username, $password]);
            $admin = $query->fetch();

            if ($admin) {
                $_SESSION['admin'] = $admin; // Lưu thông tin đăng nhập vào session
                header("Location: index.php?route=admin/dashboard");
                exit;
            } else {
                $error = "Sai tên đăng nhập hoặc mật khẩu!";
                require 'views/admin/login.php';
            }
        } else {
            require 'views/admin/login.php';
        }
        break;

    case 'admin/dashboard':
        if (!isset($_SESSION['admin'])) {
            header("Location: index.php?route=admin/login");
            exit;
        }
        require 'views/admin/dashboard.php';
        break;

    case 'admin/logout':
        session_destroy();
        header("Location: index.php?route=admin/login");
        exit;
        break;

    default:
        echo "404 - Không tìm thấy trang!";
        break;
}
