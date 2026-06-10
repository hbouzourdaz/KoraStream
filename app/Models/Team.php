<?php
/**
 * Team Model
 */

class Team {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function getAll() {
        if (!$this->db) return [];
        $stmt = $this->db->query("SELECT * FROM teams ORDER BY name ASC");
        return $stmt->fetchAll();
    }

    public function getById($id) {
        if (!$this->db) return null;
        $stmt = $this->db->prepare("SELECT * FROM teams WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($name, $logo) {
        if (!$this->db) return false;
        $stmt = $this->db->prepare("INSERT INTO teams (name, logo) VALUES (?, ?)");
        return $stmt->execute([$name, $logo]);
    }

    public function update($id, $name, $logo) {
        if (!$this->db) return false;
        if ($logo !== null) {
            $stmt = $this->db->prepare("UPDATE teams SET name = ?, logo = ? WHERE id = ?");
            return $stmt->execute([$name, $logo, $id]);
        } else {
            $stmt = $this->db->prepare("UPDATE teams SET name = ? WHERE id = ?");
            return $stmt->execute([$name, $id]);
        }
    }

    public function delete($id) {
        if (!$this->db) return false;
        $stmt = $this->db->prepare("DELETE FROM teams WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function count() {
        if (!$this->db) return 0;
        $stmt = $this->db->query("SELECT COUNT(*) FROM teams");
        return (int)$stmt->fetchColumn();
    }
}
