<?php
	session_start();
	if(isset($_SESSION['ses_admin_id']) && ($_SESSION['ses_admin_id'] != "") && isset($_SESSION['ses_admin_pass']) && ($_SESSION['ses_admin_pass'] != "")) {
		header('Location: admin-home.php');
	} else {
		$_SESSION['ses_admin_id'] 		= "";
		$_SESSION['ses_admin_fname'] 	= "";
		$_SESSION['ses_admin_email'] 	= "";
		$_SESSION['ses_admin_pass'] 	= "";
		session_destroy();
		header('Location: login.php');
	}
?>