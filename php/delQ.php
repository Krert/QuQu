<?php
include "loginCheck.php";
include "optimizeStr.php";
include "sqlQuery.php";
if(!loginCheck()) header('Location: ./login.php');

if(isset($_GET['Qid'])):
	$Qid = optmzStr($_GET["Qid"], "low");
	$username = $_SESSION["name"];

	$slctColumn = "name";
	$table = "questions";
	$match = "WHERE questionID = $Qid";
	if(sqLselect($slctColumn,$table,$match)):
		if($dbData[0]["name"] == $username):
			$matchColumn = "questionID";
			$matchValue = $Qid;
			echo "before if";
			if(sqLdelete($table,$matchColumn,$matchValue)):
				header('Location: ./profile.php');
			else:
				echo "error :D hehe";
			endif;
		endif;

	else:
		$error = "<b>!Error! *O Maybe you can not post answers.Q<b>" . $conn->error;
	endif;
endif;
?>