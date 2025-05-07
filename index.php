<?php
session_start();
require_once 'config.php';

/* ---------- protected‑page guard + flash ---------- */
if (empty($_SESSION['authenticated'])) {
  // one‑time notice for the next request
  $_SESSION['flash'] = '🚫  This page is protected — please log in first.';
  header('Location: login.php');
  exit;
}

/* ---------- dashboard ---------- */
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