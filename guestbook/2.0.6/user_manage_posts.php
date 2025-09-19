<?php

define('IN_GB', TRUE);

include("includes/security_headers.php");
include("includes/secure_session.php");
startSecureSession();

include("includes/config.php");
include("includes/functions.php");
include("includes/gb.class.php");
include("includes/user.class.php");
include("includes/csrf.class.php");

$selected_language_session = $default_language[2];
if (isset($_SESSION["language_selected_file"])) {
    $selected_language_session = validateLanguage($_SESSION["language_selected_file"], $language_array);
}
include("language/$selected_language_session");
include("includes/rain.tpl.class.php");

$theme = validateTheme($theme);
raintpl::configure("base_url", null );
raintpl::configure("tpl_dir", "themes/$theme/" );
raintpl::configure("cache_dir", "cache/" );

// CSRF setup
$csrf = new csrf();
$token_id = $csrf->get_token_id();
$token_value = $csrf->get_token();

// Construct the language select array
$lang_select_array = getLanguageArray($language_array);

// Check if logged in
$user_login_email = "";
$userid = "";
if (isset($_SESSION["login_email"])) {
    $user_login_email = $_SESSION["login_email"];
    if (isset($_SESSION['user_object']) && is_object($_SESSION['user_object']) && !empty($_SESSION['user_object']->id)) {
        $userid = $_SESSION['user_object']->id;
    } else {
        $u = getUserByEmail($user_login_email);
        if ($u && isset($u->id)) { $userid = $u->id; }
    }
}

// Handle delete via POST with CSRF protection
if (!empty($userid) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($csrf->check_valid('post') === false) {
        $tpl = new RainTPL;
        $tpl->assign("theme", $theme);
        $tpl->assign("title", $title);
        $tpl->assign("currentyear", date("Y"));
        $tpl->assign("error_msg", $errorFormToken);
        echo $tpl->draw('header', true);
        echo $tpl->draw('error', true);
        echo $tpl->draw('footer', true);
        exit;
    }

    $post_to_remove = isset($_POST['post_id']) ? trim($_POST['post_id']) : '';
    if ($post_to_remove !== '' && isUserPostOwner($post_to_remove, $userid)) {
        deletePostById($post_to_remove, $userid);
    }
    header('Location: user_manage_posts.php');
    exit;
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
$tpl->assign( "token_id", $token_id );
$tpl->assign( "token_value", $token_value );

// Read all posts and filter by owner (use decrypt-aware helper)
$lines = [];
$filename = "data/list.txt";
$datain = readDataFile($filename);
if ($datain === '') {
    echo $tpl->draw('header', true);
    $tpl->assign( "error_msg", $msgnoentries);
    echo $tpl->draw('error', true);
    echo $tpl->draw('footer', true);
    exit;
}

$out = explode("<!-- E -->", $datain);

foreach ($out as $chunk) {
    $chunk = trim($chunk);
    if ($chunk === '') continue;

    $data = json_decode($chunk, true);
    if (is_array($data)) {
        $obj = gbClass::fromArray($data);
    } else {
        // Legacy fallback
        $legacy = @unserialize($chunk, ["allowed_classes" => ["gbClass"]]);
        $obj = ($legacy instanceof gbClass) ? $legacy : null;
    }

    if ($obj && !empty($userid) && isset($obj->gbUserId) && $obj->gbUserId === $userid) {
        $lines[] = $obj;
    }
}

// Render
echo $tpl->draw('header', true);

for ($i=0; $i<count($lines); $i++)
{
    $date_format_locale = gmdate($date_time_format, $lines[$i]->gbDate + 3600 * ($timezone_offset + date("I")));
    if ($dst_auto_detect == 0) {
        $date_format_locale = gmdate($date_time_format, $lines[$i]->gbDate + 3600 * ($timezone_offset));
    }

    $tpl->assign( "listDatetxt", $listDatetxt);
    $tpl->assign( "listnametxt", $listnametxt);
    $tpl->assign( "listemailtxt", $listemailtxt);
    $tpl->assign( "listMessagetxt", $listMessagetxt);
    $tpl->assign( "outputdate", sanitizeOutput($date_format_locale));
    $tpl->assign( "outputfrom", sanitizeOutput($lines[$i]->gbFrom));
    $tpl->assign( "outputemail", sanitizeOutput($lines[$i]->gbEmail));
    $tpl->assign( "outputmessage", $lines[$i]->gbMessage);
    $tpl->assign( "langCode", $default_language[1]);
    $tpl->assign( "langCharSet", $default_language[4]);
    $tpl->assign( "lang_select_array", $lang_select_array);
    $tpl->assign( "outputhideemail", $lines[$i]->gbHideEmail); 
    $tpl->assign( "warning1", $warning1); 
    $tpl->assign( "postid", $lines[$i]->id);

    echo $tpl->draw('user_manage_post', true);
}

echo $tpl->draw('footer', true);

?>


