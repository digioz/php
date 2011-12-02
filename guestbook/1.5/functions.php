<?php

// Check to see if email address is valid --------------------------------
function checkmail($youremail)
{
        if (ereg('^[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+'.'@'.'[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\.'.
        '[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$', $youremail)) 
        {
	        return true;
         } 
         else 
         {
	        return false;
         }
}

// Smiley face insertion function --------------------------------------

function smiley_face($yourmessage)
{
 $i = 0;
 $rep1 = array( "<", ">", "\n" );
 $rep2 = array( "&lt;", "&gt;", "<br>" );
 $ubb1 = array( "[b]", "[B]", "[/b]", "[/B]", "[u]", "[U]", "[/u]", "[/U]", "[i]", "[I]", "[/i]", "[/I]", "[center]", "[CENTER]", "[/center]", "[/CENTER]" );
 $ubb2 = array( "<b>", "<B>", "</b>", "</B>", "<u>", "<U>", "</u>", "</U>", "<i>", "<I>", "</i>", "</I>", "<center>", "<CENTER>", "</center>", "</CENTER>" );
 $sm1  = array( ":?:", ":D", ":?", "8)", ":cry:", ":shock:", ":evil:", ":!:", ":frown:", ":idea:", ":arrow:", ":lol:", ":x", ":mrgreen:", ":|", ":P", ":oops:", ":roll:", ":(", ":)", ":o", ":twisted:", ":wink:" );
 $sm2  = array( "question", "biggrin", "confused", "cool", "cry", "eek", "evil", "exclaim", "frown", "idea", "arrow", "lol", "mad", "mrgreen", "neutral", "razz", "redface", "rolleyes", "sad", "smile", "surprised", "twisted", "wink" );
 $sm3  = array( ": ?:", ":D", ":?", "8)", ":cry:", ":shock:", ":evil:", ":!:", ":frown:", ":idea:", ":arrow:", ":lol:", ":x", ":mrgreen:", ":|", ":P", ": oops :", ":roll:", ":(", ":)", ":o", ":twisted:", ":wink:" );

         // Disable HTML Code in message body ---------------------------------------------------------------
         // Replacing Brackets to disable the insertion of HTML in the Guestbook and breaking long words
         $yourmessage = wordbreak($yourmessage, 40);

         for ($i=0; $i<=2; $i++)
         {
         	$yourmessage = str_replace($rep1[$i], $rep2[$i], $yourmessage);
         }

         // UBB Code Insertion ---------------------------------------------------------------------------------
         // Replacing UBB tags with the appropriate HTML tag
         
         for ($i=0; $i<=15; $i++)
         {
         	$yourmessage = str_replace($ubb1[$i], $ubb2[$i], $yourmessage);
         }

         // Inserting smiley faces for guestbook users

         for ($i=0; $i<=22; $i++)
         {
                $yourmessage = str_replace($sm1[$i], "<img src=\"images/icon_$sm2[$i].gif\" ALT=\"$sm3[$i]\">", $yourmessage);
         }
         return $yourmessage;
}

// Function to breakup log words in message -------------------------

function wordbreak($text, $wordsize) 
{

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




?>

