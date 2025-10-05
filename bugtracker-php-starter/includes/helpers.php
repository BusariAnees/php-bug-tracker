
<?php
function h($v) { return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'); }
function redirect($path) { header('Location: '.$path); exit; }

function flash($key, $msg = null) {
    if ($msg !== null) {
        $_SESSION['flash'][$key] = $msg;
        return;
    }
    if (isset($_SESSION['flash'][$key])) {
        $m = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $m;
    }
    return null;
}

function is_post() { return $_SERVER['REQUEST_METHOD'] === 'POST'; }

function is_admin() { return !empty($_SESSION['user']) && $_SESSION['user']['is_admin'] == 1; }
function auth_required() { if (empty($_SESSION['user'])) redirect('/login.php'); }
