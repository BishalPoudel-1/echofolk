<?php
session_start();
session_unset();
session_destroy();
session_start();
$_SESSION['flash_message'] = ['type' => 'success', 'text' => 'You have been logged out.'];
header("Location: login.php");
exit;
