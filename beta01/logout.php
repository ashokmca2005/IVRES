<?php
	if($_SERVER["SERVER_NAME"] == "localhost") {
		require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/includes/application-top.php");
	} else {
		require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
	}
	$_SESSION['ses_user_id'] 	= "";
	$_SESSION['ses_user_fname'] = "";
	$_SESSION['ses_user_email'] = "";
	$_SESSION['ses_user_pass'] 	= "";
	$_SESSION['ses_user_home'] 	= "";
	redirectURL("index.php");
?>