<?php
$message = $_GET['message'];
//make sure there are enough digits
$a = $_GET['area'];
if (length($area) != 3 ) kill();
$first = $_GET['three'];
if (length($three) != 3 ) kill();
$four = $_GET['four'];
if (length($four) != 4 ) kill(); 
//set phone number
$pn = $a.$first.$four;
else $pn = $a.$first.$last;
//sets boolean values for flags
if($_GET['verbose'] == 'test') $verbose = true;
else $verbose = false;
if($_GET['autosmap'] == 'autospam')$autosmap = true;
else $autosmap = false;
if($_GET['spam'] == 'no') $loop = 100;
else $loop = 1;
//start spam loop
$i = 0;
while(true)
{
	if($i == $loop) break; //breaks while loop when the cycle is complete
	if(autosmap)
	{
		if($last <= '999' && $last >= 100) $last = '0'.$i;
		if($last <= '99' && $last >= 10) $last = '00'.$i;
		if($last <= '9' && $last >= 1) $last = '000'.$i;
	}
	$gv->sms($pn,$message,$verbose); //sends verbose boolean and api will handle output
	$i = $i+1; //counter + 1;
}
