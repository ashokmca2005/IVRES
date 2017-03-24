<?php 
	if($_SERVER["SERVER_NAME"] == "localhost") {
		require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/includes/application-top.php");
	} else {
		require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
	}

	require_once(SITE_CLASSES_PATH."class.Email.php");
	$conEmailObj = new Seo();
	if(isset($_REQUEST['uId'])){
		$u_id = base64_decode($_REQUEST['uId']);
		if($conEmailObj->fun_activeUsersLink($u_id)){
			redirectURL("confirm.php"); // Go to registration thanks page
		}
		else{
			redirectURL("confirm.php");
		}
	}
?>