<?php
	require_once("adm/includes/application-top.php");
	require_once("adm/includes/classes/class.PropertyUrl.php");
	
	$UrlObj 	= new PropertyUrl(); 
	$url_name 	= $_REQUEST['url_name'];
	$url_result	= $UrlObj->fun_checkPropertyUrl($url_name);
	if( $url_result == true){
		echo "no";
	}else{
		echo "yes";
	}	
?>