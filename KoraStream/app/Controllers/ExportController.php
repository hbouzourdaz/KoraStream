<?php
/**
 * Export Controller
 * Exports database to a static JSON file for Vercel deployment.
 */

class ExportController {
    
    public function exportData() {
        AuthController::checkAuth();
        
        $matchModel = new MatchModel();
        $leagueModel = new League();
        $teamModel = new Team();
        $channelModel = new Channel();
        $adModel = new AdSetting();
        $settingModel = new AppSetting();

        $data = [
            'settings' => $settingModel->getAll(),
            'ads' => $adModel->getActiveAds(),
            'channels' => $channelModel->getActive(),
            'leagues' => $leagueModel->getAll(),
            'matches' => [],
            'matches_by_id' => [],
            'servers_by_match_id' => []
        ];

        // Fetch all matches and organize them
        $allMatches = $matchModel->getAll(); // Note: we might need a method to fetch all matches properly with league/team joins.
        // Actually matchModel->getAll() already joins team and league names/logos!
        
        foreach ($allMatches as $match) {
            $id = $match['id'];
            $date = date('Y-m-d', strtotime($match['match_time']));
            
            if (!isset($data['matches'][$date])) {
                $data['matches'][$date] = [];
            }
            
            $data['matches'][$date][] = $match;
            $data['matches_by_id'][$id] = $match;
            $data['servers_by_match_id'][$id] = $matchModel->getServers($id);
        }

        $jsonFile = dirname(dirname(__DIR__)) . '/public/data.json';
        $success = file_put_contents($jsonFile, json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        if ($success) {
            header("Location: index.php?page=admin&status=exported");
        } else {
            header("Location: index.php?page=admin&status=export_error");
        }
        exit;
    }
}
