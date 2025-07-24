<?php
class ReviewController extends Controller
{
  public function store()
  {
    // Kiểm tra đăng nhập
    if (!isset($_SESSION['user'])) {
      die('Bạn phải đăng nhập để gửi đánh giá.');
    }

    $product_id = $_POST['product_id'];
    $user_id    = $_POST['user_id'];
    $rating     = $_POST['rating'];
    $comment    = $_POST['comment'];

    $db = new Database(); // sử dụng PDO

    $db->query(
      "INSERT INTO product_reviews (product_id, user_id, rating, comment) VALUES (?, ?, ?, ?)",
      [$product_id, $user_id, $rating, $comment]
    );


    header("Location: ?url=client/detail/$product_id");

    exit;
  }
}
