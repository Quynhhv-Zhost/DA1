<?php
class Order extends Database
{
    public function createOrder($userId, $totalPrice, $paymentMethod, $address, $phone, $fullname, $email, $province, $district, $note)
    {
        $this->query(
            "INSERT INTO orders (user_id, total_price, payment_method, status, address, phone, fullname, email, province, district, note) 
         VALUES (?, ?, ?, 'pending', ?, ?, ?, ?, ?, ?, ?)",
            [
                $userId,
                $totalPrice,
                $paymentMethod,
                $address,
                $phone,
                $fullname,
                $email,
                $province,
                $district,
                $note
            ]
        );
        return $this->pdo->lastInsertId();
    }
    public function addOrderItems($orderId, $cartItems)
    {
        $total = 0; // để tính tổng đơn hàng

        foreach ($cartItems as $item) {
            // Giá cuối đã được xử lý khi thêm vào giỏ hàng (price = gốc + price_diff)
            $finalPrice = $item['price'];  // ✅ Không cộng lại variationPrice nữa

            // Tính VAT
            $finalPriceWithVAT = $finalPrice * 1.1;

            // Lưu vào order_items
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

            // Cộng dồn tổng tiền
            $total += $finalPriceWithVAT * $item['quantity'];
        }

        // Cập nhật total_price cho đơn hàng
        $this->query("UPDATE orders SET total_price = ? WHERE id = ?", [$total, $orderId]);
    }
    public function getOrderById($orderId, $userId)
    {
        // Lấy đơn hàng kèm username
        $order = $this->query(
            "SELECT 
                o.*, 
                u.username
            FROM orders o
            JOIN users u ON o.user_id = u.id
            WHERE o.id = ? AND o.user_id = ?",
            [$orderId, $userId]
        )->fetch();

        if (!$order) return null;

        // Lấy danh sách sản phẩm kèm thông tin biến thể
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
                v.price_diff
            FROM order_items oi
            JOIN product_variations v ON oi.variation_id = v.id
            JOIN products p ON v.product_id = p.id
            WHERE oi.order_id = ?",
            [$orderId]
        )->fetchAll();

        // Tính giá cuối cho mỗi sản phẩm trong đơn hàng (giá gốc + giá biến thể)
        foreach ($orderItems as &$item) {
            $item['final_price'] = $item['variation_price'] + $item['price_diff'];
            $item['final_price_with_vat'] = $item['final_price'] * 1.1;
        }

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
            "SELECT orders.*, users.username 
             FROM orders 
             JOIN users ON orders.user_id = users.id 
             WHERE orders.id = ?",
            [$orderId]
        )->fetch();

        if (!$order) return null;

        // Lấy danh sách sản phẩm kèm thông tin biến thể
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
                v.price_diff
            FROM order_items oi
            JOIN product_variations v ON oi.variation_id = v.id
            JOIN products p ON v.product_id = p.id
            WHERE oi.order_id = ?",
            [$orderId]
        )->fetchAll();

        // Tính giá cuối cho mỗi sản phẩm (bao gồm VAT)
        foreach ($orderItems as &$item) {
            $item['final_price_with_vat'] = $item['variation_price']; // đã bao gồm VAT
        }


        $order['items'] = $orderItems;
        return $order;
    }


    // Cập nhật trạng thái đơn hàng (admin duyệt, chuyển trạng thái)
    public function updateStatus($id, $newStatus)
    {
        // Lấy trạng thái hiện tại
        $current = $this->query("SELECT status FROM orders WHERE id = ?", [$id])->fetchColumn();

        // Danh sách trạng thái được phép chuyển tiếp
        $allowedTransitions = [
            'pending'    => ['preparing', 'canceled'],
            'preparing'  => ['packed', 'canceled'],
            'packed'     => ['shipping'],        // admin chuyển sang shipping
            'shipping'   => ['delivered'],       // admin chuyển sang delivered
            'delivered'  => ['completed'],       // client hoặc hệ thống mới chuyển
            'completed'  => [],
            'canceled'   => [],
        ];

        if (!in_array($newStatus, $allowedTransitions[$current] ?? [])) {
            throw new Exception("Trạng thái không hợp lệ hoặc không được phép cập nhật.");
        }

        $this->query("UPDATE orders SET status = ? WHERE id = ?", [$newStatus, $id]);
    }
    public function updateDeliveryInfo($orderId, $fullname, $email, $phone, $province, $district, $address, $note)
    {
        $this->query("UPDATE orders SET fullname = ?, email = ?, phone = ?, province = ?, district = ?, address = ?, note = ? WHERE id = ?", [
            $fullname,
            $email,
            $phone,
            $province,
            $district,
            $address,
            $note,
            $orderId
        ]);
    }
    public function autoCompleteDeliveredOrders()
    {
        $sql = "UPDATE orders SET status = 'completed'
            WHERE status = 'delivered' 
              AND TIMESTAMPDIFF(DAY, created_at, NOW()) >= 3";
        $this->query($sql);
    }
    public function getOrdersByFilter($userId, $status = null, $q = null)
    {
        $sql = "SELECT * FROM orders WHERE user_id = ?";
        $params = [$userId];

        if (!empty($q)) {
            $sql .= " AND id = ?";
            $params[] = $q;
        }

        if (!empty($status)) {
            $sql .= " AND status = ?";
            $params[] = $status;
        }

        $sql .= " ORDER BY created_at DESC";
        return $this->query($sql, $params)->fetchAll();
    }
}
