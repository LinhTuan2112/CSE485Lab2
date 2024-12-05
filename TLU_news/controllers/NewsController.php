<?php
class NewsController {
    private $newsModel;

    public function __construct($dbConnection) {
        require_once 'models/News.php';
        $this->newsModel = new News($dbConnection);
    }

    public function index() {
        session_start();
        if (!isset($_SESSION['admin'])) {
            header('Location: index.php?controller=admin&action=login');
            exit;
        }

        $newsList = $this->newsModel->getAllNews();
        include 'views/admin/news/index.php';
    }

    public function add() {
        session_start();
        if (!isset($_SESSION['admin'])) {
            header('Location: index.php?controller=admin&action=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $category_id = $_POST['category_id'];

            $this->newsModel->addNews($title, $content, $category_id);
            header('Location: index.php?controller=news&action=index');
            exit;
        }

        include 'views/admin/news/add.php';
    }

    public function edit() {
        session_start();
        if (!isset($_SESSION['admin'])) {
            header('Location: index.php?controller=admin&action=login');
            exit;
        }

        $id = $_GET['id'];
        $news = $this->newsModel->getNewsById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'];
            $content = $_POST['content'];
            $category_id = $_POST['category_id'];

            $this->newsModel->updateNews($id, $title, $content, $category_id);
            header('Location: index.php?controller=news&action=index');
            exit;
        }

        include 'views/admin/news/edit.php';
    }

    public function delete() {
        session_start();
        if (!isset($_SESSION['admin'])) {
            header('Location: index.php?controller=admin&action=login');
            exit;
        }

        $id = $_GET['id'];
        $this->newsModel->deleteNews($id);
        header('Location: index.php?controller=news&action=index');
        exit;
    }
}
?>

