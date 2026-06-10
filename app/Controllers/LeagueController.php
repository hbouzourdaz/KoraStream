<?php
/**
 * League Controller
 */

class LeagueController {
    
    public function index() {
        AuthController::checkAuth();
        $leagueModel = new League();
        $leagues = $leagueModel->getAll();
        
        $editLeague = null;
        if (isset($_GET['edit_id'])) {
            $editLeague = $leagueModel->getById((int)$_GET['edit_id']);
        }

        require_once dirname(dirname(__DIR__)) . '/views/leagues/form.php';
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
                    $newFileName = 'league_' . time() . '_' . uniqid() . '.' . $fileExtension;
                    $uploadFileDir = dirname(dirname(__DIR__)) . '/public/uploads/leagues/';
                    if (!file_exists($uploadFileDir)) {
                        mkdir($uploadFileDir, 0755, true);
                    }
                    $destPath = $uploadFileDir . $newFileName;
                    if (move_uploaded_file($fileTmpPath, $destPath)) {
                        $logoPath = 'uploads/leagues/' . $newFileName;
                    }
                }
            }

            $leagueModel = new League();
            if ($leagueModel->create($name, $logoPath)) {
                header("Location: index.php?page=admin_leagues&status=created");
                exit;
            }
        }
        header("Location: index.php?page=admin_leagues&status=error");
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
                    $newFileName = 'league_' . time() . '_' . uniqid() . '.' . $fileExtension;
                    $uploadFileDir = dirname(dirname(__DIR__)) . '/public/uploads/leagues/';
                    if (!file_exists($uploadFileDir)) {
                        mkdir($uploadFileDir, 0755, true);
                    }
                    $destPath = $uploadFileDir . $newFileName;
                    if (move_uploaded_file($fileTmpPath, $destPath)) {
                        $logoPath = 'uploads/leagues/' . $newFileName;
                    }
                }
            }

            $leagueModel = new League();
            if ($leagueModel->update($id, $name, $logoPath)) {
                header("Location: index.php?page=admin_leagues&status=updated");
                exit;
            }
        }
        header("Location: index.php?page=admin_leagues&status=error");
        exit;
    }

    public function delete() {
        AuthController::checkAuth();
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $leagueModel = new League();
        if ($leagueModel->delete($id)) {
            header("Location: index.php?page=admin_leagues&status=deleted");
        } else {
            header("Location: index.php?page=admin_leagues&status=error");
        }
        exit;
    }
}
