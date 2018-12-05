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
		$location= "Location: ./edititem.php?Qid=" . $Qid; 
		//sql Question
		$slctColumn = "title,text,name,date";
		$table = "questions";
		$match = "WHERE questionID = $Qid";
		if(sqLselect($slctColumn,$table,$match)):
			$max = count($dbData);
			$QData = $dbData;
			for($i = 0; $i < $max; $i++):
				if($QData[$i]["name"] != $_SESSION["name"]) header($location);
				echoQ($Qid,$QData[$i]["title"],$QData[$i]["text"],$QData[$i]["name"],$QData[$i]["date"]);
			endfor;
		else:
			$error = "<b>!Error! *O Maybe you can not post answers.Q<b>" . $conn->error;
		endif;

	else://if there is no $_GET, it will display top page;
		header('Location: ../indeex.php');
	endif;

	//post
	if($login && $_POST && $_POST["text"]):
		$name = $_SESSION["name"];
		$text = optmzStr($_POST["text"],"low");
		$date = date('Y-m-d');
		if(strlen($text) === 0):
			header($location);
			exit;
		endif;
		$newText = $QData[0]["text"] . "<br><br>---". $date . " add------------------<br>" . $text;

		//sql
		$table = "questions";
		$setData = "text = '$newText'";
		$matchColumn = "questionID";
		$matchValue = $Qid;
			if(sqLupdate2($table,$setData,$matchColumn,$matchValue)):
				header($location);
			else:
				$error = "SQL ERROR(code:134). Please try again. If it always happen, please tell me code." . $conn->error;
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
						<input type="submit" value="add question">
						</td>
					</tr>
					</form>
				</table>
			</td>
		</tr>
</table>
<center>
</body>
</html>