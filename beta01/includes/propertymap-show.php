<?php
//print_r($propListArr);
$propListAreaWiseArr 	= array();
$rid 		= $propListArr[0]['area_id'];
$x 			= 0;
$y 			= 0;
for($z = 0; $z < count($propListArr); $z++ ) {
	if($propListArr[$z]['area_id'] > $rid) {
		$rid = $propListArr[$z]['area_id'];
		$x++;
		$y = 0;
	}
	$propListAreaWiseArr[$x]['area_id'] = $rid;
	$propListAreaWiseArr[$x]['total_properties'] = ($y+1);
	$y++;
}
//print_r($propListAreaWiseArr);
//echo count($propListArr);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
    <tr>
        <td align="left" valign="middle" class="pad-btm5">
            <ul style="width:680px;">
                <li class="pad-top15" style="width:230px;">&nbsp;</li>
                <li id="listing-head">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <th width="60px" align="right" scope="col">&nbsp;</th>
                            <th width="200px" align="left" scope="col" class="pad-lft10">&nbsp;</th>
                            <th align="center"><a href="javascript:void(0);" onclick="changeResultsMode();" class="listing-listoff">List</a><a href="javascript:void(0);" class="listing-mapon">Map</a></th>
                        </tr>
                    </table>
                </li>
            </ul>
        </td>
    </tr>
    <tr>
        <td width="680px" align="left" valign="top" class="pad-top15">
<!-- Map code: Start here -->
<script src="http://www.google.com/jsapi"></script>
<script type="text/javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>markerclusterer.js"></script>
<script type="text/javascript">
google.load('maps', '3', {
other_params: 'sensor=false'
});

google.setOnLoadCallback(initialize);

var styles = [[{
url: '../images/people35.png',
height: 35,
width: 35,
anchor: [16, 0],
textColor: '#ff00ff',
textSize: 10
}, {
url: '../images/people45.png',
height: 45,
width: 45,
anchor: [24, 0],
textColor: '#ff0000',
textSize: 11
}, {
url: '../images/people55.png',
height: 55,
width: 55,
anchor: [32, 0],
textColor: '#ffffff',
textSize: 12
}], [{
url: '../images/conv30.png',
height: 27,
width: 30,
anchor: [3, 0],
textColor: '#ff00ff',
textSize: 10
}, {
url: '../images/conv40.png',
height: 36,
width: 40,
anchor: [6, 0],
textColor: '#ff0000',
textSize: 11
}, {
url: '../images/conv50.png',
width: 50,
height: 45,
anchor: [8, 0],
textSize: 12
}], [{
url: '../images/heart30.png',
height: 26,
width: 30,
anchor: [4, 0],
textColor: '#ff00ff',
textSize: 10
}, {
url: '../images/heart40.png',
height: 35,
width: 40,
anchor: [8, 0],
textColor: '#ff0000',
textSize: 11
}, {
url: '../images/heart50.png',
width: 50,
height: 44,
anchor: [12, 0],
textSize: 12
}]];

var markerClusterer = null;
var map = null;
var marker;
var markers = [];
var eventListeners=[];
var Options = [];
var geocoder;
var imageUrl = 'http://chart.apis.google.com/chart?cht=mm&chs=24x32&' +'chco=FFFFFF,008CFF,000000&ext=.png';

function showClusterMarker() {
if (markerClusterer) {
markerClusterer.clearMarkers();
}
var id, name, title, location, lat, lng, total_properties, urlMap, urlResult, markerHTML;
var markerImage = new google.maps.MarkerImage(imageUrl, new google.maps.Size(24, 32));
<?php
for($j = 0; $j < count($propListAreaWiseArr); $j++) {
$area_id			= $propListAreaWiseArr[$j]['area_id'];
$areaInfoArr		= $locationObj->fun_getAreaShortInfoById($area_id);
$area_name			= $areaInfoArr['destination_name'];
$area_lat			= $areaInfoArr['destination_lat'];
$area_lon			= $areaInfoArr['destination_lon'];
$total_properties	= $propListAreaWiseArr[$j]['total_properties'];
$result_link 		= SITE_URL."vacation-rentals/in.".str_replace(" ", "-", strtolower($area_name))."/";
$map_link 			= SITE_URL."map.vacation-rentals/in.".str_replace(" ", "-", strtolower($area_name))."/";
?>

id = "<?php echo $area_id; ?>"; // Property Id
name = "<?php echo $area_name; ?>"; // Property Name
title = "<?php echo addslashes($area_name); ?> - click for details"; // Property short description
location = "<?php echo $area_name; ?>"; // Property location
lat = "<?php echo $area_lat; ?>"; // Property Latitude
lng = "<?php echo $area_lon; ?>"; // Property Longitude
total_properties = "<?php echo $total_properties; ?>"; // Property images

urlMap = "<?php echo $map_link; ?>"; // Map URL
urlResult = "<?php echo $result_link; ?>"; // Map URL

if(lat != "" && lng != "") {
var latLng = new google.maps.LatLng(lat, lng);
strhtml = '<div><div style="width: 160px; overflow: hidden; height: 50px; float: left; padding-left: 10px; margin-right: 10px; line-height: normal; font-size: 9pt; text-align: left;"><div style="line-height: normal; font-size: 9pt; font-weight: bold; height: 16px; color:#531A03;">'+name+' ('+total_properties+')<\/div><div style="line-height: normal; font-size: 9pt; font-weight: normal; height: 16px; overflow: hidden;"><a href="'+urlMap+'" style="text-decoration:none; color:#531A03;">View on map</a> &nbsp;/&nbsp; <a href="'+urlResult+'" style="text-decoration:none; color:#531A03;">View as list</a><\/div><\/div><\/div>';
marker = new google.maps.Marker({
position: latLng,
icon: markerImage,
title: title
});

markers.push(marker);
set_area_info_window(marker, strhtml);
}
<?php
}
?>

var zoom = 8;//parseInt(2, 10);
var size = 20;
var style = null;

markerClusterer = new MarkerClusterer(map, markers, {
maxZoom: zoom,
gridSize: size,
styles: styles[style]
});
}

function showPropertyMarker() {
if (markerClusterer) {
markerClusterer.clearMarkers();
}
var id, name, title, location, lat, lng, img, bed, bath, price, url, marker, markerHTML;
var markerImage = new google.maps.MarkerImage(imageUrl, new google.maps.Size(24, 32));
<?php
for($j = 0; $j < count($propListArr); $j++) {
$property_id			= $propListArr[$j]['property_id'];
$property_name 			= ucfirst($propListArr[$j]['property_name']);
$property_title			= ucfirst($propListArr[$j]['property_title']);
$propLatLonArr 			= $propertyObj->fun_getPropertyLatLong($property_id);
$latitude				= $propLatLonArr[0]['latitude'];
$longitude				= $propLatLonArr[0]['longitude'];
?>
id = "<?php echo $property_id; ?>"; // Property Id
name = "<?php echo $property_name; ?>"; // Property Name
title = "<?php echo addslashes($property_name); ?> - click for details"; // Property short description
lat = "<?php echo $latitude; ?>"; // Property Latitude
lng = "<?php echo $longitude; ?>"; // Property Longitude
if(lat != "" && lng != "") {
var latLng = new google.maps.LatLng(lat, lng);
marker = new google.maps.Marker({
position: latLng,
icon: markerImage,
title: title
});
markers.push(marker);
set_property_info_window(marker, id);
}
<?php
}
?>

var zoom = 8;//parseInt(2, 10);
var size = 20;
var style = null;

markerClusterer = new MarkerClusterer(map, markers, {
maxZoom: zoom,
gridSize: size,
styles: styles[style]
});
}

function showRefinePropertyMarker(txt) {
if (markerClusterer) {
markerClusterer.clearMarkers();
}

var id, name, title, location, lat, lng, total_properties, urlMap, urlResult, marker, markerHTML;
var markerImage = new google.maps.MarkerImage(imageUrl, new google.maps.Size(24, 32));
var propListArr = txt.split(':::');
for(var cnt = 1; cnt < propListArr.length; cnt++) {
var propInfo =	propListArr[cnt];
var propInfoListArr = propInfo.split('~~~');
id = propInfoListArr[0]; // Property Id
lat = propInfoListArr[1]; // Property Latitude
lng = propInfoListArr[2]; // Property Longitude
title = propInfoListArr[3]; // Property title
if(lat != "" && lng != "") {
var latLng = new google.maps.LatLng(lat, lng);
marker = new google.maps.Marker({
position: latLng,
icon: markerImage,
title: title
});

markers.push(marker);
set_property_info_window(marker, id);
//set_refine_property_info_window(marker, strhtml);
}
}

var zoom = 8;//parseInt(2, 10);
var size = 20;
var style = null;

markerClusterer = new MarkerClusterer(map, markers, {
maxZoom: zoom,
gridSize: size,
styles: styles[style]
});
}

function addAddressToMap(results, status) {
if (status == google.maps.GeocoderStatus.OK) {
map.setCenter(results[0].geometry.location);
}
}

function set_property_info_window(marker, property_id)
{
var infowindow = new google.maps.InfoWindow();
google.maps.event.addListener(marker, 'click', function() {
$.ajax(
{			
url: '<?php echo SITE_URL; ?>gmap_info_window.php?pid='+property_id,
type: 'GET',
beforeSend: function()
{
//infowindow.open(map,marker);
//infowindow.setContent('loading');
},	
success: function(data) 
{
infowindow.setContent(data);
infowindow.open(map, marker);
}
});
});
}

function set_refine_property_info_window(marker, strhtml)
{
var infowindow = new google.maps.InfoWindow();
google.maps.event.addListener(marker, 'click', function() {
infowindow.setContent(strhtml);
infowindow.open(map,marker);
});
}

function set_area_info_window(marker, strhtml)
{
var infowindow = new google.maps.InfoWindow();
google.maps.event.addListener(marker, 'click', function() {
infowindow.setContent(strhtml);
infowindow.open(map,marker);
});
}

function initialize() {
var eventListeners=[];

<?php 
if(isset($mapLatitude) && $mapLatitude != "" && isset($mapLongitude) && $mapLongitude != "") {
?>
map = new google.maps.Map(document.getElementById('map'), {
zoom: <?php if($mapZoomLevel){ echo $mapZoomLevel;} else {echo "3";} ?>,
center: new google.maps.LatLng(<?php echo $mapLatitude; ?>, <?php echo $mapLongitude; ?>),
mapTypeId: google.maps.MapTypeId.HYBRID
});
<?php
} else if(isset($destinations) && $destinations != "") {
?>
var Options = {
zoom: <?php if($mapZoomLevel){ echo $mapZoomLevel;} else {echo "3";} ?>,
mapTypeId: google.maps.MapTypeId.HYBRID
};
map = new google.maps.Map(document.getElementById('map'), Options);
geocoder.geocode( { 'address': "<?php echo ucfirst($destinations); ?>"}, addAddressToMap);  
<?php
} else {
?>
map = new google.maps.Map(document.getElementById('map'), {
zoom: 3,
center: new google.maps.LatLng(37.0902, -95.7129),
mapTypeId: google.maps.MapTypeId.HYBRID
});
<?php
}
?>
//google.maps.event.addListener(map, 'zoomend', function() { map.closeInfoWindow(); });


/*	
var refresh = document.getElementById('refresh');
google.maps.event.addDomListener(refresh, 'click', showPropertyMarker);

var clear = document.getElementById('clear');
google.maps.event.addDomListener(clear, 'click', clearClusters);
*/
showPropertyMarker();
}

function clearClusters(e) {
e.preventDefault();
e.stopPropagation();
markerClusterer.clearMarkers();
}
</script>
<!-- Map code: End here -->

            <!-- google map: Start here -->
            <div class="map" id="map" style="display:block; width:680px; height:550px;"></div>
            <!-- google map: End here -->
            <br /><br />
            <div align="left" style="border: 1px solid rgb(212, 217, 241); padding:0px; width: 675px; height:auto; padding:5px;">
            <div class="google_map_legend">
                <div style="float:left;"><h3>Legend</h3></div>
                <div style="clear:both;"><p>&nbsp;</p></div>
                <div style="float:left;">
                    <p>
                        <img src="<?php echo SITE_URL; ?>images/markers/gmap_marker.png" align="left">  <strong><?php echo tranText('individual_property'); ?></strong>
                        <br>
                        Click pin for details
                    </p>
                </div>
                <div style="float:right;">
                    <p>
                        <img src="<?php echo SITE_URL; ?>images/markers/m1.png" align="left"> 
                        <img src="<?php echo SITE_URL; ?>images/markers/m2.png" align="left">
                        <img src="<?php echo SITE_URL; ?>images/markers/m3.png" align="left">
                        <strong>Clustered listings</strong>
                        <br>
                        <?php echo tranText('click_for_details'); ?>
                    </p>
                </div>
                <div style="clear:both;"><p>&nbsp;</p></div>
                <div style="padding-bottom:20px;">
                    <strong>Zooming</strong><br />
                    There are three ways to zoom in<br />
                        - Click on a cluster<br />
                        - Double click anywhere else on the map<br />
                        - Use the zoom bar on the left to + and - and slide<br />
                </div>
                <div style="float:left;">
                    <strong>Listing details</strong><br />
                    <ul style="list-style-type:disc; margin-left:20px;">
                        <li>A speech bubble with the property summary can be accessed by clicking an individual property pin</li>
                        <li>Full property details can be accessed by following the link in each speech bubble</li>
                        <li>To close a speech bubble click anywhere on the map, click another pin or click the cross at the top right of the speech bubble.</li>
                    </ul>
                </div>
                <div style="clear:both;"><p>&nbsp;</p></div>
            </div>
            </div>
        </td>
    </tr>
</table>
