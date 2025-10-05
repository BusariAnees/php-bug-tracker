
<?php
require_once __DIR__.'/../../includes/helpers.php';
require_once __DIR__.'/../../db.php';
auth_required();

$id = (int)($_GET['id'] ?? 0);
$stmt = db()->prepare('SELECT * FROM tickets WHERE id=?');
$stmt->execute([$id]);
$t = $stmt->fetch();
if (!$t) { flash('error', 'Ticket not found'); redirect('/'); }

$can_edit = is_admin() || (isset($_SESSION['user']['id']) && $_SESSION['user']['id'] == $t['created_by']);
if (!$can_edit) { flash('error', 'Not authorized'); redirect('/'); }

if (is_post()) {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $severity = $_POST['severity'] ?? 'low';
    if (!$title) {
        flash('error', 'Title is required');
    } else {
        $stmt = db()->prepare('UPDATE tickets SET title=?, description=?, severity=?, updated_at=NOW() WHERE id=?');
        $stmt->execute([$title, $description, $severity, $id]);
        flash('success', 'Ticket updated');
        redirect('/tickets/show.php?id='.$id);
    }
}

include __DIR__.'/../../includes/header.php';
?>
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="card shadow-sm">
      <div class="card-body">
        <h1 class="h5 mb-3">Edit Ticket</h1>
        <form method="post">
          <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" value="<?= h($t['title']) ?>" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" rows="6" class="form-control"><?= h($t['description']) ?></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Severity</label>
            <select name="severity" class="form-select">
              <?php foreach (['low','medium','high','critical'] as $s): ?>
                <option value="<?= $s ?>" <?= $t['severity']===$s?'selected':'' ?>><?= ucfirst($s) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <button class="btn btn-primary">Save</button>
          <a href="/tickets/show.php?id=<?= $t['id'] ?>" class="btn btn-link">Cancel</a>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__.'/../../includes/footer.php'; ?>
