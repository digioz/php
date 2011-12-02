<?php
session_start();
// Begin Login Verification --------------------------------------------

include("login_check.php");
require_once('../config.php');
require_once('../includes/class.gbXML.php');
require_once('../includes/class.guestbook_entry_lister.php');
require_once("../$language_file");
require_once("../includes/functions.php");

// Construct a basic page by including the admin_header.php
include_once('../includes/admin_header.php');
?>

<h2>Edit or Delete a Guestbook Entry</h2>
<!-- set up the entry listing links -->
<p>[ <a href="modify.php?page=1&order=new_first"><?php echo $newpostfirsttxt ?></a> ]
[ <a href="modify.php?page=1&order=new_last"><?php echo $newpostlasttxt ?></a> ]</p>

<div align="center">
	<?php

	// Get and do basic validation on browser input ------------------------------------------
	if (@is_numeric($_GET['page']) )
	{
		$page = $_GET['page'];
	}
	else
	{
		$page = 1;
	}

	if (@$_GET['order']=='new_first' || @$_GET['order']=='new_last' )
	{
		$order= $_GET['order'];
	}
	else
	{
		$order = 'new_first';
	}


	//Get a new guestbook_entry_lister object to help listing records
	//Tell it our context so we get the appropriate path to the email picture generator
	$entry_lister = new guestbook_entry_lister($records_per_page, $context='admin', '../data/data.xml');

	if ($entry_lister->guestbook_is_empty())
	{
		echo "<p>There are no records in the guestbook to display</p>";
		include('../includes/footer.php');
		exit();
	}

	// show records with a delete button to allow deletion;
	// and with edit button to allow editing;
	$with_buttons = array('delete', 'edit');

	//display records in apporpriate order:
	if ($order == 'new_first')
	{
		$entry_lister->list_new_first($page, $with_buttons);
	}
	else
	{
		$entry_lister->list_new_last($page, $with_buttons);
	}

	// Create the Forward and Backward links -------------------------------------
	$url = basename($_SERVER['PHP_SELF']).'?order='.$order;
	$pgoutnew = show_page_links($url, $entry_lister->get_count(), $records_per_page, $page);

	echo $pgoutnew;
	?>
</div>
	<?php

//close the page by including the admin_footer.php file
include('../includes/admin_footer.php');

?>
