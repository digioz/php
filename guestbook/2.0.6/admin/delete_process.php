<?php

// Begin Login Verification --------------------------------------------

define('IN_GB', TRUE);

include("../includes/security_headers.php");
include("../includes/secure_session.php");
include("../includes/config.php");
include("../includes/functions.php");
include("../includes/gb.class.php");

startSecureSession();

$pageTitle = "Delete Guestbook Entry"; 

include("login_check.php");
include("includes/header.php"); 

// Get and sanitize inputs
$idRaw    = isset($_GET['id']) ? $_GET['id'] : '';
$orderRaw = isset($_GET['order']) ? $_GET['order'] : '';

$id   = (ctype_digit($idRaw)) ? (int)$idRaw : -1;
$order = ($orderRaw === 'asc' || $orderRaw === 'desc') ? $orderRaw : '';
?>
<center>
<?php
// Validation ------------------------------------------------------------
if ($id < 0) {
  echo '<font color="red">Non Numeric ID Number.</font>';
  echo '<p>&nbsp;</p><p><center><a href="index.php"><font color="red"><b>Admin Main</b></font></a> - '
     .'<a href="login.php?mode=logout"><font color="red"><b>Logout</b></font></a></center></p>';
  include("includes/footer.php");
  exit;
}

if (!($order === 'asc' || $order === 'desc' || $order === '')) {
  echo '<font color="red">Entry order can only be \'asc\' or \'desc\'</font>';
  echo '<p>&nbsp;</p><p><center><a href="index.php"><font color="red"><b>Admin Main</b></font></a> - '
     .'<a href="login.php?mode=logout"><font color="red"><b>Logout</b></font></a></center></p>';
  include("includes/footer.php");
  exit;
}

// Load entries ----------------------------------------------------------
$filename = "../data/list.txt";
$datain = readDataFile($filename);
if ($datain === '') {
  echo '<font color="red">No entries found.</font>';
  include("includes/footer.php");
  exit;
}

$out = explode("<!-- E -->", $datain);
$lines = [];
foreach ($out as $chunk) {
    $chunk = trim($chunk);
    if ($chunk === '') continue;
    $data = json_decode($chunk, true);
    if (is_array($data)) { $lines[] = gbClass::fromArray($data); }
}

if (count($lines) === 0) {
  echo '<font color="red">No entries parsed.</font>';
  include("includes/footer.php");
  exit;
}

if ($order === 'desc') {
    $lines = array_values(array_reverse($lines));
}

if ($id >= count($lines)) {
  echo '<font color="red">Invalid ID (out of range).</font>';
  echo '<p>&nbsp;</p><p><center><a href="index.php"><font color="red"><b>Admin Main</b></font></a> - '
     .'<a href="login.php?mode=logout"><font color="red"><b>Logout</b></font></a></center></p>';
  include("includes/footer.php");
  exit;
}

// Rebuild file without the specified entry --------------------------------
$datanew = '';
for ($i=0; $i<count($lines); $i++) {
    if ($i === $id) { continue; }
    $datanew .= json_encode($lines[$i]) . "<!-- E -->";
}

if (!writeDataFile($filename, $datanew)) {
  echo '<font color="red">Failed to write updated data file.</font>';
  include("includes/footer.php");
  exit;
}
?>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<a href="index.php"><center><b><font color="red">Message Deleted!</font></b></center></a><br><br>
<a href="index.php"><center><b><font color="black">Back to Delete Menu</font></b></center></a><br>
<p>&nbsp;</p>
<p>&nbsp;</p>
</center>
<?php
include ("includes/footer.php");
?>


