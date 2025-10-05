
<?php
require_once __DIR__.'/../includes/helpers.php';
require_once __DIR__.'/../includes/auth.php';

if (is_post()) {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    if (login($email, $password)) {
        flash('success', 'Welcome back!');
        redirect('/');
    } else {
        flash('error', 'Invalid credentials');
    }
}
include __DIR__.'/../includes/header.php';
?>
<div class="row justify-content-center">
  <div class="col-md-5">
    <div class="card shadow-sm card-hover">
      <div class="card-body">
        <h1 class="h4 mb-3">Login</h1>
        <form method="post">
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>
          <button class="btn btn-primary w-100">Login</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__.'/../includes/footer.php'; ?>
