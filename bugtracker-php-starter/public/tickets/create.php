
<?php
require_once __DIR__.'/../../includes/helpers.php';
require_once __DIR__.'/../../db.php';
auth_required();

if (is_post()) {
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $severity = $_POST['severity'] ?? 'low';
    if (!$title) {
        flash('error', 'Title is required');
    } else {
        $stmt = db()->prepare('INSERT INTO tickets (title, description, severity, status, created_by, created_at, updated_at) VALUES (?, ?, ?, "open", ?, NOW(), NOW())');
        $stmt->execute([$title, $description, $severity, $_SESSION['user']['id']]);
        flash('success', 'Ticket created');
        redirect('/');
    }
}
include __DIR__.'/../../includes/header.php';
?>
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="card shadow-sm">
      <div class="card-body">
        <h1 class="h5 mb-3">Create Ticket</h1>
        <form method="post">
          <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" rows="6" class="form-control" placeholder="Steps to reproduce, expected vs actual..."></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Severity</label>
            <select name="severity" class="form-select">
              <?php foreach (['low','medium','high','critical'] as $s): ?>
                <option value="<?= $s ?>"><?= ucfirst($s) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <button class="btn btn-primary">Create</button>
          <a href="/" class="btn btn-link">Cancel</a>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__.'/../../includes/footer.php'; ?>
