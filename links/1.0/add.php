<?php
include("header.inc");

echo "<center><h2>Your Link has been added</h2></center>";

$yourname = $_POST['yourname'];
$yourlink = $_POST['yourlink'];
$yourdescription = $_POST['yourdescription'];

 $date = date("H:i, jS F");

if (empty($yourname))
{
$error .= "Empty fields: <b>Site Name</b><br>";
}
if (empty($yourlink))
{
$error .= "Empty fields: <b>Your Link</b><br>";
}
if (empty($yourdescription))
{
$error .= "Empty fields: <b>Site Description</b><br>";
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

  echo "<p>Following Link was added to our links page on ";
  echo $date;
  echo "<br>";

  echo "<b>Your Name:</b> $yourname <br>";
  echo "<b>Your Email:</b> $yourlink <br>";
  echo "<b>Your Message:</b> $yourdescription <br>";

  $outputstring = "<b>Date:</b> ".$date."\n<br><b>From:</b> ".$yourname."\n<br><b>Link:</b> <a href=$yourlink>".$yourlink."</a>\n<br><br>".$yourdescription."\n\n<hr>";


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