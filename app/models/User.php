<?php

require_once __DIR__ . '/../../core/Database.php';

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getUserByUsername($username)
    {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->db->query($sql, [$username]);
        return $stmt->fetch();
    }
    public function createUser($username, $password)
    {
        $hash = md5($password); // hoặc password_hash() nếu muốn bảo mật hơn
        $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, 'user')";
        $this->db->query($sql, [$username, $hash]);
    }
}
