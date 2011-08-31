<?php
if($_GET['sent'] != 1) echo '
<a href="?pass='.$_GET['pass'].'&interface=legacy">[switch to legacy]</a>
<form action "" method="get">
[For help: Click on white space, Ctrl + A to reveal hidden text, can\'t find hidden text gtfo.]<br/>
Also note this is a minimalist site for advanced logical users only.</br>

Phone Number:&nbsp;&nbsp;1-(<input type="text" name="area" size="3" maxlength="3"/>)-<input type="text" name="three" size="3" maxlength="3">-<input type="text" size="4" name="four" value="0000" maxlength="4"/>
<input type="checkbox" name="wardial" value="wardial">war dial? OR<input type="checkbox" name="spam" value="yes"> Autosmap a single number?</br>

<input type="text" name="message" size="160" maxlength="160"/></br><input type="submit" name="verbose" value="Spam"/><input type="submit" name="verbose" value="Test"/>
<input type="hidden" name="sent" value="1"/><input type="hidden" name="pass" value="'.$_GET['pass'].'"/></br>

<font color=white>Note: if you leave the last 4 digits of the phone number 0000 it will parse through all 10000 numbers.(0000-9999)<br/>
Also use this site at your own risk. I do not track IP addresses but little to no security is used in this site.</br></font>
';
	if($_GET['sent'] == 1) {
		$message = $_GET['message'];
		//make sure there are enough digits
		$a = $_GET['area'];
		if (strlen($a) != 3 ) exit("Please enter the correct number of digits");
		$first = $_GET['three'];
		if (strlen($first) != 3 ) exit("Please enter the correct number of digits");
		$four = $_GET['four'];
		if (strlen($four) != 4 ) exit("Please enter the correct number of digits");
		//set phone number
		$pn = $a.$first.$four;
		//sets boolean values for flags
		if($_GET['verbose'] == 'Test') $verbose = true;
		else $verbose = false;
		$loop = 1; //default loop value
		if($_GET['wardial'] == 'wardial')$loop = 10000;
		if($_GET['spam'] == 'yes') $loop = 100;
		//start spam loop
		$i = 0;
		$gv = new GoogleVoice($username,$password);
		while(true)
		{
			if($i == $loop) break; //breaks while loop when the cycle is complete
			if($loop == 10000)
			{
				if($four <= '999' && $four >= 100) $four = '0'.$i;
				if($four <= '99' && $four >= 10) $four = '00'.$i;
				if($four <= '9' && $four >= 1) $four = '000'.$i;
				$pn = $a.$first.$four;
				$four= $four + 1;
			}
			$gv->sms($pn,$message,$verbose); //sends verbose boolean and api will handle output
			$i = $i+1; //counter + 1;
		}
	}
?>
