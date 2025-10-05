
<?php
require_once __DIR__.'/../includes/helpers.php';
require_once __DIR__.'/../db.php';
auth_required();

$severity = $_GET['severity'] ?? '';
$status = $_GET['status'] ?? '';
$params = [];
$where = [];

if ($severity !== '') { $where[] = 't.severity = ?'; $params[] = $severity; }
if ($status !== '') { $where[] = 't.status = ?'; $params[] = $status; }

$sql = "SELECT t.*, u1.name AS creator_name, u2.name AS assignee_name
        FROM tickets t
        LEFT JOIN users u1 ON u1.id = t.created_by
        LEFT JOIN users u2 ON u2.id = t.assigned_to";
if ($where) $sql .= ' WHERE '.implode(' AND ', $where);
$sql .= ' ORDER BY t.updated_at DESC';

$stmt = db()->prepare($sql);
$stmt->execute($params);
$tickets = $stmt->fetchAll();

include __DIR__.'/../includes/header.php';
?>
<div class="d-flex align-items-center justify-content-between mb-3">
  <h1 class="h4 mb-0">Dashboard</h1>
  <a href="/tickets/create.php" class="btn btn-primary">+ New Ticket</a>
</div>

<form class="row g-2 mb-3">
  <div class="col-md-3">
    <label class="form-label">Severity</label>
    <select class="form-select" name="severity">
      <option value="">All</option>
      <?php foreach (['low','medium','high','critical'] as $s): ?>
        <option value="<?= $s ?>" <?= $severity===$s?'selected':'' ?>><?= ucfirst($s) ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="col-md-3">
    <label class="form-label">Status</label>
    <select class="form-select" name="status">
      <option value="">All</option>
      <?php foreach (['open','in_progress','resolved','closed'] as $s): ?>
        <option value="<?= $s ?>" <?= $status===$s?'selected':'' ?>><?= str_replace('_',' ', ucfirst($s)) ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="col-md-3 d-flex align-items-end">
    <button class="btn btn-outline-secondary me-2">Filter</button>
    <a href="/" class="btn btn-link">Reset</a>
  </div>
</form>

<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
<?php foreach ($tickets as $t): ?>
  <div class="col">
    <div class="card shadow-sm card-hover h-100">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
          <h2 class="h6 card-title mb-1">
            <a href="/tickets/show.php?id=<?= $t['id'] ?>" class="text-decoration-none"><?= h($t['title']) ?></a>
          </h2>
          <span class="badge text-bg-<?= $t['severity']==='critical'?'danger':($t['severity']==='high'?'warning':($t['severity']==='medium'?'info':'secondary')) ?> filter-badge">
            <?= ucfirst($t['severity']) ?>
          </span>
        </div>
        <p class="text-muted small mb-2"><?= nl2br(h(substr($t['description'],0,120))) ?><?= strlen($t['description'])>120?'...':'' ?></p>
        <div class="d-flex gap-2 align-items-center small text-muted">
          <span class="badge text-bg-light"><?= str_replace('_',' ', ucfirst($t['status'])) ?></span>
          <span>•</span>
          <span>By <?= h($t['creator_name'] ?: 'Unknown') ?></span>
          <?php if ($t['assignee_name']): ?>
            <span>•</span><span>Assigned: <?= h($t['assignee_name']) ?></span>
          <?php endif; ?>
        </div>
      </div>
      <div class="card-footer small text-muted">
        Updated: <?= h($t['updated_at']) ?>
      </div>
    </div>
  </div>
<?php endforeach; ?>
<?php if (!$tickets): ?>
  <div class="col"><div class="alert alert-info">No tickets found. Try different filters or create one.</div></div>
<?php endif; ?>
</div>

<?php include __DIR__.'/../includes/footer.php'; ?>
