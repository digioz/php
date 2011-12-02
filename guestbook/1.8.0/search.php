<?php

include("includes/header.php");
require_once('includes/functions.php');
require_once('includes/class.gbXML.php');
require_once('config.php');
require_once($language_file);

//include our helper class for listing guestbook entries
require_once('includes/class.guestbook_entry_lister.php');

require_once('includes/remove_special_chars.php');
$search = trim(isset($_POST['search_term']) ? remove_special_chars($_POST['search_term']) : '');
$pageNum = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 0;
$search = isset($_GET['search_term']) ? $_GET['search_term'] : $search;

if($search == ""){
 echo "<center><font color=blue>Please enter a search term and try again.</font></center>";
 include("includes/footer.php");
 exit;
}

$search_terms = preg_split('/(\s)+|\.|,|;/',$search);

$gbXML = new gbXML('messages','message', 'data/data.xml');
$records_array = $gbXML->parse_XML_data();

$found_records = array();
foreach($records_array as $record)
{
 	foreach($record as $key=>$value)
	{
		$flag=true;
		foreach($search_terms as $search_term)
		{
			if(substr_count(strtolower($value), strtolower($search_term))>0)
			{
				//Next foreach ($search_terms.... 
	                }
			else
			{
				$flag=false;
				$break;     //Not allowed to continue... already doesn't qualify... 
			}
		}
		if($flag==true){
                  $found_records[] = $record;
                }
	}

}
if(count($found_records) === 0)
{
	echo "<center><font color=blue>No entries found for {$search}.</font></center>";
 	include("includes/footer.php");               // write footer to complete page
 	exit;                                // nothing else to do
}


if(isset($_GET['page']) && is_numeric($_GET['page']) )
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
$perpage = $records_per_page;

$myLister = new guestbook_entry_lister($perpage, $context='main', '' , $found_records);

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
$pgoutnew = show_page_links("search.php?order=$order&search_term=$search", $myLister->get_count(), $perpage, $page) . '&nbsp;';

echo $pgoutnew;

include('includes/footer.php');
?>
