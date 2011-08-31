<?php
if($_POST['submit'] != 'Install') echo '
<h1><center>Install Frosty</center></h1>
<h2>MySQL Settings</h2>
<form action "" method="post">
<font color="crimson">MySQL username: <input type="text" name="sqlusername" size="" maxlength=""><br/>
MySQL password: <input type="password" name="sqlpassword" size="" maxlength=""></font><br/>
MySQL database: <input type="text" name="database" size="" maxlength=""><br/><br/>
Note: this will use the login credentials to create a new table in the database given called frosty.<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;If you are unsure of your database name and the mysql credentials can create a new database leave the<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;database field blank.

<h2>Frosty Settings</h2>
Google Voice username: <input type="text" name="gvusername" size="" maxlength=""><br/>
Google Voice password: <input type="password" name="gvpassword" size="" maxlength=""><br/>
Google Voice Phone Number: <input type="text" name="gvnumber" size="" maxlength="10">
<hr/><h2>Legacy Settings</h2>
Gmail username: <input type="text" name="username" size="" maxlength=""><br/>
Gmail password: <input type="password" name="password" size="" maxlength=""><br/>
Note: <font color="crimson">red</font> denotes a required field.
<center><input type="submit" name="submit" value="Install"/></center>
';
if($_POST['submit'] == 'Install') {
echo 'Installing ... <br/>logging into mysql ...';
$link = mysql_connect('localhost', $_POST['sqlusername'], $_POST['sqlpassword']);
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
echo '... Connected successfully!<br/>';
if($_POST['database'] == NULL) {
$database = frosty;
echo 'database field blank, auto-creating database `frosty`...';
$query = 'CREATE DATABASE frosty';
if (!mysql_query($query)) {
    die('Invalid query: ' . mysql_error());
}
echo '... creation successful!<br/>';
$database = 'frosty';
}
else $database = $_POST['database'];

echo 'Creating the table `frosty` in database '.$database.' ...';
$query = "CREATE TABLE  `".$database."`.`frosty` (
`service` VARCHAR( 999 ) NOT NULL ,
`username` VARCHAR( 999 ) NULL ,
`password` VARCHAR( 999 ) NULL ,
`extra` VARCHAR( 999 ) NULL
) ENGINE = MYISAM ;";
$result = mysql_query($query);
if (!$result) {
    die('Invalid query: ' . mysql_error());
}
echo '... Created successfully!<br/> Adding data to the table `frosty` ...';
$query = "INSERT INTO  `".$database."`.`frosty` (
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
echo '... Data added successfully! <br/> Closing link ...';
mysql_close($link);
echo '... link closed!</br> Writing configure.php ...';
$body = "<?php
\$link = mysql_connect('localhost', '".$_POST['sqlusername']."', '".$_POST['sqlpassword']."');
mysql_select_db('".$database."');
include('inc/header.php'); //html header
include('inc/confmain.php'); //main php file
echo '<hr/>
Your IP is: 137.101.32.79
<span class=\"conf\"><a href=\"index.php?pass=letmein\">[back to frosty]</a></span>
</body>
</html>';
mysql_close(\$link);
?>";
$file = fopen('configure.php',"w");
fwrite($file,$body);
fclose($file);
echo '... finished!<br/> Rewriting index.php ...';
$body = "<?php
\$link = mysql_connect('localhost', '".$_POST['sqlusername']."', '".$_POST['sqlpassword']."');
mysql_select_db('".$database."');
include('inc/header.php'); //html header
require_once('inc/class.googlevoice.php'); //required php class
include('inc/main.php'); //main php file
include('inc/footer.php'); //html footer
mysql_close(\$link);
?>
";
$file = fopen('index.php',"w");
fwrite($file,$body);
fclose($file);
echo '... finished!<br/>...Install complete!</br>';
echo '<a href="index.php?pass=letmein"><h1>Start using frosty now!</h1></a>
<br/>Please note to login to frosty use the login password: letmein';
}
?>
