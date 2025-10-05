
<?php
require_once __DIR__.'/../../includes/helpers.php';
require_once __DIR__.'/../../db.php';
auth_required();

$id = (int)($_GET['id'] ?? 0);
$stmt = db()->prepare('SELECT created_by FROM tickets WHERE id=?');
$stmt->execute([$id]);
$row = $stmt->fetch();
if (!$row) { flash('error', 'Ticket not found'); redirect('/'); }

$can_delete = is_admin() || (isset($_SESSION['user']['id']) && $_SESSION['user']['id'] == $row['created_by']);
if (!$can_delete) { flash('error', 'Not authorized'); redirect('/'); }

$stmt = db()->prepare('DELETE FROM tickets WHERE id=?');
$stmt->execute([$id]);
flash('success', 'Ticket deleted');
redirect('/');
