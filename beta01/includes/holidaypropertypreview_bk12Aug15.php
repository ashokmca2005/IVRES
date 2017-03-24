<a name="showSectionTop"></a>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
    <tr>
        <td align="left" valign="middle" class="pad-btm5">
            <ul style="width:680px;">
			<?php
            if((strpos($_SERVER['HTTP_REFERER'], "owner-property.php?sec=") == true) || (strpos($_SERVER['HTTP_REFERER'], "admin-pending-approval.php?sec=") == true) || (isset($_SESSION['property_preview_close_url']) && $_SESSION['property_preview_close_url'] != "")) {
            ?>
                <li id="property-head"><a href="javascript:void(0);" id="property-back">Back to results</a></li>
                <li>&nbsp;</li>
            <?php
            } else {
            ?>
				<?php /*?>
                <li id="property-head"><a href="javascript:void(0);" onclick="history.back();" id="property-back">Back to results</a></li>
                <li>&nbsp;</li>
				<?php */?>
                <li id="property-head"><a href="javascript:void(0);" onclick="document.getElementById('frmBackToSearch').submit();" id="property-back">Back to results</a></li>
                <li>&nbsp;</li>
            <?php
            }
            ?>
            </ul>
        </td>
    </tr>
</table>
<?php
if(isset($_REQUEST['txtbackurl']) && $_REQUEST['txtbackurl'] !="") {
	$action_url = $_REQUEST['txtbackurl'];
} else if(isset($_COOKIE['cook_txtbackurl']) && $_COOKIE['cook_txtbackurl'] !="") {
	$action_url = $_COOKIE['cook_txtbackurl'];
} else if(isset($_SESSION['sess_txtbackurl']) && $_SESSION['sess_txtbackurl'] !="") {
	$action_url = $_SESSION['sess_txtbackurl'];
} else if(isset($_REQUEST['showmap']) && $_REQUEST['showmap'] == "1") {
	$action_url = SITE_URL."map.vacation-rentals";
} else {
	$action_url = SITE_URL."vacation-rentals";
}
?>
<form name="frmBackToSearch" id="frmBackToSearch" action="<?php echo $action_url; ?>" method="post">
    <input type="hidden" name="txtcountryids" id="txtcountryids" value="<?php echo $_REQUEST['txtcountryids'];?>">
    <input type="hidden" name="txtareaids" id="txtareaids" value="<?php echo $_REQUEST['txtareaids'];?>">
    <input type="hidden" name="txtregionids" id="txtregionids" value="<?php echo $_REQUEST['txtregionids'];?>">
    <input type="hidden" name="txtlocationids" id="txtlocationids" value="<?php echo $_REQUEST['txtlocationids'];?>">
    <input type="hidden" name="txtavailabilityids" id="txtavailabilityids" value="<?php echo $_REQUEST['txtavailabilityids'];?>">
    <input type="hidden" name="txtpropertytypeids" id="txtpropertytypeids" value="<?php echo $_REQUEST['txtpropertytypeids'];?>">
    <input type="hidden" name="txttotalbed" id="txttotalbed" value="<?php echo $_REQUEST['txttotalbed'];?>">
    <input type="hidden" name="txtneedsleep" id="txtneedsleep" value="<?php echo $_REQUEST['txtneedsleep'];?>">
    <input type="hidden" name="txtholidaytypeids" id="txtholidaytypeids" value="<?php echo $txtholidaytypeids;?>">
    <input type="hidden" name="txtkitchenlinenids" id="txtkitchenlinenids" value="<?php echo $txtkitchenlinenids;?>">
    <input type="hidden" name="txtoutsideids" id="txtoutsideids" value="<?php echo $txtoutsideids;?>">
    <input type="hidden" name="txtactivitynearbyids" id="txtactivitynearbyids" value="<?php echo $txtactivitynearbyids;?>">
    <input type="hidden" name="txtenterainmentids" id="txtenterainmentids" value="<?php echo $txtenterainmentids;?>">
    <input type="hidden" name="txtheatingcoolingids" id="txtheatingcoolingids" value="<?php echo $txtheatingcoolingids;?>">
    <input type="hidden" name="txtlocationviewids" id="txtlocationviewids" value="<?php echo $txtlocationviewids;?>">
    <input type="hidden" name="txtserviceids" id="txtserviceids" value="<?php echo $txtserviceids;?>">
    <input type="hidden" name="txtgeneralids" id="txtgeneralids" value="<?php echo $txtgeneralids;?>">
	<?php /*?>
    <input type="hidden" name="txtfacilityids" id="txtfacilityids" value="<?php echo $_REQUEST['txtfacilityids'];?>">
    <input type="hidden" name="txtspecialrequirmentids" id="txtspecialrequirmentids" value="<?php echo $_REQUEST['txtspecialrequirmentids'];?>">
	<?php */?>
    <input type="hidden" name="sortby" id="sortbyId" value="0">
    <input type="hidden" name="latedeal" id="latedealId" value="<?php echo $_REQUEST['latedealId'];?>">
	<?php /*?>
    <input type="hidden" name="worldcup" id="worldcupId" value="<?php echo $_REQUEST['worldcupId'];?>">
	<?php */?>
    <input type="hidden" name="p_map_zoom" value="<?php if(isset($_REQUEST['p_map_zoom']) && $_REQUEST['p_map_zoom'] != "") {echo $_REQUEST['p_map_zoom'];} else if(isset($zoomLevel)) {echo $zoomLevel;} else {echo "2";}?>" id="p_map_zoom" />
    <input type="hidden" name="p_map_map_type" value="G_HYBRID_MAP" id="p_map_map_type" />
    <input type="hidden" name="p_map_latitude" id="p_map_latitude" value="<?php if(isset($_REQUEST['p_map_latitude']) && $_REQUEST['p_map_latitude'] !=""){echo $_REQUEST['p_map_latitude'];} else if(isset($destinationInfoArr['destination_lat']) && $destinationInfoArr['destination_lat'] !=""){echo $destinationInfoArr['destination_lat'];} else {echo "31.052934";} ?>">
    <input type="hidden" name="p_map_longitude" id="p_map_longitude" value="<?php if(isset($_REQUEST['p_map_longitude']) && $_REQUEST['p_map_longitude'] !=""){echo $_REQUEST['p_map_longitude'];} else if(isset($destinationInfoArr['destination_lon']) && $destinationInfoArr['destination_lon'] !=""){echo $destinationInfoArr['destination_lon'];} else {echo "10.546875";} ?>">
    <input type="hidden" name="txtcountryid" id="txtcountryid" value="<?php echo $_REQUEST['txtcountryid'];?>">
    <input type="hidden" name="txtareaid" id="txtareaid" value="<?php echo $_REQUEST['txtareaid'];?>">
    <input type="hidden" name="txtregionid" id="txtregionid" value="<?php echo $_REQUEST['txtregionid'];?>">
    <input type="hidden" name="txtsubregionid" id="txtsubregionid" value="<?php echo $_REQUEST['txtsubregionid'];?>">
    <input type="hidden" name="txtlocationid" id="txtlocationid" value="<?php echo $_REQUEST['txtlocationid'];?>">
    <input type="hidden" name="securityKey" value="<?php echo md5("REFINESEARCH")?>">
</form>
<?php 
$booking_on = false;
$minStayArr1 = array();
for($i=0; $i<count($propertyPricesArr); $i++){
	$minStay1 = $propertyPricesArr[$i]['min_stay'];
	if($propertyPricesArr[$i]['min_stay_type'] == "w")
	$minStay1 = ($minStay1*7);
	array_push($minStayArr1, $minStay1);
}
$mindays = (is_array($minStayArr1) && !empty($minStayArr1))?min($minStayArr1):1;
$cur_unixtime 	= time();
$year 			= date("Y");
$month 			= date("m");
$day 			= date("d");
$datefromArr 	= $propertyObj->fun_getPropertyAvailabilityArr($property_id, $year, $month, $day);
$date_from 		= (strtotime($datefromArr[0]['startdate']) > $cur_unixtime)?$datefromArr[0]['startdate']:date("Y-m-d");
$date_to 		= date("Y-m-d", (strtotime($date_from)+($mindays*24*60*60)));

if($propertyObj->fun_checkBookingAvailability($property_id, $date_from, $date_to) == true) {
//$booking_on 	= true;
$booking_on 	= false;
?>
<form name="frmPropertyBooking" id="frmPropertyBooking" method="post" action="<?php echo SITE_URL;?>property-booking-preview.php">
<input type="hidden" name="securityKey" value="<?php echo md5(BOOKINGENGINE); ?>" />
<input type="hidden" name="txtPropertyId" id="txtPropertyId" value="<?php echo $property_id; ?>" />
<input type="hidden" name="txtArriavalDate" id="txtArriavalDate" value="<?php echo $date_from; ?>" />
<input type="hidden" name="txtDepartureDate" id="txtDepartureDate" value="<?php echo $date_to; ?>" />
<input type="hidden" name="txtMinDays" id="txtMinDays" value="<?php echo $mindays; ?>" />
</form>
<?php
}
?>
<script language="javascript" type="text/javascript">
	function submitTripDuration(arival, departure) {
		/*
		document.getElementById("txtArriavalDate").value = arival;
		document.getElementById("txtDepartureDate").value = departure;
		*/
		document.getElementById("frmPropertyBooking").submit();
	}
</script>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <?php
    if((strpos($_SERVER['HTTP_REFERER'], "owner-property.php?sec=") == true) || (strpos($_SERVER['HTTP_REFERER'], "admin-pending-approval.php?sec=") == true) || (isset($_SESSION['property_preview_close_url']) && $_SESSION['property_preview_close_url'] != "")) {
        if((strpos($_SERVER['HTTP_REFERER'], "owner-property.php?sec=") == true)) {
        $_SESSION['property_preview_close_url'] = $_SERVER['HTTP_REFERER'];
            $return_url = $_SESSION['ses_user_home'];
        }
        if((strpos($_SERVER['HTTP_REFERER'], "admin-pending-approval.php?sec=") == true)) {
            $_SESSION['property_preview_close_url'] = $_SERVER['HTTP_REFERER'];
            $return_url = SITE_ADMIN_URL."admin-home.php";
        }
    ?>
    <tr>
        <td valign="top">
            <table width="100%" cellpadding="0" cellspacing="0" class="font12">
                <tr>
                    <td width="250"><h1>Preview of your advert</h1></td>
                    <td align="right"><a href="<?php echo $_SESSION['property_preview_close_url']; ?>" class="arrowLink">Close preview</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo $return_url; ?>" class="arrowLink">Go to my homepage</a></td>
                </tr>
            </table>
        </td>
    </tr>
    <?php
    } else {
        $propertyObj->fun_checkPropertyLive($property_id);
		$propertyObj->fun_addPropertyVisit($property_id);
    }
    ?>
    <tr>
        <td valign="top">
            <div class="box-property-left">
                <h1><a href="<?php echo $property_link; ?>" style="text-decoration:none;"><?php echo $property_name; ?></a></h1>
                <a href="<?php echo SITE_URL; ?>vacation-rentals/in.<?php echo str_replace("&", "", str_replace(",", "_", str_replace(" ", "-", strtolower($propLocInfoArr['area_name'])))); ?>" class="location-1"><?php echo ucwords($propLocInfoArr['area_name'].', '.$propLocInfoArr['countries_name']); ?></a><br />
				<?php /*?>
                <h2><?php echo $property_title?></h2>
                <h3><?php echo $strPropTypeCaterType;?> - <?php echo $strPropPriceAvg;?> - <?php echo $strPropSBB;?></h3>
				<?php */?>
                <div class="box-property-left-wrapper">
                    <div id="tab_menu-1">
                        <ul>
							<?php /*?>
                            <li><a href="#showSectionTop" onclick="return showSection(1);" title="Description" class="current">Overview</a></li>
							<?php */?>
                            <li><a href="javascript:void(0);" title="Photos" class="current" style="width:130px;">Photos</a></li>
							<?php
                                $videoArray 		= $propertyObj->fun_getPropertyVideoInfoArr($property_id);
                                if(is_array($videoArray) && count($videoArray) > 0) {
                                    $video_id 			= $videoArray['video_id'];
                                    $video_caption 		= $videoArray['video_caption'];
                                    $video_description 	= $videoArray['video_url'];
                                    $video_url_arr 		= split("<embed src=\"", $video_description);
                                    $video_url_arr1 	= split("\" type=\"application/x-shockwave-flash\"", $video_url_arr[1]);
                                    $video_url 			= $video_url_arr1[0];
                                    if(isset($video_url) && $video_url != "") { 
                                    ?>
                                    <li><a href="<?php echo $video_url; ?>" target="_blank" title="<?php echo $video_caption; ?>" style="width:130px;">Video</a></li>
                                    <li><a href="#showSectionLocation" onclick="return showSection(3);" title="Location" style="width:130px;">Show on map</a></li>
                                    <li style="width:188px; margin-right:0px;">&nbsp;</li>
                                    <?
                                    }
                                } else {
								?>
                                    <li><a href="#showSectionLocation" onclick="return showSection(3);" title="Location" style="width:130px;">Show on map</a></li>
                                    <li style="width:336px; margin-right:0px;">&nbsp;</li>
                                <?php
								}
                            ?>
							<?php /*?>
                            <li><a href="#showSectionAbout" onclick="return showSection(4);" title="Amenities">Amenities</a></li>
                            <li><a href="#showSectionCalendar" onclick="return showSection(5);" title="Availability">Availability</a></li>
                            <li><a href="#showSectionPrice" onclick="return showSection(6);" title="Prices">Rates</a></li>
                            <li><a href="#showSectionReview" onclick="return showSection(7);" title="Reviews">Read / Add Review(s)</a></li>
                            <?php
							if($booking_on == true) {
							?>
                            <li><a href="javascript:void(0);" onclick="submitTripDuration('<?php echo $date_from;?>', <?php echo $date_to;?>)" title="Book Now" style="color:#e89c4e;">Book Now</a></li>
                            <?php
							}
							?>
							<?php */?>
                        </ul>
                    </div>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td valign="top">
								<?php
                                $propertyPhotosInfo	= $propertyObj->fun_getPropertyPhotosAllInfoArr($property_id);
                                $total_photos 		= count($propertyPhotosInfo);
                                /*
                                if (isset ($_GET['imgid'] ) && $_GET['imgid'] !="") {
                                    $imgid 		= $_GET['imgid'];
                                    $propertyPhotoInfo	= $propertyObj->fun_getPropertyPhotoInfoArr($property_id, $imgid);
                                    $imgid 		= $propertyPhotoInfo[0]['photo_id'];
                                    $imgcap 	= ucfirst($propertyPhotoInfo[0]['photo_caption']);
                                    $imgcap		= addslashes($imgcap);
                                    $imgurl 	= PROPERTY_IMAGES_LARGE600x450_PATH.$propertyPhotoInfo[0]['photo_url'];
                                    $imgthumb 	= PROPERTY_IMAGES_THUMB88x66_PATH.$propertyPhotoInfo[0]['photo_thumb'];
                                } else {
                                    $propertyMainThumb	= $propertyObj->fun_getPropertyMainThumb($property_id);
                                    $imgid 		= $propertyMainThumb[0]['photo_id'];
                                    $imgcap 	= $propertyMainThumb[0]['photo_caption'];
                                    $imgcap		= addslashes($imgcap);
                                    $imgurl 	= PROPERTY_IMAGES_LARGE600x450_PATH.$propertyMainThumb[0]['photo_url'];
                                    $imgthumb 	= PROPERTY_IMAGES_THUMB88x66_PATH.$$propertyMainThumb[0]['photo_thumb'];
                                }
                                */
                                if(isset($total_photos) && $total_photos > 0) {
                                ?>
                                    <script type="text/javascript" src="<?php echo SITE_URL;?>jquery/js/jquery.bxslider.min.js"></script>
                                    <script type="text/javascript" src="<?php echo SITE_URL;?>jquery/js/jquery.easing.1.3.js"></script>
                                    <script type="text/javascript" src="<?php echo SITE_URL;?>jquery/js/jquery.fitvids.js"></script>
                                    <!-- bxSlider CSS file -->
                                    <link rel="stylesheet" type="text/css" href="<?php echo SITE_CSS_INCLUDES_PATH;?>jquery.bxslider1.css" />
                                    <script language="javascript">
                                        $(document).ready(function(){
                                            $('.bxslider').bxSlider({
                                                captions: true,
                                                auto: true,
                                                controls: true,
                                                autoControls: true,
                                                autoStart: false,
                                                //infiniteLoop: false,
                                                //hideControlOnEnd: true,
                                                //pager: true,
                                                //pagerType: 'full',
                                                pagerCustom: '#bx-pager'
                                            });
                                        });
                                    </script>
                                    <style type="text/css">
                                      #bx-pager {
                                        margin-top:-40px;
                                        padding: 0px;
                                      }
                                      
                                      #bx-pager a {
                                        border: solid #ddd 2px;
                                        display:inline-block;
                                        margin: 0 2px;
                                        padding: 0px;
                                      }
                                      
                                      #bx-pager a:hover,
                                      #bx-pager a.active {
                                        border: solid #0092d6 2px;
                                      }
                                    </style>
                                    <ul class="bxslider">
                                    <?php
                                    for($i = 0; $i < count($propertyPhotosInfo); $i++) {
                                        $photo_caption 	= ($propertyPhotosInfo[$i]['photo_caption'] !="")?ucfirst($propertyPhotosInfo[$i]['photo_caption']):"&nbsp;";
										$pos 		= strpos($propertyPhotosInfo[$i]['photo_url'], "rentalo.com");
										if($pos === false) {
											$photo_url = PROPERTY_IMAGES_LARGE600x450_PATH.$propertyPhotosInfo[$i]['photo_url'];
										} else {
											$photo_url = $propertyPhotosInfo[$i]['photo_url'];
										}

                                        //$photo_url 		= PROPERTY_IMAGES_LARGE600x450_PATH.$propertyPhotosInfo[$i]['photo_url'];
                                        //$photo_url 		= PROPERTY_IMAGES_LARGE480x360_PATH.$propertyPhotosInfo[$i]['photo_url'];
                                        echo '<li><img src="'.$photo_url.'" title="'.$photo_caption.'" width="630" height="420" /></li>';
                                    }
                                    ?>
                                    </ul>
                                    <div id="bx-pager" align="left">
                                    <?php
                                    for($i = 0; $i < count($propertyPhotosInfo); $i++) {
                                        //$photo_thumb 	= PROPERTY_IMAGES_THUMB88x66_PATH.$propertyPhotosInfo[$i]['photo_thumb'];
										$pos 		= strpos($propertyPhotosInfo[$i]['photo_thumb'], "rentalo.com");
										if($pos === false) {
											$photo_thumb = PROPERTY_IMAGES_THUMB88x66_PATH.$propertyPhotosInfo[$i]['photo_thumb'];
										} else {
											$photo_thumb = $propertyPhotosInfo[$i]['photo_thumb'];
										}
                                        echo '<a data-slide-index="'.$i.'" href=""><img src="'.$photo_thumb.'" width="88" height="66" /></a>';
                                    }
                                    ?>
                                    </div>
                                <?php
                                }
                                ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="clearfix"></div>
                <div id="sectionId1" class="box-property-left-wrapper">
                    <a name="showSectionOverview"></a>
                    <?php require_once(SITE_INCLUDES_PATH."holidaypropertyviewtaboverview.php"); ?>
                </div>
				<?php /*?>
                <div class="clearfix"></div>
                <div id="sectionId2" class="box-property-left-wrapper" style="margin-top:10px;">
                    <a name="showSectionPhotos"></a>
                    <?php require_once(SITE_INCLUDES_PATH."holidaypropertyviewtabphoto.php"); ?>
                </div>
				<?php */?>
                <div class="clearfix"></div>
                <div id="sectionId3" class="box-property-left-wrapper" style="display:none;">
                    <a name="showSectionLocation"></a>
                    <?php require_once(SITE_INCLUDES_PATH."holidaypropertyviewtablocation.php"); ?>
                </div>
                <div class="clearfix"></div>
                <div id="sectionId4" class="box-property-left-wrapper" style="display:none;">
                    <a name="showSectionAbout"></a>
                    <?php require_once(SITE_INCLUDES_PATH."holidaypropertyviewtababoutproperty.php"); ?>
                </div>
                <div class="clearfix"></div>
                <div id="sectionId5" class="box-property-left-wrapper" style="display:none;">
                    <a name="showSectionCalendar"></a>
                    <?php require_once(SITE_INCLUDES_PATH."holidaypropertyviewtabcalendar.php"); ?>
                </div>
                <div class="clearfix"></div>
                <div id="sectionId6" class="box-property-left-wrapper" style="display:none;">
                    <a name="showSectionPrice"></a>
                    <?php require_once(SITE_INCLUDES_PATH."holidaypropertyviewtabprice.php"); ?>
                </div>
                <div class="clearfix"></div>
                <div id="sectionId7" class="box-property-left-wrapper" style="display:none;">
                    <a name="showSectionReview"></a>
                    <?php require_once(SITE_INCLUDES_PATH."holidaypropertyviewtabreviews.php"); ?>
                </div>
                <div class="clearfix"></div>
                <div id="sectionId8" class="box-property-left-wrapper" style="display:none;">
                    <a name="showSectionOwner"></a>
                    <?php require_once(SITE_INCLUDES_PATH."holidaypropertyviewtabowner.php"); ?>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="box-property-right">
                <div class="box-property-right-wrapper">
                    <a name="showSectionContact"></a>
                    <?php require_once(SITE_INCLUDES_PATH."holidaypropertyviewtabcontactowner.php"); ?>
                </div>
            </div>
            <div class="clearfix"></div>
        </td>
    </tr>
</table>
