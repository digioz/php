<?php
// Including header, functions and configuration files ------------------

include("header.inc");
include("functions.php");
include("config.php");

// Re-assigning the variables passed by posted form ---------------------

$yourname = $_POST['yourname'];
$youremail = $_POST['youremail'];
$yourmessage = $_POST['yourmessage'];
$date = date("D m/j/y g:iA");

// Error Handeling and entry checking -----------------------------------
echo "<center><h2>$addentryheadtxt</h2></center>";

// Name Validation Section -----------------------------

if ($name_optional != 1)
{
        if (strlen($yourname) > 40)                 // Check Name Length
        {
        $error .= "<br>$error1";
        }
        if (empty($yourname))                       // Check if Name field is empty
        {
        $error .= "<br>$error4";
        }
}

// Email Validation Section ----------------------------

if ($email_optional != 1)
{
       if (strlen($youremail) > 40)                // Check Email Length
       {
       $error .= "<br>$error2";
       }
       if (empty($youremail))                      // Check if Email field is empty
       {
       $error .= "<br>$error5";
       }
       if (checkmail($youremail) != 1)             // Validate Email format
       {
       $error .= "<br>$error3";
       }
}

// Message Validation Section ---------------------------

if ($message_optional != 1)
{
       if (empty($yourmessage))                    // Check if Message field is empty
       {
       $error .= "<br>$error6";
       }
}

// Exit Program if there is an error --------------------

if ($error)
{
$z="1";
echo $error;
echo "<center><br><a href=\"javascript:history.go(-1)\" class=\"text\">$goback</a></center>";
include("footer.inc");
exit;
}
if ($error=="")
{
// Notify administrator of new email if option is selected -------------------------------------------

if ($notify_admin == 1)
{
   mail("$notify_admin_email", "$notify_subject", "$notify_message");
}
// Smiley face insertion into the message ------------------------------------------------------------

$yourname    = smiley_face($yourname);
$yourmessage = smiley_face($yourmessage);

// Give Confirmation that the Guestbook Entry was written -----------------------------------------

  echo "<p>$result1 ";
  echo $date;
  echo "<br><br>";

$temp1 = stripslashes($yourname);
$temp2 = stripslashes($youremail);
$temp3 = stripslashes($yourmessage);

  echo "<b>$yournametxt</b> $temp1 <br>";
  echo "<b>$youremailtxt</b> $temp2 <br>";
  echo "<b>$yourMessagetxt</b> $temp3 <br>";

// Write the verified guestbook entry to file ----------------------------------------------------------

  $outputstring = "<b>$listDatetxt:</b> ".$date."<br><b>$listnametxt:</b> ".$yourname."<br><b>$listemailtxt: </b><a href=mailto:$youremail>".$youremail."</a><br><br><b>$listMessagetxt:</b> ".$yourmessage."<hr>\n";


  // open file for appending
@ $fp = fopen("list.txt", "a");

  flock($fp, 2); 
 
  if (!$fp)
  {
    echo "<p><strong> $error7.  "
         ."$error8.</strong></p></body></html>";
    exit;
  } 

  fwrite($fp, $outputstring);
  flock($fp, 3); 
  fclose($fp);

  echo "<center><p><b>$result2.</b></p></center>"; 

}

include("footer.inc");
?>
