<?php
require_once __DIR__ . '/includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'login') {
    if (!check_csrf($_POST['csrf'] ?? '')) {
        flash('error', 'Invalid form token.');
        header('Location: login.php'); exit;
    }
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $users = load_users();
    if (!isset($users[$email]) || !password_verify($password, $users[$email]['password'])) {
        flash('error', 'Invalid credentials.');
        header('Location: login.php'); exit;
    }

    $_SESSION['user'] = $email;
    flash('success', 'Logged in successfully.');
    header('Location: dashboard.php'); exit;
}

include __DIR__ . '/includes/header.php';
?>

<div class="panel">
  <h2>Sign in</h2>
  <form method="post">
    <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
    <input type="hidden" name="action" value="login">
    <label>Email <input name="email" type="email" required></label>
    <label>Password <input name="password" type="password" required></label>
    <div style="margin-top:10px"><button class="btn" type="submit">Sign in</button></div>
  </form>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
