<?php
/**
 * Channel Controller
 */

class ChannelController {
    
    public function index() {
        AuthController::checkAuth();
        $channelModel = new Channel();
        $channels = $channelModel->getAll();
        require_once dirname(dirname(__DIR__)) . '/views/channels/index.php';
    }

    public function create() {
        AuthController::checkAuth();
        $actionUrl = 'index.php?page=admin_channels&action=store';
        $title = 'Create Channel';
        require_once dirname(dirname(__DIR__)) . '/views/channels/form.php';
    }

    public function store() {
        AuthController::checkAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $stream_url = trim($_POST['stream_url']);
            $status = $_POST['status'];
            $logoPath = '';

            if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['logo']['tmp_name'];
                $fileName = $_FILES['logo']['name'];
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                $allowedExtensions = ['jpg', 'png', 'jpeg', 'svg'];
                
                if (in_array($fileExtension, $allowedExtensions)) {
                    $newFileName = 'channel_' . time() . '_' . uniqid() . '.' . $fileExtension;
                    $uploadFileDir = dirname(dirname(__DIR__)) . '/public/uploads/channels/';
                    if (!file_exists($uploadFileDir)) {
                        mkdir($uploadFileDir, 0755, true);
                    }
                    $destPath = $uploadFileDir . $newFileName;
                    if (move_uploaded_file($fileTmpPath, $destPath)) {
                        $logoPath = 'uploads/channels/' . $newFileName;
                    }
                }
            }

            $channelModel = new Channel();
            if ($channelModel->create($name, $logoPath, $stream_url, $status)) {
                header("Location: index.php?page=admin_channels&status=created");
                exit;
            }
        }
        header("Location: index.php?page=admin_channels&status=error");
        exit;
    }

    public function edit() {
        AuthController::checkAuth();
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $channelModel = new Channel();
        $channel = $channelModel->getById($id);
        if (!$channel) {
            header("Location: index.php?page=admin_channels");
            exit;
        }

        $actionUrl = 'index.php?page=admin_channels&action=update&id=' . $id;
        $title = 'Edit Channel';
        require_once dirname(dirname(__DIR__)) . '/views/channels/form.php';
    }

    public function update() {
        AuthController::checkAuth();
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $stream_url = trim($_POST['stream_url']);
            $status = $_POST['status'];
            $logoPath = null;

            if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['logo']['tmp_name'];
                $fileName = $_FILES['logo']['name'];
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                $allowedExtensions = ['jpg', 'png', 'jpeg', 'svg'];
                
                if (in_array($fileExtension, $allowedExtensions)) {
                    $newFileName = 'channel_' . time() . '_' . uniqid() . '.' . $fileExtension;
                    $uploadFileDir = dirname(dirname(__DIR__)) . '/public/uploads/channels/';
                    if (!file_exists($uploadFileDir)) {
                        mkdir($uploadFileDir, 0755, true);
                    }
                    $destPath = $uploadFileDir . $newFileName;
                    if (move_uploaded_file($fileTmpPath, $destPath)) {
                        $logoPath = 'uploads/channels/' . $newFileName;
                    }
                }
            }

            $channelModel = new Channel();
            if ($channelModel->update($id, $name, $logoPath, $stream_url, $status)) {
                header("Location: index.php?page=admin_channels&status=updated");
                exit;
            }
        }
        header("Location: index.php?page=admin_channels&status=error");
        exit;
    }

    public function delete() {
        AuthController::checkAuth();
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $channelModel = new Channel();
        if ($channelModel->delete($id)) {
            header("Location: index.php?page=admin_channels&status=deleted");
        } else {
            header("Location: index.php?page=admin_channels&status=error");
        }
        exit;
    }
}
