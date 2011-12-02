<?php
// This sheet is diplayed when the admin wants to modify perms for registered users
// or remove the profiles of some of them

// The admin has required an action to be done
if (isset($FORM_SEND) && $FORM_SEND == 1)
{
	// A registred user have to be deleted or banished?
	$DELETE_MODE = (stripslashes($submit_type) == A_SHEET1_6)? 1:0;
	$BANISH_MODE = (stripslashes($submit_type) == A_SHEET1_9)? 1:0;

	// Get the list of the users
	$DbLink->query("SELECT username,perms FROM ".C_REG_TBL." WHERE perms != 'admin'");
	$users = Array();
	while (list($username, $perms) = $DbLink->next_record())
	{
		$users[] = $username;
	}
	$DbLink->clean_results();

	for (reset($users); $username=current($users); next($users))
	{
		$usrHash = md5($username);
		$VarName = "user_".$usrHash;
		if (!isset($$VarName)) continue;
		// Delete a profile after having sent a message to the user if he is connected
		if ($DELETE_MODE)
		{
			$VarName = "selected_".$usrHash;
			if (isset($$VarName))
			{
				$uuu = addslashes($username);
				$DbLink->query("DELETE FROM ".C_REG_TBL." WHERE username='$uuu'");
				$DbLink->query("SELECT room FROM ".C_USR_TBL." WHERE username='$uuu' LIMIT 1");
				$in_room = ($DbLink->num_rows() != 0);
				if ($in_room)
				{
					list($room) = $DbLink->next_record();
					$DbLink->clean_results();
					$DbLink->query("SELECT type FROM ".C_MSG_TBL." WHERE room='".addslashes($room)."' LIMIT 1");
					list($type) = $DbLink->next_record();
					$DbLink->clean_results();
					$DbLink->query("UPDATE ".C_USR_TBL." SET status='u' WHERE username='$uuu'");
					$DbLink->query("INSERT INTO ".C_MSG_TBL." VALUES ('$type', '".addslashes($room)."', 'SYS delreg', '', ".time().", '$uuu', 'L_ADM_2')");
				};
				// Optimize the registered users table when a MySQL DB is used
				$DbLink->optimize(C_REG_TBL);
			};
		}
		// Banish an user
		elseif ($BANISH_MODE)
		{
			$VarName = "selected_".$usrHash;
			if (isset($$VarName))
			{
				$uuu = addslashes($username);
				$DbLink->query("SELECT latin1,ip FROM ".C_REG_TBL." WHERE username='$uuu' LIMIT 1");
				list($Latin1, $IP) = $DbLink->next_record();
				$DbLink->clean_results();
				$DbLink->query("SELECT count(*) FROM ".C_BAN_TBL." WHERE username='$uuu' LIMIT 1");
				list($Nb) = $DbLink->next_record();
				$DbLink->clean_results();
				if ($Nb == "0")
				{
					$Until = time() + round(C_BANISH * 60 * 60 * 24);
					if ($Until > 2147483647) $Until = "2147483647";
					$DbLink->query("INSERT INTO ".C_BAN_TBL." VALUES ('$uuu','$Latin1','$IP','**ToDefine**','$Until')");
				};
				$Warning = A_SHEET1_10;
			};
		}
		// Modify perms for a registered user and send him a message if he is connected
		else
		{
			$VarName = "perms_".$usrHash; $ppp = $$VarName;
			$VarName = "rooms_".$usrHash; $rrr = $$VarName;
			$VarName = "old_perms_".$usrHash; $old_ppp = $$VarName;
			$VarName = "old_rooms_".$usrHash; $old_rrr = $$VarName;
			if ($ppp == $old_ppp && $rrr == $old_rrr) continue;
			$uuu = addslashes($username);
			$DbLink->query("UPDATE ".C_REG_TBL." SET perms='$ppp', rooms='$rrr' WHERE username='$uuu'");
			$DbLink->query("SELECT room FROM ".C_USR_TBL." WHERE username='$uuu' LIMIT 1");
			$in_room = ($DbLink->num_rows() != 0);
			if ($in_room)
			{
				list($room) = $DbLink->next_record();
				$DbLink->clean_results();

				// Find the changes in moderated rooms list
				if ($ppp != $old_ppp)
				{
					if ($ppp == 'user')
						$diff_rooms = explode(",", $old_rrr);
					else
						$diff_rooms = explode(",", $rrr);
				}
				else
				{
					$old_rooms_Tab = explode(",",$old_rrr);
					$new_rooms_Tab = explode(",",$rrr);
					$diff_rooms_Tab = array();
					for (reset($old_rooms_Tab); $room2Check=current($old_rooms_Tab); next($old_rooms_Tab))
					{
						if ($room2Check == "") continue;
						if (!room_in($room2Check, $rrr)) $diff_rooms_Tab[] = $room2Check;
					}
					for (reset($new_rooms_Tab); $room2Check=current($new_rooms_Tab); next($new_rooms_Tab))
					{
						if ($room2Check == "") continue;
						if (!room_in($room2Check, $old_rrr)) $diff_rooms_Tab[] = $room2Check;
					}
					unset($old_rooms_Tab);
					unset($new_rooms_Tab);

					if (count($diff_rooms_Tab) > 0)
						$diff_rooms = str_replace(",,",",",ereg_replace("^,|,$","",implode(",",$diff_rooms_Tab)));
					unset($diff_rooms_Tab);
				}

				// Send a message to the user if he chats into one of the 'diff' rooms
				if (room_in(addslashes($room), $diff_rooms))
				{
					if ($ppp == 'moderator' && room_in(addslashes($room), $rrr))	// user becomes moderator for the room he chats into
					{
						$status = "m";
						$message = "sprintf(L_MODERATOR, \"".addslashes(htmlspecialchars(stripslashes($uuu)))."\")";
					}
					else	// user becomes user for the room he chats into
					{
						$status = "r";
						$message = "sprintf(L_ADM_1, \"".addslashes(htmlspecialchars(stripslashes($uuu)))."\")";
					};
					$DbLink->query("UPDATE ".C_USR_TBL." SET status='$status' WHERE username='$uuu'");
					$DbLink->query("SELECT type FROM ".C_MSG_TBL." WHERE room='".addslashes($room)."' LIMIT 1");
					list($type) = $DbLink->next_record();
					$DbLink->clean_results();
					$DbLink->query("INSERT INTO ".C_MSG_TBL." VALUES ('$type', '".addslashes($room)."', 'SYS promote', '', ".time().", '', '$message')");
				};
			}
			else
			{
				$DbLink->clean_results();
			};
		};
	};
};

// Remove profiles of users that have not been chatting for a time > C_REG_DEL
if (!isset($FORM_SEND) && C_REG_DEL != 0) $DbLink->query("DELETE FROM ".C_REG_TBL." WHERE reg_time < ".(time() - C_REG_DEL * 60 * 60 * 24)." AND perms != 'admin'");

// Remove moderator status if no room is specified
$DbLink->query("UPDATE ".C_REG_TBL." SET perms='user' WHERE perms='moderator' AND rooms=''");
?>

<SCRIPT TYPE="text/javascript" LANGUAGE="javascript">
<!--
// Ensure an user for who a room name is entered have moderator status
function reset_perms(user)
{
	if (document.all) {
		var1 = document.all["perms_" + user];
		var2 = document.all["rooms_" + user];
	} else if (document.forms['Form1'].elements) {
		var1 = document.forms['Form1'].elements["perms_" + user];
		var2 = document.forms['Form1'].elements["rooms_" + user];
	} else {
		return;
	}
	i = (var2.value == '' ? 0:1);
	var1.options[i].selected = true;
}
// -->
</SCRIPT>

<P CLASS=title><?php echo(A_SHEET1_1); ?></P>

<?php
if (isset($Warning) && $Warning != "") echo("<P CLASS=\"success\">$Warning</SPAN></P><BR>\n");
?>

<TABLE BORDER=0 CELLPADDING=3 CLASS="table">

<?php
// Ensure at least one registered user exist (exept the administrator) before displaying the modify status
$DbLink->query("SELECT COUNT(*) FROM ".C_REG_TBL." WHERE perms != 'admin' LIMIT 1");
list($count_RegUsers) = $DbLink->next_record();
$DbLink->clean_results();
if ($count_RegUsers != 0)
{
?>
<!-- Registered users form -->
<TR>
	<TD ALIGN=CENTER>
		<FORM ACTION="<?php echo("$From?$URLQueryBody"); ?>" METHOD="POST" AUTOCOMPLETE="OFF" NAME="Form1">
		<INPUT TYPE=hidden NAME="From" value="<?php echo($From); ?>">
		<INPUT TYPE=hidden NAME="pmc_username" value="<?php echo(htmlspecialchars(stripslashes($pmc_username))); ?>">
		<INPUT TYPE=hidden NAME="pmc_password" value="<?php echo($pmc_password); ?>">
		<INPUT TYPE=hidden NAME="sortBy" value="<?php echo($sortBy); ?>">
		<INPUT TYPE=hidden NAME="sortOrder" value="<?php echo($sortOrder); ?>">
		<INPUT TYPE=hidden NAME="startReg" value="<?php echo($startReg); ?>">
		<INPUT TYPE=hidden NAME="FORM_SEND" value="1">
		<TABLE BORDER=0 CELLPADDING=5 CELLSPACING=1 WIDTH=100%>
		<TR CLASS=tabtitle>
			<TD VALIGN=CENTER ALIGN=CENTER>
				&nbsp;
			</TD>
			<TD VALIGN=CENTER ALIGN="<?php echo($CellAlign); ?>">
				<A HREF="<?php echo("$From?$URLQueryBody_SortLinks&sortBy=username"); if ($sortBy == "username") echo("&sortOrder=$New_sortOrder"); ?>"><?php echo(A_SHEET1_2); ?></A>
			</TD>
			<TD VALIGN=CENTER ALIGN=CENTER>
				<A HREF="<?php echo("$From?$URLQueryBody_SortLinks&sortBy=reg_time"); if ($sortBy == "reg_time") echo("&sortOrder=$New_sortOrder"); ?>"><?php echo(A_SHEET1_11); ?></A>
			</TD>
			<TD VALIGN=CENTER ALIGN=CENTER>
				<A HREF="<?php echo("$From?$URLQueryBody_SortLinks&sortBy=ip"); if ($sortBy == "ip") echo("&sortOrder=$New_sortOrder"); ?>"><?php echo(A_SHEET2_2); ?></A>
			</TD>
			<TD VALIGN=CENTER ALIGN=CENTER>
				<A HREF="<?php echo("$From?$URLQueryBody_SortLinks&sortBy=perms"); if ($sortBy == "perms") echo("&sortOrder=$New_sortOrder"); ?>"><?php echo(A_SHEET1_3); ?></A>
			</TD>
			<TD VALIGN=CENTER ALIGN=CENTER CLASS=tabtitle>
				<?echo(A_SHEET1_4)?> *
			</TD>
		</TR>

		<?php
		function special_char($str,$lang)
		{
			return ($lang ? htmlentities($str) : htmlspecialchars($str));
		}

		$lastPage_startReg = floor(($count_RegUsers - 1) / 10) * 10;
		if ($startReg > $lastPage_startReg) $startReg = $lastPage_startReg;
		if (C_DB_TYPE == "mysql") $limits = " LIMIT $startReg,10";
		elseif (C_DB_TYPE == "pgsql") $limits = " LIMIT 10 OFFSET $startReg";
		else $limits = "";

		$DbLink->query("SELECT username,latin1,perms,rooms,reg_time,ip FROM ".C_REG_TBL." WHERE perms != 'admin' ORDER BY $sortBy $sortOrder".$limits);
		while (list($username,$Latin1,$perms,$rooms,$lastTime,$IP) = $DbLink->next_record())
		{
			$usrHash = md5($username);
			?>
			<INPUT TYPE="hidden" NAME="user_<?echo($usrHash)?>" VALUE="1">
			<TR>
				<TD VALIGN=CENTER ALIGN=CENTER>
					<INPUT type=checkbox name="selected_<?echo($usrHash)?>" value="1">
				</TD>
				<TD VALIGN=CENTER ALIGN="<?php echo($CellAlign); ?>">
					<?echo(special_char($username,$Latin1));?>
				</TD>
				<TD VALIGN=CENTER ALIGN="<?php echo($CellAlign); ?>">
					<?echo(date("M j, Y - h:i a",$lastTime + C_TMZ_OFFSET*60*60));?>
				</TD>
				<TD VALIGN=CENTER ALIGN=CENTER>
					<?php echo($IP); ?>
				</TD>
				<TD VALIGN=CENTER ALIGN=CENTER>
					<SELECT name="perms_<?echo($usrHash)?>">
						<OPTION value="user"<?if($perms=="user") echo(" SELECTED")?>><?echo(A_USER)?></OPTION>
						<OPTION value="moderator"<?if($perms=="moderator") echo(" SELECTED")?>><?echo(A_MODER)?></OPTION>
					</SELECT>
					<INPUT type="hidden" name="old_perms_<?echo($usrHash)?>" value="<?echo($perms)?>">
				</TD>
				<TD VALIGN=CENTER ALIGN=CENTER>
					<INPUT type=text name="rooms_<?echo($usrHash)?>" value="<?echo(stripslashes(htmlspecialchars($rooms)))?>" SIZE="40" onChange="reset_perms('<?echo($usrHash)?>');">
					<INPUT type="hidden" name="old_rooms_<?echo($usrHash)?>" value="<?echo(htmlspecialchars($rooms))?>">
				</TD>
			</TR>
			<?
		};
		$DbLink->clean_results();
		?>
		<TR>
			<TD VALIGN=CENTER ALIGN=CENTER COLSPAN=6>
				<FONT size=-1>* <?echo(A_SHEET1_5)?></FONT>
			</TD>
		</TR>
		<TR><TD>&nbsp;</TD></TR>
		<TR>
			<TD VALIGN=CENTER ALIGN=CENTER COLSPAN=5>
				<INPUT TYPE="submit" NAME="submit_type" VALUE="<?php echo(A_SHEET1_6); ?>">
				<BR><BR>
				<INPUT TYPE="submit" NAME="submit_type" VALUE="<?php echo(A_SHEET1_9); ?>">
			</TD>
			<TD VALIGN=CENTER ALIGN=CENTER>
				<INPUT TYPE="submit" NAME="submit_type" VALUE="<?php echo(A_SHEET1_7); ?>">
			</TD>
		</TR>
		</TABLE>
		</FORM>

		<!-- Navigation cells at the footer -->
		<TABLE BORDER=0 CELLPADDING=5 CELLSPACING=0 CLASS="tabletitle" WIDTH=100%>
		<TR>
			<TD ALIGN="<?php echo($CellAlign); ?>" VALIGN=CENTER WIDTH=70 HEIGHT=20 CLASS=tabtitle>
			<?php
			if ($startReg > 0)
			{
				$downReg = $startReg - 10;
				if ($downReg < 0) $downReg = "0";
				?>
				&nbsp;<A HREF="<?php echo("$From?$URLQueryBody_MoveLinks&startReg=0"); ?>"><IMG SRC="images/admin/<?php echo($BeginGif); ?>" HEIGHT=20 WIDTH=21 BORDER=0></A>
				&nbsp;&nbsp;&nbsp;<A HREF="<?php echo("$From?$URLQueryBody_MoveLinks&startReg=$downReg"); ?>"><IMG SRC="images/admin/<?php echo($DownGif); ?>" HEIGHT=20 WIDTH=20 BORDER=0></A>
				<?php
			}
			else
			{
				echo("&nbsp");
			};
			?>
			</TD>
			<TD ALIGN=CENTER VALIGN=CENTER HEIGHT=20 CLASS=tabtitle>
				<SPAN CLASS="small">
				<?php
				$PageNum = ceil(($startReg + 1) / 10);
				$PagesCount = ceil($count_RegUsers / 10);
				echo(sprintf(A_PAGE_CNT,$PageNum,$PagesCount)."&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;$count_RegUsers ".A_MENU_1);
				?>
				</SPAN>
			</TD>
			<TD ALIGN="<?php echo($CellAlign); ?>" VALIGN=CENTER WIDTH=70 HEIGHT=20 CLASS=tabtitle>
			<?php
			if ($startReg < $lastPage_startReg)
			{
				$upReg = $startReg + 10;
				?>
				&nbsp;<A HREF="<?php echo("$From?$URLQueryBody_MoveLinks&startReg=$upReg"); ?>"><IMG SRC="images/admin/<?php echo($UpGif); ?>" HEIGHT=20 WIDTH=20 BORDER=0></A>
				&nbsp;&nbsp;&nbsp;<A HREF="<?php echo("$From?$URLQueryBody_MoveLinks&startReg=$lastPage_startReg"); ?>"><IMG SRC="images/admin/<?php echo($EndGif); ?>" HEIGHT=20 WIDTH=21 BORDER=0></A>
				<?php
			}
			else
			{
				echo("&nbsp");
			};
			?>
			</TD>
		</TR>
		</TABLE>
	</TD>
</TR>

<?php
}
else
{
?>

<TR>
	<TD ALIGN=CENTER CLASS=error><?php echo(A_SHEET1_8); ?></TD>
</TR>

<?php
};
?>

</TABLE>

<?php
?>