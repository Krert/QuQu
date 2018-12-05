<?php
include "loginCheck.php";
include "optimizeStr.php";
include "sqlQuery.php";
$error = "";
if(!loginCheck()) header('Location: ./login.php');

if($_POST && $_POST["title"] && $_POST["text"]):
	$title = optmzStr($_POST["title"],"hight");
	$text = optmzStr($_POST["text"],"low");
	if($title && $text):
		$name = $_SESSION["name"];
		$id = $_SESSION["id"];
		$date = date("Y-m-d");
		//sql
		$table = "questions";
		$columns = "title,text,id,name,date";
		$value = "'$title','$text',$id,'$name','$date'";
			if(sqLinsert($table,$columns,$value)):
				header('Location: ../indeex.php');
			else:
				echo $sql;
				$error = "SQL ERROR(code:234). Please try again. If it always happen, please tell me code." . $conn->error;
			endif;
	else:
		$error = "Error.Your post is too long or too short.We can not allow over 1000 strings.";
	endif;
else:
	$error = "please put string both";
endif;
?>
<!DOCTYPE html>
<html>
<head>
	<title>QuQu</title>
	<link rel="stylesheet" type="text/css" href="../css/index.css">
	<link rel="stylesheet" type="text/css" href="../css/mainTable.css">
	<link rel="stylesheet" type="text/css" href="../css/submit.css">
</head>
<body>
<center>
<table id="main">
	<tr id="menu">
		<td>
			<b>
				<a href="../indeex.php">QuQu</a>
			</b>
			&nbsp; 
			&nbsp;
			<a href="./submit.php">submit</a>
		</td>
		</tr>
		<tr>
			<td colspan="2">
				<span><?php echo $error = ($error) ? $error : ""; ?></span>
				<form method="post">
				<table id="submit">
					<tr>
						<td>title</td>
						<td>
						<input type="text" name="title" autocorrect="off" spellcheck="false" autocapitalize="off">
						</td>
					</tr>
					<tr>
						<td></td>
						<td><b></b></td>
					</tr>
					<tr>
						<td>text</td>
						<td>
							<textarea name="text"></textarea>
						</td>
					</tr>
					<tr>
						<td></td>
						<td><input type="submit"></td>
					</tr>
				</table>
				</form>
			</td>
		</tr>
</table>
<center>
</body>
</html>