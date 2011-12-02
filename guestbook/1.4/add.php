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
echo "<center><h2>$addentryheadtxt</h2></center>";

$yourname = $_POST['yourname'];
$youremail = $_POST['youremail'];
$yourmessage = $_POST['yourmessage'];

 $date = date("H:i, jS F");

if (strlen($yourname) > 40) 
{ 
$error .= "<br>$error1";
}
if (strlen($youremail) > 40) 
{ 
$error .= "<br>$error2";
}
if (checkmail($youremail) != 1) 
{
$error .= "<br>$error3";
}
if (empty($yourname))
{
$error .= "$error4<br>";
}
if (empty($youremail))
{
$error .= "$error5<br>";
}
if (empty($yourmessage))
{
$error .= "$error6<br>";
}
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
// Disable HTML Code in message body ---------------------------------------------------------------
// Replacing Brackets to disable the insertion of HTML in the Guestbook and breaking long words
$yourmessage = wordbreak($yourmessage, 25);
$yourmessage = str_replace("<", "&lt", $yourmessage);
$yourmessage = str_replace(">", "&gt;", $yourmessage);
$yourmessage = str_replace("\n", "<br>", $yourmessage);

// UBB Code Insertion ---------------------------------------------------------------------------------
// Replacing UBB tags with the appropriate HTML tag
$yourmessage = str_replace("[b]", "<b>", $yourmessage);
$yourmessage = str_replace("[B]", "<B>", $yourmessage);
$yourmessage = str_replace("[/b]", "</b>", $yourmessage);
$yourmessage = str_replace("[/B]", "</B>", $yourmessage);

$yourmessage = str_replace("[u]", "<u>", $yourmessage);
$yourmessage = str_replace("[U]", "<U>", $yourmessage);
$yourmessage = str_replace("[/u]", "</u>", $yourmessage);
$yourmessage = str_replace("[/U]", "</U>", $yourmessage);

$yourmessage = str_replace("[i]", "<i>", $yourmessage);
$yourmessage = str_replace("[I]", "<I>", $yourmessage);
$yourmessage = str_replace("[/i]", "</i>", $yourmessage);
$yourmessage = str_replace("[/I]", "</I>", $yourmessage);

$yourmessage = str_replace("[center]", "<center>", $yourmessage);
$yourmessage = str_replace("[CENTER]", "<CENTER>", $yourmessage);
$yourmessage = str_replace("[/center]", "</center>", $yourmessage);
$yourmessage = str_replace("[/CENTER]", "</CENTER>", $yourmessage);


// Smiley face insertion into the message ------------------------------------------------------------

// Inserting smiley faces for guestbook users

$yourmessage = str_replace(":?:", "<img src=\"images/icon_question.gif\" ALT=\": ?\">", $yourmessage);
$yourmessage = str_replace(":D", "<img src=\"images/icon_biggrin.gif\" ALT=\":D\">", $yourmessage);
$yourmessage = str_replace(":?", "<img src=\"images/icon_confused.gif\" ALT=\":?\">", $yourmessage);
$yourmessage = str_replace("8)", "<img src=\"images/icon_cool.gif\" ALT=\"8)\">", $yourmessage);
$yourmessage = str_replace(":cry:", "<img src=\"images/icon_cry.gif\" ALT=\":cry:\">", $yourmessage);
$yourmessage = str_replace(":shock:", "<img src=\"images/icon_eek.gif\" ALT=\":shock:\">", $yourmessage);
$yourmessage = str_replace(":evil:", "<img src=\"images/icon_evil.gif\" ALT=\":evil:\">", $yourmessage);
$yourmessage = str_replace(":!:", "<img src=\"images/icon_exclaim.gif\" ALT=\":!:\">", $yourmessage);
$yourmessage = str_replace(":frown:", "<img src=\"images/icon_frown.gif\" ALT=\":frown:\">", $yourmessage);
$yourmessage = str_replace(":idea:", "<img src=\"images/icon_idea.gif\" ALT=\":idea:\">", $yourmessage);
$yourmessage = str_replace(":arrow:", "<img src=\"images/icon_arrow.gif\" ALT=\":arrow:\">", $yourmessage);
$yourmessage = str_replace(":lol:", "<img src=\"images/icon_lol.gif\" ALT=\":lol:\">", $yourmessage);
$yourmessage = str_replace(":x", "<img src=\"images/icon_mad.gif\" ALT=\":x\">", $yourmessage);
$yourmessage = str_replace(":mrgreen:", "<img src=\"images/icon_mrgreen.gif\" ALT=\":mrgreen:\">", $yourmessage);
$yourmessage = str_replace(":|", "<img src=\"images/icon_neutral.gif\" ALT=\":|\">", $yourmessage);
$yourmessage = str_replace(":P", "<img src=\"images/icon_razz.gif\" ALT=\":P\">", $yourmessage);
$yourmessage = str_replace(":oops:", "<img src=\"images/icon_redface.gif\" ALT=\": oops :\">", $yourmessage);
$yourmessage = str_replace(":roll:", "<img src=\"images/icon_rolleyes.gif\" ALT=\":roll:\">", $yourmessage);
$yourmessage = str_replace(":(", "<img src=\"images/icon_sad.gif\" ALT=\":(\">", $yourmessage);
$yourmessage = str_replace(":)", "<img src=\"images/icon_smile.gif\" ALT=\":)\">", $yourmessage);
$yourmessage = str_replace(":o", "<img src=\"images/icon_surprised.gif\" ALT=\":o\">", $yourmessage);
$yourmessage = str_replace(":twisted:", "<img src=\"images/icon_twisted.gif\" ALT=\":twisted:\">", $yourmessage);
$yourmessage = str_replace(":wink:", "<img src=\"images/icon_wink.gif\" ALT=\":wink:\">", $yourmessage);

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

  $outputstring = "<b>$listDatetxt:</b> ".$date."<br><b>$listnametxt:</b> ".$yourname."<br><b>$listemailtxt:</b> <a href=mailto:$youremail>".$youremail."</a><br><br><b>$listMessagetxt:</b> ".$yourmessage."<hr>\n";


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