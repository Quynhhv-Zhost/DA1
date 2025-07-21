<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">Quản lý sản phẩm</h2>
    <a href="?url=product/add" class="btn btn-primary">+ Thêm sản phẩm</a>
</div>
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>#ID</th>
            <th>Ảnh</th>
            <th>Tên</th>
            <th>Giá</th>
            <th>Mô tả</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $sp) : ?>
            <tr>
                <td><?= $sp['id'] ?></td>
                <td>
                    <?php if ($sp['image']) : ?>
                        <img src="/DA1/code/public/assets/images/<?= $sp['image'] ?>" width="60" class="rounded">
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($sp['name']) ?></td>
                <td><?= number_format($sp['price'], 0, ',', '.') ?> VND</td>
                <td><?= htmlspecialchars($sp['description']) ?></td>
                <td>
                    <a href="?url=product/edit/<?= $sp['id'] ?>" class="btn btn-sm btn-warning">Sửa</a>
                    <a href="?url=product/delete/<?= $sp['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Xác nhận xóa?')">Xóa</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>