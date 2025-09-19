<?php

// Begin Login Verification --------------------------------------------

define('IN_GB', TRUE);

session_start();

$pageTitle = "Delete Guestbook Entry"; 

include("login_check.php");
include("../includes/config.php");
include("includes/header.php"); 
include("../includes/functions.php");
include("../includes/gb.class.php");

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
$datain = readDataFile($filename);
$out = explode("<!-- E -->", $datain);

$lines = [];
for ($i=0; $i<count($out)-1; $i++) {
    $raw = trim($out[$i]); if ($raw==='') continue;
    $data = json_decode($raw, true);
    if (is_array($data)) { $lines[] = gbClass::fromArray($data); }
}

if ($order == "desc") {
    $lines = array_values(array_reverse($lines));
}

// Now that we have all the entries in an array, lets take out the one entry that the user wants deleted

$datanew = "";
for ($i=0; $i<count($lines); $i++)
{
  if ($i != $id)
  {
     $datanew .= json_encode($lines[$i])."<!-- E -->";
  }
}

writeDataFile($filename, $datanew);

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


