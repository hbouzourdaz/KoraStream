<?php
/**
 * Install Controller
 */

class InstallController {
    
    public static function isInstalled() {
        // First check Vercel Env Var
        if (getenv('INSTALLED') === 'true') {
            return true;
        }

        $envPath = dirname(dirname(__DIR__)) . '/.env';
        if (file_exists($envPath)) {
            $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                $line = trim($line);
                if (strpos($line, 'INSTALLED=true') === 0) {
                    return true;
                }
            }
        }

        // If DB variables are present but INSTALLED is not explicitly set,
        // we check if the 'app_settings' table actually exists in the database.
        if (getenv('DB_HOST')) {
            try {
                require_once dirname(dirname(__DIR__)) . '/config/database.php';
                $conn = Database::getConnection();
                if ($conn) {
                    $stmt = $conn->query("SHOW TABLES LIKE 'app_settings'");
                    if ($stmt && $stmt->rowCount() > 0) {
                        return true;
                    }
                }
            } catch (Exception $e) {
                return false;
            }
        }
        
        return false;
    }



    public function checkRequirements() {
        $reqs = [
            'php_version' => version_compare(PHP_VERSION, '7.4.0', '>='),
            'pdo' => extension_loaded('pdo'),
            'pdo_mysql' => extension_loaded('pdo_mysql'),
            'mbstring' => extension_loaded('mbstring'),
            'json' => extension_loaded('json'),
            'env_writable' => is_writable(dirname(dirname(__DIR__))) || !file_exists(dirname(dirname(__DIR__)) . '/.env'),
            'uploads_writable' => is_writable(dirname(dirname(__DIR__)) . '/public')
        ];

        // Try creating uploads directories if they don't exist
        $root = dirname(dirname(__DIR__));
        $paths = [
            $root . '/public/uploads',
            $root . '/public/uploads/leagues',
            $root . '/public/uploads/teams',
            $root . '/public/uploads/channels'
        ];
        foreach ($paths as $path) {
            if (!file_exists($path)) {
                @mkdir($path, 0755, true);
            }
        }

        $reqs['uploads_writable'] = is_writable($root . '/public/uploads');
        return $reqs;
    }

    public function testDatabase($host, $name, $user, $pass) {
        try {
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_TIMEOUT => 5, // 5 seconds timeout
            ];
            
            if (strpos($host, 'tidbcloud') !== false) {
                $options[PDO::MYSQL_ATTR_SSL_CA] = dirname(dirname(__DIR__)) . '/cacert.pem';
                $options[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = true;
            }

            $conn = new PDO("mysql:host=$host;dbname=$name;charset=utf8mb4", $user, $pass, $options);
            return true;
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function runInstall($host, $name, $user, $pass, $admin_email, $admin_pass) {
        // 1. Establish database connection
        try {
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ];

            if (strpos($host, 'tidbcloud') !== false) {
                $options[PDO::MYSQL_ATTR_SSL_CA] = dirname(dirname(__DIR__)) . '/cacert.pem';
                $options[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = true;
            }

            $db = new PDO("mysql:host=$host", $user, $pass, $options);
            // Create database if not exists
            $db->exec("CREATE DATABASE IF NOT EXISTS `$name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            $db->exec("USE `$name`");
        } catch (PDOException $e) {
            return "Connection failed: " . $e->getMessage();
        }

        // 2. Import install.sql
        $sqlPath = dirname(dirname(__DIR__)) . '/install.sql';
        if (!file_exists($sqlPath)) {
            return "Schema file (install.sql) not found in root.";
        }

        $sql = file_get_contents($sqlPath);
        try {
            // Disable foreign key checks temporarily for seeding clean start
            $db->exec("SET FOREIGN_KEY_CHECKS = 0;");
            
            // Quote-aware SQL statement splitter
            // Tracks whether we are inside a string literal so semicolons
            // inside quoted values (e.g. JSON) are not treated as delimiters.
            $statements = [];
            $current = '';
            $inString = false;
            $stringChar = '';
            $len = strlen($sql);

            for ($i = 0; $i < $len; $i++) {
                $ch = $sql[$i];

                if ($inString) {
                    $current .= $ch;
                    // Handle escaped characters (skip next char)
                    if ($ch === '\\' && $i + 1 < $len) {
                        $i++;
                        $current .= $sql[$i];
                        continue;
                    }
                    // End of string
                    if ($ch === $stringChar) {
                        $inString = false;
                    }
                } else {
                    if ($ch === '\'' || $ch === '"') {
                        $inString = true;
                        $stringChar = $ch;
                        $current .= $ch;
                    } elseif ($ch === ';') {
                        // Statement boundary
                        $trimmed = trim($current);
                        // Strip SQL comments and check if non-empty
                        $cleaned = trim(preg_replace('/^--.*$/m', '', $trimmed));
                        if (!empty($cleaned)) {
                            $statements[] = $trimmed;
                        }
                        $current = '';
                    } else {
                        $current .= $ch;
                    }
                }
            }
            // Catch trailing statement without semicolon
            $trimmed = trim($current);
            $cleaned = trim(preg_replace('/^--.*$/m', '', $trimmed));
            if (!empty($cleaned)) {
                $statements[] = $trimmed;
            }

            // Execute each statement
            foreach ($statements as $statement) {
                $db->exec($statement);
            }
            
            $db->exec("SET FOREIGN_KEY_CHECKS = 1;");
        } catch (PDOException $e) {
            return "Failed to import tables: " . $e->getMessage();
        }

        // 3. Create Admin Account
        $hashedPassword = password_hash($admin_pass, PASSWORD_BCRYPT);
        try {
            // Clean existing admins
            $db->exec("DELETE FROM admins");
            $stmt = $db->prepare("INSERT INTO admins (email, password, role) VALUES (?, ?, 'super_admin')");
            $stmt->execute([$admin_email, $hashedPassword]);
        } catch (PDOException $e) {
            return "Failed to create administrator account: " . $e->getMessage();
        }

        // 4. Generate .env file
        $envPath = dirname(dirname(__DIR__)) . '/.env';
        $appUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . str_replace('/public', '', dirname($_SERVER['SCRIPT_NAME']));
        $appUrl = rtrim($appUrl, '/');

        $envContent = "DB_HOST=$host\n" .
                      "DB_NAME=$name\n" .
                      "DB_USER=$user\n" .
                      "DB_PASS=$pass\n" .
                      "APP_URL=$appUrl\n" .
                      "INSTALLED=true\n";

        if (file_put_contents($envPath, $envContent) === false) {
            return "Failed to write .env file to root. Please check directory permissions.";
        }

        return true;
    }
}
