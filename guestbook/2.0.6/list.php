<?php

define('IN_GB', TRUE);

// Include security configuration first
include("includes/security_headers.php");
include("includes/secure_session.php");

startSecureSession();

include("includes/functions.php");
include("includes/config.php");
include("includes/gb.class.php");

// Validate theme after functions are loaded
$theme = validateTheme($theme);

$selected_language_session = $default_language[2];

if (isset($_SESSION["language_selected_file"]))
{
	$selected_language_session = validateLanguage($_SESSION["language_selected_file"], $language_array);
}

include("language/$selected_language_session");
include("includes/rain.tpl.class.php");

raintpl::configure("base_url", null );
raintpl::configure("tpl_dir", "themes/" . $theme . "/" );
raintpl::configure("cache_dir", "cache/" );

// Construct the language select array
$lang_select_array = array();
$lang_select_array = getLanguageArray($language_array);

// Determine currently selected language display label
$current_language = "Select Language";
if (isset($_SESSION['language_selected_file'])) {
	$file = $_SESSION['language_selected_file'];
	foreach ($language_array as $lang) {
		if ($lang[2] === $file) { $current_language = $lang[0]; break; }
	}
}

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
$tpl->assign( "current_language", $current_language);
$tpl->assign( "logintxt", $logintxt );
$tpl->assign( "logouttxt", $logouttxt );
$tpl->assign( "registertxt", $registertxt );
$tpl->assign( "loginemail", $user_login_email );
$tpl->assign( "info2", $info2 );
$tpl->assign( "loginusermanageposts", $login_allow_post_delete );
$tpl->assign( "info4", $info4 );

// Inputs with defaults
$page  = isset($_GET['page']) ? $_GET['page'] : 1;
$order = isset($_GET['order']) ? $_GET['order'] : 'asc';

// Normalize
if ($page === '' || !is_numeric($page) || (int)$page < 1) { $page = 1; }
$page = (int)$page;
$order = ($order === 'desc') ? 'desc' : 'asc';
$currentPage = $page;

// Validate browser input ------------------------------------------------------------
if (!($order == "asc" || $order == "desc"))
{
	$tpl->assign( "error_msg", $msgsortingerror);
	$html = $tpl->draw( 'error', $return_string = true );
	echo $html;
	exit;
}  

// Setting the default values for number of records per page -------------------------
$perpage = $total_records_per_page;

// Reading in all the records, putting each guestbook entry in one Array Element -----
$filename = "data/list.txt";

$datain = readDataFile($filename);
if ($datain === '' )
{
	$tpl->assign( "error_msg", $msgnoentries);
	$html = $tpl->draw( 'error', $return_string = true );
	echo $html;
	exit;
}

// Parse entries
$out = explode("<!-- E -->", $datain);
$lines = array();
foreach ($out as $chunk) {
	$chunk = trim($chunk);
	if ($chunk === '') continue;
	$data = json_decode($chunk, true);
	if (is_array($data)) {
		$lines[] = gbClass::fromArray($data);
	} else {
		// legacy fallback if needed
		$legacy = @unserialize($chunk, ["allowed_classes" => ["gbClass"]]);
		if ($legacy instanceof gbClass) { $lines[] = $legacy; }
	}
}

// Filter out null entries
$lines = array_values(array_filter($lines));

// Apply sort order: asc = oldest first, desc = newest first
if ($order === 'desc') { $lines = array_reverse($lines); }

// Pagination calculations
$count = count($lines);
if ($count === 0) {
	$tpl->assign( "error_msg", $msgnoentries);
	$html = $tpl->draw( 'error', $return_string = true );
	echo $html;
	exit;
}

$totalpages = (int)ceil($count / max(1, $perpage));
if ($currentPage > $totalpages) { $currentPage = $totalpages; }

$startIndex = ($currentPage - 1) * $perpage;
$endIndex = min($startIndex + $perpage, $count);

// Render header
$html = $tpl->draw( 'header', $return_string = true );
echo $html;

// Display guestbook entries --------------------------------------------------
for ($i = $startIndex; $i < $endIndex; $i++)
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
	$tpl->assign( "outputdate", sanitizeOutput($date_format_locale));
	$tpl->assign( "outputfrom", sanitizeOutput($lines[$i]->gbFrom));
	$tpl->assign( "outputemail", sanitizeOutput($lines[$i]->gbEmail));
	// Do not escape the message so that smiley <img> tags (and safe system-generated markup) render
	$tpl->assign( "outputmessage", $lines[$i]->gbMessage);
	$tpl->assign( "langCode", $default_language[1]);
	$tpl->assign( "langCharSet", $default_language[4]);
	$tpl->assign( "lang_select_array", $lang_select_array);
	$tpl->assign( "current_language", $current_language);
	$tpl->assign( "outputhideemail", $lines[$i]->gbHideEmail); 
	
	$html = $tpl->draw( 'list', $return_string = true );
	echo $html;
}

// Pagination UI --------------------------------------------------------------
echo "<center>";
echo '<br><div class="pagination">';

if ($currentPage > 1) {
	echo "<a href=\"list.php?page=1&order=$order\">&lt&lt</a>";
	echo "<a href=\"list.php?page=" . ($currentPage - 1) . "&order=$order\">&lt</a>";
}

$startPagination = max(1, $currentPage - 3);
$endPagination = min($totalpages, $currentPage + 3);

for ($i = $startPagination; $i <= $endPagination; $i++)
{
	if ($currentPage == $i)
	{
		// highlight current page
		echo "<b><a href=\"list.php?page=$i&order=$order\" class=\"pagination current\"><b>$i</b></a></b>";  
	}
	else
	{
		echo "<b><a href=\"list.php?page=$i&order=$order\">$i</a></b>"; 
	}
}

if ($currentPage < $totalpages)
{
	echo "<a href=\"list.php?page=" . ($currentPage + 1) . "&order=$order\">&gt</a>";
	echo "<a href=\"list.php?page=$totalpages&order=$order\">&gt&gt</a>"; 
}

echo "</div>";
echo "</center>";

$html = $tpl->draw( 'footer', $return_string = true );
echo $html;

?>


