<?php
include("header.inc");
?>

<br>
<form action="add.php" method="post">
			<table border="0" cellpadding="0" cellspacing="2">
				<tr>
					<td>
						<p><b><font size="2">Site Name:</font></b></p>
					</td>
					<td><input type="text" name="yourname" size="20"></td>
				</tr>
				<tr>
					<td>
						<p><b><font size="2">Website Link:</font></b></p>
					</td>
					<td><input type="text" name="yourlink" size="20" value=""></td>
				</tr>
				<tr>
					<td>
						<p><b><font size="2">Site Description:</font></b></p>
					</td>
					<td>
						<textarea name="yourdescription" cols="45" rows="10"></textarea>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<div align="right">
							<input type="submit" name="ok" value="Add To Links">
					</td>
				</tr>
			</table>
		</form>


<?php
include("footer.inc");
?>