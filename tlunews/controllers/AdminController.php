<?php
session_start();

class AdminController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new User($db);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $this->userModel->findUserByUsername($username);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['admin_id'] = $user['id'];
                header('Location: index.php?controller=admin&action=dashboard');
                exit();
            } else {
                $error = "Tên đăng nhập hoặc mật khẩu không đúng.";
                require 'views/admin/login.php';
            }
        } else {
            require 'views/admin/login.php';
        }
    }

    public function logout() {
        session_destroy();
        header('Location: index.php?controller=admin&action=login');
        exit();
    }

    public function dashboard() {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?controller=admin&action=login');
            exit();
        }
        require 'views/admin/dashboard.php';
    }
}
