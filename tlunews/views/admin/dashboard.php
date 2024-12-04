<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản trị viên</title>
</head>
<body>
    <h1>Chào mừng, <?= $_SESSION['admin']['username'] ?>!</h1>
    <p><a href="index.php?route=admin/logout">Đăng xuất</a></p>
</body>
</html>
