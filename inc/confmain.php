</center><hr/>
<?php
$query = "SELECT * FROM frosty WHERE service='frosty'"; 
	 
$result = mysql_query($query) or die(mysql_error());

while($row = mysql_fetch_array($result)){
	$gvu = $row['username'];
	$gvn = $row['extra'];
}
$query = "SELECT * FROM frosty WHERE service='legacy'"; 
$result = mysql_query($query) or die(mysql_error());

while($row = mysql_fetch_array($result)){
	$gu = $row['username'];
}
/*if(file_exists(inc/configure.conf)){
$file = fopen('inc/configure.conf',"x+");
$gvu = fgets($file);
$gvn =;
fgets($file);
$gu = fgets($file);
fgets($file);
fclose($file);
}*/
if($_POST['apply'] == NULL) echo '
<h1><center>Settings</center></h1>
<h2>Frosty Settings</h2>
<form action "" method="post">
Google Voice username: <input type="text" name="gvusername" size="" maxlength="" value="'.$gvu.'"><br/>
Google Voice password: <input type="password" name="gvpassword" size="" maxlength="" value=""><br/>
Google Voice Phone Number: <input type="text" name="gvnumber" size="" maxlength="10" value='.$gvn.'>
<hr/><h2>Legacy Settings</h2>
Gmail username: <input type="text" name="username" size="" maxlength="" value="'.$gu.'"><br/>
Gmail password: <input type="password" name="password" size="" maxlength="" value=""><br/>
<center><input type="submit" name="apply" value="Apply All"/><input type="submit" name="apply" value="Clear Configuration"/></center>
';

if($_POST['apply'] == "Apply All") {
$query = "TRUNCATE TABLE `frosty`";
$result = mysql_query($query);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}
$query = "INSERT INTO  `frosty` (
`service` ,
`username` ,
`password` ,
`extra`
)
VALUES (
'frosty','".$_POST['gvusername']."' , '".$_POST['gvpassword']."' , '".$_POST['gvnumber']."'
), (
'legacy', '".$_POST['username']."' , '".$_POST['password']."' , NULL
);";
$result = mysql_query($query);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}
}
if($_POST['apply'] == "Clear Configuration") {
echo 'Dropping `frosty` ...';
$query = "DROP TABLE  `frosty`";
$result = mysql_query($query);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}
echo '... finished!<br/> Rewriting index.php ...<br/>';
$body = '<?php
include("inc/install.php");
?>';
$file = fopen('index.php',"w");
fwrite($file,$body);
fclose($file);
echo '... truncating configure.php ...<br/>';
$file = fopen('configure.php',"w");
fclose($file);
echo '...uninstall complete!';
}

?>
