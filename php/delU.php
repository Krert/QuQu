<?php
include "loginCheck.php";
include "optimizeStr.php";
include "sqlQuery.php";
$error = "";

if(!loginCheck()) header('Location: ../indeex.php');


if(isset($_POST["pw"])):
	$username = $_SESSION["name"];
	$pw = optmzStr($_POST["pw"],"hight");
// login
	if($username && $pw):
		$table = "user_profile";
		$slctColumn = "name,id,pw";
		$match = "WHERE name = '$username'";
			if(sqLselect($slctColumn,$table,$match) && pwCheck()):
				if(delete()):	
					session_destroy();
					header('Location: ../indeex.php');
				else:
					$error = "Error(224)";
				endif;
			else:
				$error = "Name or Password is wrong. Please try again.$conn->error";
			endif;
	endif;
endif;



function pwCheck(){
	global $pw;
	global $dbData;
		if($dbData && $pw != $dbData[0]["pw"]):
			return false;
		endif;

	return true;
}

function delete(){
	global $dbData;
	$matchColumn = "id";
	$matchValue = $dbData[0]["id"];

	$table = "user_profile";
	if(!sqLdelete($table,$matchColumn,$matchValue)) return false;
	$table = "questions";
	if(!sqLdelete($table,$matchColumn,$matchValue)) return false;
	$table = "answers";
	if(!sqLdelete($table,$matchColumn,$matchValue)) return false;

	return true;
}

function logout(){
	$_SESSION["login"] = false;
	$_SESSION["name"] = null;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>delete your account</title>
<link rel="stylesheet" type="text/css" href="../css/index.css">
<link rel="stylesheet" type="text/css" href="../css/login.css">
</head>
<body>
	<span><?php echo $error = ($error) ? $error : ""; ?></span>
	<br>
<!-- delet account -->
	<b>delete your account</b><br>
	<b>!! YOUR ACCOUNT,QUESTIONS,ANSWERS is dereted by this action!!</b>
	<br>
	<br>
	<form method="post">
		<table id="login">
		<tr>
		<td>password:</td>
		<td>
			<input type="password" name="pw" size="20">
		</td>
		</tr>
		</table>
		<br>
		<input type="submit" name="submit" value="delete my account">
	</form>
</body>
</html>