<h3 class="mb-4">Danh sách sản phẩm</h3>
<a href="?url=product/add" class="btn btn-success mb-3">+ Thêm sản phẩm</a>

<table class="table table-bordered table-hover align-middle">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Ảnh</th>
            <th>Tên</th>
            <th>Giá</th>
            <th>Mô tả</th>
            <th style="width: 160px;">Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $products = $data['products'] ?? [];
        usort($products, function ($a, $b) {
            return $a['id'] - $b['id'];
        });
        foreach ($products as $product) :
        ?>
            <tr>
                <td><?= $product['id'] ?></td>
                <td>
                    <?php if (!empty($product['image'])) : ?>
                        <img src="/DA1/public/assets/images/<?= $product['image'] ?>" alt="Ảnh" width="80" height="60" style="object-fit: cover;">
                    <?php else : ?>
                        <span class="text-muted">Không ảnh</span>
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($product['name']) ?></td>
                <td><?= number_format($product['price'], 0, ',', '.') ?> VND</td>
                <td><?= htmlspecialchars($product['description'] ?? '-') ?></td>
                <td>
                    <a href="?url=product/edit/<?= $product['id'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                    <a href="?url=product/delete/<?= $product['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xoá?')">Xoá</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>