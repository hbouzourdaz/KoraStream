<?php
/**
 * Setting Controller
 */

class SettingController {
    
    public function index() {
        AuthController::checkAuth();
        $settingModel = new AppSetting();
        $settings = $settingModel->getAll();
        require_once dirname(dirname(__DIR__)) . '/views/settings/index.php';
    }

    public function save() {
        AuthController::checkAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $settingModel = new AppSetting();
            
            $fields = ['site_name', 'site_description', 'facebook_url', 'telegram_url', 'custom_head_code'];
            
            foreach ($fields as $field) {
                if (isset($_POST[$field])) {
                    $settingModel->save($field, $_POST[$field]);
                }
            }

            // Toggle fields (checkboxes) — unchecked boxes aren't sent in POST
            $toggleFields = ['maintenance_mode', 'enable_channels'];
            foreach ($toggleFields as $toggle) {
                $settingModel->save($toggle, isset($_POST[$toggle]) ? '1' : '0');
            }

            // Handle logo upload
            if (isset($_FILES['site_logo']) && $_FILES['site_logo']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['site_logo']['tmp_name'];
                $fileName = $_FILES['site_logo']['name'];
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                $allowedExtensions = ['jpg', 'png', 'jpeg', 'svg'];
                
                if (in_array($fileExtension, $allowedExtensions)) {
                    $newFileName = 'logo_' . time() . '.' . $fileExtension;
                    $uploadFileDir = dirname(dirname(__DIR__)) . '/public/uploads/';
                    if (!file_exists($uploadFileDir)) {
                        mkdir($uploadFileDir, 0755, true);
                    }
                    $destPath = $uploadFileDir . $newFileName;
                    if (move_uploaded_file($fileTmpPath, $destPath)) {
                        $settingModel->save('site_logo', 'uploads/' . $newFileName);
                    }
                }
            }

            header("Location: index.php?page=admin_settings&status=saved");
            exit;
        }
        header("Location: index.php?page=admin_settings&status=error");
        exit;
    }
}
