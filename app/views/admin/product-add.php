<?php $title = 'Thêm sản phẩm mới'; ?>

<h3 class="mb-4 text-center">Thêm sản phẩm mới</h3>
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
        <input type="text" name="name" class="form-control" placeholder="Nhập tên sản phẩm" required>
    </div>
    <div class="mb-3">
        <label for="price" class="form-label">Giá (VND)</label>
        <input type="number" name="price" class="form-control" placeholder="Nhập giá sản phẩm" min="0" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Mô tả</label>
        <textarea name="description" class="form-control" rows="4" placeholder="Thêm mô tả cho sản phẩm (tùy chọn)"></textarea>
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">Ảnh (jpeg, jpg, png)</label>
        <input type="file" name="image" class="form-control" id="imgInp">
        <!-- <img id="imgPreview" src="#" class="img-preview d-none" alt="Preview" /> -->
    </div>
    <div class="d-flex justify-content-between mt-4">
        <button type="submit" class="btn btn-success px-4">+ Thêm sản phẩm</button>
        <a href="?url=product/index" class="btn btn-secondary">⬅️ Quay lại</a>
    </div>
</form>