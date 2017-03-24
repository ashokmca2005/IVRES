<?php
if($propertyInfo['latitude'] !="" && $propertyInfo['longitude'] !="") {
	$propertyLatitude 	= $propertyInfo['latitude'];
	$propertyLongitude 	= $propertyInfo['longitude'];
	$mapZoomLevel 		= $propertyInfo['map_zoom_level'];
} else {
//	$propertyLatitude 	= "38.886757140695906";
//	$propertyLongitude 	= "22.3187255859375";
	$mapZoomLevel 		= 8;
}

?>
<!-- TinyMCE -->
<script type="text/javascript" src="tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		mode : "exact",
		elements : "textPropertyLocationGuideNoteId, textPropertyAreaNoteId",
		theme : "simple",
		plugins : 'advlink,advimage',
		relative_urls : false,
		remove_script_host : false
		/*
		setup: function(ed) {
			// Force Paste-as-Plain-Text
			ed.onPaste.add( function(ed, e, o) {
				ed.execCommand('mcePasteText', true);
				return tinymce.dom.Event.cancel(e);
			});
		}
		*/
	});
</script>
<!-- /TinyMCE -->
<script type="text/javascript" language="javascript">	
	function changeDistance(strId) {
		if(strId !="") {
			var strDistance = (strId == "m")?'miles':'km';
		} else {
			var strDistance = "km";
		}

		var countLandmark = document.getElementsByName("txtLandmarkId[]").length;
		for(var i=0; i < parseInt(countLandmark); i++) {
			var cellId = "landMarkCellId"+i;
			document.getElementById(cellId).innerHTML = strDistance;
		}

		var countExtrAshokdmark = document.getElementsByName("txtExtraLandmarks[]").length;
		for(var j=0; j < parseInt(countExtrAshokdmark); j++) {
			var cellId = "extraLandMarkCellId"+j;
			document.getElementById(cellId).innerHTML = strDistance;
		}
	}

		
	window.onload=function() {
//		document.getElementById("myTable").style.display = "none";
	}

	function addEvent() {
		var strTable1 = "";
		var ni = document.getElementById('myDiv1');
		var numi = document.getElementById('theValue');
		var num = (document.getElementById("theValue").value -1)+ 2;
		var distanceType = document.getElementById('txtDistanceTypeId').value;
		var strDistanceType = (distanceType == "m")?'miles':'km';
		numi.value = num;
		//alert(num);
		var divIdName = "my"+num+"Div";
		var newdiv = document.createElement('div');
		newdiv.setAttribute("id",divIdName);
		newdiv.setAttribute("style", "padding: 0px 10px 5px 5px;");
		strTable1 += "<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"pad-top2\">";
		strTable1 += "<tr>";
		strTable1 += "<td height=\"25\"><input type=\"text\" style=\"width:147px; border: solid 1px #9F9F9F; font-size:12px; padding-top:2px; padding-bottom:2px; padding-left:5px;\" name=\"txtExtraLandmarks[]\" id=\"txtExtraLandmarks"+num+"\" value=\"\" /></td>";
		strTable1 += "<td>&nbsp;is &nbsp;</td>";
		strTable1 += "<td><input type=\"text\" style=\"width:49px; border: solid 1px #9F9F9F; font-size:12px; padding-top:2px; padding-bottom:2px; text-align:center;\" name=\"txtExtraLandmarkDist[]\" id=\"txtExtraLandmarkDist"+num+"\" maxlength=\"5\" value=\"\" /></td>";
		strTable1 += "<td style=\"width:380px;\">&nbsp; <span id='extraLandMarkCellId"+(parseInt(num)-2)+"'>"+strDistanceType+"</span> from my property</td>";
		strTable1 += "<td><a href=\"JavaScript:void(0);\" onClick=\"JavaScript:removeElement('"+divIdName+"');\" class=\"delete-photo\">Delete</a></td>";
		strTable1 += "</tr>";
		strTable1 += "</table>";
		newdiv.innerHTML = strTable1;
		ni.appendChild(newdiv);
	}

	function removeElement(divNum) {
		var d = document.getElementById('myDiv1');
		var olddiv = document.getElementById(divNum);
		d.removeChild(olddiv);
	} 

</script>
<script language="javascript" type="text/javascript">
	var req = ajaxFunction();
	/*
	* For location : Start here
	*/

	function chkSelectCountry() {
		var getID=document.getElementById("txtPropertyCountryId").value;
		if(getID !="" && getID != "0"){
			sendAreaRequest(getID);
			document.getElementById("txtPropertyAreaId").value = "0";
		}
		if(getID == "0" || getID =="") {
			document.getElementById("txtPropertyCountryId").value = "0";
			document.getElementById("txtPropertyAreaId").value = "0";
		}
	}

	function chkSelectArea() {
		var getID=document.getElementById("txtPropertyAreaId").value;
		if(getID !="" && getID != "0"){
			sendRegionRequest(getID);
			document.getElementById("txtPropertyRegionId").value = "0";
		}
		if(getID == "0" || getID =="") {
			document.getElementById("txtPropertyAreaId").value = "0";
			document.getElementById("txtPropertyRegionId").value = "0";
		}
	}
	
	function chkSelectRegion() {
		var getID=document.getElementById("txtPropertyRegionId").value;
		if(getID !="" && getID != "0"){
			sendSubRegionRequest(getID);
			document.getElementById("txtPropertySubRegionId").value = "0";
			document.getElementById("txtPropertyLocationId").value = "0";
		}
		if(getID == "0" || getID =="") {
			document.getElementById("txtPropertyRegionId").value = "0";
			document.getElementById("txtPropertySubRegionId").value = "0";
			document.getElementById("txtPropertyLocationId").value = "0";
			document.getElementById("txtPropertySubRegionId").style.display = "none";
			document.getElementById("txtPropertyLocationId").style.display = "none";
		}
	}
	
	function chkSelectSubRegion() {
		var getID=document.getElementById("txtPropertySubRegionId").value;
		if(getID !="" && getID != "0"){
			sendLocationRequest(getID);
			document.getElementById("txtPropertyLocationId").value = "0";
		}
		if(getID == "0" || getID =="") {
			document.getElementById("txtPropertySubRegionId").value = "0";
			document.getElementById("txtPropertyLocationId").value = "0";
			document.getElementById("txtPropertyLocationId").style.display = "none";
		}
	}

	function chkSelectLocation() {
		var getID=document.getElementById("txtPropertyLocationId").value;
		if(getID !="" && getID != "0"){
		}
		if(getID == "0" || getID =="") {
			document.getElementById("txtPropertyLocationId").value = "0";
		}
	}	

	function sendAreaRequest(id) { 
		req.open('get', 'selectAreaXml.php?id=' + id); 
		req.onreadystatechange = handleAreaResponse; 
		req.send(null); 
	} 
	
	function sendRegionRequest(id) { 
		req.open('get', 'selectRegionXml.php?id=' + id); 
		req.onreadystatechange = handleRegionResponse; 
		req.send(null); 
	} 
	
	function sendSubRegionRequest(id) { 
		req.open('get', 'selectSubRegionXml.php?id=' + id); 
		req.onreadystatechange = handleSubRegionResponse; 
		req.send(null); 
	} 
	
	function sendLocationRequest(id) { 
		req.open('get', 'selectLocationXml.php?id=' + id); 
		req.onreadystatechange = handleLocationResponse; 
		req.send(null); 
	} 
	
	function handleAreaResponse() { 
		var arrayOfId = new Array();
		var arrayOfNames = new Array();
		if(req.readyState == 4) { 
			var response = req.responseText; 
			xmlDoc=req.responseXML;
			var root = xmlDoc.getElementsByTagName('ntowns')[0];
			if(root != null) {
				document.getElementById("txtPropertyAreaId").style.display = "block";
//					document.getElementById("txtPropertyRegionId").style.display = "none";
//					document.getElementById("txtPropertySubRegionId").style.display = "none";
//					document.getElementById("txtPropertyLocationId").style.display = "none";
				var items = root.getElementsByTagName("ntown");
				for (var i = 0 ; i < items.length ; i++) {
					var item = items[i];
					var id = item.getElementsByTagName("id")[0].firstChild.nodeValue;
					arrayOfId[i] = id;
					var name = item.getElementsByTagName("name")[0].firstChild.nodeValue;

					arrayOfNames[i] = name;
					//alert("item #" + i + ": ID=" + id + " Name=" + name);
				}
				if( arrayOfId.length > 0) {
					var p_city=document.getElementById("txtPropertyAreaId");
					p_city.length=0;
					p_city.options[0]=new Option("Please Select...","");
					for(var j=0; j<arrayOfId.length; j++) {
						p_city.options[j+1]=new Option(arrayOfNames[j], arrayOfId[j]);
					}
				}
			}
		} 
	} 
	
	function handleRegionResponse() { 
		var arrayOfId = new Array();
		var arrayOfNames = new Array();
		if(req.readyState == 4) { 
			var response = req.responseText; 
			xmlDoc=req.responseXML;
			var root = xmlDoc.getElementsByTagName('ntowns')[0];
			if(root != null) {
				document.getElementById("txtPropertyRegionId").style.display = "block";
				document.getElementById("txtPropertyRegion").style.display = "none";
				var items = root.getElementsByTagName("ntown");
				for (var i = 0 ; i < items.length ; i++) {
					var item = items[i];
					var id = item.getElementsByTagName("id")[0].firstChild.nodeValue;
					arrayOfId[i] = id;
					var name = item.getElementsByTagName("name")[0].firstChild.nodeValue;
					arrayOfNames[i] = name;
					//alert("item #" + i + ": ID=" + id + " Name=" + name);
				}
				if( arrayOfId.length > 0) {
					var p_city=document.getElementById("txtPropertyRegionId");
					p_city.length=0;
					p_city.options[0]=new Option("Please Select...","0");
					for(var j=0; j<arrayOfId.length; j++) {
						p_city.options[j+1]=new Option(arrayOfNames[j],arrayOfId[j]);
					}
				} else {
					document.getElementById("txtPropertyRegionId").style.display = "none";
					document.getElementById("txtPropertyRegion").style.display = "block";
					//sendLocationRequest(document.getElementById("txtRegionId").value);
				}
			} else {
				document.getElementById("txtPropertyRegionId").style.display = "none";
				document.getElementById("txtPropertyRegion").style.display = "block";
			}
		} 
	} 
	
	function handleSubRegionResponse() { 
		var arrayOfId = new Array();
		var arrayOfNames = new Array();
		if(req.readyState == 4) { 
			var response = req.responseText; 
			xmlDoc=req.responseXML;
			var root = xmlDoc.getElementsByTagName('ntowns')[0];
			if(root != null) {
				document.getElementById("txtPropertySubRegionId").style.display = "block";
				document.getElementById("txtPropertyLocationId").style.display = "none";
				var items = root.getElementsByTagName("ntown");
				for (var i = 0 ; i < items.length ; i++) {
					var item = items[i];
					var id = item.getElementsByTagName("id")[0].firstChild.nodeValue;
					arrayOfId[i] = id;
					var name = item.getElementsByTagName("name")[0].firstChild.nodeValue;
					arrayOfNames[i] = name;
					//alert("item #" + i + ": ID=" + id + " Name=" + name);
				}
				if( arrayOfId.length > 0) {
					var p_city=document.getElementById("txtPropertySubRegionId");
					p_city.length=0;
					p_city.options[0]=new Option("Please Select...", "0");
					for(var j=0; j<arrayOfId.length; j++) {
						p_city.options[j+1]=new Option(arrayOfNames[j], arrayOfId[j]);
					}

//					sendLocationRequest(9);
				} else {
					document.getElementById("txtPropertySubRegionId").style.display = "none";
					sendLocationRequest(document.getElementById("txtPropertyRegionId").value);
				}
			} else {
				document.getElementById("txtPropertySubRegionId").style.display = "none";
				document.getElementById("txtPropertyLocationId").style.display = "none";
			}
		} 
	} 
	
	function handleLocationResponse(){
		var arrayOfId = new Array();
		var arrayOfNames = new Array();
		if(req.readyState == 4) { 
			var response = req.responseText; 
			xmlDoc=req.responseXML;
			var root = xmlDoc.getElementsByTagName('ntowns')[0];
	//		alert(root);
			if(root != null) {
				document.getElementById("txtPropertyLocationId").style.display = "block";
				var items = root.getElementsByTagName("ntown");
				for (var i = 0 ; i < items.length ; i++) {
					var item = items[i];
					var id = item.getElementsByTagName("id")[0].firstChild.nodeValue;
					arrayOfId[i] = id;
					var name = item.getElementsByTagName("name")[0].firstChild.nodeValue;
					arrayOfNames[i] = name;
					//alert("item #" + i + ": ID=" + id + " Name=" + name);
				}
				if( arrayOfId.length > 0) {

					var p_city=document.getElementById("txtPropertyLocationId");
					p_city.length=0;
					p_city.options[0]=new Option("Please Select...","0");

					for(var j=0; j<arrayOfId.length; j++) {
						p_city.options[j+1]=new Option(arrayOfNames[j], arrayOfId[j]);
					}

				} else {
					document.getElementById("txtPropertyLocationId").style.display = "none";
				}
			} else {
				document.getElementById("txtPropertyLocationId").style.display = "none";
			}
		} 
	}
	/*
	* For location : End here
	*/

	function frmSubmit(){
		document.frmProperty.submit();
	}

	function deleteExtraLandmark(strLandmarkId) {
		req.onreadystatechange = handleDeleteResponse;
		req.open('get', '<?php echo SITE_URL;?>extralandmarkdeleteXml.php?id='+strLandmarkId); 
		req.send(null);   
	}

	function handleDeleteResponse() {
		if(req.readyState == 4) {
			var response=req.responseText;
			xmlDoc=req.responseXML;
			var root = xmlDoc.getElementsByTagName('landmarks')[0];
			if(root != null) {
				var items = root.getElementsByTagName("landmark");
				var item = items[0];
				var landmarkstatus = item.getElementsByTagName("landmarkstatus")[0].firstChild.nodeValue;
				if(landmarkstatus == "Landmark deleted.") {
					window.location = location.href;
				}
			}
		}
	}

	function handlechangeDistanceResponse() {
		if(req.readyState == 4) {
			var response=req.responseText;
			document.getElementById("showDistances").innerHTML = "";
			document.getElementById("showDistances").innerHTML = response;
		}
	}
	
	function notFoundRegion() {
		if(document.getElementById("txtPropertyRegionId").style.display == "block") {
			document.getElementById("txtPropertyRegionId").style.display = "none";
			document.getElementById("txtPropertyRegion").style.display = "block";
		}
	}

	<?php /*?>		
	function changeDistance(strDistanceType) {
			req.onreadystatechange = handlechangeDistanceResponse;
			var pid = "<?php echo $property_id;?>";
			req.open('get', '<?php echo SITE_URL;?>showPropertyLandmarks.php?pid='+pid+'&distance='+strDistanceType); 
			req.send(null);   
		}
	<?php */?>
</script>
<!--Location Content Starts Here -->
<form name="frmProperty" id="frmPropertyId" method="post" action="<?php echo $_SERVER['PHP_SELF']."?sec=loc&pid=".$property_id;?>">
    <input type="hidden" name="securityKey" value="<?php echo md5(LOCATIONFORM)?>"  />
    <input type="hidden" name="p_map_zoom" value="<?php if(isset($mapZoomLevel)) {echo $mapZoomLevel;} else {echo "10";}?>" id="p_map_zoom" />
    <input type="hidden" name="p_map_map_type" value="G_HYBRID_MAP" id="p_map_map_type" />
    <input type="hidden" name="p_map_latitude" id="p_map_latitude" value="<?php if(isset($propertyLatitude) && $propertyLatitude !=""){echo $propertyLatitude;} else {echo "38.886757140695906";} ?>">
    <input type="hidden" name="p_map_longitude" id="p_map_longitude" value="<?php if(isset($propertyLongitude) && $propertyLongitude !=""){echo $propertyLongitude;} else {echo "22.3187255859375";} ?>">
    <div class="width690 pad-top20">
    <table width="690" border="0" cellspacing="0" cellpadding="0" class="pad-top7">
        <tr>
            <td align="left" valign="top">
                <div class="FloatLft font16-darkgrey"><?php echo tranText('where_is_your_accommodation?'); ?></div>
                <div class="FloatRgt"><a href="#" onclick="return frmSubmit();" class="button-blue">save details</a></div>
            </td>
        </tr>
        <tr>
            <td align="left" valign="top">
                <table width="690" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td align="left" valign="top" width="105px">Country<span class="pink">*</span></td>
						<td align="left" valign="top" width="250px">
							<select name="txtPropertyCountry" id="txtPropertyCountryId" onchange="return chkSelectCountry();" style="display:block;" class="select216_5">
								<option value="">Please Select...</option>
								<?php $locationObj->fun_getCountriesOptionsList($propertyInfo['country_id'], " WHERE countries_id in (".$locationObj->fun_getCountryIdHavingArea().")");?>
							</select>
						</td>
						<td align="left" valign="top">&nbsp;</td>
					</tr>
					<tr>
						<td align="left" valign="top">Region<span class="pink">*</span></td>
						<td align="left" valign="top">
							<select name="txtPropertyArea" id="txtPropertyAreaId" onchange="chkSelectArea();" style="display:block;" class="select216_5">
								<option value="0">Please Select...</option>
								<?php 
									$locationObj->fun_getAreaListOptions($propertyInfo['area_id'], $propertyInfo['country_id']);
								?>
							</select>
						</td>
						<td align="left" valign="top">&nbsp;</td>
					</tr>
					<tr>
						<td align="left" valign="top">Town/Area<span class="pink">*</span></td>
						<td align="left" valign="top" class="pad-btm5">
							<select name="txtPropertyRegionId" id="txtPropertyRegionId" style="display:block;" class="select216_5">
								<option value="0">Please Select...</option>
								<?php 
									$locationObj->fun_getRegionListOptions($propertyInfo['region_id'], '0', $propertyInfo['area_id']);
								?>
							</select>
							<input name="txtPropertyRegion" id="txtPropertyRegion" class="inpuTxt260" style="display:none;" value="<?php echo ucwords(strtolower($locationObj->fun_getRegionNameById($propertyInfo['region_id']))); ?>">
						</td>
						<td align="left" valign="top"><?php echo tranText('not_found'); ?> <a href="javascript:void(0);" onclick="notFoundRegion();" class="blue-link">click here</a></td>
					</tr>

					<tr>
						<td align="left" valign="top">Address<span class="pink">*</span></td>
						<td align="left" valign="top" class="pad-btm5">
							<input name="txtPropertyLocation" id="txtPropertyLocationId" class="inpuTxt260" style="display:block;" value="<?php echo ucwords(strtolower($locationObj->fun_getLocationNameById($propertyInfo['location_id']))); ?>">
						</td>
						<td align="left" valign="top"><span style="color:#333333; font-size:11px;"><?php echo tranText('eg_village_or_nearest_named_location'); ?></span></td>
					</tr>
					<tr>
						<td align="left" valign="top"><?php echo tranText('postcode'); ?></td>
						<td align="left" valign="top" class="pad-btm15">
							<input name="txtPropertyPostcode" id="txtPropertyPostcodeId" class="inpuTxt260" style="display:block;" value="<?php echo $propertyInfo['zip']; ?>">
						</td>
						<td align="left" valign="top"><span style="color:#333333; font-size:11px;"><?php echo tranText('note_please_use_the_full_postcode_zip_code_for_the_property_This_may_include_international_and_regional_codes'); ?></span></td>
					</tr>
					<tr>
						<td align="left" valign="top">&nbsp;</td>
						<td align="right" valign="top" class="pad-btm5 pad-rgt5">
							<a href="JavaScript:void(0);" onclick="return showPropertyOnMap();"><img src="<?php echo SITE_IMAGES;?>findpropertyonmap.gif" alt="Find Property on Map" border="0" /></a>
						</td>
						<td align="left" valign="top">
							<div class="FloatLft">
								<span class="error" id="showErrorPropertyLocationId"><?php if(array_key_exists('txtPropertyLocation', $form_array)) echo $form_array['txtPropertyLocation'];?></span>
							</div>
						</td>
					</tr>
				</table>
			</td>
		</tr>
<!--
        <tr><td align="left" valign="top" class="font12">Can't find it? <a href="owner-contact-us.php?sbj=10&pid=<?php //echo $property_id; ?>" class="blue-link">Contact us</a> and tell us where it is</td></tr>
        <tr><td align="left" valign="top"><div class="width690 dash41">&nbsp;</div></td></tr>
-->

        <tr>
            <td align="left" valign="top" style="padding-top:20px;">
                <!-- THIS TABLE IS FOR SHOW GOOGLE MAP: START HERE -->
                <table width="690" border="0" cellspacing="0" cellpadding="0">
					<tr><td align="left" valign="top"><div class="FloatLft font16-darkgrey"><?php echo tranText('now_find_it_on_the_google_map'); ?></div></td></tr>
					<tr>
						<td align="left" valign="top" style="padding-right:0px;padding-top:5px;padding-bottom:15px;">
						<?php echo tranText('to_move_the_pin_to_the_exact_location_of_your_accommodation_just_click_and_hold_on_the_marker_drag_it_to_the_exact_position_and_drop_it'); ?>					</tr>
                    <tr>
                        <td align="left" valign="top" width="690">
                            <div id="p_map_map" style="width: 688px; height:450px; float:left; border:1px solid #999999; text-align:center;"></div>
						</td>
					</tr>
                </table>
                <!-- THIS TABLE IS FOR SHOW GOOGLE MAP: END HERE -->
            </td>
        </tr>
        <tr><td align="left" valign="top"><div class="width690 dash41">&nbsp;</div></td></tr>
		<tr><td align="left" valign="top" class="owner-headings">How to get there</td></tr>
		<tr>
			<td align="left" valign="top" class="pad-btm15">
			Remember at this stage you don&rsquo;t have to give a detailed route plan. Just give a simple description of how to get to your property <a href="#" onclick="MM_openWindow('property-add-location-help-pop-up.php','childwindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=700,height=800')" class="blue-link">see examples</a> You can send your client more a more detailed description when they&rsquo;ve booked.
			</td>
		</tr>
		<tr>
			<td align="left" valign="top">
				<textarea name="textPropertyLocationGuideNote" id="textPropertyLocationGuideNoteId" class="txtarea_500x80"><?php if(isset($_POST['textPropertyLocationGuideNote'])){echo $_POST['textPropertyLocationGuideNote'];}else{echo $propertyInfo['location_guide'];}?></textarea>
			</td>
		</tr>
        <tr><td align="left" valign="top"><?php 
                        if($display_lang == 1) {
                            echo '<br />';
                            for($i = 0; $i < count($display_lang_arr); $i++) {
                                $lang_code = $display_lang_arr[$i]['lang_code'];
                                $lang_name = $display_lang_arr[$i]['name'];
                                echo '<a href="#" onclick="MM_openWindow(\'property-multilingual.php?property_id='.$property_id.'&lang_code='.$lang_code.'&field=property_name&type=textbox&limit=25\', \'childwindow\', \'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=800,height=600\')" class="blue-link"  title="'.$lang_name.'"><img src="images/flag/'.$lang_code.'.png" width="15" border="0" alt="'.$lang_name.'" /></a>&nbsp;';
                            }
                        }
                        ?><div class="width690 dash41">&nbsp;</div></td></tr>
        <tr>
            <td align="left" valign="top">
                <!--++++++   THIS TABLE IS FOR CONVERT DISTANCE INTO MILES AND KILOMETERS START HERE  +++++-->
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="left" valign="top" class="owner-headings"><?php echo tranText('distances'); ?></td>
                        <td align="right">
                            <table border="0" align="right" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="right" style="padding-right:6px;"><?php echo tranText('distances_calculated_in'); ?></td>
                                    <td align="right">
                                        <?php
                                            $distancetype = $propertyObj->fun_getPropertyLandmarkDistanceType($property_id);
                                        ?>
                                        <select name="txtDistanceType" id="txtDistanceTypeId" class="miles" style="width:84px" onchange="changeDistance(this.value);">
                                            <option value="k" <?php if(!isset($distancetype)||($distancetype =="k")){echo "selected";} ?>>Kilometers</option>								
                                            <option value="m" <?php if($distancetype =="m"){echo "selected";} ?>>Miles</option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <!--+++++  THIS TABLE IS FOR CONVERT DISTANCE INTO MILES AND KILOMETERS END HERE  +++++-->
            </td>
        </tr>
        <tr>
            <td align="left" valign="top">
                <div id="showDistances">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="left" valign="top" class="pad-btm10">
                       <?php echo tranText('how_far_away_are_the_following_from_your_property_If_the_airport_is_km_away_then_select_km_from_the_dropdown_and_then_into_the_box_next_to_airport'); ?><br /><br />
                        <span class="black">NB:</span> <?php echo tranText('leave_a_field_blank_if_it_too_far_away_to_be_useful'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" class="pad-btm10">
                            <!--++++++   THIS TABLE IS FOR SHOW ALL DISTANCES START HERE  ++++++-->
                            <?php
                                $propertyObj->fun_createPropertyLandmarks($property_id);
                            ?>
                            <!--++++++   THIS TABLE IS FOR SHOW ALL DISTANCES END HERE  ++++++-->
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" bgcolor="#e8eaee">
                            <?php
                                $propertyObj->fun_createPropertyExtraLandmarks($property_id);
                            ?>
                            <input type="hidden" value="<?php echo ($propertyObj->fun_countPropertyExtraLandmarks($property_id)+1); ?>" id="theValue" />
                            <div id="myDiv1"> </div>                                
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top" class="pad-btm15 pad-top10"><a href="JavaScript:void(0);" onclick="return addEvent();" class="add-photo"><?php echo tranText('add_another_distance'); ?></a>&nbsp;<?php echo tranText('such_as_distance_from_a_local_landmark_or_feature'); ?></td>
                    </tr>
                </table>
                </div>
            </td>
        </tr>
        <tr>
            <td align="left" valign="top"><div class="width690 dash41">&nbsp;</div></td>
        </tr> 
        <tr>
            <td align="left" valign="top" class="owner-headings"><?php echo tranText('describe_the_area'); ?></td>
        </tr>
        <tr>
            <td align="left" valign="top" class="pad-btm15">
                <?php echo tranText('this_is_your_chance_to_tell_holidaymakers_what_the_area_is_really_like_Give_them_details_such_as_great_places_to_eat_or_things_to_do_and_see_Holidaymakers_are_not_just_choosing_your_accommodation_they_are_choosing_your_location_too'); ?> <a href="#" onclick="MM_openWindow('property-add-location-help-pop-up.php','childwindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=700,height=800')" class="blue-link">see examples</a>
            </td>
        </tr>
        <tr>
            <td align="left" valign="top">
            <textarea name="textPropertyAreaNote" id="textPropertyAreaNoteId" class="txtarea_500x80"><?php if(isset($_POST['textPropertyAreaNote'])){echo $_POST['textPropertyAreaNote'];}else{echo $propertyInfo['area_notes'];}?></textarea>
            </td>
        </tr>
    </table>
	</div>
	<div class="width690 dash41"></div>
	<div class="width690">
		<div class="FloatRgt">
        <a href="#" onclick="return frmSubmit();"class="button-blue">save details</a>
        </div>
	</div>
</form>
<!--Location Content Ends Here -->
<!-- Map code: Start here -->
<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
	var map;
	var marker;
	var markersArray = [];
	var Options = [];
	var geocoder;
	var country4map;
	var area4map;
	var town4map;
	var region4map;
	var subregion4map;
	var location4map;
	var zip4map;

	function showLocation() {
		//area4map = document.getElementById('txtPropertyAreaId')[document.getElementById('txtPropertyAreaId').selectedIndex].innerHTML;
		//region4map = document.getElementById('txtPropertyRegionId')[document.getElementById('txtPropertyRegionId').selectedIndex].innerHTML;
		//subregion4map = document.getElementById('txtPropertySubRegionId')[document.getElementById('txtPropertySubRegionId').selectedIndex].innerHTML;
		location4map = document.getElementById('txtPropertyLocationId')[document.getElementById('txtPropertyLocationId').selectedIndex].innerHTML;
		var address = location4map;
		geocoder.geocode({ 'address': address}, addAddressToMap);  
	}
	
	function showSubRegion() {
		subregion4map = document.getElementById('txtPropertySubRegionId')[document.getElementById('txtPropertySubRegionId').selectedIndex].innerHTML;
		var address = subregion4map;
		geocoder.geocode({ 'address': address}, addAddressToMap);  
	}
	
	function showRegion() {
		region4map = document.getElementById('txtPropertyRegionId')[document.getElementById('txtPropertyRegionId').selectedIndex].innerHTML;
		var address = region4map;
		geocoder.geocode({ 'address': address}, addAddressToMap);  
	}
	
	function showArea() {
		area4map = document.getElementById('txtPropertyAreaId')[document.getElementById('txtPropertyAreaId').selectedIndex].innerHTML;
		var address = area4map;
		geocoder.geocode({ 'address': address}, addAddressToMap);  
	}
	
	function showPropertyOnMap() {
		if(document.getElementById("txtPropertyCountryId").value == "") {
			document.getElementById("showErrorPropertyLocationId").innerHTML = "Please select country name";
			return false;
		}
		if(document.getElementById("txtPropertyAreaId").value == "") {
			document.getElementById("showErrorPropertyLocationId").innerHTML = "Please select region name";
			return false;
		}
	
		document.getElementById("showErrorPropertyLocationId").innerHTML = "";
		country4map = document.getElementById('txtPropertyCountryId')[document.getElementById('txtPropertyCountryId').selectedIndex].innerHTML;
		area4map = document.getElementById('txtPropertyAreaId')[document.getElementById('txtPropertyAreaId').selectedIndex].innerHTML;
		//town4map = document.getElementById('txtPropertyRegionId').value;
		//location4map = document.getElementById('txtPropertyLocationId').value;
		zip4map = document.getElementById('txtPropertyPostcodeId').value;
		var address = area4map;
		address += ", "+country4map+". "+zip4map;
		geocoder.geocode({ 'address': address}, addAddressToMap);  
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
				title:"<?php echo $property_name; ?>"
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
		if((isset($propertyLatitude) && $propertyLatitude !="") && (isset($propertyLongitude) && $propertyLongitude !="")){
		?>
			var strlatitude = <?php echo $propertyLatitude; ?>;
			var strlongitude = <?php echo $propertyLongitude; ?>;
			var zoomLevel = <?php echo $mapZoomLevel; ?>;
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
				title:"<?php echo $property_name; ?>"
			});   
			/*
			google.maps.event.addListener(map, "click", function(event) { 
				if(marker!=null) return false; 
				var point = map.getPosition();
				var c = new google.maps.LatLng(point.lat(), point.lng());
				map.panTo(c); 
				la = document.getElementById("p_map_latitude"); 
				la.value = c.lat(); 
				lo = document.getElementById("p_map_longitude"); 
				lo.value = c.lng();
				marker.setPoint(c); 
			});
			*/
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
		} else {
		?>
			var zoomLevel = <?php echo $mapZoomLevel; ?>;
			country4map = document.getElementById('txtPropertyCountryId')[document.getElementById('txtPropertyCountryId').selectedIndex].innerHTML;
			area4map = document.getElementById('txtPropertyAreaId')[document.getElementById('txtPropertyAreaId').selectedIndex].innerHTML;
			var address = area4map;
			address += ", "+country4map;

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
