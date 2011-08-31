<?php $imagelink = $_GET['interface']; ?>
<html>
<!-Start Header.php-->
<head>
<title>Frosty</title>
<link rel="stylesheet" type="text/css" href="inc/style.css" />
</head>
<body>
<center><img src="inc/frosty <?php echo $imagelink; ?>.png" border="0"/><br/>
Just press Log in to access the open beta. OR Type in your invitaional password to login to the unrestricted beta.</br>
<form action="" method="get">
login:<input type="password" name="pass" value="tryme"/><input type="submit" value="Log In"/>
</form>
<!-End Header.php-->
