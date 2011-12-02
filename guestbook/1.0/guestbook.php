<?php
include("header.inc");
?>

<br>
<form action="add.php" method="post">
			<table border="0" cellpadding="0" cellspacing="2">
				<tr>
					<td>
						<p><b><font size="2">Your name:</font></b></p>
					</td>
					<td><input type="text" name="yourname" size="20"></td>
				</tr>
				<tr>
					<td>
						<p><b><font size="2">Your email:</font></b></p>
					</td>
					<td><input type="text" name="youremail" size="20" value=""></td>
				</tr>
				<tr>
					<td>
						<p><b><font size="2">Message:</font></b></p>
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
							<input type="submit" name="ok" value="Add To Guestbook">
					</td>
				</tr>
			</table>
		</form>


<?php
include("footer.inc");
?>