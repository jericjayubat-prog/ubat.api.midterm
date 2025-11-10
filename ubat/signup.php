<?php
require_once __DIR__ . '/includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'signup') {
    if (!check_csrf($_POST['csrf'] ?? '')) {
        flash('error', 'Invalid form token.');
        header('Location: signup.php'); exit;
    }
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $name = trim($_POST['name'] ?? '');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        flash('error', 'Please provide a valid email.');
        header('Location: signup.php'); exit;
    }
    if (strlen($password) < 6) {
        flash('error', 'Password must be at least 6 characters.');
        header('Location: signup.php'); exit;
    }

    $users = load_users();
    if (isset($users[$email])) {
        flash('error', 'Email already registered.');
        header('Location: signup.php'); exit;
    }

    $users[$email] = [
        'name' => $name ?: explode('@', $email)[0],
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'created_at' => date('c')
    ];
    save_users($users);

    $_SESSION['user'] = $email;
    flash('success', 'Account created successfully!');
    header('Location: dashboard.php'); exit;
}

include __DIR__ . '/includes/header.php';
?>

<div class="panel">
  <h2>Create account</h2>
  <form method="post">
    <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
    <input type="hidden" name="action" value="signup">
    <label>Name <input name="name" placeholder="Your name (optional)"></label>
    <label>Email <input name="email" type="email" required placeholder="you@example.com"></label>
    <label>Password <input name="password" type="password" required placeholder="Minimum 6 characters"></label>
    <div style="margin-top:10px"><button class="btn" type="submit">Create account</button></div>
  </form>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
