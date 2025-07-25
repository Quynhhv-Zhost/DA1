<?php
require_once __DIR__ . '/../../core/Database.php';

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllUsers()
    {
        $sql = "SELECT * FROM users";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserById($id)
    {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->db->query($sql, [$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserByUsername($username)
    {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->db->query($sql, [$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createUser($username, $password)
    {
        $hash = md5($password);
        $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, 'user')";
        $this->db->query($sql, [$username, $hash]);
    }

    public function deleteUser($id)
    {
        $sql = "DELETE FROM users WHERE id = ?";
        $this->db->query($sql, [$id]);
    }
}
