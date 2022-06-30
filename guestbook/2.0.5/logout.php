<?php

define('IN_GB', TRUE);

session_start();

unset($_SESSION['login_email']);

header( 'Location: list.php?page=1&order=asc' ) ;

?>