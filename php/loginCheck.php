<?php
session_start();
function loginCheck(){
if($_SESSION && $_SESSION["login"]):
	return true;
else:
	return false;
endif;
}
?>