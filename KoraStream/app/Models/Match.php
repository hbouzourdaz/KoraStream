<?php
/**
 * Match Model
 */

class MatchModel {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function getAll() {
        if (!$this->db) return [];
        $sql = "SELECT m.*, 
                       ht.name AS home_team_name, ht.logo AS home_team_logo,
                       at.name AS away_team_name, at.logo AS away_team_logo,
                       l.name AS league_name, l.logo AS league_logo,
                       c.name AS channel_name
                FROM matches m
                JOIN teams ht ON m.home_team_id = ht.id
                JOIN teams at ON m.away_team_id = at.id
                JOIN leagues l ON m.league_id = l.id
                LEFT JOIN channels c ON m.channel_id = c.id
                ORDER BY m.match_time ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function getByDate($date) {
        if (!$this->db) return [];
        $sql = "SELECT m.*, 
                       ht.name AS home_team_name, ht.logo AS home_team_logo,
                       at.name AS away_team_name, at.logo AS away_team_logo,
                       l.name AS league_name, l.logo AS league_logo,
                       c.name AS channel_name
                FROM matches m
                JOIN teams ht ON m.home_team_id = ht.id
                JOIN teams at ON m.away_team_id = at.id
                JOIN leagues l ON m.league_id = l.id
                LEFT JOIN channels c ON m.channel_id = c.id
                WHERE DATE(m.match_time) = ?
                ORDER BY m.match_time ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$date]);
        return $stmt->fetchAll();
    }

    public function getTodayMatches() {
        return $this->getByDate(date('Y-m-d'));
    }

    public function getById($id) {
        if (!$this->db) return null;
        $sql = "SELECT m.*, 
                       ht.name AS home_team_name, ht.logo AS home_team_logo,
                       at.name AS away_team_name, at.logo AS away_team_logo,
                       l.name AS league_name, l.logo AS league_logo,
                       c.name AS channel_name
                FROM matches m
                JOIN teams ht ON m.home_team_id = ht.id
                JOIN teams at ON m.away_team_id = at.id
                JOIN leagues l ON m.league_id = l.id
                LEFT JOIN channels c ON m.channel_id = c.id
                WHERE m.id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getServers($matchId) {
        if (!$this->db) return [];
        $stmt = $this->db->prepare("SELECT * FROM match_servers WHERE match_id = ? ORDER BY id ASC");
        $stmt->execute([$matchId]);
        return $stmt->fetchAll();
    }

    public function create($home_id, $away_id, $league_id, $match_time, $status, $home_score, $away_score, $commentator, $channel_id) {
        if (!$this->db) return false;
        $sql = "INSERT INTO matches (home_team_id, away_team_id, league_id, match_time, status, home_score, away_score, commentator, channel_id) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $res = $stmt->execute([$home_id, $away_id, $league_id, $match_time, $status, $home_score, $away_score, $commentator, $channel_id]);
        if ($res) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    public function update($id, $home_id, $away_id, $league_id, $match_time, $status, $home_score, $away_score, $commentator, $channel_id) {
        if (!$this->db) return false;
        $sql = "UPDATE matches 
                SET home_team_id = ?, away_team_id = ?, league_id = ?, match_time = ?, status = ?, home_score = ?, away_score = ?, commentator = ?, channel_id = ? 
                WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$home_id, $away_id, $league_id, $match_time, $status, $home_score, $away_score, $commentator, $channel_id, $id]);
    }

    public function delete($id) {
        if (!$this->db) return false;
        $stmt = $this->db->prepare("DELETE FROM matches WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function updateScore($id, $home_score, $away_score) {
        if (!$this->db) return false;
        $stmt = $this->db->prepare("UPDATE matches SET home_score = ?, away_score = ? WHERE id = ?");
        return $stmt->execute([$home_score, $away_score, $id]);
    }

    public function addServer($match_id, $server_name, $stream_url, $player_type) {
        if (!$this->db) return false;
        $stmt = $this->db->prepare("INSERT INTO match_servers (match_id, server_name, stream_url, player_type) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$match_id, $server_name, $stream_url, $player_type]);
    }

    public function clearServers($match_id) {
        if (!$this->db) return false;
        $stmt = $this->db->prepare("DELETE FROM match_servers WHERE match_id = ?");
        return $stmt->execute([$match_id]);
    }

    public function count() {
        if (!$this->db) return 0;
        $stmt = $this->db->query("SELECT COUNT(*) FROM matches");
        return (int)$stmt->fetchColumn();
    }

    public function countLive() {
        if (!$this->db) return 0;
        $stmt = $this->db->query("SELECT COUNT(*) FROM matches WHERE status = 'live'");
        return (int)$stmt->fetchColumn();
    }
}
