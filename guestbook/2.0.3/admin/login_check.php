<?php
if (!isset($_SESSION['Logged_In'])) {
        $URL="login.php";
        header ("Location: $URL");
}
?>
