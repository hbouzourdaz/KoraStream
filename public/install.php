<?php
/**
 * KoraStream Installer Gateway
 */

// Define application root
define('APP_ROOT', dirname(__DIR__));

// Load installation routes
require_once APP_ROOT . '/routes/install.php';
