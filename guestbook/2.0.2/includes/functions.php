<?php

if(!defined('IN_GB')) {
   die('Direct access not permitted');
}

// Check to see if email address is valid --------------------------------
function checkmail($youremail)
{
	$youremail_clean = stripslashes(trim($youremail));
	$pattern = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';
	
	if (preg_match($pattern, $youremail_clean) === 1) 
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

	while ($done == "false") 
	{
		$lastspace = strrpos($segment, " ");
		$lastbreak = strrpos($segment, "\r");

		if ( $lastspace == "" AND $lastbreak == "" ) 
		{
			$newtext .= substr($text, $start, $wordsize) . " ";
			$start = $start + $wordsize; 
		}
		else 
		{
			$last = max($lastspace, $lastbreak);
			$newtext .= substr($segment, 0, $last + 1);
			$start = $start + $last + 1;
		}

		$segment = substr($text, $start, $wordsize + 1);

		if ( strlen($segment) <= $wordsize ) 
		{
			$newtext .= $segment;
			$done = "true";
		}
	}

	$newtext = str_replace("\r", "\r\n", $newtext); # Replace linefeeds

	return $newtext;
}

// Function to filter out bad words ------------------------------------------

function swapBadWords($string) 
{
	global $gbBadWords;

	// Count the number of array element of the bad word array
	$nBadWords = sizeof($gbBadWords);

	for ($i = 0; $i < $nBadWords; $i++) 
	{
		// Grab the first letter of bad word
		$banned = substr($gbBadWords[$i], 0, 1);
		
		// Replace remaining letters of bad word
		for ($j = 1; $j < strlen($gbBadWords[$i]); $j++) 
		{
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
			if (preg_match ('/'.$referers[$x].'/', $referer))
			{
			  $found = true;
			}
		}

		// Refererer is blank.
		if ($referer =="")
		$found = false;

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

