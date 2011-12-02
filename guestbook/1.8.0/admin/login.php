<?php

// This starts the session ---------------------------------------------

session_start();

// This is the administrative Username and Password --------------------

include("../config.php");

// If they want to logout then -------------------------------------------

if (isset($_GET['mode']))
{
	if ($_GET['mode'] == "logout")
	{
		// and finally remove all the session variables
		session_destroy();

        // remove the session_id cookie from the browser
        setcookie(session_name(), '', time()-3600);

        // zero the $_SESSION array
		$_SESSION = array();

		// Redirect to show results..
		echo "<META HTTP-EQUIV=\"refresh\" content=\"1; URL=" . $_SERVER['PHP_SELF'] . "\">";
	}
}

// Login Form Generation Function ------------------------------------

function generateLoginForm()
{
	echo "<br><h1 align=\"center\">Guestbook Admin Interface</h1><br><br><center>";
	echo "<table bgcolor=#EFEFEF bordercolor=#C0C0C0 border=1 width=300 cellspacing=0 cellpadding=10><tr><td>";
	echo "<center><br><br><form method=\"post\" action=\"" . $_SERVER['PHP_SELF'] . "\">
			<b>Username: </b> <input type=\"textbox\" name=\"Username\"><br />
			<b>Password: </b> <input type=\"password\" name=\"Password\"><br />
			<input type=\"hidden\" name=\"Submitted\" value=\"True\"><br />
			<input type=\"Submit\" name=\"Submit\" value=\"Log In\">
			</form></center>";
	echo "</td></tr></table></center>";
}

// If the form was submitted -------------------------------------------

if (isset($_POST['Submitted']))
{
    // If the username and password match up, then continue...
    if ($_POST['Username'] == $_Username && $_POST['Password'] == $_Password)
	{
        $_SESSION['Logged_In'] = TRUE;
        $_SESSION['Username'] = $_Username;
    }
}

// If they are NOT logged in then show the form to login...
if (isset($_SESSION['Logged_In']))
{
	if ($_SESSION['Logged_In'] !== TRUE)
	{
		generateLoginForm();
	}
	else
	{
		$URL="index.php";
		header ("Location: $URL");
	}
}
else
{
	generateLoginForm();
}

?>
