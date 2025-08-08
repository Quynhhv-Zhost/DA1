<?php
require_once __DIR__ . '/../../core/Database.php';

class Message extends Database
{
    // Lưu tin nhắn mới
    public function sendMessage($senderId, $receiverId, $message)
    {
        $sql = "INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)";
        $stmt = $this->query($sql, [$senderId, $receiverId, $message]);
        return $stmt !== false;
    }

    // Lấy tất cả tin nhắn giữa user và admin, bao gồm tên người gửi và người nhận
    public function getMessages($userId)
    {
        $sql = "SELECT m.*, us.username as sender_username, ur.username as receiver_username 
                FROM messages m 
                JOIN users us ON m.sender_id = us.id 
                JOIN users ur ON m.receiver_id = ur.id 
                WHERE (m.sender_id = ? AND m.receiver_id = 1) OR 
                      (m.sender_id = 1 AND m.receiver_id = ?) 
                ORDER BY m.created_at ASC";
        return $this->query($sql, [$userId, $userId])->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy danh sách tất cả user
    public function getAllUsers()
    {
        $sql = "SELECT id, username FROM users WHERE role = 'user'";
        return $this->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy danh sách người dùng đã nhắn tin với admin
    public function getUsersWithMessages()
    {
        // Truy vấn lấy danh sách người dùng có tin nhắn với admin (ID=1)
        $sql = "SELECT DISTINCT u.id, u.username
                FROM users u
                JOIN messages m ON u.id = m.sender_id OR u.id = m.receiver_id
                WHERE (m.sender_id = 1 OR m.receiver_id = 1) AND u.id != 1 AND u.role = 'user'
                ORDER BY u.username";
        return $this->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Đánh dấu tất cả tin nhắn từ $otherId → $viewerId là đã xem (chưa xem → cập nhật giờ hiện tại)
    public function markAsSeen($viewerId, $otherId)
    {
        $sql = "UPDATE messages
                SET seen_at = NOW()
                WHERE sender_id = ? AND receiver_id = ? AND seen_at IS NULL";
        $this->query($sql, [$otherId, $viewerId]);
    }
}
