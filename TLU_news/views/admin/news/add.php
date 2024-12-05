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

    // Lấy danh sách thể loại
    $categorySql = "SELECT * FROM categories";
    $categoryStmt = $conn->prepare($categorySql);
    $categoryStmt->execute();
    $categories = $categoryStmt->fetchAll(PDO::FETCH_ASSOC);

    // Xử lý việc thêm tin tức (nếu có dữ liệu gửi tới)
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $category_id = $_POST['category_id'];

        // Xử lý hình ảnh (nếu có)
        $image = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $image = $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $image);
        }

        // Thêm dữ liệu vào bảng news
        $insertSql = "INSERT INTO news (title, content, image, created_at, category_id) 
                      VALUES (:title, :content, :image, NOW(), :category_id)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bindParam(':title', $title);
        $insertStmt->bindParam(':content', $content);
        $insertStmt->bindParam(':image', $image);
        $insertStmt->bindParam(':category_id', $category_id);
        $insertStmt->execute();

        // Chuyển hướng lại trang index sau khi thêm tin tức
        header('Location: index.php?status=success');
        exit();
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm tin tức</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Thêm Tin Tức</h2>
    <form action="add.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="title" class="form-label">Tiêu đề</label>
            <input type="text" name="title" id="title" class="form-control" placeholder="Nhập tiêu đề tin tức" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Nội dung</label>
            <textarea name="content" id="content" rows="5" class="form-control" placeholder="Nhập nội dung tin tức" required></textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Hình ảnh</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Thể loại</label>
            <select name="category_id" id="category" class="form-select">
                <option value="">-- Chọn thể loại --</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-success w-100">Lưu</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
