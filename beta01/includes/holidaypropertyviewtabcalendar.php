<?php
	//For availability
	$propertyAvailInfo 	= $propertyObj->fun_getPropertyAvailabilityArr($property_id);
	require_once(SITE_CLASSES_PATH."class.Calender.php");
	$calendarObj 		= new Calendar();
    $yearname 			= array(date('Y')+0,date('Y')+1,date('Y')+2,date('Y')+3);
	list($year1, $year2, $year3, $year4) = $yearname;
?>
<div id="tab_menu-1">
    <ul>
        <li><a href="#showSectionOverview" onclick="return showSection(1);" title="Description">Property details</a></li>
		<?php /*?>
        <li><a href="#showSectionPhotos" onclick="return showSection(2);" title="Photos">Photos</a></li>
		<?php */?>
        <li><a href="#showSectionLocation" onclick="return showSection(3);" title="Location">Location</a></li>
        <li><a href="#showSectionAbout" onclick="return showSection(4);" title="Amenities">Amenities</a></li>
        <li><a href="#showSectionCalendar" onclick="return showSection(5);" title="Availability" class="current">Availability</a></li>
        <li><a href="#showSectionPrice" onclick="return showSection(6);" title="Prices">Rates</a></li>
        <li><a href="#showSectionReview" onclick="return showSection(7);" title="Reviews">Reviews</a></li>
		<?php /*?>
        <li style="margin-right:0px; margin-left:6px;"><a href="<?php echo SITE_URL;?>property-owner-profile.php?pid=<?php echo $property_id;?>" title="Owner">Owner profile</a></li>
		<?php */?>
        <li style="margin-right:0px; margin-left:6px;"><a href="#showSectionOwner" onclick="return showSection(8);" title="Owner">Owner profile</a></li>
		<?php
        if($booking_on == true) {
        ?>
        <li><a href="javascript:void(0);" onclick="submitTripDuration('<?php echo $date_from;?>', <?php echo $date_to;?>)" title="Book Now" style="color:#e89c4e;">Book Now</a></li>
        <?php
        }
        ?>
    </ul>
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td valign="top" width="100%" class="pad-top10">
            <div class="calendars">
                <div class="FloatLft pad-top5">
                    <p class="key"><?php echo tranText('view'); ?></p>
                    <span>
                    <select name="strShowYear" id="strShowYearId" onchange="showYear(this.value);" class="Listmenu70 FloatLft">
                        <option value="1"><?php echo $year1; ?></option>
                        <option value="2"><?php echo $year2; ?></option>
                        <option value="3"><?php echo $year3; ?></option>
                        <option value="4"><?php echo $year4; ?></option>
                    </select> 
                    </span>
                </div>
                <div class="FloatLft pad-lft10 pad-top5 pad-btm5">
                    <p class="key"><?php echo tranText('key'); ?></p>
                    <p class="available"><?php echo tranText('available'); ?></p>
                    <p class="booked"><?php echo tranText('booked'); ?></p>
                    <p class="unavailable"><?php echo tranText('unknown_unavailable'); ?></p>
                </div>
            </div>
            <div class="clearfix"></div>
            <!-- THIS DIV IS FOR SHOW YEAR ONE CALENDAR START -->
            <div class="calendars" id="calendarsId1" style="margin:0px auto;">
                <?php echo $calendarObj->getYearPropertyAvailablityHTML4Holiday($year1, $propertyAvailInfo); ?>
            </div>
            <!-- THIS DIV IS FOR SHOW YEAR ONE CALENDAR END -->
            <!-- THIS DIV IS FOR SHOW YEAR TWO CALENDAR START -->
            <div class="calendars" id="calendarsId2" style="display:none; margin:0px auto;">
                <?php echo $calendarObj->getYearPropertyAvailablityHTML4Holiday($year2, $propertyAvailInfo); ?>
            </div>
            <!-- THIS DIV IS FOR SHOW YEAR TWO CALENDAR END -->
            <!-- THIS DIV IS FOR SHOW YEAR THREE CALENDAR START -->
            <div class="calendars" id="calendarsId3" style="display:none; margin:0px auto;">
                <?php echo $calendarObj->getYearPropertyAvailablityHTML4Holiday($year3, $propertyAvailInfo); ?>
            </div>
            <!-- THIS DIV IS FOR SHOW YEAR THREE CALENDAR END -->
            <!-- THIS DIV IS FOR SHOW YEAR FOUR CALENDAR START -->
            <div class="calendars" id="calendarsId4" style="display:none; margin:0px auto;">
                <?php echo $calendarObj->getYearPropertyAvailablityHTML4Holiday($year4, $propertyAvailInfo); ?>
            </div>
            <!-- THIS DIV IS FOR SHOW YEAR FOUR CALENDAR END -->
            <div class="clearfix"></div>
        </td>
    </tr>
</table>
