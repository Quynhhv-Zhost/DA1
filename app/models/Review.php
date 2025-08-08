<?php
class Review extends Database
{
<<<<<<< Updated upstream
  public function getReviewsByProductId($product_id)
  {
    $sql = "SELECT r.*, u.username 
                FROM product_reviews r
                LEFT JOIN users u ON r.user_id = u.id
                WHERE r.product_id = ?
                ORDER BY r.id DESC";
    return $this->query($sql, [$product_id])->fetchAll();
  }
=======
    public function getReviewsByProductId($product_id, $limit = 3, $offset = 0)
    {
        $limit = (int)$limit;
        $offset = (int)$offset;

        $sql = "SELECT r.*, u.username 
            FROM product_reviews r
            LEFT JOIN users u ON r.user_id = u.id
            WHERE r.product_id = ?
            ORDER BY r.id DESC
            LIMIT $limit OFFSET $offset";
        return $this->query($sql, [$product_id])->fetchAll();
    }

    public function countReviewsByProductId($product_id)
    {
        $sql = "SELECT COUNT(*) as total FROM product_reviews WHERE product_id = ?";
        return $this->query($sql, [$product_id])->fetch()['total'];
    }
>>>>>>> Stashed changes
}
