<?php

// Begin Login Verification --------------------------------------------

session_start();

include("login_check.php");
include('../config.php');

//begin the HTML page
include('../includes/admin_header.php');

?>

<table align="center" border="0">
<tr>
    <td>
        <div align="center">
            <br/>
            <div class="gbookAdminRecordBanner">Guestbook Admin Interface</div>
            <ul class="menu">
                <li><a href="modify.php">Edit or Delete Existing Entry</a></li>

                <li><a href="view.php?lg=1">View IP of Users</a> </li>

                <li><a href="view.php?lg=2">View IP of Spammers</a> </li>

                <li><a href="view.php?lg=3">Current Guestbook Settings</a> </li>

                <li><a href="generate_language.php">Generate Language File</a> </li>
                
                <li><a href="view.php?lg=4">Server PHP Information</a> </li>
            </ul>
        </div>
    </td>
</tr>
</table>

<?php
//close the HTML page:
include('../includes/admin_footer.php');

?>
