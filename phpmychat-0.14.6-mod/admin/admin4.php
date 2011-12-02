<?php
// This sheet is diplayed when the admin wants to send an e-mail to registered users
// Credit for it goes to Christian Hacker <c.hacker@dreamer-chat.de>

// The admin has required an action to be done
if (isset($FORM_SEND) && $FORM_SEND == 4)
{
	// Sending the mails when at least an user has been selected and subject and message
	// have been filled
	if (count($SendTo) > 0 && trim($subject) != "" && trim($message) != "")
	{
		include('./admin/mail4admin.lib.php');
		for (reset($SendTo); $mailTo=current($SendTo); next($SendTo))
		{
			$Send = send_email($mailTo,$subject,$message);
			if (!$Send) break;
		};
		$Message = ($Send ? A_SHEET4_7 : A_SHEET4_8);
		$MsgStyle = ($Send ? "success" : "error");
	}
	else
	{
		$Message = A_SHEET4_9;
		$MsgStyle = "error";
	};
};
?>

<P CLASS=title><?php echo(A_SHEET4_1); ?></P>

<?php
if (isset($Message) && $Message != "") echo("<P CLASS=\"$MsgStyle\">$Message</P><BR>\n");
?>

<TABLE CLASS=table>

<?php
// Display an error message if the administrator doesn't complete required variables in 'mail4admin.lib.php'
if (isset($ReqVar) && $ReqVar == "1")
{
	?>
	<TR>
		<TD ALIGN=CENTER CLASS=error><?php echo(A_SHEET4_0); ?></TD>
	</TR>

	<?php
}
else
{

	// Ensure at least one registered user exist (exept the administrator) before displaying the mail form
	$DbLink->query("SELECT COUNT(*) FROM ".C_REG_TBL." WHERE perms != 'admin' LIMIT 1");
	list($count_RegUsers) = $DbLink->next_record();
	$DbLink->clean_results();
	if ($count_RegUsers != 0)
	{
	?>
	<!-- Mail form -->
	<TR>
		<TD ALIGN=CENTER>
			<FORM ACTION="<?php echo("$From?$URLQueryBody"); ?>" METHOD="POST" AUTOCOMPLETE="OFF" NAME="MailForm">
			<INPUT TYPE=hidden NAME="From" value="<?php echo($From); ?>">
			<INPUT TYPE=hidden NAME="pmc_username" value="<?php echo(htmlspecialchars(stripslashes($pmc_username))); ?>">
			<INPUT TYPE=hidden NAME="pmc_password" value="<?php echo($pmc_password); ?>">
			<INPUT TYPE=hidden NAME="FORM_SEND" value="4">
			<TABLE BORDER=0 CELLSPACING=5 WIDTH=100%>
			<TR>

				<!-- Addressees list -->
				<TD VALIGN=TOP>
				<TABLE BORDER=0 WIDTH=100%>
				<TR>
					<TD ALIGN=CENTER><?php echo(A_SHEET4_2); ?></TD>
				</TR>
				<TR>
					<TD ALIGN=CENTER>
						<SELECT NAME="SendTo[]" MULTIPLE SIZE=15>
						<?php
						$DbLink->query("SELECT username,email FROM ".C_REG_TBL." WHERE perms != 'admin' ORDER BY username");
						while (list($U,$EMail) = $DbLink->next_record())
						{
							echo("<OPTION VALUE=\"$EMail\">".$U."</OPTION>");
						}
						$DbLink->clean_results();
						?>
						</SELECT>
					</TD>
				</TR>
				<TR><TD>&nbsp;</TD></TR>
				<TR>
					<TD ALIGN=CENTER>
						<INPUT TYPE=button VALUE="<?php echo(A_SHEET4_3); ?>" onClick="for (var i = 0; i < document.forms['MailForm'].elements['SendTo[]'].options.length; i++) {document.forms['MailForm'].elements['SendTo[]'].options[i].selected=true;}">
					</TD>
				</TR>
				</TABLE>
				</TD>

				<TD>&nbsp;</TD>

				<!-- Subject and message -->
				<TD>
				<TABLE BORDER=0 WIDTH=100%>
				<TR>
					<TD VALIGN=CENTER ALIGN="<?php echo($CellAlign); ?>"><?php echo(A_SHEET4_4); ?></TD>
					<TD VALIGN=CENTER ALIGN="<?php echo($CellAlign); ?>">
						<INPUT TYPE="text" NAME="subject" SIZE="30" VALUE="<?php echo("[".APP_NAME."] "); ?>">
					</TD>
				</TR>
				<TR>
					<TD VALIGN=TOP ALIGN="<?php echo($CellAlign); ?>"><?php echo(A_SHEET4_5); ?></TD>
					<TD VALIGN=CENTER ALIGN=CENTER>
						<TEXTAREA NAME="message" WRAP="on" COLS="70" ROWS="14"></TEXTAREA>
					</TD>
				</TR>
				<TR><TD>&nbsp;</TD></TR>
				<TR>
					<TD>&nbsp;</TD>
					<TD VALIGN=CENTER ALIGN="<?php echo($InvCellAlign); ?>">
						<INPUT TYPE="submit" NAME="submit_type" VALUE="<?php echo(A_SHEET4_6); ?>">
					</TD>
				</TR>
				</TABLE>
				</TD>
			</TR>
			</TABLE>
			</FORM>
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
};
?>

</TABLE>

<?php
?>