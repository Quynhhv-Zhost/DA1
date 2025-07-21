<?php $title = 'Quản lý đơn hàng'; ?>

<h2 class="mb-4">Danh sách đơn hàng</h2>
<table class="table table-striped table-bordered align-middle shadow-sm">
    <thead class="table-dark">
        <tr>
            <th>#ID</th>
            <th>Khách hàng (user_id)</th>
            <th>Tổng tiền</th>
            <th>Ngày đặt</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orders as $order) : ?>
            <tr>
                <td><?= $order['id'] ?></td>
                <td><?= $order['user_id'] ?></td>
                <td><?= number_format($order['total_price'], 0, ',', '.') ?> VND</td>
                <td><?= htmlspecialchars($order['created_at']) ?></td>
                <td>
                    <?php
                    $badge = 'secondary';
                    if ($order['status'] === 'pending') $badge = 'warning';
                    elseif ($order['status'] === 'completed') $badge = 'success';
                    elseif ($order['status'] === 'canceled') $badge = 'danger';
                    ?>
                    <span class="badge bg-<?= $badge ?>"><?= htmlspecialchars($order['status']) ?></span>
                </td>
                <td>
                    <a href="?url=order/detail/<?= $order['id'] ?>" class="btn btn-primary btn-sm">Xem</a>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if (empty($orders)) : ?>
            <tr>
                <td colspan="6" class="text-center text-muted">Chưa có đơn hàng nào.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>