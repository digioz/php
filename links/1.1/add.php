<?php
include("header.inc");

echo "<center><h2>Links Page Entry Result:</h2></center>";

$yourname = $_POST['yourname'];
$youremail = $_POST['youremail'];
$yourlink = $_POST['yourlink'];
$yourmessage = $_POST['yourmessage'];

 $date = date("H:i, jS F");

if (empty($yourname))
{
$error .= "Empty fields: <b>Your name</b><br>";
}
if (empty($youremail))
{
$error .= "Empty fields: <b>Your email</b><br>";
}
if (empty($yourlink))
{
$error .= "Empty fields: <b>Your link</b><br>";
}
if (empty($yourmessage))
{
$error .= "Empty fields: <b>Message</b><br>";
}
if ($error)
{
$z="1";
echo $error;
echo "<center><br><a href=\"javascript:history.go(-1)\" class=\"text\">Click here to go back</a></center>";
exit;
}
if ($error=="")
{

// Replacing Brackets to disable the insertion of HTML in the Links Page by Users

$yourmessage = str_replace("<", "&lt", $yourmessage);
$yourmessage = str_replace(">", "&gt;", $yourmessage);
$yourmessage = str_replace("\n", "<br>", $yourmessage);


// Inserting smiley faces for links users

$yourmessage = str_replace(":)", "<img src=images/smile.gif>", $yourmessage);
$yourmessage = str_replace(":D", "<img src=images/happy.gif>", $yourmessage);
$yourmessage = str_replace(":(", "<img src=images/sad.gif>", $yourmessage);
$yourmessage = str_replace(":p", "<img src=images/tongue.gif>", $yourmessage);
$yourmessage = str_replace(":o", "<img src=images/bored.gif>", $yourmessage);
$yourmessage = str_replace("8)", "<img src=images/cool.gif>", $yourmessage);

// Give Confirmation that the Guestbook Entry was written

  echo "<p>Following Message was added to the Links Page on ";
  echo $date;
  echo "<br><br>";

$temp1 = stripslashes($yourname);
$temp2 = stripslashes($youremail);
$temp3 = stripslashes($yourmessage);

  echo "<b>Your Name:</b> $temp1 <br>";
  echo "<b>Your Email:</b> $temp2 <br>";
  echo "<b>Your Link: </b> $yourlink <br>";
  echo "<b>Your Description:</b> $temp3 <br>";

  $outputstring = "<b>Date:</b> ".$date."<br><b>From:</b> ".$yourname."<br><b>Email:</b> <a href=mailto:$youremail>".$youremail."</a><br><b>Link:</b> <a href=$yourlink>".$yourlink."</a><br><br><b>Description:</b> ".$yourmessage."<hr>\n";


  // open file for appending
@ $fp = fopen("list.txt", "a");

  flock($fp, 2); 
 
  if (!$fp)
  {
    echo "<p><strong> Your Addition to the Links Page could not be processed at this time.  "
         ."Please try again in a few minutes.</strong></p></body></html>";
    exit;
  } 

  fwrite($fp, $outputstring);
  flock($fp, 3); 
  fclose($fp);

  echo "<center><p><b>Entry Written.</b></p></center>"; 

}

include("footer.inc");
?>