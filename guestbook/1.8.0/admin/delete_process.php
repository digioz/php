<?php

session_start();

include("login_check.php");
include("../includes/class.gbXML.php");
include("../config.php");
include("../$language_file");



echo '<?xml version="1.0" encoding="UTF-8"?>';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $lang ?>" lang="<?php echo $lang ?>">
<head><title>DigiOz Guestbook Administrative Interface</title>
	<link rel="STYLESHEET" type="text/css" href="<?php echo '../templates/'.$template_folder.'/style.css'?>">
</head>
<body>

<br>
<h2>Guestbook Admin Interface</h2>

<?php

//GET AN INSTANCE OF GBXML
$data_type = 'messages';
$record_delim = 'message';
$filename = '../data/data.xml';

$gbXML = new gbXML($data_type, $record_delim, $filename);

// Validate browser input ------------------------------------------------------------
$id = isset($_GET['id']) ? $_GET['id'] : FALSE;
$order= isset($_GET['order']) ? $_GET['order'] : FALSE;


$error = FALSE;

if ( !is_numeric($id) )
{
    $error = TRUE;
    $errorMsg = 'The ID provided is not a number.';
}
else if ( !$gbXML->tag_and_value_exist('id', $id) )
{
    $error=TRUE;
    $errorMsg = 'The ID provided does not match any record in the GuestBook.';

}
//REMOVE THE RECORD FROM THE DATA.XML FILE
//If we fail, set the error flag
if ( $gbXML->delete_record_from_file($id) === FALSE )
{
    $error = TRUE;
    $errorMsg = 'An unknown error occurred: the guest book record could not be deleted.';

}

if ($error === TRUE)
{
    echo <<<HTML
	<p class="error">$errorMsg</p>
    <p><a href="modify.php">Back to Delete Menu</a></p>
    <p>
	<a href="index.php">Admin Main</a> - <a href="login.php?mode=logout">Logout</a>
    </p>
	</body>
	</html>
HTML;

    exit();
}


?>

    <p class="alert">Message Deleted!</p>
    <p><a href="modify.php">Back to Edit / Delete Menu</a></p>

    <p id="bottomMenu" ><a href="index.php">Admin Main</a> - <a href="login.php?mode=logout">Logout</a></p>

</body>
</html>