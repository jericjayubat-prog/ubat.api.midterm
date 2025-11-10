<?php
require_once __DIR__ . '/includes/config.php';
require_login();
$user = current_user();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'convert') {
    if (!check_csrf($_POST['csrf'] ?? '')) {
        flash('error', 'Invalid form token.');
        header('Location: dashboard.php');
        exit;
    }

    $from = strtoupper(trim($_POST['from_currency'] ?? 'USD'));
    $to = strtoupper(trim($_POST['to_currency'] ?? 'EUR'));
    $amount = floatval($_POST['amount'] ?? 1);

    if (!preg_match('/^[A-Z]{3}$/', $from) || !preg_match('/^[A-Z]{3}$/', $to)) {
        flash('error', 'Invalid currency code.');
        header('Location: dashboard.php');
        exit;
    }

    $url = "https://api.frankfurter.app/latest?amount={$amount}&from={$from}&to={$to}";
    $context = stream_context_create(["http" => ["timeout" => 5]]);
    $result = @file_get_contents($url, false, $context);
    if ($result === false) {
        flash('error', 'Failed to fetch conversion.');
        header('Location: dashboard.php');
        exit;
    }

    $data = json_decode($result, true);
    $_SESSION['last_conversion'] = $data;

    // ✅ Count this conversion globally
    increment_conversions();

    header('Location: dashboard.php');
    exit;
}

$last = $_SESSION['last_conversion'] ?? null;
$stats = get_stats();

include __DIR__ . '/includes/header.php';
?>

<div class="panel">
  <h2>Dashboard</h2>
  <p class="muted">Welcome, <?= htmlspecialchars($user['name']) ?>. Use the converter below.</p>

  <form method="post">
    <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
    <input type="hidden" name="action" value="convert">
    <div class="row" style="margin-bottom:10px">
      <div class="col">
        <label>Amount <input name="amount" type="number" step="any" value="1"></label>
      </div>
      <div style="width:120px">
        <label>From <input name="from_currency" value="USD"></label>
      </div>
      <div style="width:120px">
        <label>To <input name="to_currency" value="EUR"></label>
      </div>
    </div>
    <button class="btn" type="submit">Convert</button>
  </form>

  <?php if ($last && isset($last['rates'])):
      $from = htmlspecialchars($last['base']);
      $to = htmlspecialchars(array_key_first($last['rates']));
      $rate = round($last['rates'][$to] / $last['amount'], 4);
      $converted = round($last['rates'][$to], 2);
      $amount = htmlspecialchars($last['amount']);
  ?>
    <div style="margin-top:14px" class="panel">
      <strong>Result:</strong>
      <p style="font-size:18px;margin-top:6px;">
        <?= $amount ?> <?= $from ?> = <b><?= $converted ?></b> <?= $to ?>
      </p>
      <p class="muted small">Rate: 1 <?= $from ?> = <?= $rate ?> <?= $to ?></p>
      <p class="muted small">Date: <?= htmlspecialchars($last['date']) ?></p>
    </div>
  <?php endif; ?>
</div>

<div class="row" style="gap:12px;margin-top:14px;flex-wrap:wrap">

  <!-- Last Conversion Card -->
  <div class="col" style="background:linear-gradient(135deg,#06b6d4,#10b981);padding:16px;border-radius:14px;color:#fff;flex:1;min-width:200px;">
    <h4 style="margin:0 0 6px 0;font-size:14px;font-weight:500">Last Conversion</h4>
    <?php if (!empty($last) && isset($last['rates']) && is_array($last['rates'])): ?>
      <?php 
        $from = htmlspecialchars($last['base'] ?? '');
        $to = htmlspecialchars(array_key_first($last['rates']));
        $rate = 0;
        if (!empty($last['amount']) && !empty($last['rates'][$to])) {
            $rate = round($last['rates'][$to] / $last['amount'], 4);
        }
        $converted = round($last['rates'][$to] ?? 0, 2);
        $amount = htmlspecialchars($last['amount'] ?? 1);
        $date = htmlspecialchars($last['date'] ?? '');
      ?>
      <div style="font-size:20px;font-weight:700"><?= $amount ?> <?= $from ?> → <?= $converted ?> <?= $to ?></div>
      <div style="font-size:12px;opacity:0.8">Rate: 1 <?= $from ?> = <?= $rate ?> <?= $to ?></div>
      <div style="font-size:12px;opacity:0.8">Date: <?= $date ?></div>
    <?php else: ?>
      <div style="font-size:14px;opacity:0.8">No conversions yet</div>
    <?php endif; ?>
  </div>

  <!-- Total Conversions Card -->
  <div class="col" style="background:linear-gradient(135deg,#facc15,#f97316);padding:16px;border-radius:14px;color:#fff;flex:1;min-width:200px;text-align:center;">
    <h4 style="margin:0 0 6px 0;font-size:14px;font-weight:500">Conversions</h4>
    <div style="font-size:24px;font-weight:700"><?= number_format($stats['total_conversions']) ?></div>
    <div style="font-size:12px;opacity:0.8">Total Conversions</div>
  </div> 
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
