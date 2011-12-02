<!-- guestbook_new_entry_page_template.php start-->

<script type="text/javascript" src="<?php echo @$guestbook_entry_javascript ? $guestbook_entry_javascript: 'includes/guestbook_entry.js' ?>"></script>

<p class="newRecordTemplate">
    <div class='gbookRecordBanner'></div>
    <div class='newGbookRecordSection'>

<div class="smileyImages">
	<a href="javascript:emoticon(':D')"><img src="images/icon_biggrin.gif" border="0" alt="Very Happy" title="Very Happy"></a>&nbsp;&nbsp;&nbsp;
	<a href="javascript:emoticon(':)')"><img src="images/icon_smile.gif" border="0" alt="Smile" title="Smile"></a>&nbsp;&nbsp;&nbsp;
	<a href="javascript:emoticon(':(')"><img src="images/icon_sad.gif" border="0" alt="Sad" title="Sad"></a>&nbsp;&nbsp;&nbsp;
	<a href="javascript:emoticon(':o')"><img src="images/icon_surprised.gif" border="0" alt="Surprised" title="Surprised"></a>&nbsp;&nbsp;&nbsp;
	<a href="javascript:emoticon(':shock:')"><img src="images/icon_eek.gif" border="0" alt="Shocked" title="Shocked"></a>&nbsp;&nbsp;&nbsp;
	<a href="javascript:emoticon(':?')"><img src="images/icon_confused.gif" border="0" alt="Confused" title="Confused"></a>&nbsp;&nbsp;&nbsp;
	<a href="javascript:emoticon(':cool:')"><img src="images/icon_cool.gif" border="0" alt="Cool" title="Cool"></a>&nbsp;&nbsp;&nbsp;
	<a href="javascript:emoticon(':lol:')"><img src="images/icon_lol.gif" border="0" alt="Laughing" title="Laughing"></a>&nbsp;&nbsp;&nbsp;
	<a href="javascript:emoticon(':x')"><img src="images/icon_mad.gif" border="0" alt="Mad" title="Mad"></a>&nbsp;&nbsp;&nbsp;
	<a href="javascript:emoticon(':P')"><img src="images/icon_razz.gif" border="0" alt="Razz" title="Razz"></a>
    </div>

    <div class="smileyImages">
	<a href="javascript:emoticon(':oops:')"><img src="images/icon_redface.gif" border="0" alt="Embarassed" title="Embarassed"></a>&nbsp;&nbsp;&nbsp;
	<a href="javascript:emoticon(':cry:')"><img src="images/icon_cry.gif" border="0" alt="Crying" title="Crying"></a>&nbsp;&nbsp;&nbsp;
	<a href="javascript:emoticon(':evil:')"><img src="images/icon_evil.gif" border="0" alt="Evil or Very Mad" title="Evil or Very Mad"></a>&nbsp;&nbsp;&nbsp;
	<a href="javascript:emoticon(':twisted:')"><img src="images/icon_twisted.gif" border="0" alt="Twisted Evil" title="Twisted Evil"></a>&nbsp;&nbsp;&nbsp;
	<a href="javascript:emoticon(':roll:')"><img src="images/icon_rolleyes.gif" border="0" alt="Rolling Eyes" title="Rolling Eyes"></a>&nbsp;&nbsp;&nbsp;
	<a href="javascript:emoticon(':wink:')"><img src="images/icon_wink.gif" border="0" alt="Wink" title="Wink"></a>&nbsp;&nbsp;&nbsp;
	<a href="javascript:emoticon(':!:')"><img src="images/icon_exclaim.gif" border="0" alt="Exclamation" title="Exclamation"></a>&nbsp;&nbsp;&nbsp;
	<a href="javascript:emoticon(':?:')"><img src="images/icon_question.gif" border="0" alt="Question" title="Question"></a>&nbsp;&nbsp;&nbsp;
	<a href="javascript:emoticon(':idea:')"><img src="images/icon_idea.gif" border="0" alt="Idea" title="Idea"></a>&nbsp;&nbsp;&nbsp;
	<a href="javascript:emoticon(':arrow:')"><img src="images/icon_arrow.gif" border="0" alt="Arrow" title="Arrow"></a>
     </div>

<p>
     <input type="button" id="bold" value="Bold" /> &nbsp;&nbsp;
     <input type="button" id="italic" value="Italic" /> &nbsp;&nbsp;
     <input type="button" id="underline" value="Underline" /> &nbsp;&nbsp;
     <input type="button" id="center" value="Center" />
</p>

<br>
<form name="post" action="<?php echo $form_processor ?>" method="post" accept-charset="utf-8">
<input type="text" style="display: none" value="<?php echo $id_value ?>" name="id" />
<p class="newRecordInputBox">
<span class="younametext"><?php echo $yournametxt; ?><br><br>
<?php echo $youremailtxt; ?>
<?php
     if($image_verify == 1 && $inside_admin_area != "1")
     {
      echo '<br><br>Verify:';
     }
?>
<br><br><br><br><br><br><?php echo $yourMessagetxt; ?>
</span><span class="yourNameTextInput"><input type="text" name="yourname" value="<?php echo @$your_name_value ?>" size="20" /><br><br>
<input type="text" name="youremail" size="20" value="<?php echo @$your_email_value ?>" />
<?php
     if($image_verify == 1 && $inside_admin_area != "1")
     {
      echo '<br><br><span class="varify"><input type="text" name="txtNumber" size="20" value="">&nbsp;&nbsp;<img src="includes/random.php" align="center"></span>';
     }
?>
<br><br>
<textarea id="yourmessage" name="yourmessage" cols="40" rows="12"><?php echo @$your_message_value ?></textarea>
<?php
	 if ($image_verify == 2 && $inside_admin_area != "1")
	 {
		$error = null;
		echo '<br><br><center><span class="varify">'.recaptcha_get_html($recaptcha_public_key, $error).'</span></center>';
	 }
?>
<p class="newRecordsubmitButton">
<input type="submit" name="ok" value="<?php echo $submitbutton; ?>"></p></div>
</span>
</form>
<br>

</p>
</form>
</div>
</p>

<!-- guestbook_new_entry_page_template.php end -->