<?php
define('IN_GB', TRUE);

session_start();

include("includes/gb.class.php");
include("includes/config.php");
include("language/$default_language");

include("includes/rain.tpl.class.php");
include("includes/csrf.class.php"); 

raintpl::configure("base_url", null );
raintpl::configure("tpl_dir", "themes/$theme/" );
raintpl::configure("cache_dir", "cache/" );

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
    
    $lang = "en";
    $reCaptcha = new ReCaptcha($publickey);    
    
	$tpl->assign( "captcha3", $publickey);
    $tpl->assign("captchalang", $lang);
}

$html = $tpl->draw( 'guestbook', $return_string = true );

// and then draw the output
echo $html;
	
?>

