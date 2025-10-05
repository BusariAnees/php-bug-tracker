
<?php
require_once __DIR__.'/../includes/helpers.php';
require_once __DIR__.'/../includes/auth.php';
logout();
flash('success', 'Logged out.');
redirect('/login.php');
