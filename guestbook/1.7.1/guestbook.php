<?php
include("header.php");
//include("language/language.php");
?>

<script language="JavaScript" type="text/javascript">
function emoticon(text) {
	var txtarea = document.post.yourmessage;
	text = ' ' + text + ' ';
	if (txtarea.createTextRange && txtarea.caretPos) {
		var caretPos = txtarea.caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? caretPos.text + text + ' ' : caretPos.text + text;
		txtarea.focus();
	} else {
		txtarea.value  += text;
		txtarea.focus();
	}
}

function bbcode(text) {
	var txtarea = document.post.yourmessage;
	text = ' ' + text + ' ';
	if (txtarea.createTextRange && txtarea.caretPos) {
		var caretPos = txtarea.caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? caretPos.text + text + ' ' : caretPos.text + text;
		txtarea.focus();
	} else {
		txtarea.value  += text;
		txtarea.focus();
	}
}

</script>
<table bgcolor=#EFEFEF bordercolor=#C0C0C0 border=1 width=500 cellspacing=0 cellpadding=10><tr><td background="images/toolbar.jpg" height="20"></td></tr><tr><td>
<!-- Smiley List Starts Here -->
<center>
<table width="100" border="0" cellspacing="0" cellpadding="5">
				<tr align="center" valign="middle">
				  <td><a href="javascript:emoticon(':D')"><img src="images/icon_biggrin.gif" border="0" alt="Very Happy" title="Very Happy"></a></td>
				  <td><a href="javascript:emoticon(':)')"><img src="images/icon_smile.gif" border="0" alt="Smile" title="Smile"></a></td>
				  <td><a href="javascript:emoticon(':(')"><img src="images/icon_sad.gif" border="0" alt="Sad" title="Sad"></a></td>
				  <td><a href="javascript:emoticon(':o')"><img src="images/icon_surprised.gif" border="0" alt="Surprised" title="Surprised"></a></td>
				  <td><a href="javascript:emoticon(':shock:')"><img src="images/icon_eek.gif" border="0" alt="Shocked" title="Shocked"></a></td>
				  <td><a href="javascript:emoticon(':?')"><img src="images/icon_confused.gif" border="0" alt="Confused" title="Confused"></a></td>
				  <td><a href="javascript:emoticon(':cool:')"><img src="images/icon_cool.gif" border="0" alt="Cool" title="Cool"></a></td>
				  <td><a href="javascript:emoticon(':lol:')"><img src="images/icon_lol.gif" border="0" alt="Laughing" title="Laughing"></a></td>
				  <td><a href="javascript:emoticon(':x')"><img src="images/icon_mad.gif" border="0" alt="Mad" title="Mad"></a></td>
				  <td><a href="javascript:emoticon(':P')"><img src="images/icon_razz.gif" border="0" alt="Razz" title="Razz"></a></td>
				  </tr>
				<tr align="center" valign="middle">
				  <td><a href="javascript:emoticon(':oops:')"><img src="images/icon_redface.gif" border="0" alt="Embarassed" title="Embarassed"></a></td>
				  <td><a href="javascript:emoticon(':cry:')"><img src="images/icon_cry.gif" border="0" alt="Crying" title="Crying"></a></td>
				  <td><a href="javascript:emoticon(':evil:')"><img src="images/icon_evil.gif" border="0" alt="Evil or Very Mad" title="Evil or Very Mad"></a></td>
				  <td><a href="javascript:emoticon(':twisted:')"><img src="images/icon_twisted.gif" border="0" alt="Twisted Evil" title="Twisted Evil"></a></td>
				  <td><a href="javascript:emoticon(':roll:')"><img src="images/icon_rolleyes.gif" border="0" alt="Rolling Eyes" title="Rolling Eyes"></a></td>
				  <td><a href="javascript:emoticon(':wink:')"><img src="images/icon_wink.gif" border="0" alt="Wink" title="Wink"></a></td>
				  <td><a href="javascript:emoticon(':!:')"><img src="images/icon_exclaim.gif" border="0" alt="Exclamation" title="Exclamation"></a></td>
				  <td><a href="javascript:emoticon(':?:')"><img src="images/icon_question.gif" border="0" alt="Question" title="Question"></a></td>
				  <td><a href="javascript:emoticon(':idea:')"><img src="images/icon_idea.gif" border="0" alt="Idea" title="Idea"></a></td>
				  <td><a href="javascript:emoticon(':arrow:')"><img src="images/icon_arrow.gif" border="0" alt="Arrow" title="Arrow"></a></td>
				</tr>
</table>
</center><center>
<table width="100" border="0" cellspacing="0" cellpadding="5">
				<tr align="center" valign="middle">
				<td><input type="button" class="button" value=" Bold " style="font-weight:bold; width: 50px" onClick="javascript:bbcode('[b] [/b]')"></td>
				<td><input type="button" class="button" value=" Underline " style="font-weight:bold; width: 80px" onClick="javascript:bbcode('[u] [/u]')"></td>
				<td><input type="button" class="button" value=" Italic " style="font-weight:bold; width: 50px" onClick="javascript:bbcode('[i] [/i]')"></td>
				<td><input type="button" class="button" value=" Center " style="font-weight:bold; width: 70px" onClick="javascript:bbcode('[center] [/center]')"></td>
				</tr>
</table>
</center>
<!-- Smiley List Stops Here -->


<br>
<form name="post" action="add.php" method="post">
			<table border="0" cellpadding="0" cellspacing="2">
				<tr>
					<td>
						<p><b><font size="2"><?php echo $yournametxt; ?></font></b></p>
					</td>
					<td><input type="text" name="yourname" size="20"></td>
				</tr>
				<tr>
					<td>
						<p><b><font size="2"><?php echo $youremailtxt; ?></font></b></p>
					</td>
					<td><input type="text" name="youremail" size="20" value=""></td>
				</tr>
				<?php
				     if($image_verify == 1)
				     {
				       echo '<tr><td><p><b><font size="2">Verify:</font></b></p></td><td><input type="text" name="txtNumber" size="20" value=""><img src="random.php"></td></tr>';
				     }
				?>
				<tr>
					<td>
						<p><b><font size="2"><?php echo $yourMessagetxt; ?></font></b></p>
					</td>
					<td>
						<div align="right">
							<textarea name="yourmessage" cols="45" rows="10"></textarea></div>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<div align="right">
							<input type="submit" name="ok" value="<?php echo $submitbutton; ?>">
					</td>
				</tr>
			</table>
		</form>
		
</td></tr></table><!-- End of toolbar table -->


<?php
include("footer.php");
?>
