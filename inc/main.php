<!-Start Main.php-->
<?php
if($_GET['interface'] != 'legacy') $query = "SELECT * FROM frosty WHERE service='frosty'"; 
if($_GET['interface'] == 'legacy') $query = "SELECT * FROM frosty WHERE service='legacy'"; 
	 
$result = mysql_query($query) or die(mysql_error());

while($row = mysql_fetch_array($result)){
	echo '<span style="text-transform: capitalize;">'.$row['service'].'</span> ';
	$username = $row['username'];
	$password = $row['password'];
	$number = $row['extra'];
}
if($_GET['interface'] != 'legacy') {

echo 'Number: '.$number;
}
if($_GET['interface'] == 'legacy') echo 'Username: '.$username;
echo '</center><hr/>';
if($_GET['pass'] == 'tryme') echo 'Open beta not actually open please bruteforce instead.';
if($_GET['pass'] == NULL) echo 'Please login!';
if($_GET['pass'] == 'letmein'){
if($_GET['interface'] != 'legacy') include('frosty.php');
if($_GET['interface'] == 'legacy') include('legacy.php');
}
?>
