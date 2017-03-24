<?php
if(isset($_GET['action'])) {
	if($_GET['action'] == 'edit' && isset($_GET['regionid']) && $_GET['regionid'] != "") {
		$regionid 			= $_GET['regionid'];
		$regionInfoArr 		= $locationObj->fun_getRegionInfoById($regionid);
		$region_id 			= $regionInfoArr[0]['region_id'];
		$pregion_id 		= $regionInfoArr[0]['pregion_id'];
		$area_id 			= $regionInfoArr[0]['area_id'];
		$region_name 		= $regionInfoArr[0]['region_name'];
		$region_desc 		= $regionInfoArr[0]['region_desc'];
		$latitude 			= ($regionInfoArr[0]['latitude'])?$regionInfoArr[0]['latitude']:38.886757140695906;
		$longitude 			= ($regionInfoArr[0]['longitude'])?$regionInfoArr[0]['longitude']:22.3187255859375;
		$zoom_level			= ($regionInfoArr[0]['zoom_level'])?$regionInfoArr[0]['zoom_level']:10;
		$status		 		= $regionInfoArr[0]['status'];

		$edit = TRUE;
	} else {
		$zoom_level			= 5;
		$edit = FALSE;
	}
?>
<!-- TinyMCE -->
<script type="text/javascript" src="../tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		mode : "exact",
		elements : "txtRegionDescId",
		theme : "advanced",
		plugins : 'advlink,advimage',
		relative_urls : false,
		remove_script_host : false
	});
</script>
<!-- /TinyMCE -->
<script language="javascript" type="text/javascript">
	function frmValidateAddRegion() {
		var shwError = false;
		if(document.frmAddRegion.txtRegionName.value == "") {
			document.getElementById("txtRegionNameErrorId").innerHTML = "Please enter Region name";
			document.frmAddRegion.txtRegionName.focus();
			shwError = true;
		}

		if(tinyMCE.get("txtRegionDescId").getContent() == "") {
			document.getElementById("txtRegionDescErrorId").innerHTML = "Please enter Region description.";
			document.frmAddRegion.txtRegionDescId.focus();
			shwError = true;
		}

		if(shwError == true) {
			return false;
		} else {
			document.frmAddRegion.submit();
		}
	}

	function chkblnkTxtError(strFieldId, strErrorFieldId) {
		if(document.getElementById(strFieldId).value != "") {
			document.getElementById(strErrorFieldId).innerHTML = "";
		}
	}

	function chkblnkEditorTxtError(strFieldId, strErrorFieldId) {
		if(tinyMCE.get(strFieldId).getContent() != "") {
			document.getElementById(strErrorFieldId).innerHTML = "";
		}
	}
</script>

<form name="frmAddRegion" id="frmAddRegion" action="admin-site-variables.php?sec=manloca" method="post" enctype="multipart/form-data">
<input type="hidden" name="securityKey" id="securityKey" value="<?php echo md5("ADDREGION"); ?>">
<input type="hidden" name="txtRegionId" id="txtRegionId" value="<?php echo $region_id; ?>">
<input type="hidden" name="txtAreaId" id="txtAreaId" value="<?php echo $area_id; ?>">
<input type="hidden" name="p_map_zoom" value="<?php if(isset($zoom_level)) {echo $zoom_level;} else {echo "10";}?>" id="p_map_zoom" />
<input type="hidden" name="p_map_map_type" value="G_HYBRID_MAP" id="p_map_map_type" />
<input type="hidden" name="p_map_latitude" id="p_map_latitude" value="<?php if(isset($latitude) && $latitude !=""){echo $latitude;} else {echo "38.886757140695906";} ?>">
<input type="hidden" name="p_map_longitude" id="p_map_longitude" value="<?php if(isset($longitude) && $longitude !=""){echo $longitude;} else {echo "22.3187255859375";} ?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
    <tr>
        <td valign="top" class="SectionSubHead"><?php echo $addtitle;?></td>
        <td>&nbsp;</td>
    </tr>
    <tr><td height="10" colspan="2" valign="top">&nbsp;</td></tr>
    <tr>
		<td valign="top"><a href="admin-site-variables.php?sec=manloca&show=area&countryid=<?php echo $country_id; ?>" class="back">Back to Region List</a></td>
		<td align="right" valign="top"><a href="admin-site-variables.php?sec=manloca&action=add&show=region&areaid=<?php echo $area_id;?>" class="back">Add new area</a></td>
    </tr>
    <tr>
        <td colspan="2" valign="top" class="pad-top5">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
                <tr>
                    <td valign="top" class="pad-top7">
                        <table width="690" border="0" cellspacing="0" cellpadding="0" class="font12">
                            <tr>
                                <td align="left" valign="top">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="10" class="eventForm">
                                        <tr>
                                            <td colspan="2" align="right" valign="top" class="header">
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td align="right" valign="bottom" colspan="2">
                                                            <a href="admin-site-variables.php?sec=manloca&show=region&areaid=<?php echo $area_id;?>" style="text-decoration: none;"><img src="images/cancelN.png" alt="Cancel" border="0" height="21" width="66"></a>&nbsp;<a href="javascript:void(0);" onclick="frmValidateAddRegion();" style="text-decoration:none;"><img src="images/saveChangesN.png" alt="Save Approve" width="108" height="21" border="0" /></a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>

<!--

                                        <tr>
                                            <td height="23"  align="right" valign="top" class="admleftBg">Country</td>
                                            <td  valign="top">
												<select name="txtCountry" id="txtCountryId" style="display:block;" class="select216">
													<?php //$locationObj->fun_getCountriesOptionsList($country_id, " ");?>
												</select>
												<span class="pdError1 pad-lft10" id="txtCountryErrorId"></span>
											</td>
                                        </tr>

-->

                                        <tr>
                                            <td height="23"  align="right" valign="top" class="admleftBg">Region Name</td>
                                            <td  valign="top"><input name="txtRegionName" id="txtRegionNameId" type="text" class="inpuTxt260" value="<?php echo $region_name; ?>" /><span class="pdError1 pad-lft10" id="txtRegionNameErrorId"></span></td>
                                        </tr>
                                        <tr>
                                            <td height="23" align="right" valign="top" class="admleftBg">Description</td>
                                            <td  valign="top">
												<textarea name="txtRegionDesc" id="txtRegionDescId" class="textArea460"><?php echo $region_desc; ?></textarea>
                                                <span class="pdError1 pad-lft10" id="txtRegionDescErrorId"></span>
											</td>
                                        </tr>
                                        <tr>
                                            <td height="23" align="right" valign="top" class="admleftBg">Google Map</td>
                                            <td  valign="top">
                                                <div style="height:60px; width:570px; margin-bottom:5px; vertical-align:middle;" >
                                                <script language="javascript" type="text/javascript">
												function showLatLonFrm() {
													document.getElementById("findMapFrm").style.display = "block";
												}
												</script>
                                                    <a href="javascript:void(0);" onclick="showLatLonFrm();">Know Latitude and Longitude?</a>
                                                    <span id="findMapFrm" style="display:none;">
                                                        Latitude&nbsp;<input name="txtLat" id="txtLatId" type="text" class="txtBox75" value="<?php echo $latitude; ?>" />
                                                        &nbsp;&nbsp;
                                                        Longitude&nbsp;<input name="txtLon" id="txtLonId" type="text" class="txtBox75" value="<?php echo $longitude; ?>" />
                                                        &nbsp;&nbsp;
                                                        Zoom level&nbsp;<?php $propertyObj->fun_createSelectNumField("txtZoom", "txtZoomId", "numbers", $zoom_level, "", 1, 10); ?>
                                                        &nbsp;&nbsp;
                                                        <a href="javascript:void(0);" onclick="findOnMap();" class="button157x32" style="text-decoration:none;">Find Now</a>
                                                    </span>
                                                </div>
												<div id="p_map_map" style="width: 570px; height:400px; float:left; border:1px solid #999999; text-align:center;"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="23"  align="right" valign="top" class="admleftBg">Status</td>
                                            <td  valign="top">
												<select name="txtStatus" id="txtStatusId" class="select216">
													<option value="1" <?php if($status == 1) {echo "selected=\"selected\"";} ?> >Pending</option>
													<option value="2" <?php if($status == 2) {echo "selected=\"selected\"";} ?> >Approved</option>
												</select>
												<span class="pdError1 pad-lft10" id="txtStatusErrorId"></span>
											</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" align="right" valign="top" class="header">
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td align="right" valign="bottom" colspan="2">
                                                            <a href="admin-site-variables.php?sec=manloca&show=region&areaid=<?php echo $area_id;?>" style="text-decoration: none;"><img src="images/cancelN.png" alt="Cancel" border="0" height="21" width="66"></a>&nbsp;<a href="javascript:void(0);" onclick="frmValidateAddRegion();" style="text-decoration:none;"><img src="images/saveChangesN.png" alt="Save Approve" width="108" height="21" border="0" /></a>
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
                </tr>
                <tr><td valign="top">&nbsp;</td></tr>
                <tr><td valign="top">&nbsp;</td></tr>
            </table>
        </td>
    </tr>
</table>
</form>
<!-- Map code: Start here -->
<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
	var map;
	var marker;
	var markersArray = [];
	var Options = [];
	var geocoder;

	function findOnMap() {
		clearOverlays();
		var image = new google.maps.MarkerImage('<?php echo SITE_IMAGES;?>markers/marker.png', new google.maps.Size(20, 34), new google.maps.Point(0,0), new google.maps.Point(0,32));
		var shadow = new google.maps.MarkerImage('<?php echo SITE_IMAGES;?>markers/shadow.png', new google.maps.Size(37, 32), new google.maps.Point(0,0), new google.maps.Point(0, 32));
		var Latlng = new google.maps.LatLng(document.getElementById('txtLatId').value, document.getElementById('txtLonId').value, document.getElementById('txtZoomId').value);
		var zoomLevel = parseInt(document.getElementById("txtZoomId").value);
		document.getElementById("p_map_latitude").value = document.getElementById('txtLatId').value;
		document.getElementById("p_map_longitude").value = document.getElementById('txtLonId').value;
		document.getElementById("p_map_zoom").value = document.getElementById('txtZoomId').value;

		map.setCenter(Latlng);
		map.setZoom(zoomLevel);
		map.setMapTypeId(google.maps.MapTypeId.HYBRID);
		marker = new google.maps.Marker({
			position: Latlng, 
			map: map,
			shadow: shadow,
			icon: image,
			draggable: true,
			title:"<?php echo $region_name; ?>"
		});   

		google.maps.event.addListener(map, 'zoom_changed', function() {
			zoomLevel = map.getZoom();
			lz = document.getElementById("p_map_zoom");
			lz.value = zoomLevel; 
			if (zoomLevel == 0) {
				map.setZoom(10);
			}
		});

		google.maps.event.addListener(marker, 'dragend', function(event) {
			var point = marker.getPosition();
			var c = new google.maps.LatLng(point.lat(), point.lng());
			map.panTo(c); 
			la = document.getElementById("p_map_latitude"); 
			la.value = c.lat(); 
			lo = document.getElementById("p_map_longitude"); 
			lo.value = c.lng();
			marker.setPoint(c); 
		}); 
		markersArray.push(marker);
	}

	function addAddressToMap(results, status) {
		clearOverlays();
		if (status == google.maps.GeocoderStatus.OK) {
			var image = new google.maps.MarkerImage('<?php echo SITE_IMAGES;?>markers/marker.png', new google.maps.Size(20, 34), new google.maps.Point(0,0), new google.maps.Point(0,32));
			var shadow = new google.maps.MarkerImage('<?php echo SITE_IMAGES;?>markers/shadow.png', new google.maps.Size(37, 32), new google.maps.Point(0,0), new google.maps.Point(0, 32));
			var zoomLevel = parseInt(document.getElementById("p_map_zoom").value);
			map.setCenter(results[0].geometry.location);
			map.setZoom(zoomLevel);
			map.setMapTypeId(google.maps.MapTypeId.HYBRID);
			marker = new google.maps.Marker({
				position: results[0].geometry.location, 
				map: map,
				shadow: shadow,
				icon: image,
				draggable: true,
				title:"<?php echo $region_name; ?>"
			});   
		
			google.maps.event.addListener(map, 'zoom_changed', function() {
				zoomLevel = map.getZoom();
				lz = document.getElementById("p_map_zoom");
				lz.value = zoomLevel; 
				if (zoomLevel == 0) {
					map.setZoom(10);
				}
			});

			google.maps.event.addListener(marker, 'dragend', function(event) {
				var point = marker.getPosition();
				var c = new google.maps.LatLng(point.lat(), point.lng());
				map.panTo(c); 
				la = document.getElementById("p_map_latitude"); 
				la.value = c.lat(); 
				lo = document.getElementById("p_map_longitude"); 
				lo.value = c.lng();
				marker.setPoint(c); 
			}); 
			markersArray.push(marker);
		}
	}

	// Removes the overlays from the map, but keeps them in the array
	function clearOverlays() {
	  if (markersArray) {
		for (i in markersArray) {
		  markersArray[i].setMap(null);
		}
	  }
	}

	function initialize() {
		geocoder = new google.maps.Geocoder();
		<?php 
		if((isset($latitude) && $latitude !="") && (isset($longitude) && $longitude !="")){
		?>
			var strlatitude = <?php echo $latitude; ?>;
			var strlongitude = <?php echo $longitude; ?>;
			var zoomLevel = <?php echo $zoom_level; ?>;
			var image = new google.maps.MarkerImage('<?php echo SITE_IMAGES;?>markers/marker.png', new google.maps.Size(20, 34), new google.maps.Point(0,0), new google.maps.Point(0,32));
			var shadow = new google.maps.MarkerImage('<?php echo SITE_IMAGES;?>markers/shadow.png', new google.maps.Size(37, 32), new google.maps.Point(0,0), new google.maps.Point(0, 32));
			var Latlng = new google.maps.LatLng(strlatitude, strlongitude);

			var Options = {
			  zoom: zoomLevel,
			  center: Latlng,
			  mapTypeId: google.maps.MapTypeId.HYBRID
			};
			map = new google.maps.Map(document.getElementById('p_map_map'), Options);

			marker = new google.maps.Marker({
				position: Latlng, 
				map: map,
				shadow: shadow,
				icon: image,
				draggable: true,
				title:"<?php echo $region_name; ?>"
			});   
		
			google.maps.event.addListener(map, 'zoom_changed', function() {
				zoomLevel = map.getZoom();
				lz = document.getElementById("p_map_zoom");
				lz.value = zoomLevel; 
				if (zoomLevel == 0) {
					map.setZoom(10);
				}
			});


			google.maps.event.addListener(marker, 'dragend', function(event) {
				var point = marker.getPosition();
				var c = new google.maps.LatLng(point.lat(), point.lng());
				map.panTo(c); 
				la = document.getElementById("p_map_latitude"); 
				la.value = c.lat(); 
				lo = document.getElementById("p_map_longitude"); 
				lo.value = c.lng();
				marker.setPoint(c); 
			}); 


			markersArray.push(marker);
		<?php
		} else if(isset($region_name) && $region_name != ""){
		?>
			var zoomLevel = <?php echo $zoom_level; ?>;
			var address = "<?php echo ucwords($region_name); ?>";
			var Options = {
			  zoom: zoomLevel,
			  mapTypeId: google.maps.MapTypeId.HYBRID
			};
			map = new google.maps.Map(document.getElementById('p_map_map'), Options);
			geocoder.geocode( { 'address': address}, addAddressToMap);  
		<?php
		} else {
		?>
			var zoomLevel = <?php echo $zoom_level; ?>;
			var address = "<?php echo ucwords($area_name); ?>";
			var Options = {
			  zoom: zoomLevel,
			  mapTypeId: google.maps.MapTypeId.HYBRID
			};
			map = new google.maps.Map(document.getElementById('p_map_map'), Options);
			geocoder.geocode( { 'address': address}, addAddressToMap);  
		<?php
		}
		?>
	}
	google.maps.event.addDomListener(window, 'load', initialize);
</script>
<!-- Map code: End here -->
<?php
}
?>