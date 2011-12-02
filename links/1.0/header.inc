<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<HTML>

<HEAD>
<TITLE>DigiOz.com</TITLE>

<META http-equiv=Content-Type content="text/html; charset=windows-1252">
<META content=TRUE name=MSSmartTagsPreventParsing>
<META http-equiv=MSThemeCompatible content=Yes>
<meta name="keywords" content="webdesign, web design, forum, message board, PHP scripts, HTML Design, Perl Design">
<meta name="description" content=" Welcome to DigiOz. We are a Webdesign and support company specializing in creation of dynamic web content. ">
<link rel=stylesheet type="text/css" href="http://www.digioz.com/style.css">
</HEAD>

<BODY text="#000000" bottomMargin="0" vLink="#000000" link="#000000" bgColor="#B7C2D3" leftMargin="0" topMargin="0" rightMargin="0" marginwidth="0" marginheight="0">

<TABLE cellSpacing=0 cellPadding=0 width="100%" background="http://www.digioz.com/images/bannerbg2.gif" border=0>
<TBODY>
	<TR>
		<TD width=270>
		<A href="http://www.digioz.com"><IMG alt="DigiOz.com" src="http://www.digioz.com/images/logo2.gif" border=0></A>
		</TD>
	</TR></TBODY>
</TABLE>

<TABLE cellSpacing=0 cellPadding=0 width="100%" background=images/footertopbg.gif border=0>
	<TBODY>
	<TR>
       	<TABLE cellSpacing=0 cellPadding=4 width="100%" bgColor=#192a3a border=0>
  			<TBODY>
  			<TR>
    				<TD width="100%">
      				<DIV align=center>
					<B><FONT face="verdana, arial, helvetica" color=#ffffff size=2>
						<A class=white href="http://www.digioz.com/index.php">Home</A>&nbsp; |&nbsp;
						<A class=white href="http://www.digioz.com/prices.php">Prices</A>&nbsp; |&nbsp;
						<A class=white href="http://www.digioz.com/clients.php">Clients</A>&nbsp; |&nbsp;
						<A class=white href="http://www.digioz.com/forum.php">Forums</A>&nbsp; |&nbsp;
						<A class=white href="http://www.digioz.com/services.php">Services</A>&nbsp; |&nbsp;
						<A class=white href="http://www.digioz.com/contactus.php">Contact Us</A>&nbsp; |&nbsp;
						<A class=white href="http://www.digioz.com/faq.php">FAQ</A>&nbsp; |&nbsp;
						<A class=white href="http://www.digioz.com/downloads.php">Downloads</A>
					</FONT></B>
					</DIV>
				</TD>
			</TR>
			</TBODY>
		</TABLE>
	</TR>
	</TBODY>
</TABLE>

<TABLE cellSpacing=0 cellPadding=4 width="100%" bgColor=#AFB1B4 border=0>
	<TBODY>
  	<TR>
		<TD width="100%"><FONT face=verdana,arial,helvetica size=1><center>
			<A class=white href="http://www.digioz.com/pcrepair.php">PC Repair</A>&nbsp; |&nbsp;
			<A class=white href="http://www.digioz.com/networking.php">Networking</A>&nbsp; |&nbsp;
			<A class=white href="http://www.digioz.com/consulting.php">Computer Consulting</A>&nbsp; |&nbsp;
			<A class=white href="http://www.digioz.com/index.php">Web Design</A>&nbsp; |&nbsp;
			<A class=white href="http://www.digioz.com/custompc.php">Custom PC</A>&nbsp; |&nbsp;
			<A class=white href="http://www.digioz.com/pcupgrade.php">PC Upgrade</A>&nbsp; |&nbsp;
			<A class=white href="http://www.digioz.com/programming.php">Programming</A>
	</TR>
	</TBODY>
</TABLE>

<!-- Actual Body of the Display Starts Right Here -->
<br>
<center>
<TABLE width=850 bgcolor=#C4D1E4>
<tr>
<td vAlign=top width=25%>

            <TABLE cellSpacing=0 cellPadding=0 width="98%" height="150" align=center bgColor=#000000 border=0>
            <TBODY>
                   <TR>
                      	<TD>
                        	<TABLE cellSpacing=1 cellPadding=1 cellspacing=0 width="100%" height=100% border=0>
                          		<TBODY>
                          			<TR>
                            				<TD width="100%" height=20 bgColor=#314263>
									<FONT face="verdana, arial, helvetica" color=#ffffff size=2>
									<center><B>DigiOz Scripts</B></center>
									</FONT>
								</TD>
							</TR>
                          			<TR>
                         				<TD width="100%" vAlign=top bgColor=#efefef>
								<ul>
									<li><a href="http://www.digioz.com/downloads.php"><FONT face="verdana, arial, helvetica" size=2>PHP Scripts</FONT></a><br>
									<li><FONT face="verdana, arial, helvetica" size=2>ASP Scripts</FONT><br>
									<li><FONT face="verdana, arial, helvetica" size=2>JavaScripts</FONT><br>
									<li><FONT face="verdana, arial, helvetica" size=2>Perl Scripts</FONT><br>
									<li><a href="http://www.digioz.com/downloads.php"><FONT face="verdana, arial, helvetica" size=2>Visual Basic</FONT></a><br>
									<li><FONT face="verdana, arial, helvetica" size=2>Visual C++</FONT><br>
								</ul>
									</TD>
							</TR>
							</TBODY>
							</TABLE>
						</TD>
							</TR>
							</TBODY>
							</TABLE>
<br>

<TABLE cellSpacing=0 cellPadding=0 width="98%" height="150" align=center bgColor=#000000 border=0>
            <TBODY>
                   <TR>
                      	<TD>
                        	<TABLE cellSpacing=1 cellPadding=1 cellspacing=0 width="100%" height=100% border=0>
                          		<TBODY>
                          			<TR>
                            				<TD width="100%" height=20 bgColor=#314263>
									<FONT face="verdana, arial, helvetica" color=#ffffff size=2>
									<center><B>Current Calender</B></center>
									</FONT>
								</TD>
							</TR>
                          			<TR>
                         				<TD width="100%" vAlign=top bgColor=#efefef>
									<FONT face="verdana, arial, helvetica" size=2>
<center>
<?
define ('ADAY', (60*60*24));
$datearray = getdate();
$month = $datearray['mon'];
$year = $datearray['year'];

$start= mktime(0,0,0,$month,1,$year);
$firstdayarray = getdate($start);

$months = Array('January','February','March','April','May','June',
				'July','August','September','October','November','December');
$days = Array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');

?>

<table border=1 cellpadding=1 bordercolor="000000" cellspacing="0">
  <tr> 
    <td colspan="7" bordercolor="ffffff"> 
      <div align="center"><font color="#000066"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
        <? echo "$datearray[month] $year";?>
        </font></b></font></div>
    </td>
  </tr>
  <?

foreach($days as $day)
{
?>
  <td bordercolor="ffffff"> 
    <div align="center"><font color="#000066"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
      <?echo"$day";?>
      </font></b></font></div>
  </td>
  <?
}
for( $count=0;$count<(6*7);$count++)
{
	$dayarray = getdate($start);
	if((($count) % 7) == 0)
	{
		if($dayarray['mon'] != $datearray['mon'])
			break;
		echo "</tr><tr>";
	}
	if($count < $firstdayarray['wday'] || $dayarray['mon'] != $month)
	{
		echo "<td bordercolor=ffffff><br></td>";
	}
	else
	{
		if($dayarray['mday'] == $datearray['mday'])
		{
		?>
  <td bgcolor="#FFCC99" bordercolor="#FFCC99"> 
    <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
      <? echo "$dayarray[mday]";?>
      </font></div>
  </td>
  <?
				$start += ADAY;
		}
		else
		{
	?>
  <td bordercolor="ffffff"> 
    <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"> 
      <? echo "$dayarray[mday]";?>
      </font></div>
  </td>
  <?
		$start += ADAY;
		}
	}
}
?>
  </tr>
</table></center>
									</FONT>
								</TD>
							</TR>
							</TBODY>
							</TABLE>
						</TD>
							</TR>
							</TBODY>
							</TABLE>
<br>


            <TABLE cellSpacing=0 cellPadding=0 width="98%" height="150" align=center bgColor=#000000 border=0>
            <TBODY>
                   <TR>
                      	<TD>
                        	<TABLE cellSpacing=1 cellPadding=1 cellspacing=0 width="100%" height=100% border=0>
                          		<TBODY>
                          			<TR>
                            				<TD width="100%" height=20 bgColor=#314263>
									<FONT face="verdana, arial, helvetica" color=#ffffff size=2>
									<center><B>Tutorials</B></center>
									</FONT>
								</TD>
							</TR>
                          			<TR>
                         				<TD width="100%" vAlign=top bgColor=#efefef>
								<ul>
									<li><FONT face="verdana, arial, helvetica" size=2>HTML Tutorial</FONT><br>
									<li><FONT face="verdana, arial, helvetica" size=2>XHTML Tutorial</FONT><br>
									<li><FONT face="verdana, arial, helvetica" size=2>CSS Tutorial</FONT><br>
									<li><FONT face="verdana, arial, helvetica" size=2>JavaScript Tutorial</FONT><br>
									<li><FONT face="verdana, arial, helvetica" size=2>PHP Tutorial</FONT><br>
									<li><a href="http://www.morgande.com/display.php?display=mysqlintro"><FONT face="verdana, arial, helvetica" size=2>MySQL Tutorial</FONT></a><br>
									<li><FONT face="verdana, arial, helvetica" size=2>ASP Tutorial</FONT><br>
									<li><FONT face="verdana, arial, helvetica" size=2>Perl Tutorial</FONT><br>
									<li><FONT face="verdana, arial, helvetica" size=2>Visual Basic Tutorial</FONT><br>
									<li><FONT face="verdana, arial, helvetica" size=2>C++ Tutorial</FONT><br>
								</ul>
									</TD>
							</TR>
							</TBODY>
							</TABLE>
						</TD>
							</TR>
							</TBODY>
							</TABLE>

</td>
<td  vAlign=top width=50%>
                  				<TABLE cellSpacing=0 cellPadding=0 width="98%" height="450" align=center bgColor=#000000 border=0>
                    				<TBODY>
                    				<TR>
                      					<TD>
                        					<TABLE cellSpacing=1 cellPadding=1 cellspacing=0 width="100%" height=100% border=0>
                          					<TBODY>
                          					<TR>
                            						<TD width="100%" height=20 bgColor=#314263>
											<FONT face="verdana, arial, helvetica" color=#ffffff size=2>
											<center><B>Links Script</B></center>
											</FONT>
										</TD>
									</TR>
                          					<TR>
                         						<TD width="100%" vAlign=top bgColor=#efefef>
											<FONT face="verdana, arial, helvetica" size=1>

<br><center>[ <a href="links.php"><b>Add to Links Page</b></a> ]  [ <a href="list.php"><b>View Current Links</b> ]</center>

<br>
<br>


<table border=0 width=450><tr><td>
<FONT face="verdana, arial, helvetica" size=1>
