<?php
/**
 * AdSetting Model
 */

class AdSetting {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function getAll() {
        if (!$this->db) return [];
        $stmt = $this->db->query("SELECT * FROM ad_settings ORDER BY network_name ASC");
        return $stmt->fetchAll();
    }

    public function getByNetwork($networkName) {
        if (!$this->db) return null;
        $stmt = $this->db->prepare("SELECT * FROM ad_settings WHERE network_name = ?");
        $stmt->execute([$networkName]);
        return $stmt->fetch();
    }

    public function save($networkName, $settingsJson, $isActive) {
        if (!$this->db) return false;
        // Check if exists
        $existing = $this->getByNetwork($networkName);
        if ($existing) {
            $stmt = $this->db->prepare("UPDATE ad_settings SET settings_json = ?, is_active = ? WHERE network_name = ?");
            return $stmt->execute([$settingsJson, $isActive, $networkName]);
        } else {
            $stmt = $this->db->prepare("INSERT INTO ad_settings (network_name, settings_json, is_active) VALUES (?, ?, ?)");
            return $stmt->execute([$networkName, $settingsJson, $isActive]);
        }
    }

    public function getActiveAds() {
        if (!$this->db) return [];
        $stmt = $this->db->query("SELECT * FROM ad_settings WHERE is_active = 1");
        $ads = [];
        while ($row = $stmt->fetch()) {
            $ads[$row['network_name']] = json_decode($row['settings_json'], true);
        }
        return $ads;
    }
}
