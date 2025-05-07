<?php
session_start();
require_once 'config.php';

/* Bounce authenticated users straight to the dashboard */
if (!empty($_SESSION['authenticated'])) {
  header('Location: index.php');
  exit;
}

/* Handle lockout window */
$now = time();
if (isset($_SESSION['lockout_until']) && $now < $_SESSION['lockout_until']) {
  $remaining = $_SESSION['lockout_until'] - $now;
  $error = "Too many failed attempts. Try again in {$remaining} s.";
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Normal login flow
  $u = trim($_POST['username'] ?? '');
  $p = $_POST['password'] ?? '';

  $_SESSION['failed'] = $_SESSION['failed'] ?? 0;

  if ($u === VALID_USERNAME && $p === VALID_PASSWORD) {
    /* --- success --- */
    session_regenerate_id(true);        // anti‑fixation
    $_SESSION['authenticated'] = true;
    $_SESSION['username']      = $u;
    unset($_SESSION['failed'], $_SESSION['lockout_until']);
    header('Location: index.php');
    exit;
  } else {
    /* --- failure --- */
    $_SESSION['failed']++;
    if ($_SESSION['failed'] >= MAX_FAILED) {
      $_SESSION['lockout_until'] = $now + LOCKOUT_SECONDS;
      $error = "Too many failed attempts. Locked for " . LOCKOUT_SECONDS . " s.";
    } else {
      $tries = MAX_FAILED - $_SESSION['failed'];
      $error = "Invalid credentials. {$tries} attempt(s) left.";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>Login</title></head>
<body>
<h2>Login</h2>

<form method="post">
  <label>Username
    <input type="text" name="username" required autocomplete="username">
  </label><br><br>
  <label>Password
    <input type="password" name="password" required autocomplete="current-password">
  </label><br><br>
  <button type="submit">Submit</button>
</form>

<?php if (!empty($error)): ?>
  <p style="color:red"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

</body>
</html>