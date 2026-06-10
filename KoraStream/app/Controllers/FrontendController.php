<?php
/**
 * Frontend Controller (Android UI style launcher)
 */

class FrontendController {
    private $matchModel;
    private $leagueModel;
    private $channelModel;
    private $adModel;
    private $settingModel;

    public function __construct() {
        $this->matchModel = new MatchModel();
        $this->leagueModel = new League();
        $this->channelModel = new Channel();
        $this->adModel = new AdSetting();
        $this->settingModel = new AppSetting();
    }

    private function getCommonData() {
        return [
            'settings' => $this->settingModel->getAll(),
            'ads' => $this->adModel->getActiveAds()
        ];
    }

    public function home() {
        $common = $this->getCommonData();
        
        // Handle Maintenance Mode
        if (isset($common['settings']['maintenance_mode']) && $common['settings']['maintenance_mode'] == '1') {
            echo "<h1>Site is currently in maintenance mode. Please come back later.</h1>";
            exit;
        }

        // Get filter date (Yesterday, Today, Tomorrow)
        $selectedDate = isset($_GET['date']) ? trim($_GET['date']) : date('Y-m-d');
        
        $matches = $this->matchModel->getByDate($selectedDate);

        // Group matches by league
        $groupedMatches = [];
        foreach ($matches as $match) {
            $leagueId = $match['league_id'];
            if (!isset($groupedMatches[$leagueId])) {
                $groupedMatches[$leagueId] = [
                    'league_name' => $match['league_name'],
                    'league_logo' => $match['league_logo'],
                    'matches' => []
                ];
            }
            $groupedMatches[$leagueId]['matches'][] = $match;
        }

        $activeTab = 'home';
        require_once dirname(dirname(__DIR__)) . '/views/frontend/home.php';
    }

    public function watch() {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        $match = $this->matchModel->getById($id);
        $servers = $this->matchModel->getServers($id);

        if (!$match) {
            header("Location: index.php");
            exit;
        }

        $common = $this->getCommonData();

        $activeTab = 'home'; // Kept under home navigation context
        require_once dirname(dirname(__DIR__)) . '/views/frontend/watch.php';
    }

    public function channels() {
        $common = $this->getCommonData();
        
        // Ensure channels are enabled
        if (isset($common['settings']['enable_channels']) && $common['settings']['enable_channels'] == '0') {
            header("Location: index.php");
            exit;
        }

        $channels = $this->channelModel->getActive();
        
        $activeTab = 'channels';
        require_once dirname(dirname(__DIR__)) . '/views/frontend/channels.php';
    }

    public function leagues() {
        $common = $this->getCommonData();
        $leagues = $this->leagueModel->getAll();
        
        $activeTab = 'leagues';
        require_once dirname(dirname(__DIR__)) . '/views/frontend/leagues.php';
    }

    public function settings() {
        $common = $this->getCommonData();
        $activeTab = 'settings';
        require_once dirname(dirname(__DIR__)) . '/views/frontend/settings.php';
    }
}
