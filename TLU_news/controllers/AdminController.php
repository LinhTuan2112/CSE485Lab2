<?php
class AdminController {
    private $newsModel;

    public function __construct($newsModel) {
        $this->newsModel = $newsModel;
    }

    // Hiển thị danh sách tin tức
    public function listNews() {
        $news = $this->newsModel->getAllNews();
        include './views/admin/news/index.php';
    }

    // Thêm tin tức
    public function addNews() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $image = $_FILES['image']['name'];
            $category_id = $_POST['category_id'];

            move_uploaded_file($_FILES['image']['tmp_name'], "uploads/$image");

            $this->newsModel->addNews($title, $content, $image, $category_id);
            header('Location: index.php?action=listNews');
        }
        include './views/admin/news/add.php';
    }

    // Sửa tin tức
    public function editNews($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $image = $_FILES['image']['name'];
            $category_id = $_POST['category_id'];

            if ($image) {
                move_uploaded_file($_FILES['image']['tmp_name'], "uploads/$image");
            } else {
                $image = $_POST['current_image'];
            }

            $this->newsModel->updateNews($id, $title, $content, $image, $category_id);
            header('Location: index.php?action=listNews');
        }

        $news = $this->newsModel->getNewsById($id);
        include './views/admin/news/edit.php';
    }

    // Xóa tin tức
    public function deleteNews($id) {
        $this->newsModel->deleteNews($id);
        header('Location: index.php?action=listNews');
    }
}
