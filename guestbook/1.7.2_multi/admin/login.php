<?php

// This starts the session ---------------------------------------------

session_start();

// This is the administrative Username and Password --------------------

include("../config.php");

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
} 

// If they are NOT logged in then show the form to login... 
if ($_SESSION['Logged_In'] != "True") { 

    echo "<br><h1 align=\"center\">Guestbook Admin Interface</h1><br><br><center><table bgcolor=#EFEFEF bordercolor=#C0C0C0 border=1 width=300 cellspacing=0 cellpadding=10><tr><td>";
    echo "<center><br><br><form method=\"post\" action=\"" . $_SERVER['PHP_SELF'] . "\">
        <b>Username: </b> <input type=\"textbox\" name=\"Username\"><br />
        <b>Password: </b> <input type=\"password\" name=\"Password\"><br />
        <input type=\"hidden\" name=\"Submitted\" value=\"True\"><br />
        <input type=\"Submit\" name=\"Submit\" value=\"Log In\">
    </form></center>";
    echo "</td></tr></table></center>";
} 
else 
{ 
    //echo "<center><font size=\"-1\">You are logged in as: <b>" . $_SESSION['Username'] . "</b> <a href=\"" . $_SERVER['PHP_SELF'] . "?mode=logout\">Logout</a></font></center>";
    
    //echo "<center><h2><a href=\"index.php\">Enter Admin Interface</a></h2></center>";
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
