<?php	
if($_SERVER["SERVER_NAME"] == "localhost") {
	require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/includes/application-top.php");
} else {
	require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
}
require_once(SITE_CLASSES_PATH."class.Users.php");
require_once(SITE_CLASSES_PATH."class.Property.php");
require_once(SITE_CLASSES_PATH."class.Pagination.php");
require_once(SITE_CLASSES_PATH."class.Location.php");

$propertyObj 	= new Property();
$usersObj 		= new Users();
$locationObj 	= new Location();

if(isset($_GET['pid']) && $_GET['pid'] !=""){
	$property_id 			= $_GET['pid'];
	$propertyInfo			= $propertyObj->fun_getPropertyInfo($property_id);

	if($propertyInfo['latitude'] !="" && $propertyInfo['longitude'] !="") {
		$propertyLatitude 	= $propertyInfo['latitude'];
		$propertyLongitude 	= $propertyInfo['longitude'];
		$mapZoomLevel 		= $propertyInfo['map_zoom_level'];
	} else {
		$propertyLatitude 	= "51.51121";
		$propertyLongitude 	= "-0.11982";
		$mapZoomLevel 		= 8;
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo tranText('charset'); ?>" />
    <META HTTP-EQUIV="Content-language" CONTENT="<?php echo tranText('lang_iso'); ?>">
    <link rel="shortcut icon" href="favicon.ico" />
    <base target="_parent" />
	<style type="text/css">
        #p_map_map {
            width: 404px;
            height: 402px;
        }
    </style>
</head>
<body bgcolor="#FFFFFF" style="background-color:#FFFFFF;background:#FFFFFF; margin:0px; padding:0px;">
<?php
	echo "<div id=\"p_map_map\" style=\"overflow: hidden; width: 404px; height: 402px; border:1px solid #999999;\"></div>";

	//echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
	//echo "<tr>";
	//echo "<td class=\"pad-btm30\" align=\"center\" valign=\"top\" width=\"406\"><div id=\"p_map_map\" style=\"overflow: hidden; width: 404px; height: 402px; float:left; border:1px solid #999999;\"></div></td>";
	//echo "</tr>";
	//echo "</table>";
?>
<!-- Map code: Start here -->
<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
	var map;
	var strlatitude = <?php if(isset($propertyLatitude) && $propertyLatitude !=""){echo $propertyLatitude;} else {echo "51.51121";} ?>;;
	var strlongitude = <?php if(isset($propertyLongitude) && $propertyLongitude !=""){echo $propertyLongitude;} else {echo "-0.11982";} ?>;
	var zoomLevel = <?php if(isset($mapZoomLevel) && $mapZoomLevel !="") {echo $mapZoomLevel;} else {echo "2";} ?>;
	var image = new google.maps.MarkerImage('<?php echo SITE_IMAGES;?>markers/marker.png', new google.maps.Size(20, 34), new google.maps.Point(0,0), new google.maps.Point(0,32));
	var shadow = new google.maps.MarkerImage('<?php echo SITE_IMAGES;?>markers/shadow.png', new google.maps.Size(37, 32), new google.maps.Point(0,0), new google.maps.Point(0, 32));
	//function initialize() {
		var Latlng = new google.maps.LatLng(strlatitude, strlongitude);
		var Options = {
		  zoom: zoomLevel,
		  center: Latlng,
		  mapTypeId: google.maps.MapTypeId.ROADMAP
		};

		map = new google.maps.Map(document.getElementById('p_map_map'), Options);
		var marker = new google.maps.Marker({
			position: Latlng, 
			map: map,
			shadow: shadow,
			icon: image,
			title:"<?php echo $property_name; ?>"
		});   
		//map.panTo(marker.getPosition());
		//map.setCenter(Latlng, 2);

		google.maps.event.addListener(map, 'center_changed', function() {
			// 3 seconds after the center of the map has changed, pan back to the
			// marker.
			window.setTimeout(function() {
			  map.panTo(marker.getPosition());
			}, 1000);
		});

	//}
	//initialize();
	//google.maps.event.addDomListener(window, 'load', initialize);
</script>
<!-- Map code: End here -->
</body>
</html>
<?php
}
?>