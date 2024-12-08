<?php

class AdminController {
    public function login() {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            // Kết nối cơ sở dữ liệu
            $pdo = new PDO('mysql:host=localhost;dbname=tlunews', 'root', '');
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->execute(['username' => $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Kiểm tra tài khoản và mật khẩu
            if ($user && password_verify($password, $user['password']) && $user['role'] == 1) {
                $_SESSION['admin'] = $user['id'];
                header('Location: /admin/dashboard');
                exit;
            } else {
                $error = "Sai tên đăng nhập hoặc mật khẩu!";
            }
        }

        // Hiển thị form đăng nhập
        include './views/user/index.php';
    }

    public function logout() {
        session_start();
        unset($_SESSION['admin']);
        header('Location: /admin/login');
        exit;
    }

    public function dashboard() {
        session_start();
        if (!isset($_SESSION['admin'])) {
            header('Location: /admin/login');
            exit;
        }
        include './views/admin/dashboard.php';
    }
}
