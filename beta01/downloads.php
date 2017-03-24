<?php
if($_SERVER["SERVER_NAME"] == "localhost") {
	require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/includes/application-top.php");
} else {
	require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
}
$uriArr 	= split("downloads.php\?", $_SERVER['REQUEST_URI']);
$uri 		= $uriArr[1];
redirectURL("download.php?".url_decrypt($uri, ""));
?>