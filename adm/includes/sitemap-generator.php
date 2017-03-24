<?php
session_start();
require_once("common.php");
require_once("database-table.php");
require_once("classes/class.DB.php");
require_once("classes/class.Sitemap.php");
require_once("functions/general.php");

$dbObj = new DB();
$dbObj->fun_db_connect();

$sitemapObj 	= new sitemap();
$map 			= array();
$country_arr	= array();
$area_arr		= array();
$region_arr		= array();
$location_arr	= array();

//High priority page
$lastmod 		= date('Y-m-d');
$changefreq 	= "daily";
$priority 		= "1.0";
array_push($map, array("loc"=>SITE_URL, "lastmod"=>$lastmod, "changefreq"=>$changefreq, "priority"=>$priority));
array_push($map, array("loc"=>SITE_URL."list-your-property", "lastmod"=>$lastmod, "changefreq"=>$changefreq, "priority"=>$priority));
array_push($map, array("loc"=>SITE_URL."owner-login", "lastmod"=>$lastmod, "changefreq"=>$changefreq, "priority"=>$priority));
array_push($map, array("loc"=>SITE_URL."about-us", "lastmod"=>$lastmod, "changefreq"=>$changefreq, "priority"=>$priority));
array_push($map, array("loc"=>SITE_URL."contact-us", "lastmod"=>$lastmod, "changefreq"=>$changefreq, "priority"=>$priority));
array_push($map, array("loc"=>SITE_URL."help", "lastmod"=>$lastmod, "changefreq"=>$changefreq, "priority"=>$priority));
array_push($map, array("loc"=>SITE_URL."vacation-rentals", "lastmod"=>$lastmod, "changefreq"=>$changefreq, "priority"=>$priority));
array_push($map, array("loc"=>SITE_URL."map.vacation-rentals", "lastmod"=>$lastmod, "changefreq"=>$changefreq, "priority"=>$priority));
array_push($map, array("loc"=>SITE_URL."vacation-rentals/featured", "lastmod"=>$lastmod, "changefreq"=>$changefreq, "priority"=>$priority));
array_push($map, array("loc"=>SITE_URL."vacation-rentals/page_1/latedeal_1", "lastmod"=>$lastmod, "changefreq"=>$changefreq, "priority"=>$priority));


//for property pages
//$pageProperty 	= "sitemapProperties.txt";
//$contentProperty 	= SITE_URL."vacation-rentals\n";

$lastmod 		= date('Y-m-d');
$changefreq 	= "daily";
$priority 		= "0.8";

$sql 	= "SELECT property_id, country_id, area_id, region_id, location_id, friendly_link FROM  " . TABLE_PROPERTY . " WHERE active='1' AND status='2' ORDER BY updated_on";
$rs 	= $dbObj->createRecordset($sql);
if($dbObj->getRecordCount($rs) > 0){
	$arr = $dbObj->fetchAssoc($rs);

	//property page : with friendly url
	for($j = 1; $j < count($arr); $j++) {
		array_push($country_arr, $arr[$j]['country_id']);
		array_push($area_arr, $arr[$j]['area_id']);
		array_push($region_arr, $arr[$j]['region_id']);
		array_push($location_arr, $arr[$j]['location_id']);

		if(isset($arr[$j]['friendly_link']) && $arr[$j]['friendly_link'] !="") {
			//$contentProperty 	.= SITE_URL."vacation-rentals/".$arr[$j]['friendly_link']."\n";
			array_push($map, array("loc"=>SITE_URL."vacation-rentals/".$arr[$j]['friendly_link'], "lastmod"=>$lastmod, "changefreq"=>$changefreq, "priority"=>$priority));
		} else {
		
		}
	}

	//result page : find total number of properties
	for($i = 1; $i < (count($arr)/10); $i++) {
		//$contentProperty 	.= SITE_URL."vacation-rentals/page_".($i+1)."/txtavailabilityids_1\n";
		array_push($map, array("loc"=>SITE_URL."vacation-rentals/page_".($i+1)."/txtavailabilityids_1", "lastmod"=>$lastmod, "changefreq"=>$changefreq, "priority"=>$priority));
	}

	//result page : with location name
	array_unique($country_arr);
	array_unique($area_arr);
	array_unique($region_arr);
	array_unique($location_arr);

	$sqlCountry = "SELECT countries_name FROM  " . TABLE_COUNTRIES . " WHERE countries_id IN ('".implode("','", $country_arr)."')";
	$rsCountry 	= $dbObj->createRecordset($sqlCountry);
	if($dbObj->getRecordCount($rsCountry) > 0){
		$arrCountry = $dbObj->fetchAssoc($rsCountry);
		for($cnt1 = 1; $cnt1 < count($arrCountry); $cnt1++) {
			$countries_name = $arrCountry[$cnt1]['countries_name'];
			array_push($map, array("loc"=>SITE_URL."vacation-rentals/in.".str_replace("/", "_", str_replace(" ", "-", strtolower($countries_name))), "lastmod"=>$lastmod, "changefreq"=>$changefreq, "priority"=>$priority));
		}
	}

	$sqlArea = "SELECT area_name FROM  " . TABLE_AREA . " WHERE area_id IN ('".implode("','", $area_arr)."')";
	$rsArea 	= $dbObj->createRecordset($sqlArea);
	if($dbObj->getRecordCount($rsArea) > 0){
		$arrArea = $dbObj->fetchAssoc($rsArea);
		for($cnt2 = 1; $cnt2 < count($arrArea); $cnt2++) {
			$area_name = $arrArea[$cnt2]['area_name'];
			array_push($map, array("loc"=>SITE_URL."vacation-rentals/in.".str_replace("/", "_", str_replace(" ", "-", strtolower($area_name))), "lastmod"=>$lastmod, "changefreq"=>$changefreq, "priority"=>$priority));
		}
	}

	$sqlRegion = "SELECT region_name FROM  " . TABLE_REGION . " WHERE region_id IN ('".implode("','", $region_arr)."')";
	$rsRegion 	= $dbObj->createRecordset($sqlRegion);
	if($dbObj->getRecordCount($rsRegion) > 0){
		$arrRegion = $dbObj->fetchAssoc($rsRegion);
		for($cnt3 = 1; $cnt3 < count($arrRegion); $cnt3++) {
			$region_name = $arrRegion[$cnt3]['region_name'];
			array_push($map, array("loc"=>SITE_URL."vacation-rentals/in.".str_replace("/", "_", str_replace(" ", "-", strtolower($region_name))), "lastmod"=>$lastmod, "changefreq"=>$changefreq, "priority"=>$priority));
		}
	}

	$sqlLocation = "SELECT location_name FROM  " . TABLE_LOCATION . " WHERE location_id IN ('".implode("','", $location_arr)."')";
	$rsLocation = $dbObj->createRecordset($sqlLocation);
	if($dbObj->getRecordCount($rsLocation) > 0){
		$arrLocation = $dbObj->fetchAssoc($rsLocation);
		for($cnt4 = 1; $cnt4 < count($arrLocation); $cnt4++) {
			$location_name = $arrLocation[$cnt4]['location_name'];
			array_push($map, array("loc"=>SITE_URL."vacation-rentals/in.".str_replace("/", "_", str_replace(" ", "-", strtolower($location_name))), "lastmod"=>$lastmod, "changefreq"=>$changefreq, "priority"=>$priority));
		}
	}

}

/*
if(!file_exists(SITE_DOC_ROOT.$pageProperty)){
	$handle = fopen(SITE_DOC_ROOT.$pageProperty,'w');
	fwrite($handle,$contentProperty);
} else {
	@unlink(SITE_DOC_ROOT.$pageProperty);
	$handle = fopen(SITE_DOC_ROOT.$pageProperty,'w');
	fwrite($handle,$contentProperty);
}
fclose($handle);
*/
//array_push($map, array("loc"=>SITE_URL.$pageProperty, "lastmod"=>$lastmod, "changefreq"=>$changefreq, "priority"=>$priority));

/*
// for event pages
$pageEvents 	= "sitemapEvents.txt";
$contentEvents 	= SITE_URL."events\n";
//$contentEvents 	.= SITE_URL."holiday-events-view.php?evntcode=SAEVNT00000014\n";
$lastmod 		= date('Y-m-d');
$changefreq 	= "daily";
$priority 		= "1.0";
if(!file_exists(SITE_DOC_ROOT.$pageEvents)){
	$handle = fopen(SITE_DOC_ROOT.$pageEvents,'w');
	fwrite($handle,$contentEvents);
} else {
	@unlink(SITE_DOC_ROOT.$pageEvents);
	$handle = fopen(SITE_DOC_ROOT.$pageEvents,'w');
	fwrite($handle,$contentEvents);
}
fclose($handle);
array_push($map, array("loc"=>SITE_URL.$pageEvents, "lastmod"=>$lastmod, "changefreq"=>$changefreq, "priority"=>$priority));

// for travel guide pages
$pageTravelGuides 		= "sitemapTravelGuides.txt";
$contentTravelGuides 	= SITE_URL."travel-guides\n";
//$contentTravelGuides 	.= SITE_URL."south-africa/travel-guides/4\n";
$sqlTravel 	= "SELECT trvl_guid_id, trvl_guid_title FROM  " . TABLE_TRAVEL_GUIDES . " WHERE active='1' AND status='2' ";
$rsTravel 	= $dbObj->createRecordset($sqlTravel);
if($dbObj->getRecordCount($rsTravel) > 0){
	$arrTravel = $dbObj->fetchAssoc($rsTravel);
	for($j = 0; $j < count($arrTravel); $j++) {
		$trvl_guid_id 	=	$arrTravel[$j]['trvl_guid_id'];
		$trvl_guid_title =	$arrTravel[$j]['trvl_guid_title'];
		$contentTravelGuides 	.= SITE_URL."travel-guides/".replace_NonAlphaNumChars(strtolower($trvl_guid_title))."_".$trvl_guid_id."\n";
	}
}
$lastmod 		= date('Y-m-d');
$changefreq 	= "daily";
$priority 		= "1.0";
if(!file_exists(SITE_DOC_ROOT.$pageTravelGuides)){
	$handle = fopen(SITE_DOC_ROOT.$pageTravelGuides,'w');
	fwrite($handle,$contentTravelGuides);
} else {
	@unlink(SITE_DOC_ROOT.$pageTravelGuides);
	$handle = fopen(SITE_DOC_ROOT.$pageTravelGuides,'w');
	fwrite($handle,$contentTravelGuides);
}
fclose($handle);
array_push($map, array("loc"=>SITE_URL.$pageTravelGuides, "lastmod"=>$lastmod, "changefreq"=>$changefreq, "priority"=>$priority));
*/

// for static pages
//$pageStatic 	= "sitemapStatic.txt";

$lastmod 		= date('Y-m-d');
$changefreq 	= "daily";
$priority 		= "0.3";

/*
$contentStatic 	.= SITE_URL."about-us\n";
$contentStatic 	.= SITE_URL."contact-us\n";
$contentStatic 	.= SITE_URL."pages/How-to-book\n";
$contentStatic 	.= SITE_URL."pages/Why-book-with-us\n";
$contentStatic 	.= SITE_URL."pages/Pricing-Options\n";
$contentStatic 	.= SITE_URL."pages/Property-Manager\n";
$contentStatic 	.= SITE_URL."pages/Sitemap\n";
$contentStatic 	.= SITE_URL."show-terms\n";
$contentStatic 	.= SITE_URL."privacy-policy\n";
$contentStatic 	.= SITE_URL."help\n";
$contentStatic 	.= SITE_URL."testimonials\n";
$contentStatic 	.= SITE_URL."tell-your-friends\n";
$contentStatic 	.= SITE_URL."resources\n";
$contentStatic 	.= SITE_URL."vacation-rentals\n";
$contentStatic 	.= SITE_URL."searchform\n";
$contentStatic 	.= SITE_URL."map.vacation-rentals\n";
$contentStatic 	.= SITE_URL."vacation-rentals/featured\n";
$contentStatic 	.= SITE_URL."vacation-rentals/page_1/latedeal_1\n";
$contentStatic 	.= SITE_URL."advertise\n";
$contentStatic 	.= SITE_URL."owner-login\n";
*/

array_push($map, array("loc"=>SITE_URL."show-terms", "lastmod"=>$lastmod, "changefreq"=>$changefreq, "priority"=>$priority));
array_push($map, array("loc"=>SITE_URL."privacy-policy", "lastmod"=>$lastmod, "changefreq"=>$changefreq, "priority"=>$priority));
array_push($map, array("loc"=>SITE_URL."testimonials", "lastmod"=>$lastmod, "changefreq"=>$changefreq, "priority"=>$priority));
array_push($map, array("loc"=>SITE_URL."tell-your-friends", "lastmod"=>$lastmod, "changefreq"=>$changefreq, "priority"=>$priority));
array_push($map, array("loc"=>SITE_URL."resources", "lastmod"=>$lastmod, "changefreq"=>$changefreq, "priority"=>$priority));

//array_push($map, array("loc"=>SITE_URL."pages/How-to-book", "lastmod"=>$lastmod, "changefreq"=>$changefreq, "priority"=>$priority));
//array_push($map, array("loc"=>SITE_URL."pages/Why-book-with-us.html", "lastmod"=>$lastmod, "changefreq"=>$changefreq, "priority"=>$priority));
//array_push($map, array("loc"=>SITE_URL."pages/Pricing-Options.html", "lastmod"=>$lastmod, "changefreq"=>$changefreq, "priority"=>$priority));
//array_push($map, array("loc"=>SITE_URL."pages/Property-Manager.html", "lastmod"=>$lastmod, "changefreq"=>$changefreq, "priority"=>$priority));
//array_push($map, array("loc"=>SITE_URL."pages/Sitemap.html", "lastmod"=>$lastmod, "changefreq"=>$changefreq, "priority"=>$priority));
//array_push($map, array("loc"=>SITE_URL."searchform", "lastmod"=>$lastmod, "changefreq"=>$changefreq, "priority"=>$priority));
//array_push($map, array("loc"=>SITE_URL.$pageStatic, "lastmod"=>$lastmod, "changefreq"=>$changefreq, "priority"=>$priority));

/*
if(!file_exists(SITE_DOC_ROOT.$pageStatic)){
	$handle = fopen(SITE_DOC_ROOT.$pageStatic,'w');
	fwrite($handle,$contentStatic);
} else {
	@unlink(SITE_DOC_ROOT.$pageStatic);
	$handle = fopen(SITE_DOC_ROOT.$pageStatic,'w');
	fwrite($handle,$contentStatic);
}
fclose($handle);
*/



$sitemapObj->prepare();
$sitemapObj->siteUrl = "http://".$_SERVER['SERVER_NAME'];
$sitemapObj->siteDir = $_SERVER["DOCUMENT_ROOT"];
//$sitemapObj->proxy='proxy.isp.net'; // use if the proxy is enabled in your ISP , use NULL in your site
//$sitemapObj->proxy_port='3311'; // use if the proxy is enabled in your ISP , use NULL in your site
$sitemapObj->proxy = ''; // use if the proxy is enabled in your ISP , use NULL in your site
$sitemapObj->proxy_port = ''; // use if the proxy is enabled in your ISP , use NULL in your site
if(!$sitemapObj->addElements($map)) {
	die('error');
} else {
	echo "DONE!!";
}
?>
