//////////////////////////////////////////////////////////
///  The purpose of this script is to convert the list.txt
///  data from the old format (which was used for DigiOz
///  Guestbook 1.0 to 1.6 to the new Object Oriented 
///  Serialized format used in Guestbook Version 1.7.
//////////////////////////////////////////////////////////


<?php
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
  $value = str_replace("<b>Date:</b>", "|", $value); 
  $value = str_replace("<br><b>From:</b>", "|", $value); 
  $value = str_replace("<br><b>Email: </b>", "|", $value); 
  $value = str_replace("<br><br><b>Message:</b>", "|", $value); 
  $msgArray = explode("|", $value); 
  $tmpDate = $msgArray[1]; 
  $tmpFrom = $msgArray[2]; 
  $tmpEmail = $msgArray[3]; 
  $tmpMessage = $msgArray[4]; 
  
  $tmpEmail = str_replace('"','"', $tmpEmail); 
  $tmpEmail = str_replace("'","'", $tmpEmail); 

  
  $tmpFrom = strip_tags($tmpFrom); 
  $tmpFrom = str_replace('"','"', $tmpFrom); 
  $tmpFrom = str_replace("'","'", $tmpFrom); 
  
  $tmpMessage = strip_tags($tmpMessage); 
  $tmpMessage = str_replace('"','"', $tmpMessage); 
  $tmpMessage = str_replace("'","'", $tmpMessage); 

  if($tmpDate != "" && $tmpFrom != "" && $tmpEmail != "" && $tmpMessage != "") 
  { 
       //echo "DATE: ".$tmpDate."<br>"; 
       //echo "FROM: ".$tmpFrom."<br>"; 
       //echo "EMAIL: ".$tmpEmail."<br>"; 
       //echo "MESSAGE: ".$tmpMessage."<br>"; 

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

