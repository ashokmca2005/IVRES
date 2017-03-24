<?php
if($_SERVER["SERVER_NAME"] == "localhost") {
	require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/includes/application-top.php");
} else {
	require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
}

require_once(SITE_CLASSES_PATH."class.Users.php");
require_once(SITE_CLASSES_PATH."class.Event.php");
require_once(SITE_CLASSES_PATH."class.Pagination.php");
require_once(SITE_CLASSES_PATH."class.Location.php");
$dbObj = new DB();
$dbObj->fun_db_connect();

$eventObj 		= new Event();
$locationObj 	= new Location();

if(isset($_GET['ec']) && $_GET['ec'] !="") {
	$event_code 	= $_GET['ec'];

	$strList 		= $_GET['list'];
	$strListArr 	= explode("|", $strList);
	
//	print_r($strListArr);
	
//	echo $strList;
	
	if(is_array($strListArr) && count($strListArr) > 0) {
		for($i = 0; $i < count($strListArr); $i++) {
			if($strListArr[$i] == $event_code) {
				if(isset($strListArr[$i-1]) && $strListArr[$i-1] != "") {
					$previous = $strListArr[$i-1];
				} else {
					$previous = "";
				}

				if(isset($strListArr[$i+1]) && $strListArr[$i+1] != "") {
					$next = $strListArr[$i+1];
				} else {
					$next = "";
				}
			}
		}
	}

	$evntDetails	= $eventObj->fun_getEventDetailsByCode($event_code);
	if(is_array($evntDetails) && count($evntDetails) > 0) {
	?>
	<table width="450" border="0" cellspacing="0" cellpadding="0">
		<tr><td align="left" valign="top" class="pad-btm3 pad-top15"><h1 class="page-heading"><?php echo $evntDetails['event_name']; ?></h1></td></tr>
		<tr>
			<td align="left" valign="top">
				<table width="450" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td align="left" valign="top" class="pad-top10"><a href="javascript:void(0);" onclick="backToResult();" class="back">Back to results </a></td>
						<td align="right" valign="top" class="pad-top10 blue11">
                        <span>
                        <?php
							if(isset($previous) && $previous != "") {
								echo "<a href=\"javascript:void(0);\" onclick=\"shwEventDetails('".$previous."', '".$strList."');\" class=\"back\">Previous</a>";
							}
						?>
                        </span>
						<?php if(isset($previous) && $previous != "" && isset($next) && $next != "") { echo "|"; } ?>
                        <span>
                        <?php
							if(isset($next) && $next != "") {
								echo "<a href=\"javascript:void(0);\" onclick=\"shwEventDetails('".$next."', '".$strList."');\" class=\"next\">Next</a>";
							}
						?>
                        </span>
                        </td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td align="left" valign="top">
				<table width="450" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td align="left" valign="top" class="pad-top10">
							<table border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td align="left" valign="top">
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
												if(isset($evntDetails['event_img_by']) && ($evntDetails['event_img_by'] != "" && $evntDetails['event_img_by'] != "Photo By")) {
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
												<td valign="top" class="pad-btm20 pad-top10"><div class="pad-btm10"><?php echo $evntDetails['event_description']; ?></div></td>
											</tr>
											<tr>
												<td valign="top" class="pad-btm10"><span class="gray20">Information</span></td>
											</tr>
										</table>
									</td>
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
														$endDate 	= date('M d, Y', strtotime($evntDetails['event_end_date']));
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
                                            <td align="left" class="pad-lft20"><?php if($evntDetails['event_area_id'] != "" && $evntDetails['event_area_id'] > 0) { echo ucwords($locationObj->fun_getAreaNameById($evntDetails['event_area_id'])).", ";} if($evntDetails['event_region_id'] != "" && $evntDetails['event_region_id'] > 0) { echo ucwords($locationObj->fun_getRegionNameById($evntDetails['event_region_id'])).", ";} if($evntDetails['event_sub_region_id'] != "" && $evntDetails['event_sub_region_id'] > 0) { echo ucwords($locationObj->fun_getRegionNameById($evntDetails['event_sub_region_id'])).", ";}  if($evntDetails['event_location_id'] != "" && $evntDetails['event_location_id'] > 0) { echo ucwords($locationObj->fun_getLocationNameById($evntDetails['event_location_id']));} ?></td>
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
					<tr><td align="left" valign="top" class="dash25">&nbsp;</td></tr>
				</table>
			</td>
		</tr>
	</table>
	<?php
	}
}
?>
