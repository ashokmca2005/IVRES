<?php
	if($_SERVER["SERVER_NAME"] == "localhost") {
		require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/includes/application-top.php");
	} else {
		require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
	}

	require_once(SITE_CLASSES_PATH."class.Event.php");
	require_once(SITE_CLASSES_PATH."class.Location.php");
	$eventObj 		= new Event();
	$locationObj 	= new Location();
	$seo_friendly 		= SITE_URL."events"; // for seo friendly urls
	if(isset($_GET['event']) && $_GET['event'] !="") {
		$event 	= $_GET['event'];
		$event	= str_replace("_", ",", str_replace("-", " ", $event));
		$evntDetails	= $eventObj->fun_getEventDetailsByName($event);
	/*
		if(!is_array($evntDetails)) {
			redirectURL(SITE_URL.'events'); // go to event listing page
		}
	*/
	} else {
		redirectURL(SITE_URL.'events'); // go to event listing page
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo tranText('charset'); ?>" />
<META HTTP-EQUIV="Content-language" CONTENT="<?php echo tranText('lang_iso'); ?>">
<link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo SITE_URL; ?>favicon.ico" />
<link rel="SHORTCUT ICON" href="<?php echo SITE_URL; ?>favicon.ico"/>
<title><?php echo $sitetitle;?>:: Events</title>
<link rel="stylesheet" type="text/css" href="<?php echo SITE_CSS_INCLUDES_PATH;?>common.css" />
<script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>dhtmlwindow.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>common.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>pop-up.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>tab_menu.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>dargPop.js"></script>
<script language="javascript" type="text/javascript">
    var req = ajaxFunction();
    var x, y;
    function show_coords(event){	
        x=event.clientX;
        y=event.clientY;
        x = x-160;
        y = y+4;
    //	alert(x);alert(y);
    }
    function toggleLayer(whichLayer){
        var output = document.getElementById(whichLayer).innerHTML;
        if(whichLayer == 'ANP-Example'){
            output = '<div style="z-index:5;">'+output+'</div>';
            var googlewin=dhtmlwindow.open("Example", "inline", output, "", "width=295px,height=470px,resize=0,scrolling=0,center=1,xAxis="+x+",yAxis="+y+"", "recal");
        }
        googlewin.onclose=function(){ //Run custom code when window is being closed (return false to cancel action):
            return true
        }
    }
    
    function closeWindow(){	
        document.getElementById("Example").style.display="none";
    }
    
    function closeWindowNRefresh(){
        document.getElementById("Example").style.display="none";
        window.location = location.href;
    }
    </script>
</head>
<body onmousedown="show_coords(event);">
<!-- Main Wrapper Starts Here -->
<div id="wrapper">
    <!-- Header Include Starts Here -->
    <div id="header" align="center">
        <?php require_once(SITE_INCLUDES_PATH.'header.php'); ?>
    </div>
    <!-- Header Include End Here -->
	<?php require_once(SITE_INCLUDES_PATH.'holidayadvsearch.php'); ?>
	<?php //require_once(SITE_INCLUDES_PATH.'breadcrumb.php'); ?>
    <div id="main">
        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="left" valign="top">
					<?php require_once(SITE_INCLUDES_PATH.'holiday-events-view-left-links.php'); ?>
                </td>
                <td width="30" align="left" valign="top" style="border-right:thin #efefef solid;">&nbsp;</td>
                <td align="left" valign="top" class="font12" style="padding-left:40px;">
                    <table width="690" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="450" align="left" valign="top">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr><td align="left" valign="top" class="pad-btm2 pad-top15"><h1 class="font16-darkgrey"><?php echo fun_db_output($evntDetails['event_name']); ?></h1></td></tr>
                                    <tr><td align="left" valign="top" class="pad-top10"><a href="<?php echo SITE_URL; ?>events" class="back">Back to results </a></td></tr>
                                    <tr>
                                        <td align="left" valign="top" class="pad-top15">
                                            <table border="0" cellpadding="0" cellspacing="0">
                                                <?php
                                                if(isset($evntDetails['event_img']) && $evntDetails['event_img'] != "") {
                                                    echo "<tr>";
                                                    echo "<td valign=\"top\" class=\"pad-btm8\">";
                                                    echo "<img src=\"".EVENT_IMAGES_LARGE449x341_PATH.$evntDetails['event_img']."\" alt=\"".$evntDetails['event_img_caption']."\" id=\"txtEvntPhotoId\" width=\"449\" height=\"341\" />";
                                                    echo "</td>";
                                                    echo "</tr>";
                                                    echo "<tr>";
                                                    echo "<td valign=\"top\" class=\"pad-btm8\">";
                                                    if(isset($evntDetails['event_img_caption']) && $evntDetails['event_img_caption'] != "") {
                                                        echo "<div id=\"txtEvntPhotoCaptionId\" class=\"font11 FloatLft\">".ucfirst($evntDetails['event_img_caption'])."</div>";
                                                    }
                                                    if(isset($evntDetails['event_img_by']) && ($evntDetails['event_img_by'] != "" && $evntDetails['event_img_by'] != "Photo by")) {
                                                        $evntPhotoLink	 = $evntDetails['event_img_link'];
                                                        if(($evntPhotoLink !="") && $evntPhotoLink != "http://") {
                                                            if(substr($evntPhotoLink, 0, 7) == "http://") { 
                                                                $evntPhotoLink = $evntPhotoLink; 
                                                            } else { 
                                                                $evntPhotoLink = "http://".$evntPhotoLink; 
                                                            }
                                                            echo "<div id=\"txtEvntPhotoById\" class=\"font10 FloatRgt\"><a href=\"".$evntPhotoLink."\" style=\"text-decoration:none; color:#585858;\" target=\"_blank\">Photo by ".ucfirst($evntDetails['event_img_by'])."</a></div>";
                                                        } else {
                                                            echo "<div id=\"txtEvntPhotoById\" class=\"font10 FloatRgt\">Photo by ".ucfirst($evntDetails['event_img_by'])."</div>";
                                                        }
                                                    }
                                                    echo "</td>";
                                                    echo "</tr>";
                                                }
                                                ?>
                                                <tr>
                                                    <td valign="top" class="pad-btm20 pad-top10">
                                                        <div><?php echo fun_db_output($evntDetails['event_description']); ?></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td valign="top" class="pad-btm10"><span class="gray20">Information</span></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="left" valign="top">
                                            <table border="0" cellpadding="0" cellspacing="0" class="eventsData">
                                                <?php
                                                if(isset($evntDetails['event_start_date']) && ($evntDetails['event_start_date'] != "") && isset($evntDetails['event_end_date']) && ($evntDetails['event_end_date'] != "")) {
                                                ?>
                                                <tr class="grayRow">
                                                    <td width="87"><strong>Dates</strong></td>
                                                    <td width="364" align="left" class="pad-lft20">
                                                    <strong>
                                                        <?php 
                                                            if($evntDetails['event_year_around'] == "1") {
                                                                echo "All year round";
                                                            } else {
                                                                $startDate 	= date('M d, Y', strtotime($evntDetails['event_start_date']));
                                                                $endDate 		= date('M d, Y', strtotime($evntDetails['event_end_date']));
                                                                if($startDate == $endDate) {
                                                                    echo $startDate; 
                                                                } else {
                                                                    echo $startDate." - ".$endDate; 
                                                                }
                                                            }
                                                        ?>
                                                    </strong>
                                                    </td>
                                                </tr>
                                                <?php
                                                }
                                                ?>
                                                <?php
                                                if(isset($evntDetails['event_venue']) && ($evntDetails['event_venue'] != "")) {
                                                ?>
                                                <tr>
                                                    <td><strong>Venue</strong></td>
                                                    <td align="left" class="pad-lft20"><?php echo $evntDetails['event_venue']; ?></td>
                                                </tr>
                                                <?php
                                                }
                                                ?>
                                                <?php
                                                if(isset($evntDetails['event_area_id']) && ($evntDetails['event_area_id'] != "") || isset($evntDetails['event_region_id']) && ($evntDetails['event_region_id'] != "") || isset($evntDetails['event_sub_region_id']) && ($evntDetails['event_sub_region_id'] != "") || isset($evntDetails['event_location_id']) && ($evntDetails['event_location_id'] != "")) {
                                                ?>
                                                <tr class="grayRow">
                                                    <td><strong>Location</strong></td>
                                                    <td align="left" class="pad-lft20">
                                                        <?php if($evntDetails['event_area_id'] != "" && $evntDetails['event_area_id'] > 0) { echo ucwords($locationObj->fun_getAreaNameById($evntDetails['event_area_id'])).", ";} if($evntDetails['event_region_id'] != "" && $evntDetails['event_region_id'] > 0) { echo ucwords($locationObj->fun_getRegionNameById($evntDetails['event_region_id'])).", ";} if($evntDetails['event_sub_region_id'] != "" && $evntDetails['event_sub_region_id'] > 0) { echo ucwords($locationObj->fun_getRegionNameById($evntDetails['event_sub_region_id'])).", ";}  if($evntDetails['event_location_id'] != "" && $evntDetails['event_location_id'] > 0) { echo ucwords($locationObj->fun_getLocationNameById($evntDetails['event_location_id']));} ?>
                                                    </td>
                                                </tr>
                                                <?php
                                                }
                                                ?>
                                                <?php
                                                if(isset($evntDetails['event_price']) && ($evntDetails['event_price'] != "")) {
                                                ?>
                                                <tr>
                                                    <td><strong>Ticket prices</strong></td>
                                                    <td align="left" class="pad-lft20"><?php echo $evntDetails['event_price']; ?></td>
                                                </tr>
                                                <?php
                                                }
                                                ?>
                                                <?php
                                                if(isset($evntDetails['event_time']) && ($evntDetails['event_time'] != "")) {
                                                ?>
                                                <tr class="grayRow">
                                                    <td><strong>Times</strong></td>
                                                    <td align="left" class="pad-lft20"><?php echo $evntDetails['event_time']; ?></td>
                                                </tr>
                                                <?php
                                                }
                                                ?>
                                                <?php
                                                if(isset($evntDetails['event_phone']) && ($evntDetails['event_phone'] != "")) {
                                                ?>
                                                <tr>
                                                    <td><strong>Telephone</strong></td>
                                                    <td align="left" class="pad-lft20"><?php echo $evntDetails['event_phone']; ?></td>
                                                </tr>
                                                <?php
                                                }
                                                ?>
                                                <?php
                                                if(isset($evntDetails['event_website']) && ($evntDetails['event_website'] != "")) {
                                                ?>
                                                <tr class="grayRow">
                                                    <td><strong>Website</strong></td>
                                                    <td align="left" class="pad-lft20"><a href="<?php if(substr($evntDetails['event_website'], 0, 7) == "http://") { echo $evntDetails['event_website']; } else { echo "http://".$evntDetails['event_website']; } ?>" target="_blank" class="blue-link">Link to website</a></td>
                                                </tr>
                                                <?php
                                                }
                                                ?>
                                                <?php
                                                if(isset($evntDetails['event_email']) && ($evntDetails['event_email'] != "")) {
                                                ?>
                                                <tr>
                                                    <td><strong>Email</strong></td>
                                                    <td align="left" class="pad-lft20"><a class="blue-link" href="mailto:<?php echo $evntDetails['event_email']; ?>"><?php echo $evntDetails['event_email']; ?></a></td>
                                                </tr>
                                                <?php
                                                }
                                                ?>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td align="right" valign="top" class="pad-top20">
                                <?php require_once(SITE_INCLUDES_PATH.'holiday-events-view-right-links.php'); ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</div>
<!-- Main Wrapper End Here -->
<!-- Footer Include Starts Here -->
<div id="footer">
    <?php require_once(SITE_INCLUDES_PATH.'footer.php'); ?>
</div>
<!-- Footer Include End Here -->
</body>
</html>
