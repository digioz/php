<?php

define('IN_GB', TRUE);

include("includes/security_headers.php");
include("includes/secure_session.php");
startSecureSession();

include("includes/functions.php");
include("includes/gb.class.php");
include("includes/user.class.php");
include("includes/config.php");
include("includes/csrf.class.php");

$theme = validateTheme($theme);

$selected_language_session = $default_language[2];
if (isset($_SESSION["language_selected_file"])) {
    $selected_language_session = validateLanguage($_SESSION["language_selected_file"], $language_array);
}
include("language/$selected_language_session");
include("includes/rain.tpl.class.php");
include("includes/sanitize.php");

raintpl::configure("base_url", null );
raintpl::configure("tpl_dir", "themes/$theme/" );
raintpl::configure("cache_dir", "cache/" );

// Require login
if (!isset($_SESSION['login_email'])) {
    header('Location: login.php');
    exit;
}

$user = getUserByEmail($_SESSION['login_email']);
$userid = $user ? $user->id : '';
if ($userid === '') {
    header('Location: login.php');
    exit;
}

$postid = isset($_GET['id']) ? trim($_GET['id']) : '';
if ($postid === '') {
    header('Location: user_manage_posts.php');
    exit;
}

$all = getAllPosts();
$thePost = null;
foreach ($all as $p) {
    if ($p && $p->id === $postid && $p->gbUserId === $userid) {
        $thePost = $p; break;
    }
}

if (!$thePost) {
    header('Location: user_manage_posts.php');
    exit;
}

// CSRF setup
$csrf = new csrf();
$token_id = $csrf->get_token_id();
$token_value = $csrf->get_token();

// Derive a plain message for editing: convert <br> to newlines and convert smiley <img> back to tokens
$postMessagePlain = $thePost->gbMessage;
$postMessagePlain = str_ireplace(["<br>", "<br/>", "<br />"], "\n", $postMessagePlain);

// Map icon names back to original tokens used by smiley_face()
$smileyMap = [
    'question' => ':?:',
    'biggrin' => ':D',
    'confused' => ':?',
    'cool' => ':cool:',
    'cry' => ':cry:',
    'eek' => ':shock:',
    'evil' => ':evil:',
    'exclaim' => ':!:',
    'frown' => ':frown:',
    'idea' => ':idea:',
    'arrow' => ':arrow:',
    'lol' => ':lol:',
    'mad' => ':x',
    'mrgreen' => ':mrgreen:',
    'neutral' => ':|',
    'razz' => ':P',
    'redface' => ':oops:',
    'rolleyes' => ':roll:',
    'sad' => ':(',
    'smile' => ':)',
    'surprised' => ':o',
    'twisted' => ':twisted:',
    'wink' => ':wink:'
];

$postMessagePlain = preg_replace_callback('/<img[^>]+icon_([a-z]+)\.gif[^>]*>/i', function($m) use ($smileyMap) {
    $key = strtolower($m[1]);
    return isset($smileyMap[$key]) ? $smileyMap[$key] : '';
}, $postMessagePlain);

// Normalize a couple of legacy ALT variants back to canonical tokens
$postMessagePlain = str_ireplace([': ?:',' : ?:', ': oops :'], [':?:', ':?:', ':oops:'], $postMessagePlain);

// Strip any remaining tags
$postMessagePlain = strip_tags($postMessagePlain);

// Handle submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($csrf->check_valid('post') === false) {
        $tpl = new RainTPL;        
        $tpl->assign("theme", $theme);
        $tpl->assign("title", $title);
        $tpl->assign("currentyear", date('Y'));
        $tpl->assign("error_msg", $errorFormToken);
        echo $tpl->draw('header', true);
        echo $tpl->draw('error', true);
        echo $tpl->draw('footer', true);
        exit;
    }

    $msg = validateInput($_POST['yourmessage'] ?? '', 'string', 1000);
    $hide = isset($_POST['hideemail']) && $_POST['hideemail'] === 'hideemail';

    if ($msg === false) {
        $tpl = new RainTPL;
        $tpl->assign("theme", $theme);
        $tpl->assign("title", $title);
        $tpl->assign("currentyear", date('Y'));
        $tpl->assign("error_msg", "Invalid message content");
        echo $tpl->draw('header', true);
        echo $tpl->draw('error', true);
        echo $tpl->draw('footer', true);
        exit;
    }

    $clean = clean_message(stripslashes($msg));
    $clean = smiley_face($clean);

    if (updatePostById($postid, $userid, $clean, $hide)) {
        header('Location: user_manage_posts.php');
        exit;
    }

    $tpl = new RainTPL;
    $tpl->assign("theme", $theme);
    $tpl->assign("title", $title);
    $tpl->assign("currentyear", date('Y'));
    $tpl->assign("error_msg", "Unable to update the post.");
    echo $tpl->draw('header', true);
    echo $tpl->draw('error', true);
    echo $tpl->draw('footer', true);
    exit;
}

$tpl = new RainTPL;
$tpl->assign('theme', $theme);
$tpl->assign('title', $title);
$tpl->assign('headingtitletxt', $headingtitletxt);
$tpl->assign('addentrytxt', $addentrytxt);
$tpl->assign('viewguestbooktxt', $viewguestbooktxt);
$tpl->assign('newpostfirsttxt', $newpostfirsttxt);
$tpl->assign('newpostlasttxt', $newpostlasttxt);
$tpl->assign('searchlabeltxt', $searchlabeltxt);
$tpl->assign('searchbuttontxt', $searchbuttontxt);
$tpl->assign('currentyear', date('Y'));
$tpl->assign('goback', $goback);
$tpl->assign('langCode', $default_language[1]);
$tpl->assign('langCharSet', $default_language[4]);
$tpl->assign('lang_select_array', getLanguageArray($language_array));
$tpl->assign('yournametxt', $yournametxt);
$tpl->assign('youremailtxt', $youremailtxt);
$tpl->assign('yourMessagetxt', $yourMessagetxt);
$tpl->assign('submitbutton', isset($info3)?$info3:'Save');
$tpl->assign('hideemailtxt', $hideemailtxt);
$tpl->assign('let_user_hide_email', $let_user_hide_email);
$tpl->assign('logintxt', $logintxt);
$tpl->assign('logouttxt', $logouttxt);
$tpl->assign('registertxt', $registertxt);
$tpl->assign('info2', $info2);
$tpl->assign('loginusermanageposts', $login_allow_post_delete);
$tpl->assign('info4', $info4);
$tpl->assign('loginemail', $_SESSION['login_email']);
$tpl->assign('loginname', $thePost->gbFrom);
$tpl->assign('postid', $thePost->id);
$tpl->assign('postid_url', rawurlencode($thePost->id));
$tpl->assign('postmessage', $postMessagePlain);
$tpl->assign('outputfrom', $thePost->gbFrom);
$tpl->assign('outputemail', $thePost->gbEmail);
$tpl->assign('outputhideemail', $thePost->gbHideEmail);
$tpl->assign('tokenid', $token_id);
$tpl->assign('tokenvalue', $token_value);

// Render edit form that mirrors add entry page
echo $tpl->draw('user_edit_post', true);

?>