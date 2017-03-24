<?php
if($_SERVER["SERVER_NAME"] == "localhost") {
	require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/includes/application-top.php");
} else {
	require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
}

$systemObj 	= new System();

$strContent 	= "";
if(isset($_GET['lang']) && ($_GET['lang'] !="")){
	$langCode 	= $_GET['lang'];
	$langDets 	= $systemObj->fun_getLangInfo($langCode);
	if($langDets["display_status"] == "1"){
		$_SESSION['lang_code'] 	= $langDets["lang_code"];
		$_SESSION['lang_name'] 	= $langDets["name"];
		$strContent 	= "success";
	} else {
		$strContent 	= "failed";
	}
}
echo $strContent;
?>
