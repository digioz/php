<?php
header('content-type: text/html; charset: utf-8');
include("../config.php");
include("../includes/class.gbXML.php");
include("../includes/functions.php");
include('../includes/class.UBBCodeN.php');
include('gbClass.php');

$filename = "list.txt";
$handle = fopen($filename, "r");

if (filesize("data.xml") == 0)
{
    $xml_header = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n<messages>\n";
    $fp = fopen('data.xml', 'w');
	fwrite($fp, $xml_header);
	fclose($fp);
}
else
{
	//Do nothing
}
if (filesize($filename) == 0)
{                         
   print "Nothing to convert"; 
}
else
{
    $datain = fread($handle, filesize($filename));
    fclose($handle);
    $out = explode("<!-- E -->", $datain);
    $outCount = count($out) - 1;
    $j = 0;
    
    for ($i=0; $i<=$outCount; $i++)
    {
        if (unserialize($out[$i]) != FALSE)
        {
            $lines[$j] = unserialize($out[$i]);
            $j++;
        }
    }
    
    // Make user input safe, insert emoticons, and encode UBB code -------------------------------------
    function formatMessage($mess)
    {
        $mess = stripcslashes($mess);
        $mess = html_entity_decode($mess, ENT_NOQUOTES, 'UTF-8');
        $mess = utf8_encode($mess);
        return $mess;
    }
    for ($i=0; $i<count($lines); $i++)
    {
        $gbXML = new gbXML('messages', 'message', 'data.xml');
        $id = $gbXML->get_max_value_for_tag('id');
        ++$id;
        $myUBB = new UBBCodeN();
        
        $tmpArray = array ('id' => $id,
            'date' => $lines[$i]->showDate(),
            'name' => formatMessage($lines[$i]->showFrom()),
            'email' => $lines[$i]->showEmail(),
            'msg' => formatMessage($lines[$i]->showMessage())
            ); 
        if ($gbXML->append_record_to_file($tmpArray) === TRUE) 
        {
            // Add code to display progress
        }
    }
    
    echo "Conversion is complete.";
}

?>
