<?php

// If form is submitted update values in the database 

if (isset($FORM_SEND) && $FORM_SEND == 7)
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
  mysql_select_db(C_DB_NAME)or die("Could not select the database!");
  
  if($searchCategory == "1" && $searchTerm != "")
  {
    // create query for 1
    $sql = "SELECT username,firstname,lastname,email,perms,ip,gender FROM c_reg_users WHERE username='".$searchTerm."';";
    //echo $query;
  }
  elseif($searchCategory == 2 && $searchTerm != "")
  {
    // create query for 2
    $sql = "SELECT username,firstname,lastname,email,perms,ip,gender FROM c_reg_users WHERE ip='".$searchTerm."';";
  }
  elseif($searchCategory == 3 && $searchTerm != "")
  {
    // create query for 3
    $sql = "SELECT username,firstname,lastname,email,perms,ip,gender FROM c_reg_users WHERE perms='".$searchTerm."';";
  }
  elseif($searchCategory == 4 && $searchTerm != "")
  {
    // create query for 4
    $sql = "SELECT username,firstname,lastname,email,perms,ip,gender FROM c_reg_users WHERE gender='".$searchTerm."';";
  }
  else
  {
    // Means forgot to specify a search term
    echo "<table bgcolor=white align=center border=0><tr><td><b>Please Provide a Search Term and Try Again!</b></td></tr></table>";
    exit;
  }

   //echo $query;
   $query = mysql_query($sql) or die("Cannot query the database.<br>" . mysql_error());
   //mysql_query($query)or die("Could not execute search query!");

   // Display search result on screen
   echo "<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" width=\"800\"  bordercolor=\"#C0C0C0\" CLASS=table>";
   echo "<tr align=\"center\"><td><b>Username</b></td><td><b>First Name</b></td><td><b>Last Name</b></td><td><b>E-mail</b></td><td><b>Permission</b></td><td><b>IP</b></td><td><b>Gender</b></td></tr>";

   while($result = mysql_fetch_array($query))
   {
       $s_username = stripslashes($result["username"]);
       $s_firstname = stripslashes($result["firstname"]);
       $s_lastname = stripslashes($result["lastname"]);
       $s_email = stripslashes($result["email"]);
       $s_perms = stripslashes($result["perms"]);
       $s_ip = stripslashes($result["ip"]);
       $s_gender = stripslashes($result["gender"]);
       
       if($s_gender == "1")
       {
         $s_gender = "M";
       }
       elseif($s_gender == "2")
       {
         $s_gender = "F";
       }
       else
       {
         $s_gender = "?";
       }

       echo "<tr bgcolor=\"#FFFFFF\"><td width=100> $s_username </td><td> $s_firstname </td><td> $s_lastname </td><td> <a href=\"mailto:$s_email\"><font color=\"orange\">$s_email</font></a> </td><td> $s_perms </td><td> $s_ip </td><td><center> $s_gender </center></td></tr>";
   }

echo "</table><br>";
}

?>

<P CLASS=title>Chatroom Search Page</P>

<FORM ACTION="<?php echo("$From?$URLQueryBody"); ?>" METHOD="POST" AUTOCOMPLETE="OFF" NAME="Form7">
		<INPUT TYPE=hidden NAME="From" value="<?php echo($From); ?>">
		<INPUT TYPE=hidden NAME="pmc_username" value="<?php echo(htmlspecialchars(stripslashes($pmc_username))); ?>">
		<INPUT TYPE=hidden NAME="pmc_password" value="<?php echo($pmc_password); ?>">
		<INPUT TYPE=hidden NAME="FORM_SEND" value="7">
<table align="center" width="280" CLASS=table>
<tr>
    <td><b>Search Term:</b></td>
    <td><input name="searchTerm" type="text" size="20"></td>
</tr>
<tr>
    <td bgcolor="#9B9DFF"><b>Search Category:</b></td>
    <td bgcolor="#9B9DFF">
        <select name="searchCategory">
                <option value="1">Username
                <option value="2">IP Address
                <option value="3">Permissions
                <option value="4">Gender
        </select>
    
    </td></tr>
<tr>
    <td></td><td align="right"><input type="submit" name="submit_type" value="Search"></td>
</tr>
</table>
</form>

<table align="center" width="400" CLASS=table>
<tr>
    <td>
    <b>*</b> For Permissions Category, options are <b>admin</b> or <b>user</b>.<br>
    <b>*</b> For Gender Category, options are <b>1</b> for Male, or <b>2</b> for Female.<br>
</tr>
</table>

<?php

?>

