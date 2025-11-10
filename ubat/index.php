<?php include __DIR__ . '/includes/header.php'; ?>

<div class="panel">
  <h2>Welcome to Frankfurter Converter</h2>
  <p class="muted">
    This is a simple currency converter app using the
    <b>Frankfurter API</b>. You can sign up, log in, and test real-time
    currency conversions — all stored locally with JSON, no database required.
  </p>

  <div style="margin-top:16px">
    <a class="btn" href="signup.php">Get started — Sign up</a>
    <a class="btn ghost" href="login.php" style="margin-left:8px">Already have an account?</a>
  </div>
</div>

<div class="panel">
  <h3>How it works</h3>
  <ul class="muted" style="line-height:1.6">
    <li>Create an account using your email (stored in <code>users.json</code>)</li>
    <li>Log in securely — passwords are hashed</li>
    <li>Access the dashboard to convert currencies in real time</li>
    <li>Frankfurter API provides reliable exchange rates</li>
  </ul>
</div>

<div class="panel">
  <h3>Developer Notes</h3>
  <p class="muted">
    To run locally: place these files in a PHP-enabled folder (like <code>htdocs/frankfurter-app</code>) and open:
  </p>
  <pre class="kb">http://localhost/frankfurter-app/index.php</pre>
  <p class="muted">Ensure <b>users.json</b> is writable by PHP (permissions 664 or 666).</p>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
