<?php
$featureEventArr	= $eventObj->fun_getEventsFeatureArr(4);
if(is_array($featureEventArr) && count($featureEventArr) > 0) {
?>
<table width="210" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td align="right" valign="top">
            <table width="200" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <table width="180" border="0" align="right" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="center" class="pad-btm20 pad-top1"><span class="gray18"><?php echo tranText('featured_listings'); ?></span></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            	<?php
				$strEventDates = "";
				for($i = 0; $i < count($featureEventArr); $i++) {
					//thumbnails
					if($featureEventArr[$i]['event_thumb'] != "") {
                        $strEventImg 		= "<img src=\"".EVENT_IMAGES_THUMB168x127_PATH.$featureEventArr[$i]['event_thumb']."\" name=\"".$featureEventArr[$i]['event_name']."\" width=\"168\" height=\"127\" border=\"0\" />";
                        $strEventImgCaption = $featureEventArr[$i]['event_img_caption'];
					} else {
                        $strEventImg 		= "&nbsp;";
                        $strEventImgCaption = "";
                    }

					//Event date
					if($featureEventArr[$i]['event_year_around'] == "1") {
						$strEventDates = "All year round";
					} else {
						$startDate 	= date('M d, Y', strtotime($featureEventArr[$i]['event_start_date']));
						$endDate 	= date('M d, Y', strtotime($featureEventArr[$i]['event_end_date']));
						if($startDate == $endDate) {
							$strEventDates 	= $startDate;
						} else {
							$strEventDates 	= $startDate." - ".$endDate;
						}
					}

					//event category
					$strEventCategories = $eventObj->fun_getEventCatNameByCatIdsWithVBnRS($featureEventArr[$i]['event_cat_ids']);
				?>
                <tr>
                    <td <?php if($i > 0){ echo "class=\"pad-top15\""; } else { echo ""; } ?> >
                        <table width="180" border="0" align="right" cellpadding="0" cellspacing="0">
                            <tr><td align="right" class="pad-btm5"><a href="<?php echo SITE_URL; ?>excursion/index.php?event=<?php echo str_replace("&", "", str_replace(",", "_", str_replace(" ", "^", strtolower($featureEventArr[$i]['event_name'])))); ?>" style="text-decoration:none;"><?php echo $strEventImg; ?></a></td></tr>
                        	<?php
							echo  "<tr><td>";
							if(isset($strEventImgCaption) && $strEventImgCaption != "") {
								echo "<div id=\"txtEvntPhotoCaptionId".$i."\" class=\"font11 pad-lft15 FloatLft\">";
								echo "".ucfirst($strEventImgCaption)."</div>";
							}
							if(isset($featureEventArr[$i]['event_img_by']) && ($featureEventArr[$i]['event_img_by'] != "" && $featureEventArr[$i]['event_img_by'] != "Photo by")) {
								$evntPhotoLink	 = $featureEventArr[$i]['event_img_link'];
								if(($evntPhotoLink !="")) {
									if(substr($evntPhotoLink, 0, 7) == "http://") { 
										$evntPhotoLink = $evntPhotoLink; 
									} else { 
										$evntPhotoLink = "http://".$evntPhotoLink; 
									}
									echo "<div id=\"txtEvntPhotoById".$i."\" class=\"font10 FloatLft\"><a href=\"".$evntPhotoLink."\" style=\"text-decoration:none; color:#585858;\" target=\"_blank\">Photo by ".ucfirst($featureEventArr[$i]['event_img_by'])."</a></div>";
								} else {
									echo "<div id=\"txtEvntPhotoById".$i."\" class=\"font10 FloatLft\">Photo by ".ucfirst($featureEventArr[$i]['event_img_by'])."</div>";
								}
							}
							echo  "</td></tr>";

							?>
                            <tr>
                                <td valign="top" class="pad-top5 pad-lft15"><a href="<?php echo SITE_URL; ?>excursion/index.php?event=<?php echo str_replace("&", "", str_replace(",", "_", str_replace(" ", "^", strtolower($featureEventArr[$i]['event_name'])))); ?>" class="blue14" style="text-decoration:none;"><?php echo $featureEventArr[$i]['event_name']; ?></a></td>
                            </tr>
                            <tr>
                                <td class="font11 pad-lft15"><?php echo $strEventCategories; ?></td>
                            </tr>
                            <tr><td class="font11 pad-btm10 pad-lft15"><?php echo $strEventDates; ?></td></tr>
                        </table>
                    </td>
                </tr>
				<?php					
				}
				?>
            </table>
        </td>
    </tr>
</table>      
<?php
} else {
	echo "<table width=\"218\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tr><td align=\"left\" valign=\"top\">&nbsp;</td></tr></table>";
}
?>
