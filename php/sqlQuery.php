<?php
include "dbconnect.php";
function sqLinsert($table,$columns,$values){
	global $conn;
	global $sql;
	$sql = "INSERT INTO $table ($columns) VALUES ($values)";
	if($conn->query($sql)):
		return true;
	else:
		return false;
	endif;
}

function sqLselect($slctColumn,$table,$match){
	global $conn;
	global $result;
	global $dbData;
	$sql = "SELECT $slctColumn FROM $table $match";
	$result = $conn->query($sql);
	if($result->num_rows > 0):
		return getdata($result,$slctColumn);
	else:
		return false;
	endif;
}

function sqLsearch($slctColumn,$table,$matchColumn,$value){
	global $conn;
	global $result;
	global $dbData;
	global $sql;
	$sql = "SELECT $slctColumn FROM $table WHERE $matchColumn LIKE '$value%'";
	$result = $conn->query($sql);
	if($result->num_rows > 0):
		return getdata($result,$slctColumn);
	else:
		return false;
	endif;
}

function sqLupdate($table,$setData,$matchColumn,$matchValue){
	global $conn;
	$sql = "UPDATE $table SET $setData WHERE $matchColumn = '$matchValue'";
	if($conn->query($sql)):
		return true;
	else:
		return false;
	endif;
}

function sqLupdate2($table,$setData,$matchColumn,$matchValue){
	global $conn;
	$sql = "UPDATE $table SET $setData WHERE $matchColumn = $matchValue";
	if($conn->query($sql)):
		return true;
	else:
		return false;
	endif;
}

function sqLdelete($table,$matchColumn,$matchValue){
	global $conn;
	$sql = "DELETE FROM $table WHERE $matchColumn = '$matchValue'";
		if($conn->query($sql)):
			return true;
		else:
			return false;
		endif;
}

function getData($result,$slctColumn){
	global $dbData;
	$slctPieces = explode(",", $slctColumn);
	$max = count($slctPieces);
	$dbData = array();
	$temp = array();
	while($row = $result->fetch_assoc()):
		for($i = 0; $i < $max; $i++):
			$index = $slctPieces[$i];
			$temp[$index] = $row[$index];
		endfor;
		array_push($dbData,$temp);
	endwhile;
	return true;
}
?>