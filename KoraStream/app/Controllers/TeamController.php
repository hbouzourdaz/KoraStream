<?php
/**
 * Team Controller
 */

class TeamController {
    
    public function index() {
        AuthController::checkAuth();
        $teamModel = new Team();
        $teams = $teamModel->getAll();
        
        $editTeam = null;
        if (isset($_GET['edit_id'])) {
            $editTeam = $teamModel->getById((int)$_GET['edit_id']);
        }

        require_once dirname(dirname(__DIR__)) . '/views/teams/form.php';
    }

    public function store() {
        AuthController::checkAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $logoPath = '';

            if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['logo']['tmp_name'];
                $fileName = $_FILES['logo']['name'];
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                $allowedExtensions = ['jpg', 'png', 'jpeg', 'svg'];
                
                if (in_array($fileExtension, $allowedExtensions)) {
                    $newFileName = 'team_' . time() . '_' . uniqid() . '.' . $fileExtension;
                    $uploadFileDir = dirname(dirname(__DIR__)) . '/public/uploads/teams/';
                    if (!file_exists($uploadFileDir)) {
                        mkdir($uploadFileDir, 0755, true);
                    }
                    $destPath = $uploadFileDir . $newFileName;
                    if (move_uploaded_file($fileTmpPath, $destPath)) {
                        $logoPath = 'uploads/teams/' . $newFileName;
                    }
                }
            }

            $teamModel = new Team();
            if ($teamModel->create($name, $logoPath)) {
                header("Location: index.php?page=admin_teams&status=created");
                exit;
            }
        }
        header("Location: index.php?page=admin_teams&status=error");
        exit;
    }

    public function update() {
        AuthController::checkAuth();
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $logoPath = null;

            if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['logo']['tmp_name'];
                $fileName = $_FILES['logo']['name'];
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                $allowedExtensions = ['jpg', 'png', 'jpeg', 'svg'];
                
                if (in_array($fileExtension, $allowedExtensions)) {
                    $newFileName = 'team_' . time() . '_' . uniqid() . '.' . $fileExtension;
                    $uploadFileDir = dirname(dirname(__DIR__)) . '/public/uploads/teams/';
                    if (!file_exists($uploadFileDir)) {
                        mkdir($uploadFileDir, 0755, true);
                    }
                    $destPath = $uploadFileDir . $newFileName;
                    if (move_uploaded_file($fileTmpPath, $destPath)) {
                        $logoPath = 'uploads/teams/' . $newFileName;
                    }
                }
            }

            $teamModel = new Team();
            if ($teamModel->update($id, $name, $logoPath)) {
                header("Location: index.php?page=admin_teams&status=updated");
                exit;
            }
        }
        header("Location: index.php?page=admin_teams&status=error");
        exit;
    }

    public function delete() {
        AuthController::checkAuth();
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $teamModel = new Team();
        if ($teamModel->delete($id)) {
            header("Location: index.php?page=admin_teams&status=deleted");
        } else {
            header("Location: index.php?page=admin_teams&status=error");
        }
        exit;
    }
}
