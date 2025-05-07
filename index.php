<?php
session_start();
require_once 'config.php';

/* Redirect guests */
if (empty($_SESSION['authenticated'])) {
  header('Location: login.php');
  exit;
}

$username = htmlspecialchars($_SESSION['username']);
$today    = date('l, F j, Y \a\t g:i A');
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>Dashboard</title></head>
<body>
<h1>Welcome, <?= $username ?>!</h1>
<p>Today is <?= $today ?></p>

<p><a href="logout.php">Log out</a></p>
</body>
</html>