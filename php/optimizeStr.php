<?php
function optmzStr($string,$level){
	global $error;
	//trim
	$string = ltrim($string); // \n hogehoge \n => hogehoge \n
	$string = rtrim($string); // \n hogehoge \n => \n hogehoge 

	//count length of str
	$strlen = mb_strlen($string);
	if($strlen < 3 || $strlen > 1000) return false;


	if($level === "hight" && $strlen < 20):
		if(!$string || strpos($string,' ') !== false):
			$error = "Bad strings. Please try again.";
			return false;
		endif;
	endif;
	$string = htmlspecialchars($string,ENT_QUOTES);
	$string = nl2br($string);
	return $string;
}
?>