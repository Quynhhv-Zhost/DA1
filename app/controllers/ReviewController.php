<?php
class ReviewController extends Controller
{
<<<<<<< Updated upstream
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
=======
    public function store()
    {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user'])) {
            die('Bạn phải đăng nhập để gửi đánh giá.');
        }

        // Lấy dữ liệu từ form
        $product_id = $_POST['product_id'] ?? 0;
        $rating     = $_POST['rating'] ?? 0;
        $comment    = $_POST['comment'] ?? '';

        // Lấy user_id trực tiếp từ session để tránh fake hidden input
        $user_id = $_SESSION['user']['id'];

        // Validate rating (1–5)
        if ($rating < 1 || $rating > 5) {
            die('Giá trị rating không hợp lệ.');
        }

        // Validate comment không rỗng
        if (trim($comment) === '') {
            die('Bình luận không được để trống.');
        }

        // Kết nối DB và insert
        $db = new Database();
        $db->query(
            "INSERT INTO product_reviews (product_id, user_id, rating, comment) VALUES (?, ?, ?, ?)",
            [$product_id, $user_id, $rating, $comment]
        );

        // Redirect về trang chi tiết sản phẩm
        header("Location: ?url=client/detail/$product_id");
        exit;
    }
    public function loadMore()
    {
        $product_id = $_GET['product_id'] ?? 0;
        $offset = $_GET['offset'] ?? 0;

        $reviewModel = $this->model('Review');
        $reviews = $reviewModel->getReviewsByProductId($product_id, 3, $offset);

        foreach ($reviews as $review) : ?>
            <div class="border p-3 rounded mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <strong><?= htmlspecialchars($review['username'] ?? 'Khách') ?></strong>
                    <div class="star-display">
                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                            <span class="star <?= $i <= (int)$review['rating'] ? 'active' : '' ?>">&#9733;</span>
                        <?php endfor; ?>
                    </div>
                </div>
                <p class="mb-0"><?= nl2br(htmlspecialchars($review['comment'])) ?></p>
                <small class="text-muted"><?= date('d/m/Y H:i', strtotime($review['created_at'])) ?></small>
            </div>
        <?php endforeach;
        exit;
    }
    public function paginate()
    {
        $product_id = $_GET['product_id'] ?? 0;
        $page = $_GET['page'] ?? 1;
        $limit = 3;
        $offset = ($page - 1) * $limit;

        $reviewModel = $this->model('Review');
        $reviews = $reviewModel->getReviewsByProductId($product_id, $limit, $offset);

        foreach ($reviews as $review) : ?>
            <div class="border p-3 rounded mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <strong><?= htmlspecialchars($review['username'] ?? 'Khách') ?></strong>
                    <div class="star-display">
                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                            <span class="star <?= $i <= (int)$review['rating'] ? 'active' : '' ?>">&#9733;</span>
                        <?php endfor; ?>
                    </div>
                </div>
                <p class="mb-0"><?= nl2br(htmlspecialchars($review['comment'])) ?></p>
                <small class="text-muted"><?= date('d/m/Y H:i', strtotime($review['created_at'])) ?></small>
            </div>
<?php endforeach;
        exit;
    }
>>>>>>> Stashed changes
}
