<?php

define('IN_GB', TRUE);

session_start();

include("includes/config.php");
include("includes/functions.php");
include("includes/gb.class.php");
include("includes/user.class.php");

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
$userid = "";

if (isset($_SESSION["login_email"]))
{
	$user_login_email = $_SESSION["login_email"];
	$user_login_object = getUserByEmail($user_login_email);
	$userid = $user_login_object->id;
}

if (isset($_GET['id']))
{
	// Remove Post
	$post_to_remove = trim($_GET['id']);
	$is_user_post_owner = isUserPostOwner($post_to_remove, $userid);
	
	if ($is_user_post_owner)
	{
		deletePostById($post_to_remove, $userid);
	}

	header( 'Location: user_manage_posts.php' ) ;
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


// Reading in all the records, putting each guestbook entry in one Array Element -----

$filename = "data/list.txt";
$handle = fopen($filename, "r");
$lines = array();

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
	$j = 0;

	for ($i=0; $i<=$outCount; $i++)
	{
		$temp1 = unserialize($out[$i]);
		
		if ($temp1 != null && $temp1->gbUserId != null && $temp1->gbUserId == $userid)
		{
			$lines[$j] = unserialize($out[$i]);
			$j++;
		}
	}
	
	// Display guestbook entries --------------------------------------------------
	
	$html = $tpl->draw( 'header', $return_string = true );
	echo $html;

	for ($i=0;$i<count($lines);$i++)	
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
		$tpl->assign( "warning1", $warning1); 
		$tpl->assign( "postid", $lines[$i]->id);
		
		$html = $tpl->draw( 'user_manage_post', $return_string = true );
		echo $html;
	}

    echo "<center>";
	echo '<br><div class="pagination">';

	echo "</div>";
	echo "</center>";
}

	$html = $tpl->draw( 'footer', $return_string = true );
	echo $html;

?>


