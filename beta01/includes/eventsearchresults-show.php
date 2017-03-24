<?php	
	if($_SERVER["SERVER_NAME"] == "localhost") {
		require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/includes/application-top.php");
	} else {
		require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
	}
	require_once(SITE_CLASSES_PATH."class.Users.php");
	require_once(SITE_CLASSES_PATH."class.Event.php");
	require_once(SITE_CLASSES_PATH."class.Property.php");
	require_once(SITE_CLASSES_PATH."class.Pagination.php");
	require_once(SITE_CLASSES_PATH."class.CMS.php");
	$eventObj 		= new Event();
	$propertyObj 	= new Property();
	$usersObj 		= new Users();
	$cmsObj         = new Cms();
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td align="left" valign="top">
            <?php
            if(is_array($evntDetails) && count($evntDetails) > 0) {
            ?>
            <table width="450" border="0" cellspacing="0" cellpadding="0">
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
            <?php
            } else{
            ?>
        	<div id="eventDetailsDivId" style="display:none;"></div>
        	<div id="eventsLisitingDivId" style="display:block;">
            <table width="450" border="0" cellspacing="0" cellpadding="0" style="padding-left:20px;">
                <tr><td align="left" valign="top" class="pad-btm10"><?php echo tranText('site_notes_event_listing'); ?></td></tr>
                <tr>
                    <td align="left" valign="top" class="pad-btm10 pad-top25">
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td class="paging dash-btm pad-btm10 pad-left2" align="left" valign="top"><strong><?php if(isset($pagination['total_rows']) && $pagination['total_rows'] > 1) { echo $pagination['total_rows']." Results";} else if(isset($pagination['total_rows']) && $pagination['total_rows'] == 1){echo $pagination['total_rows']." Result";} ?> </strong></td>
                                <td class="paging dash-btm pad-btm10 pad-left2" align="right" valign="top">
                                <?php
                                if(isset($pagination['pages']) && $pagination['pages'] != "") {
                                    if(isset($pagination['prev']) && $pagination['prev'] !="") {
                                        echo "<a href=\"".$pagination['prev']."\" class=\"previous\">Previous</a>";
                                    }
									if(($pagination['pages'][0]['no']) > 1) {
										echo "<span>...</span>";
									}
                                    foreach($pagination['pages'] as $key => $value) {
                                        if(isset($value['link']) && $value['link'] != "") {
                                            echo "<a href=\"".$value['link']."\">".($value['no'])."</a>";
                                        } else {
                                            echo "<span>".($value['no'])."</span>";
                                        }
                                    }
									if(($pagination['pages'][count($pagination['pages'])-1]['no']) < ($pagination['total_rows']/GLOBAL_RECORDS_PER_PAGE)) {
										echo "<span>...</span>";
									}
                                    if(isset($pagination['next']) && $pagination['next'] !="") {
                                        echo "<a href=\"".$pagination['next']."\" class=\"next\">Next</a>";
                                    }
                                } else {
                                    echo "&nbsp;";
                                }
                                ?>
                                </td>
                            </tr>                
                        </table>
                    </td>
                </tr>
                <tr>
                    <td align="left" valign="top">
                        <table width="400" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td align="left" valign="top" class="pad-top5">
                                    <table border="0" cellpadding="0" cellspacing="0">
                                        <?php
                                        if(count($evntListArr) > 0) {
                                            $strEvntCodeList = "";
                                            foreach($evntListArr as $key => $value) {
                                                $strEvntCodeList .= "|".$value['event_code'];
                                            }
                                            $strEvntCodeList 	= substr($strEvntCodeList, 1, strlen($strEvntCodeList));

                                            for($i = 0; $i < count($evntListArr); $i++) {
                                                //Event date
                                                if($evntListArr[$i]['event_year_around'] == "1") {
                                                    $strEventDates = "All year round";
                                                } else {
                                                    $startDate 	= date('M d, Y', strtotime($evntListArr[$i]['event_start_date']));
                                                    $endDate 		= date('M d, Y', strtotime($evntListArr[$i]['event_end_date']));
                                                    if($startDate == $endDate) {
                                                        $strEventDates 		= $startDate;
                                                    } else {
                                                        $strEventDates 		= $startDate." - ".$endDate;
                                                    }
                                                }

                                                //event category
                                                $strEventCategories = $eventObj->fun_getEventCatNameByCatIdsWithVBnRS($evntListArr[$i]['event_cat_ids']);

                                                echo "<tr>";
                                                echo "<td valign=\"top\">";
                                                echo "<table  border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\" class=\"font12\">";
                                                echo "<tr><td align=\"left\" valign=\"top\" class=\"blue20\"><a href=\"javascript:void(0);\" onclick=\"shwEventDetails('".$evntListArr[$i]['event_code']."', '".$strEvntCodeList."');\" class=\"blue20\" style=\"text-decoration:none;\">".$evntListArr[$i]['event_name']."</a></td></tr>";
                                                echo "<tr>";
                                                echo "<td align=\"left\" valign=\"top\" class=\"font11 pad-btm10 pad-top5\">";
                                                echo "<div style=\"line-height:16px;\">".$strEventCategories."<br />".$strEventDates."</div>";
                                                echo "</td>";
                                                echo "</tr>";
                                                echo "<tr>";
                                                echo "<td align=\"left\" valign=\"top\" class=\"pad-btm5\">".substr($evntListArr[$i]['event_description'], 0, 300)." ... <a href=\"javascript:void(0);\" onclick=\"shwEventDetails('".$evntListArr[$i]['event_code']."', '".$strEvntCodeList."');\" class=\"blue-link\">read more</a></td>";
                                                echo "</tr>";

/*
                                                echo "<tr>";
                                                echo "<td align=\"left\" valign=\"top\" class=\"pad-btm5\"><a href=\"javascript:void(0);\" onclick=\"shwEventDetails('".$evntListArr[$i]['event_code']."', '".$strEvntCodeList."');\" class=\"blue-link\">View more details</a></td>";
                                                echo "</tr>";
*/
                                                echo "<tr><td class=\"dash25\">&nbsp;</td></tr>";
                                                echo "<tr><td><img src=\"".SITE_IMAGES."spacer.gif\" width=\"30\" height=\"10\" /></td></tr>";
                                                echo "</table>";
                                                echo "</td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "No event found!";
                                        }
                                        ?>
                                    </table>
                                </td>
                            </tr>
                            <!-- Details Row Start Here -->
                            <tr>
                                <td align="right" valign="top" class="paging  pad-btm10 pad-left2">
                                    <?php
                                    if(isset($pagination['pages']) && $pagination['pages'] != "") {
                                        if(isset($pagination['prev']) && $pagination['prev'] !="") {
                                            echo "<a href=\"".$pagination['prev']."\" class=\"previous\">Previous</a>";
                                        }
                                        if(($pagination['pages'][0]['no']) > 1) {
                                            echo "<span>...</span>";
                                        }
                                        foreach($pagination['pages'] as $key => $value) {
                                            if(isset($value['link']) && $value['link'] != "") {
                                                echo "<a href=\"".$value['link']."\">".($value['no'])."</a>";
                                            } else {
                                                echo "<span>".($value['no'])."</span>";
                                            }
                                        }
                                        if(($pagination['pages'][count($pagination['pages'])-1]['no']) < ($pagination['total_rows']/GLOBAL_RECORDS_PER_PAGE)) {
                                            echo "<span>...</span>";
                                        }
                                        if(isset($pagination['next']) && $pagination['next'] !="") {
                                            echo "<a href=\"".$pagination['next']."\" class=\"next\">Next</a>";
                                        }
                                    } else {
                                        echo "&nbsp;";
                                    }
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            </div>
            <?php
            }
            ?>
        </td>
        <td align="right" valign="top">
            <?php require_once(SITE_INCLUDES_PATH.'holiday-events-view-right-links.php'); ?>
        </td>
    </tr>
</table>        
