<?php
require_once(SITE_CLASSES_PATH."class.Breadcrumb.php");
$nav = new breadcrumb();
if($_SERVER['REQUEST_URI'] !="") {
	$str_url = $_SERVER['REQUEST_URI'];
	//General section
	if(strpos($str_url, "home") == true) {
		$nav ->add("Home", $str_url, 0);
	} else if(strpos($str_url, "owner-home") == true){
		$nav ->add("Home", $str_url, 0);
	} else if(strpos($str_url, "property-search-results.php") == true){
		$nav ->add("Property Search", $str_url, 1);
	} else if(strpos($str_url, "property-map-search.php") == true){
		$nav ->add("Property Map Search", $str_url, 1);
	} else if(strpos($str_url, "tell-your-friends") == true){
		$nav ->add("Tell your friends", $str_url, 1);
	} else if(strpos($str_url, "resources") == true){
		$nav ->add("Resources", $str_url, 1);
	//Owner section
	} else if(strpos($str_url, "owner-property.php?sec") == true){
		$nav_title2 = $propertyObj->fun_getPropertyName($_GET['pid']);
		$nav ->add($nav_title2, $str_url, 2);
	} else if(strpos($str_url, "owner-advertise") == true){
		$nav ->add("Advertise your property", $str_url, 1);
	} else if(strpos($str_url, "owner-favourities") == true){
		$nav ->add("My favourites", $str_url, 1);
	} else if(strpos($str_url, "owner-my-properties") == true){
		$nav ->add("My Properties", $str_url, 1);
	} else if(strpos($str_url, "owner-profile-settings") == true){
		$nav ->add("My Profile and settings", $str_url, 1);
	} else if(strpos($str_url, "owner-terms") == true){
		$nav ->add("Term & Condition", $str_url, 1);
	} else if(strpos($str_url, "holiday-property-preview.php") == true){
		$propLocInfoArr = $propertyObj->fun_getPropertyLocInfoArr($property_id);
		$propBreadArr 		= array();
		if($propLocInfoArr['area_name'] !=""){
			array_push($propBreadArr, array('label' => $propLocInfoArr['area_name'], 'url' => "".SITE_URL."vacation-rentals/in.".str_replace(" ", "-", strtolower($propLocInfoArr['area_name']))));
		}
		if($propLocInfoArr['region_name'] !=""){
			array_push($propBreadArr, array('label' => $propLocInfoArr['region_name'], 'url' => "".SITE_URL."vacation-rentals/in.".str_replace(" ", "-", strtolower($propLocInfoArr['region_name']))));
		}
		if($propLocInfoArr['subregion_name'] !=""){
			array_push($propBreadArr, array('label' => $propLocInfoArr['subregion_name'], 'url' => "".SITE_URL."vacation-rentals/in.".str_replace(" ", "-", strtolower($propLocInfoArr['subregion_name']))));
		}
		if($propLocInfoArr['location_name'] !=""){
			array_push($propBreadArr, array('label' => $propLocInfoArr['location_name'], 'url' => "".SITE_URL."vacation-rentals/in.".str_replace(" ", "-", strtolower($propLocInfoArr['location_name']))));
		}
		for($bCrumbCounter = 0; $bCrumbCounter < count($propBreadArr); $bCrumbCounter++) {
			$nav->addParent($propBreadArr[$bCrumbCounter]['label'], $propBreadArr[$bCrumbCounter]['url'], ($bCrumbCounter+1));
		}
		$nav->add(ucfirst($propertyObj->fun_getPropertyName($property_id))." ref:".fill_zero_left($property_id, "0", (6-strlen($property_id))), $str_url, (count($propBreadArr)+1));
	} else if(strpos($str_url, "vacation-rentals/in.") == true){
		if($property_id) {
			$propLocInfoArr = $propertyObj->fun_getPropertyLocInfoArr($property_id);
			$propBreadArr 		= array();
			if($propLocInfoArr['area_name'] !=""){
				array_push($propBreadArr, array('label' => $propLocInfoArr['area_name'], 'url' => "".SITE_URL."vacation-rentals/in.".str_replace("/", "_", str_replace(" ", "-", strtolower($propLocInfoArr['area_name'])))));
			}
			if($propLocInfoArr['region_name'] !=""){
				array_push($propBreadArr, array('label' => $propLocInfoArr['region_name'], 'url' => "".SITE_URL."vacation-rentals/in.".str_replace("/", "_", str_replace(" ", "-", strtolower($propLocInfoArr['region_name'])))));
			}
			if($propLocInfoArr['subregion_name'] !=""){
				array_push($propBreadArr, array('label' => $propLocInfoArr['subregion_name'], 'url' => "".SITE_URL."vacation-rentals/in.".str_replace("/", "_", str_replace(" ", "-", strtolower($propLocInfoArr['subregion_name'])))));
			}
			if($propLocInfoArr['location_name'] !=""){
				array_push($propBreadArr, array('label' => $propLocInfoArr['location_name'], 'url' => "".SITE_URL."vacation-rentals/in.".str_replace("/", "_", str_replace(" ", "-", strtolower($propLocInfoArr['location_name'])))));
			}
			for($bCrumbCounter = 0; $bCrumbCounter < count($propBreadArr); $bCrumbCounter++) {
				$nav->addParent($propBreadArr[$bCrumbCounter]['label'], $propBreadArr[$bCrumbCounter]['url'], ($bCrumbCounter+1));
			}
			$nav->add(ucfirst($propertyObj->fun_getPropertyName($property_id))." ref:".fill_zero_left($property_id, "0", (6-strlen($property_id))), $str_url, (count($propBreadArr)+1));
		} else {
			$propBreadArr 		= array();
			array_push($propBreadArr, array('label' => "Accommodation search", 'url' => "".SITE_URL."accommodation"));
			if(isset($_REQUEST['destinations']) && $_REQUEST['destinations'] != "") {
				$destinations		= $_REQUEST['destinations'];
				$destinations		= str_replace("_", "/", str_replace("-", " ", $destinations));
//				array_push($propBreadArr, array('label' => ucwords($destinations), 'url' => "".SITE_URL."vacation-rentals/in.".str_replace("/", "_", str_replace(" ", "-", $destinations))));
				for($bCrumbCounter = 0; $bCrumbCounter < count($propBreadArr); $bCrumbCounter++) {
					$nav->addParent($propBreadArr[$bCrumbCounter]['label'], $propBreadArr[$bCrumbCounter]['url'], ($bCrumbCounter+1));
				}
				$nav->add(ucfirst($destinations), $str_url, (count($propBreadArr)+1));
			}
		}
	} else if(strpos($str_url, "vacation-rentals/") == true) {
		if(isset($_GET['fr_url']) && $_GET['fr_url'] != "") {
			$fr_url 			= $_GET['fr_url'];
	//		$fr_url			= str_replace("_", ",", str_replace("-", " ", $fr_url));
			$property_id	= $propertyObj->fun_getPropertyIdByFriendlyURL($fr_url);
			$propLocInfoArr = $propertyObj->fun_getPropertyLocInfoArr($property_id);
			$propBreadArr 		= array();
			if($propLocInfoArr['area_name'] !=""){
				array_push($propBreadArr, array('label' => $propLocInfoArr['area_name'], 'url' => "".SITE_URL."vacation-rentals/in.".str_replace("/", "_", str_replace(" ", "-", strtolower($propLocInfoArr['area_name'])))));
			}
			if($propLocInfoArr['region_name'] !=""){
				array_push($propBreadArr, array('label' => $propLocInfoArr['region_name'], 'url' => "".SITE_URL."vacation-rentals/in.".str_replace("/", "_", str_replace(" ", "-", strtolower($propLocInfoArr['region_name'])))));
			}
			if($propLocInfoArr['subregion_name'] !=""){
				array_push($propBreadArr, array('label' => $propLocInfoArr['subregion_name'], 'url' => "".SITE_URL."vacation-rentals/in.".str_replace("/", "_", str_replace(" ", "-", strtolower($propLocInfoArr['subregion_name'])))));
			}
			if($propLocInfoArr['location_name'] !=""){
				array_push($propBreadArr, array('label' => $propLocInfoArr['location_name'], 'url' => "".SITE_URL."vacation-rentals/in.".str_replace("/", "_", str_replace(" ", "-", strtolower($propLocInfoArr['location_name'])))));
			}
			for($bCrumbCounter = 0; $bCrumbCounter < count($propBreadArr); $bCrumbCounter++) {
				$nav->addParent($propBreadArr[$bCrumbCounter]['label'], $propBreadArr[$bCrumbCounter]['url'], ($bCrumbCounter+1));
			}
			$nav->add(ucfirst($propertyObj->fun_getPropertyName($property_id))." ref:".fill_zero_left($property_id, "0", (6-strlen($property_id))), $str_url, (count($propBreadArr)+1));
		} else {
			$nav ->add("Accommodation search", $str_url, 1);
		}
	} else if(strpos($str_url, "accommodation") == true){
		$nav ->add("Accommodation search", $str_url, 1);
	} else if(strpos($str_url, "property") == true){
		$nav ->add("Add a new property", $str_url, 1);
	} else if(strpos($str_url, "owner-enquiries") == true){
		$nav ->add("Enquiries", $str_url, 1);
	} else if(strpos($str_url, "owner-shopping-cart") == true){
		$nav ->add("My Basket", $str_url, 1);
	} else if(strpos($str_url, "owner-testimonials") == true){
		$nav ->add("Testimonials", $str_url, 1);
	} else if(strpos($str_url, "owner-about-us") == true){
		$nav ->add("About Us", $str_url, 1);
	} else if(strpos($str_url, "owner-privacy-policy") == true){
		$nav ->add("Privacy Policy", $str_url, 1);
	} else if(strpos($str_url, "owner-help") == true){
		$nav ->add("Help", $str_url, 1);
	} else if(strpos($str_url, "owner-faqs") == true){
		$nav ->add("FAQs", $str_url, 1);
	} else if(strpos($str_url, "events") == true){
	$nav ->add("What is on", $str_url, 1);
	} else if(strpos($str_url, "holiday-planning") == true){
	$nav ->add("holiday Planning", $str_url, 1);
	} else if(strpos($str_url, "checklist") == true){
	$nav ->add("checklist", $str_url, 1);
	} else if(strpos($str_url, "home-mod") == true){
	$nav ->add("home-mod", $str_url, 1);
	} else if(strpos($str_url, "owner-login") == true){
	$nav ->add("Owner-Login", $str_url, 1);
	} else if(strpos($str_url, "lettingadvice") == true){
	$nav ->add("Lettingadvice", $str_url, 1);
	} else if(strpos($str_url, "a-to-z-countries") == true){
	$nav ->add("a-to-z-countries", $str_url, 1);
	} else if(strpos($str_url, "show-sitemap") == true){
	$nav ->add("Sitemap", $str_url, 1);
	} else if(strpos($str_url, "company-description") == true){
	$nav ->add("Company Description", $str_url, 1);
	} else if(strpos($str_url, "carrier-oportunities") == true){
	$nav ->add("Carrier Oportunities", $str_url, 1);
	} else if(strpos($str_url, "advertising") == true){
	$nav ->add("Advertising", $str_url, 1);
	} else if(strpos($str_url, "legal-information") == true){
	$nav ->add("Legal Information", $str_url, 1);
	} else if(strpos($str_url, "media-center") == true){
	$nav ->add("Media Center", $str_url, 1);
	
	
	//Holidya section
	} else if(strpos($str_url, "advertise") == true){
		$nav ->add("Advertise your property", $str_url, 1);
	} else if(strpos($str_url, "travel-guides") == true){
		$nav ->add("Travel Guides", $str_url, 1);
	} else if(strpos($str_url, "holiday-events-view.php") == true){
		$nav ->add("Events", $str_url, 1);
	} else if(strpos($str_url, "contact-us") == true) {
		$nav ->add("Contact Us", $str_url, 1);
	} else if(strpos($str_url, "about-us") == true){
		$nav ->add("About Us", $str_url, 1);
	} else if(strpos($str_url, "privacy-policy") == true){
		$nav ->add("Privacy Policy", $str_url, 1);
	} else if(strpos($str_url, "help") == true){
		$nav ->add("Help", $str_url, 1);
	} else if(strpos($str_url, "terms") == true){
		$nav ->add("Terms & Conditions", $str_url, 1);
	} else if(strpos($str_url, "testimonials") == true){
		$nav ->add("Testimonials", $str_url, 1);
	} else {
		$nav ->add("Home", $str_url, 0);
	}
}

?>
<div id="BreadCrumbWrapper11">
    <div id="BreadCrumb11">
        <div id="BreadCrumb-Left11">
            <?php $nav ->output();?>
        </div>
    </div>
</div>