<?php
define('IN_GB', TRUE);

include("includes/security_headers.php");
include("includes/secure_session.php");
startSecureSession();

include("includes/functions.php");
include("includes/user.class.php");
include("includes/config.php");

// Validate theme after functions are loaded
$theme = validateTheme($theme);

$selected_language_session = $default_language[2];
$selected_language_session_code = $default_language[1];

if (isset($_SESSION["language_selected_file"]))
{
	$selected_language_session = validateLanguage($_SESSION["language_selected_file"], $language_array);
}

if (isset($_SESSION["language_selected_code"]))
{
	$selected_language_session_code = validateInput($_SESSION["language_selected_code"], 'string', 5);
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

if (isset($_SESSION["login_email"]))
{
	$user_login_email = $_SESSION["login_email"];
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
$tpl->assign( "goback", $goback);
$tpl->assign( "emailtxt", $emailtxt );
$tpl->assign( "passwordtxt", $passwordtxt );
$tpl->assign( "passwordconfirmtxt", $passwordconfirmtxt );
$tpl->assign( "nametxt", $nametxt );
$tpl->assign( "addresstxt", $addresstxt );
$tpl->assign( "citytxt", $citytxt );
$tpl->assign( "statetxt", $statetxt );
$tpl->assign( "ziptxt", $ziptxt );
$tpl->assign( "countrytxt", $countrytxt );
$tpl->assign( "phonetxt", $phonetxt );
$tpl->assign( "loginemail", $user_login_email );
$tpl->assign( "info2", $info2 );
$tpl->assign( "loginusermanageposts", $login_allow_post_delete );
$tpl->assign( "info4", $info4 );

// Process Registration
if (isset($_POST['submit']))
{
	$name = validateInput($_POST['name'] ?? '', 'string', 100);
	$email = validateInput($_POST['email'] ?? '', 'email', 150);
	$password = validateInput($_POST['password'] ?? '', 'string', 200);
	$passwordConfirm = validateInput($_POST['passwordconfirm'] ?? '', 'string', 200);
	$address = validateInput($_POST['address'] ?? '', 'string', 200);
	$city = validateInput($_POST['city'] ?? '', 'string', 100);
	$state = validateInput($_POST['state'] ?? '', 'string', 100);
	$zip = validateInput($_POST['zip'] ?? '', 'string', 20);
	$country = validateInput($_POST['country'] ?? '', 'string', 100);
	$phone = validateInput($_POST['phone'] ?? '', 'string', 50);

	if ($email === false) {
		$tpl->assign("error_msg", $error3);
        $html = $tpl->draw('error', $return_string = true);
        echo $html;
        exit;
	}

	// Prevent duplicate registration by email (case-insensitive)
	if (getUserByEmail($email) !== null) {
		$duplicateMsg = isset($error12) ? $error12 : "This email is already registered.";
		$tpl->assign("error_msg", $duplicateMsg);
        $html = $tpl->draw('error', $return_string = true);
        echo $html;
        exit;
	}

	if ($password === false || $passwordConfirm === false || $password !== $passwordConfirm)
	{
		$tpl->assign("error_msg", $error10);
        $html = $tpl->draw('error', $return_string = true);
        echo $html;
        exit;
	}
	
	// Hash password using secure API
	$hashedPassword = encryptPassword($password);

	$u = new userClass();
	$u->setUserVars($email, $hashedPassword, $name, $address, $city, $state, $zip, $country, $phone);
	
	@$fp = fopen("data/users.txt", "a");
    flock($fp, 2);
    
    if (!$fp) 
	{
        $tpl->assign("error_msg", $error9 . " - " . $error8);
        $html = $tpl->draw('error', $return_string = true);
        echo $html;
        exit;
    }
    
    // Store user as JSON instead of PHP serialize for security
    $data = json_encode($u) . "<!-- E -->";
    fwrite($fp, $data);
    flock($fp, 3);
    fclose($fp);
	
	$userLoggingIn = getUserByEmail($email);
	$_SESSION["login_email"] = $email;
	$_SESSION["user_object"] = $userLoggingIn;
	
	$tpl->assign("info_msg", $info1);
	$tpl->assign( "loginemail", sanitizeOutput($email) );
	$html = $tpl->draw('info', $return_string = true);
	echo $html;
	
	exit;
}

// Show registration form if not posting back
$html = $tpl->draw( 'register', $return_string = true );

// and then draw the output
echo $html;
	
?>

