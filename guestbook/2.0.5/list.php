<?php

define('IN_GB', TRUE);

session_start();

include("includes/functions.php");
include("includes/gb.class.php");
include("includes/config.php");

$selected_language_session = $default_language[2];

if (isset($_SESSION["language_selected_file"]))
{
	$selected_language_session = $_SESSION["language_selected_file"];
}

include("language/$selected_language_session");
include("includes/rain.tpl.class.php");

raintpl::configure("base_url", null );
raintpl::configure("tpl_dir", "themes/$theme/" );
raintpl::configure("cache_dir", "cache/" );

// Construct the language select array
$lang_select_array = array();
$lang_select_array = getLanguageArray($language_array);

// Check if logged in
$user_login_email = "";

if (isset($_SESSION["login_email"]))
{
	$user_login_email = $_SESSION["login_email"];
}

//initialize a Rain TPL object
$tpl = new RainTPL;
$tpl->assign( "theme", $theme );
$tpl->assign( "title", $title );
$tpl->assign( "headingtitletxt", $headingtitletxt );
$tpl->assign( "addentrytxt", $addentrytxt );
$tpl->assign( "viewguestbooktxt", $viewguestbooktxt );
$tpl->assign( "newpostfirsttxt", $newpostfirsttxt );
$tpl->assign( "newpostlasttxt", $newpostlasttxt );
$tpl->assign( "searchlabeltxt", $searchlabeltxt );
$tpl->assign( "searchbuttontxt", $searchbuttontxt );
$tpl->assign( "currentyear", date("Y") );
$tpl->assign( "goback", $goback );
$tpl->assign( "langCode", $default_language[1]);
$tpl->assign( "langCharSet", $default_language[4]);
$tpl->assign( "lang_select_array", $lang_select_array);
$tpl->assign( "logintxt", $logintxt );
$tpl->assign( "logouttxt", $logouttxt );
$tpl->assign( "registertxt", $registertxt );
$tpl->assign( "loginemail", $user_login_email );
$tpl->assign( "info2", $info2 );
$tpl->assign( "loginusermanageposts", $login_allow_post_delete );
$tpl->assign( "info4", $info4 );

$page = $_GET['page'];
$order= $_GET['order'];

$currentPage = $page;

if ($page == "" || $order == "")
{
    $page = 1;
    $order = "asc";
}

// Validate browser input ------------------------------------------------------------

if (is_numeric($page) == false) 
{
	$tpl->assign( "error_msg", $msgnonnumericpagenr);
	$html = $tpl->draw( 'error', $return_string = true );
	echo $html;
	exit;
}

if (!($order == "asc" || $order == "desc"))
{
	$tpl->assign( "error_msg", $msgsortingerror);
	$html = $tpl->draw( 'error', $return_string = true );
	echo $html;
	exit;
}  

// -----------------------------------------------------------------------------------

if ($page == "") { $page = 1; }
$fwd = $page + 1;
$rwd = $page - 1;

// Setting the default values for number of records per page -------------------------

$perpage = $total_records_per_page;

// Reading in all the records, putting each guestbook entry in one Array Element -----

$filename = "data/list.txt";
$handle = fopen($filename, "r");

if (filesize($filename) == 0)
{
	$tpl->assign( "error_msg", $msgnoentries);
	$html = $tpl->draw( 'error', $return_string = true );
	echo $html;
	exit;
}
else
{
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

	// Counting the total number of entries (lines) in the data text file --------

	$result = count($lines);
	$count = $result-1;

	// Calculate how many pages there are ----------------------------------------

	if ($count == 0) { $totalpages = 0; }
	else { $totalpages = intval(($count - 1) / $perpage) + 1; }

	$page = $totalpages - ($page - 1);

	$end = $count - (($totalpages - $page) * $perpage);
	$start = $end - ($perpage - 1); if ($start < 1) { $start = 1; }

	if ($start < 0) { $start = 0; }
	
	// Display guestbook entries --------------------------------------------------
	
	$html = $tpl->draw( 'header', $return_string = true );
	echo $html;

	for ($i=$end-1; $i>$start-2; $i--)
	{
		// Convert to local date time
		$date_format_locale = gmdate($date_time_format, $lines[$i]->gbDate + 3600 * ($timezone_offset + date("I")));
		
		if ($dst_auto_detect == 0)
		{
			$date_format_locale = gmdate($date_time_format, $lines[$i]->gbDate + 3600 * ($timezone_offset));
		}
		
		$tpl->assign( "listDatetxt", $listDatetxt);
		$tpl->assign( "listnametxt", $listnametxt);
		$tpl->assign( "listemailtxt", $listemailtxt);
		$tpl->assign( "listMessagetxt", $listMessagetxt);
		$tpl->assign( "outputdate", $date_format_locale);
		$tpl->assign( "outputfrom", $lines[$i]->gbFrom);
		$tpl->assign( "outputemail", $lines[$i]->gbEmail);
		$tpl->assign( "outputmessage", $lines[$i]->gbMessage);
		$tpl->assign( "langCode", $default_language[1]);
		$tpl->assign( "langCharSet", $default_language[4]);
		$tpl->assign( "lang_select_array", $lang_select_array);
		$tpl->assign( "outputhideemail", $lines[$i]->gbHideEmail); 
		
		$html = $tpl->draw( 'list', $return_string = true );
		echo $html;
	}

    echo "<center>";
	echo '<br><div class="pagination">';

	
	// Creating the Forward and Backward links -------------------------------------

	if ($fwd > 0 && $rwd > 0 && $rwd<$totalpages+1)
	{
		echo "<a href=\"list.php?page=1&order=$order\">&lt&lt</a>";
		echo "<a href=\"list.php?page=$rwd&order=$order\">&lt</a>";
	}
	else if ($rwd > 0)
	{ 
		echo "<a href=\"list.php?page=$rwd&order=$order\">&lt</a>"; 
	}
	
	// loop through and display each page number
	
	$startPagination = $currentPage - 3;
	$endPagination = $currentPage + 3;

	if ($startPagination < 1)
	{
		$startPagination = 1;
	}

	if ($endPagination > $totalpages)
	{
		$endPagination = $totalpages;
	}
	
	//for ($i = 1; $i<=$totalpages; $i++)
	for ($i = $startPagination; $i<=$endPagination; $i++)  
	{
        if ($currentPage == $i)
        {
             echo "<b><a href=\"list.php?page=$i&order=$order\" class=\"pagination current\"><b>$i</b></a></b>";  
        }
        else
        {
            echo "<b><a href=\"list.php?page=$i&order=$order\">$i</a></b>"; 
        }
	}

	if ($fwd > 0 && $rwd > 0 && $fwd<$totalpages+1)
	{
		echo "<a href=\"list.php?page=$fwd&order=$order\">&gt</a>";
	}
	else if ($fwd > 0 && $fwd <= $totalpages)
	{ 
		echo "<a href=\"list.php?page=$fwd&order=$order\">&gt</a>"; 
	}
	
	if ($currentPage < $totalpages)
	{
		echo "<a href=\"list.php?page=$totalpages&order=$order\">&gt&gt</a>"; 
	}

	echo "</div>";
	echo "</center>";
}

	$html = $tpl->draw( 'footer', $return_string = true );
	echo $html;

?>


