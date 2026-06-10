<?php
/**
 * AppSetting Model
 */

class AppSetting {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function getAll() {
        if (!$this->db) return [];
        $stmt = $this->db->query("SELECT * FROM app_settings");
        $settings = [];
        while ($row = $stmt->fetch()) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        return $settings;
    }

    public function get($key, $default = null) {
        if (!$this->db) return $default;
        $stmt = $this->db->prepare("SELECT setting_value FROM app_settings WHERE setting_key = ?");
        $stmt->execute([$key]);
        $val = $stmt->fetchColumn();
        return ($val !== false) ? $val : $default;
    }

    public function save($key, $value) {
        if (!$this->db) return false;
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM app_settings WHERE setting_key = ?");
        $stmt->execute([$key]);
        if ($stmt->fetchColumn() > 0) {
            $stmt = $this->db->prepare("UPDATE app_settings SET setting_value = ? WHERE setting_key = ?");
            return $stmt->execute([$value, $key]);
        } else {
            $stmt = $this->db->prepare("INSERT INTO app_settings (setting_key, setting_value) VALUES (?, ?)");
            return $stmt->execute([$key, $value]);
        }
    }
}
