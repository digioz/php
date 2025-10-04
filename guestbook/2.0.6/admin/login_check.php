<?php
if (session_status() === PHP_SESSION_NONE) {
    // Fallback: start a basic session if secure session wrapper not used yet
    session_start();
}
if (empty($_SESSION['Logged_In']) || $_SESSION['Logged_In'] !== true) {
    header('Location: login.php');
    exit;
}
?>
