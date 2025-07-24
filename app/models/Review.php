<?php
class Review extends Database
{
  public function getReviewsByProductId($product_id)
  {
    $sql = "SELECT r.*, u.username 
                FROM product_reviews r
                LEFT JOIN users u ON r.user_id = u.id
                WHERE r.product_id = ?
                ORDER BY r.id DESC";
    return $this->query($sql, [$product_id])->fetchAll();
  }
}
