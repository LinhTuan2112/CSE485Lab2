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
                header('Location: /CSE485Lab2/views/admin/dashboard.php');
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
            header('Location: /CSE485Lab2/views/admin/dashboard.php');
            exit;
        }

        // Hiển thị danh sách người dùng
        $pdo = new PDO('mysql:host=localhost;dbname=tlunews', 'root', '');
        $stmt = $pdo->query("SELECT * FROM users ORDER BY id ASC");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        include './CSE485Lab2/views/admin/dashboard.php';
    }

    public function deleteUser($id) {
        session_start();
        if (!isset($_SESSION['admin'])) {
            header('Location: /admin/login');
            exit;
        }

        $pdo = new PDO('mysql:host=localhost;dbname=tlunews', 'root', '');
        $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id AND role != 1"); // Không xóa admin
        $stmt->execute(['id' => $id]);

        header('Location: /admin/dashboard');
        exit;
    }

    public function updateUser() {
        session_start();
        if (!isset($_SESSION['admin'])) {
            header('Location: /admin/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id']);
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
            $role = intval($_POST['role']);

            $pdo = new PDO('mysql:host=localhost;dbname=tlunews', 'root', '');

            // Nếu có mật khẩu mới, mã hóa mật khẩu
            if (!empty($password)) {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE users SET username = :username, password = :password, role = :role WHERE id = :id");
                $stmt->execute(['username' => $username, 'password' => $hashedPassword, 'role' => $role, 'id' => $id]);
            } else {
                $stmt = $pdo->prepare("UPDATE users SET username = :username, role = :role WHERE id = :id");
                $stmt->execute(['username' => $username, 'role' => $role, 'id' => $id]);
            }

            header('Location: /admin/dashboard');
            exit;
        }
    }
}
