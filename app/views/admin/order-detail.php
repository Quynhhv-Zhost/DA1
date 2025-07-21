<?php $title = 'Chi tiết đơn hàng'; ?>

<h2 class="mb-4">Chi tiết đơn hàng #<?= $order['id'] ?></h2>

<div class="mb-4">
    <strong>Khách hàng (user_id):</strong> <?= $order['user_id'] ?><br>
    <strong>Phương thức thanh toán:</strong> <?= htmlspecialchars($order['payment_method']) ?><br>
    <strong>Ngày đặt:</strong> <?= htmlspecialchars($order['created_at']) ?><br>
    <strong>Trạng thái:</strong>
    <span class="badge bg-<?= $order['status'] === 'completed' ? 'success' : ($order['status'] === 'canceled' ? 'danger' : 'warning') ?>">
        <?= htmlspecialchars($order['status']) ?>
    </span>
</div>

<h5>Sản phẩm đặt mua:</h5>
<table class="table table-hover align-middle">
    <thead>
        <tr>
            <th>Ảnh</th>
            <th>Sản phẩm</th>
            <th>Màu</th>
            <th>Size</th>
            <th>SL</th>
            <th>Giá</th>
            <th>Tổng</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($order['items'] as $item) : ?>
            <tr>
                <td><img src="/DA1/code/public/assets/images/<?= htmlspecialchars($item['image']) ?>" width="60" class="rounded"></td>
                <td><?= htmlspecialchars($item['product_name']) ?></td>
                <td><?= htmlspecialchars($item['color']) ?></td>
                <td><?= htmlspecialchars($item['size']) ?></td>
                <td><?= $item['quantity'] ?></td>
                <td><?= number_format($item['price'], 0, ',', '.') ?> VND</td>
                <td><?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?> VND</td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div class="mt-3 text-end">
    <strong>Tổng cộng: <span class="text-danger"><?= number_format($order['total_price'], 0, ',', '.') ?> VND</span></strong>
</div>

<!-- Form đổi trạng thái -->
<div class="mt-5">
    <form method="POST" action="?url=order/updateStatus/<?= $order['id'] ?>" class="d-inline-block">
        <div class="input-group">
            <select name="status" class="form-select" required>
                <option value="pending" <?= $order['status'] == 'pending' ? 'selected' : '' ?>>Chờ duyệt</option>
                <option value="completed" <?= $order['status'] == 'completed' ? 'selected' : '' ?>>Đã duyệt/Giao thành công</option>
                <option value="canceled" <?= $order['status'] == 'canceled' ? 'selected' : '' ?>>Huỷ đơn</option>
            </select>
            <button type="submit" class="btn btn-success">Cập nhật</button>
        </div>
    </form>
    <a href="?url=order/index" class="btn btn-secondary ms-3">⬅️ Quay lại danh sách</a>
</div>