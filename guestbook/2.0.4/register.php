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

// Process Registration
if (isset($_POST['submit']))
{	
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
	
	if ($password != $passwordConfirm)
	{
		$tpl->assign("error_msg", $error10);
        $html = $tpl->draw('error', $return_string = true);
        echo $html;
        exit;
	}
	
	$password = encryptPassword($password, $login_salt);
	
	/*
	echo "Name: " . $name . "<br>";
	echo "Email: " . $email . "<br>";
	echo "Password: " . $password . "<br>";
	echo "Password Confirm: " . $passwordConfirm . "<br>";
	echo "Address: " . $address . "<br>";
	echo "City: " . $city . "<br>";
	echo "State: " . $state . "<br>";
	echo "Zip: " . $zip . "<br>";
	echo "Country: " . $country . "<br>";
	echo "Phone: " . $phone . "<br>";
	*/
	
	$u = new userClass();
	$u->setUserVars($email, $password, $name, $address, $city, $state, $zip, $country, $phone);
	
	@$fp = fopen("data/users.txt", "a");
    flock($fp, 2);
    
    if (!$fp) 
	{
        $tpl->assign("error_msg", $error9 . " - " . $error8);
        $html = $tpl->draw('error', $return_string = true);
        echo $html;
        exit;
    }
    
    $data = serialize($u) . "<!-- E -->";
    fwrite($fp, $data);
    flock($fp, 3);
    fclose($fp);
	
	exit;
}

// Show registration form if not posting back
$html = $tpl->draw( 'register', $return_string = true );

// and then draw the output
echo $html;
	
?>

