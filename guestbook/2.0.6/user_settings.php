<?php
define('IN_GB', TRUE);

// Use the same secure session/bootstrap as other pages
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

if (isset($_SESSION["login_email"]))
{
	$user_login_email = $_SESSION["login_email"];
	$user_login_object = getUserByEmail($user_login_email);
	$userid = $user_login_object ? $user_login_object->id : '';
}
else
{
	header('Location: index.php');
	exit;
}

// Generate Token Id and Value
$csrf = new csrf();
$token_id = $csrf->get_token_id();
$token_value = $csrf->get_token();

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
$tpl->assign( "info3", $info3 );
$tpl->assign( "loginusermanageposts", $login_allow_post_delete );
$tpl->assign( "info4", $info4 );

$tpl->assign("user_name", $user_login_object->name);
$tpl->assign("user_email", $user_login_object->email);
$tpl->assign("user_address", $user_login_object->address);
$tpl->assign("user_city", $user_login_object->city);
$tpl->assign("user_state", $user_login_object->state);
$tpl->assign("user_zip", $user_login_object->zip);
$tpl->assign("user_country", $user_login_object->country);
$tpl->assign("user_phone", $user_login_object->phone);
$tpl->assign('tokenid', $token_id);
$tpl->assign('tokenvalue', $token_value);

// Process save
if (isset($_POST['submit']))
{   
    // CSRF check
    if ($csrf->check_valid('post') === false) {
        $tpl->assign("error_msg", $errorFormToken);
        echo $tpl->draw('error', true);
        exit;
    }

	$name = $_POST['name'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$passwordConfirm = $_POST['passwordconfirm'];
	$address = $_POST['address'];
	$city = $_POST['city'];
	$state = $_POST['state'];
	$zip = $_POST['zip'];
	$country = $_POST['country'];
	$phone = $_POST['phone'];
	
	if ($password !== $passwordConfirm)
	{
		$tpl->assign("error_msg", $error10);
        $html = $tpl->draw('error', $return_string = true);
        echo $html;
        exit;
	}
	
	$users = getAllUsers();
	$user_current = getUserByEmail($user_login_email);
	$datanew = "";
	
	foreach ($users as &$user)
	{
		if ($user == null) { continue; }
		if ($user->id == $user_current->id)
		{
			$user->name = $name;
			$user->email = $email;
			$user->address = $address;
			$user->city = $city;
			$user->state = $state;
			$user->zip = $zip;
			$user->country = $country;
			$user->phone = $phone;
			
			if (strlen($password) > 0)
			{
				// Update password using secure password_hash
				$user->password = encryptPassword($password);
			}
		}
		$datanew .= json_encode($user) . "<!-- E -->";
	}
	
	// Write back using encryption-aware helper
	if (!writeDataFile("data/users.txt", $datanew)) {
		$tpl->assign("error_msg", $error9 . " - " . $error8);
        $html = $tpl->draw('error', $return_string = true);
        echo $html;
        exit;
	}
	
	$userLoggingIn = getUserByEmail($email);
	$_SESSION["login_email"] = $email;
	$_SESSION["user_object"] = $userLoggingIn;
	
	header('Location: index.php');
	exit;
}

// Show settings form if not posting back
$html = $tpl->draw('user_settings', $return_string = true);

echo $html;
	
?>

