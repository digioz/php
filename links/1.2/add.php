<?php
include("header.inc");

// List of Functions used in the script -----------------------------------------------------------------------

// List of Default Variables Values -------------------------------------
// $wordsize = 25;

//Check to see if email address is valid --------------------------------
function checkmail ($youremail) {

if (ereg('^[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+'.'@'.'[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\.'.
'[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$', $youremail)) {
	return true;
} else {
	return false;
} 
} 

// Function to breakup log words in message -------------------------
function wordbreak($text, $wordsize) {

if (strlen($text) <= $wordsize) { return $text; } # No breaking necessary, return original text.

$text = str_replace("\n", "", $text); # Strip linefeeds
$done = "false";
$newtext = "";
$start = 0; # Initialize starting position
$segment = substr($text, $start, $wordsize + 1); # Initialize first segment

while ($done == "false") { # Parse text

	$lastspace = strrpos($segment, " ");
	$lastbreak = strrpos($segment, "\r");

	if ( $lastspace == "" AND $lastbreak == "" ) { # Break segment
		$newtext .= substr($text, $start, $wordsize) . " ";
		$start = $start + $wordsize; }
	else { # Move start to last space or break
		$last = max($lastspace, $lastbreak);
		$newtext .= substr($segment, 0, $last + 1);
		$start = $start + $last + 1;
	} # End If - Break segment

	$segment = substr($text, $start, $wordsize + 1);

	if ( strlen($segment) <= $wordsize ) { # Final segment is smaller than word size.
		$newtext .= $segment;
		$done = "true";
	} # End If - Final segment is smaller than word size.

} # End While - Parse text

$newtext = str_replace("\r", "\r\n", $newtext); # Replace linefeeds

return $newtext;

} # End of function - Word Break

// Error Handeling and entry checking -----------------------------------------------------------------------

echo "<center><h2>Links Page Entry Result:</h2></center>";

$yourname = $_POST['yourname'];
$youremail = $_POST['youremail'];
$yourlink = $_POST['yourlink'];
$yourmessage = $_POST['yourmessage'];

 $date = date("H:i, jS F");

if (strlen($yourname) > 40) 
{ 
$error .= "<br>The Name you specified is too long.";
}
if (strlen($youremail) > 40) 
{ 
$error .= "<br>The Email you specified is too long.";
}
if (strlen($yourlink) > 70) 
{ 
$error .= "<br>The Link you specified is too long.";
}
if (checkmail($youremail) != 1) 
{
$error .= "<br>Invalid Email. Entry Not Processed!";
}
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
include("footer.inc");
exit;
}
if ($error=="")
{

// Disable HTML Code in message body ---------------------------------------------------------------

// Check for http in front of the link ----------------------------------------------------
if ( $yourlink != "" ) { 
	if ( strtolower(substr($yourlink, 0, 7)) != "http://" ) { $yourlink = "http://" . $yourlink; } # Add http:// to link if not there
	if ( strtolower(substr($yourlink, 0, 14)) == "http://http://" ) { $yourlink =  substr($yourlink, 7); } # Remove "double" http://
} # End If - Check for URL

// Replacing Brackets to disable the insertion of HTML in the Links Page by Users

$yourmessage = wordbreak($yourmessage, 25);
$yourmessage = str_replace("<", "&lt", $yourmessage);
$yourmessage = str_replace(">", "&gt;", $yourmessage);
$yourmessage = str_replace("\n", "<br>", $yourmessage);

// Smiley face insertion into the message ------------------------------------------------------------

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

// Write the verified guestbook entry to file ----------------------------------------------------------

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