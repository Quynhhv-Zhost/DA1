<?php $title = 'Danh sách người dùng'; ?>

<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-primary mb-0">📋 Danh sách người dùng</h2>
    <a href="?url=user/add" class="btn btn-success">+ Thêm người dùng</a>
  </div>

  <?php
  $admins = array_filter($users, fn($u) => $u['role'] === 'admin');
  $clients = array_filter($users, fn($u) => $u['role'] === 'user');
  ?>

  <!-- BẢNG QUẢN TRỊ VIÊN -->
  <h4 class="text-danger mt-4">👑 Quản trị viên</h4>
  <div class="card shadow-sm mb-5">
    <div class="card-body p-0">
      <table class="table table-hover table-bordered align-middle mb-0">
        <thead class="table-light">
          <tr class="text-center">
            <th style="width: 5%;">ID</th>
            <th style="width: 30%;">👤 Username</th>
            <th style="width: 20%;">👤 Password</th>
            <th style="width: 20%;">🔐 Vai trò</th>
            <th style="width: 25%;">⚙️ Hành động</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($admins)) : ?>
            <?php foreach ($admins as $user) : ?>
              <tr class="text-center">
                <td><?= $user['id'] ?></td>
                <td class="text-start"><?= htmlspecialchars($user['username']) ?></td>
                <td class="text-start"><?= htmlspecialchars($user['password']) ?></td>
                <td><span class="badge bg-danger">Admin</span></td>
                <td>
                  <a href="?url=user/edit/<?= $user['id'] ?>" class="btn btn-sm btn-warning me-1">✏️ Sửa</a>
                  <a href="?url=user/delete/<?= $user['id'] ?>" class="btn btn-sm btn-danger"
                    onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?')">🗑️ Xóa</a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else : ?>
            <tr>
              <td colspan="4" class="text-center text-muted">Không có quản trị viên nào.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- BẢNG NGƯỜI DÙNG -->
  <h4 class="text-primary mt-4">👥 Người dùng</h4>
  <div class="card shadow-sm mb-5">
    <div class="card-body p-0">
      <table class="table table-hover table-bordered align-middle mb-0">
        <thead class="table-light">
          <tr class="text-center">
            <th style="width: 5%;">ID</th>
            <th style="width: 30%;">👤 Username</th>
            <th style="width: 20%;">👤 Password</th>
            <th style="width: 20%;">🔐 Vai trò</th>
            <th style="width: 25%;">⚙️ Hành động</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($clients)) : ?>
            <?php foreach ($clients as $user) : ?>
              <tr class="text-center">
                <td><?= $user['id'] ?></td>
                <td class="text-start"><?= htmlspecialchars($user['username']) ?></td>
                <td class="text-start"><?= htmlspecialchars($user['password']) ?></td>
                <td><span class="badge bg-secondary">User</span></td>
                <td>
                  <a href="?url=user/edit/<?= $user['id'] ?>" class="btn btn-sm btn-warning me-1">✏️ Sửa</a>
                  <a href="?url=user/delete/<?= $user['id'] ?>" class="btn btn-sm btn-danger"
                    onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này?')">🗑️ Xóa</a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else : ?>
            <tr>
              <td colspan="4" class="text-center text-muted">Không có người dùng nào.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>