<?php

// If form is submitted update values in the database 

if (isset($FORM_SEND) && $FORM_SEND == 5)
{
  while(list($name,$value) = each($HTTP_GET_VARS))
  {
           $$name = $value;
  };
  while(list($name,$value) = each($HTTP_POST_VARS))
  {
           $$name = $value;
  };
  
  $conn = mysql_connect(C_DB_HOST, C_DB_USER, C_DB_PASS) or die ('<center>Error: Could Not Connect To Database');
  mysql_select_db(C_DB_NAME);

  $query = "UPDATE c_config SET ".
            "MSG_DEL = '$vMSG_DEL', ".
            "USR_DEL = '$vUSR_DEL', ".
            "REG_DEL = '$vREG_DEL', ".
            "LANGUAGE = '$vLANGUAGE', ".
            "MULTI_LANG = '$vMULTI_LANG', ".
            "REQUIRE_REGISTER = '$vREQUIRE_REGISTER', ".
            "EMAIL_PASWD = '$vEMAIL_PASWD', ".
            "SHOW_ADMIN = '$vSHOW_ADMIN', ".
            "SHOW_DEL_PROF = '$vSHOW_DEL_PROF', ".
            "VERSION = '$vVERSION', ".
            "BANISH = '$vBANISH', ".
            "NO_SWEAR = '$vNO_SWEAR', ".
            "SAVE = '$vSAVE', ".
            "USE_SMILIES = '$vUSE_SMILIES', ".
            "HTML_TAGS_KEEP = '$vHTML_TAGS_KEEP', ".
            "HTML_TAGS_SHOW = '$vHTML_TAGS_SHOW', ".
            "TMZ_OFFSET = '$vTMZ_OFFSET', ".
            "MSG_ORDER = '$vMSG_ORDER', ".
            "MSG_NB = '$vMSG_NB', ".
            "MSG_REFRESH = '$vMSG_REFRESH', ".
            "SHOW_TIMESTAMP = '$vSHOW_TIMESTAMP', ".
            "NOTIFY = '$vNOTIFY', ".
            "WELCOME = '$vWELCOME'".
            " WHERE ID='0'";
   //echo $query;

   mysql_query($query);

   echo "<TABLE BORDER=0 CELLPADDING=3 CLASS=table><TR><TD ALIGN=CENTER>Configuration Settings Changed Successfully!</TD></TR></TABLE>";
}
else
{

// Credit for this goes to Pete Soheil <webmaster@digioz.com>.
$conn = mysql_connect(C_DB_HOST, C_DB_USER, C_DB_PASS) or die ('<center>Error: Could Not Connect To Database');
mysql_select_db(C_DB_NAME);

$query = "SELECT * FROM c_config";
$result = mysql_query($query);
$row = mysql_fetch_row($result);

$MSG_DEL          = $row[1];
$USR_DEL          = $row[2];
$REG_DEL          = $row[3];
$LANGUAGE         = $row[4];
$MULTI_LANG       = $row[5];
$REQUIRE_REGISTER = $row[6];
$EMAIL_PASWD      = $row[7];
$SHOW_ADMIN       = $row[8];
$SHOW_DEL_PROF    = $row[9];
$VERSION          = $row[10];
$BANISH           = $row[11];
$NO_SWEAR         = $row[12];
$SAVE             = $row[13];
$USE_SMILIES      = $row[14];
$HTML_TAGS_KEEP   = $row[15];
$HTML_TAGS_SHOW   = $row[16];
$TMZ_OFFSET       = $row[17];
$MSG_ORDER        = $row[18];
$MSG_NB           = $row[19];
$MSG_REFRESH      = $row[20];
$SHOW_TIMESTAMP   = $row[21];
$NOTIFY           = $row[22];
$WELCOME          = $row[23];

?>

<P CLASS=title>Chatroom Configuration Page</P>

<FORM ACTION="<?php echo("$From?$URLQueryBody"); ?>" METHOD="POST" AUTOCOMPLETE="OFF" NAME="Form5">
		<INPUT TYPE=hidden NAME="From" value="<?php echo($From); ?>">
		<INPUT TYPE=hidden NAME="pmc_username" value="<?php echo(htmlspecialchars(stripslashes($pmc_username))); ?>">
		<INPUT TYPE=hidden NAME="pmc_password" value="<?php echo($pmc_password); ?>">
		<INPUT TYPE=hidden NAME="FORM_SEND" value="5">
<table align="center" width="650" CLASS=table>
<tr>
    <td><b>Number of hours before messages are deleted:</b></td>
    <td><input name="vMSG_DEL" type="text" size="20" value="<? echo $MSG_DEL; ?>"></td>
</tr>
<tr>
    <td bgcolor="#9B9DFF"><b>Number of minutes before usernames are deleted from Chatroom:</b></td>
    <td bgcolor="#9B9DFF"><input name="vUSR_DEL" type="text" size="20" value="<? echo $USR_DEL; ?>"></td></tr>
<tr>
    <td><b>Delete registered users if not used in this many days:</b> (0 for never)</td>
    <td><input name="vREG_DEL" type="text" size="20" value="<? echo $REG_DEL; ?>"></td></tr>
<tr>
    <td bgcolor="#9B9DFF"><b>Default Language for Chatroom:</b></td>                                      
    <td bgcolor="#9B9DFF"><input name="vLANGUAGE" type="text" size="20" value="<? echo $LANGUAGE; ?>"></td></tr>
<tr>
    <td><b>Allow multi-languages/charset:</b> (0 = no, 1 = yes)</td>                    
    <td><input name="vMULTI_LANG" type="text" size="20" value="<? echo $MULTI_LANG; ?>"></td></tr>
<tr>
    <td bgcolor="#9B9DFF"><b>Require Registration to chat:</b> (0 = no, 1 = yes)</td>                     
    <td bgcolor="#9B9DFF"><input name="vREQUIRE_REGISTER" type="text" size="20" value="<? echo $REQUIRE_REGISTER; ?>"></td></tr>
<tr>
    <td><b>Email Password to new registered users:</b> (0 = no, 1 = yes)</td>           
    <td><input name="vEMAIL_PASWD" type="text" size="20" value="<? echo $EMAIL_PASWD; ?>"></td></tr>
<tr>
    <td bgcolor="#9B9DFF"><b>Show link for admin resources at startup screen:</b> (0 = no, 1 = yes)</td>  
    <td bgcolor="#9B9DFF"><input name="vSHOW_ADMIN" type="text" size="20" value="<? echo $SHOW_ADMIN; ?>"></td></tr>
<tr>
    <td><b>Show link to allows users to delete their own profile:</b> (0 = no, 1 = yes) </td>
    <td valign="top"><input name="vSHOW_DEL_PROF" type="text" size="20" value="<? echo $SHOW_DEL_PROF; ?>"></td></tr>
<tr>
    <td bgcolor="#9B9DFF"><b>Available Rooms:</b><br>
                  0 : only the first room within the public default ones<br>
                  1 : all the public default rooms but not create a room<br>
                  2 : all the rooms and create new ones                          </td>
    <td bgcolor="#9B9DFF"><input name="vVERSION" type="text" size="20" value="<? echo $VERSION; ?>"></td></tr>
<tr>
    <td><b>Enable the banishment feature and define the delay for banishment</b><br>
    0 = disabled, any positive number = number of banishment day(s)</td>
    <td><input name="vBANISH" type="text" size="20" value="<? echo $BANISH; ?>"></td></tr>
<tr>
    <td bgcolor="#9B9DFF"><b>Check for swear words:</b>(0 = no, 1 = yes) </td>                            
    <td bgcolor="#9B9DFF"><input name="vNO_SWEAR" type="text" size="20" value="<? echo $NO_SWEAR; ?>"></td></tr>
<tr>
    <td><b>Max number of message that user may export:</b> (0=disable, *=no limit)</td> 
    <td><input name="vSAVE" type="text" size="20" value="<? echo $SAVE; ?>"></td></tr>
<tr>
    <td bgcolor="#9B9DFF"><b>Use graphical smilies:</b> (0 = no, 1 = yes)</td>                            
    <td bgcolor="#9B9DFF"><input name="vUSE_SMILIES" type="text" size="20" value="<? echo $USE_SMILIES; ?>"></td></tr>
<tr>
    <td><b>Keep HTML tags in messages:</b><br>
    <b>simple</b>: keep bold, italic and underline tags<br>
    <b>none</b>: keep none</td>
    <td valign="top"><input name="vHTML_TAGS_KEEP" type="text" size="20" value="<? echo $HTML_TAGS_KEEP; ?>"></td>
</tr>
<tr>
    <td bgcolor="#9B9DFF"><b>Show discarded HTML tags:</b> (0 = no, 1 = yes)</td>
    <td bgcolor="#9B9DFF"><input name="vHTML_TAGS_SHOW" type="text" size="20" value="<? echo $HTML_TAGS_SHOW; ?>"></td>
</tr>
<tr>
    <td><b>Timezone offset in hour between the server time and your country:</b></td>
    <td><input name="vTMZ_OFFSET" type="text" size="20" value="<? echo $TMZ_OFFSET; ?>"></td>
</tr>
<tr>
    <td bgcolor="#9B9DFF"><b>Default message order:</b> (0 = last on top, 1 = last on bottom)</td>
    <td bgcolor="#9B9DFF"><input name="vMSG_ORDER" type="text" size="20" value="<? echo $MSG_ORDER; ?>"></td>
</tr>
<tr>
    <td><b>Default number of messages to display:</b></td>
    <td><input name="vMSG_NB" type="text" size="20" value="<? echo $MSG_NB; ?>"></td>
</tr>
<tr>
    <td bgcolor="#9B9DFF"><b>Default timeout between each update:</b></td>
    <td bgcolor="#9B9DFF"><input name="vMSG_REFRESH" type="text" size="20" value="<? echo $MSG_REFRESH; ?>"></td>
</tr>
<tr>
    <td><b>Show Timsestamp before messages:</b> (0 = no, 1 = yes)</td>
    <td><input name="vSHOW_TIMESTAMP" type="text" size="20" value="<? echo $SHOW_TIMESTAMP; ?>"></td>
</tr>
<tr>
    <td bgcolor="#9B9DFF"><b>Show nofications of user entrance/exit</b>: (0 = no, 1 = yes)</td>
    <td bgcolor="#9B9DFF"><input name="vNOTIFY" type="text" size="20" value="<? echo $NOTIFY; ?>"></td>
</tr>
<tr>
    <td><b>Display a welcome message when user enters chatroom:</b></td>
    <td><input name="vWELCOME" type="text" size="20" value="<? echo $WELCOME; ?>"></td>
</tr>
<tr>
    <td></td><td><input type="submit" name="submit_type" value="SAVE CHANGES"></td>
</tr>
</table>
</form>

<?php
}
?>

