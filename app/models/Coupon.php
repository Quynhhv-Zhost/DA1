<?php
class Coupon extends Database
{
    // Tìm mã giảm giá theo code
    public function findByCode($code)
    {
        $sql = "SELECT * FROM coupons WHERE code = ?";
        $stmt = $this->query($sql, [$code]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Trả về 1 dòng nếu có
    }
}
