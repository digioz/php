<h2 align="center">DigiOz Who Is Online Installation</h2>

<?php

include("whoisonline_config.php");

if (isset($_POST['submit']))
{
   $dbhost  = $_POST['txtdbhost'];
   $dbname  = $_POST['txtdbname'];
   $dbtable = $_POST['txtdbtable'];
   $dbuser  = $_POST['txtdbuser'];
   $dbpass  = $_POST['txtdbpass'];
   
   //echo "Inside The Installer<br>";
   //echo "$dbhost-$dbname-$dbtable-$dbuser-$dbpass";
   $sql1 = "CREATE DATABASE IF NOT EXISTS `$dbname`;";
   $sql2 = "CREATE TABLE IF NOT EXISTS `$dbname`.`$dbtable` (`id` INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,`ip` VARCHAR(20) NOT NULL,`modified` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,PRIMARY KEY(`id`));";
   $cfgsettings = '<?php $dbhost="'.$dbhost.'"; $dbname="'.$dbname.'"; $dbtable="'.$dbtable.'"; $dbuser="'.$dbuser.'"; $dbpass="'.$dbpass.'"; $purge_length=10; $txtVisitors="Visitors:"; $txtYourIP="Your IP:"; ?>';

   echo "<center>";
   echo "SQL Statement Database: <br><textarea cols=\"45\" rows=\"2\">$sql1</textarea><br><br>";
   echo "SQL Statement TABLE: <br><textarea cols=\"45\" rows=\"8\">$sql2</textarea><br><br>";
   echo "Configuration Setting: <br><textarea cols=\"45\" rows=\"8\">$cfgsettings</textarea><br>";

   // Table Creation SQL Statement -------------------
   include("dbclass.php");

   $db1 = new dbClass();
   $db1->setDBVars($dbhost,$dbname,$dbuser,$dbpass);
   $db1->openConnection();
   $db1->execCommand($sql1);
   $db1->execCommand($sql2);
   $db1->closeConnection();

   echo "<br><br>Installation Completed!";
   echo "</center>";

}
else
{
?>

<!-- HTML Form -->
<form name="whoisonlineinstall" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
      <table border="0" cellpadding="0" cellspacing="2" align="center">
				<tr>
					<td>
						<p><b><font size="2">Database Host:</font></b></p>
					</td>
					<td><input type="text" name="txtdbhost" size="20" value="<?php echo $dbhost; ?>"></td>
				</tr>
				<tr>
					<td>
						<p><b><font size="2">Database Name:</font></b></p>
					</td>
					<td><input type="text" name="txtdbname" size="20" value="<?php echo $dbname; ?>"></td>
				</tr>
				<tr>
					<td>
						<p><b><font size="2">Database Table:</font></b></p>
					</td>
					<td><input type="text" name="txtdbtable" size="20" value="<?php echo $dbtable; ?>"></td>
				</tr>
				<tr>
					<td>
						<p><b><font size="2">Database Username:</font></b></p>
					</td>
					<td><input type="text" name="txtdbuser" size="20" value="<?php echo $dbuser; ?>"></td>
				</tr>
				<tr>
					<td>
						<p><b><font size="2">Database Password:</font></b></p>
					</td>
					<td><input type="text" name="txtdbpass" size="20" value="<?php echo $dbpass; ?>"></td>
				</tr>
				<tr>
					<td></td>
					<td>
						<div align="right">
							<input type="submit" name="submit" value="submit">
					</td>
				</tr>
       </table>
</form>

<center><b>Note:</b> If You are changing any of the above values, you will need to<br>update the <b>&quot;whoisonline_config.php&quot;</b> file to reflect the same changes.</center>
<!-- End  Form -->

<?php
}
?>