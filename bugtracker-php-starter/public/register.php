
<?php
require_once __DIR__.'/../includes/helpers.php';
require_once __DIR__.'/../includes/auth.php';

if (is_post()) {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    if (!$name || !$email || !$password) {
        flash('error', 'All fields are required.');
    } elseif (find_user_by_email($email)) {
        flash('error', 'Email already registered.');
    } else {
        create_user($name, $email, $password, 0);
        flash('success', 'Account created. Please login.');
        redirect('/login.php');
    }
}
include __DIR__.'/../includes/header.php';
?>
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card shadow-sm card-hover">
      <div class="card-body">
        <h1 class="h4 mb-3">Create account</h1>
        <form method="post">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Name</label>
              <input type="text" name="name" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" required>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required minlength="6">
          </div>
          <button class="btn btn-success w-100">Register</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__.'/../includes/footer.php'; ?>
