<script language="javascript" type="text/javascript">
	var http = new XMLHttpRequest();
	function cancelAddEvent(strEventTmpId){
		http.onreadystatechange = handleDeleteTmpResponse;
		http.open('get', '<?php echo SITE_URL;?>eventtmpdeleteXml.php?evtid='+strEventTmpId); 
		http.send(null);   
	}

	function handleDeleteTmpResponse(){
		var arrayOfEventStatus 	= new Array();
		if(http.readyState == 4){
			var response=http.responseText;
			xmlDoc=http.responseXML;
			var root = xmlDoc.getElementsByTagName('events')[0];
			if(root != null){
				var items = root.getElementsByTagName("event");
				for (var i = 0 ; i < items.length ; i++){
					var item 				= items[i];
					var eventstatus 		= item.getElementsByTagName("eventstatus")[0].firstChild.nodeValue;
					arrayOfEventStatus[i] 	= eventstatus;
					if(arrayOfEventStatus[i] == "Event deleted."){
						window.location = 'holiday-events-add.php';
					}
				}
			}
		}
	}

</script>

<table width="974" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td class="width18">&nbsp;</td>
        <td align="left" valign="top" class="width210 dash-right">
			<?php require_once(SITE_INCLUDES_PATH.'holiday-events-view-left-links.php'); ?>
        </td>
        <td align="left" valign="top" class="width26">&nbsp;</td>
        <td align="left" valign="top" class="font12 width690">
            <div id="showDetails">
				<form name="frmAddEvent" id="frmAddEvent" action="<?php echo SITE_URL;?>holiday-events-preview.php" method="post">
				<input type="hidden" name="securityKey" value="<?php echo md5("ADDEVENTCONFIRM")?>">
				<input type="hidden" name="txtEventId" value="<?php echo $eventInfoArr['event_id']; ?>">
				<table width="690" border="0" cellspacing="0" cellpadding="0" id="showRefineMapId" style="display:block;">
					<tr>
						<td  colspan="2" align="left" valign="top" class="pad-btm15 pad-top20"><h1 class="page-heading">Preview</h1></td>
					</tr>
					<tr>
						<td colspan="2" align="left" valign="top">
							<table width="450" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td align="left" valign="top" class="pad-top10">
										This is how your full listing will appear, please read and check it carefully<br />
										before confirming it&rsquo;s okay.
									</td>
								</tr>
								<tr>
									<td align="left" valign="top" class="grey-txt14 pad-btm15 pad-top15">Once it&rsquo;s live on the site you will not be able to change it !</td>
								</tr>
								<tr>
									<td align="left" valign="top">
										Please note that listings will automatically be removed on the last day of the<br />
										event. In the event that the listing is an &lsquo;all year round&rsquo; event then you will need to<br />
										contact us if there is a change to the information.
									</td>
								</tr>
								<tr><td align="left" valign="top" class="dash31">&nbsp;</td></tr>
								<tr>
                                    <td align="left" valign="top" class="pad-top10"><h1 class="page-heading"><?php echo fun_db_output($eventInfoArr['event_name']); ?></h1></td>
                                </tr>
                                <tr>
                                    <td align="left" valign="top" class="font11 pad-btm10 pad-top5"><div style="line-height:16px;"><?php echo fun_db_output($eventObj->fun_getEventCatNameByCatIdsWithVBnRSTmp($eventInfoArr['event_cat_ids'])); ?></div></td>
                                </tr>
								<tr>
									<td align="left" valign="top">
										<table width="450" border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td align="left" valign="top" class="pad-top15">
													<table border="0" cellpadding="0" cellspacing="0">
														<tr>
															<td align="left" valign="top">
																<table border="0" cellpadding="0" cellspacing="0">
                                                                	<?php if(isset($eventInfoArr['event_img']) && $eventInfoArr['event_img'] != "") {
																	?>
                                                                    <tr><td valign="top" class="pad-btm8"><img src="<?php if(isset($eventInfoArr['event_img']) && $eventInfoArr['event_img'] != "") { echo EVENT_IMAGES_LARGE449x341_PATH.$eventInfoArr['event_img']; } else { echo EVENT_IMAGES_LARGE449x341_PATH."no-image.gif"; } ?>" alt="<?php if(isset($eventInfoArr['event_img_caption']) && $eventInfoArr['event_img_caption'] != "" && $eventInfoArr['event_img_caption'] != "Add caption for image ... Leave blank if not required") { echo $eventInfoArr['event_img_caption'];} ?>" width="449" height="341" /></td></tr>
                                                                    <tr><td valign="top" class="pad-btm8"><div id="txtEvntPhotoCaptionId" class="font10 FloatLft"><?php if(isset($eventInfoArr['event_img_caption']) && $eventInfoArr['event_img_caption'] != "" && $eventInfoArr['event_img_caption'] != "Add caption for image ... Leave blank if not required") { echo $eventInfoArr['event_img_caption'];} ?></div></td></tr>
                                                                    <?php
																	} else {
																	?>
                                                                    <tr><td valign="top" class="pad-btm8"><img src="<?php echo EVENT_IMAGES_LARGE449x341_PATH."no-image.gif"; ?>" alt="no image" width="449" height="341" /></td></tr>
                                                                    <?php
																	}
																	?>
                                                                    <tr><td valign="top" class="pad-btm20"><div><?php echo fun_db_output($eventInfoArr['event_description']); ?></div></td></tr>
                                                                    <tr><td valign="top" class="pad-btm10"><span class="gray20">Information</span></td></tr>
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
                                                            if((isset($eventInfoArr['event_start_date']) && ($eventInfoArr['event_start_date'] != "") && isset($eventInfoArr['event_end_date']) && ($eventInfoArr['event_end_date'] != "")) || (isset($eventInfoArr['event_year_around']) && ($eventInfoArr['event_year_around'] != ""))) {
                                                            ?>
                                                                <tr class="grayRow">
                                                                    <td width="87"><strong>Dates</strong></td>
                                                                    <td width="364" align="left" class="pad-lft20">
                                                                        <strong>
                                                                        <?php 
                                                                            if($eventInfoArr['event_year_around'] == "1") {
                                                                                echo "All year round";
                                                                            } else {
																				if(date('M d, Y', strtotime($eventInfoArr['event_start_date'])) == date('M d, Y', strtotime($eventInfoArr['event_end_date']))) {
																					echo date('M d, Y', strtotime($eventInfoArr['event_start_date'])); 
																				} else {
																					echo date('M d, Y', strtotime($eventInfoArr['event_start_date']))." - ".date('M d, Y', strtotime($eventInfoArr['event_end_date'])); 
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
                                                            if(isset($eventInfoArr['event_venue']) && ($eventInfoArr['event_venue'] != "")) {
                                                            ?>
                                                                <tr>
                                                                    <td><strong>Venue</strong></td>
                                                                    <td align="left" class="pad-lft20"><?php echo fun_db_output($eventInfoArr['event_venue']); ?></td>
                                                                </tr>
                                                            <?php
                                                            }
                                                        ?>
                                                        <?php
                                                            if(isset($eventInfoArr['event_area_id']) && ($eventInfoArr['event_area_id'] != "") || isset($eventInfoArr['event_region_id']) && ($eventInfoArr['event_region_id'] != "") || isset($eventInfoArr['event_sub_region_id']) && ($eventInfoArr['event_sub_region_id'] != "") || isset($eventInfoArr['event_location_id']) && ($eventInfoArr['event_location_id'] != "")) {
                                                            ?>
                                                                <tr class="grayRow">
                                                                    <td><strong>Location</strong></td>
                                                                    <td align="left" class="pad-lft20">
																		<?php
                                                                        $locationArr = array();
                                                                        if($eventInfoArr['event_area_id'] != "" && $eventInfoArr['event_area_id'] > 0) {
                                                                            array_push($locationArr, ucfirst($locationObj->fun_getAreaNameById($eventInfoArr['event_area_id'])));
                                                                        }
                                                                        if($eventInfoArr['event_region_id'] != "" && $eventInfoArr['event_region_id'] > 0) {
                                                                            array_push($locationArr, ucfirst($locationObj->fun_getRegionNameById($eventInfoArr['event_region_id'])));
                                                                        }
                                                                        if($eventInfoArr['event_sub_region_id'] != "" && $eventInfoArr['event_sub_region_id'] > 0) {
                                                                            array_push($locationArr, ucfirst($locationObj->fun_getRegionNameById($eventInfoArr['event_sub_region_id'])));
                                                                        }
                                                                        if($eventInfoArr['event_location_id'] != "" && $eventInfoArr['event_location_id'] > 0) {
                                                                            array_push($locationArr, ucfirst($locationObj->fun_getLocationNameById($eventInfoArr['event_location_id'])));
                                                                        }
                                                                        $strLocation = implode(", ", $locationArr);
                                                                        echo $strLocation;
                                                                        ?>
                                                                    </td>
                                                                </tr>
                                                            <?php
                                                            }
                                                        ?>
                                                        <?php
                                                            if(isset($eventInfoArr['event_price']) && ($eventInfoArr['event_price'] != "")) {
                                                            ?>
                                                                <tr>
                                                                    <td><strong>Ticket prices</strong></td>
                                                                    <td align="left" class="pad-lft20"><?php echo fun_db_output($eventInfoArr['event_price']); ?></td>
                                                                </tr>
                                                            <?php
                                                            }
                                                        ?>
                                                        <?php
                                                            if(isset($eventInfoArr['event_time']) && ($eventInfoArr['event_time'] != "")) {
                                                            ?>
                                                                <tr class="grayRow">
                                                                    <td><strong>Times</strong></td>
                                                                    <td align="left" class="pad-lft20"><?php echo fun_db_output($eventInfoArr['event_time']); ?></td>
                                                                </tr>
                                                            <?php
                                                            }
                                                        ?>
                                                        <?php
                                                            if(isset($eventInfoArr['event_phone']) && ($eventInfoArr['event_phone'] != "")) {
                                                            ?>
                                                                <tr>
                                                                    <td><strong>Telephone</strong></td>
                                                                    <td align="left" class="pad-lft20"><?php echo $eventInfoArr['event_phone']; ?></td>
                                                                </tr>
                                                            <?php
                                                            }
                                                        ?>
                                                        <?php
                                                            if(isset($eventInfoArr['event_website']) && ($eventInfoArr['event_website'] != "")) {
                                                            ?>
                                                                <tr class="grayRow">
                                                                    <td><strong>Website</strong></td>
                                                                    <td align="left" class="pad-lft20"><a href="<?php if(substr($eventInfoArr['event_website'], 0, 7) == "http://") { echo $eventInfoArr['event_website']; } else { echo "http://".$eventInfoArr['event_website']; } ?>" target="_blank" class="blue-link"><?php echo $eventInfoArr['event_website']; ?></a></td>
                                                                </tr>
                                                            <?php
                                                            }
                                                        ?>
                                                        <?php
                                                            if(isset($eventInfoArr['event_email']) && ($eventInfoArr['event_email'] != "")) {
                                                            ?>
                                                                <tr>
                                                                    <td><strong>Email</strong></td>
                                                                    <td align="left" class="pad-lft20"><a class="blue-link" href="mailto:<?php echo $eventInfoArr['event_email']; ?>"><?php echo $eventInfoArr['event_email']; ?></a></td>
                                                                </tr>
                                                            <?php
                                                            }
                                                        ?>
													</table>
												</td>
											</tr>
											<tr><td align="left" valign="top" class="dash31">&nbsp;</td></tr>
											<tr>
												<td align="left" valign="top" class="pad-top3" style="padding-left:95px;">
                                                    <span><a href="#" onclick="toggleLayer1('add-event-cancel-pop'); return false;"><img src="<?php echo SITE_IMAGES;?>cancel-gray.gif" alt="cancel" border="0" /></a></span>
                                                    <span class="pad-lft10"><a href="<?php echo SITE_URL;?>holiday-events-add.php" style="text-decoration:none;"><img src="<?php echo SITE_IMAGES;?>editnew-gray.gif" alt="edit" border="0" /></a></span>
                                                    <span class="pad-lft10"><input src="<?php echo SITE_IMAGES;?>confirm.gif" onclick="frmValidateAddEvent();" alt="Update" type="image"></span>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
                    <tr>
                        <td colspan="2" align="left" valign="top">
                            <div id="add-event-cancel-pop" class="box cursor1" style="display:none; position:absolute; left:285px; top:1140px;">
                            <!--[if IE]><iframe id="iframe" frameborder="0" style="position:absolute;top:3px;left:3px;width:445px; height:118px;"></iframe><![endif]-->
                            <div class="content">
                            <div onMouseDown="dragStart(event, 'add-event-cancel-pop');" style="position:relative; z-index:999;left:0px;width:250px;height:158px;">
                            <table width="300" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td align="right"><img src="<?php echo SITE_IMAGES;?>poplefttop.png" alt="ANP" /></td>
                                    <td class="topp"></td>
                                    <td><img src="<?php echo SITE_IMAGES;?>poprighttop1.png" alt="ANP" /></td>
                                </tr>
                                <tr>
                                    <td class="leftp"></td>
                                    <td align="left" valign="top" bgcolor="#FFFFFF" style="padding:12px;"> 
                                        <table border="0" cellspacing="0" cellpadding="0" width="100%">
                                            <tr>
                                                <td align="left" valign="top"><span class="pink16">Are you sure ?</span></td>
                                                <td width="15" align="right" valign="top"><a href="javascript:toggleLayer1('add-event-cancel-pop');"><img src="<?php echo SITE_IMAGES;?>pop-up-cross.gif" alt="Close" title="Close" border="0" /></a></td>
                                            </tr>
                                            <tr>
                                                <td  align="left" valign="top" class="PopTxt">
                                                    <table width="98%" border="0" cellpadding="0" cellspacing="0">
                                                        <tr><td class="pad-rgt10 pad-top5">You will not be able to retrieve this information once you delete it</td></tr>
                                                        <tr><td height="10"></td></tr>
                                                        <tr>
                                                            <td class="pad-top10">
                                                                <div class="FloatLft"><a href="javascript:toggleLayer1('add-event-cancel-pop');"><img src="<?php echo SITE_IMAGES;?>cancel-gray.gif" alt="Keep it" /></a></div>
                                                                <div class="FloatRgt pad-lft5"><a href="javascript:cancelAddEvent('<?php echo $eventInfoArr['event_id']; ?>');"><img src="<?php echo SITE_IMAGES;?>deletenow.gif" alt="Cancel it" /></a></div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td  align="left" valign="top" class="PopTxt">&nbsp;</td>
                                            </tr>
                                        </table>                               
                                    </td>
                                    <td class="rightp" width="15"></td>
                                </tr>
                                <tr>
                                    <td align="right"><img src="<?php echo SITE_IMAGES;?>popleftbtm.png" alt="ANP" /></td>
                                    <td  class="bottomp"></td>
                                    <td align="left"><img src="<?php echo SITE_IMAGES;?>poprightbtm1.png" alt="ANP"/></td>
                                </tr>
                            </table>
                            </div>
                            </div>
                            </div>
                        </td>
                    </tr>
				</table>
				</form>
            </div>        
        </td>
        <td class="width22">&nbsp;</td>
    </tr>
</table>    
