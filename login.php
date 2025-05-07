<?php
/* ---------- login.php ---------- */
session_start();

/* Hard‑coded demo credentials */
$VALID_USERNAME = "admin";
$VALID_PASSWORD = "secret";

/* If user is already logged in, bounce them away */
if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true) {
  header("Location: index.php");
  exit();
}

/* If form submitted, check credentials */
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $u = $_POST["username"] ?? "";
  $p = $_POST["password"] ?? "";

  /* Initialise fail counter once */
  if (!isset($_SESSION["failed"])) $_SESSION["failed"] = 0;

  if ($u === $VALID_USERNAME && $p === $VALID_PASSWORD) {
    $_SESSION["authenticated"] = true;
    $_SESSION["username"]      = $u;
    header("Location: index.php");
    exit();
  } else {
    $_SESSION["failed"]++;
    $error = "Invalid credentials (attempt #{$_SESSION['failed']})";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>Login</title></head>
<body>
<h2>Login</h2>
<form method="post">
  <label>Username <input type="text" name="username" required></label><br><br>
  <label>Password <input type="password" name="password" required></label><br><br>
  <button type="submit">Submit</button>
</form>
<?php if(isset($error)) echo "<p style='color:red'>$error</p>"; ?>
</body>
</html>