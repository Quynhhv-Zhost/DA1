<?php

class User extends Database
{
    // Lấy người dùng theo tên đăng nhập
    public function getUserByUsername($username)
    {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->query($sql, [$username]);
        return $stmt->fetch();
    }

    // Tạo người dùng (đăng ký đơn giản)
    public function createUser($username, $password)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT); // bảo mật tốt hơn md5
        $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, 'user')";
        return $this->query($sql, [$username, $hash]);
    }

    // Lấy tất cả người dùng
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
        $fields = [];
        $params = [];

        foreach ($data as $key => $value) {
            // Nếu cập nhật mật khẩu, hãy hash lại
            if ($key === 'password') {
                $value = password_hash($value, PASSWORD_DEFAULT);
            }
            $fields[] = "$key = ?";
            $params[] = $value;
        }

        $params[] = $id;
        $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = ?";
        return $this->query($sql, $params);
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
}
