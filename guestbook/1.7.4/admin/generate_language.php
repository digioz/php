<?php

// Begin Login Verification --------------------------------------------

session_start();

include("login_check.php");

?>
<html>
<head><title>DigiOz Guestbook Administrative Interface</title></head>
  <link rel="STYLESHEET" type="text/css" href="../style.css">
<body>

<br>
<h2 align="center">Generate Language File</h2>
<br><br><center>
<!-- End of Header Section -->
<?php
if (isset($_POST['Submit']))
{
  $f1 = $_POST['f1'];
  $f2 = $_POST['f2'];
  $f3 = $_POST['f3'];
  $f4 = $_POST['f4'];
  $f5 = $_POST['f5'];
  $f6 = $_POST['f6'];
  $f7 = $_POST['f7'];
  $f8 = $_POST['f8'];
  $f9 = $_POST['f9'];
  $f10 = $_POST['f10'];
  $f11 = $_POST['f11'];
  $f12 = $_POST['f12'];
  $f13 = $_POST['f13'];
  $f14 = $_POST['f14'];
  $f15 = $_POST['f15'];
  $f16 = $_POST['f16'];
  $f17 = $_POST['f17'];
  $f18 = $_POST['f18'];
  $f19 = $_POST['f19'];
  $f20 = $_POST['f20'];
  $f21 = $_POST['f21'];
  $f22 = $_POST['f22'];
  $f23 = $_POST['f23'];
  $f24 = $_POST['f24'];
  $f25 = $_POST['f25'];
  

echo "<textarea  cols=\"90\" rows=\"30\">";
echo '<?php';
echo "\n";
echo "".
"\$yournametxt          = '$f1';\n".
"\$youremailtxt		= '$f2';\n".
"\$yourMessagetxt 	= '$f3';\n".
"\$submitbutton 	= '$f4';\n".
"\$headingtitletxt 	= '$f5';\n".
"\$addentrytxt 		= '$f6';\n".
"\$viewguestbooktxt 	= '$f7';\n".
"\$newpostfirsttxt 	= '$f8';\n".
"\$newpostlasttxt 	= '$f9';\n".
"\$addentryheadtxt	= '$f10';\n".
"\$error1		= '$f11';\n".
"\$error2		= '$f12';\n".
"\$error3		= '$f13';\n".
"\$error4		= '$f14';\n".
"\$error5		= '$f15';\n".
"\$error6		= '$f16';\n".
"\$error7		= '$f17';\n".
"\$error8		= '$f18';\n".
"\$goback		= '$f19';\n".
"\$result1		= '$f20';\n".
"\$result2		= '$f21';\n".
"\$listnametxt		= '$f22';\n".
"\$listemailtxt		= '$f23';\n".
"\$listMessagetxt	= '$f24';\n".
"\$listDatetxt		= '$f25';\n";
echo '?>';
echo "\n";
echo "</textarea>";
echo "<center>Please copy and paste the above code into the language.php file in your guestbook folder";
}
else
{
?>
<!-- Form Starts Here -->
<form method="post" action="generate_language.php">
<table border=1 bordercolor=#C0C0C0 width=800>
<tr>
    <td> Your Name: </td>
    <td> <input type="textbox" name="f1" size="50">
</tr>
<tr>
    <td> Your Email: </td>
    <td> <input type="textbox" name="f2" size="50">
</tr>
<tr>
    <td> Your Message: </td>
    <td> <input type="textbox" name="f3" size="50">
</tr>
<tr>
    <td> Submit Guestbook Entry </td>
    <td> <input type="textbox" name="f4" size="50">
</tr>
<tr>
    <td> Guestbook </td>
    <td> <input type="textbox" name="f5" size="50">
</tr>
<tr>
    <td> Add Entry </td>
    <td> <input type="textbox" name="f6" size="50">
</tr>
<tr>
    <td> View Guestbook </td>
    <td> <input type="textbox" name="f7" size="50">
</tr>
<tr>
    <td> New Post First </td>
    <td> <input type="textbox" name="f8" size="50">
</tr>
<tr>
    <td> New Post Last </td>
    <td> <input type="textbox" name="f9" size="50">
</tr>
<tr>
    <td> Guestbook Entry Result: </td>
    <td> <input type="textbox" name="f10" size="50">
</tr>
<tr>
    <td> The Name you specified is too long. </td>
    <td> <input type="textbox" name="f11" size="50">
</tr>
<tr>
    <td> The Email you specified is too long. </td>
    <td> <input type="textbox" name="f12" size="50">
</tr>
<tr>
    <td> Invalid Email. Entry Not Processed! </td>
    <td> <input type="textbox" name="f13" size="50">
</tr>
<tr>
    <td> Empty fields: <b>Your name</b> </td>
    <td> <input type="textbox" name="f14" size="50">
</tr>
<tr>
    <td> Empty fields: <b>Your email</b> </td>
    <td> <input type="textbox" name="f15" size="50">
</tr>
<tr>
    <td> Empty fields: <b>Message</b> </td>
    <td> <input type="textbox" name="f16" size="50">
</tr>
<tr>
    <td> Your Addition to the Guestbook could not be processed at this time </td>
    <td> <input type="textbox" name="f17" size="50">
</tr>
<tr>
    <td> Please try again in a few minutes </td>
    <td> <input type="textbox" name="f18" size="50">
</tr>
<tr>
    <td> Click here to go back </td>
    <td> <input type="textbox" name="f19" size="50">
</tr>
<tr>
    <td> Following Message was added to the Guestbook on </td>
    <td> <input type="textbox" name="f20" size="50">
</tr>
<tr>
    <td> Entry Written </td>
    <td> <input type="textbox" name="f21" size="50">
</tr>
<tr>
    <td> From </td>
    <td> <input type="textbox" name="f22" size="50">
</tr>
<tr>
    <td> Email </td>
    <td> <input type="textbox" name="f23" size="50">
</tr>
<tr>
    <td> Message </td>
    <td> <input type="textbox" name="f24" size="50">
</tr>
<tr>
    <td> Date </td>
    <td> <input type="textbox" name="f25" size="50">
</tr>
<tr>
    <td></td>
    <td><input type="Submit" name="Submit" value="Generate Language File"></td>
</tr>
</table>
</form>
<!-- Form Ends Here -->
<?php
}
?>
<!-- Footer Starts Here -->

<p>&nbsp;</p>
<p>
<center>
        <a href="index.php"><font color="red"><b>Admin Main</b></font></a> -
        <a href="login.php?mode=logout"><font color="red"><b>Logout</b></font></a>
</center>
</p>

</body>
</html>
