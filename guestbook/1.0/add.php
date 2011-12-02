<?php
include("header.inc");

echo "<center><h2>Your Guestbook Entry has been added</h2></center>";

$yourname = $_POST['yourname'];
$youremail = $_POST['youremail'];
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

// Replacing Brackets to disable the insertion of HTML in the Guestbook by Users

$yourmessage = str_replace("<", "&lt", $yourmessage);
$yourmessage = str_replace(">", "&gt;", $yourmessage);
$yourmessage = str_replace("\n", "<br>", $yourmessage);


// Inserting smiley faces for guestbook users

$yourmessage = str_replace(":)", "<img src=images/smile.gif>", $yourmessage);
$yourmessage = str_replace(":D", "<img src=images/happy.gif>", $yourmessage);
$yourmessage = str_replace(":(", "<img src=images/sad.gif>", $yourmessage);
$yourmessage = str_replace(":p", "<img src=images/tongue.gif>", $yourmessage);
$yourmessage = str_replace(":o", "<img src=images/bored.gif>", $yourmessage);
$yourmessage = str_replace("8)", "<img src=images/cool.gif>", $yourmessage);

// Give Confirmation that the Guestbook Entry was written

  echo "<p>Following Message was added to the Guestbook on ";
  echo $date;
  echo "<br>";

  echo "<b>Your Name:</b> $yourname <br>";
  echo "<b>Your Email:</b> $youremail <br>";
  echo "<b>Your Message:</b> $yourmessage <br>";

  $outputstring = "<b>Date:</b> ".$date."<br><b>From:</b> ".$yourname."<br><b>Email:</b> <a href=mailto:$youremail>".$youremail."</a><br><br>Message: ".$yourmessage."<hr>\n";


  // open file for appending
@ $fp = fopen("list.txt", "a");

  flock($fp, 2); 
 
  if (!$fp)
  {
    echo "<p><strong> Your Addition to the Guestbook could not be processed at this time.  "
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