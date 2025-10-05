
<?php
require_once __DIR__.'/../db.php';

function find_user_by_email($email) {
    $stmt = db()->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
    $stmt->execute([$email]);
    return $stmt->fetch();
}

function create_user($name, $email, $password, $is_admin = 0) {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = db()->prepare('INSERT INTO users (name, email, password_hash, is_admin, created_at) VALUES (?, ?, ?, ?, NOW())');
    $stmt->execute([$name, $email, $hash, $is_admin]);
    return db()->lastInsertId();
}

function login($email, $password) {
    $u = find_user_by_email($email);
    if ($u && password_verify($password, $u['password_hash'])) {
        $_SESSION['user'] = $u;
        return true;
    }
    return false;
}

function logout() {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params['path'], $params['domain'],
            $params['secure'], $params['httponly']
        );
    }
    session_destroy();
}
