<?php
if($propertyInfo['latitude'] !="" && $propertyInfo['longitude'] !="") {
	$propertyLatitude 	= $propertyInfo['latitude'];
	$propertyLongitude 	= $propertyInfo['longitude'];
	$mapZoomLevel 		= $propertyInfo['map_zoom_level'];
} else {
	$propertyLatitude 	= "38.886757140695906";
	$propertyLongitude 	= "22.3187255859375";
	$mapZoomLevel 		= 8;
}
?>
<div id="tab_menu-1">
    <ul>
        <li><a href="#showSectionOverview" onclick="return showSection(1);" title="Description">Property details</a></li>
		<?php /*?>
        <li><a href="#showSectionPhotos" onclick="return showSection(2);" title="Photos">Photos</a></li>
		<?php */?>
        <li><a href="#showSectionLocation" onclick="return showSection(3);" title="Location" class="current">Location</a></li>
        <li><a href="#showSectionAbout" onclick="return showSection(4);" title="Amenities">Amenities</a></li>
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
<table border="0" align="left" cellpadding="0" cellspacing="0"  width="100%">
    <tr>
        <td valign="top" class="pad-top5 pad-btm10">
                <iframe src="<?php echo SITE_URL; ?>google-map-property.php?pid=<?php echo $property_id;?>" width="406px" height="404px" style="overflow:hidden;border:none; margin-left:0px;" scrolling="no"></iframe>
                <?php
                //$propertyObj->fun_createPropertyLocationMap4PropertyPriview($property_id);
                ?>
        </td>
    </tr>
    <tr><td valign="top"><?php $propertyObj->fun_createPropertyLandmarks4PropertyPriview($property_id); ?></td></tr>
</table>
<?php /*?>
<!-- Map code: Start here -->
<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
	var map;
	var strlatitude = <?php if(isset($propertyLatitude) && $propertyLatitude !=""){echo $propertyLatitude;} else {echo "-33.91147226200426";} ?>;
	var strlongitude = <?php if(isset($propertyLongitude) && $propertyLongitude !=""){echo $propertyLongitude;} else {echo "18.422377109527588";} ?>;
	var zoomLevel = <?php if(isset($mapZoomLevel) && $mapZoomLevel !="") {echo $mapZoomLevel;} else {echo "2";} ?>;
	var image = new google.maps.MarkerImage('<?php echo SITE_IMAGES;?>markers/marker.png', new google.maps.Size(20, 34), new google.maps.Point(0,0), new google.maps.Point(0,32));
	var shadow = new google.maps.MarkerImage('<?php echo SITE_IMAGES;?>markers/shadow.png', new google.maps.Size(37, 32), new google.maps.Point(0,0), new google.maps.Point(0, 32));

	function initialize() {
	var Latlng = new google.maps.LatLng(strlatitude, strlongitude);
	var Options = {
	  zoom: zoomLevel,
	  center: Latlng,
	  mapTypeId: google.maps.MapTypeId.HYBRID
	};
	map = new google.maps.Map(document.getElementById('map'), Options);
	
	var marker = new google.maps.Marker({
		position: Latlng, 
		map: map,
        shadow: shadow,
        icon: image,
		title:"<?php echo $property_name; ?>"
	});   
	}
	google.maps.event.addDomListener(window, 'load', initialize);
</script>
<!-- Map code: End here -->
<?php */?>