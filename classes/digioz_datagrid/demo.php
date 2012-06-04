<?php

if (isset($_GET['st']))
{
	$st = $_GET['st'];
}
else
{
	$st = 0;
}

include("dbgrid.php");

$a = new dbGrid('localhost','test','root','password');

// Set Display Colors and table properties -----------------------

$a->setProperties("#000000", "10", "2", "800");

// Display Column Names ------------------------------------------

$a->setShowHeader(1);

// This is How you set custom column header ----------------------

//$a->setCustomHeader("Column1|Column2|Column3");

// Display Data Grid ---------------------------------------------

$a->displayGrid("test1", $st);

?>