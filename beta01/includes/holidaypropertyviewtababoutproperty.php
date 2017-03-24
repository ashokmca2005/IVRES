<div id="tab_menu-1">
    <ul>
        <li><a href="#showSectionOverview" onclick="return showSection(1);" title="Description">Property details</a></li>
		<?php /*?>
        <li><a href="#showSectionPhotos" onclick="return showSection(2);" title="Photos">Photos</a></li>
		<?php */?>
        <li><a href="#showSectionLocation" onclick="return showSection(3);" title="Location">Location</a></li>
        <li><a href="#showSectionAbout" onclick="return showSection(4);" title="Amenities" class="current">Amenities</a></li>
        <li><a href="#showSectionCalendar" onclick="return showSection(5);" title="Availability">Availability</a></li>
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
<div style="width:628px; height:auto; margin-top:10px; border:thin #D8E7F2 solid;">
	<?php $propertyObj->fun_createPropertyAmenities4PropertyPreview($property_id); ?>
    <div class="clearfix"></div>
</div>
