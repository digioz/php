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
                $yourmessage = str_replace($sm1[$i], "<img src=\"images/icon_$sm2[$i].gif\" ALT=\"$sm3[$i]\"/>", $yourmessage);
         }
         return $yourmessage;
}



/**
 * clean_encode_message
 *
 * clean message or potentially dangerous (X)HTML and encode UBB to XHTML
 *
 *  @author 		DigiOz Guestbook, Scott Trevithick
 *  @copyright 	    DigiOz.com, 2009.
 *  @param 		    string 	$yourmessage  The string to reformat
 *  @return 		string  $yourmessage  The reformatted string
 **/
function clean_encode_message($yourmessage)
{

    require_once('class.UBBCodeN.php');
    $myUBB = new UBBCodeN();

    $yourmessage = $myUBB->encode($yourmessage);

  //  $yourmessage = str_replace('"','&#34;', $yourmessage);
    $yourmessage = entify_nonprinting_chars($yourmessage);

    return $yourmessage;
}

/**
 * entify_nonprinting_chars
 *
 * Replace \n, \r\n in message with html <br />
 * Replace \t with 4 &nbsp;s
 *
 * @author 		DigiOz Guestbook, Scott Trevithick
 * @copyright 	DigiOz.com, 2009.
 * @param 		string 	$str  The string to reformat
 * @return 		string  $new  The reformatted string
 */
function entify_nonprinting_chars($text)
{
    $text = str_replace("\r\n", "<br />", $text);
    $text = str_replace("\n", "<br />", $text);
    $text = str_replace("\r", "<br />", $text); //unnecessary b/c of wordbreak, but included for completeness
    $text = str_replace("\t", "&nbsp;&nbsp;&nbsp;&nbsp;", $text);

    return $text;
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

/**
 * swap_bad_words()
 *
 * replace, in a case insensitive way, the "bad words"
 * listed in config.php gbBadWords with asterisked versions
 * of them: badword => b******
 *
 * We use the /i switch for case insentivity and the /u
 * switch for compatibility with UTF-8.
 *
 * @author 		DigiOz Guestbook, Scott Trevithick
 * @copyright 	DigiOz.com, 2009.
 * @param 		string 	$string  The string to clean up
 * @return 		string  $string  The cleaned up string
 */

function swap_bad_words($string)
{
    global $gbBadWords;

    foreach ($gbBadWords as $bad_word)
    {
        $pattern = '/(\W|^)(' . $bad_word . ')(\W|$)/iu';

        //just get the first letter of bad_word into good_word
        $good_word = substr($bad_word, 0, 1);

        //fill out good_word with *s
        for ($i = 1; $i < strlen($bad_word); $i++)
        {
            $good_word .= '*';
        }
        //we replace the bad_word with good word including anything immediately adjacent
        //such as a comma, space, period or start/end of string.
        $replacement = '$1' . $good_word . '$3';
        $string = preg_replace($pattern, $replacement, $string);
    }

    //convert back to UTF-8
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
  $cSpam = 0;

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

/**
 * show page links
 *
 * Show links to pages of records in the address book
 * Show up to 10 links on a page. Show << for preceding
 * pages available and >> for succeeding pages available.
 *
 * << points to one less than the current page (shifting us left)
 * >> points to one more than the current page (shifting us right)
 *
 * @author 		DigiOz Guestbook, Scott Trevithick
 * @copyright 	DigiOz.com, 2009.
 * @param 		string 	$base_url   The url for the page including sort order
 * @param       numeric $num_items  The number of records in total
 * @param       numeric $per_page   The number of records that are displayed on each page
 * @param       numeric $page       The number of the current page
 * @return 		string  $new  The ascii version of $str
 */
function show_page_links($base_url, $num_items, $per_page, $page)
{
    //$base_url contains the address of the page and the order it is called with
    //e.g., 'asc' or 'desc' - the page handles this so we have to worry about it.

    $total_pages = ceil($num_items/$per_page);

    if ($total_pages == 1)
    {
        return '';
    }

    //initialize our $page_string variable wich will hold the links
    $page_string = '<p><span class="page_numbers">';

    //SHOW UP TO 4 LINKS ON EITHER SIDE OF THE CURRENT PAGE

    //get the number of page links are available after the current page
    $num_succeeding_links = $total_pages - $page;

    //get the number of preceding links available before the current page
    $num_preceding_links = $page -1;

    //calculate our start and end values
    $start = $page - 4;
    if ( $start < 1)
    {
        $start = 1;
    }
    //if we have less than 10 total_page, use the number we have ($total_pages)
    $end = $total_pages;
    //but if end is more than 9 higher than $start, make $end 9 higher than $start
    //we only want to show 10 records per page (e.g., 1..10)
    if ( ($end - $start) > 9 )
    {
        $end= $start + 9;
    }

    //if the total number of succeeding links exceeds 4 show 4 and a >> at the end
    //the >> at the end is just the 5th succeeding link
    //do the same for preceding links if they are more than 4
    if ($total_pages > 10 && $page > 1) //don't show first page link except when we're not the first page
    {
        //create a << which points to the first page
        $page_string .= '<a title="first page" href="'.$base_url.'&page=1">&lt;&lt;</a>&nbsp;&nbsp;';
        //create a < which points to the current page -1 (shifts us left one)
        $val = $page-1;
        $page_string .= '<a title="previous page" href="'.$base_url.'&page='.$val.'">&lt;</a>&nbsp;&nbsp;';
    }
    for ($i=$start; $i<=$end; $i++)
    {
        if ($i == $page)
        {
            $page_string .= " <b>[$i]</b> ";
        }
        else
        {
            $page_string .= ' <a title="page ' . $i . '" href="'.$base_url.'&page='.$i.'">'.$i.'</a> ';
        }
    }
    if ($total_pages > 10 && $page < $total_pages) //don't show last page link except when we're not on the last page
    {
        //create a > which points to the current page +1 (shifts us right one)
        $val = $page + 1;
        $page_string .= '&nbsp;&nbsp;<a title="next page" href="'.$base_url.'&page='.$val.'">&gt</a>';

        //create a >> which point to the last page
        $page_string .= '&nbsp;&nbsp;<a title="last page" href="'.$base_url.'&page='.$total_pages.'">&gt;&gt</a> ';
    }

    $page_string .= '</span></p>';

    return $page_string;

}

/**
 * Text To Ascii
 *
 * We loop through the given string ($str), accessing each
 * character in the string via $str[index], getting it's
 * ASCII value by using ord(). We then build the string again
 * with the new values.
 *
 * @author 		DigiOz Guestbook, Mark Skilbeck (http://mahcuz.com)
 * @copyright 	DigiOz.com, 2009.
 * @param 		string 	$str  The string the encode
 * @return 		string  $new  The ascii version of $str
 */
function text_to_ascii ($str)
{
	# Our empty new string.
	$new = '';

	# String length (minus one, for looping.)
	$strlen = (strlen($str) - 1);

	# Now loop through, using a for-loop.
	for ($i = 0; $i <= $strlen; ++$i)
	{
		$ascii = ord($str[$i]);
		# Assign a new value.
		$new .= "&#{$ascii};";
	}

	return $new;
}

/**
 * Ascii To Text
 *
 * Complements text_to_ascii()
 *
 * @author 		DigiOz Guestbook, Mark Skilbeck (http://mahcuz.com)
 * @copyright 	DigiOz.com, 2009.
 * @param 		string 	$str  The string to decode
 * @return 		string  $new  The text version of $str
 */
function ascii_to_text ($str)
{
	# Empty string to build up.
	$new = '';

	# The pattern used in preg_match. Searches for &#<3 letters/numbers/mix of>;
	$pattern = '/&#([a-zA-Z0-9]+){1,3};/';

	# Match all occurences of pattern, and store in array $matches
	preg_match_all($pattern, $str, $matches);

	# Traverse the $matches array, using chr() to convert them back.
	foreach ($matches[1] as $ascii)
	{
		$new .= chr($ascii);
	}

	return $new;
}

/**
 * display_email()
 *
 * To avoid cluttering gbClass:getEmail(), we provide a
 * function that returns the email in the correct display type
 * depending on the settings.
 *
 * Furthermore, if $no_image is set to TRUE, it will not return
 * the email as an image, regardless of whether $email_display = 2.
 * This is to prevent us outputting an image inside a mailto() link.
 *
 * @author 		DigiOz Guestbook, Mark Skilbeck (http://mahcuz.com)
 * @copyright 	DigiOz.com, 2009.
 * @param 		string 	$email 		Email to return
 * @param		bool	$no_image	Override image display.
 * @return
 */
function display_email ($email, $no_image=FALSE, $img_src_path='includes/')
{
	global $email_display;

	# Email setting wants an image returned.
	if ($email_display === 2)
	{
		# TODO: Check $image_verify (should this function only work if $image_verify = 1?)
		# Do we want the image overriding?
		if ($no_image)
		{
			return text_to_ascii($email);
		}
		else
		{
			# Encode it with urlencode() (to prevent any errors)
			# and text_to_ascii() (to prevent bots from reading it)
			$email = urlencode(text_to_ascii($email));
			return "<img style='border: none' src='{$img_src_path}email_image.php?email={$email}' />";
		}
	}
	# Email setting wants ASCII returned.
	elseif ($email_display === 1)
	{
		return text_to_ascii($email);
	}
	# Email setting wants plain text returned.
	else
	{
		return $email;
	}
}

/* swap_image
* Swap image html tag to the ALT tag
*/
function swap_image($msg){

	if(preg_match("/\[img ALT=('|\")(.*?)('|\")\]([^\[]*)\[\/img\]/i",$msg)){
		$msg=preg_replace("/\[img ALT=('|\")(.*?)('|\")\]([^\[]*)\[\/img\]/i","$2",$msg);
	}

return $msg;
}
?>
