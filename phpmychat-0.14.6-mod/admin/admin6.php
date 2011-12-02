<?php

// View List of Current Chat (HIDDEN and VISIBLE) -------------------------------------------------------------

// Credit for this goes to Pete Soheil <webmaster@digioz.com>.
$conn = mysql_connect(C_DB_HOST, C_DB_USER, C_DB_PASS) or die ('<center>Error: Could Not Connect To Database');
mysql_select_db(C_DB_NAME);

$sql = "SELECT * FROM `c_messages` ORDER BY `m_time` DESC;";

$query = mysql_query($sql) or die("Cannot query the database.<br>" . mysql_error());

echo "<table border=\"0\" cellpadding=\"1\" cellspacing=\"1\" width=\"800\" CLASS=table>";

while($result = mysql_fetch_array($query)) 
{

$username = stripslashes($result["username"]);
$address = stripslashes($result["address"]);
$message = stripslashes($result["message"]);
$detail = stripslashes($result["detail"]);
$category = stripslashes($result["category"]);
$updated = stripslashes($result["updated"]);

echo "<tr bgcolor=\"#FFFFFF\"><td width=150> <b>$username</b> - <b>$address</b> : </td><td> $message </td></tr>";
}

echo "</table><br>";

?>

