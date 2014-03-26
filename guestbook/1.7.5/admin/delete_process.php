<?php

// Begin Login Verification --------------------------------------------

define('IN_GB', TRUE);

session_start();

include("login_check.php");
include("includes/header.php"); 

include("../includes/gb.class.php");
include("../includes/config.php");
include("../language/$default_language");

$order= isset($_GET['order']) ? $_GET['order'] : "";

?>

<center>

<?php

$id = $_GET['id'];

// Validate browser input ------------------------------------------------------------

if (is_numeric($id) == false)
{
  echo "<font color=\"red\">Non Numeric ID Number.</font>";
  echo "<p>&nbsp;</p>";
  echo "<p>";
  echo "<center>";
  echo "      <a href=\"index.php\"><font color=\"red\"><b>Admin Main</b></font></a> -";
  echo "      <a href=\"login.php?mode=logout\"><font color=\"red\"><b>Logout</b></font></a>";
  echo "</center></p>";
  echo "</body>";
  echo "</html>";
  exit;
}

if (!($order == "asc" || $order == "desc" || $order == ""))
{
  echo "<font color=\"red\">Entry order can only be 'asc' or 'desc'</font>";
  echo "<p>&nbsp;</p>";
  echo "<p>";
  echo "<center>";
  echo "      <a href=\"index.php\"><font color=\"red\"><b>Admin Main</b></font></a> -";
  echo "      <a href=\"login.php?mode=logout\"><font color=\"red\"><b>Logout</b></font></a>";
  echo "</center></p>";
  echo "</body>";
  echo "</html>";
  exit;
}

// Reading in all the records, putting each guestbook entry in one Array Element -----

$filename = "../data/list.txt";
$handle = fopen($filename, "r");
$datain = fread($handle, filesize($filename));
fclose($handle);
$out = explode("<!-- E -->", $datain);

$outCount = count($out) - 1;
$j = $outCount-1;

if ($order == "desc")
{
    for ($i=0; $i<=$outCount; $i++)
    {
        $lines[$j] = unserialize($out[$i]);
        $j = $j - 1;
    }
}
else
{
    for ($i=0; $i<=$outCount; $i++)
    {
        $lines[$i] = unserialize($out[$i]);
    }
}

// Lets Clear the output text file first

@ $fp = fopen("../data/list.txt","w");
flock($fp, 2);
fwrite($fp, "");
flock($fp, 3);
fclose($fp);

// Now that we have all the entries in an array, lets take out the one entry that the user wants deleted

for ($i=0; $i<$outCount; $i++)
{
  if ($i != $id)
  {
     @ $fp = fopen("../data/list.txt","a");
     flock($fp, 2);
     $data = serialize($lines[$i])."<!-- E -->";
     fwrite($fp, $data);
     flock($fp, 3);
     fclose($fp);
  }
}


?>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>

         <a href="index.php"><center><b><font color="red">Message Deleted!</font></center></b></a><br><br>
         <a href="index.php"><center><b><font color="black">Back to Delete Menu</font></center></b></a><br>
		 
<p>&nbsp;</p>
<p>&nbsp;</p>
</center>

<?php
include ("includes/footer.php");
?>


