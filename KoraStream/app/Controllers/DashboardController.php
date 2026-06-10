<?php
/**
 * Dashboard Controller
 */

class DashboardController {
    
    public function index() {
        AuthController::checkAuth();

        $matchModel = new MatchModel();
        $leagueModel = new League();
        $teamModel = new Team();
        $channelModel = new Channel();

        $stats = [
            'matches' => $matchModel->count(),
            'live_matches' => $matchModel->countLive(),
            'leagues' => $leagueModel->count(),
            'teams' => $teamModel->count(),
            'channels' => $channelModel->count()
        ];

        // Today's matches
        $todayMatches = $matchModel->getTodayMatches();

        require_once dirname(dirname(__DIR__)) . '/views/dashboard/index.php';
    }

    public function updateScore() {
        AuthController::checkAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
            $homeScore = isset($_POST['home_score']) ? (int)$_POST['home_score'] : 0;
            $awayScore = isset($_POST['away_score']) ? (int)$_POST['away_score'] : 0;

            $matchModel = new MatchModel();
            $success = $matchModel->updateScore($id, $homeScore, $awayScore);
            
            header('Content-Type: application/json');
            if ($success) {
                echo json_encode(['status' => 'success', 'message' => 'Scores updated successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to update scores.']);
            }
            exit;
        }
    }
}
