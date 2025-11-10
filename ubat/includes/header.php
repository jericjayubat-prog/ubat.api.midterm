<?php
require_once __DIR__ . '/config.php';
$user = current_user();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Frankfurter Converter</title>
  <style>
    :root{--bg:#0f1724;--card:#0b1220;--muted:#9aa6b2;--accent:#6ee7b7}
    *{box-sizing:border-box}
    body{margin:0;font-family:Inter,system-ui,-apple-system,'Segoe UI',Roboto,Helvetica,Arial;
      color:#E6EEF3;background:linear-gradient(180deg,#081026 0%, #071227 100%);
      min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px}
    .container{width:100%;max-width:980px}
    .card{background:linear-gradient(180deg,rgba(255,255,255,0.02),rgba(255,255,255,0.01));
      padding:24px;border-radius:14px;box-shadow:0 6px 20px rgba(2,6,23,0.6);}
    header{display:flex;align-items:center;justify-content:space-between;margin-bottom:18px}
    h1{margin:0;font-size:20px}
    .muted{color:var(--muted);font-size:13px}
    .btn{display:inline-block;padding:10px 14px;border-radius:10px;border:0;
      background:linear-gradient(90deg,#10b981,#06b6d4);color:#04201a;font-weight:700;cursor:pointer;text-decoration:none}
    .ghost{background:transparent;border:1px solid rgba(255,255,255,0.06);color:var(--muted)}
    .nav{display:flex;gap:10px;align-items:center}
    .small{font-size:13px}
    .panel{background:rgba(255,255,255,0.02);padding:14px;border-radius:10px;margin-bottom:12px}
    .toast{padding:10px 12px;border-radius:8px;margin-bottom:10px}
    .success{background:linear-gradient(90deg,rgba(110,231,183,0.12),rgba(6,182,212,0.08));border:1px solid rgba(110,231,183,0.12)}
    .error{background:linear-gradient(90deg,rgba(255,99,99,0.06),rgba(255,99,99,0.04));border:1px solid rgba(255,99,99,0.08)}
    .logo{display:flex;gap:10px;align-items:center}
    .logo .dot{width:36px;height:36px;border-radius:9px;background:linear-gradient(180deg,#06b6d4,#10b981);
      display:flex;align-items:center;justify-content:center;color:#04201a;font-weight:800}
    input{width:100%;padding:10px 12px;border-radius:8px;border:1px solid rgba(255,255,255,0.04);
      background:transparent;color:inherit}
    label{display:block;font-size:13px;margin-bottom:6px;color:var(--muted)}
    footer{text-align:center;margin-top:20px;color:var(--muted);font-size:13px}
    .row{display:flex;gap:16px}
    .col{flex:1}
    .kb{font-family:monospace;font-size:13px;color:#cfece9}
    @media(max-width:900px){body{padding:16px}}
  </style>
</head>
<body>
  <div class="container">
  <div class="card">
    <header>
      <div class="logo">
        <div class="dot">F</div>
        <div>
          <h1>Frankfurter Converter</h1>
          <div class="muted">Currency converter demo.</div>
        </div>
      </div>
      <nav class="nav">
        <?php if ($user): ?>
          <div class="small muted">Hello, <?= htmlspecialchars($user['name']) ?></div>
          <a class="btn ghost small" href="logout.php">Logout</a>
        <?php else: ?>
          <a class="btn ghost small" href="login.php">Login</a>
          <a class="btn small" href="signup.php">Sign up</a>
        <?php endif; ?>
      </nav>
    </header>

    <?php if ($m = flash('success')): ?>
      <div class="toast success"><?= htmlspecialchars($m) ?></div>
    <?php endif; ?>
    <?php if ($m = flash('error')): ?>
      <div class="toast error"><?= htmlspecialchars($m) ?></div>
    <?php endif; ?>
