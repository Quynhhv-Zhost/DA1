<?php
class Cart
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Lấy giỏ hàng với đầy đủ thông tin sản phẩm và biến thể
    public function getCartWithProductInfo($userId)
    {
        $stmt = $this->db->query(
            "SELECT c.*, 
                    p.id AS product_id,
                    p.name AS product_name, 
                    p.image, 
                    v.color, 
                    v.size,
                    v.price
             FROM cart c
             JOIN product_variations v ON c.variation_id = v.id
             JOIN products p ON v.product_id = p.id
             WHERE c.user_id = ?",
            [$userId]
        );
        return $stmt->fetchAll();
    }


    // Thêm sản phẩm vào giỏ hàng
    public function addToCart($userId, $variationId, $quantity = 1)
    {
        // Kiểm tra nếu sản phẩm này đã tồn tại trong giỏ hàng thì cộng dồn số lượng
        $stmt = $this->db->query(
            "SELECT * FROM cart WHERE user_id = ? AND variation_id = ?",
            [$userId, $variationId]
        );
        $existing = $stmt->fetch();

        if ($existing) {
            $this->db->query(
                "UPDATE cart SET quantity = quantity + ? WHERE user_id = ? AND variation_id = ?",
                [$quantity, $userId, $variationId]
            );
        } else {
            $this->db->query(
                "INSERT INTO cart (user_id, variation_id, quantity) VALUES (?, ?, ?)",
                [$userId, $variationId, $quantity]
            );
        }
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function removeFromCart($userId, $variationId)
    {
        $stmt = $this->db->query(
            "DELETE FROM cart WHERE user_id = ? AND variation_id = ?",
            [$userId, $variationId]
        );
        return $stmt->rowCount();
    }
    public function clearCart($userId)
    {
        $this->db->query("DELETE FROM cart WHERE user_id = ?", [$userId]);
    }
}
