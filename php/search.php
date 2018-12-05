<?php
include "optimizeStr.php";
include "sqlQuery.php";
$notice = "";
$dbData = "";
if(isset($_GET['acct'])):
	$str = optmzStr($_GET["acct"], "low");
	
	$table = "questions";
	$slctColumn = "title,questionID";
	$matchColumn = "title";
	$value = $str;
	if(sqLsearch($slctColumn,$table,$matchColumn,$value)):
		
	else:
		$error = "<b>Nothing<b>";
	endif;
endif;


function echoQ () 
{
	global $dbData;
	foreach ($dbData as $key) {
		echo <<< EOS
		<tr>
		<td></td>
		<td>
		<a href="./editItem.php?Qid={$key["questionID"]}">{$key["questionID"]}. {$key["title"]}</a>
		</td>
		</tr>
EOS;
	}
}


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
				<form method="get">
				<table id="submit">
					<tr id="searvh">
						<td>search</td>
						<td>
						<input type="text" name="acct" autocorrect="off" spellcheck="false" autocapitalize="off" autofocus>
						
						</form>
						</td>
					</tr>
					<tr id="tr_about">
						<td>result</td>
						<td>
							<?php echo $notice = ($dbData) ? echoQ() : "Nothing"; ?>
						</td>
					</tr>
				</table>
				</form>
			</td>
		</tr>
</table>
<center>
</body>
</html>