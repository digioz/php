<?php

// Begin Login Verification --------------------------------------------

session_start();

include("login_check.php");
?>
<html>
<head><title>Guestbook Admin Interface</title></head>
  <link rel="STYLESHEET" type="text/css" href="../style.css">
<body>

<br>
<h2 align="center">IP Tracking Interface</h2>
<br><br><center>
<?php

$lg = $_GET['lg'];

// Validate browser input ------------------------------------------------------------

if (is_numeric($lg) == false)
{
  echo "<font color=\"red\">Non Numeric LG Number.</font>";
  echo "<p>&nbsp;</p>";
  echo "<p>";
  echo "<center>";
  echo "      <a href=\"index.php\"><font color=\"red\"><b>Admin Main</b></font></a> -";
  echo "      <a href=\"login.php?mode=logout\"><font color=\"red\"><b>Logout</b></font></a>";
  echo "</center></p>";
  echo "</body>";
  echo "</html>";
  exit;
}

// Determine page selection ----------------------------------------------------------

if($lg == 1)
{
  echo "<h3 align=\"center\"><u>User IP Log</u></h3><br><br>";
  $filename = "../data/message_post.log";
  echo "<br><br><center><table border=1 bordercolor=#C0C0C0 width=500><tr><td><pre>";
  echo "  Timestamp         | IP Number | IP Address      | Visitor Name \n";
  echo "------------------------------------------------------------------\n";
  readfile($filename);
  echo "</pre><br><br></td></tr></table><br><br>";
}
elseif ($lg == 2)
{
  echo "<h3 align=\"center\"><u>Spammer IP Log</u></h3>";
  $filename = "../data/message_spam.log";
  echo "<br><br><center><table border=1 bordercolor=#C0C0C0 width=500><tr><td><pre>";
  echo "  Timestamp         | IP Number | IP Address      | Visitor Name    |     Message     \n";
  echo "--------------------------------------------------------------------------------------\n";
  readfile($filename);
  echo "</pre><br><br></td></tr></table><br><br>";
}
elseif ($lg == 3)
{
  echo "<center><h3 align=\"center\"><u>Current Guestbook Settings</u></h3>";
  echo "<br><br><u><b>Note</b></u>: To change any of the above values, simply open the file <b>config.php</b> in notepad<br>and changes the corresponding value to '1' to '0' depending on your selection.";

  include("../config.php");
  
  echo "<br><br><table border=1 bordercolor=#C0C0C0 width=600>";
  echo "<tr><td><b><center>Setting</center></b></td><td><b><center>Option Selected</center></b></td></tr>";
  echo "<tr><td>Email Field Optional</td><td><center><font color=blue><b>";
       if($email_optional == 1){ echo "Yes"; }else{ echo "No"; }
       echo "</b></font></center></td></tr>";
  echo "<tr><td>Name Field Optional:</td><td><center><font color=blue><b>";
       if($$name_optional == 1){ echo "Yes"; }else{ echo "No"; }
       echo "</b></font></center></td></tr>";
  echo "<tr><td>Message Field Optional:</td><td><center><font color=blue><b>";
       if($message_optional == 1){ echo "Yes"; }else{ echo "No"; }
       echo "</b></font></center></td></tr>";
  echo "<tr><td>Nofity Admin when message posted:</td><td><center><font color=blue><b>";
       if($notify_admin == 1){ echo "Yes"; }else{ echo "No"; }
       echo "</b></font></center></td></tr>";
  echo "<tr><td>Notify Admin email (current):</td><td><center><font color=blue><b>";
       if($notify_admin_email == 1){ echo "Yes"; }else{ echo "No"; }
       echo "</b></font></center></td></tr>";
  echo "<tr><td>Default Language:</td><td><center><font color=blue><b>";
       echo $default_language;
       echo "</b></font></center></td></tr>";
    echo "<tr><td>Image Verification:</td><td><center><font color=blue><b>";
       if($image_verify == 1){ echo "Yes"; }else{ echo "No"; }
       echo "</b></font></center></td></tr>";
  echo "<tr><td>Guestbook Flood Protection:</td><td><center><font color=blue><b>";
       if($gbflood == 1){ echo "Yes"; }else{ echo "No"; }
       echo "</b></font></center></td></tr>";
  echo "<tr><td>Referer Checking:</td><td><center><font color=blue><b>";
       if($referersKey == 1){ echo "Yes"; }else{ echo "No"; }
       echo "</b></font></center></td></tr>";
  echo "<tr><td>Referer domain allowed for posting:</td><td><center><font color=blue><b>";
       echo $referers[0];
       echo "</b></font></center></td></tr>";
  echo "<tr><td>Full Referer domain allowed for posting:</td><td><center><font color=blue><b>";
       echo $referers[1];
       echo "</b></font></center></td></tr>";
  echo "<tr><td>Referer Site IP allowed for posting:</td><td><center><font color=blue><b>";
       echo $referers[2];
       echo "</b></font></center></td></tr>";
  echo "<tr><td>Guestbook IP Log:</td><td><center><font color=blue><b>";
       if($gbIPLogKey == 1){ echo "Yes"; }else{ echo "No"; }
       echo "</b></font></center></td></tr>";
  echo "<tr><td>Ban Specified IP:</td><td><center><font color=blue><b>";
       if($banIPKey == 1){ echo "Yes"; }else{ echo "No"; }
       echo "</b></font></center></td></tr>";
  echo "<tr><td>Bad Word Filter:</td><td><center><font color=blue><b>";
       if($gbBadWordsKey == 1){ echo "Yes"; }else{ echo "No"; }
       echo "</b></font></center></td></tr>";
  echo "<tr><td>Keyword based Spam Block:</td><td><center><font color=blue><b>";
       if($gbSpamKey == 1){ echo "Yes"; }else{ echo "No"; }
       echo "</b></font></center></td></tr>";
       
  echo "<tr><td>IP Ban List (if option is 'YES' above):</td><td><center><font color=blue><b>";
       foreach($banned_ip as $value1)
       {
         echo $value1."<br>";
       }
       echo "</b></font></center></td></tr>";
  echo "<tr><td>Bad word list (if option is 'YES' above):</td><td><center><font color=blue><b>";
       foreach($gbBadWords as $value2)
       {
         echo $value2."<br>";
       }
       echo "</b></font></center></td></tr>";
  echo "<tr><td>Spam word list (if option is 'YES' above):</td><td><center><font color=blue><b>";
       foreach($gbSpam as $value3)
       {
         echo $value3."<br>";
       }
       echo "</b></font></center></td></tr>";

  echo "</table>";
}
else
{
  echo "Sorry, but you did not make a selection from the main menu";
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
