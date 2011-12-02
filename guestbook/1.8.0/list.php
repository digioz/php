<?php

include("includes/header.php");
require_once('includes/functions.php');
require_once('includes/class.gbXML.php');
require_once('config.php');
require_once($language_file);

//include our helper class for listing guestbook entries
require_once('includes/class.guestbook_entry_lister.php');


// Get and do basic validation on browser input ------------------------------------------
if (isset($_GET['page']) && is_numeric($_GET['page']) )
{
    $page = $_GET['page'];
}
else
{
    $page = 1;
}

if (isset($_GET['order']) && ($_GET['order']=='new_first' || $_GET['order']=='new_last') )
{
    $order= $_GET['order'];
}
else
{
    $order = 'new_first';
}


// Setting the default values for number of records per page -------------------------
$perpage = $records_per_page; //this value comes from config.php which is included by header.php

$myLister = new guestbook_entry_lister($perpage, $context='main', 'data/data.xml');

if ($myLister->guestbook_is_empty() )
{
    echo <<<HTML
    <p>I'm sorry. The guest book is empty. <a href="guestbook.php" title="add an entry">Be the first to add an entry</a>!</p>
HTML;

    include('includes/footer.php');
    exit();
}

if ($order == 'new_first')
{
    $myLister->list_new_first($page);
}
else
{
    $myLister->list_new_last($page);
}

// Creating the Forward and Backward links
$pgoutnew = show_page_links("list.php?order=$order", $myLister->get_count(), $perpage, $page) . '&nbsp;';

echo $pgoutnew;

include('includes/footer.php');

?>
