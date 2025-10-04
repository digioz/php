<?php

define('IN_GB', TRUE);

// Secure session & headers
include("../includes/security_headers.php");
include("../includes/secure_session.php");
include("../includes/config.php");

startSecureSession();

$pageTitle = "Generate Language File";  

include("login_check.php");
include("includes/header.php");  

function gl_safe($key) { return isset($_POST[$key]) ? str_replace(['"',"'"], ['&quot;','&#39;'], trim($_POST[$key])) : ''; }
?>
<center>
<?php
if (isset($_POST['Submit'])) {
  // Collect 63 fields safely
  $fields = [];
  for ($i=1; $i<=63; $i++) { $fields[$i] = gl_safe('f'.$i); }

  echo "<textarea cols=\"80\" rows=\"30\">";
  echo "<?php\n";
  echo "".
  "\$yournametxt          = '{$fields[1]}';\n".
  "\$youremailtxt        = '{$fields[2]}';\n".
  "\$yourMessagetxt      = '{$fields[3]}';\n".
  "\$submitbutton        = '{$fields[4]}';\n".
  "\$headingtitletxt     = '{$fields[5]}';\n".
  "\$addentrytxt         = '{$fields[6]}';\n".
  "\$viewguestbooktxt    = '{$fields[7]}';\n".
  "\$newpostfirsttxt     = '{$fields[8]}';\n".
  "\$newpostlasttxt      = '{$fields[9]}';\n".
  "\$addentryheadtxt     = '{$fields[10]}';\n".
  "\$error1              = '{$fields[11]}';\n".
  "\$error2              = '{$fields[12]}';\n".
  "\$error3              = '{$fields[13]}';\n".
  "\$error4              = '{$fields[14]}';\n".
  "\$error5              = '{$fields[15]}';\n".
  "\$error6              = '{$fields[16]}';\n".
  "\$error7              = '{$fields[17]}';\n".
  "\$error8              = '{$fields[18]}';\n".
  "\$goback              = '{$fields[19]}';\n".
  "\$result1             = '{$fields[20]}';\n".
  "\$result2             = '{$fields[21]}';\n".
  "\$listnametxt         = '{$fields[22]}';\n".
  "\$listemailtxt        = '{$fields[23]}';\n".
  "\$listMessagetxt      = '{$fields[24]}';\n".
  "\$listDatetxt         = '{$fields[25]}';\n".
  "\$searchlabeltxt      = '{$fields[26]}';\n".
  "\$searchbuttontxt     = '{$fields[27]}';\n".
  "\$errorImageVerification = '{$fields[28]}';\n".
  "\$msgfloodprotection  = '{$fields[29]}';\n".
  "\$msgreferrerkey      = '{$fields[30]}';\n".
  "\$msgspamdetected     = '{$fields[31]}';\n".
  "\$title               = '{$fields[32]}';\n".
  "\$msgnonnumericpagenr = '{$fields[33]}';\n".
  "\$msgsortingerror     = '{$fields[34]}';\n".
  "\$msgnoentries        = '{$fields[35]}';\n".
  "\$msgnosearchterm     = '{$fields[36]}';\n".
  "\$msgresultofsearch   = '{$fields[37]}';\n".
  "\$msgnomatchfound     = '{$fields[38]}';\n".
  "\$errorFormToken      = '{$fields[39]}';\n".
  "\$errorSFS            = '{$fields[40]}';\n".
  "\$hideemailtxt        = '{$fields[41]}';\n".
  "\$logintxt            = '{$fields[42]}';\n".
  "\$logouttxt           = '{$fields[43]}';\n".
  "\$registertxt         = '{$fields[44]}';\n".
  "\$emailtxt            = '{$fields[45]}';\n".
  "\$passwordtxt         = '{$fields[46]}';\n".
  "\$passwordconfirmtxt  = '{$fields[47]}';\n".
  "\$nametxt             = '{$fields[48]}';\n".
  "\$addresstxt          = '{$fields[49]}';\n".
  "\$citytxt             = '{$fields[50]}';\n".
  "\$statetxt            = '{$fields[51]}';\n".
  "\$ziptxt              = '{$fields[52]}';\n".
  "\$countrytxt          = '{$fields[53]}';\n".
  "\$phonetxt            = '{$fields[54]}';\n".
  "\$error9              = '{$fields[55]}';\n".
  "\$error10             = '{$fields[56]}';\n".
  "\$info1               = '{$fields[57]}';\n".
  "\$error11             = '{$fields[58]}';\n".
  "\$error12             = '{$fields[59]}';\n".
  "\$warning1            = '{$fields[60]}';\n".
  "\$info2               = '{$fields[61]}';\n".
  "\$info3               = '{$fields[62]}';\n".
  "\$info4               = '{$fields[63]}';\n";
  echo "?>\n";
  echo "</textarea>";
  echo "<center>Please copy and paste the above code into the language.php file in your guestbook folder";
} else {
?>
<p>If you speak a language that is not already supported by the guestbook, please consider submitting a guestbook translation
to the language of your choice to our support team at <a href="mailto:support@digioz.com">support@digioz.com</a> so it can
be added to future versions of the guestbook. </p>
<form method="post" action="generate_language.php">
<table border=1 bordercolor=#C0C0C0 width=800>
<?php
$labels = [
 'Your Name:', 'Your Email:', 'Your Message:', 'Submit Guestbook Entry', 'Guestbook', 'Add Entry', 'View Guestbook',
 'New Post First', 'New Post Last', 'Guestbook Entry Result:',
 'The Name you specified is too long.', 'The Email you specified is too long.', 'Invalid Email. Entry Not Processed!',
 'Empty fields: <b>Your name</b>', 'Empty fields: <b>Your email</b>', 'Empty fields: <b>Message</b>',
 'Your Addition to the Guestbook could not be processed at this time', 'Please try again in a few minutes',
 'Click here to go back', 'Following Message was added to the Guestbook on', 'Entry Written', 'From', 'Email', 'Message',
 'Date', 'Enter Search <b>WORD</b>', 'Find Now!',
 'Wrong Image Verification Code Entered!<br />Please go back and enter it again.',
 'Sorry, You have already posted a Message on this guestbook.<br>Please wait 2 minutes and try again.',
 'You are attempting to submit this entry from an <br>UNAUTHORIZED LOCATION. Your IP Number and Address has been logged.<br> Please be warned that continuing your attempt<br>to flood this guestbook may result<br>in legal action against you and your organization.',
 'SPAM DETECTED!<br>Your IP HAS BEEN LOGGED<br>AND WILL BE REPORTED TO YOUR ISP.',
 'DigiOz Guestbook', 'Non Numeric Page Number', "Entry order can only be 'asc' or 'desc'",
 'There are currently no entries to display', 'Please enter a search term and try again.',
 'The result of your search', 'No match found.', 'Invalid Form Security Token Detected.',
 'Your IP has been identified as a spammer in the Stop Forum Spam Database. You are not permitted to post a message in this guestbook.',
 'Hide Email', 'Login', 'Logout', 'Register', 'Email', 'Password', 'Confirm Password', 'Name', 'Address', 'City', 'State', 'Zip', 'Country', 'Phone',
 'Unable to Register due to an error', 'Password and Password Confirm do not match', 'You have been logged in successfully',
 'Unable to log you in. Please try again later.', 'This email is already registered.', 'Are you sure you want to delete this message?',
 'Settings', 'Save', 'Manage Posts'
];
for ($i=0; $i<count($labels); $i++) {
    $n = $i+1;
    echo "<tr><td>{$labels[$i]}</td><td><input type=\"text\" name=\"f{$n}\" size=\"50\"></td></tr>";
}
?>
<tr><td></td><td><input type="Submit" name="Submit" value="Generate Language File"></td></tr>
</table>
</form>
<?php } ?>
<?php include ("includes/footer.php"); ?>
