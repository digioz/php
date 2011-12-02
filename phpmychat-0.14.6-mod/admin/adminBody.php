<?php
// Ensure a moderator have such a status for the current room
function room_in($what, $in)
{
	$rooms = (is_array($in) ? $in : explode(",",$in));
	for (reset($rooms); $room_name=current($rooms); next($rooms))
	{
		if (strcasecmp($what, $room_name) == 0) return true;
	};
	return false;
};


$DbLink = new DB;

// Optimize MySQL table when the script run for the first time
if (isset($First))
{
	$DbLink->optimize(C_MSG_TBL);
	$DbLink->optimize(C_USR_TBL);
	$DbLink->optimize(C_REG_TBL);
	$DbLink->optimize(C_BAN_TBL);
};

if ($sheet < 3)
{
	// Inverse sort order
	if (!isset($sortBy)) $sortBy = "username";
	if (!isset($sortOrder)) $sortOrder = "ASC";
	$New_sortOrder = ($sortOrder == "ASC") ? "DESC" : "ASC";

	// Define the lower bound to be displayed for registered users table
	if (!isset($startReg)) $startReg = "0";
};

// Remove some var from the url query
$URLQueryBody = "What=Body&L=$L&sheet=$sheet";
if ($sheet < 3)
{
	$URLQueryBody_Links = "From=$From&".$URLQueryBody."&pmc_username=".urlencode($pmc_username)."&pmc_password=$pmc_password";
	$URLQueryBody_SortLinks = $URLQueryBody_Links."&startReg=$startReg";
	$URLQueryBody_MoveLinks = $URLQueryBody_Links."&sortBy=$sortBy&sortOrder=$sortOrder";
};

// Horizontal alignement for cells topic and gifs names

if ($Charset == "windows-1256")	// Arabic
{
	$CellAlign		= "RIGHT";
	$InvCellAlign	= "LEFT";
	$BeginGif		= "end.gif";
	$DownGif		= "up.gif";
	$EndGif		= "begin.gif";
	$UpGif		= "down.gif";
}
else
{
	$CellAlign		= "LEFT";
	$InvCellAlign	= "RIGHT";
	$BeginGif		= "begin.gif";
	$DownGif		= "down.gif";
	$EndGif		= "end.gif";
	$UpGif		= "up.gif";
};	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML dir="<?php echo(($Charset == "windows-1256") ? "RTL" : "LTR"); ?>">

<HEAD>
<TITLE><?php echo(APP_NAME); ?></TITLE>
<LINK REL="stylesheet" HREF="config/admin.css.php?<?php echo("Charset=${Charset}&medium=${FontSize}&FontName=".urlencode($FontName)); ?>" TYPE="text/css">
<?php
if ($sheet < 3)
{
	?>
	<SCRIPT TYPE="text/javascript" LANGUAGE="JavaScript1.2">
	<!--
	if (document.layers)
	{
		window.parent.sortBy = "<?php echo((isset($sortBy) && $sortBy != "") ? "&sortBy=$sortBy" : ""); ?>";
		window.parent.sortOrder = "<?php echo((isset($sortOrder) && $sortOrder != "") ? "&sortOrder=$sortOrder" : ""); ?>";
		window.parent.startReg = "<?php echo((isset($startReg) && $startReg != "") ? "&startReg=$startReg" : ""); ?>";
	};
	// -->
	</SCRIPT>
	<?php
};
?>
</HEAD>

<BODY>
<CENTER>
<?php
require("./admin/admin${sheet}.php");
?>
</CENTER>
</BODY>

</HTML>
<?php
$DbLink->close();
exit();
?>