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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa tin tức</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Sửa Tin Tức</h2>
        <form action="index.php?action=updateNews&id=<?= $news['id'] ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Tiêu đề</label>
                <input type="text" name="title" id="title" class="form-control" value="<?= $news['title'] ?>" placeholder="Nhập tiêu đề tin tức" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Nội dung</label>
                <textarea name="content" id="content" rows="5" class="form-control" placeholder="Nhập nội dung tin tức" required><?= $news['content'] ?></textarea>
            </div>
            <div class="mb-3">
                <label for="current-image" class="form-label">Hình ảnh hiện tại</label>
                <div>
                    <?php if (!empty($news['image'])): ?>
                        <img src="uploads/<?= $news['image'] ?>" alt="Hình ảnh" class="img-thumbnail" style="max-width: 150px;">
                    <?php else: ?>
                        <p>Không có hình ảnh.</p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Hình ảnh mới (nếu có)</label>
                <input type="file" name="image" id="image" class="form-control">
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Thể loại</label>
                <select name="category_id" id="category" class="form-select">
                    <option value="">-- Chọn thể loại --</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id'] ?>" <?= $category['id'] == $news['category_id'] ? 'selected' : '' ?>>
                            <?= $category['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Cập nhật</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
