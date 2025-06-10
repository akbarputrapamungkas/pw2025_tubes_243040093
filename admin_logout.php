<?php
session_start();
session_unset();
session_destroy();
header("Location: admin_login.php");
exit;



session_start();
if (!isset($_SESSION['login'])) {
    header("Location: ../admin_login.php");
    exit;
}
