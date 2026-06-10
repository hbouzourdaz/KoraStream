<?php
/**
 * KoraStream Main Web Gateway
 */

// Define application root
define('APP_ROOT', dirname(__DIR__));

// Load installation check
require_once APP_ROOT . '/app/Controllers/InstallController.php';

if (!InstallController::isInstalled()) {
    header("Location: install.php");
    exit;
}

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load main routing rules
require_once APP_ROOT . '/routes/web.php';
