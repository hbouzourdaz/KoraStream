<?php
/**
 * Match Controller
 */

class MatchController {
    
    public function index() {
        AuthController::checkAuth();
        $matchModel = new MatchModel();
        $matches = $matchModel->getAll();
        require_once dirname(dirname(__DIR__)) . '/views/matches/index.php';
    }

    public function create() {
        AuthController::checkAuth();
        
        $teamModel = new Team();
        $leagueModel = new League();
        $channelModel = new Channel();

        $teams = $teamModel->getAll();
        $leagues = $leagueModel->getAll();
        $channels = $channelModel->getActive();

        $actionUrl = 'index.php?page=admin_matches&action=store';
        $title = 'Create Match';

        require_once dirname(dirname(__DIR__)) . '/views/matches/form.php';
    }

    public function store() {
        AuthController::checkAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $homeId = (int)$_POST['home_team_id'];
            $awayId = (int)$_POST['away_team_id'];
            $leagueId = (int)$_POST['league_id'];
            $matchTime = $_POST['match_time'];
            $status = $_POST['status'];
            $homeScore = (int)$_POST['home_score'];
            $awayScore = (int)$_POST['away_score'];
            $commentator = trim($_POST['commentator']);
            $channelId = !empty($_POST['channel_id']) ? (int)$_POST['channel_id'] : null;

            $matchModel = new MatchModel();
            $matchId = $matchModel->create($homeId, $awayId, $leagueId, $matchTime, $status, $homeScore, $awayScore, $commentator, $channelId);

            if ($matchId) {
                // Add servers
                if (isset($_POST['servers']) && is_array($_POST['servers'])) {
                    foreach ($_POST['servers'] as $server) {
                        if (!empty($server['name']) && !empty($server['url'])) {
                            $matchModel->addServer($matchId, trim($server['name']), trim($server['url']), $server['player_type']);
                        }
                    }
                }
                header("Location: index.php?page=admin_matches&status=created");
                exit;
            }
        }
        header("Location: index.php?page=admin_matches&status=error");
        exit;
    }

    public function edit() {
        AuthController::checkAuth();
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        $matchModel = new MatchModel();
        $match = $matchModel->getById($id);
        if (!$match) {
            header("Location: index.php?page=admin_matches");
            exit;
        }

        $teamModel = new Team();
        $leagueModel = new League();
        $channelModel = new Channel();

        $teams = $teamModel->getAll();
        $leagues = $leagueModel->getAll();
        $channels = $channelModel->getActive();
        $servers = $matchModel->getServers($id);

        $actionUrl = 'index.php?page=admin_matches&action=update&id=' . $id;
        $title = 'Edit Match';

        require_once dirname(dirname(__DIR__)) . '/views/matches/form.php';
    }

    public function update() {
        AuthController::checkAuth();
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $homeId = (int)$_POST['home_team_id'];
            $awayId = (int)$_POST['away_team_id'];
            $leagueId = (int)$_POST['league_id'];
            $matchTime = $_POST['match_time'];
            $status = $_POST['status'];
            $homeScore = (int)$_POST['home_score'];
            $awayScore = (int)$_POST['away_score'];
            $commentator = trim($_POST['commentator']);
            $channelId = !empty($_POST['channel_id']) ? (int)$_POST['channel_id'] : null;

            $matchModel = new MatchModel();
            $success = $matchModel->update($id, $homeId, $awayId, $leagueId, $matchTime, $status, $homeScore, $awayScore, $commentator, $channelId);

            if ($success) {
                // Clear and recreate servers
                $matchModel->clearServers($id);
                if (isset($_POST['servers']) && is_array($_POST['servers'])) {
                    foreach ($_POST['servers'] as $server) {
                        if (!empty($server['name']) && !empty($server['url'])) {
                            $matchModel->addServer($id, trim($server['name']), trim($server['url']), $server['player_type']);
                        }
                    }
                }
                header("Location: index.php?page=admin_matches&status=updated");
                exit;
            }
        }
        header("Location: index.php?page=admin_matches&status=error");
        exit;
    }

    public function delete() {
        AuthController::checkAuth();
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $matchModel = new MatchModel();
        if ($matchModel->delete($id)) {
            header("Location: index.php?page=admin_matches&status=deleted");
        } else {
            header("Location: index.php?page=admin_matches&status=error");
        }
        exit;
    }
}
