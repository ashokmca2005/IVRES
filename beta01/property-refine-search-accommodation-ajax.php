<?php	
	if($_SERVER["SERVER_NAME"] == "localhost") {
		require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/includes/application-top.php");
	} else {
		require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
	}
	require_once(SITE_CLASSES_PATH."class.Property.php");
	require_once(SITE_CLASSES_PATH."class.Location.php");

	if (!headers_sent()) {
	   header('Content-Type: text/html; charset=ISO-8859-1');
	}

	$dbObj = new DB();
	$dbObj->fun_db_connect();
	
	$propertyObj 	= new Property();
	$locationObj 	= new Location();
	if(isset($_POST['securityKey']) && $_POST['securityKey'] == md5("REFINESEARCH")) {
		// Read search fields from submitted form
		if(isset($_REQUEST['featured']) && $_REQUEST['featured'] != "") { $featured = form_text("featured"); $featured = stripslashes($featured); }
		if(isset($_REQUEST['txtcountryids']) && $_REQUEST['txtcountryids'] != "") { $txtcountryids = form_text("txtcountryids"); $txtcountryids = stripslashes($txtcountryids);}
		if(isset($_REQUEST['txtareaids']) && $_REQUEST['txtareaids'] != "") { $txtareaids = form_text("txtareaids"); $txtareaids = stripslashes($txtareaids); }
		if(isset($_REQUEST['txtregionids']) && $_REQUEST['txtregionids'] != "") { $txtregionids = form_text("txtregionids"); $txtregionids = stripslashes($txtregionids); }
		if(isset($_REQUEST['txtlocationids']) && $_REQUEST['txtlocationids'] != "") { $txtlocationids = form_text("txtlocationids"); $txtlocationids = stripslashes($txtlocationids); }

		if((isset($_REQUEST['txtgeneralids']) && $_REQUEST['txtgeneralids'] != "") || (isset($_COOKIE['cook_txtgeneralids']) && $_COOKIE['cook_txtgeneralids'] != "")) { $txtgeneralids = (form_text("txtgeneralids") != "")?form_text("txtgeneralids"):$_COOKIE['cook_txtgeneralids']; $txtgeneralids = stripslashes($txtgeneralids); }
		if((isset($_REQUEST['txtserviceids']) && $_REQUEST['txtserviceids'] != "") || (isset($_COOKIE['cook_txtserviceids']) && $_COOKIE['cook_txtserviceids'] != "")) { $txtserviceids = (form_text("txtserviceids") != "")?form_text("txtserviceids"):$_COOKIE['cook_txtserviceids']; $txtserviceids = stripslashes($txtserviceids); }
		if((isset($_REQUEST['txtlocationviewids']) && $_REQUEST['txtlocationviewids'] != "") || (isset($_COOKIE['cook_txtlocationviewids']) && $_COOKIE['cook_txtlocationviewids'] != "")) { $txtlocationviewids = (form_text("txtlocationviewids") != "")?form_text("txtlocationviewids"):$_COOKIE['cook_txtlocationviewids']; $txtlocationviewids = stripslashes($txtlocationviewids); }
		if((isset($_REQUEST['txtenterainmentids']) && $_REQUEST['txtenterainmentids'] != "") || (isset($_COOKIE['cook_txtenterainmentids']) && $_COOKIE['cook_txtenterainmentids'] != "")) { $txtenterainmentids = (form_text("txtenterainmentids") != "")?form_text("txtenterainmentids"):$_COOKIE['cook_txtenterainmentids']; $txtenterainmentids = stripslashes($txtenterainmentids); }
		if((isset($_REQUEST['txtheatingcoolingids']) && $_REQUEST['txtheatingcoolingids'] != "") || (isset($_COOKIE['cook_txtheatingcoolingids']) && $_COOKIE['cook_txtheatingcoolingids'] != "")) { $txtheatingcoolingids = (form_text("txtheatingcoolingids") != "")?form_text("txtheatingcoolingids"):$_COOKIE['cook_txtheatingcoolingids']; $txtheatingcoolingids = stripslashes($txtheatingcoolingids); }
		if((isset($_REQUEST['txtactivitynearbyids']) && $_REQUEST['txtactivitynearbyids'] != "") || (isset($_COOKIE['cook_txtactivitynearbyids']) && $_COOKIE['cook_txtactivitynearbyids'] != "")) { $txtactivitynearbyids = (form_text("txtactivitynearbyids") != "")?form_text("txtactivitynearbyids"):$_COOKIE['cook_txtactivitynearbyids']; $txtactivitynearbyids = stripslashes($txtactivitynearbyids); }
		if((isset($_REQUEST['txtoutsideids']) && $_REQUEST['txtoutsideids'] != "") || (isset($_COOKIE['cook_txtoutsideids']) && $_COOKIE['cook_txtoutsideids'] != "")) { $txtoutsideids = (form_text("txtoutsideids") != "")?form_text("txtoutsideids"):$_COOKIE['cook_txtoutsideids']; $txtoutsideids = stripslashes($txtoutsideids); }
		if((isset($_REQUEST['txtkitchenlinenids']) && $_REQUEST['txtkitchenlinenids'] != "") || (isset($_COOKIE['cook_txtkitchenlinenids']) && $_COOKIE['cook_txtkitchenlinenids'] != "")) { $txtkitchenlinenids = (form_text("txtkitchenlinenids") != "")?form_text("txtkitchenlinenids"):$_COOKIE['cook_txtkitchenlinenids']; $txtkitchenlinenids = stripslashes($txtkitchenlinenids); }
		if((isset($_REQUEST['txtholidaytypeids']) && $_REQUEST['txtholidaytypeids'] != "") || (isset($_COOKIE['cook_txtholidaytypeids']) && $_COOKIE['cook_txtholidaytypeids'] != "")) { $txtholidaytypeids = (form_text("txtholidaytypeids") != "")?form_text("txtholidaytypeids"):$_COOKIE['cook_txtholidaytypeids']; $txtholidaytypeids = stripslashes($txtholidaytypeids); }
		if((isset($_REQUEST['txtneedsleep']) && $_REQUEST['txtneedsleep'] != "") || (isset($_COOKIE['cook_txtneedsleep']) && $_COOKIE['cook_txtneedsleep'] != "")) { $txtneedsleep = (form_text("txtneedsleep") != "")?form_text("txtneedsleep"):$_COOKIE['cook_txtneedsleep']; $txtneedsleep = stripslashes($txtneedsleep); }
		if((isset($_REQUEST['txttotalbed']) && $_REQUEST['txttotalbed'] != "") || (isset($_COOKIE['cook_txttotalbed']) && $_COOKIE['cook_txttotalbed'] != "")) { $txttotalbed = (form_text("txttotalbed") != "")?form_text("txttotalbed"):$_COOKIE['cook_txttotalbed']; $txttotalbed = stripslashes($txttotalbed); }
		if((isset($_REQUEST['txtonlybed']) && $_REQUEST['txtonlybed'] != "") || (isset($_COOKIE['cook_txtonlybed']) && $_COOKIE['cook_txtonlybed'] != "")) { $txtonlybed = (form_text("txtonlybed") != "")?form_text("txtonlybed"):$_COOKIE['cook_txtonlybed']; $txtonlybed = stripslashes($txtonlybed); }
		if((isset($_REQUEST['txtpropertytypeids']) && $_REQUEST['txtpropertytypeids'] != "") || (isset($_COOKIE['cook_txtpropertytypeids']) && $_COOKIE['cook_txtpropertytypeids'] != "")) { $txtpropertytypeids = (form_text("txtpropertytypeids") != "")?form_text("txtpropertytypeids"):$_COOKIE['cook_txtpropertytypeids']; $txtpropertytypeids = stripslashes($txtpropertytypeids); }
		if((isset($_REQUEST['txtavailabilityids']) && $_REQUEST['txtavailabilityids'] != "") || (isset($_COOKIE['cook_txtavailabilityids']) && $_COOKIE['cook_txtavailabilityids'] != "")) { $txtavailabilityids = (form_text("txtavailabilityids") !="")?form_text("txtavailabilityids"):$_COOKIE['cook_txtavailabilityids']; $txtavailabilityids = stripslashes($txtavailabilityids); } else {$txtavailabilityids = 1;}
		if((isset($_REQUEST['latedeal']) && $_REQUEST['latedeal'] != "") || (isset($_COOKIE['cook_latedealId']) && $_COOKIE['cook_latedealId'] != "")) { $latedeal = (form_text("latedeal") !="")?form_text("latedeal"):$_COOKIE['cook_latedealId']; $latedeal = stripslashes($latedeal); } else {$latedeal = 0;}

		if(isset($txtavailabilityids) && $txtavailabilityids == "1") {
			// For jQuery date picker
			if((isset($_REQUEST['txtArrivaldate']) && $_REQUEST['txtArrivaldate'] != "") || (isset($_COOKIE['cook_txtarrivaldate']) && $_COOKIE['cook_txtarrivaldate'] != "")) { $txtArrivaldate = (form_text("txtArrivaldate") != "")?form_text("txtArrivaldate"):$_COOKIE['cook_txtarrivaldate']; $txtArrivaldate = stripslashes($txtArrivaldate);}
			if((isset($_REQUEST['txtDeparturedate']) && $_REQUEST['txtDeparturedate'] != "") || (isset($_COOKIE['cook_txtdeparturedate']) && $_COOKIE['cook_txtdeparturedate'] != "")) { $txtDeparturedate = (form_text("txtDeparturedate") != "")?form_text("txtDeparturedate"):$_COOKIE['cook_txtdeparturedate']; $txtDeparturedate = stripslashes($txtDeparturedate);}
	
			if($txtArrivaldate != "") {
				list($txtMonthFrom0, $txtDayFrom0, $txtYearFrom0) = split('[/.-]', $txtArrivaldate);
				$txtFromUnixTime 		= mktime(0, 0, 0, (int)$txtMonthFrom0, (int)$txtDayFrom0, (int)$txtYearFrom0);
				$txtFromDate 			= date('Y-m-d', $txtFromUnixTime);
				if(isset($txtArrivaldate) && $txtArrivaldate != "") { $search_query .= "&txtArrivaldate=" . html_escapeURL($txtArrivaldate); }
			}
			if($txtDeparturedate != "") {
				list($txtMonthTo0, $txtDayTo0, $txtYearTo0) = split('[/.-]', $txtDeparturedate);
				$txtToUnixTime	 		= mktime(0, 0, 0, (int)$txtMonthTo0, (int)$txtDayTo0, (int)$txtYearTo0);
				$txtToDate 				= date('Y-m-d', $txtToUnixTime);
				if(isset($txtDeparturedate) && $txtDeparturedate != "") { $search_query .= "&txtDeparturedate=" . html_escapeURL($txtDeparturedate); }
			}
		} else {
			$txtFromUnixTime 	= "";
			$txtToUnixTime 		= "";
		}

		$strQueryParameter	= "";

		$propertyTypeArr 			= $propertyObj->fun_getPropertyTypeArrayWithRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids, $txtFromUnixTime, $txtToUnixTime, str_replace("-", ",", $txtpropertytypeids), $txtneedsleep, $txtonlybed, $txttotalbed, str_replace("-", ",",$txtholidaytypeids), str_replace("-", ",", $txtkitchenlinenids), str_replace("-", ",", $txtoutsideids), str_replace("-", ",", $txtactivitynearbyids), str_replace("-", ",", $txtheatingcoolingids), str_replace("-", ",", $txtenterainmentids), str_replace("-", ",", $txtlocationviewids), str_replace("-", ",", $txtserviceids),  str_replace("-", ",", $txtgeneralids), $featured, $latedeal, $strQueryParameter);
		$propertyTotalBedArr	 	= $propertyObj->fun_getPropertyBedArrayRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids, $txtFromUnixTime, $txtToUnixTime, str_replace("-", ",", $txtpropertytypeids), $txtneedsleep, $txtonlybed, $txttotalbed, str_replace("-", ",",$txtholidaytypeids), str_replace("-", ",", $txtkitchenlinenids), str_replace("-", ",", $txtoutsideids), str_replace("-", ",", $txtactivitynearbyids), str_replace("-", ",", $txtheatingcoolingids), str_replace("-", ",", $txtenterainmentids), str_replace("-", ",", $txtlocationviewids), str_replace("-", ",", $txtserviceids),  str_replace("-", ",", $txtgeneralids), $featured, $latedeal, $strQueryParameter);
		$propertyComfortSleepArr 	= $propertyObj->fun_getPropertySleepArrayRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids, $txtFromUnixTime, $txtToUnixTime, str_replace("-", ",", $txtpropertytypeids), $txtneedsleep, $txtonlybed, $txttotalbed, str_replace("-", ",",$txtholidaytypeids), str_replace("-", ",", $txtkitchenlinenids), str_replace("-", ",", $txtoutsideids), str_replace("-", ",", $txtactivitynearbyids), str_replace("-", ",", $txtheatingcoolingids), str_replace("-", ",", $txtenterainmentids), str_replace("-", ",", $txtlocationviewids), str_replace("-", ",", $txtserviceids),  str_replace("-", ",", $txtgeneralids), $featured, $latedeal, $strQueryParameter);
		$propertyHolidayTypeArr	 	= $propertyObj->fun_getPropertyHolidayTypeArrayRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids, $txtFromUnixTime, $txtToUnixTime, str_replace("-", ",", $txtpropertytypeids), $txtneedsleep, $txtonlybed, $txttotalbed, str_replace("-", ",",$txtholidaytypeids), str_replace("-", ",", $txtkitchenlinenids), str_replace("-", ",", $txtoutsideids), str_replace("-", ",", $txtactivitynearbyids), str_replace("-", ",", $txtheatingcoolingids), str_replace("-", ",", $txtenterainmentids), str_replace("-", ",", $txtlocationviewids), str_replace("-", ",", $txtserviceids),  str_replace("-", ",", $txtgeneralids), $featured, $latedeal, $strQueryParameter);
		$propertyKitchenArr	 		= $propertyObj->fun_getPropertyKitchenArrayRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids, $txtFromUnixTime, $txtToUnixTime, str_replace("-", ",", $txtpropertytypeids), $txtneedsleep, $txtonlybed, $txttotalbed, str_replace("-", ",",$txtholidaytypeids), str_replace("-", ",", $txtkitchenlinenids), str_replace("-", ",", $txtoutsideids), str_replace("-", ",", $txtactivitynearbyids), str_replace("-", ",", $txtheatingcoolingids), str_replace("-", ",", $txtenterainmentids), str_replace("-", ",", $txtlocationviewids), str_replace("-", ",", $txtserviceids),  str_replace("-", ",", $txtgeneralids), $featured, $latedeal, $strQueryParameter);
		$propertyOutsideArr	 		= $propertyObj->fun_getPropertyOutsideArrayRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids, $txtFromUnixTime, $txtToUnixTime, str_replace("-", ",", $txtpropertytypeids), $txtneedsleep, $txtonlybed, $txttotalbed, str_replace("-", ",",$txtholidaytypeids), str_replace("-", ",", $txtkitchenlinenids), str_replace("-", ",", $txtoutsideids), str_replace("-", ",", $txtactivitynearbyids), str_replace("-", ",", $txtheatingcoolingids), str_replace("-", ",", $txtenterainmentids), str_replace("-", ",", $txtlocationviewids), str_replace("-", ",", $txtserviceids),  str_replace("-", ",", $txtgeneralids), $featured, $latedeal, $strQueryParameter);
		$propertyActivitiesNearbyArr= $propertyObj->fun_getPropertyActivitiesNearbyArrayRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids, $txtFromUnixTime, $txtToUnixTime, str_replace("-", ",", $txtpropertytypeids), $txtneedsleep, $txtonlybed, $txttotalbed, str_replace("-", ",",$txtholidaytypeids), str_replace("-", ",", $txtkitchenlinenids), str_replace("-", ",", $txtoutsideids), str_replace("-", ",", $txtactivitynearbyids), str_replace("-", ",", $txtheatingcoolingids), str_replace("-", ",", $txtenterainmentids), str_replace("-", ",", $txtlocationviewids), str_replace("-", ",", $txtserviceids),  str_replace("-", ",", $txtgeneralids), $featured, $latedeal, $strQueryParameter);
		$propertyHeatingCoolingArr 	= $propertyObj->fun_getPropertyHeatingCoolingArrayRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids, $txtFromUnixTime, $txtToUnixTime, str_replace("-", ",", $txtpropertytypeids), $txtneedsleep, $txtonlybed, $txtonlybed, $txttotalbed, str_replace("-", ",",$txtholidaytypeids), str_replace("-", ",", $txtkitchenlinenids), str_replace("-", ",", $txtoutsideids), str_replace("-", ",", $txtactivitynearbyids), str_replace("-", ",", $txtheatingcoolingids), str_replace("-", ",", $txtenterainmentids), str_replace("-", ",", $txtlocationviewids), str_replace("-", ",", $txtserviceids),  str_replace("-", ",", $txtgeneralids), $featured, $latedeal, $strQueryParameter);
		$propertyEntertainmentArr 	= $propertyObj->fun_getPropertyEntertainmentArrayRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids, $txtFromUnixTime, $txtToUnixTime, str_replace("-", ",", $txtpropertytypeids), $txtneedsleep, $txtonlybed, $txttotalbed, str_replace("-", ",",$txtholidaytypeids), str_replace("-", ",", $txtkitchenlinenids), str_replace("-", ",", $txtoutsideids), str_replace("-", ",", $txtactivitynearbyids), str_replace("-", ",", $txtheatingcoolingids), str_replace("-", ",", $txtenterainmentids), str_replace("-", ",", $txtlocationviewids), str_replace("-", ",", $txtserviceids),  str_replace("-", ",", $txtgeneralids), $featured, $latedeal, $strQueryParameter);
		$propertyLocationViewArr 	= $propertyObj->fun_getPropertyLocationViewArrayRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids, $txtFromUnixTime, $txtToUnixTime, str_replace("-", ",", $txtpropertytypeids), $txtneedsleep, $txtonlybed, $txttotalbed, str_replace("-", ",",$txtholidaytypeids), str_replace("-", ",", $txtkitchenlinenids), str_replace("-", ",", $txtoutsideids), str_replace("-", ",", $txtactivitynearbyids), str_replace("-", ",", $txtheatingcoolingids), str_replace("-", ",", $txtenterainmentids), str_replace("-", ",", $txtlocationviewids), str_replace("-", ",", $txtserviceids),  str_replace("-", ",", $txtgeneralids), $featured, $latedeal, $strQueryParameter);
		$propertyServicesArr 		= $propertyObj->fun_getPropertyServicesArrayRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids, $txtFromUnixTime, $txtToUnixTime, str_replace("-", ",", $txtpropertytypeids), $txtneedsleep, $txtonlybed, $txttotalbed, str_replace("-", ",",$txtholidaytypeids), str_replace("-", ",", $txtkitchenlinenids), str_replace("-", ",", $txtoutsideids), str_replace("-", ",", $txtactivitynearbyids), str_replace("-", ",", $txtheatingcoolingids), str_replace("-", ",", $txtenterainmentids), str_replace("-", ",", $txtlocationviewids), str_replace("-", ",", $txtserviceids),  str_replace("-", ",", $txtgeneralids), $featured, $latedeal, $strQueryParameter);
		$propertyGeneralArr 		= $propertyObj->fun_getPropertyGeneralArrayRefineByCriteria($txtcountryids, $txtareaids, $txtregionids, $txtlocationids, $txtFromUnixTime, $txtToUnixTime, str_replace("-", ",", $txtpropertytypeids), $txtneedsleep, $txtonlybed, $txttotalbed, str_replace("-", ",",$txtholidaytypeids), str_replace("-", ",", $txtkitchenlinenids), str_replace("-", ",", $txtoutsideids), str_replace("-", ",", $txtactivitynearbyids), str_replace("-", ",", $txtheatingcoolingids), str_replace("-", ",", $txtenterainmentids), str_replace("-", ",", $txtlocationviewids), str_replace("-", ",", $txtserviceids),  str_replace("-", ",", $txtgeneralids), $featured, $latedeal, $strQueryParameter);

		if(isset($txtpropertytypeids) && $txtpropertytypeids != "") {
			$txtpropertytypeidsArr 	= split("-", $txtpropertytypeids);
		}
		if(isset($txtholidaytypeids) && $txtholidaytypeids != "") {
			$txtholidaytypeidsArr 		= split("-", $txtholidaytypeids);
		}
		if(isset($txtkitchenlinenids) && $txtkitchenlinenids != "") {
			$txtkitchenlinenidsArr = split("-", $txtkitchenlinenids);
		}
		if(isset($txtoutsideids) && $txtoutsideids != "") {
			$txtoutsideidsArr = split("-", $txtoutsideids);
		}
		if(isset($txtactivitynearbyids) && $txtactivitynearbyids != "") {
			$txtactivitynearbyidsArr = split("-", $txtactivitynearbyids);
		}
		if(isset($txtheatingcoolingids) && $txtheatingcoolingids != "") {
			$txtheatingcoolingidsArr = split("-", $txtheatingcoolingids);
		}
		if(isset($txtenterainmentids) && $txtenterainmentids != "") {
			$txtenterainmentidsArr = split("-", $txtenterainmentids);
		}
		if(isset($txtlocationviewids) && $txtlocationviewids != "") {
			$txtlocationviewidsArr = split("-", $txtlocationviewids);
		}
		if(isset($txtserviceids) && $txtserviceids != "") {
			$txtserviceidsArr = split("-", $txtserviceids);
		}
		if(isset($txtgeneralids) && $txtgeneralids != "") {
			$txtgeneralidsArr = split("-", $txtgeneralids);
		}

	} else {
		$propertyTypeArr 			= $propertyObj->fun_getPropertyTypeArrayWithTotalProp();
		$propertyTotalBedArr	 	= $propertyObj->fun_getPropertyBedArrayWithTotalProp();
		$propertyComfortSleepArr 	= $propertyObj->fun_getPropertySleepArrayWithTotalProp();
		$propertyHolidayTypeArr	 	= $propertyObj->fun_getPropertyHolidayTypeWithTotalProp();
		$propertyKitchenArr	 		= $propertyObj->fun_getPropertyKitchenArrayWithTotalProp();
		$propertyOutsideArr	 		= $propertyObj->fun_getPropertyOutsideArrayWithTotalProp();
		$propertyActivitiesNearbyArr= $propertyObj->fun_getPropertyActivitiesNearbyArrayWithTotalProp();
		$propertyHeatingCoolingArr 	= $propertyObj->fun_getPropertyHeatingCoolingArrayWithTotalProp();
		$propertyEntertainmentArr 	= $propertyObj->fun_getPropertyEntertainmentArrayWithTotalProp();
		$propertyLocationViewArr 	= $propertyObj->fun_getPropertyLocationViewArrayWithTotalProp();
		$propertyServicesArr 		= $propertyObj->fun_getPropertyServicesArrayWithTotalProp();
		$propertyGeneralArr 		= $propertyObj->fun_getPropertyGeneralArrayWithTotalProp();
	} 
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" id="RSAccomShwId" style="display:block; padding:0px; margin:0px;" class="font12">
    <tr>
        <td valign="middle" class="pad-btm2">
            <div id="RSPropTypeDivId" style="display:block;">
                <div id="RSPropTypeDivShortId" style="display:<?php if(isset($_COOKIE['showHideRSPropTypeDivShortId']) && $_COOKIE['showHideRSPropTypeDivShortId']=="none" && $_COOKIE['showHideRSPropTypeDivFullId']=="block"){echo "none";} else {echo "block";}?>;">
                    <div style="background-color:#efefef; height:25px; vertical-align:middle; cursor:pointer;" onclick="SetCookie('showHideRSPropTypeDivFullId', 'block');SetCookie('showHideRSPropTypeDivShortId', 'none');showHideSection('RSPropTypeDivShortId');showHideSection('RSPropTypeDivFullId');" class="refine-wrap-first">
                        <span class="FloatLft pad-lft10 pad-top5" style="color:#009bd4; font-weight:bold;"><?php echo tranText('property_type'); ?></span>
                        <span class="FloatRgt pad-rgt10 pad-top10"><img src="<?php echo SITE_IMAGES;?>up-icon.gif" /></span>
                    </div>
                </div>
                <div id="RSPropTypeDivFullId" style="display:<?php if(isset($_COOKIE['showHideRSPropTypeDivFullId']) && $_COOKIE['showHideRSPropTypeDivFullId']=="block"){echo "block";} else {echo "none";}?>;">
                    <div style="background-color:#009bd4; height:25px; vertical-align:middle; cursor:pointer;" onclick="SetCookie('showHideRSPropTypeDivShortId', 'block');SetCookie('showHideRSPropTypeDivFullId', 'none');showHideSection('RSPropTypeDivFullId');showHideSection('RSPropTypeDivShortId');" class="refine-wrap-first">
                        <span class="FloatLft pad-lft10 pad-top5" style="color:#ffffff; font-weight:bold;"><?php echo tranText('property_type'); ?></span>
                        <span class="FloatRgt pad-rgt10 pad-top10"><img src="<?php echo SITE_IMAGES;?>down-icon.gif" /></span>
                    </div>
                    <?php
                    for($typeCounter2 = 0; $typeCounter2 < count($propertyTypeArr); $typeCounter2++) {
                        $typeCounterDisplay2 = (is_array($txtpropertytypeidsArr) && in_array($propertyTypeArr[$typeCounter2]['property_type_id'], $txtpropertytypeidsArr))?"none":"block";
                        echo "<div id=\"RSPropTypeDivFullItemId".$typeCounter2."\" style=\"display:".$typeCounterDisplay2."; padding:5px 10px 5px 10px;\"><a href=\"javascript:showHideSection('RSPropTypeDivShortItemId".$typeCounter2."');showHideSection('RSPropTypeDivFullItemId".$typeCounter2."');addNonMutualAccomTxt('RSPropTypeDivId', 'RSPropTypeDivFullItemId".$typeCounter2."', '".ucfirst($propertyTypeArr[$typeCounter2]['property_type_name'])."', 'txtpropertytypeids','".$propertyTypeArr[$typeCounter2]['property_type_id']."');Post.Send(document.getElementById('frmRefineSearch'));refineaccommodation();void(0);\" onMouseover=\"return hidestatus()\" style=\"text-decoration:none;\"><strong>(+)</strong>&nbsp;<span class=\"blackText\">".ucfirst($propertyTypeArr[$typeCounter2]['property_type_name'])."</span></a></div>";
                    }
                    ?>
                </div>
            </div>                                            
        </td>
    </tr>
    <?php
    /*
    if(count($propertyTotalBedArr) > 0 && $txttotalbed == "" &&  $txtonlybed == "") {
    ?>
    <tr>
        <td>
            <div id="RSBedRoomDivId" style="display:block;">
                <div id="RSBedRoomDivShortId" style="display:<?php if($txttotalbed != "") {echo "none";} else if(isset($_COOKIE['showHideRSBedRoomDivShortId']) && $_COOKIE['showHideRSBedRoomDivShortId']=="none" && $txttotalbed == ""){echo "none";} else {echo "block";}?>;">
                    <div style=" background-color:#ccffff; height:21px; width:188px; vertical-align:middle;">
                        <span class="FloatLft font12-darkgrey pad-lft5"><?php echo tranText('bedrooms'); ?></span>
                        <span class="FloatRgt pad-rgt10"><img src="<?php echo SITE_IMAGES;?>maximize-icon.gif" alt="Expand" onclick="SetCookie('showHideRSBedRoomDivFullId', 'block');SetCookie('showHideRSBedRoomDivShortId', 'none');showHideSection('RSBedRoomDivShortId');showHideSection('RSBedRoomDivFullId');" class="cursor" width="15" height="15" /></span>
                    </div>
                </div>
                <div id="RSBedRoomDivFullId" style="display:<?php if($txttotalbed != "") {echo "none";} else if(isset($_COOKIE['showHideRSBedRoomDivFullId']) && $_COOKIE['showHideRSBedRoomDivFullId']=="block" && $txttotalbed == ""){echo "block";} else {echo "none";}?>;">
                    <div style="background-color:#ccffff; height:21px; width:188px; vertical-align:middle;">
                        <span class="FloatLft font12-darkgrey pad-lft5"><?php echo tranText('bedrooms'); ?></span>
                        <span class="FloatRgt pad-rgt10"><img src="<?php echo SITE_IMAGES;?>minimize-icon.gif" alt="Expand" onclick="SetCookie('showHideRSBedRoomDivShortId', 'block');SetCookie('showHideRSBedRoomDivFullId', 'none');showHideSection('RSBedRoomDivFullId');showHideSection('RSBedRoomDivShortId');" class="cursor" width="15" height="15" /></span>
                    </div>
                    <?php
                    for($totalBedCounter2 = 0; $totalBedCounter2 < count($propertyTotalBedArr); $totalBedCounter2++) {
                        echo "<div id=\"RSBedRoomDivFullItemId".$totalBedCounter2."\" style=\"display:block;\"><a href=\"javascript:showHideSection('RSBedRoomDivId');addMutualAccomTxt('RSBedRoomDivId', 'Beds ".(int)($totalBedCounter2+1)." or more', 'txttotalbed','".(int)($totalBedCounter2+1)."');Post.Send(document.getElementById('frmRefineSearch'));refineaccommodation();void(0);\" onMouseover=\"return hidestatus()\"  style=\"text-decoration:none;\"><strong>(+)</strong>&nbsp;<span class=\"blackText\">".$propertyTotalBedArr[$totalBedCounter2]['total_bed_text']."</span></a></div>";
                    }
                    ?>
                </div>
            </div>                                            
        </td>
    </tr>
    <?php
    }
    */
    ?>
    <?php
    if(count($propertyComfortSleepArr) > 0 && $txtneedsleep == "") {
    ?>
    <tr>
        <td valign="middle" class="pad-btm2">
            <div id="RSNeedSleepDivId" style="display:block;">
                <div id="RSNeedSleepDivShortId" style="display:<?php if($txtneedsleep != "") {echo "none";} else if(isset($_COOKIE['showHideRSNeedSleepDivShortId']) && $_COOKIE['showHideRSNeedSleepDivShortId']=="none" && $txtneedsleep == ""){echo "none";} else {echo "block";}?>;">
                    <div style="background-color:#efefef; height:25px; vertical-align:middle; cursor:pointer;" onclick="SetCookie('showHideRSNeedSleepDivFullId', 'block');SetCookie('showHideRSNeedSleepDivShortId', 'none');showHideSection('RSNeedSleepDivShortId');showHideSection('RSNeedSleepDivFullId');">
                        <span class="FloatLft pad-lft10 pad-top5" style="color:#009bd4; font-weight:bold;"><?php echo tranText('sleeps'); ?></span>
                        <span class="FloatRgt pad-rgt10 pad-top10"><img src="<?php echo SITE_IMAGES;?>up-icon.gif" /></span>
                    </div>
                </div>
                <div id="RSNeedSleepDivFullId" style="display:<?php if($txtneedsleep != "") {echo "none";} else if(isset($_COOKIE['showHideRSNeedSleepDivFullId']) && $_COOKIE['showHideRSNeedSleepDivFullId']=="block" && $txtneedsleep == ""){echo "block";} else {echo "none";}?>;">
                    <div style="background-color:#009bd4; height:25px; vertical-align:middle; cursor:pointer;" onclick="SetCookie('showHideRSNeedSleepDivShortId', 'block');SetCookie('showHideRSNeedSleepDivFullId', 'none');showHideSection('RSNeedSleepDivFullId');showHideSection('RSNeedSleepDivShortId');">
                        <span class="FloatLft pad-lft10 pad-top5" style="color:#ffffff; font-weight:bold;"><?php echo tranText('sleeps'); ?></span>
                        <span class="FloatRgt pad-rgt10 pad-top10"><img src="<?php echo SITE_IMAGES;?>down-icon.gif" /></span>
                    </div>
                    <?php
                    for($sleepCounter2 = 0; $sleepCounter2 < count($propertyComfortSleepArr); $sleepCounter2++) {
                        echo "<div id=\"RSNeedSleepDivFullItemId".$sleepCounter2."\" style=\"display:block; padding:5px 10px 5px 10px;\"><a href=\"javascript:showHideSection('RSNeedSleepDivId');addMutualAccomTxt('RSNeedSleepDivId', 'Sleeps ".(int)($sleepCounter2+1)." or more', 'txtneedsleep','".(int)($sleepCounter2+1)."');Post.Send(document.getElementById('frmRefineSearch'));refineaccommodation();void(0);\" onMouseover=\"return hidestatus()\"  style=\"text-decoration:none;\"><strong>(+)</strong>&nbsp;<span class=\"blackText\">".$propertyComfortSleepArr[$sleepCounter2]['comfort_bed_text']."</span></a></div>";
                    }
                    ?>
                </div>
            </div>                                            
        </td>
    </tr>
    <?php
    }
    ?>
    <?php
    /*
    if(count($propertyHolidayTypeArr) > 0) {
    ?>
    <tr>
        <td>
            <div id="RSHolidayTypeDivId" style="display:block;">
                <div id="RSHolidayTypeDivShortId" style="display:<?php if(isset($_COOKIE['showHideRSHolidayTypeDivShortId']) && $_COOKIE['showHideRSHolidayTypeDivShortId']=="none" && $_COOKIE['showHideRSHolidayTypeDivFullId']=="block"){echo "none";} else {echo "block";}?>;">
                    <div style="background-color:#ccffff; height:21px; width:188px; vertical-align:middle;">
                        <span class="FloatLft font12-darkgrey pad-lft5"><?php echo tranText('holiday_type'); ?></span>
                        <span class="FloatRgt pad-rgt10"><img src="<?php echo SITE_IMAGES;?>maximize-icon.gif" alt="Expand" onclick="SetCookie('showHideRSHolidayTypeDivFullId', 'block');SetCookie('showHideRSHolidayTypeDivShortId', 'none');showHideSection('RSHolidayTypeDivShortId');showHideSection('RSHolidayTypeDivFullId');" class="cursor" width="15" height="15" /></span>
                    </div>
                </div>
                <div id="RSHolidayTypeDivFullId" style="display:<?php if(isset($_COOKIE['showHideRSHolidayTypeDivFullId']) && $_COOKIE['showHideRSHolidayTypeDivFullId']=="block"){echo "block";} else {echo "none";}?>;">
                    <div style="background-color:#ccffff; height:21px; width:188px; vertical-align:middle;">
                        <span class="FloatLft font12-darkgrey pad-lft5"><?php echo tranText('holiday_type'); ?></span>
                        <span class="FloatRgt pad-rgt10"><img src="<?php echo SITE_IMAGES;?>minimize-icon.gif" alt="Expand" onclick="SetCookie('showHideRSHolidayTypeDivShortId', 'block');SetCookie('showHideRSHolidayTypeDivFullId', 'none');showHideSection('RSHolidayTypeDivFullId');showHideSection('RSHolidayTypeDivShortId');" class="cursor" width="15" height="15" /></span>
                    </div>
                    <?php
                    for($HolidayTypeCounter = 0; $HolidayTypeCounter < count($propertyHolidayTypeArr); $HolidayTypeCounter++) {
                        $property_holidaytype_name 	= ucfirst($propertyHolidayTypeArr[$HolidayTypeCounter]['property_holidaytype_name']);
                        $facilityCounterDisplay2 = (is_array($txtholidaytypeidsArr) && in_array($propertyHolidayTypeArr[$HolidayTypeCounter]['property_holidaytype_id'], $txtholidaytypeidsArr))?"none":"block";
                        echo "<div id=\"RSHolidayTypeDivFullItemId".$HolidayTypeCounter."\" style=\"display:".$facilityCounterDisplay2.";\"><a href=\"javascript:showHideSection('RSHolidayTypeDivShortItemId".$HolidayTypeCounter."');showHideSection('RSHolidayTypeDivFullItemId".$HolidayTypeCounter."');addNonMutualAccomTxt('RSHolidayTypeDivId', 'RSHolidayTypeDivFullItemId".$HolidayTypeCounter."', '".$property_holidaytype_name."', 'txtholidaytypeids','".$propertyHolidayTypeArr[$HolidayTypeCounter]['property_holidaytype_id']."');Post.Send(document.getElementById('frmRefineSearch'));refineaccommodation();void(0);\" onMouseover=\"return hidestatus()\"  style=\"text-decoration:none;\"><strong>(+)</strong>&nbsp;<span class=\"blackText\">".$property_holidaytype_name."</span></a></div>";
                    }
                    ?>
                </div>
            </div>                                            
        </td>
    </tr>
    <?php
    }
    */
    ?>
    <?php
    if(count($propertyKitchenArr) > 0) {
    ?>
    <tr>
        <td valign="middle" class="pad-btm2">
            <div id="RSKitchenDivId" style="display:block;">
                <div id="RSKitchenDivShortId" style="display:<?php if(isset($_COOKIE['showHideRSKitchenDivShortId']) && $_COOKIE['showHideRSKitchenDivShortId']=="none" && $_COOKIE['showHideRSKitchenDivFullId']=="block"){echo "none";} else {echo "block";}?>;">
                    <div style="background-color:#efefef; height:25px; vertical-align:middle; cursor:pointer;" onclick="SetCookie('showHideRSKitchenDivFullId', 'block');SetCookie('showHideRSKitchenDivShortId', 'none');showHideSection('RSKitchenDivShortId');showHideSection('RSKitchenDivFullId');">
                        <span class="FloatLft pad-lft10 pad-top5" style="color:#009bd4; font-weight:bold;"><?php echo tranText('kitchen_linen'); ?></span>
                        <span class="FloatRgt pad-rgt10 pad-top10"><img src="<?php echo SITE_IMAGES;?>up-icon.gif" /></span>
                    </div>
                </div>
                <div id="RSKitchenDivFullId" style="display:<?php if(isset($_COOKIE['showHideRSKitchenDivFullId']) && $_COOKIE['showHideRSKitchenDivFullId']=="block"){echo "block";} else {echo "none";}?>;">
                    <div style="background-color:#009bd4; height:25px; vertical-align:middle; cursor:pointer;" onclick="SetCookie('showHideRSKitchenDivShortId', 'block');SetCookie('showHideRSKitchenDivFullId', 'none');showHideSection('RSKitchenDivFullId');showHideSection('RSKitchenDivShortId');">
                        <span class="FloatLft pad-lft10 pad-top5" style="color:#ffffff; font-weight:bold;"><?php echo tranText('kitchen_linen'); ?></span>
                        <span class="FloatRgt pad-rgt10 pad-top10"><img src="<?php echo SITE_IMAGES;?>down-icon.gif" /></span>
                    </div>
                    <?php
                    for($KitchenCounter = 0; $KitchenCounter < count($propertyKitchenArr); $KitchenCounter++) {
                        $property_kitchen_name 	= ucfirst($propertyKitchenArr[$KitchenCounter]['property_kitchen_name']);
                        $kitchenCounterDisplay2 = (is_array($txtkitchenlinenidsArr) && in_array($propertyKitchenArr[$KitchenCounter]['property_kitchen_id'], $txtkitchenlinenidsArr))?"none":"block";
                        echo "<div id=\"RSKitchenDivFullItemId".$KitchenCounter."\" style=\"display:".$kitchenCounterDisplay2."; padding:5px 10px 5px 10px;\"><a href=\"javascript:showHideSection('RSKitchenDivFullItemId".$KitchenCounter."');showHideSection('RSKitchenDivFullItemId".$KitchenCounter."');addNonMutualAccomTxt('RSKitchenDivId', 'RSKitchenDivFullItemId".$KitchenCounter."', '".$property_kitchen_name."', 'txtkitchenlinenids','".$propertyKitchenArr[$KitchenCounter]['property_kitchen_id']."');Post.Send(document.getElementById('frmRefineSearch'));refineaccommodation();void(0);\" onMouseover=\"return hidestatus()\"  style=\"text-decoration:none;\"><strong>(+)</strong>&nbsp;<span class=\"blackText\">".$property_kitchen_name."</span></a></div>";
                    } 
                    ?>
                </div>
            </div>                                            
        </td>
    </tr>
    <?php
    }
    ?>
    <?php
    if(count($propertyOutsideArr) > 0) {
    ?>
    <tr>
        <td valign="middle" class="pad-btm2">
            <div id="RSOutsideDivId" style="display:block;">
                <div id="RSOutsideDivShortId" style="display:<?php if(isset($_COOKIE['showHideRSOutsideDivShortId']) && $_COOKIE['showHideRSOutsideDivShortId']=="none" && $_COOKIE['showHideRSOutsideDivFullId']=="block"){echo "none";} else {echo "block";}?>;">
                    <div style="background-color:#efefef; height:25px; vertical-align:middle; cursor:pointer;" onclick="SetCookie('showHideRSOutsideDivFullId', 'block');SetCookie('showHideRSOutsideDivShortId', 'none');showHideSection('RSOutsideDivShortId');showHideSection('RSOutsideDivFullId');">
                        <span class="FloatLft pad-lft10 pad-top5" style="color:#009bd4; font-weight:bold;"><?php echo tranText('outside'); ?></span>
                        <span class="FloatRgt pad-rgt10 pad-top10"><img src="<?php echo SITE_IMAGES;?>up-icon.gif" /></span>
                    </div>
                </div>
                <div id="RSOutsideDivFullId" style="display:<?php if(isset($_COOKIE['showHideRSOutsideDivFullId']) && $_COOKIE['showHideRSOutsideDivFullId']=="block"){echo "block";} else {echo "none";}?>;">
                    <div style="background-color:#009bd4; height:25px; vertical-align:middle; cursor:pointer;" onclick="SetCookie('showHideRSOutsideDivShortId', 'block');SetCookie('showHideRSOutsideDivFullId', 'none');showHideSection('RSOutsideDivFullId');showHideSection('RSOutsideDivShortId');">
                        <span class="FloatLft pad-lft10 pad-top5" style="color:#ffffff; font-weight:bold;"><?php echo tranText('outside'); ?></span>
                        <span class="FloatRgt pad-rgt10 pad-top10"><img src="<?php echo SITE_IMAGES;?>down-icon.gif" /></span>
                    </div>
                    <?php
                    for($OutsideCounter = 0; $OutsideCounter < count($propertyOutsideArr); $OutsideCounter++) {
                        $property_outside_name 	= ucfirst($propertyOutsideArr[$OutsideCounter]['property_outside_name']);
                        $OutsideCounterDisplay2 = (is_array($txtoutsideidsArr) && in_array($propertyOutsideArr[$OutsideCounter]['property_outside_id'], $txtoutsideidsArr))?"none":"block";
                        echo "<div id=\"RSOutsideDivFullItemId".$OutsideCounter."\" style=\"display:".$OutsideCounterDisplay2."; padding:5px 10px 5px 10px;\"><a href=\"javascript:showHideSection('RSOutsideDivFullItemId".$OutsideCounter."');showHideSection('RSOutsideDivFullItemId".$OutsideCounter."');addNonMutualAccomTxt('RSOutsideDivId', 'RSOutsideDivFullItemId".$OutsideCounter."', '".$property_outside_name."', 'txtoutsideids','".$propertyOutsideArr[$OutsideCounter]['property_outside_id']."');Post.Send(document.getElementById('frmRefineSearch'));refineaccommodation();void(0);\" onMouseover=\"return hidestatus()\"  style=\"text-decoration:none;\"><strong>(+)</strong>&nbsp;<span class=\"blackText\">".$property_outside_name."</span></a></div>";
                    } 
                    ?>
                </div>
            </div>                                            
        </td>
    </tr>
    <?php
    }
    ?>
    <?php
    if(count($propertyActivitiesNearbyArr) > 0) {
    ?>
    <tr>
        <td valign="middle" class="pad-btm2">
            <div id="RSActivitiesNearbyDivId" style="display:block;">
                <div id="RSActivitiesNearbyDivShortId" style="display:<?php if(isset($_COOKIE['showHideRSActivitiesNearbyDivShortId']) && $_COOKIE['showHideRSActivitiesNearbyDivShortId']=="none" && $_COOKIE['showHideRSActivitiesNearbyDivFullId']=="block"){echo "none";} else {echo "block";}?>;">
                    <div style="background-color:#efefef; height:25px; vertical-align:middle; cursor:pointer;" onclick="SetCookie('showHideRSActivitiesNearbyDivFullId', 'block');SetCookie('showHideRSActivitiesNearbyDivShortId', 'none');showHideSection('RSActivitiesNearbyDivShortId');showHideSection('RSActivitiesNearbyDivFullId');">
                        <span class="FloatLft pad-lft10 pad-top5" style="color:#009bd4; font-weight:bold;"><?php echo tranText('activities_nearby'); ?></span>
                        <span class="FloatRgt pad-rgt10 pad-top10"><img src="<?php echo SITE_IMAGES;?>up-icon.gif" /></span>
                    </div>
                </div>
                <div id="RSActivitiesNearbyDivFullId" style="display:<?php if(isset($_COOKIE['showHideRSActivitiesNearbyDivFullId']) && $_COOKIE['showHideRSActivitiesNearbyDivFullId']=="block"){echo "block";} else {echo "none";}?>;">
                    <div style="background-color:#009bd4; height:25px; vertical-align:middle; cursor:pointer;" onclick="SetCookie('showHideRSActivitiesNearbyDivShortId', 'block');SetCookie('showHideRSActivitiesNearbyDivFullId', 'none');showHideSection('RSActivitiesNearbyDivFullId');showHideSection('RSActivitiesNearbyDivShortId');">
                        <span class="FloatLft pad-lft10 pad-top5" style="color:#ffffff; font-weight:bold;"><?php echo tranText('activities_nearby'); ?></span>
                        <span class="FloatRgt pad-rgt10 pad-top10"><img src="<?php echo SITE_IMAGES;?>down-icon.gif" /></span>
                    </div>
                    <?php
                    for($ActivitiesNearbyCounter = 0; $ActivitiesNearbyCounter < count($propertyActivitiesNearbyArr); $ActivitiesNearbyCounter++) {
                        $property_activitiesnearby_name 	= ucfirst($propertyActivitiesNearbyArr[$ActivitiesNearbyCounter]['property_activitiesnearby_name']);
                        $ActivitiesNearbyCounterDisplay2 = (is_array($txtactivitynearbyidsArr) && in_array($propertyActivitiesNearbyArr[$ActivitiesNearbyCounter]['property_activitiesnearby_id'], $txtactivitynearbyidsArr))?"none":"block";
                        echo "<div id=\"RSActivitiesNearbyDivFullItemId".$ActivitiesNearbyCounter."\" style=\"display:".$ActivitiesNearbyCounterDisplay2."; padding:5px 10px 5px 10px;\"><a href=\"javascript:showHideSection('RSKitchenDivFullItemId".$ActivitiesNearbyCounter."');showHideSection('RSActivitiesNearbyDivFullItemId".$ActivitiesNearbyCounter."');addNonMutualAccomTxt('RSActivitiesNearbyDivId', 'RSActivitiesNearbyDivFullItemId".$ActivitiesNearbyCounter."', '".$property_activitiesnearby_name."', 'txtactivitynearbyids','".$propertyActivitiesNearbyArr[$ActivitiesNearbyCounter]['property_activitiesnearby_id']."');Post.Send(document.getElementById('frmRefineSearch'));refineaccommodation();void(0);\" onMouseover=\"return hidestatus()\"  style=\"text-decoration:none;\"><strong>(+)</strong>&nbsp;<span class=\"blackText\">".$property_activitiesnearby_name."</span></a></div>";
                    } 
                    ?>
                </div>
            </div>                                            
        </td>
    </tr>
    <?php
    }
    ?>
    <?php
    if(count($propertyEntertainmentArr) > 0) {
    ?>
    <tr>
        <td valign="middle" class="pad-btm2">
            <div id="RSEntertainmentDivId" style="display:block;">
                <div id="RSEntertainmentDivShortId" style="display:<?php if(isset($_COOKIE['showHideRSEntertainmentDivShortId']) && $_COOKIE['showHideRSEntertainmentDivShortId']=="none" && $_COOKIE['showHideRSEntertainmentDivFullId']=="block"){echo "none";} else {echo "block";}?>;">
                    <div style="background-color:#efefef; height:25px; vertical-align:middle; cursor:pointer;" onclick="SetCookie('showHideRSEntertainmentDivFullId', 'block');SetCookie('showHideRSEntertainmentDivShortId', 'none');showHideSection('RSEntertainmentDivShortId');showHideSection('RSEntertainmentDivFullId');">
                        <span class="FloatLft pad-lft10 pad-top5" style="color:#009bd4; font-weight:bold;"><?php echo tranText('entertainment'); ?></span>
                        <span class="FloatRgt pad-rgt10 pad-top10"><img src="<?php echo SITE_IMAGES;?>up-icon.gif" /></span>
                    </div>
                </div>
                <div id="RSEntertainmentDivFullId" style="display:<?php if(isset($_COOKIE['showHideRSEntertainmentDivFullId']) && $_COOKIE['showHideRSEntertainmentDivFullId']=="block"){echo "block";} else {echo "none";}?>;">
                    <div style="background-color:#009bd4; height:25px; vertical-align:middle; cursor:pointer;" onclick="SetCookie('showHideRSEntertainmentDivShortId', 'block');SetCookie('showHideRSEntertainmentDivFullId', 'none');showHideSection('RSEntertainmentDivFullId');showHideSection('RSEntertainmentDivShortId');">
                        <span class="FloatLft pad-lft10 pad-top5" style="color:#ffffff; font-weight:bold;"><?php echo tranText('entertainment'); ?></span>
                        <span class="FloatRgt pad-rgt10 pad-top10"><img src="<?php echo SITE_IMAGES;?>down-icon.gif" /></span>
                    </div>
                    <?php
                    for($EntertainmentCounter = 0; $EntertainmentCounter < count($propertyEntertainmentArr); $EntertainmentCounter++) {
                        $property_entertainment_name 	= ucfirst($propertyEntertainmentArr[$EntertainmentCounter]['property_entertainment_name']);
                        $EntertainmentCounterDisplay2 = (is_array($txtenterainmentidsArr) && in_array($propertyEntertainmentArr[$EntertainmentCounter]['property_entertainment_id'], $txtenterainmentidsArr))?"none":"block";
                        echo "<div id=\"RSEntertainmentDivFullItemId".$EntertainmentCounter."\" style=\"display:".$EntertainmentCounterDisplay2."; padding:5px 10px 5px 10px;\"><a href=\"javascript:showHideSection('RSKitchenDivFullItemId".$EntertainmentCounter."');showHideSection('RSEntertainmentDivFullItemId".$EntertainmentCounter."');addNonMutualAccomTxt('RSEntertainmentDivId', 'RSEntertainmentDivFullItemId".$EntertainmentCounter."', '".$property_entertainment_name."', 'txtenterainmentids','".$propertyEntertainmentArr[$EntertainmentCounter]['property_entertainment_id']."');Post.Send(document.getElementById('frmRefineSearch'));refineaccommodation();void(0);\" onMouseover=\"return hidestatus()\"  style=\"text-decoration:none;\"><strong>(+)</strong>&nbsp;<span class=\"blackText\">".$property_entertainment_name."</span></a></div>";
                    } 
                    ?>
                </div>
            </div>                                            
        </td>
    </tr>
    <?php
    }
    ?>
    <?php
    /*
    if(count($propertyHeatingCoolingArr) > 0) {
    ?>
    <tr>
        <td>
            <div id="RSHeatingCoolingDivId" style="display:block;">
                <div id="RSHeatingCoolingDivShortId" style="display:<?php if(isset($_COOKIE['showHideRSHeatingCoolingDivShortId']) && $_COOKIE['showHideRSHeatingCoolingDivShortId']=="none" && $_COOKIE['showHideRSHeatingCoolingDivFullId']=="block"){echo "none";} else {echo "block";}?>;">
                    <div style="background-color:#ccffff; height:21px; width:188px; vertical-align:middle;">
                        <span class="FloatLft font12-darkgrey pad-lft5"><?php echo tranText('heating_cooling'); ?></span>
                        <span class="FloatRgt pad-rgt10"><img src="<?php echo SITE_IMAGES;?>maximize-icon.gif" alt="Expand" onclick="SetCookie('showHideRSHeatingCoolingDivFullId', 'block');SetCookie('showHideRSHeatingCoolingDivShortId', 'none');showHideSection('RSHeatingCoolingDivShortId');showHideSection('RSHeatingCoolingDivFullId');" class="cursor" width="15" height="15" /></span>
                    </div>
                </div>
                <div id="RSHeatingCoolingDivFullId" style="display:<?php if(isset($_COOKIE['showHideRSHeatingCoolingDivFullId']) && $_COOKIE['showHideRSHeatingCoolingDivFullId']=="block"){echo "block";} else {echo "none";}?>;">
                    <div style="background-color:#ccffff; height:21px; width:188px; vertical-align:middle;">
                        <span class="FloatLft font12-darkgrey pad-lft5"><?php echo tranText('heating_cooling'); ?></span>
                        <span class="FloatRgt pad-rgt10"><img src="<?php echo SITE_IMAGES;?>minimize-icon.gif" alt="Expand" onclick="SetCookie('showHideRSHeatingCoolingDivShortId', 'block');SetCookie('showHideRSHeatingCoolingDivFullId', 'none');showHideSection('RSHeatingCoolingDivFullId');showHideSection('RSHeatingCoolingDivShortId');" class="cursor" width="15" height="15" /></span>
                    </div>
                    <?php
                    for($HeatingCoolingCounter = 0; $HeatingCoolingCounter < count($propertyHeatingCoolingArr); $HeatingCoolingCounter++) {
                        $property_heatingcooling_name 	= ucfirst($propertyHeatingCoolingArr[$HeatingCoolingCounter]['property_heatingcooling_name']);
                        $HeatingCoolingCounterDisplay2 = (is_array($txtheatingcoolingidsArr) && in_array($propertyHeatingCoolingArr[$HeatingCoolingCounter]['property_heatingcooling_id'], $txtheatingcoolingidsArr))?"none":"block";
                        echo "<div id=\"RSHeatingCoolingDivFullItemId".$HeatingCoolingCounter."\" style=\"display:".$HeatingCoolingCounterDisplay2.";\"><a href=\"javascript:showHideSection('RSKitchenDivFullItemId".$HeatingCoolingCounter."');showHideSection('RSHeatingCoolingDivFullItemId".$HeatingCoolingCounter."');addNonMutualAccomTxt('RSHeatingCoolingDivId', 'RSHeatingCoolingDivFullItemId".$HeatingCoolingCounter."', '".$property_heatingcooling_name."', 'txtheatingcoolingids','".$propertyHeatingCoolingArr[$HeatingCoolingCounter]['property_heatingcooling_id']."');Post.Send(document.getElementById('frmRefineSearch'));refineaccommodation();void(0);\" onMouseover=\"return hidestatus()\"  style=\"text-decoration:none;\"><strong>(+)</strong>&nbsp;<span class=\"blackText\">".$property_heatingcooling_name."</span></a></div>";
                    } 
                    ?>
                </div>
            </div>                                            
        </td>
    </tr>
    <?php
    }
    */
    ?>
    <?php
    if(count($propertyLocationViewArr) > 0) {
    ?>
    <tr>
        <td valign="middle" class="pad-btm2">
            <div id="RSLocationViewDivId" style="display:block;">
                <div id="RSLocationViewDivShortId" style="display:<?php if(isset($_COOKIE['showHideRSLocationViewDivShortId']) && $_COOKIE['showHideRSLocationViewDivShortId']=="none" && $_COOKIE['showHideRSLocationViewDivFullId']=="block"){echo "none";} else {echo "block";}?>;">
                    <div style="background-color:#efefef; height:25px; vertical-align:middle; cursor:pointer;" onclick="SetCookie('showHideRSLocationViewDivFullId', 'block');SetCookie('showHideRSLocationViewDivShortId', 'none');showHideSection('RSLocationViewDivShortId');showHideSection('RSLocationViewDivFullId');">
                        <span class="FloatLft pad-lft10 pad-top5" style="color:#009bd4; font-weight:bold;"><?php echo tranText('location'); ?></span>
                        <span class="FloatRgt pad-rgt10 pad-top10"><img src="<?php echo SITE_IMAGES;?>up-icon.gif" /></span>
                    </div>
                </div>
                <div id="RSLocationViewDivFullId" style="display:<?php if(isset($_COOKIE['showHideRSLocationViewDivFullId']) && $_COOKIE['showHideRSLocationViewDivFullId']=="block"){echo "block";} else {echo "none";}?>;">
                    <div style="background-color:#009bd4; height:25px; vertical-align:middle; cursor:pointer;" onclick="SetCookie('showHideRSLocationViewDivShortId', 'block');SetCookie('showHideRSLocationViewDivFullId', 'none');showHideSection('RSLocationViewDivFullId');showHideSection('RSLocationViewDivShortId');">
                        <span class="FloatLft pad-lft10 pad-top5" style="color:#ffffff; font-weight:bold;"><?php echo tranText('location'); ?></span>
                        <span class="FloatRgt pad-rgt10 pad-top10"><img src="<?php echo SITE_IMAGES;?>down-icon.gif" /></span>
                    </div>
                    <?php
                    for($LocationViewCounter = 0; $LocationViewCounter < count($propertyLocationViewArr); $LocationViewCounter++) {
                        $property_locationview_name 	= ucfirst($propertyLocationViewArr[$LocationViewCounter]['property_locationview_name']);
                        $LocationViewCounterDisplay2 = (is_array($txtlocationviewidsArr) && in_array($propertyLocationViewArr[$LocationViewCounter]['property_locationview_id'], $txtlocationviewidsArr))?"none":"block";
                        echo "<div id=\"RSLocationViewDivFullItemId".$LocationViewCounter."\" style=\"display:".$LocationViewCounterDisplay2."; padding:5px 10px 5px 10px;\"><a href=\"javascript:showHideSection('RSKitchenDivFullItemId".$LocationViewCounter."');showHideSection('RSLocationViewDivFullItemId".$LocationViewCounter."');addNonMutualAccomTxt('RSLocationViewDivId', 'RSLocationViewDivFullItemId".$LocationViewCounter."', '".$property_locationview_name."', 'txtlocationviewids','".$propertyLocationViewArr[$LocationViewCounter]['property_locationview_id']."');Post.Send(document.getElementById('frmRefineSearch'));refineaccommodation();void(0);\" onMouseover=\"return hidestatus()\"  style=\"text-decoration:none;\"><strong>(+)</strong>&nbsp;<span class=\"blackText\">".$property_locationview_name."</span></a></div>";
                    } 
                    ?>
                </div>
            </div>                                            
        </td>
    </tr>
    <?php
    }
    ?>
    <?php
    /*
    if(count($propertyServicesArr) > 0) {
    ?>
    <tr>
        <td>
            <div id="RSServicesDivId" style="display:block;">
                <div id="RSServicesDivShortId" style="display:<?php if(isset($_COOKIE['showHideRSServicesDivShortId']) && $_COOKIE['showHideRSServicesDivShortId']=="none" && $_COOKIE['showHideRSServicesDivFullId']=="block"){echo "none";} else {echo "block";}?>;">
                    <div style="background-color:#ccffff; height:21px; width:188px; vertical-align:middle;">
                        <span class="FloatLft font12-darkgrey pad-lft5"><?php echo tranText('services'); ?></span>
                        <span class="FloatRgt pad-rgt10 "><img src="<?php echo SITE_IMAGES;?>maximize-icon.gif" alt="Expand" onclick="SetCookie('showHideRSServicesDivFullId', 'block');SetCookie('showHideRSServicesDivShortId', 'none');showHideSection('RSServicesDivShortId');showHideSection('RSServicesDivFullId');" class="cursor" width="15" height="15" /></span>
                    </div>
                </div>
                <div id="RSServicesDivFullId" style="display:<?php if(isset($_COOKIE['showHideRSServicesDivFullId']) && $_COOKIE['showHideRSServicesDivFullId']=="block"){echo "block";} else {echo "none";}?>;">
                    <div style="background-color:#ccffff; height:21px; width:188px; vertical-align:middle;">
                        <span class="FloatLft font12-darkgrey pad-lft5"><?php echo tranText('services'); ?></span>
                        <span class="FloatRgt pad-rgt10"><img src="<?php echo SITE_IMAGES;?>minimize-icon.gif" alt="Expand" onclick="SetCookie('showHideRSServicesDivShortId', 'block');SetCookie('showHideRSServicesDivFullId', 'none');showHideSection('RSServicesDivFullId');showHideSection('RSServicesDivShortId');" class="cursor" width="15" height="15" /></span>
                    </div>
                    <?php
                    for($ServicesCounter = 0; $ServicesCounter < count($propertyServicesArr); $ServicesCounter++) {
                        $property_services_name 	= ucfirst($propertyServicesArr[$ServicesCounter]['property_services_name']);
                        $ServicesCounterDisplay2 = (is_array($txtserviceidsArr) && in_array($propertyServicesArr[$ServicesCounter]['property_services_id'], $txtserviceidsArr))?"none":"block";
                        echo "<div id=\"RSServicesDivFullItemId".$ServicesCounter."\" style=\"display:".$ServicesCounterDisplay2.";\"><a href=\"javascript:showHideSection('RSKitchenDivFullItemId".$ServicesCounter."');showHideSection('RSServicesDivFullItemId".$ServicesCounter."');addNonMutualAccomTxt('RSServicesDivId', 'RSServicesDivFullItemId".$ServicesCounter."', '".$property_services_name."', 'txtserviceids','".$propertyServicesArr[$ServicesCounter]['property_services_id']."');Post.Send(document.getElementById('frmRefineSearch'));refineaccommodation();void(0);\" onMouseover=\"return hidestatus()\"  style=\"text-decoration:none;\"><strong>(+)</strong>&nbsp;<span class=\"blackText\">".$property_services_name."</span></a></div>";
                    } 
                    ?>
                </div>
            </div>                                            
        </td>
    </tr>
    <?php
    }
    */
    ?>
    <?php
    if(count($propertyGeneralArr) > 0) {
    ?>
    <tr>
        <td valign="middle">
            <div id="RSGeneralDivId" style="display:block;">
                <div id="RSGeneralDivShortId" style="display:<?php if(isset($_COOKIE['showHideRSGeneralDivShortId']) && $_COOKIE['showHideRSGeneralDivShortId']=="none" && $_COOKIE['showHideRSGeneralDivFullId']=="block"){echo "none";} else {echo "block";}?>;">
                    <div style="background-color:#efefef; height:25px; vertical-align:middle; cursor:pointer;" onclick="SetCookie('showHideRSGeneralDivFullId', 'block');SetCookie('showHideRSGeneralDivShortId', 'none');showHideSection('RSGeneralDivShortId');showHideSection('RSGeneralDivFullId');">
                        <span class="FloatLft pad-lft10 pad-top5" style="color:#009bd4; font-weight:bold;"><?php echo tranText('general'); ?></span>
                        <span class="FloatRgt pad-rgt10 pad-top10"><img src="<?php echo SITE_IMAGES;?>up-icon.gif" /></span>
                    </div>
                </div>
                <div id="RSGeneralDivFullId" style="display:<?php if(isset($_COOKIE['showHideRSGeneralDivFullId']) && $_COOKIE['showHideRSGeneralDivFullId']=="block"){echo "block";} else {echo "none";}?>;">
                    <div style="background-color:#009bd4; height:25px; vertical-align:middle; cursor:pointer;" onclick="SetCookie('showHideRSGeneralDivShortId', 'block');SetCookie('showHideRSGeneralDivFullId', 'none');showHideSection('RSGeneralDivFullId');showHideSection('RSGeneralDivShortId');">
                        <span class="FloatLft pad-lft10 pad-top5" style="color:#ffffff; font-weight:bold;"><?php echo tranText('general'); ?></span>
                        <span class="FloatRgt pad-rgt10 pad-top10"><img src="<?php echo SITE_IMAGES;?>down-icon.gif" /></span>
                    </div>
                    <?php
                    for($GeneralCounter = 0; $GeneralCounter < count($propertyGeneralArr); $GeneralCounter++) {
                        $property_general_name 	= ucfirst($propertyGeneralArr[$GeneralCounter]['property_general_name']);
                        $GeneralCounterDisplay2 = (is_array($txtgeneralidsArr) && in_array($propertyGeneralArr[$GeneralCounter]['property_general_id'], $txtgeneralidsArr))?"none":"block";
                        echo "<div id=\"RSGeneralDivFullItemId".$GeneralCounter."\" style=\"display:".$GeneralCounterDisplay2."; padding:5px 10px 5px 10px;\"><a href=\"javascript:showHideSection('RSKitchenDivFullItemId".$GeneralCounter."');showHideSection('RSGeneralDivFullItemId".$GeneralCounter."');addNonMutualAccomTxt('RSGeneralDivId', 'RSGeneralDivFullItemId".$GeneralCounter."', '".$property_general_name."', 'txtgeneralids','".$propertyGeneralArr[$GeneralCounter]['property_general_id']."');Post.Send(document.getElementById('frmRefineSearch'));refineaccommodation();void(0);\" onMouseover=\"return hidestatus()\"  style=\"text-decoration:none;\"><strong>(+)</strong>&nbsp;<span class=\"blackText\">".$property_general_name."</span></a></div>";
                    } 
                    ?>
                </div>
            </div>                                            
        </td>
    </tr>
    <?php
    }
    ?>
</table>