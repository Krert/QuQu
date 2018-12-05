<?php
include "adminlogincheck.php";
include "optimizeStr.php";
include "sqlQuery.php";
$error = "";

if(isset($_POST["name"]) && isset($_POST["pw"])):
	$name = optmzStr($_POST["name"],"hight");
	$pw = optmzStr($_POST["pw"],"hight");
// login
	if(pwCheck()):
		setSESSION();
		header('Location: ./admin.php');
	else:
		$error = "Name or Password is wrong. Please try again.";
	endif;
endif;

function pwCheck(){
	global $pw;
	global $name;
	if($pw === "0331" && $name === "keisuke"):
		return true;
	else:
		return false;
	endif;
}

function setSESSION(){
	$_SESSION["admin"] = true;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>login</title>
<link rel="stylesheet" type="text/css" href="../css/index.css">
<link rel="stylesheet" type="text/css" href="../css/login.css">
</head>
<body>
	<span><?php echo $error = ($error) ? $error : ""; ?></span>
	<br>
<!-- login -->
	<b>Admin Login</b>
	<br>
	<br>
	<form method="post">
		<table id="login">
		<tr>
		<td>username:</td>
		<td>
			<input type="text" name="name" size="20" autocorrect="off" spellcheck="false" autocapitalize="off">
		</td>
		</tr>

		<tr>
		<td>password:</td>
		<td>
			<input type="password" name="pw" size="20">
		</td>
		</tr>
		</table>
		<br>
		<input type="submit" name="submit" value="login">
	</form>
</body>
</html>