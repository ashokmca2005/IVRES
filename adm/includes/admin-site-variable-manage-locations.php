<?php
// Form submision
$detail_array 	= array();
$error_msg		= 'no';
if($_POST['securityKey']==md5(COUNTRYDELETE)){
	if(isset($_POST['txtCountryId']) && $_POST['txtCountryId'] != "") {
		$txtCountryId = $_POST['txtCountryId'];
		//$promoObj->fun_delPromo($txtCountryId);
	}

	/*
	echo "<script> location.href='admin-site-variables.php?sec=manloca';</script>";
	*/
	redirectURL('admin-site-variables.php?sec=manloca');
}

if($_POST['securityKey'] == md5(ADDCOUNTRY)){
	$edit = false;
	if(isset($_POST['txtCountryId']) && $_POST['txtCountryId'] != "") {
		$txtCountryId			= $_POST['txtCountryId'];
		$edit = true;
	}

	$txtCountryName 		= $_POST['txtCountryName'];
	$txtCountryISO2 		= $_POST['txtCountryISO2'];
	$txtCountryISO3 		= $_POST['txtCountryISO3'];
	$txtCountryISD			= $_POST['txtCountryISD'];
	$txtCountryDesc 		= $_POST['txtCountryDesc'];
	$p_map_latitude 		= $_POST['p_map_latitude'];
	$p_map_longitude 		= $_POST['p_map_longitude'];
	$p_map_zoom				= $_POST['p_map_zoom'];

	if($edit == true) {
		$locationObj->fun_editCountry($txtCountryId, $txtCountryName, $txtCountryISO2, $txtCountryISO3, $txtCountryISD, $txtCountryDesc, $p_map_latitude, $p_map_longitude, $p_map_zoom);
	} else {
		$txtCountryId = $locationObj->fun_addCountry($txtCountryName, $txtCountryISO2, $txtCountryISO3, $txtCountryISD, $txtCountryDesc, $p_map_latitude, $p_map_longitude, $p_map_zoom);
	}
	/*
	echo "<script>location.href = 'admin-site-variables.php?sec=manloca&action=edit&countryid=".$txtCountryId."';</script>";
	*/
	redirectURL('admin-site-variables.php?sec=manloca&action=edit&countryid='.$txtCountryId);
}

if($_POST['securityKey'] == md5(ADDAREA)){
	$edit = false;
	if(isset($_POST['txtAreaId']) && $_POST['txtAreaId'] != "") {
		$txtAreaId			= $_POST['txtAreaId'];
		$edit = true;
	}

	$txtCountryId 			= $_POST['txtCountryId'];
	$txtAreaName 			= $_POST['txtAreaName'];
	$txtAreaDesc 			= $_POST['txtAreaDesc'];
	$p_map_latitude 		= $_POST['p_map_latitude'];
	$p_map_longitude 		= $_POST['p_map_longitude'];
	$p_map_zoom				= $_POST['p_map_zoom'];

	if($edit == true) {
		$locationObj->fun_editAreas($txtAreaId, $txtCountryId, $txtAreaName, $txtAreaDesc, $p_map_latitude, $p_map_longitude, $p_map_zoom);
	} else {
		$txtAreaId = $locationObj->fun_addAreas($txtCountryId, $txtAreaName, $txtAreaDesc, $p_map_latitude, $p_map_longitude, $p_map_zoom);
	}
	/*
	echo "<script>location.href = 'admin-site-variables.php?sec=manloca&action=edit&show=area&countryid=".$txtCountryId."&areaid=".$txtAreaId."';</script>";
	*/
	redirectURL('admin-site-variables.php?sec=manloca&action=edit&show=area&countryid='.$txtCountryId.'&areaid='.$txtAreaId);
}

if($_POST['securityKey'] == md5(DELAREA)){
	if(isset($_POST['txtAreaId']) && $_POST['txtAreaId'] != "") {
		$txtAreaId		= $_POST['txtAreaId'];
		$txtCountryId 	= $locationObj->fun_getAreaCountryIdById($txtAreaId);
		$locationObj->fun_delAreaById($txtAreaId);
	}
	/*
	echo "<script>location.href = 'admin-site-variables.php?sec=manloca&show=area&countryid=".$txtCountryId."';</script>";
	*/
	redirectURL('admin-site-variables.php?sec=manloca&show=area&countryid='.$txtCountryId);
}

if($_POST['securityKey'] == md5(ADDREGION)){
	$edit = false;
	if(isset($_POST['txtRegionId']) && $_POST['txtRegionId'] != "") {
		$txtRegionId			= $_POST['txtRegionId'];
		$edit = true;
	}

	$txtAreaId 			= $_POST['txtAreaId'];
	$txtRegionName 		= $_POST['txtRegionName'];
	$txtRegionDesc 		= $_POST['txtRegionDesc'];
	$p_map_latitude 	= $_POST['p_map_latitude'];
	$p_map_longitude 	= $_POST['p_map_longitude'];
	$p_map_zoom			= $_POST['p_map_zoom'];
	$txtStatus			= $_POST['txtStatus'];

	if($edit == true) {
		$locationObj->fun_editRegions($txtRegionId, $txtAreaId, $txtRegionName, $txtRegionDesc, $p_map_latitude, $p_map_longitude, $p_map_zoom, $txtStatus);
	} else {
		$txtRegionId = $locationObj->fun_addRegions($txtAreaId, $txtRegionName, $txtRegionDesc, $p_map_latitude, $p_map_longitude, $p_map_zoom, $txtStatus);
	}
	/*
	echo "<script>location.href = 'admin-site-variables.php?sec=manloca&action=edit&show=region&areaid=".$txtAreaId."&regionid=".$txtRegionId."';</script>";
	*/
	redirectURL('admin-site-variables.php?sec=manloca&action=edit&show=region&areaid='.$txtAreaId.'&regionid='.$txtRegionId);
}

if($_POST['securityKey'] == md5("DELREGION")){
	if(isset($_POST['txtRegionId']) && $_POST['txtRegionId'] != "") {
		$txtRegionId	= $_POST['txtRegionId'];
		$txtAreaId 		= $locationObj->fun_getRegionAreaIdById($txtRegionId);
		$locationObj->fun_delRegionById($txtRegionId);
	}

	/*
	echo "<script>location.href = 'admin-site-variables.php?sec=manloca&show=region&areaid=".$txtAreaId."';</script>";
	*/
	redirectURL('admin-site-variables.php?sec=manloca&show=region&areaid='.$txtAreaId);
}

if($_POST['securityKey'] == md5(ADDLOCATION)){
	$edit = false;
	if(isset($_POST['txtLocationId']) && $_POST['txtLocationId'] != "") {
		$txtLocationId	= $_POST['txtLocationId'];
		$edit = true;
	}
	$txtRegionId 		= $_POST['txtRegionId'];
	$txtLocationName 	= $_POST['txtLocationName'];
	$txtLocationDesc 	= $_POST['txtLocationDesc'];
	$p_map_latitude 	= $_POST['p_map_latitude'];
	$p_map_longitude 	= $_POST['p_map_longitude'];
	$p_map_zoom			= $_POST['p_map_zoom'];
	$txtPostalCode		= $_POST['txtPostalCode'];
	$txtStatus			= $_POST['txtStatus'];

	if($edit == true) {
		$locationObj->fun_editLocations($txtLocationId, $txtRegionId, $txtLocationName, $txtLocationDesc, $p_map_latitude, $p_map_longitude, $p_map_zoom, $txtPostalCode, $txtStatus);
	} else {
		$txtLocationId = $locationObj->fun_addLocations($txtRegionId, $txtLocationName, $txtLocationDesc, $p_map_latitude, $p_map_longitude, $p_map_zoom, $txtPostalCode, $txtStatus);
	}
	/*
	echo "<script>location.href = 'admin-site-variables.php?sec=manloca&action=edit&show=location&regionid=".$txtRegionId."&locationid=".$txtLocationId."';</script>";
	*/
	redirectURL('admin-site-variables.php?sec=manloca&action=edit&show=location&regionid='.$txtRegionId.'&locationid='.$txtLocationId);
}

if($_POST['securityKey'] == md5(DELLOCATION)){
	if(isset($_POST['txtLocationId']) && $_POST['txtLocationId'] != "") {
		$txtLocationId	= $_POST['txtLocationId'];
		$txtRegionId = $locationObj->fun_getLocationRegionIdById($txtLocationId);
		$locationObj->fun_delLocationById($txtLocationId);
	}
	/*
	echo "<script>location.href = 'admin-site-variables.php?sec=manloca&show=location&regionid=".$txtRegionId."';</script>";
	*/
	redirectURL('admin-site-variables.php?sec=manloca&show=location&regionid='.$txtRegionId);
}

if(isset($_GET['action']) && $_GET['action'] !=""){
	if(isset($_GET['show']) && $_GET['show'] == "location") {
		$addtitle 	= "Manage Locations";
		$region_id	= $_GET['regionid'];
		$area_id 	= $locationObj->fun_getRegionAreaIdById($region_id);
		$region_name= $locationObj->fun_getRegionNameById($region_id);
		include("includes/admin-site-variable-manage-locations-locations.php");
	} else if(isset($_GET['show']) && $_GET['show'] == "region") {
		$addtitle 	= "Manage Area / Towns";
		$area_id 	= $_GET['areaid'];
		$country_id = $locationObj->fun_getAreaCountryIdById($area_id);
		$area_name 	= $locationObj->fun_getAreaNameById($area_id);
		include("includes/admin-site-variable-manage-locations-regions.php");
	} else if(isset($_GET['show']) && $_GET['show'] == "area") {
		$addtitle 		= "Manage Regions";
		$country_id 	= $_GET['countryid'];
		$country_name 	= $locationObj->fun_getCountryNameById($country_id);
		include("includes/admin-site-variable-manage-locations-areas.php");
	} else {
		$addtitle = "Manage Countries";
		include("includes/admin-site-variable-manage-locations-countries.php");
	}

} else {
	if(isset($_GET['show']) && $_GET['show'] == "location") {
		$addtitle 	= "Manage Locations";
		$region_id	= $_GET['regionid'];
		$area_id 	= $locationObj->fun_getRegionAreaIdById($region_id);
		$region_name= $locationObj->fun_getRegionNameById($region_id);
		include("includes/admin-site-variable-manage-locations-locationslist.php");
	} else if(isset($_GET['show']) && $_GET['show'] == "region") {
		$addtitle 	= "Manage Area / Towns";
		$area_id 	= $_GET['areaid'];
		$country_id = $locationObj->fun_getAreaCountryIdById($area_id);
		$area_name 	= $locationObj->fun_getAreaNameById($area_id);
		include("includes/admin-site-variable-manage-locations-regionslist.php");
	} else if(isset($_GET['show']) && $_GET['show'] == "area") {
		$addtitle 	= "Manage Regions";
		$country_id = $_GET['countryid'];
		$country_name 	= $locationObj->fun_getCountryNameById($country_id);
		include("includes/admin-site-variable-manage-locations-areaslist.php");
	} else {
		$addtitle = "Manage Countries";
		include("includes/admin-site-variable-manage-locations-countrieslist.php");
	}
}
?>