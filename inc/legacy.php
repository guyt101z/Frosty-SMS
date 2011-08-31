<?php
require_once('phpmailer/class.phpmailer.php');
if($_GET['sent'] != 1) echo '
<a href="?pass='.$_GET['pass'].'">[switch to frosty]</a>
<form action "" method="get">
[For help: Click on white space, Ctrl + A to reveal hidden text, can\'t find hidden text gtfo.]<br/>
Also note this is a minimalist site for advanced logical users only.</br>

Phone Number:&nbsp;&nbsp;1-(<input type="text" name="area" size="3" maxlength="3"/>)-<input type="text" name="three" size="3" maxlength="3">-<input type="text" size="4" name="four" value="0000" maxlength="4"/><input type="checkbox" name="autospam" value="autospam">single number?<input type="checkbox" name="nospam" value="no"> Autosmap single number?</br>

Provider/Carrier: <select name="carrier" id="carrier">
	<option>Verizon</option>
	<option>U.S. Cellular</option>
	<option>T-Mobile</option>
	<option>Sprint</option>
	<option>AT&T</option>
	<option>Virgin Mobile</option>
	<option>Use custom email</option>
</select> Custom email:<input type="text" name="custom"/><br/>
<font color="white">If you are using a carrier who has a email to text message email put everything after the @ sign. we assume the email will be formated as such: 15556661234@carrieremailservice.com</font></br>


<input type="text" name="message" size="160" maxlength="160"/></br><input type="submit" name="verbose" value="Spam"/><input type="submit" name="verbose" value="test"/>
<input type="hidden" name="sent" value="1"/><input type="hidden" name="pass" value="'.$_GET['pass'].'"/><input type="hidden" name="interface" value="legacy"/></br>

<font color=white>Note: if you leave the last 4 digits of the phone number 0000 it will parse through all 10000 numbers.<br/>
Also use this site at your own risk. I do not track IP addresses but little to no security is used in this site.</br></font>
';
if($_GET['sent'] == 1) {
define('GUSER', $username); // Gmail username
define('GPWD', $password); // Gmail password

function smtpmailer($to, $from, $from_name, $subject, $body) { 
	global $error;
	$mail = new PHPMailer();  // create a new object
	$mail->IsSMTP(); // enable SMTP
	$mail->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only
	$mail->SMTPAuth = true;  // authentication enabled
	$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = 465; 
	$mail->Username = GUSER;  
	$mail->Password = GPWD;           
	$mail->SetFrom($from, $from_name);
	$mail->Subject = $subject;
	$mail->Body = $body;
	$mail->AddAddress($to);
	if(!$mail->Send()) {
		$error = 'Mail error: '.$mail->ErrorInfo; 
		return false;
	} else {
		$error = 'Message sent!';
		return true;
	}
}

$message = $_GET['message'];
$i = 0;
$a = $_GET['area'];
$first = $_GET['three'];
$last = '0000';
$four = $_GET['four'];
$email = $_GET['carrier'];
	if($email == "U.S. Cellular") $email = 'email.uscc.net';
	if($email == "Verizon") $email = 'vtext.com';
	if($email == "T-Mobile") $email = 'tmomail.net';
	if($email == "Sprint") $email = 'messaging.sprintpcs.com';
	if($email == "AT&T") $email = 'txt.att.net';
	if($email == "Virgin Mobile") $email = 'vmobl.com';
echo '<font color="crimson">';
	if ($email == "Use custom email") {
	$email = $_GET['custom'];
	echo 'Mail to be sent to: 1xxxxxxxxxx@'.$email.'<br/>';
	}else echo 'Mail will be sent through: '.$_GET['carrier'];
echo '</font><br/>';
    while($i != 10000 && $four == '0000') {
	$email = $_GET['carrier'];
	if($email == "U.S. Cellular") $email = 'email.uscc.net';
	if($email == "Verizon") $email = 'vtext.com';
	if($email == "T-Mobile") $email = 'tmomail.net';
	if($email == "Sprint") $email = 'messaging.sprintpcs.com';
	if($email == "AT&T") $email = 'txt.att.net';
	if($email == "Virgin Mobile") $email = 'vmobl.com';

	if($last <= '999' && $last >= 100) $last = '0'.$i;
	if($last <= '99' && $last >= 10) $last = '00'.$i;
	if($last <= '9' && $last >= 1) $last = '000'.$i;
	$email = '1'.$a.$first.$last.'@'.$email;

	if ($_GET['verbose'] != 'test') {
	if (smtpmailer($email, $email, 'John',NULL, $message)) {
		// do something
		}
	if (!empty($error)) echo $error;
	}

	if ($_GET['verbose'] != 'test') echo 'mail sent to: ('.$a.')-'.$first.'-'.$last.'<br/>';
	else echo 'mail would be sent to: ('.$a.')-'.$first.'-'.$last.'&nbsp;&nbsp;&nbsp;&nbsp;'.$email.'<br/>';
	$i = $i + 1;
	$last = $i;
	}

	if ($four != '0000') {
	$email = '1'.$a.$first.$four.'@'.$email;
	
	if ($_GET['autospam'] == 'autospam'){
	if ($_GET['nospam'] != 'no') $loop = '1';
	else $loop = '100';
	$iz = 0;
	while (0==0){
		if ($iz == $loop) break;
		if ($_GET['verbose'] != 'test') {
		if (smtpmailer($email, $email, 'John',NULL, $message)) {
			// do something
			}
		if (!empty($error)) echo $error;
		}

		if ($_GET['verbose'] != 'test') echo 'mail sent to: ('.$a.')-'.$first.'-'.$four.'<br/>';
		else echo 'mail would be sent to: ('.$a.')-'.$first.'-'.$four.'&nbsp;&nbsp;&nbsp;&nbsp;'.$email.'<br/>';
		$iz = $iz +1;
		}
	}else{
		if ($_GET['verbose'] != 'test') {
		if (smtpmailer($email, $email, 'John',NULL, $message)) {
			// do something
			}
		if (!empty($error)) echo $error;
		}

		if ($_GET['verbose'] != 'test') echo 'mail sent to: ('.$a.')-'.$first.'-'.$four.'<br/>';
		else echo 'mail would be sent to: ('.$a.')-'.$first.'-'.$four.'&nbsp;&nbsp;&nbsp;&nbsp;'.$email.'<br/>';
		}
	}
}

?>
