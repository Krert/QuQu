<?php
include "loginCheck.php";
include "optimizeStr.php";
include "sqlQuery.php";
$error = "";

if(!loginCheck()) header('Location: ../indeex.php');


if($_POST && $_POST["current_pw"] && $_POST["new_pw"]):
	$current_pw = optmzStr($_POST["current_pw"],"hight");
	$new_pw = optmzStr($_POST["new_pw"],"hight");
	$username = $_SESSION["name"];

	// edit
	if($current_pw && $new_pw):
		//select
		$table = "user_profile";
		$slctColumn = "pw";
		$match = "WHERE name = '$username'";
			//sql
			if(sqLselect($slctColumn,$table,$match) && pwCheck()):

				//updata
				$table = "user_profile";
				$setData = "pw = '$new_pw'";
				$matchColumn = "name";
				$matchValue = $username;
					//sql
					if(sqLupdate($table,$setData,$matchColumn,$matchValue)):
						header('Location: ./profile.php');
					else:
						$error = "SQL ERROR(code:134). Please try again." . $conn->error;
					endif;

			else:
				$error = "Current password or new password is wrong. Please try again.";
			endif;
	endif;

endif;

function pwCheck(){
	global $current_pw;
	global $pw;
	global $dbData;
		if($dbData && $current_pw != $dbData[0]["pw"]):
			return false;
		endif;
	return true;
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
	Edit password user => <b><?= $_SESSION["name"] ?></b>
	<br>
	<br>
	<form method="post">
		<table id="login">
		<tr>
		<td>current password:</td>
		<td>
			<input type="password" name="current_pw" size="20" autocorrect="off" spellcheck="false" autocapitalize="off">
		</td>
		</tr>
		<tr>
		<td>new password:</td>
		<td>
			<input type="password" name="new_pw" size="20">
		</td>
		</tr>
		<td></td>
		<td>
			<input type="submit" name="submit" value="edit password" style="width:130px;">
		</td>
		</tr>
		</table>
		<br>
	</form>
</body>
</html>