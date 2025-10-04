<?php

// Begin Login Verification --------------------------------------------

define('IN_GB', TRUE);

// Secure session & headers
include("../includes/security_headers.php");
include("../includes/secure_session.php");
include("../includes/config.php");
include("../includes/functions.php");

startSecureSession();

// Sanitize lg parameter
$lg = isset($_GET['lg']) ? trim($_GET['lg']) : '';
if ($lg === '' || !ctype_digit($lg)) { $lg = '0'; }

include("login_check.php");

if ($lg === "1") {
    $pageTitle = "User IP Log"; 
} elseif ($lg === "2") {
    $pageTitle = "Spammer IP Log"; 
} elseif ($lg === "3") {
    $pageTitle = "Guestbook Settings"; 
} else {
    $pageTitle = "Admin View";
}

include("includes/header.php");  
?>
<center>
<?php
// Validate numeric (already sanitized above)
if ($lg === '0') {
  echo "<font color=\"red\">Non Numeric LG Number.</font>";
  echo "<p>&nbsp;</p><p><center>";
  echo "<a href=\"index.php\"><font color=red><b>Admin Main</b></font></a> -";
  echo " <a href=\"login.php?mode=logout\"><font color=red><b>Logout</b></font></a>";
  echo "</center></p></body></html>";
  include("includes/footer.php");
  exit;
}

if ($lg === '1') {
  $filename = "../data/message_post.log";
  echo "<h3 align=\"center\"><u>User IP Log</u></h3><br><br>";
  echo "<br><br><center><table border=1 bordercolor=#C0C0C0 width=500><tr><td><pre>";
  echo "  Timestamp         | IP Number | IP Address      | Visitor Name \n";
  echo "------------------------------------------------------------------\n";
  if (is_readable($filename)) { readfile($filename); } else { echo "(log file not found)"; }
  echo "</pre><br><br></td></tr></table><br><br>";
} elseif ($lg === '2') {
  $filename = "../data/message_spam.log";
  echo "<h3 align=\"center\"><u>Spammer IP Log</u></h3>";
  echo "<br><br><center><table border=1 bordercolor=#C0C0C0 width=500><tr><td><pre>";
  echo "  Timestamp         | IP Number | IP Address      | Visitor Name    |     Message     \n";
  echo "--------------------------------------------------------------------------------------\n";
  if (is_readable($filename)) { readfile($filename); } else { echo "(log file not found)"; }
  echo "</pre><br><br></td></tr></table><br><br>";
} elseif ($lg === '3') {
  echo "<center><h3 align=\"center\"><u>Current Guestbook Settings</u></h3>";
  echo "<br><br><u><b>Note</b></u>: To change any of the above values, simply open the file <b>config.php</b> in a text editor<br>and change the corresponding value.";
  echo "<br><br><table border=1 bordercolor=#C0C0C0 width=600>";
  echo "<tr><td><b><center>Setting</center></b></td><td><b><center>Option Selected</center></b></td></tr>";
  $yesNo = function($v){ return $v==1? 'Yes':'No'; };
  echo "<tr><td>Email Field Optional</td><td><center><font color=blue><b>".$yesNo($email_optional)."</b></font></center></td></tr>";
  echo "<tr><td>Name Field Optional</td><td><center><font color=blue><b>".$yesNo($name_optional)."</b></font></center></td></tr>";
  echo "<tr><td>Message Field Optional</td><td><center><font color=blue><b>".$yesNo($message_optional)."</b></font></center></td></tr>";
  echo "<tr><td>Notify Admin when message posted</td><td><center><font color=blue><b>".$yesNo($notify_admin)."</b></font></center></td></tr>";
  echo "<tr><td>Notify Admin email (configured)</td><td><center><font color=blue><b>".htmlspecialchars($notify_admin_email)."</b></font></center></td></tr>";
  echo "<tr><td>Default Language</td><td><center><font color=blue><b>".htmlspecialchars($default_language[0])."</b></font></center></td></tr>";
  echo "<tr><td>Image Verification Enabled</td><td><center><font color=blue><b>".$yesNo($image_verify)."</b></font></center></td></tr>";
  echo "<tr><td>Guestbook Flood Protection</td><td><center><font color=blue><b>".$yesNo($gbflood)."</b></font></center></td></tr>";
  echo "<tr><td>Referer Checking</td><td><center><font color=blue><b>".$yesNo($referersKey)."</b></font></center></td></tr>";
  echo "<tr><td>Referer domain allowed (short)</td><td><center><font color=blue><b>".htmlspecialchars($referers[0])."</b></font></center></td></tr>";
  echo "<tr><td>Referer domain allowed (full)</td><td><center><font color=blue><b>".htmlspecialchars($referers[1])."</b></font></center></td></tr>";
  echo "<tr><td>Referer site IP allowed</td><td><center><font color=blue><b>".htmlspecialchars($referers[2])."</b></font></center></td></tr>";
  echo "<tr><td>Guestbook IP Log</td><td><center><font color=blue><b>".$yesNo($gbIPLogKey)."</b></font></center></td></tr>";
  echo "<tr><td>Ban Specified IP</td><td><center><font color=blue><b>".$yesNo($banIPKey)."</b></font></center></td></tr>";
  echo "<tr><td>Bad Word Filter</td><td><center><font color=blue><b>".$yesNo($gbBadWordsKey)."</b></font></center></td></tr>";
  echo "<tr><td>Keyword based Spam Block</td><td><center><font color=blue><b>".$yesNo($gbSpamKey)."</b></font></center></td></tr>";
  echo "<tr><td>Allow Attachments</td><td><center><font color=blue><b>".$yesNo($gbAllowAttachments)."</b></font></center></td></tr>";
  echo "<tr><td>Show Attachment Inline</td><td><center><font color=blue><b>".$yesNo($gbDisplayImageInBody)."</b></font></center></td></tr>";
  echo "<tr><td>Attachment File Types Allowed</td><td><center><font color=blue><b>".implode('<br>', array_map('htmlspecialchars',$attach_ext))."</b></font></center></td></tr>";
  echo "<tr><td>Files to Attach Inline</td><td><center><font color=blue><b>".implode('<br>', array_map('htmlspecialchars',$attach_img))."</b></font></center></td></tr>";
  echo "<tr><td>IP Ban List</td><td><center><font color=blue><b>".implode('<br>', array_map('htmlspecialchars',$banned_ip))."</b></font></center></td></tr>";
  echo "<tr><td>Bad word list</td><td><center><font color=blue><b>".implode('<br>', array_map('htmlspecialchars',$gbBadWords))."</b></font></center></td></tr>";
  echo "<tr><td>Spam word list</td><td><center><font color=blue><b>".implode('<br>', array_map('htmlspecialchars',$gbSpam))."</b></font></center></td></tr>";
  echo "</table>";
} else {
  echo "Sorry, but you did not make a selection from the main menu";
}
?>
<?php include ("includes/footer.php"); ?>
