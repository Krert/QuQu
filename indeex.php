<?php
include "./php/loginCheck.php";
include "./php/sqlQuery.php";
$error = "";
$html = "";
	if(loginCheck()):
		$name = $_SESSION["name"];
		$str = '<a href="./php/profile.php">' . $name . '</a>&nbsp;|&nbsp;<a href="./php/logout.php">logout</a>';
	else:
		$str = '<a href="./PHP/login.php">login</a>';
	endif;

	// sql
	$slctColumn = "questionID,title,name,date";
	$table = "questions";
	$match = "";
	if(sqLselect($slctColumn,$table,$match)):
		$max = count($dbData);
		for($i = 0; $i < $max; $i++):
			echoHTML($dbData[$i]["questionID"],$dbData[$i]["title"],$dbData[$i]["name"],$dbData[$i]["date"]);
		endfor;
	else:
		$error = "Error or we don't heve any problem :D";
	endif;

function echoHTML($id,$title,$name,$date){
global $html;
$html .= <<< EOS
	<tr>
	<td>{$id}.</td>
	<td></td>
	<td><a href="./php/item.php?Qid={$id}">{$title}</a></td>
	</tr>
	<tr>
	<td colspan="2"></>
	<td>{$date} by {$name}</td>
	</tr>
EOS;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>QuQu</title>
	<link rel="stylesheet" type="text/css" href="./css/index.css">
	<link rel="stylesheet" type="text/css" href="./css/mainTable.css">
</head>
<body>
<center>
<table id="main">
	<tr id="menu">
		<td>
			<b>
				<a href="indeex.php">QuQu</a>
			</b>
			&nbsp; 
			&nbsp;
			<a href="./php/submit.php">submit</a>
			&nbsp; 
			&nbsp;
			<a href="./php/search.php">search</a>
		</td>
		<td id="profile">
			<!-- login or name | logout -->
			<?php echo $str ?>
		</td>
		</tr>
		<tr>
			<td colspan="2">
				<span><?php echo $error = ($error) ? $error : ""; ?></span>
				<table id="conts">
				<?php echo $html = ($html) ? $html : "No more problem" ?>
				</table>
			</td>
		</tr>
</table>
<center>
</body>
</html>