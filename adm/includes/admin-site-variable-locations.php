<?php
// Form submision
$detail_array 	= array();
$error_msg		= 'no';

if($_POST['securityKey']==md5(EDITLOCATION)){
	$txtAreaName 			= fun_db_input($_POST['txtAreaName']);
	$txtAreaDesc 			= html_entity_decode(fun_db_input($_POST['txtAreaDesc']));

	if(isset($_POST['txtHiddenLocation']) && $_POST['txtHiddenLocation'] > 0) {
		$txtHiddenLocationId 	= $_POST['txtHiddenLocation'];
		$locationObj->fun_editLocation($txtHiddenLocationId, $txtAreaName, $txtAreaDesc);
	} else if(isset($_POST['txtHiddenRegion']) && $_POST['txtHiddenRegion'] > 0) {
		$txtHiddenRegionId 	= $_POST['txtHiddenRegion'];
		$locationObj->fun_editRegion($txtHiddenRegionId, $txtAreaName, $txtAreaDesc);
	} else if(isset($_POST['txtHiddenArea']) && $_POST['txtHiddenArea'] > 0) {
		$txtHiddenAreaId 	= $_POST['txtHiddenArea'];
		$locationObj->fun_editArea($txtHiddenAreaId, $txtAreaName, $txtAreaDesc);
	}
/*
	echo "<script>location.href = window.location;</script>";
*/
}

$txtLocationArr = $locationObj->fun_getAreaShortInfoById(1);

//print_r($_POST);
?>
<!-- TinyMCE -->
<script type="text/javascript" src="../tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		mode : "textareas",
		elements : "txtAreaDescId",
		theme : "simple",
		plugins : 'advlink,advimage',
		relative_urls : false,
		remove_script_host : false
	});
</script>
<!-- /TinyMCE -->

<script language="javascript" type="text/javascript">
	var req = ajaxFunction();
	function frmValidateEditLocation() {
		var shwError = false;
		document.frmEditLocation.txtAreaDesc.value = tinyMCE.get('txtAreaDescId').getContent();
		if(document.frmEditLocation.txtAreaName.value == "") {
			document.getElementById("txtAreaNameErrorId").innerHTML = "Please enter Location name.";
			document.frmEditLocation.txtAreaName.focus();
			shwError = true;
		}

		if(document.frmEditLocation.txtAreaDesc.value == "") {
			document.getElementById("txtAreaDescErrorId").innerHTML = "Please enter Location description.";
			document.frmEditLocation.txtAreaDesc.focus();
			shwError = true;
		}
		
//alert(document.frmEditLocation.txtAreaName.value);
//alert(document.frmEditLocation.txtAreaDesc.value);
//alert(tinyMCE.get('txtAreaDescId').getContent());

		if(shwError == true) {
			return false;
		} else {
			document.frmEditLocation.submit();
		}
	}
	
/*
* For Add / Edit location section : Start here
*/
	function chkSelectCountry() {
		var getID=document.getElementById("txtcountryid").value;
		if(getID !="" && getID != "0"){
			sendAreaRequest(getID);
			document.getElementById("txtareaid").value = "0";
			document.getElementById("txtregionid").value = "0";
			document.getElementById("txtsubregionid").value = "0";
			document.getElementById("txtlocationid").value = "0";

			document.getElementById("txtHiddenAreaId").value = "";
			document.getElementById("txtAreaNameId").value = "";
			document.getElementById("txtAreaDescId").value = "";
			tinyMCE.execCommand('mceFocus', false, 'txtAreaDescId');
			tinyMCE.execCommand('mceSetContent', false, "");
			document.getElementById("txtAreaNameId").focus = true;
		}
		if(getID == "0" || getID =="") {
			document.getElementById("txtcountryid").value = "0";
			document.getElementById("txtareaid").value = "0";
			document.getElementById("txtregionid").value = "0";
			document.getElementById("txtsubregionid").value = "0";
			document.getElementById("txtlocationid").value = "0";
			document.getElementById("txtregionid").style.display = "none";
			document.getElementById("txtsubregionid").style.display = "none";
			document.getElementById("txtlocationid").style.display = "none";
		}
	}

	function chkSelectArea() {
		var getID=document.getElementById("txtareaid").value;
		if(getID !="" && getID != "0"){
			sendRegionRequest(getID);
			sendAreaInfoRequest(getID);
			document.getElementById("txtregionid").value = "0";
			document.getElementById("txtsubregionid").value = "0";
			document.getElementById("txtlocationid").value = "0";
		}
		if(getID == "0" || getID =="") {
			document.getElementById("txtareaid").value = "0";
			document.getElementById("txtregionid").value = "0";
			document.getElementById("txtsubregionid").value = "0";
			document.getElementById("txtlocationid").value = "0";
			document.getElementById("txtsubregionid").style.display = "none";
			document.getElementById("txtlocationid").style.display = "none";
		}
	}
	
	function chkSelectRegion() {
		var getID=document.getElementById("txtregionid").value;
		if(getID !="" && getID != "0"){
			sendSubRegionRequest(getID);
			sendRegionInfoRequest(getID);
			document.getElementById("txtsubregionid").value = "0";
			document.getElementById("txtlocationid").value = "0";
		}
		if(getID == "0" || getID =="") {
			document.getElementById("txtregionid").value = "0";
			document.getElementById("txtsubregionid").value = "0";
			document.getElementById("txtlocationid").value = "0";
			document.getElementById("txtsubregionid").style.display = "none";
			document.getElementById("txtlocationid").style.display = "none";
		}
	}
	
	function chkSelectSubRegion() {
		var getID=document.getElementById("txtsubregionid").value;
		if(getID !="" && getID != "0"){
			sendLocationRequest(getID);
			sendRegionInfoRequest(getID);
//			sendRegionInfoRequest(getID);
			document.getElementById("txtlocationid").value = "0";
		}
		if(getID == "0" || getID =="") {
			document.getElementById("txtsubregionid").value = "0";
			document.getElementById("txtlocationid").value = "0";
			document.getElementById("txtlocationid").style.display = "none";
		}
	}

	function chkSelectLocation() {
		var getID=document.getElementById("txtlocationid").value;
		if(getID !="" && getID != "0"){
			sendLocationInfoRequest(getID);
		}
		if(getID == "0" || getID =="") {
			document.getElementById("txtlocationid").value = "0";
		}
	}	

	function sendAreaRequest(id) { 
		req.open('get', '../selectAreaXml.php?id=' + id); 
		req.onreadystatechange = handleAreaResponse; 
		req.send(null); 
	} 
	
	function sendRegionRequest(id) { 
		req.open('get', '../selectRegionXml.php?id=' + id); 
		req.onreadystatechange = handleRegionResponse;
		req.send(null); 
	} 
	
	function sendSubRegionRequest(id) { 
		req.open('get', '../selectSubRegionXml.php?id=' + id); 
		req.onreadystatechange = handleSubRegionResponse; 
		req.send(null); 
	} 
	
	function sendLocationRequest(id) { 
		req.open('get', '../selectLocationXml.php?id=' + id); 
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
				document.getElementById("txtareaid").style.display = "block";
				document.getElementById("txtregionid").style.display = "none";
				document.getElementById("txtsubregionid").style.display = "none";
				document.getElementById("txtlocationid").style.display = "none";
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
					var p_city=document.getElementById("txtareaid");
					p_city.length=0;
					p_city.options[0]=new Option("Please Select...","");
					for(var j=0; j<arrayOfId.length; j++) {
						p_city.options[j+1]=new Option(arrayOfNames[j], arrayOfId[j]);
					}
				} else {
					document.getElementById("txtareaid").style.display = "none";
				}
			} else {
				document.getElementById("txtareaid").style.display = "none";
				document.getElementById("txtregionid").style.display = "none";
				document.getElementById("txtsubregionid").style.display = "none";
				document.getElementById("txtlocationid").style.display = "none";
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
				document.getElementById("txtregionid").style.display = "block";
				document.getElementById("txtsubregionid").style.display = "none";
				document.getElementById("txtlocationid").style.display = "none";
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
					var p_city=document.getElementById("txtregionid");
					p_city.length=0;
					p_city.options[0]=new Option("Select ...","0");
					for(var j=0; j<arrayOfId.length; j++) {
						p_city.options[j+1]=new Option(arrayOfNames[j],arrayOfId[j]);
					}
//					sendSubRegionRequest(1);
				} else {
					document.getElementById("txtregionid").style.display = "none";
	//				sendLocationRequest(document.getElementById("txtRegionId").value);
				}
			} else {
				document.getElementById("txtregionid").style.display = "none";
				document.getElementById("txtsubregionid").style.display = "none";
				document.getElementById("txtlocationid").style.display = "none";
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
				document.getElementById("txtsubregionid").style.display = "block";
				document.getElementById("txtlocationid").style.display = "none";
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
					var p_city=document.getElementById("txtsubregionid");
					p_city.length=0;
					p_city.options[0]=new Option("Select ...", "0");
					for(var j=0; j<arrayOfId.length; j++) {
						p_city.options[j+1]=new Option(arrayOfNames[j], arrayOfId[j]);
					}
//					sendLocationRequest(9);
				} else {
					document.getElementById("txtsubregionid").style.display = "none";
					sendLocationRequest(document.getElementById("txtregionid").value);
				}
			} else {
				document.getElementById("txtsubregionid").style.display = "none";
				document.getElementById("txtlocationid").style.display = "none";
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
				document.getElementById("txtlocationid").style.display = "block";
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
					var p_city=document.getElementById("txtlocationid");
					p_city.length=0;
					p_city.options[0]=new Option("Select ...","0");
					for(var j=0; j<arrayOfId.length; j++) {
						p_city.options[j+1]=new Option(arrayOfNames[j], arrayOfId[j]);
					}
				} else {
					document.getElementById("txtlocationid").style.display = "none";
				}
			} else {
				document.getElementById("txtlocationid").style.display = "none";
			}
		} 
	}


	function sendAreaInfoRequest(id) { 
		//alert(id);
		req.open('get', '../infoAreaXml.php?id=' + id); 
		req.onreadystatechange = handleAreaInfoResponse; 
		req.send(null); 

	} 

	function handleAreaInfoResponse() { 
		if(req.readyState == 4) { 
			var response = req.responseText; 
			xmlDoc=req.responseXML;
			//alert(response);
			var root = xmlDoc.getElementsByTagName('areas')[0];
			if(root != null) {
				var items = root.getElementsByTagName("area");
				var item = items[0];
				var id = item.getElementsByTagName("id")[0].firstChild.nodeValue;
				var name = item.getElementsByTagName("name")[0].firstChild.nodeValue;
				var description = item.getElementsByTagName("description")[0].firstChild.nodeValue;
				document.getElementById("txtHiddenLocationId").value = "";
				document.getElementById("txtHiddenRegionId").value = "";
				document.getElementById("txtHiddenAreaId").value = id;
				document.getElementById("txtAreaNameId").value = name;
				document.getElementById("txtAreaDescId").value = stripslashes(description);
//				alert(description);
				tinyMCE.execCommand('mceFocus', false, 'txtAreaDescId');
				tinyMCE.execCommand('mceSetContent', false, stripslashes(description));

//				tinyMCE.execCommand('mceCleanup', false);
//				tinyMCE.execCommand('mceInsertContent', false, description);

			} else {
				document.getElementById("txtHiddenLocationId").value = "";
				document.getElementById("txtHiddenRegionId").value = "";
				document.getElementById("txtHiddenAreaId").value = "";
				document.getElementById("txtAreaNameId").value = "";
				document.getElementById("txtAreaNameId").value = "";
			}
		} 
	} 

	function sendRegionInfoRequest(id) { 
		//alert(id);
		req.open('get', '../infoRegionXml.php?id=' + id); 
		req.onreadystatechange = handleRegionInfoResponse; 
		req.send(null); 

	} 

	function handleRegionInfoResponse() { 
		if(req.readyState == 4) { 
			var response = req.responseText; 
			xmlDoc=req.responseXML;
//			alert(response);
			var root = xmlDoc.getElementsByTagName('regions')[0];
			if(root != null) {
				var items = root.getElementsByTagName("region");
				var item = items[0];
				var id = item.getElementsByTagName("id")[0].firstChild.nodeValue;
				var name = item.getElementsByTagName("name")[0].firstChild.nodeValue;
				var description = item.getElementsByTagName("description")[0].firstChild.nodeValue;
				document.getElementById("txtHiddenLocationId").value = "";
				document.getElementById("txtHiddenRegionId").value = id;
				document.getElementById("txtAreaNameId").value = name;
				document.getElementById("txtAreaDescId").value = stripslashes(description);
//				alert(description);
				tinyMCE.execCommand('mceFocus', false, 'txtAreaDescId');
				tinyMCE.execCommand('mceSetContent', false, stripslashes(description));

//				tinyMCE.execCommand('mceCleanup', false);
//				tinyMCE.execCommand('mceInsertContent', false, description);

			} else {
				document.getElementById("txtHiddenLocationId").value = "";
				document.getElementById("txtHiddenRegionId").value = "";
				document.getElementById("txtAreaNameId").value = "";
				document.getElementById("txtAreaNameId").value = "";
			}
		} 
	} 

	function sendLocationInfoRequest(id) { 
		req.open('get', '../infoLocationXml.php?id=' + id); 
		req.onreadystatechange = handleLocationInfoResponse; 
		req.send(null); 
	} 

	function handleLocationInfoResponse() { 
		if(req.readyState == 4) { 
			var response = req.responseText; 
			xmlDoc=req.responseXML;
//			alert(response);
			var root = xmlDoc.getElementsByTagName('locations')[0];
			if(root != null) {
				var items = root.getElementsByTagName("location");
				var item = items[0];
				var id = item.getElementsByTagName("id")[0].firstChild.nodeValue;
				var name = item.getElementsByTagName("name")[0].firstChild.nodeValue;
				var description = item.getElementsByTagName("description")[0].firstChild.nodeValue;
				document.getElementById("txtHiddenLocationId").value = id;
				document.getElementById("txtAreaNameId").value = name;
				document.getElementById("txtAreaDescId").value = stripslashes(description);
				tinyMCE.execCommand('mceFocus', false, 'txtAreaDescId');
				tinyMCE.execCommand('mceSetContent', false, stripslashes(description));

//				tinyMCE.updateContent(document.getElementById("txtAreaDescId").value);

//				tinyMCE.execCommand('mceCleanup', false);
//				tinyMCE.execCommand('mceInsertContent', false, description);

			} else {
				document.getElementById("txtHiddenLocationId").value = "";
				document.getElementById("txtAreaNameId").value = "";
				document.getElementById("txtAreaDescId").value = "";
			}
		} 
	} 
/*
* For Add / Edit location: End here
*/
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
    <tr>
        <td valign="top" class="SectionSubHead"><?php echo $addtitle;?></td>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td colspan="2" valign="top">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
                <tr>
                    <td valign="top">
                        <!-- main body : Start here -->
                        <form name="frmEditLocation" id="frmEditLocation" action="admin-site-variables.php?sec=loca" method="post" >
                        <input type="hidden" name="securityKey" id="securityKey" value="<?php echo md5("EDITLOCATION"); ?>">
                        <input type="hidden" name="txtHiddenCountry" id="txtHiddenCountryId" value="0">
                        <input type="hidden" name="txtHiddenArea" id="txtHiddenAreaId" value="0">
                        <input type="hidden" name="txtHiddenRegion" id="txtHiddenRegionId" value="0">
                        <input type="hidden" name="txtHiddenLocation" id="txtHiddenLocationId" value="0">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
                            <tr><td height="5" colspan="2" valign="top">&nbsp;</td></tr>
<!--                            
							<tr>
                                <td valign="top"><a href="admin-collateral.php?sec=trvlguide" class="back">Back to List</a></td>
                                <td align="right" valign="top">&nbsp;</td>
                            </tr>
-->
                            <tr>
                                <td colspan="2" valign="top">
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
<!--                                                                            
<a href="admin-collateral.php?sec=trvlguide" style="text-decoration:none;"><img src="images/cancelN.png" alt="Preview" width="66" height="21" border="0" /></a>&nbsp;
-->
                                                                            <a href="javascript:void(0);" onclick="frmValidateEditLocation();" style="text-decoration:none;"><img src="images/saveChangesN.png" alt="Save Approve" width="108" height="21" border="0" /></a>
                                                                            </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="23" align="right" valign="top" class="admleftBg">Select Location</td>
                                                                    <td  valign="top">
																		<div id="showtxtlocationcombo">
																			<?php
																			// case I: all available 
																			if(($_POST['txtcountryid'] > 0) && ($_POST['txtareaid'] > 0) && ($_POST['txtregionid'] > 0) && ($_POST['txtsubregionid'] > 0) && ($_POST['txtlocationid'] > 0)) {
																				?>
																				<select name="txtcountryid" id="txtcountryid" onchange="return chkSelectCountry();" style="display:block;" class="select216">
																					<!--
																					<option value="">Please Select...</option>
																					-->
																					<?php $locationObj->fun_getCountriesOptionsList($_POST['txtcountryid'], " WHERE countries_id in (".$locationObj->fun_getCountryIdHavingArea().")");?>
																				</select>
																				<select name="txtareaid" id="txtareaid" onchange="return chkSelectArea();" style="display:block;" class="select216">
																					<option value="0">Select ...</option>
																					<?php $locationObj->fun_getAreaListOptions($_POST['txtareaid'], $_POST['txtcountryid']); ?>
																				</select>
																				<select name="txtregionid" id="txtregionid" onchange="return chkSelectRegion();" style="display:block;" class="select216">
																					<option value="0">Select ...</option>
																					<?php $locationObj->fun_getRegionListOptions($_POST['txtregionid'], '0', $_POST['txtareaid']);?>
																				</select>
																				<select name="txtsubregionid" id="txtsubregionid" onchange="return chkSelectSubRegion();" style="display:block;" class="select216">
																					<option value="0">Select ...</option>
																					<?php $locationObj->fun_getRegionListOptions($_POST['txtsubregionid'], $_POST['txtregionid'], $_POST['txtareaid']);?>
																				</select>
																				<select name="txtlocationid" id="txtlocationid" onchange="return chkSelectLocation();" style="display:block;"  class="select216">
																					<option value="0">Select ...</option>
																					<?php $locationObj->fun_getLocationListOptions($_POST['txtlocationid'], $_POST['txtsubregionid']);?>
																				</select>
																				<?php
																			// case II: not location, but all
																			} else if(($_POST['txtcountryid'] > 0) && ($_POST['txtareaid'] > 0) && ($_POST['txtregionid'] > 0) && ($_POST['txtsubregionid'] > 0) && !($_POST['txtlocationid'] > 0)) {
																				?>
																				<select name="txtcountryid" id="txtcountryid" onchange="return chkSelectCountry();" style="display:block;" class="select216">
																					<!--
																					<option value="">Please Select...</option>
																					-->
																					<?php $locationObj->fun_getCountriesOptionsList($_POST['txtcountryid'], " WHERE countries_id in (".$locationObj->fun_getCountryIdHavingArea().")");?>
																				</select>
																				<select name="txtareaid" id="txtareaid" onchange="return chkSelectArea();" style="display:block;" class="select216">
																					<option value="0">Select ...</option>
																					<?php $locationObj->fun_getAreaListOptions($_POST['txtareaid'], $_POST['txtcountryid']); ?>
																				</select>
																				<select name="txtregionid" id="txtregionid" onchange="return chkSelectRegion();" style="display:block;" class="select216">
																					<option value="0">Select ...</option>
																					<?php $locationObj->fun_getRegionListOptions($_POST['txtregionid'], '0', $_POST['txtareaid']);?>
																				</select>
																				<select name="txtsubregionid" id="txtsubregionid" onchange="return chkSelectSubRegion();" style="display:block;" class="select216">
																					<option value="0">Select ...</option>
																					<?php $locationObj->fun_getRegionListOptions($_POST['txtsubregionid'], $_POST['txtregionid'], $_POST['txtareaid']);?>
																				</select>
																				<select name="txtlocationid" id="txtlocationid" onchange="return chkSelectLocation();" style="display:block;"  class="select216">
																					<option value="0">Select ...</option>
																					<?php $locationObj->fun_getLocationListOptions('', $_POST['txtsubregionid']);?>
																				</select>
																				<?php
																			// case III: not sub - region, but all
																			} else if(($_POST['txtcountryid'] > 0) && ($_POST['txtareaid'] > 0) && ($_POST['txtregionid'] > 0) && !($_POST['txtsubregionid'] > 0) && ($_POST['txtlocationid'] > 0)) {
																				?>
																				<select name="txtcountryid" id="txtcountryid" onchange="return chkSelectCountry();" style="display:block;" class="select216">
																					<!--
																					<option value="">Please Select...</option>
																					-->
																					<?php $locationObj->fun_getCountriesOptionsList($_POST['txtcountryid'], " WHERE countries_id in (".$locationObj->fun_getCountryIdHavingArea().")");?>
																				</select>
																				<select name="txtareaid" id="txtareaid" onchange="return chkSelectArea();" style="display:block;" class="select216">
																					<option value="0">Select ...</option>
																					<?php $locationObj->fun_getAreaListOptions($_POST['txtareaid'], $_POST['txtcountryid']); ?>
																				</select>
																				<select name="txtregionid" id="txtregionid" onchange="return chkSelectRegion();" style="display:block;" class="select216">
																					<option value="0">Select ...</option>
																					<?php $locationObj->fun_getRegionListOptions($_POST['txtregionid'], '0', $_POST['txtareaid']);?>
																				</select>
																				<select name="txtsubregionid" id="txtsubregionid" onchange="return chkSelectSubRegion();" style="display:<?php if($locationObj->fun_countSubRegionByRegionid($_POST['txtregionid']) == 0){ echo "none";} else {echo "block";} ?>;" class="select216">
																					<option value="0">Select ...</option>
																					<?php $locationObj->fun_getRegionListOptions('0', $_POST['txtregionid'], $_POST['txtareaid']);?>
																				</select>
																				<select name="txtlocationid" id="txtlocationid" onchange="return chkSelectLocation();" style="display:<?php if($locationObj->fun_countSubRegionByRegionid($_POST['txtregionid']) == 0){ echo "block";} else {echo "none";} ?>;"  class="select216">
																					<option value="0">Select ...</option>
																					<?php $locationObj->fun_getLocationListOptions($_POST['txtlocationid'], $_POST['txtregionid']);?>
																				</select>
																				<?php
																			// case IV: not sub - region & location, but all
																			} else if(($_POST['txtcountryid'] > 0) && ($_POST['txtareaid'] > 0) && ($_POST['txtregionid'] > 0) && !($_POST['txtsubregionid'] > 0) && !($_POST['txtlocationid'] > 0)) {
																				?>
																				<select name="txtcountryid" id="txtcountryid" onchange="return chkSelectCountry();" style="display:block;" class="select216">
																				<!--
																					<option value="">Please Select...</option>
																				-->
																					<?php $locationObj->fun_getCountriesOptionsList($_POST['txtcountryid'], " WHERE countries_id in (".$locationObj->fun_getCountryIdHavingArea().")");?>
																				</select>
																				<select name="txtareaid" id="txtareaid" onchange="return chkSelectArea();" style="display:block;" class="select216">
																					<option value="0">Select ...</option>
																					<?php $locationObj->fun_getAreaListOptions($_POST['txtareaid'], $_POST['txtcountryid']); ?>
																				</select>
																				<select name="txtregionid" id="txtregionid" onchange="return chkSelectRegion();" style="display:block;" class="select216">
																					<option value="0">Select ...</option>
																					<?php $locationObj->fun_getRegionListOptions($_POST['txtregionid'], '0', $_POST['txtareaid']);?>
																				</select>
																				<select name="txtsubregionid" id="txtsubregionid" onchange="return chkSelectSubRegion();" style="display:<?php if($locationObj->fun_countSubRegionByRegionid($_POST['txtregionid']) == 0){ echo "none";} else {echo "block";} ?>;" class="select216">
																					<option value="0">Select ...</option>
																					<?php $locationObj->fun_getRegionListOptions('0', $_POST['txtregionid'], $_POST['txtareaid']);?>
																				</select>
																				<select name="txtlocationid" id="txtlocationid" onchange="return chkSelectLocation();" style="display:<?php if($locationObj->fun_countSubRegionByRegionid($_POST['txtregionid']) == 0){ echo "block";} else {echo "none";} ?>;"  class="select216">
																					<option value="0">Select ...</option>
																					<?php $locationObj->fun_getLocationListOptions('', $_POST['txtregionid']);?>
																				</select>
																				<?php
																			// case V: not region, sub - region & location, but all
																			} else if(($_POST['txtcountryid'] > 0) && ($_POST['txtareaid'] > 0) && !($_POST['txtregionid'] > 0) && !($_POST['txtsubregionid'] > 0) && !($_POST['txtlocationid'] > 0)) {
																				?>
																				<select name="txtcountryid" id="txtcountryid" onchange="return chkSelectCountry();" style="display:block;" class="select216">
																					<!--
																					<option value="">Please Select...</option>
																					-->
																					<?php $locationObj->fun_getCountriesOptionsList($_POST['txtcountryid'], " WHERE countries_id in (".$locationObj->fun_getCountryIdHavingArea().")");?>
																				</select>
																				<select name="txtareaid" id="txtareaid" onchange="return chkSelectArea();" style="display:block;" class="select216">
																						<option value="0">Select ...</option>
																					<?php $locationObj->fun_getAreaListOptions($_POST['txtareaid'], $_POST['txtcountryid']); ?>
																				</select>
																				<select name="txtregionid" id="txtregionid" onchange="return chkSelectRegion();" style="display:<?php if($locationObj->fun_countRegionByAreaid($_POST['txtareaid']) == 0){ echo "none";} else {echo "block";} ?>;" class="select216">
																					<option value="0">Select ...</option>
																					<?php $locationObj->fun_getRegionListOptions('', '0', $_POST['txtareaid']);?>
																				</select>
																				<select name="txtsubregionid" id="txtsubregionid" onchange="return chkSelectSubRegion();" style="display:none;" class="select216">
																					<option value="0">Select ...</option>
																				</select>
																				<select name="txtlocationid" id="txtlocationid" onchange="return chkSelectLocation();" style="display:none;"  class="select216">
																					<option value="0">Select ...</option>
																				</select>
																				<?php
																			} else if(($_POST['txtcountryid'] > 0) && !($_POST['txtareaid'] > 0) && !($_POST['txtregionid'] > 0) && !($_POST['txtsubregionid'] > 0) && !($_POST['txtlocationid'] > 0)) {
																				?>
																				<select name="txtcountryid" id="txtcountryid" onchange="return chkSelectCountry();" style="display:block;" class="select216">
																					<!--
																					<option value="">Please Select...</option>
																					-->
																					<?php $locationObj->fun_getCountriesOptionsList('193', " WHERE countries_id in (".$locationObj->fun_getCountryIdHavingArea().")");?>
																				</select>
																				<select name="txtareaid" id="txtareaid" onchange="return chkSelectArea();" style="display:block;" class="select216">
																					<?php $locationObj->fun_getAreaListOptions('1', '193'); ?>
																				</select>
																				<select name="txtregionid" id="txtregionid" onchange="return chkSelectRegion();" style="display:none;" class="select216">
																					<option value="0">Select ...</option>
																					<?php $locationObj->fun_getRegionListOptions('', '0', '1');?>
																				</select>
																				<select name="txtsubregionid" id="txtsubregionid" onchange="return chkSelectSubRegion();" style="display:none;" class="select216">
																					<option value="0">Select ...</option>
																				</select>
																				<select name="txtlocationid" id="txtlocationid" onchange="return chkSelectLocation();" style="display:none;"  class="select216">
																					<option value="0">Select ...</option>
																				</select>
																				<?php
																			} else {
																				?>
																				<select name="txtcountryid" id="txtcountryid" onchange="return chkSelectCountry();" style="display:block;" class="select216">
																					<!--
																					<option value="">Please Select...</option>
																					-->
																					<?php $locationObj->fun_getCountriesOptionsList('193', " WHERE countries_id in (".$locationObj->fun_getCountryIdHavingArea().")");?>
																				</select>
																				<select name="txtareaid" id="txtareaid" onchange="return chkSelectArea();" style="display:block;" class="select216">
																					<?php $locationObj->fun_getAreaListOptions('1', '193'); ?>
																				</select>
																				<select name="txtregionid" id="txtregionid" onchange="return chkSelectRegion();" style="display:block;" class="select216">
																					<option value="0">Select ...</option>
																					<?php $locationObj->fun_getRegionListOptions('', '0', '1');?>
																				</select>
																				<select name="txtsubregionid" id="txtsubregionid" onchange="return chkSelectSubRegion();" style="display:none;" class="select216">
																					<option value="0">Select ...</option>
																				</select>
																				<select name="txtlocationid" id="txtlocationid" onchange="return chkSelectLocation();" style="display:none;"  class="select216">
																					<option value="0">Select ...</option>
																				</select>
																				<?php
																			}
																			?>
																		</div>
                                                                        <span class="pdError1 pad-lft10" id="txtLocationErrorId"></span>
                                                                    </td>
                                                                </tr>
                                                                <tr style="display:none;">
                                                                    <td height="23" align="right" valign="top" class="admleftBg">Location Name</td>
                                                                    <td  valign="top">
                                                                    <input name="txtAreaName" id="txtAreaNameId" class="inpuTxt260" value="<?php if(isset($_POST['txtAreaName']) && $_POST['txtAreaName'] !="") {echo $_POST['txtAreaName'];} else {echo $txtLocationArr['destination_name'];} ?>" type="text" /><span class="pdError1 pad-lft10" id="txtAreaNameErrorId"></span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td height="23" align="right" valign="top" class="admleftBg">Header text</td>
                                                                    <td  valign="top">
																	<textarea name="txtAreaDesc" id="txtAreaDescId" class="textArea460"><?php if(isset($_POST['txtHiddenLocation']) && ($_POST['txtHiddenLocation'] > 0) && ($txtLocationArr = $locationObj->fun_getLocationShortInfoById($_POST['txtHiddenLocation']))) { echo $txtLocationArr['destination_desc'];} else if(isset($_POST['txtHiddenRegion']) && ($_POST['txtHiddenRegion'] > 0) && ($txtLocationArr = $locationObj->fun_getRegionShortInfoById($_POST['txtHiddenRegion']))) {echo fun_db_output($txtLocationArr['destination_desc']);} else if(isset($_POST['txtHiddenArea']) && ($_POST['txtHiddenArea'] > 0) && ($txtLocationArr = $locationObj->fun_getAreaShortInfoById($_POST['txtHiddenArea']))) {echo fun_db_output($txtLocationArr['destination_desc']);} else {echo fun_db_output($txtLocationArr['destination_desc']);} ?></textarea>
                                                                    <span class="pdError1 pad-lft10" id="txtAreaDescErrorId"></span>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2" align="right" valign="top" class="header">
                                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                            <tr>
                                                                            <td align="right" valign="bottom" colspan="2">
<!--                                                                            
<a href="admin-collateral.php?sec=trvlguide" style="text-decoration:none;"><img src="images/cancelN.png" alt="Preview" width="66" height="21" border="0" /></a>&nbsp;
-->                                                                            
                                                                            <a href="javascript:void(0);" onclick="frmValidateEditLocation();" style="text-decoration:none;"><img src="images/saveChangesN.png" alt="Save Approve" width="108" height="21" border="0" /></a>
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
                                    </table>
                                </td>
                            </tr>
                        </table>
                        </form>
                        <!-- main body : End here -->
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
