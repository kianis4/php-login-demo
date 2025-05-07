<?php
/* ---------- logout.php ---------- */
session_start();
session_unset();      // remove all session vars
session_destroy();    // kill the session
header("Location: login.php");
exit();