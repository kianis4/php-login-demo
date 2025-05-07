<?php
/* ---------- index.php ---------- */
session_start();

/* Gate‑keep: redirect guests to login */
if (!isset($_SESSION["authenticated"]) || $_SESSION["authenticated"] !== true) {
  header("Location: login.php");
  exit();
}

/* Friendly values */
$username = htmlspecialchars($_SESSION["username"]);
$today    = date("l, F j, Y \\a\\t g:i A");
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>Dashboard</title></head>
<body>
<h1>Welcome, <?php echo $username; ?>!</h1>
<p>Today is <?php echo $today; ?></p>

<p><a href="logout.php">Log out</a></p>
</body>
</html>