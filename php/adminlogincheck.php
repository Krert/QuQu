<?php
session_start();
function loginCheck(){
if($_SESSION && isset($_SESSION["admin"])):
	return true;
else:
	return false;
endif;
}
?>