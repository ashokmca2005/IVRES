<!-- TinyMCE -->
<script type="text/javascript" src="tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		mode : "exact",
		elements : "txtResourceDescId",
		theme : "simple",
		plugins : 'advlink,advimage',
		relative_urls : false,
		remove_script_host : false
	});
</script>
<!-- /TinyMCE -->
<script language="javascript" type="text/javascript">
	var req = ajaxFunction();
	/*
	* For Location : Start here
	*/
	function chkSelectArea() {
		var getID=document.getElementById("txtAreaId").value;
		if(getID !="" && getID != "0"){
			sendRegionRequest(getID);
			document.getElementById("txtRegionId").value = "0";
			document.getElementById("txtSubRegionId").value = "0";
			document.getElementById("txtLocationId").value = "0";
		}
		if(getID == "0" || getID =="") {
			document.getElementById("txtAreaId").value = "0";
			document.getElementById("txtRegionId").value = "0";
			document.getElementById("txtSubRegionId").value = "0";
			document.getElementById("txtLocationId").value = "0";
			document.getElementById("txtSubRegionId").style.display = "none";
			document.getElementById("txtLocationId").style.display = "none";
		}
	}
	
	function chkSelectRegion() {
		var getID=document.getElementById("txtRegionId").value;
		if(getID !="" && getID != "0"){
			sendSubRegionRequest(getID);
			document.getElementById("txtSubRegionId").value = "0";
			document.getElementById("txtLocationId").value = "0";
		}
		if(getID == "0" || getID =="") {
			document.getElementById("txtRegionId").value = "0";
			document.getElementById("txtSubRegionId").value = "0";
			document.getElementById("txtLocationId").value = "0";
			document.getElementById("txtSubRegionId").style.display = "none";
			document.getElementById("txtLocationId").style.display = "none";
		}
	}
	
	function chkSelectSubRegion() {
		var getID=document.getElementById("txtSubRegionId").value;
		if(getID !="" && getID != "0"){
			sendLocationRequest(getID);
			document.getElementById("txtLocationId").value = "0";
		}
		if(getID == "0" || getID =="") {
			document.getElementById("txtSubRegionId").value = "0";
			document.getElementById("txtLocationId").value = "0";
			document.getElementById("txtLocationId").style.display = "none";
			alert(document.getElementById("txtSubRegionId").value);
		}
	}

	function chkSelectLocation() {
		var getID=document.getElementById("txtLocationId").value;
		if(getID !="" && getID != "0"){
		}
		if(getID == "0" || getID =="") {
			document.getElementById("txtLocationId").value = "0";
		}
	}	

	function sendAreaRequest(id) { 
		req.open('get', '<?php echo SITE_URL;?>selectAreaXml.php?id=' + id); 
		req.onreadystatechange = handleAreaResponse; 
		req.send(null); 
	} 
	
	function sendRegionRequest(id) { 
		req.open('get', '<?php echo SITE_URL;?>selectRegionXml.php?id=' + id); 
		req.onreadystatechange = handleRegionResponse; 
		req.send(null); 
	} 
	
	function sendSubRegionRequest(id) { 
		req.open('get', '<?php echo SITE_URL;?>selectSubRegionXml.php?id=' + id); 
		req.onreadystatechange = handleSubRegionResponse; 
		req.send(null); 
	} 
	
	function sendLocationRequest(id) { 
		req.open('get', '<?php echo SITE_URL;?>selectLocationXml.php?id=' + id); 
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
				document.getElementById("txtAreaId").style.display = "block";
				document.getElementById("txtRegionId").style.display = "none";
				document.getElementById("txtSubRegionId").style.display = "none";
				document.getElementById("txtLocationId").style.display = "none";
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
					var p_city=document.getElementById("txtAreaId");
					p_city.length=0;
					p_city.options[0]=new Option("Please Select...","");
					for(var j=0; j<arrayOfId.length; j++) {
						p_city.options[j+1]=new Option(arrayOfNames[j], arrayOfId[j]);
					}
				} else {
					document.getElementById("txtAreaId").style.display = "none";
				}
			} else {
				document.getElementById("txtAreaId").style.display = "none";
				document.getElementById("txtRegionId").style.display = "none";
				document.getElementById("txtSubRegionId").style.display = "none";
				document.getElementById("txtLocationId").style.display = "none";
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
				document.getElementById("txtRegionId").style.display = "block";
				document.getElementById("txtSubRegionId").style.display = "none";
				document.getElementById("txtLocationId").style.display = "none";
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
					var p_city=document.getElementById("txtRegionId");

					p_city.length=0;
					p_city.options[0]=new Option("All Areas ...","0");
					for(var j=0; j<arrayOfId.length; j++) {
						p_city.options[j+1]=new Option(arrayOfNames[j],arrayOfId[j]);
					}
//					sendSubRegionRequest(1);
				} else {
					document.getElementById("txtRegionId").style.display = "none";
				}
			} else {
				document.getElementById("txtRegionId").style.display = "none";
				document.getElementById("txtSubRegionId").style.display = "none";
				document.getElementById("txtLocationId").style.display = "none";
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
				document.getElementById("txtSubRegionId").style.display = "block";
				document.getElementById("txtLocationId").style.display = "none";
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
					var p_city=document.getElementById("txtSubRegionId");
					p_city.length=0;
					p_city.options[0]=new Option("All Areas ...", "0");
					for(var j=0; j<arrayOfId.length; j++) {
						p_city.options[j+1]=new Option(arrayOfNames[j], arrayOfId[j]);
					}
//					sendLocationRequest(9);
				} else {
					document.getElementById("txtSubRegionId").style.display = "none";
					sendLocationRequest(document.getElementById("txtRegionId").value);
				}
			} else {
				document.getElementById("txtSubRegionId").style.display = "none";
				document.getElementById("txtLocationId").style.display = "none";
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
			if(root != null) {
				document.getElementById("txtLocationId").style.display = "block";
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
					var p_city=document.getElementById("txtLocationId");
					p_city.length=0;
					p_city.options[0]=new Option("All Areas ...","0");

					for(var j=0; j<arrayOfId.length; j++) {
						p_city.options[j+1]=new Option(arrayOfNames[j], arrayOfId[j]);
					}

				} else {
					document.getElementById("txtLocationId").style.display = "none";
				}
			} else {
				document.getElementById("txtLocationId").style.display = "none";
			}
		} 
	}

	/*
	* For Location : End here
	*/

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

	function cancelAddResource() {
		window.location = 'resources.php';
	}

	function validateAddResource() {
	}
</script>
<table width="690" border="0" cellspacing="0" cellpadding="0" class="font12">
    <tr>
        <td align="left" valign="top">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr><td valign="top" class="pad-rgt10"><h1 class="page-headingNew">Add your own resource</h1></td></tr>
                <tr>
                	<td align="left" valign="bottom" class="pad-top10">
                        Do you have a quality website tht might be of use to holidaymakers visiting the site? If so then just fill out the form below, place a link to us on your own website and then when we’ve checked that the link is in place and that your website is suitable (no gambling or adult sites please!) we’ll place a link in this section for our holidaymakers to search and use.
                        <br /><br />
                        If you have any questions then please <a href="holiday-contact-us.php" class="blue-link">contact us</a>.
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="left" valign="top">
            <div class="pad-btm20">
            <table width="690" border="0" cellspacing="0" cellpadding="0" class="font12">
                <tr><td width="690" align="left" valign="bottom">&nbsp;</td></tr>
                <tr>
                    <td align="left" valign="bottom">
                        <form name="frmResources" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                        <input type="hidden" name="securityKey" value="<?php echo md5(RESOURCES);?>" />
                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="left" valign="top">
                                    <table width="100%" border="0" cellpadding="5" cellspacing="0">
                                        <tr>
                                            <td width="195" align="right" valign="middle">First name</td>
                                            <td width="235" valign="middle"><span class="RegFormRight"><input name="txtUserFName" type="text" class="RegFormFld" id="txtUserFNameId" value="<?php if(isset($_POST['txtUserFName'])){echo $_POST['txtUserFName'];}else{echo $userInfoArr['user_fname'];}?>" onkeydown="chkblnkTxtError('txtUserFNameId', 'showErrorUserFNameId');" onkeyup="chkblnkTxtError('txtUserFNameId', 'showErrorUserFNameId');" /></span></td>
                                            <td width="234" valign="top"><span class="pdError1" id="showErrorUserFNameId"><?php if(array_key_exists('txtUserFName', $form_array)) echo $form_array['txtUserFName'];?></span></td>
                                        </tr>
                                        <tr>
                                            <td align="right" valign="middle">Last name</td>
                                            <td valign="middle"><span class="RegFormRight"><input name="txtUserLName" type="text" class="RegFormFld" id="txtUserLNameId" value="<?php if(isset($_POST['txtUserLName'])){echo $_POST['txtUserLName'];}else{echo $userInfoArr['user_lname'];}?>" onkeydown="chkblnkTxtError('txtUserLNameId', 'showErrorUserLNameId');" onkeyup="chkblnkTxtError('txtUserLNameId', 'showErrorUserLNameId');" /></span></td>
                                            <td valign="top"><span class="pdError1" id="showErrorUserLNameId"><?php if(array_key_exists('txtUserLName', $form_array)) echo $form_array['txtUserLName'];?></span></td>
                                        </tr>
                                        <tr>
                                            <td align="right" valign="middle">Email address</td>
                                            <td valign="middle"><span class="RegFormRight"><input name="txtUserEmail" type="text" class="RegFormFld" id="txtUserEmailId" value="<?php if(isset($_POST['txtUserEmail'])){echo $_POST['txtUserEmail'];}else{echo $userInfoArr['user_email'];}?>" /></span></td>
                                            <td valign="top"><span class="pdError1" id="showErrorUserEmailId"><?php if(array_key_exists('txtUserEmail', $form_array)) echo $form_array['txtUserEmail']."<br><a href=\"forget-password.php\" class=\"blue-link\" >Send me a password reminder</a>";?></span></td>
                                        </tr>
                                        <tr>
                                            <td align="right" valign="middle">Choose a category</td>
                                            <td valign="middle">
                                                <span class="RegFormRight">
                                                    <select name="txtResourceCategory" class="select230">
                                                        <option value="" disabled="disabled" selected="selected">Select ...</option>
                                                        <?php 
                                                        if(isset($_POST['txtResourceCategory'])){
                                                            $resources_categories_id = $_POST['txtResourceCategory'];
                                                        } else if(isset($txtResourceCategory) && $txtResourceCategory != ""){
                                                            $resources_categories_id = $txtResourceCategory;
                                                        }
                                                        $resObj->fun_getResourcesCatListOptions($resources_categories_id);
                                                        ?>
                                                    </select>                    
                                                </span>
                                            </td>
                                            <td valign="top">
                                                <span class="pdError1" id="showErrorResourceCategory">
                                                    <?php 
                                                    if(array_key_exists('txtResourceCategory', $form_array)) { 
                                                        echo $form_array['txtResourceCategory'];
                                                    }
                                                    ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="right" valign="top">Your resource would be ideal for people visiting which location</td>
                                            <td valign="middle">
                                                <div id="showtxtlocationcombo" class="pad-btm3">
                                                    <select name="txtArea" id="txtAreaId" onchange="return chkSelectArea();" style="display:block;" class="select230_15">
                                                        <?php 
                                                        if(isset($eventInfoArr['event_area_id']) && $eventInfoArr['event_area_id'] != "") {
                                                            $locationObj->fun_getAreaListOptions($eventInfoArr['event_area_id'], '193');
                                                        } else {
                                                            $locationObj->fun_getAreaListOptions('1', '193');
                                                        }
                                                        ?>
                                                    </select>
                                                    <select name="txtRegion" id="txtRegionId" onchange="return chkSelectRegion();" style="display:<?php if(isset($eventInfoArr['event_region_id']) && ($eventInfoArr['event_region_id'] != "0")) { echo "block";} else { echo "block";} ?>;" class="select230_15">
                                                        <option value="0" <?php if(isset($eventInfoArr['event_region_id']) && ($eventInfoArr['event_region_id'] == "0")) {echo "selected";} ?> >All Areas ...</option>
                                                        <?php 
                                                        if(isset($eventInfoArr['event_region_id']) && ($eventInfoArr['event_region_id'] != "0") && ($eventInfoArr['event_region_id'] != "") && isset($eventInfoArr['event_area_id']) && ($eventInfoArr['event_area_id'] != "0") && ($eventInfoArr['event_area_id'] != "")) {
                                                            $locationObj->fun_getRegionListOptions($eventInfoArr['event_region_id'], '0', $eventInfoArr['event_area_id']);
                                                        } else {
                                                            $locationObj->fun_getRegionListOptions('', '0', '1');
                                                        }
                                                        ?>
                                                    </select>
                                                    <?php 
                                                    if(isset($eventInfoArr['event_region_id']) && ($eventInfoArr['event_region_id'] != "0") && ($locationObj->fun_getRegionPid($eventInfoArr['event_region_id']) == "0") && ($locationObj->fun_countSubRegionByRegionid($eventInfoArr['event_region_id']) > 0) && ((isset($eventInfoArr['event_sub_region_id']) && $eventInfoArr['event_sub_region_id'] == "0") || !isset($eventInfoArr['event_sub_region_id']))) {
                                                    ?>
                                                    <select name="txtSubRegion" id="txtSubRegionId" onchange="return chkSelectSubRegion();" style="display:block;" class="select230_15">
                                                        <option value="0" selected>All Areas ...</option>
                                                        <?php 
                                                            $locationObj->fun_getRegionListOptions('', $eventInfoArr['event_region_id'], $eventInfoArr['event_area_id']);
                                                        ?>
                                                    </select>
                                                    <?php
                                                    } else {
                                                    ?>
                                                    <select name="txtSubRegion" id="txtSubRegionId" onchange="return chkSelectSubRegion();" style="display:<?php if(isset($eventInfoArr['event_sub_region_id']) && ($eventInfoArr['event_sub_region_id'] != "0")) { echo "block";} else { echo "none";} ?>;" class="select230_15">
                                                        <option value="0" <?php if(isset($eventInfoArr['event_sub_region_id']) && ($eventInfoArr['event_sub_region_id'] == "0")) {echo "selected";} ?> >All Areas ...</option>
                                                        <?php 
                                                        if(isset($eventInfoArr['event_sub_region_id']) && ($eventInfoArr['event_sub_region_id'] != "0") && ($eventInfoArr['event_sub_region_id'] != "") && isset($eventInfoArr['event_region_id']) && ($eventInfoArr['event_region_id'] != "0") && ($eventInfoArr['event_region_id'] != "")) {
                                                            $locationObj->fun_getRegionListOptions($eventInfoArr['event_sub_region_id'], $eventInfoArr['event_region_id'], $eventInfoArr['event_area_id']);
                                                        } else {
                                                            $locationObj->fun_getRegionListOptions('', '1', '1');
                                                        }
                                                        ?>
                                                    </select>
                                                    <?php
                                                    }
                                                    ?>
                                                    <?php 
                                                    if(isset($eventInfoArr['event_sub_region_id']) && ($eventInfoArr['event_sub_region_id'] != "0") && ((isset($eventInfoArr['event_location_id']) && $eventInfoArr['event_location_id'] == "0") || !isset($eventInfoArr['event_location_id']))) {
                                                    ?>
                                                    <select name="txtLocation" id="txtLocationId" onchange="return chkSelectLocation();" style="display:block;" class="select230_15">
                                                        <option value="0" selected>All Areas ...</option>
                                                        <?php 
                                                            $locationObj->fun_getLocationListOptions('', $eventInfoArr['event_sub_region_id']);
                                                        ?>
                                                    </select>
                                                    <?php
                                                    } else if(isset($eventInfoArr['event_region_id']) && ($eventInfoArr['event_region_id'] != "0") && ($locationObj->fun_countSubRegionByRegionid($eventInfoArr['event_region_id']) == 0) && ((isset($eventInfoArr['event_location_id']) && $eventInfoArr['event_location_id'] == "0") || !isset($eventInfoArr['event_location_id']))) {
                                                    ?>
                                                    <select name="txtLocation" id="txtLocationId" onchange="return chkSelectLocation();" style="display:block;" class="select230_15">
                                                        <option value="0" selected>All Areas ...</option>
                                                        <?php 
                                                            $locationObj->fun_getLocationListOptions('', $eventInfoArr['event_region_id']);
                                                        ?>
                                                    </select>
                                                    <?php
                                                    } else {
                                                    ?>
                                                    <select name="txtLocation" id="txtLocationId" onchange="return chkSelectLocation();" style="display:<?php if(isset($eventInfoArr['event_location_id']) && ($eventInfoArr['event_location_id'] != "0")) { echo "block";} else { echo "none";} ?>;" class="select230_15">
                                                        <option value="0" <?php if(isset($eventInfoArr['event_location_id']) && ($eventInfoArr['event_location_id'] == "0")) {echo "selected";} ?> >All Areas ...</option>
                                                        <?php 
                                                        if(isset($eventInfoArr['event_location_id']) && ($eventInfoArr['event_location_id'] != "0") && ($eventInfoArr['event_location_id'] != "")) {
                                                            $locationObj->fun_getLocationListOptions($eventInfoArr['event_location_id']);
                                                        } else {
                                                            $locationObj->fun_getLocationListOptions();
                                                        }
                                                        ?>
                                                    </select>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>									
                                            </td>
                                            <td valign="top">
                                                <span class="pdError1" id="txtLocationErrorId">
                                                    <?php 
                                                    if(array_key_exists('txtLocation', $form_array)) { 
                                                        echo $form_array['txtLocation'];
                                                    }
                                                    ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="right" valign="middle">Where do you want your resource to link to?</td>
                                            <td valign="middle"><span class="RegFormRight"><input name="txtResourceUrl" type="text" class="RegFormFld" id="txtResourceUrlId" value="<?php if(isset($_POST['txtResourceUrl'])){echo $_POST['txtResourceUrl'];} else {echo "http://";}?>" onkeydown="chkblnkTxtError('txtResourceUrlId', 'showErrorResourceUrlId');" onkeyup="chkblnkTxtError('txtResourceUrlId', 'showErrorResourceUrlId');" /></span></td>
                                            <td valign="top"><span class="pdError1" id="showErrorResourceUrlId"><?php if(array_key_exists('txtResourceUrl', $form_array)) echo $form_array['txtResourceUrl'];?></span></td>
                                        </tr>
                                        <tr>
                                            <td align="right" valign="middle">Title of your link</td>
                                            <td valign="middle"><span class="RegFormRight"><input name="txtResourceTitle" type="text" class="RegFormFld" id="txtResourceTitleId" value="<?php if(isset($_POST['txtResourceTitle'])){echo $_POST['txtResourceTitle'];} else {echo "";}?>" onkeydown="chkblnkTxtError('txtResourceTitleId', 'showErrorResourceTitleId');" onkeyup="chkblnkTxtError('txtResourceTitleId', 'showErrorResourceTitleId');" /></span></td>
                                            <td valign="top"><span class="pdError1" id="showErrorResourceTitleId"><?php if(array_key_exists('txtResourceTitle', $form_array)) echo $form_array['txtResourceTitle'];?></span></td>
                                        </tr>
                                        <tr>
                                            <td align="right" valign="top">Description</td>
                                            <td colspan="2" valign="middle">
                                            	<textarea name="txtResourceDesc" id="txtResourceDescId" class="textArea460" ><?php echo stripcslashes($eventInfoArr['event_description']); ?></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="right" valign="top">&nbsp;</td>
                                            <td colspan="2" valign="middle">
                                            	<span class="pdError1" id="txtResourceDescErrorId"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="right" valign="middle">Where will our link appear on your website</td>
                                            <td valign="middle"><span class="RegFormRight"><input name="txtResourceOLUrl" type="text" class="RegFormFld" id="txtResourceOLUrlId" value="<?php if(isset($_POST['txtResourceOLUrl'])){echo $_POST['txtResourceOLUrl']."";} else {echo "http://";}?>" onkeydown="chkblnkTxtError('txtResourceOLUrlId', 'showErrorResourceTitleId');" onkeyup="chkblnkTxtError('txtResourceOLUrlId', 'showErrorResourceTitleId');" /></span></td>
                                            <td valign="top"><span class="pdError1" id="showErrorResourceTitleId"><?php if(array_key_exists('txtResourceOLUrl', $form_array)) echo $form_array['txtResourceOLUrl'];?></span></td>
                                        </tr>
                                        <tr>
                                            <td align="right" valign="middle">&nbsp;</td>
                                            <td colspan="2" valign="middle">By clicking submit you are agreeing to our <a href="javascript:popcontact('terms.html')" class="blue-link">terms and conditions</a></td>
                                        </tr>
                                        <tr><td colspan="3" align="right" valign="middle" class="dash25">&nbsp;</td></tr>
                                        <tr>
                                            <td align="right" valign="middle">&nbsp;</td>
                                            <td colspan="2" valign="middle"><a href="javascript:cancelAddResource();"><img src="<?php echo SITE_IMAGES;?>cancel-gray.gif" alt="Cancel" width="81" height="27" /></a>&nbsp;&nbsp;<input type="image" src="<?php echo SITE_IMAGES;?>submit.gif" alt="Submit" name="Submit" width="81" height="27" border="0" id="SubmitId" onclick="return validateAddResource();"></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        </form>
                    </td>
                </tr>
                <tr><td width="690" valign="top">&nbsp;</td></tr>
            </table>
            </div>
        </td>
    </tr>
</table>