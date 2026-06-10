<?php
/**
 * Auth Controller
 */

class AuthController {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public static function isLoggedIn() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
    }

    public static function checkAuth() {
        if (!self::isLoggedIn()) {
            header("Location: index.php?page=admin&action=login");
            exit;
        }
    }

    public function login($email, $password) {
        if (!$this->db) return "Database not connected.";

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $stmt = $this->db->prepare("SELECT * FROM admins WHERE email = ?");
        $stmt->execute([$email]);
        $admin = $stmt->fetch();

        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_email'] = $admin['email'];
            $_SESSION['admin_role'] = $admin['role'];
            return true;
        }
        return "Invalid email or password.";
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        header("Location: index.php?page=admin&action=login");
        exit;
    }

    public function createAdmin($email, $password, $role = 'admin') {
        if (!$this->db) return false;
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare("INSERT INTO admins (email, password, role) VALUES (?, ?, ?)");
        return $stmt->execute([$email, $hashedPassword, $role]);
    }
}
