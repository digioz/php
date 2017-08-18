<?php

define('IN_GB', TRUE);

// Begin Login Verification --------------------------------------------

session_start();

$pageTitle = "Generate Language File";  

include("login_check.php");
include("../includes/config.php");
include("includes/header.php");  

?>
<center>
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
  $f26 = $_POST['f26'];
  $f27 = $_POST['f27'];
  $f28 = $_POST['f28'];
  $f29 = $_POST['f29'];
  $f30 = $_POST['f30'];
  $f31 = $_POST['f31'];
  $f32 = $_POST['f32'];
  $f33 = $_POST['f33'];
  $f34 = $_POST['f34'];
  $f35 = $_POST['f35'];
  $f36 = $_POST['f36'];
  $f37 = $_POST['f37'];
  $f38 = $_POST['f38'];
  $f39 = $_POST['f39'];
  $f40 = $_POST['f40'];
  $f41 = $_POST['f41'];
  

echo "<textarea  cols=\"80\" rows=\"30\">";
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
"\$listDatetxt		= '$f25';\n".
"\$searchlabeltxt	= '$f26';\n".		
"\$searchbuttontxt	= '$f27';\n".	
"\$errorImageVerification = '$f28';\n".
"\$msgfloodprotection	= '$f29';\n".	
"\$msgreferrerkey 	= '$f30';\n".	
"\$msgspamdetected	= '$f31';\n".	
"\$title			= '$f32';\n".		
"\$msgnonnumericpagenr	= '$f33';\n".
"\$msgsortingerror		= '$f34';\n".
"\$msgnoentries			= '$f35';\n".
"\$msgnosearchterm		= '$f36';\n".
"\$msgresultofsearch	= '$f37';\n".	
"\$msgnomatchfound		= '$f38';\n".
"\$errorFormToken		= '$f39';\n".	
"\$errorSFS				= '$f40';\n".
"\$hideemailtxt			= '$f41';\n";

echo '?>';
echo "\n";
echo "</textarea>";
echo "<center>Please copy and paste the above code into the language.php file in your guestbook folder";
}
else
{
?>
<!-- Form Starts Here -->

<p>If you speak a language that is not already supported by the guestbook, please consider submitting a guestbook translation
to the language of your choice to our support team at <a href="mailto:support@digioz.com">support@digioz.com</a> so it can
be added to future versions of the guestbook. </p>

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
    <td> Enter Search <b>WORD</b> </td>
    <td> <input type="textbox" name="f26" size="50">
</tr>
<tr>
    <td> Find Now! </td>
    <td> <input type="textbox" name="f27" size="50">
</tr>
<tr>
    <td> Wrong Image Verification Code Entered!<br />Please go back and enter it again. </td>
    <td> <input type="textbox" name="f28" size="50">
</tr>
<tr>
    <td> Sorry, You have already posted a Message on this guestbook.<br>Please wait 2 minutes and try again. </td>
    <td> <input type="textbox" name="f29" size="50">
</tr>
<tr>
    <td> You are attempting to submit this entry from an <br>UNAUTHORIZED LOCATION. Your IP Number and Address has been logged.<br> Please be warned that continuing your attempt<br>to flood this guestbook may result<br>in legal action against you and your organization. </td>
    <td> <input type="textbox" name="f30" size="50">
</tr>
<tr>
    <td> SPAM DETECTED!<br>Your IP HAS BEEN LOGGED<br>AND WILL BE REPORTED TO YOUR ISP. </td>
    <td> <input type="textbox" name="f31" size="50">
</tr>
<tr>
    <td> DigiOz Guestbook </td>
    <td> <input type="textbox" name="f32" size="50">
</tr>
<tr>
    <td> Non Numeric Page Number </td>
    <td> <input type="textbox" name="f33" size="50">
</tr>
<tr>
    <td> Entry order can only be 'asc' or 'desc' </td>
    <td> <input type="textbox" name="f34" size="50">
</tr>
<tr>
    <td> There are currently no entries to display </td>
    <td> <input type="textbox" name="f35" size="50">
</tr>
<tr>
    <td> Please enter a search term and try again. </td>
    <td> <input type="textbox" name="f36" size="50">
</tr>
<tr>
    <td> The result of your search </td>
    <td> <input type="textbox" name="f37" size="50">
</tr>
<tr>
    <td> No match found. </td>
    <td> <input type="textbox" name="f38" size="50">
</tr>
<tr>
    <td> Invalid Form Security Token Detected. </td>
    <td> <input type="textbox" name="f39" size="50">
</tr>
<tr>
    <td> Your IP has been identified as a spammer in the Stop Forum Spam Database. You are not permitted to post a message in this guestbook. </td>
    <td> <input type="textbox" name="f40" size="50">
</tr>
<tr>
    <td> Hide Email </td>
    <td> <input type="textbox" name="f41" size="50">
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

<?php
include ("includes/footer.php");
?>
