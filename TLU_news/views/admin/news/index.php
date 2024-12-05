<?php
$host = 'localhost'; // Địa chỉ máy chủ CSDL
$dbname = 'tlunews'; // Tên CSDL
$username = 'root'; // Tên người dùng
$password = ''; // Mật khẩu

try {
    // Tạo kết nối PDO
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Thiết lập chế độ lỗi của PDO
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Câu lệnh SQL
    $sql = "SELECT * FROM news";
    // Chuẩn bị câu lệnh SQL
    $stmt = $conn->prepare($sql);
    // Thực thi câu lệnh SQL
    $stmt->execute();
    // Lấy tất cả kết quả dưới dạng mảng kết hợp
    $news = $stmt->fetchAll(PDO::FETCH_ASSOC);



} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Quản lý Tin tức</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Quản lý Tin tức</h2>
    <!-- Hiển thị thông báo thành công khi thêm tin -->
    <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
        <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
            Tin tức đã được thêm thành công!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="add.php" class="btn btn-success">Thêm tin mới</a>
    </div>
    <table class="table table-striped table-bordered">
        <thead class="table-primary">
        <tr>
            <th>ID</th>
            <th>Tiêu đề</th>
            <th>Nội dung</th>
            <th>Hình ảnh</th>
            <th>Thể loại</th>
            <th>Ngày tạo</th>
            <th>Hành động</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($news)): ?>
            <?php foreach ($news as $item): ?>
                <tr>
                    <td><?= $item['id'] ?></td>
                    <td><?= $item['title'] ?></td>
                    <td><?= $item['content'] ?></td>
                    <td>
                        <img src="uploads/<?= $item['image'] ?>" alt="Hình ảnh" width="100" class="img-thumbnail">
                    </td>
                    <td><?= $item['category_id'] ?></td> <!-- Sử dụng category_id từ cơ sở dữ liệu -->
                    <td><?= $item['created_at'] ?></td> <!-- Thêm cột created_at -->
                    <td>
                        <a href="index.php?action=editNews&id=<?= $item['id'] ?>" class="btn btn-primary btn-sm">Sửa</a>
                        <a href="index.php?action=deleteNews&id=<?= $item['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xóa tin này?')">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7" class="text-center">Chưa có tin tức nào!</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
