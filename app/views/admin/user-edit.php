<h3 class="mb-4 text-center">Cập nhật người dùng</h3>

<<<<<<< Updated upstream
<?php if (!empty($data['errors'])): ?>
  <div class="alert alert-danger">
    <?php foreach ($data['errors'] as $error): ?>
      <div>• <?= htmlspecialchars($error) ?></div>
    <?php endforeach; ?>
  </div>
=======
<?php if (!empty($data['errors'])) : ?>
    <div class="alert alert-danger">
        <?php foreach ($data['errors'] as $error) : ?>
            <div>• <?= htmlspecialchars($error) ?></div>
        <?php endforeach; ?>
    </div>
>>>>>>> Stashed changes
<?php endif; ?>

<form method="POST" action="?url=user/edit/<?= $data['user']['id'] ?>" class="card p-4 shadow-sm">

<<<<<<< Updated upstream
  <div class="mb-3">
    <label class="form-label">Tên đăng nhập</label>
    <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($data['user']['username']) ?>" required>
  </div>

  <div class="mb-3">
    <label class="form-label">Mật khẩu mới</label>
    <input type="password" name="password" class="form-control" placeholder="(Để trống nếu không đổi)">
    <small class="text-muted">Để trống nếu bạn không muốn thay đổi mật khẩu</small>
  </div>


  <div class="mb-3">
    <label class="form-label">Vai trò</label>
    <select name="role" class="form-control">
      <option value="user" <?= $data['user']['role'] === 'user' ? 'selected' : '' ?>>User</option>
      <option value="admin" <?= $data['user']['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
    </select>
  </div>

  <div class="d-flex justify-content-between">
    <button type="submit" class="btn btn-success px-4">💾 Lưu thay đổi</button>
    <a href="?url=user/index" class="btn btn-secondary">⬅️ Quay lại</a>
  </div>
=======
    <div class="mb-3">
        <label class="form-label">Tên đăng nhập</label>
        <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($data['user']['username']) ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Vai trò</label>
        <select name="role" class="form-control">
            <option value="user" <?= $data['user']['role'] === 'user' ? 'selected' : '' ?>>User</option>
            <option value="admin" <?= $data['user']['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
        </select>
        <div class="mb-3">
            <label class="form-label">Mật khẩu mới (nếu đổi)</label>
            <input type="password" name="password" class="form-control" placeholder="Để trống nếu không đổi">
        </div>
    </div>

    <div class="d-flex justify-content-between">
        <button type="submit" class="btn btn-success px-4">💾 Lưu thay đổi</button>
        <a href="?url=user/index" class="btn btn-secondary">⬅️ Quay lại</a>
    </div>
>>>>>>> Stashed changes

</form>