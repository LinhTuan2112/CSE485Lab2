<?php

require_once './controllers/AdminController.php';

$uri = $_SERVER['REQUEST_URI'];

$adminController = new AdminController();

if ($uri === '/admin/login') {
    $adminController->login();
} elseif ($uri === '/admin/logout') {
    $adminController->logout();
} elseif ($uri === '/admin/dashboard') {
    $adminController->dashboard();
} else {
    echo "404 Not Found";
}
?>