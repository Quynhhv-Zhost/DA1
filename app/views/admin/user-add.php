<?php $title = 'Thêm người dùng'; ?>

<h3 class="mb-4 text-center">Thêm người dùng</h3>

<?php if (!empty($data['errors'])) : ?>
<<<<<<< Updated upstream
  <div class="alert alert-danger">
    <?php foreach ($data['errors'] as $error) : ?>
      <div>• <?= $error ?></div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<form method="post" action="?url=user/add" class="card p-4 shadow-sm">
  <div class="mb-3">
    <label for="username" class="form-label">Tên đăng nhập</label>
    <input type="text" name="username" class="form-control" placeholder="Nhập tên đăng nhập" required>
  </div>

  <div class="mb-3">
    <label for="password" class="form-label">Mật khẩu</label>
    <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu (tối thiểu 6 ký tự)" required>
  </div>

  <div class="mb-3">
    <label for="role" class="form-label">Vai trò</label>
    <select name="role" class="form-select" required>
      <option value="admin">Admin</option>
      <option value="user">User</option>
    </select>
  </div>

  <div class="d-flex justify-content-between mt-4">
    <button type="submit" class="btn btn-success px-4">+ Thêm người dùng</button>
    <a href="?url=user/index" class="btn btn-secondary">⬅️ Quay lại</a>
  </div>
=======
    <div class="alert alert-danger">
        <?php foreach ($data['errors'] as $error) : ?>
            <div>• <?= $error ?></div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="post" action="?url=user/add" class="card p-4 shadow-sm">
    <div class="mb-3">
        <label for="username" class="form-label">Tên đăng nhập</label>
        <input type="text" name="username" class="form-control" placeholder="Nhập tên đăng nhập" required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Mật khẩu</label>
        <input type="password" name="password" class="form-control" placeholder="Nhập mật khẩu (tối thiểu 6 ký tự)" required>
    </div>

    <div class="mb-3">
        <label for="role" class="form-label">Vai trò</label>
        <select name="role" class="form-select" required>
            <option value="admin">Admin</option>
            <option value="user">User</option>
        </select>
    </div>

    <div class="d-flex justify-content-between mt-4">
        <button type="submit" class="btn btn-success px-4">+ Thêm người dùng</button>
        <a href="?url=user/index" class="btn btn-secondary">⬅️ Quay lại</a>
    </div>
>>>>>>> Stashed changes
</form>