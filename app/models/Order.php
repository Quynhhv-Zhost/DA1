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
        $total = 0;

        foreach ($cartItems as $item) {
            $finalPrice = $item['price']; // Giá đã bao gồm biến thể

            // Tính VAT (10%)
            $finalPriceWithVAT = $finalPrice * 1.1;

            $this->query(
                "INSERT INTO order_items (order_id, product_id, variation_id, quantity, price) VALUES (?, ?, ?, ?, ?)",
                [
                    $orderId,
                    $item['product_id'],
                    $item['variation_id'],
                    $item['quantity'],
                    $finalPriceWithVAT
                ]
            );

            $total += $finalPriceWithVAT * $item['quantity'];
        }

        $this->query("UPDATE orders SET total_price = ? WHERE id = ?", [$total, $orderId]);
    }

    public function getOrderById($orderId, $userId)
    {
        $order = $this->query(
            "SELECT * FROM orders WHERE id = ? AND user_id = ?",
            [$orderId, $userId]
        )->fetch();

        if (!$order) return null;

        $orderItems = $this->query(
            "SELECT 
                oi.*, 
                v.color, 
                v.size, 
                v.image AS variation_image,
                p.image AS product_image,
                COALESCE(NULLIF(v.image, ''), p.image) AS image,
                p.name AS product_name,
                oi.price AS variation_price,
                v.price AS variant_price
            FROM order_items oi
            JOIN product_variations v ON oi.variation_id = v.id
            JOIN products p ON v.product_id = p.id
            WHERE oi.order_id = ?",
            [$orderId]
        )->fetchAll();

        foreach ($orderItems as &$item) {
            $item['final_price'] = $item['variant_price'];
            $item['final_price_with_vat'] = $item['variant_price'] * 1.1;
        }

        $order['items'] = $orderItems;
        return $order;
    }

    public function getOrdersByUser($userId)
    {
        return $this->query(
            "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC",
            [$userId]
        )->fetchAll();
    }

    public function getAllOrders()
    {
        return $this->query("SELECT * FROM orders ORDER BY created_at DESC")->fetchAll();
    }

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
                v.color, 
                v.size, 
                v.image AS variation_image,
                p.image AS product_image,
                COALESCE(NULLIF(v.image, ''), p.image) AS image,
                p.name AS product_name,
                oi.price AS variation_price,
                v.price AS variant_price
            FROM order_items oi
            JOIN product_variations v ON oi.variation_id = v.id
            JOIN products p ON v.product_id = p.id
            WHERE oi.order_id = ?",
            [$orderId]
        )->fetchAll();

        foreach ($orderItems as &$item) {
            $item['final_price_with_vat'] = $item['variation_price'];
        }

        $order['items'] = $orderItems;
        return $order;
    }

    public function updateStatus($id, $status)
    {
        $this->query("UPDATE orders SET status = ? WHERE id = ?", [$status, $id]);
    }
}
