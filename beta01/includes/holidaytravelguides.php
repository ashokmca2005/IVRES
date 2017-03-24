<table width="100%" border="0" cellspacing="0" cellpadding="0" id="innerright">
        <td align="left" valign="top" class="font12 width690">
            <div id="showDetails">
				<?php
				if(isset($trvl_guid_id) && $trvl_guid_id !="") { // travel guide details section
					$tvlguidInfoArr = $tvlguidObj->fun_getTravelInfo($trvl_guid_id);
					if(is_array($tvlguidInfoArr) && count($tvlguidInfoArr) > 0) {
						$tvlguidMainImgInfoArr 	= $tvlguidObj->fun_getTravelMainImgInfo($trvl_guid_id);
						$tvlguidImgInfoArr 		= $tvlguidObj->fun_getTravelImgArr($trvl_guid_id);
					}
					if(is_array($tvlguidMainImgInfoArr) && count($tvlguidMainImgInfoArr) > 0) {
						$tvlguidMainPhotoId 		= $tvlguidMainImgInfoArr['photo_id'];
						$tvlguidMainPhoto 			= TVLGUID_IMAGES_LARGE449x341_PATH.$tvlguidMainImgInfoArr['photo_url'];
						$tvlguidMainPhotoCaption	= $tvlguidMainImgInfoArr['photo_caption'];
						$tvlguidMainPhotoBy			= $tvlguidMainImgInfoArr['photo_by'];
						$tvlguidMainPhotoLink		= $tvlguidMainImgInfoArr['photo_link'];
					} else {
						$tvlguidMainPhoto 			= "";
						$tvlguidMainPhotoCaption	= "";
						$tvlguidMainPhotoBy			= "";
						$tvlguidMainPhotoLink		= "";
					}
				?>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="395" align="left" valign="top">
                            <table width="395" border="0" cellspacing="0" cellpadding="0">
                                <tr><td colspan="2" align="left" valign="top"><h1 class="page-headingNew"><?php echo $tvlguidInfoArr['trvl_guid_title']; ?></h1></td></tr>
                                <tr>
                                    <td colspan="2" valign="top">
                                        <table width="395" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td colspan="2" align="left" valign="top" class="pad-top15">
                                                    <table border="0" cellpadding="0" cellspacing="0">
                                                        <tr>
                                                            <td align="left" valign="top">
                                                                <table border="0" cellpadding="0" cellspacing="0">
																	<?php
                                                                    if(isset($tvlguidMainPhoto) && $tvlguidMainPhoto !="") {
                                                                        echo "<tr>";
                                                                        echo "<td valign=\"top\" class=\"pad-btm8\">";
                                                                        echo "<img src=\"".$tvlguidMainPhoto."\" alt=\"".$tvlguidMainPhotoCaption."\" id=\"txtTvlGuidPhotoId\" width=\"690\" height=\"380\" />";
                                                                        echo "</td>";
                                                                        echo "</tr>";
																		
                                                                    }
                                                                    
                                                                    for( $i = 0; $i < count($tvlguidImgInfoArr); $i = $i+6) {
                                                                        $photoid_1 		= $tvlguidImgInfoArr[$i+0]['photo_id'];
                                                                        $photoid_2 		= $tvlguidImgInfoArr[$i+1]['photo_id'];
                                                                        $photoid_3 		= $tvlguidImgInfoArr[$i+2]['photo_id'];
                                                                        $photoid_4 		= $tvlguidImgInfoArr[$i+3]['photo_id'];
                                                                        $photoid_5 		= $tvlguidImgInfoArr[$i+4]['photo_id'];
                                                                        $photoid_6 		= $tvlguidImgInfoArr[$i+5]['photo_id'];
                                        
                                                                        echo "<tr><td class=\"pad-btm8\" valign=\"top\">";
                                                                        if( isset( $photoid_1 ) && $photoid_1 !="" ){
                                                                            $tvlguidthumbid= "tvlguidthumbid".$photoid_1;
                                                                            $photocap_1 	= trim(ucfirst($tvlguidImgInfoArr[$i+0]['photo_caption']));
																			$photoby_1 		= ucfirst($tvlguidImgInfoArr[$i+0]['photo_by']);
																			$photolink_1 	= $tvlguidImgInfoArr[$i+0]['photo_link'];
																			$photourl_1 	= TVLGUID_IMAGES_LARGE449x341_PATH.$tvlguidImgInfoArr[$i+0]['photo_url'];
                                                                            $photothumb_1 	= TVLGUID_IMAGES_THUMB168x127_PATH.$tvlguidImgInfoArr[$i+0]['photo_thumb'];
                                                                            echo "<span class=\"pad-left2\"><img src=\"".$photothumb_1."\" height=\"53\" width=\"69\" onclick=\"showPropImg('".$photourl_1."', '".$photocap_1."', '".$photoby_1."', '".$photolink_1."')\" style=\"cursor: pointer;\"></span>\n";
                                                                        }
                                                                        if( isset( $photoid_2 ) && $photoid_2 !="" ){
                                                                            $tvlguidthumbid= "tvlguidthumbid".$photoid_2;
                                                                            $photocap_2 	= trim(ucfirst($tvlguidImgInfoArr[$i+1]['photo_caption']));
																			$photoby_2 		= ucfirst($tvlguidImgInfoArr[$i+1]['photo_by']);
																			$photolink_2 	= $tvlguidImgInfoArr[$i+1]['photo_link'];
																			$photourl_2 	= TVLGUID_IMAGES_LARGE449x341_PATH.$tvlguidImgInfoArr[$i+1]['photo_url'];
                                                                            $photothumb_2 	= TVLGUID_IMAGES_THUMB168x127_PATH.$tvlguidImgInfoArr[$i+1]['photo_thumb'];
                                                                            echo "<span class=\"pad-left2\"><img src=\"".$photothumb_2."\" height=\"53\" width=\"69\" onclick=\"showPropImg('".$photourl_2."', '".$photocap_2."', '".$photoby_2."', '".$photolink_2."')\" style=\"cursor: pointer;\"></span>\n";
                                                                        }
                                                                        if( isset( $photoid_3 ) && $photoid_3 !="" ){
                                                                            $tvlguidthumbid= "tvlguidthumbid".$photoid_3;
                                                                            $photocap_3 	= trim(ucfirst($tvlguidImgInfoArr[$i+2]['photo_caption']));
																			$photoby_3 		= ucfirst($tvlguidImgInfoArr[$i+2]['photo_by']);
																			$photolink_3 	= $tvlguidImgInfoArr[$i+2]['photo_link'];
																			$photourl_3 	= TVLGUID_IMAGES_LARGE449x341_PATH.$tvlguidImgInfoArr[$i+2]['photo_url'];
                                                                            $photothumb_3 	= TVLGUID_IMAGES_THUMB168x127_PATH.$tvlguidImgInfoArr[$i+2]['photo_thumb'];
                                                                            echo "<span class=\"pad-left2\"><img src=\"".$photothumb_3."\" height=\"53\" width=\"69\" onclick=\"showPropImg('".$photourl_3."', '".$photocap_3."', '".$photoby_3."', '".$photolink_3."')\" style=\"cursor: pointer;\"></span>\n";
                                                                        }
                                                                        if( isset( $photoid_4 ) && $photoid_4 !="" ){
                                                                            $tvlguidthumbid= "tvlguidthumbid".$photoid_4;
                                                                            $photocap_4 	= trim(ucfirst($tvlguidImgInfoArr[$i+3]['photo_caption']));
																			$photoby_4 		= ucfirst($tvlguidImgInfoArr[$i+3]['photo_by']);
																			$photolink_4 	= $tvlguidImgInfoArr[$i+3]['photo_link'];
																			$photourl_4 	= TVLGUID_IMAGES_LARGE449x341_PATH.$tvlguidImgInfoArr[$i+3]['photo_url'];
                                                                            $photothumb_4 	= TVLGUID_IMAGES_THUMB168x127_PATH.$tvlguidImgInfoArr[$i+3]['photo_thumb'];
                                                                            echo "<span class=\"pad-left2\"><img src=\"".$photothumb_4."\" height=\"53\" width=\"69\" onclick=\"showPropImg('".$photourl_4."', '".$photocap_4."', '".$photoby_4."', '".$photolink_4."')\" style=\"cursor: pointer;\"></span>\n";
                                                                        }
                                                                        if( isset( $photoid_5 ) && $photoid_5 !="" ){
                                                                            $tvlguidthumbid= "tvlguidthumbid".$photoid_5;
                                                                            $photocap_5 	= trim(ucfirst($tvlguidImgInfoArr[$i+4]['photo_caption']));
																			$photoby_5 		= ucfirst($tvlguidImgInfoArr[$i+4]['photo_by']);
																			$photolink_5 	= $tvlguidImgInfoArr[$i+4]['photo_link'];
																			$photourl_5 	= TVLGUID_IMAGES_LARGE449x341_PATH.$tvlguidImgInfoArr[$i+4]['photo_url'];
                                                                            $photothumb_5 	= TVLGUID_IMAGES_THUMB168x127_PATH.$tvlguidImgInfoArr[$i+4]['photo_thumb'];
                                                                            echo "<span class=\"pad-left2\"><img src=\"".$photothumb_5."\" height=\"53\" width=\"69\" onclick=\"showPropImg('".$photourl_5."', '".$photocap_5."', '".$photoby_5."', '".$photolink_5."')\" style=\"cursor: pointer;\"></span>\n";
                                                                        }
                                                                        if( isset( $photoid_6 ) && $photoid_6 !="" ){
                                                                            $tvlguidthumbid= "tvlguidthumbid".$photoid_6;
                                                                            $photocap_6 	= trim(ucfirst($tvlguidImgInfoArr[$i+5]['photo_caption']));
																			$photoby_6 		= ucfirst($tvlguidImgInfoArr[$i+5]['photo_by']);
																			$photolink_6 	= $tvlguidImgInfoArr[$i+5]['photo_link'];
																			$photourl_6 	= TVLGUID_IMAGES_LARGE449x341_PATH.$tvlguidImgInfoArr[$i+5]['photo_url'];
                                                                            $photothumb_6 	= TVLGUID_IMAGES_THUMB168x127_PATH.$tvlguidImgInfoArr[$i+5]['photo_thumb'];
                                                                            echo "<span class=\"pad-left2\"><img src=\"".$photothumb_6."\" height=\"53\" width=\"69\" onclick=\"showPropImg('".$photourl_6."', '".$photocap_6."', '".$photoby_6."', '".$photolink_6."')\" style=\"cursor: pointer;\"></span>\n";
                                                                        }
                                                                        echo "</td></tr>";
                                                                    }
                            
                                                                    if(is_array($tvlguidImgInfoArr) && count($tvlguidImgInfoArr) > 0) {
                                                                        echo "<tr><td valign=\"top\">&nbsp;</td></tr>";
                                                                    }
                            
                                                                    if(isset($tvlguidInfoArr['trvl_guid_desc']) && $tvlguidInfoArr['trvl_guid_desc'] !="") {
                                                                     echo "<tr><td valign=\"top\" class=\"pad-btm20\">".$tvlguidInfoArr['trvl_guid_desc']."</td></tr>";
                                                                    }
																 ?>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        </td>
                    </tr>
                </table>
                <?php
				} else {
				?>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="395" align="left" valign="top">
                        <?php
						if(is_array($tvlCatInfoArr) && count($tvlCatInfoArr) > 0) { // travel guide list by category
						?>
                            <table width="395" border="0" cellspacing="0" cellpadding="0">
                                <tr><td colspan="2" align="left" valign="top" class="pad-btm10 pad-top20"><h1 class="page-heading"><?php echo ucfirst($tvlCatInfoArr['trvl_guid_categories_name']); ?></h1></td></tr>
                                <tr>
                                    <td colspan="2" align="left" valign="top">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
											<tr>
                                                <td colspan="2" align="left" valign="top" class="pad-top10">
                                                    <span class="pad-btm15"><?php echo ucfirst($tvlCatInfoArr['trvl_guid_categories_desc']); ?></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" align="left" valign="top" class="pad-top10">
                                                	<?php
													if(is_array($tvlInfoByCatArr) && count($tvlInfoByCatArr) > 0) {
														for($j = 0; $j < count($tvlInfoByCatArr); $j++) {
															$trvl_guid_id 				= $tvlInfoByCatArr[$j]['trvl_guid_id'];
															$trvl_guid_area_id 			= $tvlInfoByCatArr[$j]['trvl_guid_area_id'];
															$trvl_guid_region_id 		= $tvlInfoByCatArr[$j]['trvl_guid_region_id'];
															$trvl_guid_sub_region_id 	= $tvlInfoByCatArr[$j]['trvl_guid_sub_region_id'];
															$trvl_guid_location_id 		= $tvlInfoByCatArr[$j]['trvl_guid_location_id'];
															$trvl_guid_title 			= ucfirst($tvlInfoByCatArr[$j]['trvl_guid_title']);
															$trvl_guid_desc 			= substr(ucfirst($tvlInfoByCatArr[$j]['trvl_guid_desc']), 0, 450);
//															$trvl_guid_desc 			= ucfirst($tvlInfoByCatArr[$j]['trvl_guid_desc']);
															$tvlguidMainImgInfoArr 		= $tvlguidObj->fun_getTravelMainImgInfo($trvl_guid_id);
															if(is_array($tvlguidMainImgInfoArr) && count($tvlguidMainImgInfoArr) > 0) {
																$tvlguidMainPhotoId 	= $tvlguidMainImgInfoArr['photo_id'];
																$tvlguidMainPhoto	 	= TVLGUID_IMAGES_LARGE449x341_PATH.$tvlguidMainImgInfoArr['photo_url'];
//																$tvlguidMainPhotoThumb 	= TVLGUID_IMAGES_THUMB168x127_PATH.$tvlguidMainImgInfoArr['photo_thumb'];
																$tvlguidMainPhotoCaption= $tvlguidMainImgInfoArr['photo_caption'];
																$tvlguidMainPhotoBy		= $tvlguidMainImgInfoArr['photo_by'];
																$tvlguidMainPhotoLink	= $tvlguidMainImgInfoArr['photo_link'];
															} else {
																$tvlguidMainPhoto 		= "";
																$tvlguidMainPhotoCaption= "";
																$tvlguidMainPhotoBy		= "";
																$tvlguidMainPhotoLink	= "";
															}

															$trvlLocationArray = array();
															if($trvl_guid_area_id != "" && $trvl_guid_area_id > 0) {
																array_push($trvlLocationArray, ucfirst($locationObj->fun_getAreaNameById($trvl_guid_area_id)));
															}
															
															if($trvl_guid_region_id != "" && $trvl_guid_region_id > 0) {
																array_push($trvlLocationArray, ucfirst($locationObj->fun_getRegionNameById($trvl_guid_region_id)));
															}
															
															if($trvl_guid_sub_region_id != "" && $trvl_guid_sub_region_id > 0) {
																array_push($trvlLocationArray, ucfirst($locationObj->fun_getAreaNameById($trvl_guid_sub_region_id)));
															}
															
															if($trvl_guid_location_id != "" && $trvl_guid_location_id > 0) {
																array_push($trvlLocationArray, ucfirst($locationObj->fun_getLocationNameById($trvl_guid_location_id)));
															}
															
															if(count($trvlLocationArray) > 0) {
																$tvlguidLocation = "<strong>Location: </strong>";
																for($i = 0; $i < count($trvlLocationArray); $i++) {
																	$tvlguidLocation .= $trvlLocationArray[$i];
																	if($i < (count($trvlLocationArray)-1)) 
																		$tvlguidLocation .= ", ";
																}
																$tvlguidLocation = "<span  class=\"font11\">".$tvlguidLocation."</span>";
															}
														?>
															<table border="0" cellpadding="0" cellspacing="0">
																<tr>
																	<td align="left" valign="top">
																		<table border="0" cellpadding="0" cellspacing="0" class="listingTable">

                                                                            <tr><td valign="top" class="pad-top5"><h1 class="font18-darkgrey"><?php echo $trvl_guid_title; ?></h1></td></tr>
                                                                            <tr><td valign="top" class="pad-top20 pad-btm5"><img src="<?php echo $tvlguidMainPhoto; ?>" alt="<?php echo $tvlguidMainPhotoCaption; ?>" height="60" width="80" /></td></tr>
                                                                            <tr>
                                                                                <td valign=\"top\" class=\"pad-btm8\">
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                            	<td valign="top" class="pad-top20 pad-btm20">
                                                                                    <p><?php echo $trvl_guid_desc; ?> ... <a href="<?php echo SITE_URL."travel-guides/".replace_NonAlphaNumChars(strtolower($tvlCatInfoArr['trvl_guid_categories_name']))."/".replace_NonAlphaNumChars(strtolower($trvl_guid_title))."_".$trvl_guid_id; ?>">read more</a></p>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
																	</td>
																</tr>
                                                            </table>
														<?php
														}
													} else {
													?>
                                                    No travel guide found ...
                                                    <?php
													}
													?>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
						<?php
						} 
						?>
                        </td>
                    </tr>
                </table>
				<?php
				}
				?>
            </div>        
        </td>
        <td class="width22">&nbsp;</td>
    </tr>
</table>    
