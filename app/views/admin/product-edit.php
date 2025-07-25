<?php $title = 'Chỉnh sửa sản phẩm'; ?>

<h3 class="mb-4 text-center">Chỉnh sửa sản phẩm</h3>

<?php if (!empty($data['errors'])) : ?>
    <div class="alert alert-danger">
        <?php foreach ($data['errors'] as $error) : ?>
            <div>• <?= $error ?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
    <div class="mb-3">
        <label for="name" class="form-label">Tên sản phẩm</label>
        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($data['product']['name']) ?>" required>
    </div>

    <div class="mb-3">
        <label for="price" class="form-label">Giá (VND)</label>
        <input type="number" name="price" class="form-control" value="<?= $data['product']['price'] ?>" min="0" required>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Mô tả</label>
        <textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($data['product']['description'] ?? '') ?></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Ảnh hiện tại</label><br>
        <?php if (!empty($data['product']['image'])) : ?>
            <img src="/DA1/code/public/assets/images/<?= htmlspecialchars($data['product']['image']) ?>" class="img-preview mb-2" alt="Ảnh hiện tại">
        <?php else : ?>
            <p class="text-muted">Chưa có ảnh</p>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">Chọn ảnh mới (nếu muốn đổi)</label>
        <input type="file" name="image" id="image" class="form-control">
    </div>

    <div class="d-flex justify-content-between mt-4">
        <button type="submit" class="btn btn-success px-4">💾 Lưu thay đổi</button>
        <a href="?url=product/index" class="btn btn-secondary">⬅️ Quay lại</a>
    </div>
</form>