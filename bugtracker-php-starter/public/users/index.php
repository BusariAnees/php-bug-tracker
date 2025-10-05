
<?php
require_once __DIR__.'/../../includes/helpers.php';
require_once __DIR__.'/../../db.php';
auth_required();
if (!is_admin()) { flash('error', 'Admin only'); redirect('/'); }

$users = db()->query('SELECT id, name, email, is_admin, created_at FROM users ORDER BY created_at DESC')->fetchAll();

include __DIR__.'/../../includes/header.php';
?>
<h1 class="h4 mb-3">Users</h1>
<div class="table-responsive">
<table class="table table-striped align-middle">
  <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Joined</th></tr></thead>
  <tbody>
    <?php foreach ($users as $u): ?>
      <tr>
        <td><?= $u['id'] ?></td>
        <td><?= h($u['name']) ?></td>
        <td><?= h($u['email']) ?></td>
        <td><?= $u['is_admin'] ? 'Admin' : 'User' ?></td>
        <td><?= h($u['created_at']) ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
</div>
<?php include __DIR__.'/../../includes/footer.php'; ?>
