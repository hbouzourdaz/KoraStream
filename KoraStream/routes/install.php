<?php
/**
 * Installation Router
 */

require_once dirname(__DIR__) . '/app/Controllers/InstallController.php';

if (InstallController::isInstalled()) {
    header("Location: index.php");
    exit;
}

$installer = new InstallController();
$step = isset($_GET['step']) ? (int)$_GET['step'] : 1;
if ($step < 1 || $step > 4) $step = 1;

// Start session to save state between steps
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$error = null;
$success = null;

// Handle form submissions for step transitions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_GET['action'])) {
    if ($step === 3) {
        $_SESSION['install_admin'] = [
            'email' => isset($_POST['admin_email']) ? trim($_POST['admin_email']) : '',
            'pass' => isset($_POST['admin_pass']) ? trim($_POST['admin_pass']) : ''
        ];
        header("Location: install.php?step=4");
        exit;
    }
}

// Handle AJAX actions
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action'])) {
    header('Content-Type: application/json');
    $action = $_GET['action'];

    if ($action === 'test_db') {
        $host = isset($_POST['host']) ? trim($_POST['host']) : '';
        $name = isset($_POST['name']) ? trim($_POST['name']) : '';
        $user = isset($_POST['user']) ? trim($_POST['user']) : '';
        $pass = isset($_POST['pass']) ? trim($_POST['pass']) : '';

        $test = $installer->testDatabase($host, $name, $user, $pass);
        if ($test === true) {
            // Store details in session
            $_SESSION['install_db'] = [
                'host' => $host,
                'name' => $name,
                'user' => $user,
                'pass' => $pass
            ];
            echo json_encode(['status' => 'success', 'message' => 'Database connected successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => $test]);
        }
        exit;
    }

    if ($action === 'execute') {
        $dbInfo = isset($_SESSION['install_db']) ? $_SESSION['install_db'] : null;
        $adminInfo = isset($_SESSION['install_admin']) ? $_SESSION['install_admin'] : null;
        
        if (!$dbInfo || !$adminInfo) {
            echo json_encode(['status' => 'error', 'message' => 'Installation session lost. Please restart.']);
            exit;
        }

        $result = $installer->runInstall(
            $dbInfo['host'],
            $dbInfo['name'],
            $dbInfo['user'],
            $dbInfo['pass'],
            $adminInfo['email'],
            $adminInfo['pass']
        );

        if ($result === true) {
            // Destroy install session variables
            unset($_SESSION['install_db']);
            unset($_SESSION['install_admin']);
            echo json_encode(['status' => 'success', 'message' => 'Installation completed successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => $result]);
        }
        exit;
    }
    
    echo json_encode(['status' => 'error', 'message' => 'Invalid action.']);
    exit;
}

// Requirements check for step 1
$reqs = [];
if ($step === 1) {
    $reqs = $installer->checkRequirements();
}

// Render layout with the step template loaded inside
require_once dirname(__DIR__) . '/views/install/layout.php';
