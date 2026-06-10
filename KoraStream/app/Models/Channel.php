<?php
/**
 * Channel Model
 */

class Channel {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function getAll() {
        if (!$this->db) return [];
        $stmt = $this->db->query("SELECT * FROM channels ORDER BY name ASC");
        return $stmt->fetchAll();
    }

    public function getActive() {
        if (!$this->db) return [];
        $stmt = $this->db->query("SELECT * FROM channels WHERE status = 'active' ORDER BY name ASC");
        return $stmt->fetchAll();
    }

    public function getById($id) {
        if (!$this->db) return null;
        $stmt = $this->db->prepare("SELECT * FROM channels WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($name, $logo, $stream_url, $status) {
        if (!$this->db) return false;
        $stmt = $this->db->prepare("INSERT INTO channels (name, logo, stream_url, status) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$name, $logo, $stream_url, $status]);
    }

    public function update($id, $name, $logo, $stream_url, $status) {
        if (!$this->db) return false;
        if ($logo !== null) {
            $stmt = $this->db->prepare("UPDATE channels SET name = ?, logo = ?, stream_url = ?, status = ? WHERE id = ?");
            return $stmt->execute([$name, $logo, $stream_url, $status, $id]);
        } else {
            $stmt = $this->db->prepare("UPDATE channels SET name = ?, stream_url = ?, status = ? WHERE id = ?");
            return $stmt->execute([$name, $stream_url, $status, $id]);
        }
    }

    public function delete($id) {
        if (!$this->db) return false;
        $stmt = $this->db->prepare("DELETE FROM channels WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function count() {
        if (!$this->db) return 0;
        $stmt = $this->db->query("SELECT COUNT(*) FROM channels");
        return (int)$stmt->fetchColumn();
    }

    public function countActive() {
        if (!$this->db) return 0;
        $stmt = $this->db->query("SELECT COUNT(*) FROM channels WHERE status = 'active'");
        return (int)$stmt->fetchColumn();
    }
}
