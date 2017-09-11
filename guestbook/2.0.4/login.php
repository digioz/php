<?php
define('IN_GB', TRUE);

session_start();

include("includes/functions.php");
include("includes/user.class.php");
include("includes/config.php");

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

// Generate Token Id and Valid  
$csrf = new csrf();
$token_id = $csrf->get_token_id();
$token_value = $csrf->get_token($token_id);

// Check if logged in
$user_login_email = "";

if (isset($_SESSION["login_email"]))
{
	$user_login_email = $_SESSION["login_email"];
}

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
$tpl->assign( "submitbutton", $submitbutton );
$tpl->assign( "image_verify", $image_verify );
$tpl->assign( "currentyear", date("Y") );
$tpl->assign( "langCode", $default_language[1]);
$tpl->assign( "langCharSet", $default_language[4]);
$tpl->assign( "lang_select_array", $lang_select_array);
$tpl->assign( "captchalang", $selected_language_session_code);
$tpl->assign( "logintxt", $logintxt );
$tpl->assign( "logouttxt", $logouttxt );
$tpl->assign( "registertxt", $registertxt );
$tpl->assign("goback", $goback);
$tpl->assign( "emailtxt", $emailtxt );
$tpl->assign( "passwordtxt", $passwordtxt );
$tpl->assign( "passwordconfirmtxt", $passwordconfirmtxt );
$tpl->assign( "loginemail", $user_login_email );
$tpl->assign( "info2", $info2 );
$tpl->assign( "loginusermanageposts", $login_allow_post_delete );
$tpl->assign( "info4", $info4 );

// Process Login
if (isset($_POST['submit']))
{	
	$email = $_POST['email'];
	$password = $_POST['password'];
	
	// Validate Email format
	if (checkmail($email) != 1) 
	{
        $tpl->assign("error_msg", $error3);
        $html = $tpl->draw('error', $return_string = true);
        echo $html;
		exit;
    }
	
	$allUsers = getAllUsers();
	
	$userLoggingIn = getUserByEmail($email);
	$msg = "";
	
	if (isset($userLoggingIn))
	{
		// Check to make sure login is correct
		$userLoginValidated = false;
		$userLoginValidated = validateLogin($email, $password, $userLoggingIn->password, $login_salt);
		
		if ($userLoginValidated)
		{
			$_SESSION["login_email"] = $email;
			$_SESSION["user_object"] = $userLoggingIn;
			
			$tpl->assign("info_msg", $info1);
			$tpl->assign( "loginemail", $email );
			$html = $tpl->draw('info', $return_string = true);
			echo $html;			
		}
		else
		{
			$tpl->assign("error_msg", $error11);
			$html = $tpl->draw('error', $return_string = true);
			echo $html;
		}
	}
	else
	{
		$tpl->assign("error_msg", $error11);
        $html = $tpl->draw('error', $return_string = true);
        echo $html;
	}

	exit;
}

$html = $tpl->draw( 'login', $return_string = true );

// and then draw the output
echo $html;
	
?>

