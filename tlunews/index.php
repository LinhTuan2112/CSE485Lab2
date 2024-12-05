<?php
require 'models/User.php';
require 'controllers/AdminController.php';

try {
    $db = new PDO('mysql:host=localhost;dbname=tintuc', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $controller = $_GET['controller'] ?? 'admin';
    $action = $_GET['action'] ?? 'login';

    $adminController = new AdminController($db);

    if ($controller == 'admin') {
        if ($action == 'login') $adminController->login();
        if ($action == 'logout') $adminController->logout();
        if ($action == 'dashboard') $adminController->dashboard();
    }
} catch (PDOException $e) {
    echo "Lỗi kết nối CSDL: " . $e->getMessage();
}
