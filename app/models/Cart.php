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
                p.price AS product_price,  -- Lấy giá gốc của sản phẩm
                v.price_diff  -- Lấy sự chênh lệch giá từ biến thể
         FROM cart c
         JOIN product_variations v ON c.variation_id = v.id
         JOIN products p ON v.product_id = p.id
         WHERE c.user_id = ?",
            [$userId]
        );
        $cartItems = $stmt->fetchAll();

        // Duyệt qua các sản phẩm trong giỏ hàng và tính lại giá cuối cùng
        foreach ($cartItems as &$item) {
            // Tính giá cuối cùng của sản phẩm (giá cơ bản + sự chênh lệch giá từ biến thể)
            $item['final_price'] = $item['product_price'] + $item['price_diff'];
        }

        return $cartItems;
    }
    // Thêm sản phẩm vào giỏ hàng
    public function addToCart($userId, $variationId, $quantity = 1)
    {
        // Lấy thông tin biến thể
        $stmt = $this->db->query("SELECT * FROM product_variations WHERE id = ?", [$variationId]);
        $variation = $stmt->fetch();

        // Kiểm tra nếu có biến thể hợp lệ
        if (!$variation) {
            throw new Exception("Variation not found.");
        }

        // Lấy giá sản phẩm cơ bản
        $stmtProduct = $this->db->query("SELECT * FROM products WHERE id = ?", [$variation['product_id']]);
        $product = $stmtProduct->fetch();

        if (!$product) {
            throw new Exception("Product not found.");
        }

        // Tính giá cuối cùng của biến thể (giá gốc + price_diff)
        $finalPrice = $product['price'] + $variation['price_diff'];

        // Kiểm tra nếu sản phẩm này đã tồn tại trong giỏ hàng thì cộng dồn số lượng
        $stmt = $this->db->query(
            "SELECT * FROM cart WHERE user_id = ? AND variation_id = ?",
            [$userId, $variationId]
        );
        $existing = $stmt->fetch();

        if ($existing) {
            // Nếu sản phẩm đã tồn tại trong giỏ hàng, cập nhật số lượng và giá
            $this->db->query(
                "UPDATE cart SET quantity = quantity + ?, price = ? WHERE user_id = ? AND variation_id = ?",
                [$quantity, $finalPrice, $userId, $variationId]
            );
        } else {
            // Nếu sản phẩm chưa có trong giỏ hàng, thêm mới
            $this->db->query(
                "INSERT INTO cart (user_id, variation_id, quantity, price) VALUES (?, ?, ?, ?)",
                [$userId, $variationId, $quantity, $finalPrice]
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
