<?php
session_start(); // Bắt đầu session

// Thông tin kết nối cơ sở dữ liệu
$host = "localhost";
$dbname = "tlunews";
$username = "root";
$password = "";

try {
    // Kết nối đến cơ sở dữ liệu
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Kết nối cơ sở dữ liệu thất bại: " . $e->getMessage());
}

// Kiểm tra xem admin đã đăng nhập hay chưa
if (!isset($_SESSION['admin'])) {
    header('Location: /CSE485LAB2/views/user/login.php');
    exit;
}

// Xử lý xóa người dùng
if (isset($_GET['delete'])) {
    $userId = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
    $stmt->execute(['id' => $userId]);
    header('Location: /admin/dashboard');
    exit;
}

// Xử lý cập nhật người dùng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET username = :username, password = :password, role = :role WHERE id = :id");
        $stmt->execute(['username' => $username, 'password' => $hashedPassword, 'role' => $role, 'id' => $id]);
    } else {
        $stmt = $pdo->prepare("UPDATE users SET username = :username, role = :role WHERE id = :id");
        $stmt->execute(['username' => $username, 'role' => $role, 'id' => $id]);
    }
    header('Location: /CSE485LAB2/views/admin/dashboard.php');
    exit;
}

// Lấy danh sách người dùng
$stmt = $pdo->query("SELECT * FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h1 class="text-center">Admin Dashboard</h1>
    <a href="/admin/logout" class="btn btn-danger mb-3">Logout</a>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['id']); ?></td>
                <td><?php echo htmlspecialchars($user['username']); ?></td>
                <td><?php echo $user['role'] == 1 ? 'Admin' : 'User'; ?></td>
                <td>
                    <a href="?delete=<?php echo $user['id']; ?>" class="btn btn-danger btn-sm"
                       onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                            data-bs-target="#editModal-<?php echo $user['id']; ?>">Edit</button>
                </td>
            </tr>

            <!-- Edit Modal -->
            <div class="modal fade" id="editModal-<?php echo $user['id']; ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="" method="POST" class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                            <div class="mb-3">
                                <label for="username-<?php echo $user['id']; ?>" class="form-label">Username</label>
                                <input type="text" name="username" id="username-<?php echo $user['id']; ?>"
                                       class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="password-<?php echo $user['id']; ?>" class="form-label">New Password</label>
                                <input type="password" name="password" id="password-<?php echo $user['id']; ?>"
                                       class="form-control">
                                <small class="text-muted">Leave blank to keep the current password</small>
                            </div>
                            <div class="mb-3">
                                <label for="role-<?php echo $user['id']; ?>" class="form-label">Role</label>
                                <select name="role" id="role-<?php echo $user['id']; ?>" class="form-control">
                                    <option value="0" <?php echo $user['role'] == 0 ? 'selected' : ''; ?>>User</option>
                                    <option value="1" <?php echo $user['role'] == 1 ? 'selected' : ''; ?>>Admin</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>