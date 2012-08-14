<?php

// Begin Login Verification --------------------------------------------

session_start();

include("login_check.php");

?>

<html>
<head><title>DigiOz Guestbook Administrative Interface</title></head>
  <link rel="STYLESHEET" type="text/css" href="../style.css">
<body>

<br>
<h2 align="center">Guestbook Admin Interface</h2>
<br><br><center>

<center><br><table bordercolor=#C0C0C0 border=1 width=300 cellpadding=10 height=100>

<tr>
    <td height="30"> 
    
         <a href="delete.php"><center><b><font color="#000000" size=3>Delete Existing Entry</font></center></b></a>
    
    </td>
</tr>
<tr>
    <td height="30">
    
         <a href="view.php?lg=1"><center><b><font color="#000000" size=3>View IP of Users</font></center></b></a>
    
    </td>
</tr>
<tr>
    <td height="30">
    
         <a href="view.php?lg=2"><center><b><font color="#000000" size=3>View IP of Spammers</font></center></b></a>
    
    </td>
</tr>
<tr>
    <td height="30">
    
         <a href="view.php?lg=3"><center><b><font color="#000000" size=3>Current Guestbook Settings</font></center></b></a>
    
    </td>
</tr>
<tr>
    <td height="30">
    
         <a href="generate_language.php"><center><b><font color="#000000" size=3>Generate Language File</font></center></b></a>
    
    </td>
</tr>
</table></center>

<p>&nbsp;</p>
<p>
<center>
        <a href="index.php"><font color="red"><b>Admin Main</b></font></a> -
        <a href="login.php?mode=logout"><font color="red"><b>Logout</b></font></a>
</center>
</p>

</body>
</html>
