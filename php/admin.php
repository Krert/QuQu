<?php
include "adminlogincheck.php";
include "optimizeStr.php";
include "./sqlQuery.php";
$error = "";
$html = "";
$str = "";
	if(loginCheck()):
		$str = '</a>&nbsp;|&nbsp;<a href="./adminlogout.php">logout</a>';
	else:
		header('Location: ./adminlogin.php');
	endif;

	// sql
	$slctColumn = "name,id";
	$table = "user_profile";
	$match = "";
	if(sqLselect($slctColumn,$table,$match)):
		$max = count($dbData);
		for($i = 0; $i < $max; $i++):
			echoHTML($dbData[$i]["id"],$dbData[$i]["name"]);
		endfor;
	else:
		$error = "no user";
	endif;

function echoHTML($id,$name){
global $html;
$html .= <<< EOS
	<tr>
	<td>{$id}.</td>
	<td></td>
	<td>
	<form method="post">
	<span>{$name}</span>
	<input type="hidden" name="userid" value="{$id}">
	<input type="submit" value="delete">
	</form>
	</td>
	</tr>
	<tr>
	<td colspan="2"></>
	<td></td>
	</tr>
EOS;
}

if(isset($_POST["userid"])):
	$id = optmzStr($_POST["userid"],"low");
	delete($id);
	header('Location: ./admin.php');
endif;

function delete($id){
	$matchColumn = "id";
	$matchValue = $id;

	$table = "user_profile";
	if(!sqLdelete($table,$matchColumn,$matchValue)) return false;
	$table = "questions";
	if(!sqLdelete($table,$matchColumn,$matchValue)) return false;
	$table = "answers";
	if(!sqLdelete($table,$matchColumn,$matchValue)) return false;

	return true;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>QuQu</title>
	<link rel="stylesheet" type="text/css" href="../css/index.css">
	<link rel="stylesheet" type="text/css" href="../css/mainTable.css">
</head>
<body>
<center>
<table id="main">
	<tr id="menu">
		<td>
			<b>
				<a href="indeex.php">QuQu -admin page-</a>
			</b>
		</td>
		<td id="profile">
			<!-- login or name | logout -->
			<?php echo $str = ($str) ? $str : "" ?>
		</td>
		</tr>
		<tr>
			<td colspan="2">
				<span><?php echo $error = ($error) ? $error : ""; ?></span>
				<table id="conts">
				<?php echo $html = ($html) ? $html : "" ?>
				</table>
			</td>
		</tr>
</table>
<center>
</body>
</html>