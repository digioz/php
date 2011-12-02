<?php

session_start();

// Including configuration files -----------------------------------------

include("config.php");

if($image_verify == 1)
{
    $number = $_POST['txtNumber'];
    if (md5($number) == $_SESSION['image_random_value'])
    {
      // echo "Nice Job";
    }
    else
    {
      include("header.php");
      echo "<br><br><font color=red><center>Wrong Image Verification Code
      Entered!<br>Please go back and enter it again.</center></font><br><br>";
      include("footer.php");
      exit;
    }
}

// Checking to see if the visitor has already posted --------------------

if ($gbflood == 1)
{
 if (isset($_COOKIE['entry']))
 {
  include("header.php");
  $cookieval = $_COOKIE['entry'];
  echo $cookieval;
  echo "<center><br><a href=\"javascript:history.go(-1)\" class=\"text\">$goback</a></center>";
  include("footer.php");
  exit;
 }

// Set cookie for flood protection --------------------------------------------------------------
$cookie = setcookie('entry','<br><br><center><font color=red><b>Sorry, You have already posted a Message on this guestbook.<br>Please wait 2 minutes and try again.</b></font><br><br></center>',time() + (120));
} // End of If statement for flooding

// Including header of the system ---------------------------------------

//include("functions.php");
include("header.php");

// Check for Banned IP if Option is set ---------------------------------

if ($banIPKey == 1)
{
   include("ban.php");
}

// Check to make sure that the post is coming from YOUR domain ----------

if ($referersKey == 1)
{
   if (!check_referer($referers))
   {
      // Form was not submitted from the site so exit
      echo "<center><br><a href=\"javascript:history.go(-1)\" class=\"text\"><font color=red>You are attempting to submit this entry from an<br>UNAUTHORIZED LOCATION. Your IP Number and Address has been logged.<br>Please be warned that continuing your attempt<br>to flood this guestbook may result<br>in legal action against you and your organization. </a></center>";
      include("footer.php");
      exit;
   }
}

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

if (isset($error))
{
$z="1";
echo $error;
echo "<center><br><a href=\"javascript:history.go(-1)\" class=\"text\">$goback</a></center>";
include("footer.php");
exit;
}
if (!isset($error))
{
   // Detect Spam based on keywords ------------------------------------------------------------------

   if ($gbSpamKey == 1)
   {
      $detectSpam = spamDetect($yourmessage);
      if($detectSpam == true)
      {
       $yourmessage = str_replace("\n", "<br>", $yourmessage);
       $yourmessage = str_replace("\r", "<br>", $yourmessage);
       $message_ip_log = $_SERVER['REMOTE_ADDR'];
       $message_ip_address_log = gethostbyaddr($_SERVER['REMOTE_ADDR']);
       $message_time_log = $date;
       $message_log_string = $message_time_log." | ".$message_ip_log." | ".$message_ip_address_log." | ".$yourname." | ".$yourmessage."\n";
       $fp = fopen("data/message_spam.log", "a");
       fwrite($fp, $message_log_string);
       fclose($fp);
       echo "<center><b><font size=-1>SPAM DETECTED!<br>Your IP HAS BEEN LOGGED<br>AND WILL BE REPORTED TO YOUR ISP.</font></center>";
       echo "<center><br><a href=\"javascript:history.go(-1)\" class=\"text\">$goback</a></center>";
       include("footer.php");
       exit;
      }
   }
   
   // Log visitor IP Number and IP Address if option is set by guestbook administrator ---------------

   if ($gbIPLogKey == 1)
   {
       $message_ip_log = $_SERVER['REMOTE_ADDR'];
       $message_ip_address_log = gethostbyaddr($_SERVER['REMOTE_ADDR']);
       $message_time_log = $date;
       $message_log_string = $message_time_log." | ".$message_ip_log." | ".$message_ip_address_log." | ".$yourname."\n";
       $fp = fopen("data/message_post.log", "a");
       fwrite($fp, $message_log_string);
       fclose($fp);
   }

   // Notify administrator of new email if option is selected ----------------------------------------

   if ($notify_admin == 1)
   {
      mail("$notify_admin_email", "$notify_subject", "$notify_message");
      }
   // Smiley face insertion into the message ---------------------------------------------------------

   $yourname    = clean_message(stripslashes($yourname));
   $yourmessage = clean_message(stripslashes($yourmessage));

   // Call for filtering bad words -------------------------------------------------------------------

   if ($gbBadWordsKey == 1)
   {
    $yourmessage = swapBadWords($yourmessage);
   }

   // Give Confirmation that the Guestbook Entry was written -----------------------------------------

   echo "<p>$result1 ";
   echo $date;
   echo "<br><br>";

   $temp1 = stripslashes($yourname);
   $temp2 = stripslashes($youremail);
   $temp3 = stripslashes($yourmessage);

   echo "<table bgcolor=#EFEFEF bordercolor=#C0C0C0 border=1 width=500 cellspacing=0 cellpadding=10><tr><td background=\"images/toolbar.jpg\" height=\"20\"></td></tr><tr><td>";
   echo "<b>$yournametxt</b> $temp1 <br>";
   echo "<b>$youremailtxt</b> $temp2 <br>";
   echo "<b>$yourMessagetxt</b> ".smiley_face($temp3)." <br>";
   echo "</td></tr></table>";

   // Write the verified guestbook entry to file ----------------------------------------------------

   $a = new gbClass();
   $a->setGBVars($date,$yourname,$youremail,$yourmessage);
   @ $fp = fopen("data/list.txt","a");
   flock($fp, 2);
 
   if (!$fp)
   {
       echo "<p><strong> $error7.  "
                ."$error8.</strong></p></body></html>";
       exit;
   }

   $data = serialize($a)."<!-- E -->";
   fwrite($fp, $data);
   flock($fp, 3);
   fclose($fp);

   echo "<center><p><b>$result2.</b></p></center>";

}

include("footer.php");
?>
