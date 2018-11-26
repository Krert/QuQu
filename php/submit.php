<?php
include "loginCheck.php";
include "optimizeStr.php";
include "sqlQuery.php";
$error = "";
if(!loginCheck()) header('Location: ./login.php');

if($_POST && $_POST["title"] && $_POST["text"]):
	$title = optmzStr($_POST["title"],"low");
	$text = optmzStr($_POST["text"],"low");
	if($title && $text):
		$name = $_SESSION["name"];
		$date = date("Y-m-d");
		//sql
		$table = "questions";
		$columns = "title,text,name,date";
		$value = "'$title','$text','$name','$date'";
			if(sqLinsert($table,$columns,$value)):
				header('Location: ../indeex.php');
			else:
				$error = "SQL ERROR(code:234). Please try again. If it always happen, please tell me code.";
			endif;
	else:
		$error = "this is main if Bad strings. Please try again.";
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
</head>
<body>
<center>
<table id="main">
	<tr id="topsel">
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