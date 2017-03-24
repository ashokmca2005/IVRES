<?php
	session_start();
	$_SESSION['ses_admin_id'] 		= "";
	$_SESSION['ses_admin_fname'] 	= "";
	$_SESSION['ses_admin_email'] 	= "";
	$_SESSION['ses_admin_pass'] 	= "";
	session_destroy();
	header('Location: login.php');
?>