<?php
include "./loginCheck.php";
include "./optimizeStr.php";
include "./sqlQuery.php";
$error = "";
$htmlQ = "";
$htmlA = "";
$NumAns = "";
if(loginCheck()):
	$login = true;
	$name = $_SESSION["name"];
	$str = '<a href="">' . $name . '</a>&nbsp;|&nbsp;<a href="./php/logout.php">logout</a>';
else:
	$str = '<a href="./PHP/login.php">login</a>';
endif;

	if($_GET && $_GET["Qid"]):
		$Qid = optmzStr($_GET["Qid"], "low");

		//sql Question
		$slctColumn = "title,text,name,date";
		$table = "questions";
		$match = "WHERE questionID = $Qid";
		if(sqLselect($slctColumn,$table,$match)):
			$max = count($dbData);
			for($i = 0; $i < $max; $i++):
				echoQ($Qid,$dbData[$i]["title"],$dbData[$i]["text"],$dbData[$i]["name"],$dbData[$i]["date"]);
			endfor;
		else:
			$error = "<b>!Error! *O Maybe you can not post answers.Q<b>" . $conn->error;
		endif;

		//sql Answer
		$slctColumn = "text,name,date";
		$table = "answers";
		if(sqLselect($slctColumn,$table,$match) && $result->num_rows > 0):
			$max = count($dbData);
			$NumAns = $max;
			for($i = 0; $i < $max; $i++):
				echoA($dbData[$i]["text"],$dbData[$i]["name"],$dbData[$i]["date"]);
			endfor;
		else:
				echoA("Not yet answer.","admin","");
		endif;

	else://if there is no $_GET, it will display top page;
		header('Location: ../indeex.php');
	endif;

	//post
	if($login && $_POST && $_POST["text"]):
		$location= "Location: ./item.php?Qid=" . $Qid; 
		$text = optmzStr($_POST["text"],"low");
		if(strlen($text) === 0):
			header($location);
			exit;
		endif;
		$date = date('Y-m-d');

		//sql 
		$table = "answers";
		$columns = "text,name,questionID,date";
		$values = "'$text','$name','$Qid','$date'";
			if(sqLinsert($table,$columns,$values)):
				header($location);
			else:
				$error = "!ERROR! We could not post your answer.";
			endif;

	else:


	endif;

function echoQ($id,$title,$text,$name,$date){
global $htmlQ;
$htmlQ .= <<< EOS
	<tr>
	<td>{$id}</td>
	<td>☆</td>
	<td><a href="">{$title}</a></td>
	</tr>
	<tr>
	<td></td>
	<td>
	<td>{$date} by {$name}</td>
	</tr>
	<tr>
	<td colspan="2"></td>
	<td>
		{$text}
	</td>
	</tr>
EOS;
}

function echoA($text,$name,$date){
global $htmlA;
$htmlA .= <<< EOS
	<tr class="text">
	<td></td>
	<td></td>
	<td>{$text}</td>
	</tr>
	<tr class="date">
	<td></td>
	<td></td>
	<td>{$date} by {$name}</td>
	</tr>
EOS;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>QuQu</title>
	<link rel="stylesheet" type="text/css" href="../css/index.css">
	<link rel="stylesheet" type="text/css" href="../css/mainTable.css">
	<link rel="stylesheet" type="text/css" href="../css/item.css">
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
			<a href="./php/submit.php">submit</a>
		</td>
		<td>
			<!-- login or name | logout -->
			<!-- <?php echo $str ?> -->
		</td>
		</tr>
		<tr>
			<td colspan="2">
				<span><!-- <?php echo $error = ($error) ? $error : ""; ?> --></span>
				<table id="item">
					<?php echo $htmlQ = ($htmlQ) ? $htmlQ : "" ; ?>
					<form method="post">
					<tr>
					<td colspan="2"></td>
					<td>
					<br>
					<span><?php echo $error = ($error) ? $error : ""; ?></span>
					<textarea name="text"></textarea>
					</td>
					</tr>
					<tr>
						<td colspan="2"></td>
						<td>
						<br>
						<input type="submit" value="add comment">
						</td>
					</tr>
					</form>
					<tr>
					<td colspan="2">
						(<?php echo $NumAns = ($NumAns) ? $NumAns : "0" ; ?>)
					</td>
					<td></td>
					</tr>
					<?php echo $htmlA = ($htmlA) ? $htmlA : "" ; ?>
				</table>
			</td>
		</tr>
</table>
<center>
</body>
</html>