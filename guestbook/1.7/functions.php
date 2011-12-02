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
 $ubb1 = array( "[b]", "[B]", "[/b]", "[/B]", "[u]", "[U]", "[/u]", "[/U]", "[i]", "[I]", "[/i]", "[/I]", "[center]", "[CENTER]", "[/center]", "[/CENTER]" );
 $ubb2 = array( "<b>", "<B>", "</b>", "</B>", "<u>", "<U>", "</u>", "</U>", "<i>", "<I>", "</i>", "</I>", "<center>", "<CENTER>", "</center>", "</CENTER>" );
 $sm1  = array( ":?:", ":D", ":?", ":cool:", ":cry:", ":shock:", ":evil:", ":!:", ":frown:", ":idea:", ":arrow:", ":lol:", ":x", ":mrgreen:", ":|", ":P", ":oops:", ":roll:", ":(", ":)", ":o", ":twisted:", ":wink:" );
 $sm2  = array( "question", "biggrin", "confused", "cool", "cry", "eek", "evil", "exclaim", "frown", "idea", "arrow", "lol", "mad", "mrgreen", "neutral", "razz", "redface", "rolleyes", "sad", "smile", "surprised", "twisted", "wink" );
 $sm3  = array( ": ?:", ":D", ":?", ":cool:", ":cry:", ":shock:", ":evil:", ":!:", ":frown:", ":idea:", ":arrow:", ":lol:", ":x", ":mrgreen:", ":|", ":P", ": oops :", ":roll:", ":(", ":)", ":o", ":twisted:", ":wink:" );

         // UBB Code Insertion and Replacing UBB tags with the appropriate HTML tag

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


// Message Cleanup function --------------------------------------

function clean_message($yourmessage)
{
 $i = 0;
 $rep1 = array( "<", ">", "\n", "'" );
 $rep2 = array( "&lt;", "&gt;", "<br>", "&#39;" );

         // Disable HTML Code in message body ---------------------------------------------------------------
         // Replacing Brackets to disable the insertion of HTML in the Guestbook and breaking long words
         $yourmessage = wordbreak($yourmessage, 40);

         for ($i=0; $i<=2; $i++)
         {
         	$yourmessage = str_replace($rep1[$i], $rep2[$i], $yourmessage);
         }
         
         $yourmessage = str_replace('"','&#34;', $yourmessage);

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

// Function to filter out bad words ------------------------------------------

function swapBadWords($string) 
{
  global $gbBadWords;

  // Count the number of array element of the bad word array
  $nBadWords = sizeof($gbBadWords);

  for ($i = 0; $i < $nBadWords; $i++) {

    // Grab the first letter of bad word
    $banned = substr($gbBadWords[$i], 0, 1);
    // Replace remaining letters of bad word
    for ($j = 1; $j < strlen($gbBadWords[$i]); $j++) {
      $banned .= "*";
    }
    // chars replaced with *.
    $string = str_replace($gbBadWords[$i], $banned, $string);
  }
  return $string;
}

// Function to detect if form submitted using injection ------------------------

function check_referer($referers)
{ 
  // If there are any referrers in the list ...
  if (count($referers))
  {
   $found = false;

   // Use the browsers referrer header.
   $temp = explode("/",getenv("HTTP_REFERER"));
   $referer = $temp[2];

   if ($referer=="")
   {
      $referer = $_SERVER['HTTP_REFERER'];
      list($remove,$stuff)=split('//',$referer,2);
      list($home,$stuff)=split('/',$stuff,2);
      $referer = $home;
   }

   // Check agains list.
   for ($x=0; $x < count($referers); $x++)
   {
       if (eregi ($referers[$x], $referer))
       {
          $found = true;
       }
   }

   // Refererer is blank.
   if ($referer =="")
   $found = false;

   if (!$found)
   {
      // You might alter this to print some sort of error of your own.
      echo "<b>You are submitting entry from an <b>unauthorized domain.</b><br><br>";
   }

   return $found;

   }
   else
   {
      return true;
   }
}

// Function to detect spam keywords ------------------------------------------

function spamDetect($string)
{
  global $gbSpam;

  // Count the number of array element of the bad word array
  $nSpam = sizeof($gbSpam);
  
  $tmpString = str_replace(" ", "", $string);
  $tmpString = strtolower($tmpString);

  for ($i = 0; $i < $nSpam; $i++) 
  {
      $cSpam += substr_count($tmpString, $gbSpam[$i]);
  }
  
  if ($cSpam > 0)
  {
    return true;
  }
  else
  {
    return false;
  }

}

?>

