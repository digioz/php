<?php

define('IN_GB', TRUE);

// Use the same secure session settings used everywhere else
include("includes/security_headers.php");
include("includes/secure_session.php");
startSecureSession();

// Clear all login-related session data and destroy the session
unset($_SESSION['login_email']);
unset($_SESSION['user_object']);

destroySecureSession();

header('Location: list.php?page=1&order=asc');
exit;

?>