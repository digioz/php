<?php

// Begin Login Verification --------------------------------------------

session_start();

include('login_check.php');
include('../config.php');
include('../'.$language_file);
require_once('../includes/class.gbXML.php');

//start the HTML page
include_once('../includes/admin_header.php');
?>

<div align="center">
	<?php

	$lg = $_GET['lg'];

	// Validate browser input ------------------------------------------------------------

	if (is_numeric($lg) == false)
	{
	  echo '<p class="error">Non Numeric LG Number <br />';
	  echo '      <a href="index.php">Admin Main</a> -<a href="login.php?mode=logout">Logout/a>';
	  echo '</p>';
	  echo '</body>';
	  echo '</html>';
	  exit;
	}

	// Determine page selection ----------------------------------------------------------

	if($lg == 1)
	{
		echo "<h3>IP Tracking Interface</h3>";
        $filename = '../data/message_post.xml';
        echo "
        <div class='gbookAdminRecordBanner'></div>
        <div class='gbookAdminRecord'>";	  
		readXML($filename);
        echo "</div>";
	}
	elseif ($lg == 2)
	{
        echo "<h3>Spammer Tracking Interface</h3>";
		$filename = '../data/message_spam.xml';
		echo "
		<div class='gbookAdminRecordBanner'></div>
		<div class='gbookAdminRecord'>";
		readXML($filename);
		echo "</div>";
	}
	elseif ($lg == 3)
	{
	  echo '<h3>Current Guestbook Settings</h3>';
	  echo '<p>Note: To change any of the values below, simply open the file <em>config.php</em> in notepad<br /> and changes the corresponding value to "1" to "0" depending on your selection.</p>';


	  echo "
		<div class='gbookAdminRecordBanner'></div>
		<div class='gbookAdminRecord'>";
	  echo '<table width="500">';
	  echo '<tr><th>Setting</th><th>Option Selected</th></tr>';
	  echo '<tr><td>Guestbook Version</td><td>'.$gb_system_version.'</td></tr>';
	  echo '<tr><td>Email Field Optional</td><td>'; //colour font blue
		   if($email_optional == 1){ echo 'Yes'; }else{ echo 'No'; }
		   echo "</td></tr>";
	  echo "<tr><td>Name Field Optional:</td><td>"; //colour font blue
		   if($name_optional == 1){ echo "Yes"; }else{ echo "No"; }
		   echo "</td></tr>";
	  echo "<tr><td>Message Field Optional:</td><td>"; //colour font blue
		   if($message_optional == 1){ echo "Yes"; }else{ echo "No"; }
		   echo "</td></tr>";
	  echo "<tr><td>Nofity Admin when message posted:</td><td>";
		   if($notify_admin == 1){ echo "Yes"; }else{ echo "No"; }
		   echo "</td></tr>";
	  echo "<tr><td>Notify Admin email (current):</td><td>";
		   if($notify_admin_email == 1){ echo "Yes"; }else{ echo "No"; }
		   echo "</td></tr>";
	  echo '<tr><td>Language Code</td><td>'.$lang.'</td></tr>';
	  echo "<tr><td>Default Language:</td><td>";
		   echo $language_file;
		   echo "</td></tr>";
		echo "<tr><td>Image Verification:</td><td>";
		   if($image_verify == 1){ echo "Yes"; }else{ echo "No"; }
		   echo "</td></tr>";
	  echo "<tr><td>Email Display Type (spam prevention):</td><td>";
		   if($email_display == 2){ echo "Image"; } elseif($email_display == 1){ echo "Ascii"; } else { echo "Plain Text (not recommended)"; }
		   echo "</td></tr>";
	  echo "<tr><td>Guestbook Flood Protection:</td><td>";
		   if($gbflood == 1){ echo "Yes"; }else{ echo "No"; }
		   echo "</td></tr>";
	  echo "<tr><td>Referer Checking:</td><td>";
		   if($referersKey == 1){ echo "Yes"; }else{ echo "No"; }
		   echo "</td></tr>";
	  echo "<tr><td>Referer domain allowed for posting:</td><td>";
		   echo $referers[0];
		   echo "</td></tr>";
	  echo "<tr><td>Full Referer domain allowed for posting:</td><td>";
		   echo $referers[1];
		   echo "</td></tr>";
	  echo "<tr><td>Referer Site IP allowed for posting:</td><td>";
		   echo $referers[2];
		   echo "</td></tr>";
	  echo "<tr><td>Guestbook IP Log:</td><td>";
		   if($gbIPLogKey == 1){ echo "Yes"; }else{ echo "No"; }
		   echo "</td></tr>";
	  echo "<tr><td>Ban Specified IP:</td><td>";
		   if($banIPKey == 1){ echo "Yes"; }else{ echo "No"; }
		   echo "</td></tr>";
	  echo "<tr><td>Bad Word Filter:</td><td>";
		   if($gbBadWordsKey == 1){ echo "Yes"; }else{ echo "No"; }
		   echo "</td></tr>";
	  echo "<tr><td>Keyword based Spam Block:</td><td>";
		   if($gbSpamKey == 1){ echo "Yes"; }else{ echo "No"; }
		   echo "</td></tr>";

	  echo "<tr><td>IP Ban List (if option is 'YES' above):</td><td>";
		   foreach($banned_ip as $value1)
		   {
			 echo $value1."<br/>";
		   }
		   echo "</td></tr>";
	  echo "<tr><td>Bad word list (if option is 'YES' above):</td><td>";
		   foreach($gbBadWords as $value2)
		   {
			 echo $value2."<br>";
		   }
		   echo "</b></font></center></td></tr>";
	  echo "<tr><td>Spam word list (if option is 'YES' above):</td><td>";
		   foreach($gbSpam as $value3)
		   {
			 echo $value3."<br>";
		   }
		   echo "</td></tr>";

	  echo "</table>";
	  echo "</div>";
	}
    elseif ($lg == 4)
    {
        echo "<h3>Server PHP Information</h3>";
        phpinfo();
    }
	else
	{
	  echo "Sorry, but you did not make a selection from the main menu";
	}
?>

</div>

<?php

    function readXML($filename)
    { 
		if(file_exists($filename))
        {
            $tracking_array_parse = new gbXML("entries","entry",$filename);
            $tracking_array_parse->parse_XML_data();
            $tracking_array = $tracking_array_parse->parsed_array;
            
            echo "<table width=\"100%\"><tr><td><b>Name</b></td><td><b>IP</b></td><td><b>Host</b></td><td><b>Timestamp</b></td>";
            
            foreach($tracking_array as $key=>$tracking_array_data)
            {                      
                echo "
                    <tr>
                        <td>{$tracking_array_data[name]}</td> 
                        <td>{$tracking_array_data[ip]}</td>
                        <td>{$tracking_array_data[host]}</td>
                        <td>{$tracking_array_data[timestamp]}</td>
                    </tr>
                ";
                
            }
            echo "</table>";
	  	}
    }
    
    //close the page be including the admin_footer.php
    include('../includes/admin_footer.php');
    
?>
