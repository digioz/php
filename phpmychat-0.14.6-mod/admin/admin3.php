<?php
// This sheet is diplayed when the admin wants to clean some rooms

if (isset($FORM_SEND) && $FORM_SEND == 3)
{
	for (reset($DelRooms); $room=current($DelRooms); next($DelRooms))
	{
		// Kicks users that are in the room
		$DbLink->query("UPDATE ".C_USR_TBL." SET status='d' WHERE room='$room'");
		$DbLink->query("SELECT COUNT(*) FROM ".C_USR_TBL." WHERE room='$room'");
		list($anybody) = $DbLink->next_record();
		$DbLink->clean_results();
		$i = time() + 20;	// let the time to users to be 'kicked' (max=20 sec)
		while ($anybody != 0 && time() < $i)
		{
			$DbLink->query("SELECT COUNT(*) FROM ".C_USR_TBL." WHERE room='$room'");
			list($anybody) = $DbLink->next_record();
			$DbLink->clean_results();
			sleep(2);
		}
		// Remove permissions for that room when it's not a default one (define in config.lib.php)
		if (!room_in(stripslashes($room), $DefaultChatRooms))
		{
			$UpdLink = new DB;
			$DbLink->query("SELECT username,rooms FROM ".C_REG_TBL." WHERE perms='moderator'");
			while (list($mod_un,$mod_rooms) = $DbLink->next_record())
			{
				$changed = false;
				$roomTab = explode(",",$mod_rooms);
				for ($i = 0; $i < count($roomTab); $i++)
				{
					if (strcasecmp(stripslashes($room), $roomTab[$i]) == 0)
					{
						$roomTab[$i] = "";
						$changed = true;
						break;
					};
				};
				if ($changed)
				{
					$mod_rooms = str_replace(",,",",",ereg_replace("^,|,$","",implode(",",$roomTab)));
					$UpdLink->query("UPDATE ".C_REG_TBL." SET rooms='".addslashes($mod_rooms)."' WHERE username='".addslashes($mod_un)."'");
				};
				unset($roomTab);
			};
			$DbLink->clean_results();
		};
		// Clean the room;
		$DbLink->query("DELETE FROM ".C_USR_TBL." WHERE room='$room'");
		$DbLink->query("DELETE FROM ".C_MSG_TBL." WHERE room='$room'");
	};
	// Optimize the messages table when a MySQL DB is used
	$DbLink->optimize(C_MSG_TBL);
};
?>

<P CLASS=title><?php echo(A_SHEET3_1); ?></P>

<TABLE BORDER=0 CELLPADDING=3 CLASS=table>

<?php
// Ensure at least one room can be cleaned before displaying the form to do this
$DbLink->query("SELECT COUNT(*) FROM ".C_MSG_TBL." LIMIT 1");
list($count_Rooms) = $DbLink->next_record();
$DbLink->clean_results();
if ($count_Rooms != 0)
{
?>

<!-- Form to clean rooms -->
<TR>
	<TD ALIGN=CENTER>
		<FORM ACTION="<?php echo("$From?$URLQueryBody"); ?>" METHOD="POST" AUTOCOMPLETE="OFF" NAME="Form2">
		<INPUT TYPE=hidden NAME="From" value="<?php echo($From); ?>">
		<INPUT TYPE=hidden NAME="pmc_username" value="<?php echo(htmlspecialchars(stripslashes($pmc_username))); ?>">
		<INPUT TYPE=hidden NAME="pmc_password" value="<?php echo($pmc_password); ?>">
		<INPUT TYPE=hidden NAME="FORM_SEND" value="3">
		<TABLE BORDER=0 WIDTH=100%>
		<TR>
			<TD VALIGN=CENTER ALIGN=CENTER>
				<FONT size=-1><?php echo(A_SHEET3_2); ?></FONT>
			</TD>
		</TR>
		<TR>
			<TD ALIGN=CENTER>
				<SELECT NAME="DelRooms[]" MULTIPLE SIZE=6>
				<?php
				$DbLink->query("SELECT DISTINCT room FROM ".C_MSG_TBL);
				while (list($room) = $DbLink->next_record())
				{
					echo("<OPTION VALUE=\"".htmlspecialchars($room)."\"");
					echo(">".$room."</OPTION>");
				}
				$DbLink->clean_results();
				?>
				</SELECT>
			</TD>
		</TR>
		</TABLE>
		<P>
		<INPUT TYPE="submit" NAME="submit_type" VALUE="<?php echo(A_SHEET3_3); ?>">
		</P>
		</FORM>
	</TD>
</TR>

<?php
}
else
{
?>

<TR>
	<TD ALIGN=CENTER CLASS=error><?php echo(A_SHEET3_4); ?></TD>
</TR>

<?php
};
?>

</TABLE>

<?php
?>