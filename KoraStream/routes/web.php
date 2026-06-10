<?php
/**
 * Main Web Router
 */

// Autoload files
require_once dirname(__DIR__) . '/config/database.php';

// Models
require_once dirname(__DIR__) . '/app/Models/AppSetting.php';
require_once dirname(__DIR__) . '/app/Models/AdSetting.php';
require_once dirname(__DIR__) . '/app/Models/League.php';
require_once dirname(__DIR__) . '/app/Models/Team.php';
require_once dirname(__DIR__) . '/app/Models/Channel.php';
require_once dirname(__DIR__) . '/app/Models/Match.php';

// Controllers
require_once dirname(__DIR__) . '/app/Controllers/AuthController.php';
require_once dirname(__DIR__) . '/app/Controllers/DashboardController.php';
require_once dirname(__DIR__) . '/app/Controllers/LeagueController.php';
require_once dirname(__DIR__) . '/app/Controllers/TeamController.php';
require_once dirname(__DIR__) . '/app/Controllers/ChannelController.php';
require_once dirname(__DIR__) . '/app/Controllers/MatchController.php';
require_once dirname(__DIR__) . '/app/Controllers/AdController.php';
require_once dirname(__DIR__) . '/app/Controllers/SettingController.php';
require_once dirname(__DIR__) . '/app/Controllers/FrontendController.php';

$page = isset($_GET['page']) ? trim($_GET['page']) : 'home';
$action = isset($_GET['action']) ? trim($_GET['action']) : 'index';

switch ($page) {
    // Admin Dashboard Routes
    case 'admin':
        $auth = new AuthController();
        if ($action === 'login') {
            if (AuthController::isLoggedIn()) {
                header("Location: index.php?page=admin");
                exit;
            }
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $email = isset($_POST['email']) ? trim($_POST['email']) : '';
                $password = isset($_POST['password']) ? trim($_POST['password']) : '';
                $result = $auth->login($email, $password);
                if ($result === true) {
                    header("Location: index.php?page=admin");
                    exit;
                } else {
                    $error = $result;
                }
            }
            require_once dirname(__DIR__) . '/views/auth/login.php';
        } elseif ($action === 'logout') {
            $auth->logout();
        } else {
            $dashboard = new DashboardController();
            $dashboard->index();
        }
        break;

    case 'admin_update_score':
        $dashboard = new DashboardController();
        $dashboard->updateScore();
        break;

    case 'admin_leagues':
        $controller = new LeagueController();
        if ($action === 'store') $controller->store();
        elseif ($action === 'update') $controller->update();
        elseif ($action === 'delete') $controller->delete();
        else $controller->index();
        break;

    case 'admin_teams':
        $controller = new TeamController();
        if ($action === 'store') $controller->store();
        elseif ($action === 'update') $controller->update();
        elseif ($action === 'delete') $controller->delete();
        else $controller->index();
        break;

    case 'admin_channels':
        $controller = new ChannelController();
        if ($action === 'create') $controller->create();
        elseif ($action === 'store') $controller->store();
        elseif ($action === 'edit') $controller->edit();
        elseif ($action === 'update') $controller->update();
        elseif ($action === 'delete') $controller->delete();
        else $controller->index();
        break;

    case 'admin_matches':
        $controller = new MatchController();
        if ($action === 'create') $controller->create();
        elseif ($action === 'store') $controller->store();
        elseif ($action === 'edit') $controller->edit();
        elseif ($action === 'update') $controller->update();
        elseif ($action === 'delete') $controller->delete();
        else $controller->index();
        break;

    case 'admin_ads':
        $controller = new AdController();
        if ($action === 'save') $controller->save();
        else $controller->index();
        break;

    case 'admin_settings':
        $controller = new SettingController();
        if ($action === 'save') $controller->save();
        else $controller->index();
        break;

    // Client Frontend (Android UI) Routes
    case 'home':
        $frontend = new FrontendController();
        $frontend->home();
        break;

    case 'watch':
        $frontend = new FrontendController();
        $frontend->watch();
        break;

    case 'channels':
        $frontend = new FrontendController();
        $frontend->channels();
        break;

    case 'leagues':
        $frontend = new FrontendController();
        $frontend->leagues();
        break;

    case 'settings':
        $frontend = new FrontendController();
        $frontend->settings();
        break;

    case 'admin_export':
        requireLocalAdmin();
        require_once APP_ROOT . '/app/Controllers/ExportController.php';
        $controller = new ExportController();
        $controller->exportData();
        break;

    default:
        $frontend = new FrontendController();
        $frontend->home();
        break;
}
