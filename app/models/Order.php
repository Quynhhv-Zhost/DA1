<?php
class Order extends Database
{
    public function createOrder($userId, $totalPrice, $paymentMethod)
    {
        $this->query(
            "INSERT INTO orders (user_id, total_price, payment_method, status) VALUES (?, ?, ?, 'pending')",
            [$userId, $totalPrice, $paymentMethod]
        );
        return $this->pdo->lastInsertId();
    }

    public function addOrderItems($orderId, $cartItems)
    {
        foreach ($cartItems as $item) {
            $this->query(
                "INSERT INTO order_items (order_id, product_id, variation_id, quantity, price) VALUES (?, ?, ?, ?, ?)",
                [
                    $orderId,
                    $item['product_id'],      // ✅ Bổ sung product_id
                    $item['variation_id'],
                    $item['quantity'],
                    $item['price']
                ]
            );
        }
    }
    public function getOrderById($orderId, $userId)
    {
        // Lấy đơn hàng
        $order = $this->query(
            "SELECT * FROM orders WHERE id = ? AND user_id = ?",
            [$orderId, $userId]
        )->fetch();

        if (!$order) return null;

        // Lấy danh sách sản phẩm kèm ảnh
        $orderItems = $this->query(
            "SELECT 
            oi.*, 
            v.color, v.size, 
            COALESCE(v.image, p.image) AS image,
            p.name AS product_name,
            oi.price
        FROM order_items oi
        JOIN product_variations v ON oi.variation_id = v.id
        JOIN products p ON v.product_id = p.id
        WHERE oi.order_id = ?        
        ",
            [$orderId]
        )->fetchAll();

        $order['items'] = $orderItems;
        return $order;
    }
    public function getOrdersByUser($userId)
    {
        $stmt = $this->query(
            "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC",
            [$userId]
        );
        return $stmt->fetchAll();
    }

    // Lấy tất cả đơn hàng cho admin
    public function getAllOrders()
    {
        return $this->query("SELECT * FROM orders ORDER BY created_at DESC")->fetchAll();
    }

    // Lấy chi tiết đơn hàng cho admin (không ràng buộc user)
    public function getOrderByIdAdmin($orderId)
    {
        $order = $this->query(
            "SELECT * FROM orders WHERE id = ?",
            [$orderId]
        )->fetch();

        if (!$order) return null;

        $orderItems = $this->query(
            "SELECT 
                    oi.*, 
                    v.color, v.size, 
                    COALESCE(v.image, p.image) AS image,
                    p.name AS product_name,
                    oi.price
                FROM order_items oi
                JOIN product_variations v ON oi.variation_id = v.id
                JOIN products p ON v.product_id = p.id
                WHERE oi.order_id = ?",
            [$orderId]
        )->fetchAll();

        $order['items'] = $orderItems;
        return $order;
    }

    // Cập nhật trạng thái đơn hàng (admin duyệt, chuyển trạng thái)
    public function updateStatus($id, $status)
    {
        $this->query("UPDATE orders SET status = ? WHERE id = ?", [$status, $id]);
    }
}
