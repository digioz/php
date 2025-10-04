<?php

define('IN_GB', TRUE);

// Secure session & headers
include("../includes/security_headers.php");
include("../includes/secure_session.php");
include("../includes/config.php");

startSecureSession();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Submitted'])) {
    $user = isset($_POST['Username']) ? trim($_POST['Username']) : '';
    $pass = isset($_POST['Password']) ? (string)$_POST['Password'] : '';

    if ($user === $_Username && $pass === $_Password) {
        regenerateSessionOnLogin();
        $_SESSION['Logged_In'] = true;
        $_SESSION['Username'] = $_Username;
        header('Location: index.php');
        exit;
    } else {
        $error = "<center><div style=\"color:red;\">Invalid Login Information Entered.</div></center>";
    }
}

if (isset($_GET['mode']) && $_GET['mode'] === 'logout') {
    destroySecureSession();
    header('Location: login.php');
    exit;
}

$loggedIn = !empty($_SESSION['Logged_In']);
if ($loggedIn) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>DigiOz Guestbook Admin Interface Login</title>
<link rel="stylesheet" type="text/css" href="css/login.css" media="screen" />
</head>
<body>
<div class="wrap">
    <div id="content">
        <h3>Guestbook Admin Interface Login</h3>
        <p>&nbsp;</p>
        <div id="main">
            <div class="full_w">
                <form action="login.php" method="post" autocomplete="off">
                    <label for="login">Username:</label>
                    <input id="login" name="Username" class="text" />
                    <label for="pass">Password:</label>
                    <input id="pass" name="Password" type="password" class="text" />
                    <input type="hidden" name="Submitted" value="True" />
                    <br />
                    <div class="sep"></div>
                    <button type="submit" class="ok">Login</button>
                </form>
            </div>
            <div class="footer"> <a href="http://www.digioz.com">&copy; 2007- <?php echo date("Y"); ?> DigiOz Multimedia, Inc.</a> </div>
        </div>
    </div>
    <p>&nbsp;</p>
    <?php echo $error; ?>
</div>
</body>
</html>
