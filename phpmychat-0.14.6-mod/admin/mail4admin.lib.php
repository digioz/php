<?php
// This library is used by the administration script. It allows to send emails to
// the registered users.
// Note that the php mail function must be enabled to run this functionality. If
// an other function has been developed by your ISP to send PHP mail, just modify
// the send_email function to make in runable.


// -- SETTINGS BELLOW MUST BE COMPLETED --

$Sender_Name = 'your true name';	// May also be the name of your site 
$Sender_email = 'your e-mail';	// For the reply address
$Completed = '0';				// Sets this to '1'


// -- CORE FUNCTIONS - DO NOT MODIFY --

$MailFunctionOn = (function_exists("mail") && @mail('','',''));

if ($MailFunctionOn)
{
	function quote_printable($str,$WithCharset) 
	{
		$str = str_replace("%","=",rawurlencode($str));
		return "=?${WithCharset}?Q?${str}?=";
	};

	// Credits for this function goes to fwancho <fwancho@whc.net>
	// It can be found at the URL: http://www.zend.com/codex.php?id=307&single=1
	function rfcDate()
	{
		// Translated from imap-4.7c/src/osdep/unix/env_unix.c
		// env-unix.c is Copyright 2000 by the University of Washington
		// localtime() not available in php...

		$tn = time(0);
		$zone = gmdate("H", $tn) * 60 + gmdate("i", $tn);
		$julian = gmdate("z", $tn);
		$t = getdate($tn);
		$zone = $t["hours"] * 60 + $t["minutes"] - $zone;

		// julian can be one of:
		//  36x  local time is December 31, UTC is January 1, offset -24 hours
		//    1  local time is 1 day ahead of UTC, offset +24 hours
		//    0  local time is same day as UTC, no offset
		//   -1  local time is 1 day behind UTC, offset -24 hours
		// -36x  local time is January 1, UTC is December 31, offset +24 hours
		if ($julian = $t["yday"] - $julian)
		{
			$zone += (($julian < 0) == (abs($julian) == 1)) ? -24*60 : 24*60;
		};

		$zone_sign = ($zone > 0 ? "+" : "-");

		return date('D, d M Y H:i:s ', $tn).$zone_sign.sprintf("%02d%02d", abs($zone)/60, abs($zone)%60)." (".strftime("%Z").")"; 
	}

	$Sender_Name = quote_printable($Sender_Name,$Charset);
	$mail_date = rfcDate();

	function send_email($To,$Subject,$Body)
	{
		global $Charset;
		global $Sender_Name, $Sender_email;
		global $mail_date;

		$Subject = quote_printable($Subject,$Charset);

		$Headers = "From: ${Sender_Name} <${Sender_email}> \r\n";
		$Headers .= "X-Sender: <${Sender_email}> \r\n";
		$Headers .= "X-Mailer: PHP/".phpversion()." \r\n";
		$Headers .= "Return-Path: <${Sender_email}> \r\n";
		$Headers .= "Date: ${mail_date} \r\n";
		$Headers .= "Mime-Version: 1.0 \r\n";
		$Headers .= "Content-Type: text/plain; charset=${Charset} \r\n";
		$Headers .= "Content-Transfer-Encoding: 8bit \r\n";

		return @mail($To, $Subject, stripslashes($Body), $Headers);
	};

};
?>