<?php

require_once __DIR__ . '/../../core/Database.php';

class User extends Database
{
    // private $db;

    // public function __construct()
    // {
    //     parent::__construct();
    // }

    public function getUserByUsername($username)
    {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->query($sql, [$username]);
        return $stmt->fetch();
    }
    public function createUser($username, $password, $role = 'user')
    {
        $hash = md5($password); // hoặc password_hash()
        $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
        $this->query($sql, [$username, $hash, $role]);
    }

    public function all()
    {
        return $this->query("SELECT * FROM users ORDER BY id DESC")->fetchAll();
    }


    // Tìm người dùng theo ID
    public function find($id)
    {
        return $this->query("SELECT * FROM users WHERE id = ?", [$id])->fetch();
    }

    // Tạo người dùng với role tùy chọn
    public function create($username, $password, $role)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        return $this->query(
            "INSERT INTO users (username, password, role) VALUES (?, ?, ?)",
            [$username, $hash, $role]
        );
    }

    // Cập nhật người dùng
    public function update($id, $data)
    {
        if (isset($data['password'])) {
            return $this->query(
                "UPDATE users SET username = ?, role = ?, password = ? WHERE id = ?",
                [$data['username'], $data['role'], $data['password'], $id]
            );
        } else {
            return $this->query(
                "UPDATE users SET username = ?, role = ? WHERE id = ?",
                [$data['username'], $data['role'], $id]
            );
        }
    }


    // Xóa người dùng
    public function delete($id)
    {
        // Kiểm tra xem user có đơn hàng không
        $hasOrders = $this->query("SELECT COUNT(*) FROM orders WHERE user_id = ?", [$id])->fetchColumn();
        if ($hasOrders > 0) {
            throw new Exception("Không thể xóa người dùng vì đã có đơn hàng.");
        }

        // Nếu không có đơn hàng thì xóa
        return $this->query("DELETE FROM users WHERE id = ?", [$id]);
    }
    public function searchByUsername($keyword)
    {
        return $this->query(
            "SELECT * FROM users WHERE username LIKE ? ORDER BY id DESC",
            ["%$keyword%"]
        )->fetchAll();
    }
}
