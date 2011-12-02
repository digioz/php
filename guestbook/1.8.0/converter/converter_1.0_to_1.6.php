<?php

////////////////////////////////////////////////////////////
///  Author:      Pete Soheil
///               DigiOz Multimedia
///               www.digioz.com
///  Revised:     01/02/07
///  Support:     Visit www.digioz.com/bb for support.
///  Description: The purpose of this script is to convert
///               the list.txt data from the old format 
///               (which was used for DigiOz Guestbook 1.0 
///               through 1.6) to the new Object Oriented 
///               Serialized format in Guestbook Version 1.7
///               or higher.
////////////////////////////////////////////////////////////

////////////////////////////////////// 
/// Function to reverse smiley face 
/// and style formatting in messages 
////////////////////////////////////// 

function smiley_face_undo($yourmessage) 
{ 
 $i = 0; 
 $ubb1 = array( "[b]", "[B]", "[/b]", "[/B]", "[u]", "[U]", "[/u]", "[/U]", "[i]", "[I]", "[/i]", "[/I]", "[center]", "[CENTER]", "[/center]", "[/CENTER]" ); 
 $ubb2 = array( "<b>", "<B>", "</b>", "</B>", "<u>", "<U>", "</u>", "</U>", "<i>", "<I>", "</i>", "</I>", "<center>", "<CENTER>", "</center>", "</CENTER>" ); 
 $sm1  = array( ":?:", ":D", ":?", ":cool:", ":cry:", ":shock:", ":evil:", ":!:", ":frown:", ":idea:", ":arrow:", ":lol:", ":x", ":mrgreen:", ":|", ":P", ":oops:", ":roll:", ":(", ":)", ":o", ":twisted:", ":wink:" ); 
 $sm2  = array( "question", "biggrin", "confused", "cool", "cry", "eek", "evil", "exclaim", "frown", "idea", "arrow", "lol", "mad", "mrgreen", "neutral", "razz", "redface", "rolleyes", "sad", "smile", "surprised", "twisted", "wink" ); 
 $sm3  = array( ": ?:", ":D", ":?", ":cool:", ":cry:", ":shock:", ":evil:", ":!:", ":frown:", ":idea:", ":arrow:", ":lol:", ":x", ":mrgreen:", ":|", ":P", ": oops :", ":roll:", ":(", ":)", ":o", ":twisted:", ":wink:" ); 

         // UBB Code Removal and Replacing HTML tags with the appropriate UBB tag 

         for ($i=0; $i<=15; $i++) 
         { 
            $yourmessage = str_replace($ubb2[$i], $ubb1[$i], $yourmessage); 
         } 

         // Removing smiley faces for guestbook entries 

         for ($i=0; $i<=22; $i++) 
         { 
                $yourmessage = str_replace("<img src=\"images/icon_$sm2[$i].gif\" ALT=\"$sm3[$i]\">", $sm1[$i], $yourmessage); 
         } 
         return $yourmessage; 
} 

////////////////////////////////////// 
/// Main Body of the Converter Script 
////////////////////////////////////// 

include("../config.php");
include("../language/".$default_language);
include("../gbclass.php");

$fd = fopen ("list.txt", "r"); 
while (!feof ($fd)) 
{ 
$buffer = fgets($fd, 4096); 
$lines[] = $buffer; 
} 
fclose ($fd); 

$countLines = count($lines); 
//echo $countLines; 

foreach ($lines as $value) 
{ 
  // Find each part of the entry 
  $value = str_replace("<b>".$listDatetxt.":</b>", "|", $value);
  $value = str_replace("<br><b>".$listnametxt.":</b>", "|", $value);
  $value = str_replace("<br><b>".$listemailtxt.": </b>", "|", $value); 
  $value = str_replace("<br><br><b>".$listMessagetxt.":</b>", "|", $value);
  $value = smiley_face_undo($value); 

  $msgArray = explode("|", $value); 
  $tmpDate = $msgArray[1]; 
  $tmpFrom = $msgArray[2]; 
  $tmpEmail = $msgArray[3]; 
  $tmpMessage = $msgArray[4]; 
  
  $tmpEmail = str_replace('"','"', $tmpEmail); 
  $tmpEmail = str_replace("'","'", $tmpEmail); 
  $tmpEmail = strip_tags($tmpEmail); 

  
  $tmpFrom = strip_tags($tmpFrom); 
  $tmpFrom = str_replace('"','"', $tmpFrom); 
  $tmpFrom = str_replace("'","'", $tmpFrom); 
  
  $tmpMessage = strip_tags($tmpMessage, "<br>"); 
  $tmpMessage = str_replace('"','"', $tmpMessage); 
  $tmpMessage = str_replace("'","'", $tmpMessage);
  
  if ($tmpEmail == "")
  {
    $tmpEmail = "xx@yy.zz";
  }

  if($tmpDate != "" && $tmpFrom != "" && $tmpEmail != "" && $tmpMessage != "") 
  {
       if ($tmpEmail == "xx@yy.zz")
       {
          $tmpEmail = "";
       }

       $a = new gbClass();
       $a->setGBVars($tmpDate,$tmpFrom,$tmpEmail,$tmpMessage); 
       @ $fp = fopen("list_converted.txt","a"); 
       flock($fp, 2); 
       $data = serialize($a)."<!-- E -->"; 
       fwrite($fp, $data); 
       flock($fp, 3); 
       fclose($fp);
  }
} 

echo "<b>Guestbook Entry Conversion Completed!</b>"; 

?> 
