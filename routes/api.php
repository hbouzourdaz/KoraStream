<?php
/**
 * JSON API Router
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once dirname(__DIR__) . '/config/database.php';
require_once dirname(__DIR__) . '/app/Models/AppSetting.php';
require_once dirname(__DIR__) . '/app/Models/AdSetting.php';
require_once dirname(__DIR__) . '/app/Models/League.php';
require_once dirname(__DIR__) . '/app/Models/Team.php';
require_once dirname(__DIR__) . '/app/Models/Channel.php';
require_once dirname(__DIR__) . '/app/Models/Match.php';

$endpoint = isset($_GET['endpoint']) ? trim($_GET['endpoint']) : '';

$response = [
    'status' => 'error',
    'message' => 'Invalid endpoint.'
];

switch ($endpoint) {
    case 'settings':
        $model = new AppSetting();
        $response = [
            'status' => 'success',
            'data' => $model->getAll()
        ];
        break;

    case 'leagues':
        $model = new League();
        $response = [
            'status' => 'success',
            'data' => $model->getAll()
        ];
        break;

    case 'teams':
        $model = new Team();
        $response = [
            'status' => 'success',
            'data' => $model->getAll()
        ];
        break;

    case 'channels':
        $model = new Channel();
        $response = [
            'status' => 'success',
            'data' => $model->getActive()
        ];
        break;

    case 'matches':
        $model = new MatchModel();
        $date = isset($_GET['date']) ? trim($_GET['date']) : date('Y-m-d');
        $matches = $model->getByDate($date);
        
        // Add servers to each match
        foreach ($matches as &$match) {
            $match['servers'] = $model->getServers($match['id']);
        }
        
        $response = [
            'status' => 'success',
            'data' => $matches
        ];
        break;

    case 'ads':
        $model = new AdSetting();
        $response = [
            'status' => 'success',
            'data' => $model->getActiveAds()
        ];
        break;
}

echo json_encode($response);
exit;
