<?php
header("Content-Type: application/rss+xml; charset=UTF-8"); 

// Open RSS
$rssfeed = '<?xml version="1.0" encoding="UTF-8" ?>';
$rssfeed .= '<rss version="2.0">';
$rssfeed .= '<channel>';
$rssfeed .= '<title>DigiOz Guestbook</title>';
$rssfeed .= '<link>http://www.digioz.com</link>';
$rssfeed .= '<description>RSS Feed for DigiOz Guestbook</description>';
$rssfeed .= '<language>en-us</language>';
$rssfeed .= '<copyright>Copyright (C) 2015 DigiOz Multimedia, Inc</copyright>';
echo $rssfeed;

$rssfeed = '';

// App context
define('IN_GB', TRUE);
include("includes/config.php");
include("includes/functions.php");
include("includes/gb.class.php");

// Read entries using decrypt-aware helper
$filename = "data/list.txt";
$datain = readDataFile($filename);

$entries = array();
if ($datain !== '') {
    $chunks = explode("<!-- E -->", $datain);
    foreach ($chunks as $chunk) {
        $chunk = trim($chunk);
        if ($chunk === '') continue;

        $data = json_decode($chunk, true);
        $obj = null;
        if (is_array($data)) {
            $obj = gbClass::fromArray($data);
        } else {
            $legacy = @unserialize($chunk, ["allowed_classes" => ["gbClass"]]);
            if ($legacy instanceof gbClass) { $obj = $legacy; }
        }
        if ($obj) { $entries[] = $obj; }
    }

    // Newest first
    $entries = array_reverse($entries);

    // Build items
    foreach ($entries as $e) {
        $from = isset($e->gbFrom) ? $e->gbFrom : '';
        $msg = isset($e->gbMessage) ? $e->gbMessage : '';
        $date = isset($e->gbDate) ? (int)$e->gbDate : time();

        // Escape for XML, then convert newlines to <br/>
        $tmpMsg = htmlspecialchars($msg, ENT_QUOTES | ENT_XML1 | ENT_SUBSTITUTE, 'UTF-8');
        $tmpMsg = str_replace(["\r\n", "\r", "\n"], "<br />", $tmpMsg);

        $rssfeed .= '<item>';
        $rssfeed .= '<title>' . htmlspecialchars($from, ENT_QUOTES | ENT_XML1, 'UTF-8') . '</title>';
        $rssfeed .= '<description>' . $tmpMsg . '</description>';
        $rssfeed .= '<link>rss.php</link>';
        $rssfeed .= '<pubDate>' . date(DATE_RSS, $date) . '</pubDate>';
        $rssfeed .= '</item>';
    }
}

// Close RSS
$rssfeed .= '</channel>';
$rssfeed .= '</rss>';

echo $rssfeed;
?>


