<?php
	require_once(SITE_CLASSES_PATH."class.Calender.php");
	$calendarObj = new Calendar();
	
	$yearname 	= array(date('Y')+0,date('Y')+1,date('Y')+2,date('Y')+3);
	list($year1, $year2, $year3, $year4) = $yearname;
?>
<script language="javascript" type="text/javascript">

function showYear(str){
	var caldiv = "";
	var calli = "";
	for(var i=1; i<=4; i++){
		caldiv = "calendarsId"+i;
		calli = "strYearli"+i;
		if(i==str){
			document.getElementById(caldiv).style.display = "block";
			document.getElementById(calli).className = "CalendarLeftS";
		} else {
			document.getElementById(caldiv).style.display = "none";
			document.getElementById(calli).className = "CalendarRightNS";
		}
	}
}
</script>
<table border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td valign="top">
            <ul>
                <li class="TabLeft">&nbsp;</li>
                <li class="SummaryTabUS"><a href="javascript:showSection(1);" title="Summary"><img src="images/Summary-US.gif" alt="Summary" border="0" /></a></li>
                <li class="PricesTabUS"><a href="javascript:showSection(2);" title="Prices"><img src="images/Prices-US.gif" alt="Prices" border="0" /></a></li>
                <li class="AvailabilityTabS"><a href="javascript:showSection(3);" title="Availability"><img src="images/Availability-S.gif" alt="Availability" border="0" /></a></li>
                <li class="AccomoFacilitiesTabUS"><a href="javascript:showSection(4);" title="AccomoFacilities"><img src="images/Acco-n-Facilities-US.gif" alt="AccomoFacilities" border="0" /></a></li>
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
            <!-- property inner tabs : start here --> 
            <table width="888" cellpadding="0" cellspacing="0" class="font12 pad-btm8">
                <tr>
                    <td><img src="images/spacer.gif" alt="Image" width="24" height="20" /></td>
                    <td>
                        <div class="width843 pad-btm15">
                            <div class="blackHeadtab">Availability</div>
                        </div>
                        <div class="width843">
                            <ul>
                                <li class="calendar-li-left-1"><span class="black">Property added:</span> <?php echo date('F j, Y', strtotime($propertyObj->fun_getPropertyAddedDate($property_id)));?> <?php if($propertyObj->fun_getPropertyAvailablityUpdatedDate($property_id) !=""){ echo "<span class=\"pad-lft8 black\">Availability last updated:</span> ".getTimeLeft(time (), $propertyObj->fun_getPropertyAvailablityUpdatedDate($property_id))." ago "; }?></li>
                                <li class="CalendarLeftS" id="strYearli1"><a href="javascript:showYear(1);" title="<?php echo $year1;?>"><?php echo $year1;?></a></li>
                                <li class="CalendarRightNS" id="strYearli2"><a href="javascript:showYear(2);" title="<?php echo $year2;?>"><?php echo $year2;?></a></li>
                                <li class="CalendarRightNS" id="strYearli3"><a href="javascript:showYear(3);" title="<?php echo $year3;?>"><?php echo $year3;?></a></li>
                                <li class="CalendarRightNS" id="strYearli4"><a href="javascript:showYear(4);" style="width:58px;" title="<?php echo $year4;?>"><?php echo $year4;?></a></li>
                            </ul>
                        </div>
                        <div class="color-bar-1">
                            <p class="key">Key to colours</p>
                            <p class="available">Available</p>
                            <p class="booked">Booked</p>
                            <p class="special">Special deal</p>
                            <p class="unavailable">Unavailable</p>
                            <p class="unknown">Unknown</p>
                            <p class="changeover">Changeover days</p>
                            <p class="FloatLft black">Show me
                            <p class="FloatRgt pad-lft5">
                                <select name="" class="calender" style="width:148px;">
                                    <option>12 months availability</option>
                                </select>
                            </p>
                        </div>

                        <!-- THIS DIV IS FOR SHOW YEAR ONE CALENDAR START -->
                        <div class="calendar-tab" id="calendarsId1">
                            <?php
                                $propertyAvailInfoYear1 = $propertyObj->fun_getPropertyAvailabilityArr($property_id, $year1);
                                echo $calendarObj->getYearPropertyAvailablityHTML4Holiday($year1, $propertyAvailInfoYear1);
                            ?>
                        </div>
                        <!-- THIS DIV IS FOR SHOW YEAR ONE CALENDAR END -->
                        <!-- THIS DIV IS FOR SHOW YEAR TWO CALENDAR START -->
                        <div class="calendar-tab" id="calendarsId2" style="display:none;">
                            <?php
                                $propertyAvailInfoYear2 = $propertyObj->fun_getPropertyAvailabilityArr($property_id, $year2);
                                echo $calendarObj->getYearPropertyAvailablityHTML4Holiday($year2, $propertyAvailInfoYear2);
                            ?>
                        </div>
                        <!-- THIS DIV IS FOR SHOW YEAR TWO CALENDAR END -->
                        <!-- THIS DIV IS FOR SHOW YEAR THREE CALENDAR START -->
                        <div class="calendar-tab" id="calendarsId3"  style="display:none;">
                            <?php
                                $propertyAvailInfoYear3 = $propertyObj->fun_getPropertyAvailabilityArr($property_id, $year3);
                                echo $calendarObj->getYearPropertyAvailablityHTML4Holiday($year3, $propertyAvailInfoYear3);
                            ?>
                        </div>
                        <!-- THIS DIV IS FOR SHOW YEAR THREE CALENDAR END -->
                        <!-- THIS DIV IS FOR SHOW YEAR FOUR CALENDAR START -->
                        <div class="calendar-tab" id="calendarsId4" style="display:none;">
                            <?php
                                $propertyAvailInfoYear4 = $propertyObj->fun_getPropertyAvailabilityArr($property_id, $year4);
                                echo $calendarObj->getYearPropertyAvailablityHTML4Holiday($year4, $propertyAvailInfoYear4);
                            ?>
                        </div>
                        <!-- THIS DIV IS FOR SHOW YEAR FOUR CALENDAR END -->
                    </td>
                    <td><img src="images/spacer.gif" alt="Summary" width="22" height="30" /></td>
                  </tr>
                </table>
            <!-- property inner tabs : end here --> 
        </td>
    </tr>
    <tr><td><img src="images/tab-bttm.gif" alt="Image" /></td></tr>
</table>
