<?php
include "loginCheck.php";
include "optimizeStr.php";
include "sqlQuery.php";
$error = "";

if(loginCheck()) header('Location: ../indeex.php');


if($_POST && $_POST["acct"] && $_POST["pw"]):
	$username = optmzStr($_POST["acct"],"hight");
	$pw = optmzStr($_POST["pw"],"hight");
	$submit = optmzStr($_POST["submit"],"hight");
// login
	if($submit === "login" && $username && $pw):
		$table = "user_profile";
		$slctColumn = "name,id,pw";
		$matchColumn = "name";
		$matchValue = $username;
			if(sqLselect($slctColumn,$table,$matchColumn,$matchValue) && pwCheck()):
				setSESSION($dbData[0]["name"]);
				header('Location: ../indeex.php');
			else:
				$error = "Name or Password is wrong. Please try again.";
			endif;
	endif;
// register
	if($submit === "register" && $username && $pw):
		$table = "user_profile";
		$columns = "name,pw";
		$values = "'$username','$pw'";
			// sql
			if(sqLinsert($table,$columns,$values)):
				setSESSION($username);
				header('Location: ../indeex.php');
			else:
				$error = "Bad strings. Please try again other words.";
			endif;
	endif;

endif;

function pwCheck(){
	global $pw;
	global $dbData;
		if($pw != $dbData[0]["pw"]):
			return false;
		endif;

	return true;
}

function setSESSION($name){
	$_SESSION["login"] = true;
	$_SESSION["name"] = $name;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>login | create account</title>
<link rel="stylesheet" type="text/css" href="../css/index.css">
<link rel="stylesheet" type="text/css" href="../css/login.css">
</head>
<body>
	<span><?php echo $error = ($error) ? $error : ""; ?></span>
	<br>
<!-- login -->
	<b>Login</b>
	<br>
	<br>
	<form method="post">
		<table id="login">
		<tr>
		<td>username:</td>
		<td>
			<input type="text" name="acct" size="20" autocorrect="off" spellcheck="false" autocapitalize="off">
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
	<br>
	<a href="">Forgot your password?</a>
	<br>
	<br>
<!-- create account -->
	<b>Create Account</b>
	<br>
	<br>
	<form method="post">
		<table id="login">
		<tr>
		<td>username:</td>
		<td><input type="text" name="acct" size="20" autocorrect="off" spellcheck="false" autocapitalize="off"></td>
		</tr>
		<tr>
		<td>password:</td>
		<td><input type="password" name="pw" size="20"></td>
		</tr>
		</table>
		<br>
		<input type="submit" name="submit" value="register">
	</form>
</body>
</html>