<?php
/**
 * KoraStream Database Connection Class
 */

class Database {
    private static $conn = null;

    public static function connect() {
        if (self::$conn === null) {
            $envPath = dirname(__DIR__) . '/.env';
            
            $dbHost = getenv('DB_HOST') ?: 'localhost';
            $dbName = getenv('DB_NAME') ?: '';
            $dbUser = getenv('DB_USER') ?: '';
            $dbPass = getenv('DB_PASS') ?: '';

            if (file_exists($envPath)) {
                $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                foreach ($lines as $line) {
                    $line = trim($line);
                    if (empty($line) || strpos($line, '#') === 0) {
                        continue;
                    }
                    if (strpos($line, '=') !== false) {
                        list($key, $value) = explode('=', $line, 2);
                        $key = trim($key);
                        $value = trim($value, " \t\n\r\0\x0B\"'");
                        
                        switch ($key) {
                            case 'DB_HOST':
                                $dbHost = $value;
                                break;
                            case 'DB_NAME':
                                $dbName = $value;
                                break;
                            case 'DB_USER':
                                $dbUser = $value;
                                break;
                            case 'DB_PASS':
                                $dbPass = $value;
                                break;
                        }
                    }
                }
            } else if (empty($dbName) || empty($dbUser)) {
                return null;
            }

            try {
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ];
                
                if (strpos($dbHost, 'tidbcloud') !== false) {
                    $options[PDO::MYSQL_ATTR_SSL_CA] = dirname(__DIR__) . '/cacert.pem';
                    $options[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = true;
                }

                self::$conn = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4", $dbUser, $dbPass, $options);
            } catch (PDOException $e) {
                // Return null if connection fails (useful for the installer check)
                return null;
            }
        }
        return self::$conn;
    }
}
