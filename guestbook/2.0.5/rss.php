<?php
header("Content-Type: application/rss+xml; charset=UTF-8"); 
$rssfeed = '<?xml version="1.0" encoding="ISO-8859-1" ?>';
$rssfeed .= '<rss version="2.0">';
$rssfeed .= '<channel>';
$rssfeed .= '<title>DigiOz Guestbook</title>';
$rssfeed .= '<link>http://www.digioz.com</link>';
$rssfeed .= '<description>RSS Feed for DigiOz Guestbook</description>';
$rssfeed .= '<language>en-us</language>';
$rssfeed .= '<copyright>Copyright (C) 2015 DigiOz Multimedia, Inc</copyright>';
echo $rssfeed;

$rssfeed = '';

define('IN_GB', TRUE);
include("includes/gb.class.php");
include("includes/config.php");

$filename = "data/list.txt";
$handle = fopen($filename, "r");

if (filesize($filename) != 0)
{
	$datain = fread($handle, filesize($filename));
	fclose($handle);
	$out = explode("<!-- E -->", $datain);

	$outCount = count($out) - 1;
	$j = $outCount-1;
    

	for ($i=0; $i<=$outCount; $i++)
	{
		$lines[$j] = unserialize($out[$i]);
		$j = $j - 1;
	}

	// Counting the total number of entries (lines) in the data text file --------

	$result = count($lines);
	$count = $result-1;
	
	// Display guestbook entries --------------------------------------------------

	for ($i=0; $i<$count; $i++)
	{
        $tmpMsg = $lines[$i]->gbMessage;
        $tmpMsg = str_replace("<", "&lt;", $tmpMsg);
        $tmpMsg = str_replace(">", "&gt;", $tmpMsg);
        $tmpMsg = str_replace("\n", "<br />", $tmpMsg);
        $tmpMsg = str_replace("\r", "<br />", $tmpMsg);
        
        $rssfeed .= '<item>';
        $rssfeed .= '<title>' . $lines[$i]->gbFrom . '</title>';
        $rssfeed .= '<description>' . $tmpMsg . '</description>';
        $rssfeed .= '<link>rss.php</link>';
        $rssfeed .= '<pubDate>' . $lines[$i]->gbDate . '</pubDate>';
        $rssfeed .= '</item>';
	}
}

$rssfeed .= '</channel>';
$rssfeed .= '</rss>';

echo $rssfeed;
?>


