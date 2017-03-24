<table border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td valign="top">
            <ul>
                <li class="TabLeft">&nbsp;</li>
                <li class="SummaryTabS"><a href="javascript:showSection(1);" title="Summary"><img src="<?php echo SITE_IMAGES;?>Summary-S.gif" alt="Summary" border="0" /></a></li>
                <li class="PricesTabUS"><a href="javascript:showSection(2);" title="Prices"><img src="<?php echo SITE_IMAGES;?>Prices-US.gif" alt="Prices" border="0" /></a></li>
                <li class="AvailabilityTabUS"><a href="javascript:showSection(3);" title="Availability"><img src="<?php echo SITE_IMAGES;?>Availabilty-US.gif" alt="Availability" border="0" /></a></li>
                <li class="AccomoFacilitiesTabUS"><a href="javascript:showSection(4);" title="AccomoFacilities"><img src="<?php echo SITE_IMAGES;?>Acco-n-Facilities-US.gif" alt="AccomoFacilities" border="0" /></a></li>
                <li class="LocationTabUS"><a href="javascript:showSection(5);" title="Location"><img src="<?php echo SITE_IMAGES;?>Location-US.gif" alt="Location" border="0" /></a></li>
                <li class="ReviewsTabUS"><a href="javascript:showSection(6);" title="Reviews"><img src="<?php echo SITE_IMAGES;?>Reviews-US.gif" alt="Reviews" border="0" /><span class="VPTxt-UNS">(<?php if(is_array($propertyObj->fun_getPropertyReviewsArr($property_id))) {echo count($propertyObj->fun_getPropertyReviewsArr($property_id));} else { echo "0";} ?>)</span></a></li>
                <li class="AboutAreaTabUS"><a href="javascript:showSection(7);" title="AboutArea"><img src="<?php echo SITE_IMAGES;?>About-Area-US.gif" alt="AboutArea" border="0" /></a></li>
                <li class="ContactOwnerTabUS"><a href="javascript:showSection(8);" title="ContactOwner"><img src="<?php echo SITE_IMAGES;?>Contact-owner-US.gif" alt="ContactOwner" border="0" /></a></li>
                <li class="TabRight">&nbsp;</li>
            </ul>
        </td>
    </tr>
    <tr><td><img src="<?php echo SITE_IMAGES;?>tab-top.gif" alt="Image" /></td></tr>
    <tr>
        <td valign="top" class="Tab-Bg">
            <!-- property inner tabs : start here --> 
            <table width="888" cellpadding="0" cellspacing="0" class="font12">
                <tr>
                    <td><img src="<?php echo SITE_IMAGES;?>spacer.gif" alt="Image" width="24" height="20" /></td>
                    <td valign="top">
                        <table width="405" cellpadding="0" cellspacing="0">
                            <tr><td class="pad-btm15"><div class="blackHeadtab">Property Summary</div>
                            </td></tr>
                            <tr>
                                <td class="font12-line-height">
                                    <?php echo $strPropSBB;?><br />
                                    <?php echo $strPropPriceAvg;?><br />
                                    <?php echo $strPropType;?><br />
                                    <?php echo $strPropCaterType;?>
                                </td>
                            </tr>
                            <tr><td class="dash31">&nbsp;</td></tr>
                            <tr>
                                <td class="pad-btm5">
                                    <p class="FloatLft font11">Customer rating</p>
                                    <p class="FloatLft" style="padding-left:18px;"> <img src="<?php echo SITE_IMAGES;?>yellow-star.gif" alt="yellow star" /> <img src="<?php echo SITE_IMAGES;?>yellow-star.gif" alt="yellow star" /> <img src="<?php echo SITE_IMAGES;?>yellow-star.gif" alt="yellow star" /> <img src="<?php echo SITE_IMAGES;?>yellow-star-faded.gif" alt="yellow star" /> <img src="<?php echo SITE_IMAGES;?>yellow-star-faded.gif" alt="yellow star" /> </p>
                                    <p class="FloatLft pad-lft5 font11"><a href="#" class="blue-link">(32 reviews)</a></p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <?php
									if ( isset($rating) && $rating != "" ) {
                                    echo "<p class=\"FloatLft font11\">SA Tourism rating </p>";
                                    echo "<p class=\"FloatLft pad-lft8\">";
										for ( $i=0; $i < (int)$rating; $i++ ) {
											echo "<img src=\"".SITE_IMAGES."colored-star.gif\" alt=\"yellow star\" /> ";
										}
                                    echo "</p>";
									} else {
									
									}
									?>
                                </td>
                            </tr>
                            <tr><td class="dash31">&nbsp;</td></tr>
                            <tr>
                                <td><?php echo $property_description;?></td>
                            </tr>
                        </table>
                    </td>
                    <td><img src="<?php echo SITE_IMAGES;?>spacer.gif" alt="Summary" width="30" height="30" /></td>
                    <td valign="top">
                        <?php
                        $propertyObj->fun_createPropertyNeedToKnow($property_id);
                        ?>
                        <?php
                        $propertyObj->fun_createPropertyPropertyDistances($property_id);
                        ?>
                    </td>
                    <td><img src="<?php echo SITE_IMAGES;?>spacer.gif" alt="Summary" width="25" height="30" /></td>
                    <td valign="top">
                        <?php
                        $propertyObj->fun_createPropertyIsSuitable($property_id);
                        ?>
                        <?php
                        $propertyObj->fun_createPropertyHighlightView($property_id);
                        ?>
                    </td>
                    <td><img src="<?php echo SITE_IMAGES;?>spacer.gif" alt="Summary" width="20" height="30" /></td>
                </tr>
            </table>																		
            <!-- property inner tabs : end here --> 
        </td>
    </tr>
    <tr><td><img src="<?php echo SITE_IMAGES;?>tab-bttm.gif" alt="Image" /></td></tr>
</table>
