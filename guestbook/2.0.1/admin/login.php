<?php

// This starts the session ---------------------------------------------

define('IN_GB', TRUE);

session_start();

// This is the administrative Username and Password --------------------

include("../includes/config.php");

// If the form was submitted -------------------------------------------

if (isset($_POST['Submitted'])) 
{
    // If the username and password match up, then continue...
    if ($_POST['Username'] == $_Username && $_POST['Password'] == $_Password) { 

        // Username and password matched, set them as logged in and set the 
        // Username to a session variable. 
        $_SESSION['Logged_In'] = true;
        $_SESSION['Username'] = $_Username; 
    }
    else
    {
        $error = "<center><div style=\"color:red;\">Invalid Login Information Entered.</div></center>";
    } 
} 

// If they are NOT logged in then show the form to login... 
if ($_SESSION['Logged_In'] != "True") {

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
            
                <form action="login.php" method="post">
                    <label for="login">Username:</label>
                    <input id="login" name="Username" class="text" />
                    <label for="pass">Password:</label>
                    <input id="pass" name="Password" type="password" class="text" />
                    <input type="hidden" name="Submitted" value="True">
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
    
<?php
} 
else 
{
    $URL="index.php";
    header ("Location: $URL");
} 

// If they want to logout then 
if (@$_GET['mode'] == "logout") { 
    // Start the session 
    session_start(); 

    // Put all the session variables into an array 
    $_SESSION = array(); 

    // and finally remove all the session variables 
    session_destroy(); 

    // Redirect to show results.. 
    echo "<META HTTP-EQUIV=\"refresh\" content=\"1; URL=" . $_SERVER['PHP_SELF'] . "\">"; 
}
 
?>
