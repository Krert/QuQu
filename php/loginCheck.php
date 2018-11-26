<?php
session_start();
function loginCheck(){
if($_SESSION && isset($_SESSION["login"])):
	return true;
else:
	return false;
endif;
}
?>