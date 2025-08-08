<?php $title = 'Chi tiết đơn hàng'; ?>

<h2 class="mb-4">Chi tiết đơn hàng #<?= $order['id'] ?></h2>

<div class="mb-4">
  <strong>Khách hàng:</strong> <?= htmlspecialchars($order['username']) ?> (ID: <?= $order['user_id'] ?>)<br>
  <strong>Phương thức thanh toán:</strong> <?= htmlspecialchars($order['payment_method']) ?><br>
  <strong>Họ và tên người nhận:</strong> <?= htmlspecialchars($order['fullname'] ?? '') ?><br>
  <strong>Email:</strong> <?= htmlspecialchars($order['email'] ?? '') ?><br>
  <strong>Số điện thoại:</strong> <?= htmlspecialchars($order['phone'] ?? '') ?><br>
  <strong>Tỉnh/Thành phố:</strong> <?= htmlspecialchars($order['province'] ?? '') ?><br>
  <strong>Quận/Huyện:</strong> <?= htmlspecialchars($order['district'] ?? '') ?><br>
  <strong>Địa chỉ chi tiết:</strong> <?= htmlspecialchars($order['address'] ?? '') ?><br>
  <strong>Ghi chú:</strong> <?= htmlspecialchars($order['note'] ?? '') ?><br>
  <br>
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
    <?php foreach ($data['order']['items'] as $item) : ?>
      <tr>
        <td>
          <div class="product-item">
            <img src="/DA1/code/public/assets/images/<?= htmlspecialchars($item['image']) ?>" width="60" class="rounded">
          </div>
        </td>
        <td><?= htmlspecialchars($item['product_name']) ?></td>
        <td><?= htmlspecialchars($item['color']) ?></td>
        <td><?= htmlspecialchars($item['size']) ?></td>
        <td><?= $item['quantity'] ?></td>
        <td>
          <!-- Hiển thị giá cuối cùng (final_price) đã tính VAT -->
          <?= isset($item['final_price_with_vat']) ? number_format($item['final_price_with_vat'], 0, ',', '.') : '0' ?> VND
        </td>
        <td>
          <!-- Tính tổng tiền cho sản phẩm (final_price * quantity) -->
          <?= isset($item['final_price_with_vat']) ? number_format($item['final_price_with_vat'] * $item['quantity'], 0, ',', '.') : '0' ?> VND
        </td>
      </tr>
    <?php endforeach; ?>


  </tbody>
</table>
<div class="mt-3 text-end">
  <strong>Tổng cộng: <span class="text-danger"><?= number_format($order['total_price'], 0, ',', '.') ?> VND</span></strong> <!-- Tổng tiền đơn hàng -->
</div>

<!-- Form đổi trạng thái -->
<div class="mt-5">
  <form method="POST" action="?url=order/updateStatus/<?= $order['id'] ?>" class="d-inline-block">
    <div class="input-group">
      <?php
      // Khai báo danh sách trạng thái đầy đủ và trạng thái được phép cập nhật tiếp theo
      $status = $order['status'];
      $statusLabels = [
        'pending'    => 'Chờ duyệt',
        'preparing'  => 'Đang chuẩn bị',
        'packed'     => 'Đã đóng gói',
        'shipping'   => 'Đã giao cho vận chuyển',
        'delivered'  => 'Đã giao hàng (chờ xác nhận)',
        'completed'  => 'Hoàn thành',
        'canceled'   => 'Đã huỷ',
      ];

      $adminTransitions = [
        'pending'    => ['preparing', 'canceled'],
        'preparing'  => ['packed', 'canceled'],
        'packed'     => ['shipping'],
        'shipping'   => ['delivered'],
        'delivered'  => [], // client mới xác nhận
        'completed'  => [],
        'canceled'   => [],
      ];

      ?>
      <form method="POST" action="?url=order/updateStatus/<?= $order['id'] ?>" class="d-inline-block">
        <div class="input-group">
          <?php if (!empty($adminTransitions[$status])) : ?>
            <select name="status" class="form-select" required>
              <?php foreach ($adminTransitions[$status] as $nextStatus) : ?>
                <option value="<?= $nextStatus ?>"><?= $statusLabels[$nextStatus] ?></option>
              <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-success">Cập nhật</button>
          <?php else : ?>
            <div class="form-control-plaintext text-start ps-2">
              <?php if ($status === 'completed') : ?>
                <span class="text-success">✅ Đơn hàng đã hoàn tất.</span>
              <?php elseif ($status === 'canceled') : ?>
                <span class="text-danger">❌ Đơn hàng đã bị huỷ.</span>
              <?php else : ?>
                <span class="text-muted">Không thể cập nhật tiếp từ trạng thái hiện tại.</span>
              <?php endif; ?>
            </div>
          <?php endif; ?>
        </div>
      </form>
    </div>
  </form>
  <a href="?url=order/index" class="btn btn-secondary ms-3">⬅️ Quay lại danh sách</a>
</div>