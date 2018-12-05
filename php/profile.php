<?php
include "loginCheck.php";
include "optimizeStr.php";
include "sqlQuery.php";
$error = "";
$emai_error = "";
if(!loginCheck()) header('Location: ./login.php');

//sql show user profile
$username = $_SESSION["name"];
$table = "user_profile";
$slctColumn = "name,email,id,pw,text";
$match = "WHERE name = '$username'";
	if(sqLselect($slctColumn,$table,$match)):
		$proData = $dbData;
		if(!$proData[0]["email"]):
			$emai_error = "";
		endif;
	else:
		$error = "Error. Please try again.";
	endif;

//sql show user question
$table = "questions";
$slctColumn = "title,questionID,date";
	if(sqLselect($slctColumn,$table,$match)):
		$QData = $dbData;
	else:
		$error = "Error. Please try again.";
	endif;

function echoQ () 
{
	global $QData;
	foreach ($QData as $key) {
		echo <<< EOS
		<tr>
		<td></td>
		<td>
		<a href="./editItem.php?Qid={$key["questionID"]}">{$key["questionID"]}. {$key["title"]}({$key["date"]})</a>
		<a href="#" onclick="notice(this)" id="{$key["questionID"]}">[delete]</a>
		</td>
		</tr>
EOS;
	}
}

if($_POST && $_POST["email"]):
	$email = optmzStr($_POST["email"],"low");
	$text = optmzStr($_POST["text"],"low");
	if($email):
		$name = $_SESSION["name"];
		//sql
		$table = "user_profile";
		$setData = "email = '$email', text = '$text'";
		$matchColumn = "name";
		$matchValue = $name;
			if(sqLupdate($table,$setData,$matchColumn,$matchValue)):
				header('Location: ./profile.php');
			else:
				$error = "SQL ERROR(code:134). Please try again. If it always happen, please tell me code." . $conn->error;
			endif;
	else:
		$error = "Please try again.";
	endif;
endif;


?>
<!DOCTYPE html>
<html>
<head>
	<title>QuQu</title>
	<link rel="stylesheet" type="text/css" href="../css/index.css">
	<link rel="stylesheet" type="text/css" href="../css/mainTable.css">
	<link rel="stylesheet" type="text/css" href="../css/submit.css">
	<link rel="stylesheet" type="text/css" href="../css/profile.css">
</head>
<body>
<center>
<script>
	function notice(obj)
	{
		if(window.confirm("Delete => " + obj.id)){	
			location.href = "http://192.168.33.10/practice/QuQu_ver3/php/delQ.php?Qid=" + obj.id;
		}else{
		}
	}
</script>
<table id="main">
	<tr id="menu">
		<td>
			<b>
				<a href="../indeex.php">QuQu</a>
			</b>
			&nbsp; 
			&nbsp;
			<a href="">submit</a>
		</td>
		</tr>
		<tr>
			<td colspan="2">
				<span><?php echo $error = ($error) ? $error : ""; ?></span>
				<form method="post">
				<table id="submit">
					<tr id="tr_name">
						<td>name</td>
						<td>
						<?= $username ?>
						</td>
					</tr>
					<tr>
						<td></td>
						<td><b></b></td>
					</tr>
					<tr id="tr_email">
						<td>email</td>
						<td>
						<form method="POST">
						<input type="text" name="email" autocorrect="off" spellcheck="false" autocapitalize="off" placeholder="Not yet registerd email" value="<?= $proData[0]["email"] ?>">
						<?= $emai_error = ($emai_error) ? $emai_error : ""; ?>
						</form>
						</td>
					</tr>
					<tr id="tr_about">
						<td>about</td>
						<td>
							<input type="text" name="text" placeholder="Nothing" value="<?= $proData[0]["text"] ?>">
						</td>
					</tr>
					<tr>
						<td></td>
						<td><input type="submit" value="Edit email and about"></form></td>
					</tr>
					<tr>
						<td></td>
						<td><a href="./editPW">edit password(open other page)</a></td>
					</tr>
					<tr>
						<td>your<br>post</td>
						<td></td>
					</tr>
					<?php echoQ() ?>
					<tr>
						<td><br></td>
						<td></td>
					</tr>
					<tr>
						<td><br></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td style="text-align: center"><b><a href="./delU.php">DELETE MY ACCOUT</a></b></td>
					</tr>

				</table>
				</form>
			</td>
		</tr>
</table>
<center>
</body>
</html>