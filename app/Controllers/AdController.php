<?php
/**
 * Ad Controller
 */

class AdController {
    
    public function index() {
        AuthController::checkAuth();
        $adModel = new AdSetting();
        $ads = $adModel->getAll();
        
        // Structure active ads easily for views
        $adNetworks = [];
        foreach ($ads as $ad) {
            $adNetworks[$ad['network_name']] = [
                'is_active' => $ad['is_active'],
                'settings' => json_decode($ad['settings_json'], true)
            ];
        }

        require_once dirname(dirname(__DIR__)) . '/views/ads/settings.php';
    }

    public function save() {
        AuthController::checkAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adModel = new AdSetting();
            
            $slots = ['banner_header', 'banner_player', 'popunder'];
            foreach ($slots as $slot) {
                $code = isset($_POST[$slot . '_code']) ? $_POST[$slot . '_code'] : '';
                $is_active = isset($_POST[$slot . '_active']) ? 1 : 0;
                $settingsJson = json_encode(['code' => $code]);

                $adModel->save($slot, $settingsJson, $is_active);
            }

            header("Location: index.php?page=admin_ads&status=saved");
            exit;
        }
        header("Location: index.php?page=admin_ads&status=error");
        exit;
    }
}
