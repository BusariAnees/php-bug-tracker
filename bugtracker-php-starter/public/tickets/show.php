
<?php
require_once __DIR__.'/../../includes/helpers.php';
require_once __DIR__.'/../../db.php';
auth_required();

$id = (int)($_GET['id'] ?? 0);
$stmt = db()->prepare('SELECT t.*, u1.name AS creator_name, u2.name AS assignee_name FROM tickets t LEFT JOIN users u1 ON u1.id=t.created_by LEFT JOIN users u2 ON u2.id=t.assigned_to WHERE t.id=?');
$stmt->execute([$id]);
$t = $stmt->fetch();
if (!$t) { flash('error', 'Ticket not found'); redirect('/'); }

// Admin: handle assign & status changes
if (is_admin() && is_post()) {
    if (isset($_POST['assign_to'])) {
        $assign_to = $_POST['assign_to'] ? (int)$_POST['assign_to'] : null;
        $stmt = db()->prepare('UPDATE tickets SET assigned_to = ?, updated_at = NOW() WHERE id = ?');
        $stmt->execute([$assign_to, $id]);
        flash('success', 'Assignee updated');
        redirect('/tickets/show.php?id='.$id);
    }
    if (isset($_POST['status'])) {
        $status = $_POST['status'];
        $stmt = db()->prepare('UPDATE tickets SET status = ?, updated_at = NOW() WHERE id = ?');
        $stmt->execute([$status, $id]);
        flash('success', 'Status updated');
        redirect('/tickets/show.php?id='.$id);
    }
}

$users = [];
if (is_admin()) {
    $users = db()->query('SELECT id, name FROM users ORDER BY name')->fetchAll();
}

include __DIR__.'/../../includes/header.php';
?>
<div class="row">
  <div class="col-lg-8">
    <div class="card shadow-sm mb-3">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <h1 class="h5 mb-0"><?= h($t['title']) ?></h1>
          <span class="badge text-bg-<?= $t['severity']==='critical'?'danger':($t['severity']==='high'?'warning':($t['severity']==='medium'?'info':'secondary')) ?>"><?= ucfirst($t['severity']) ?></span>
        </div>
        <p class="text-muted small mb-2">Created by <?= h($t['creator_name']) ?> • <?= h($t['created_at']) ?></p>
        <p><?= nl2br(h($t['description'])) ?></p>
      </div>
      <div class="card-footer d-flex gap-2 align-items-center">
        <span class="badge text-bg-light">Status: <?= str_replace('_',' ', ucfirst($t['status'])) ?></span>
        <?php if ($t['assignee_name']): ?>
          <span class="ms-2">Assignee: <strong><?= h($t['assignee_name']) ?></strong></span>
        <?php endif; ?>
      </div>
    </div>

    <a href="/tickets/edit.php?id=<?= $t['id'] ?>" class="btn btn-outline-secondary">Edit</a>
    <a href="/tickets/delete.php?id=<?= $t['id'] ?>" class="btn btn-outline-danger" onclick="return confirm('Delete this ticket?')">Delete</a>
    <a href="/" class="btn btn-link">Back</a>
  </div>

  <?php if (is_admin()): ?>
  <div class="col-lg-4">
    <div class="card shadow-sm">
      <div class="card-body">
        <h2 class="h6">Admin Controls</h2>
        <form method="post" class="mb-3">
          <label class="form-label">Assign to</label>
          <select class="form-select" name="assign_to" onchange="this.form.submit()">
            <option value="">Unassigned</option>
            <?php foreach ($users as $u): ?>
              <option value="<?= $u['id'] ?>" <?= $t['assigned_to']==$u['id']?'selected':'' ?>><?= h($u['name']) ?></option>
            <?php endforeach; ?>
          </select>
        </form>

        <form method="post" class="d-flex gap-2">
          <?php foreach (['open','in_progress','resolved','closed'] as $s): ?>
            <button name="status" value="<?= $s ?>" class="btn btn-sm btn-outline-primary <?= $t['status']===$s?'active':'' ?>"><?= str_replace('_',' ', ucfirst($s)) ?></button>
          <?php endforeach; ?>
        </form>
      </div>
    </div>
  </div>
  <?php endif; ?>
</div>
<?php include __DIR__.'/../../includes/footer.php'; ?>
