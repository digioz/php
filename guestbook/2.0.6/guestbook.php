<?php
define('IN_GB', TRUE);

session_start();

include("includes/functions.php");
include("includes/gb.class.php");
include("includes/config.php");
include("includes/user.class.php");

$selected_language_session = $default_language[2];
$selected_language_session_code = $default_language[1];

if (isset($_SESSION["language_selected_file"]))
{
	$selected_language_session = $_SESSION["language_selected_file"];
}

if (isset($_SESSION["language_selected_code"]))
{
	$selected_language_session_code = $_SESSION["language_selected_code"];
}

include("language/$selected_language_session");

include("includes/rain.tpl.class.php");
include("includes/csrf.class.php"); 

raintpl::configure("base_url", null );
raintpl::configure("tpl_dir", "themes/$theme/" );
raintpl::configure("cache_dir", "cache/" );

// Construct the language select array
$lang_select_array = array();
$lang_select_array = getLanguageArray($language_array);

// Check if logged in
$user_login_email = "";
$user_login_name = "";

if (isset($_SESSION["login_email"]))
{
	$user_login_email = $_SESSION["login_email"];
	$user_object = getUserByEmail($user_login_email);
	$user_login_name = $user_object->name;
}

if ($login_required == "1" && $user_login_email == "")
{
	header( 'Location: login.php' ) ;
}

// Generate Token Id and Valid  
$csrf = new csrf();
$token_id = $csrf->get_token_id();
$token_value = $csrf->get_token($token_id);

//initialize a Rain TPL object
$tpl = new RainTPL;

$tpl->assign("theme", $theme);
$tpl->assign( "title", $title );
$tpl->assign( "headingtitletxt", $headingtitletxt );
$tpl->assign( "addentrytxt", $addentrytxt );
$tpl->assign( "viewguestbooktxt", $viewguestbooktxt );
$tpl->assign( "newpostfirsttxt", $newpostfirsttxt );
$tpl->assign( "newpostlasttxt", $newpostlasttxt );
$tpl->assign( "searchlabeltxt", $searchlabeltxt );
$tpl->assign( "searchbuttontxt", $searchbuttontxt );
$tpl->assign( "yournametxt", $yournametxt );
$tpl->assign( "youremailtxt", $youremailtxt );
$tpl->assign( "yourMessagetxt", $yourMessagetxt );
$tpl->assign( "submitbutton", $submitbutton );
$tpl->assign( "image_verify", $image_verify );
$tpl->assign( "currentyear", date("Y") );
$tpl->assign( "tokenid", $token_id );
$tpl->assign( "tokenvalue", $token_value );
$tpl->assign( "gbAllowAttachments", $gbAllowAttachments );
$tpl->assign( "langCode", $default_language[1]);
$tpl->assign( "langCharSet", $default_language[4]);
$tpl->assign( "lang_select_array", $lang_select_array);
$tpl->assign( "captchalang", $selected_language_session_code);
$tpl->assign( "hideemailtxt", $hideemailtxt );
$tpl->assign( "let_user_hide_email", $let_user_hide_email );
$tpl->assign( "logintxt", $logintxt );
$tpl->assign( "logouttxt", $logouttxt );
$tpl->assign( "registertxt", $registertxt );
$tpl->assign( "loginemail", $user_login_email );
$tpl->assign( "loginname", $user_login_name );
$tpl->assign( "info2", $info2 );
$tpl->assign( "loginusermanageposts", $login_allow_post_delete );
$tpl->assign( "info4", $info4 );

if ($image_verify == 1)
{
	$tpl->assign( "captcha1", "<img src=\"includes/random.php\">");
}

if ($image_verify == 2)
{
	require_once('includes/recaptchalib.php');
	$publickey = $recaptcha_public_key;
	$tpl->assign( "captcha2", recaptcha_get_html($publickey));
}

if ($image_verify == 3)
{
	require_once('includes/recaptcha2.php');
	$publickey = $recaptcha_public_key;
	
    $reCaptcha = new ReCaptcha($publickey);    
    
	$tpl->assign( "captcha3", $publickey);
    $tpl->assign("captchalang", $selected_language_session_code);
}

$html = $tpl->draw( 'guestbook', $return_string = true );

// and then draw the output
echo $html;
	
?>

