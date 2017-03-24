<table border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td valign="top">
            <ul>
                <li class="TabLeft">&nbsp;</li>
                <li class="SummaryTabUS"><a href="javascript:showSection(1);" title="Summary"><img src="images/Summary-US.gif" alt="Summary" border="0" /></a></li>
                <li class="PricesTabUS"><a href="javascript:showSection(2);" title="Prices"><img src="images/Prices-US.gif" alt="Prices" border="0" /></a></li>
                <li class="AvailabilityTabUS"><a href="javascript:showSection(3);" title="Availability"><img src="images/Availabilty-US.gif" alt="Availability" border="0" /></a></li>
                <li class="AccomoFacilitiesTabS"><a href="javascript:showSection(4);" title="AccomoFacilities"><img src="images/Acc-n-Facilities-S.gif" alt="AccomoFacilities" border="0" /></a></li>
                <li class="LocationTabUS"><a href="javascript:showSection(5);" title="Location"><img src="images/Location-US.gif" alt="Location" border="0" /></a></li>
                <li class="ReviewsTabUS"><a href="javascript:showSection(6);" title="Reviews"><img src="images/Reviews-US.gif" alt="Reviews" border="0" /><span class="VPTxt-UNS">(<?php if(is_array($propertyObj->fun_getPropertyReviewsArr($property_id))) {echo count($propertyObj->fun_getPropertyReviewsArr($property_id));} else { echo "0";} ?>)</span></a></li>
                <li class="AboutAreaTabUS"><a href="javascript:showSection(7);" title="AboutArea"><img src="images/About-Area-US.gif" alt="AboutArea" border="0" /></a></li>
                <li class="ContactOwnerTabUS"><a href="javascript:showSection(8);" title="ContactOwner"><img src="images/Contact-owner-US.gif" alt="ContactOwner" border="0" /></a></li>
                <li class="TabRight">&nbsp;</li>
            </ul>
        </td>
    </tr>
    <tr><td><img src="images/tab-top.gif" alt="Image" /></td></tr>
    <tr>
        <td valign="top" class="Tab-Bg">
            <table width="888" cellpadding="0" cellspacing="0" class="font12">
                <tr>
                    <td><img src="images/spacer.gif" alt="Image" width="24" height="20" /></td>
                    <td valign="Top" align="left">
                        <table width="405" cellspacing="0" cellpadding="0">
                            <tr><td colspan="2" class="pad-btm20"><div class="blackHeadtab">Accomodation &amp; Facilities</div></td></tr>
                            <tr>
                                <td>
									<?php
                                    $propertyObj->fun_createPropertyBedroom4PropertyPriview($property_id);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
									<?php
                                    $propertyObj->fun_createPropertyBathroom4PropertyPriview($property_id);
                                    ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td><img src="images/spacer.gif" alt="Summary" width="25" height="30" /></td>
                    <td valign="top">
                        <table width="100%" cellspacing="0" cellpadding="0">
                            <tr><td><img src="images/spacer.gif" alt="Summary" width="30" height="40" /></td></tr>
                            <tr>
                                <td>
									<?php
                                    $propertyObj->fun_createPropertyFacilities4PropertyPriview($property_id);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
									<?php
                                    $propertyObj->fun_createPropertySRequirements4PropertyPriview($property_id);
                                    ?>
                                </td>
                            </tr>
                        </table>
                    <td><img src="images/spacer.gif" alt="Summary" width="20" height="30" /></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr><td><img src="images/tab-bttm.gif" alt="Image" /></td></tr>
</table>
