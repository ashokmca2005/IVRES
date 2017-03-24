<!-- TinyMCE -->
<script type="text/javascript" src="../tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		mode : "exact",
		elements : "txtPropertySummaryId, txtPropertyDescriptionId, txtBedroomsNoteId, txtBathroomsNotesId, txtFeatureNotesId, txtSRequirementNotesId",
		theme : "advanced",
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,bullist,numlist,blockquote,|,justifyleft,justifycenter,justifyright,|,cleanup,code",
		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",
		theme_advanced_buttons4 : "",
		theme_advanced_toolbar_location : "bottom",
		theme_advanced_toolbar_align : "left",
		plugins : 'advlink,advimage',
		relative_urls : false,
		remove_script_host : false,
		theme_advanced_resizing : false,
		extended_valid_elements : 'a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]',
		paste_convert_middot_lists: true,
		paste_convert_headers_to_strong: true,
		remove_linebreaks: true,
		apply_source_formatting: false,
		button_tile_map : true,
		spellchecker_languages : '+Nederlands=nl,Engels=en'
	});
</script>
<!-- /TinyMCE -->
<script language="javascript" type="text/javascript">
	// For friendly_link availability check: Start here
	function checkFriendlyLinkAvailability(strId){
		var url_str	= document.getElementById("unique_URL").value;	
		url_str = rm_trim(url_str);
		if(url_str == ''){
			document.getElementById("resultId").innerHTML = "<font color='#BF0000'><strong>Please enter a name</strong></font>";
			return false;
		}
		var url = "check-property-url-ajax.php?pid="+strId+"&friendly_link="+url_str;
		req.open("GET", url, true);
		req.onreadystatechange = handleFriendlyLinkResponse; 
		req.send(null); 
	}
	
	function handleFriendlyLinkResponse() { 
		if(req.readyState == 4) {
			if (req.responseText){
				val = req.responseText;
				if(val == 'Yes'){
					document.getElementById("txtFriendlyLink").value = document.getElementById("unique_URL").value;	
					document.getElementById("resultId").innerHTML = "<font color='#BF0000'><strong>Address is available</strong></font>";
				} else {
					var strfriendlylink = "<?php echo $propertyInfo['friendly_link']; ?>";
					document.getElementById("txtFriendlyLink").value = strfriendlylink;	
					document.getElementById("resultId").innerHTML = "<font color='#BF0000'><strong>Please choose another</strong></fon>";
					document.getElementById("unique_URL").select();
					return false;
				}
			}
		}
	} 
	// For friendly_link availability check: End here

function frmSubmit(){
	if(document.getElementById("txtPropertyNameId").value == "") {
		document.getElementById("txtNameCountdownId").innerHTML = "Please enter property name";
		return false;
	}

/*
	if(document.getElementById("txtPropertyTitleId").value == "") {
		document.getElementById("txtTitleCountdownId").innerHTML = "Please enter property title";
		return false;
	}
*/

	if(document.getElementById("txtPropertyTypeId").value == "0") {
		document.getElementById("showErrorPropertyTypeId").innerHTML = "Please select property type";
		document.getElementById("txtPropertyTypeId").focus();
		return false;
	}

	if(document.getElementById("unique_URL").value !=""){
		checkFriendlyLinkAvailability(<?php echo $property_id; ?>);
	} else {
		document.getElementById("txtFriendlyLink").value = '';
	}
	document.frmProperty.submit();
}
</script>

<!--Details Starts Here -->
<?php
$uniq_url 			= '';
// array of bedrooms text
$bedOption 			= $propertyObj->fun_getPropertyBedOptionsArray();
// array of bathrooms text
$bathOption 		= $propertyObj->fun_getPropertyBathOptionsArray();
if(isset($_POST['txtFriendlyLink'])){
	$friendly_link = $_POST['txtFriendlyLink'];
} else if(isset($propertyInfo['friendly_link']) && $propertyInfo['friendly_link'] != "") {
	$friendly_link = $propertyInfo['friendly_link'];
} else {
	$friendly_link = $propertyObj->fun_suggestPropertyFriendlyLinks($property_id);
}
?>
<!--Details Content Starts Here -->
<div class="width690 pad-top10">
<form name="frmProperty" id="frmPropertyId" method="post" action="<?php echo $linkdet;?>">
    <input type="hidden" name="securityKey" value="<?php echo md5(OWNERPROPERTYDETAILS);?>" />
    <input type="hidden" name="txtFriendlyLink" id="txtFriendlyLink" value="<?php echo $friendly_link;?>">
    <table width="690" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="left" valign="top">
                <div class="FloatLft">
                <table width="600" border="0" cellspacing="1" cellpadding="0">
                    <tr>
                        <td width="92" align="left" valign="top" class="font12 pad-top1">Property name<span class="red">*</span> </td>
                        <td align="left" valign="top" class="pad-btm10">
                        <span style="float:left;"><input name="txtPropertyName" id="txtPropertyNameId" type="text" style="width:269px;" class="ANPFormFld" value="<?php if(isset($_POST['txtPropertyName'])){echo $_POST['txtPropertyName'];}else{echo $propertyInfo['property_name'];}?>" maxlength="25" onkeydown="limitText(this.form.txtPropertyName,this.form.txtNameCountdown,25);" onkeyup="limitText(this.form.txtPropertyName,this.form.txtNameCountdown,25);" onfocus="showField('txtNameCountdownId');" /></span><span class="error" id="txtNameCountdownId" style="float:left;"><?php if(array_key_exists('txtPropertyName', $form_array)) {echo $form_array['txtPropertyName'];} else { echo "<input readonly type=\"text\" name=\"txtNameCountdown\" onfocus=\"this.form.txtPropertyTitle.focus();\" size=\"1\" value=\"".(25-strlen($propertyInfo['property_name']))."\" style=\"padding:0 2px 0 2px;background-color:#FFFFFF; top:4px; left:-1px; position:relative; text-align:left; width: 30px; border:0px solid #FFFFFF; color:#BF0000; \">";}?></span>
                        </td>
                    </tr>
                    <tr>
                        <td width="92" align="left" valign="top" class="font12 pad-top2">Property title<span class="red">*</span> </td>
                        <td align="left" valign="top" class="pad-btm10">
                        <span style="float:left;"><textarea name="txtPropertyTitle" id="txtPropertyTitleId" cols="" rows="" class="ANP" onkeydown="limitText(this.form.txtPropertyTitle,this.form.txtTitleCountdown,70);" onkeyup="limitText(this.form.txtPropertyTitle,this.form.txtTitleCountdown,70);" onfocus="showField('txtTitleCountdownId');" ><?php if(isset($_POST['txtPropertyTitle'])){echo $_POST['txtPropertyTitle'];}else{echo $propertyInfo['property_title'];}?></textarea></span><span class="error" id="txtTitleCountdownId" style="float:left;"><?php if(array_key_exists('txtPropertyTitle', $form_array)) {echo $form_array['txtPropertyTitle'];} else {echo "<input readonly type=\"text\" name=\"txtTitleCountdown\" onfocus=\"this.form.txtPropertyType.focus();\" size=\"1\" value=\"".(70-strlen($propertyInfo['property_title']))."\" style=\"padding:0 2px 0 2px;background-color:#FFFFFF; top:4px; left:-1px; position:relative; text-align:left; width: 30px; border:0px solid #FFFFFF; color:#BF0000; \">";}?></span>
                        </td>
                    </tr>

                    <tr>
                        <td width="92" align="left" valign="top" class="font12 pad-top2">Property type<span class="red">*</span> </td>
                        <td align="left" valign="top" class="pad-btm10">
                        <?php
                            if(isset($_POST['txtPropertyType'])){
                                $property_type = $_POST['txtPropertyType'];
                            } else {
                                $property_type = $propertyInfo['property_type'];
                            }
                        ?>
                            <div class="FloatLft">
                            <select name="txtPropertyType" id="txtPropertyTypeId" class="ANPForm">
                                <option value="0">Please Select...</option>
                                <?php 
                                $propertyObj->fun_getPropertyTypeOptionsList($property_type);
                                ?>
                            </select>
                            </div>
                            <div class="FloatLft">
                                <span class="error" id="showErrorPropertyTypeId"><?php if(array_key_exists('txtPropertyType', $form_array)) echo $form_array['txtPropertyType'];?></span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td width="92" align="left" valign="top" class="font12 pad-top2">Catering type </td>
                        <td align="left" valign="top">
                            <?php
                                if(isset($_POST['txtCateringType'])){
                                    $property_catering_type = $_POST['txtCateringType'];
                                }
                                else{
                                    $property_catering_type = $propertyInfo['catering_type'];
                                }
                            ?>
                            <select name="txtCateringType" id="txtCateringType" class="ANPForm">
                                <option value="">Please Select...</option>
                                <?php $propertyObj->fun_getCateringTypeOptionsList($property_catering_type);?>
                            </select>
                        </td>
                    </tr>
                </table>
                </div>
                <div class="FloatRgt"><a href="#" onclick="return frmSubmit();" class="button-blue">Save details</a></div>
            </td>
        </tr>

        <tr><td align="left" valign="top"><div class="width690 dash41">&nbsp;</div></td></tr>
        <tr><td align="left" valign="top" class="owner-headings">Property summary</td></tr>
        <tr>
            <td align="left" valign="top" class="font12">
            This will be displayed on the search results and is the first thing potential customers will really mention all the great features, this is your chance to sell sell sell the property. <a href="#" onclick="MM_openWindow('property-add-details-help-pop-up.php', 'childwindow', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=700,height=800')" class="blue-link">see examples</a>
            </td>
        </tr>
        <tr>
            <td align="left" valign="top" class="pad-top15">
            <span  style="float:left;">
            <?php
            if(isset($_POST['txtPropertySummary'])){
                $property_summary = $_POST['txtPropertySummary'];
            } else {
                $property_summary = $propertyInfo['property_summary'];
            }
            ?>
            <textarea name="txtPropertySummary" id="txtPropertySummaryId" cols="" rows="" class="txtarea_500x80"><?php echo $property_summary;?></textarea>
            </span>
            <span class="error" style="float:left;" id="showErrorPropertySummaryId"><?php if(array_key_exists('txtPropertySummary', $form_array)) echo $form_array['txtPropertySummary'];?></span>
            </td>
        </tr>
        <tr><td align="left" valign="top"><div class="width690 dash41">&nbsp;</div></td></tr>
        <tr>
            <td align="left" valign="top" class="owner-headings">Property description</td>
        </tr>
        <tr>
            <td align="left" valign="top" class="font12">
            Write a full description of your property, again don&acute;t hold back with selling your property. Put yourself in the holidaymakers shoes, they want something special, what&acute;s unique about your property and why should they visit yours as opposed to somebody else? <a href="#" onclick="MM_openWindow('property-add-details-help-pop-up.php','childwindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=700,height=800')" class="blue-link">see examples</a>
            </td>
        </tr>
        <tr>
            <td align="left" valign="top" class="pad-top15">
            <span  style="float:left;">
            <?php
            if(isset($_POST['txtPropertyDescription'])){
                $property_description = $_POST['txtPropertyDescription'];
            }
            else{
                $property_description = $propertyInfo['description'];
            }
            ?>
            <textarea name="txtPropertyDescription" id="txtPropertyDescriptionId" cols="" rows="" class="txtarea_500x150"><?php echo $property_description;?></textarea>
            </span>
            <span class="error" style="float:left;" id="showErrorPropertyDescriptionId"><?php if(array_key_exists('txtPropertyDescription', $form_array)) echo $form_array['txtPropertyDescription'];?></span>
            </td>
        </tr>
        <tr><td align="left" valign="top"><div class="width690 dash41">&nbsp;</div></td></tr>

        <tr>
            <td align="left" valign="top" class="pad-btm20">
                <table border="0" cellspacing="0" cellpadding="2" width="100%">
                    <tr>
                        <td valign="middle" colspan="6" align="left" class="pad-rgt10 pad-btm15">
                        <div class="FloatLft pad-rgt10"><h1 class="owner-headings">Bathrooms and bedrooms</h1></div>
                        </td>
                    </tr>

                    <tr>
                        <td valign="middle" align="right" class="pad-rgt10 font12normal"><strong>Total number of bedrooms</strong></td>
                        <td valign="middle" colspan="5" align="left">
                            <?php $propertyObj->fun_createSelectNumField("txtTotalBeds", "txtTotalBeds", "numbers", $propertyInfo['total_beds'], "", 1, 17); ?>
                        </td>
                    </tr>
                    <tr><td colspan="6" class="pad-btm10"></td></tr>
                    <tr>
                        <td valign="middle" align="right" class="pad-rgt10 font12normal"><strong>It can comfortably sleeps</strong></td>
                        <td valign="middle" colspan="5" align="left">
                            <?php $propertyObj->fun_createSelectNumField("txtcomfortBeds", "txtcomfortBeds", "numbers", $propertyInfo['scomfort_beds'], "", 1, 17); ?>
                        </td>
                    </tr>
                    <tr><td colspan="6" class="pad-btm10"></td></tr>
                    <tr>
                        <td valign="middle" align="right" class="pad-rgt10 font12normal" width="310px"><strong>How many: Double</strong></td>
                        <td valign="middle" align="left" width="60px">
                            <?php $propertyObj->fun_createSelectNumField("txtdoubleBeds", "txtdoubleBeds", "numbers", $propertyInfo['double_beds'], "", 1, 17); ?>
                        </td>
                        <td valign="middle" align="right" class="pad-rgt5 font12normal" width="30px"><strong>Twin</strong></td>
                        <td valign="middle" align="left" width="60px">
                            <?php $propertyObj->fun_createSelectNumField("txtsofaBeds", "txtsofaBeds", "numbers", $propertyInfo['sofa_beds'], "", 1, 17); ?>
                        </td>
                        <td valign="middle" align="right" class="pad-rgt5 font12normal" width="30px"><strong>Single</strong></td>
                        <td valign="middle" align="left">
                            <?php $propertyObj->fun_createSelectNumField("txtsingleBeds", "txtsingleBeds", "numbers", $propertyInfo['single_beds'], "", 1, 17); ?>
                        </td>
                    </tr>
					<?php /*?>
                    <tr>
                    <td valign="middle" align="right" class="pad-rgt10 font12normal" width="205px"><strong>How many 1 bdr apts</strong></td>
                    <td valign="middle" align="left" width="60px">
                    <?php $propertyObj->fun_createSelectNumField("txt1BdrApts", "txt1BdrApts", "numbers", $propertyInfo['1bdrapts'], "", 1, 17); ?>
                    </td>
                    <td valign="middle" align="right" class="pad-rgt5 font12normal" width="30px"><strong>2 bdr</strong></td>
                    <td valign="middle" align="left" width="60px">
                    <?php $propertyObj->fun_createSelectNumField("txt2BdrApts", "txt2BdrApts", "numbers", $propertyInfo['2bdrapts'], "", 1, 17); ?>
                    </td>
                    <td valign="middle" align="right" class="pad-rgt5 font12normal" width="30px"><strong>3 bdr</strong></td>
                    <td valign="middle" align="left">
                    <?php $propertyObj->fun_createSelectNumField("txt3BdrApts", "txt3BdrApts", "numbers", $propertyInfo['3bdrapts'], "", 1, 17); ?>
                    </td>
                    <td valign="middle" align="right" class="pad-rgt5 font12normal" width="40px"><strong>4 bdr</strong></td>
                    <td valign="middle" align="left">
                    <?php $propertyObj->fun_createSelectNumField("txt4BdrApts", "txt4BdrApts", "numbers", $propertyInfo['4bdrapts'], "", 1, 17); ?>
                    </td>
                    <td valign="middle" align="right" class="pad-rgt5 font12normal" width="40px"><strong>Studio</strong></td>
                    <td valign="middle" align="left">
                    <?php $propertyObj->fun_createSelectNumField("txt5BdrApts", "txt5BdrApts", "numbers", $propertyInfo['5bdrapts'], "", 1, 17); ?>
                    </td>
                    </tr>
					<?php */?>              
                    <tr><td colspan="6" class="pad-btm10"></td></tr>
                    <tr>
                        <td valign="middle" align="right" class="pad-rgt10 font12normal"><strong>Total number of en-suite bathrooms</strong></td>
                        <td valign="middle" colspan="5" align="left">
                            <?php $propertyObj->fun_createSelectNumField("txtEnsuiteBaths", "txtEnsuiteBaths", "numbers", $propertyInfo['ensuite_baths'], "", 1, 17); ?>
                        </td>
                    </tr>
                    <tr><td colspan="6" class="pad-btm10"></td></tr>
                    <tr>
                        <td valign="middle" align="right" class="pad-rgt10 font12normal"><strong>Total number of bathrooms</strong></td>
                        <td valign="middle" colspan="5" align="left">
                            <?php $propertyObj->fun_createSelectNumField("txtTotalBaths", "txtTotalBaths", "numbers", $propertyInfo['total_bathrooms'], "", 1, 17); ?>
                        </td>
                    </tr>
                    <tr><td colspan="6" class="pad-btm10"></td></tr>
                    <tr>
                        <td valign="middle" align="right" class="pad-rgt10 font12normal"><strong>Total number of toilets / WCs</strong></td>
                        <td valign="middle" colspan="5" align="left">
                            <?php $propertyObj->fun_createSelectNumField("txtToilets", "txtToilets", "numbers", $propertyInfo['toilets'], "", 1, 17); ?>
                        </td>
                    </tr>
                    <tr><td colspan="6" class="pad-btm10"></td></tr>
                    <tr>
                        <td valign="top" align="right" class="pad-rgt10 font12normal"><div class="pad-top3"><strong>Does it have</strong></div></td>
                        <td valign="top" colspan="5" align="left">
                            <!--  For Does it have function : Start here -->
                            <?php
                                $propertyObj->fun_createPropertyDoesItHave($propertyInfo['property_id']);
                            ?>
                            <!--  For Does it have function : End here -->
                        </td>
                    </tr>
                    <tr>
                        <td colspan="6" class="pad-btm10">
                            <table>
                                 <tr>
                                    <td valign="top" align="right" class="pad-rgt10 font12normal" width="205px"><strong>Unit types of the complex</strong></td>
                                    <td valign="middle" align="left">
                                        <?php $propertyObj->fun_createUnitTypeField($propertyInfo['complex_unit_type']); ?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="left" valign="top" class="pad-btm15">
                <table border="0" cellspacing="0" cellpadding="0" width="100%">
                    <tr>
                        <td valign="middle" align="left" class="pad-rgt10 pad-btm15">
                        <div class="FloatLft pad-rgt10 font12normal"><strong>Add some notes about the bedrooms and bathrooms</strong></div>
                        <div class="pad-top1"><a href="#" onclick="MM_openWindow('property-add-details-help-pop-up.php','childwindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=700,height=800')" class="blue-link" style="background:0% 50%  url(<?php echo SITE_IMAGES;?>arrow.gif) no-repeat;">&nbsp;&nbsp;&nbsp;view examples</a></div>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" align="left">
                            <span  style="float:left;">
                                <textarea name="txtBedroomsNote" id="txtBedroomsNoteId" cols="" rows="" class="txtarea_690x70"><?php echo $propertyInfo['bed_notes'];?></textarea>
                            </span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="left" valign="top" class="pad-btm10">
                <table border="0" cellspacing="0" cellpadding="0" width="100%">
                    <tr>
                        <td valign="middle" colspan="6" align="left" class="pad-rgt10 pad-btm15">
                        <div class="pad-rgt10"><h1 class="owner-headings">Further details</h1></div>
                        <div class="font12normal"><strong>Tick all the boxes that apply to your Luxury Villa</strong></div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="left" valign="top" class="pad-btm20">
            <?php
                $propertyObj->fun_createPropertyFurtherDetails($propertyInfo['property_id']);
            ?>
            </td>
        </tr>
        <tr>
            <td align="left" valign="top" class="pad-btm10">
                <table border="0" cellspacing="0" cellpadding="0" width="100%">
                    <tr>
                        <td valign="middle" align="left" class="pad-rgt10 pad-top5">
                        <div class="FloatLft pad-rgt10"><h1 class="owner-headings">Highlights</h1></div>
                        <div class="pad-top10"><a href="#" onclick="MM_openWindow('property-add-details-help-pop-up.php','childwindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=700,height=800')" class="blue-link" style="background:0% 50%  url(<?php echo SITE_IMAGES;?>arrow.gif) no-repeat;">&nbsp;&nbsp;&nbsp;view examples</a></div>
                        </td>
                    </tr>
                    <tr>
                        <td valign="middle" align="left" class="pad-rgt10 pad-top5 pad-btm15">
                        <div class="font16-darkgrey">What are the top 5 features of your holiday home?</div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="left" valign="top" class="pad-btm20">
                <table border="0" cellspacing="0" cellpadding="0" width="100%">
                    <tr>
                        <td valign="middle" align="left" class="pad-rgt5 font14-darkgrey" width="15px">1</td>
                        <td valign="middle" align="left" width="450px"><input name="txtSellingPoint1" id="txtSellingPointId1" type="text" class="property-sale-point" value="<?php echo $propertyInfo['selling_point1']?>" maxlength="70" onkeydown="limitText(this.form.txtSellingPoint1,this.form.txtSellingPoint1CountdownId,70);" onkeyup="limitText(this.form.txtSellingPoint1,this.form.txtSellingPoint1CountdownId,70);" onfocus="showField('txtSellingPoint1CountdownId');" /></td>
                        <td valign="middle" align="left" class="pad-rgt5"><span class="error" id="txtSellingPoint1CountdownId" style="float:left;"><input readonly type="text" name="txtSellingPoint1CountdownId" onfocus="this.form.txtPropertyTitle.focus();" size="1" value="<?php echo (70-strlen($propertyInfo['selling_point1'])); ?>" style="padding:0 2px 0 2px;background-color:#FFFFFF; top:0px; left:-1px; position:relative; text-align:left; width:15px; border:0px solid #FFFFFF; color:#333333;"><font color="#333333">characters remaining</font></span></td>
                    </tr>
                    <tr><td colspan="3" class="pad-btm10"></td></tr>
                    <tr>
                        <td valign="middle" align="left" class="pad-rgt5 font14-darkgrey" width="15px">2</td>
                        <td valign="middle" align="left" width="450px"><input name="txtSellingPoint2" id="txtSellingPointId2" type="text" class="property-sale-point" value="<?php echo $propertyInfo['selling_point2']?>" maxlength="70" onkeydown="limitText(this.form.txtSellingPoint2,this.form.txtSellingPoint2CountdownId,70);" onkeyup="limitText(this.form.txtSellingPoint2,this.form.txtSellingPoint2CountdownId,70);" onfocus="showField('txtSellingPoint2CountdownId');" /></td>
                        <td valign="middle" align="left" class="pad-rgt5"><span class="error" id="txtSellingPoint2CountdownId" style="float:left;"><input readonly type="text" name="txtSellingPoint2CountdownId" onfocus="this.form.txtPropertyTitle.focus();" size="1" value="<?php echo (70-strlen($propertyInfo['selling_point2'])); ?>" style="padding:0 2px 0 2px;background-color:#FFFFFF; top:0px; left:-1px; position:relative; text-align:left; width:15px; border:0px solid #FFFFFF; color:#333333;"><font color="#333333">characters remaining</font></span></td>
                    </tr>
                    <tr><td colspan="3" class="pad-btm10"></td></tr>
                    <tr>
                        <td valign="middle" align="left" class="pad-rgt5 font14-darkgrey" width="15px">3</td>
                        <td valign="middle" align="left" width="450px"><input name="txtSellingPoint3" id="txtSellingPointId3" type="text" class="property-sale-point" value="<?php echo $propertyInfo['selling_point3']?>" maxlength="70" onkeydown="limitText(this.form.txtSellingPoint3,this.form.txtSellingPoint3CountdownId,70);" onkeyup="limitText(this.form.txtSellingPoint3,this.form.txtSellingPoint3CountdownId,70);" onfocus="showField('txtSellingPoint3CountdownId');" /></td>
                        <td valign="middle" align="left" class="pad-rgt5"><span class="error" id="txtSellingPoint3CountdownId" style="float:left;"><input readonly type="text" name="txtSellingPoint3CountdownId" onfocus="this.form.txtPropertyTitle.focus();" size="1" value="<?php echo (70-strlen($propertyInfo['selling_point3'])); ?>" style="padding:0 2px 0 2px;background-color:#FFFFFF; top:0px; left:-1px; position:relative; text-align:left; width:15px; border:0px solid #FFFFFF; color:#333333;"><font color="#333333">characters remaining</font></span></td>
                    </tr>
                    <tr><td colspan="3" class="pad-btm10"></td></tr>
                    <tr>
                        <td valign="middle" align="left" class="pad-rgt5 font14-darkgrey" width="15px">4</td>
                        <td valign="middle" align="left" width="450px"><input name="txtSellingPoint4" id="txtSellingPointId4" type="text" class="property-sale-point" value="<?php echo $propertyInfo['selling_point4']?>" maxlength="70" onkeydown="limitText(this.form.txtSellingPoint4,this.form.txtSellingPoint4CountdownId,70);" onkeyup="limitText(this.form.txtSellingPoint4,this.form.txtSellingPoint4CountdownId,70);" onfocus="showField('txtSellingPoint4CountdownId');" /></td>
                        <td valign="middle" align="left" class="pad-rgt5"><span class="error" id="txtSellingPoint4CountdownId" style="float:left;"><input readonly type="text" name="txtSellingPoint4CountdownId" onfocus="this.form.txtPropertyTitle.focus();" size="1" value="<?php echo (70-strlen($propertyInfo['selling_point4'])); ?>" style="padding:0 2px 0 2px;background-color:#FFFFFF; top:0px; left:-1px; position:relative; text-align:left; width:15px; border:0px solid #FFFFFF; color:#333333;"><font color="#333333">characters remaining</font></span></td>
                    </tr>
                    <tr><td colspan="3" class="pad-btm10"></td></tr>
                    <tr>
                        <td valign="middle" align="left" class="pad-rgt5 font14-darkgrey" width="15px">5</td>
                        <td valign="middle" align="left" width="450px"><input name="txtSellingPoint5" id="txtSellingPointId5" type="text" class="property-sale-point" value="<?php echo $propertyInfo['selling_point5']?>" maxlength="70" onkeydown="limitText(this.form.txtSellingPoint5,this.form.txtSellingPoint5CountdownId,70);" onkeyup="limitText(this.form.txtSellingPoint5,this.form.txtSellingPoint5CountdownId,70);" onfocus="showField('txtSellingPoint5CountdownId');" /></td>
                        <td valign="middle" align="left" class="pad-rgt5"><span class="error" id="txtSellingPoint5CountdownId" style="float:left;"><input readonly type="text" name="txtSellingPoint5CountdownId" onfocus="this.form.txtPropertyTitle.focus();" size="1" value="<?php echo (70-strlen($propertyInfo['selling_point5'])); ?>" style="padding:0 2px 0 2px;background-color:#FFFFFF; top:0px; left:-1px; position:relative; text-align:left; width:15px; border:0px solid #FFFFFF; color:#333333;"><font color="#333333">characters remaining</font></span></td>
                    </tr>

                </table>
            </td>
        </tr>
        <tr>
            <td align="left" valign="top" class="pad-btm10">
                <table border="0" cellspacing="0" cellpadding="0" width="100%">
                    <tr>
                        <td valign="middle" align="left" class="pad-rgt10 pad-top5">
                        <div class="FloatLft pad-rgt10"><h1 class="owner-headings">Property tags</h1></div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="left" valign="top" class="pad-btm20">
                <table border="0" cellspacing="0" cellpadding="0" width="100%">
                    <tr>
                        <td valign="middle" align="left" class="pad-rgt5 font14-darkgrey" width="15px">1</td>
                        <td valign="middle" align="left" width="450px"><input type="hidden" name="txtTagsid1" id="txtTagsid1" value="<?php echo $propertyInfo['tagid1']?>"><input name="txtTag1" id="txtTagId1" type="text" class="property-sale-point" value="<?php echo $propertyInfo['tag1']?>" maxlength="70" onkeydown="limitText(this.form.txtTag1,this.form.txtTag1CountdownId,70);" onkeyup="limitText(this.form.txtTag1,this.form.txtTag1CountdownId,70);" onfocus="showField('txtTag1CountdownId');" /></td>
                        <td valign="middle" align="left" class="pad-rgt5"><span class="error" id="txtTag1CountdownId" style="float:left;"><input readonly type="text" name="txtTag1CountdownId" onfocus="this.form.txtPropertyTitle.focus();" size="1" value="<?php echo (70-strlen($propertyInfo['tag1'])); ?>" style="padding:0 2px 0 2px;background-color:#FFFFFF; top:0px; left:-1px; position:relative; text-align:left; width:15px; border:0px solid #FFFFFF; color:#333333;"><font color="#333333">characters remaining</font></span></td>
                    </tr>
                    <tr><td colspan="3" class="pad-btm10"></td></tr>
                    <tr>
                        <td valign="middle" align="left" class="pad-rgt5 font14-darkgrey" width="15px">2</td>
                        <td valign="middle" align="left" width="450px"><input type="hidden" name="txtTagsid2" id="txtTagsid2" value="<?php echo $propertyInfo['tagid2']?>"><input name="txtTag2" id="txtTagId2" type="text" class="property-sale-point" value="<?php echo $propertyInfo['tag2']?>" maxlength="70" onkeydown="limitText(this.form.txtTag2,this.form.txtTag2CountdownId,70);" onkeyup="limitText(this.form.txtTag2,this.form.txtTag2CountdownId,70);" onfocus="showField('txtTag2CountdownId');" /></td>
                        <td valign="middle" align="left" class="pad-rgt5"><span class="error" id="txtTag2CountdownId" style="float:left;"><input readonly type="text" name="txtTag2CountdownId" onfocus="this.form.txtPropertyTitle.focus();" size="1" value="<?php echo (70-strlen($propertyInfo['tag2'])); ?>" style="padding:0 2px 0 2px;background-color:#FFFFFF; top:0px; left:-1px; position:relative; text-align:left; width:15px; border:0px solid #FFFFFF; color:#333333;"><font color="#333333">characters remaining</font></span></td>
                    </tr>
                    <tr><td colspan="3" class="pad-btm10"></td></tr>
                    <tr>
                        <td valign="middle" align="left" class="pad-rgt5 font14-darkgrey" width="15px">3</td>
                        <td valign="middle" align="left" width="450px"><input type="hidden" name="txtTagsid3" id="txtTagsid3" value="<?php echo $propertyInfo['tagid3']?>"><input name="txtTag3" id="txtTagId3" type="text" class="property-sale-point" value="<?php echo $propertyInfo['tag3']?>" maxlength="70" onkeydown="limitText(this.form.txtTag3,this.form.txtTag3CountdownId,70);" onkeyup="limitText(this.form.txtTag3,this.form.txtTag3CountdownId,70);" onfocus="showField('txtTag3CountdownId');" /></td>
                        <td valign="middle" align="left" class="pad-rgt5"><span class="error" id="txtTag3CountdownId" style="float:left;"><input readonly type="text" name="txtTag3CountdownId" onfocus="this.form.txtPropertyTitle.focus();" size="1" value="<?php echo (70-strlen($propertyInfo['tag3'])); ?>" style="padding:0 2px 0 2px;background-color:#FFFFFF; top:0px; left:-1px; position:relative; text-align:left; width:15px; border:0px solid #FFFFFF; color:#333333;"><font color="#333333">characters remaining</font></span></td>
                    </tr>
                    <tr><td colspan="3" class="pad-btm10"></td></tr>
                    <tr>
                        <td valign="middle" align="left" class="pad-rgt5 font14-darkgrey" width="15px">4</td>
                        <td valign="middle" align="left" width="450px"><input type="hidden" name="txtTagsid4" id="txtTagsid4" value="<?php echo $propertyInfo['tagid4']?>"><input name="txtTag4" id="txtTagId4" type="text" class="property-sale-point" value="<?php echo $propertyInfo['tag4']?>" maxlength="70" onkeydown="limitText(this.form.txtTag4,this.form.txtTag4CountdownId,70);" onkeyup="limitText(this.form.txtTag4,this.form.txtTag4CountdownId,70);" onfocus="showField('txtTag4CountdownId');" /></td>
                        <td valign="middle" align="left" class="pad-rgt5"><span class="error" id="txtTag4CountdownId" style="float:left;"><input readonly type="text" name="txtTag4CountdownId" onfocus="this.form.txtPropertyTitle.focus();" size="1" value="<?php echo (70-strlen($propertyInfo['tag4'])); ?>" style="padding:0 2px 0 2px;background-color:#FFFFFF; top:0px; left:-1px; position:relative; text-align:left; width:15px; border:0px solid #FFFFFF; color:#333333;"><font color="#333333">characters remaining</font></span></td>
                    </tr>
                    <tr><td colspan="3" class="pad-btm10"></td></tr>
                    <tr>
                        <td valign="middle" align="left" class="pad-rgt5 font14-darkgrey" width="15px">5</td>
                        <td valign="middle" align="left" width="450px"><input type="hidden" name="txtTagsid5" id="txtTagsid5" value="<?php echo $propertyInfo['tagid5']?>"><input name="txtTag5" id="txtTagId5" type="text" class="property-sale-point" value="<?php echo $propertyInfo['tag5']?>" maxlength="70" onkeydown="limitText(this.form.txtTag5,this.form.txtTag5CountdownId,70);" onkeyup="limitText(this.form.txtTag5,this.form.txtTag5CountdownId,70);" onfocus="showField('txtTag5CountdownId');" /></td>
                        <td valign="middle" align="left" class="pad-rgt5"><span class="error" id="txtTag5CountdownId" style="float:left;"><input readonly type="text" name="txtTag5CountdownId" onfocus="this.form.txtPropertyTitle.focus();" size="1" value="<?php echo (70-strlen($propertyInfo['tag5'])); ?>" style="padding:0 2px 0 2px;background-color:#FFFFFF; top:0px; left:-1px; position:relative; text-align:left; width:15px; border:0px solid #FFFFFF; color:#333333;"><font color="#333333">characters remaining</font></span></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="left" valign="top" class="pad-btm10">
                <table border="0" cellspacing="0" cellpadding="0" width="100%">
                    <tr>
                        <td valign="middle" align="left" class="pad-rgt10 pad-top5">
                        <div class="FloatLft pad-rgt10"><h1 class="owner-headings">Unique URL</h1></div>
                        </td>
                    </tr>
                    <tr>
                        <td valign="middle" align="left" class="pad-rgt10 pad-top5 pad-btm15">
                        <div class="font16-darkgrey">Create your own memorable web address</div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="left" valign="top" class="pad-btm20 btm-border1">
                <table border="0" cellspacing="0" cellpadding="0" width="100%">
                    <tr>
                        <td valign="middle" align="left" class="font12 pad-rgt5" width="130px"><?php echo "http:/".$_SERVER["SERVER_NAME"];?>/vacation-rentals/</td>
                        <td valign="middle" align="left" class="font12 pad-rgt5" width="280px"><input type="text" name="unique_URL" id="unique_URL" class="ANPFormFld" value="<?php echo $friendly_link;?>" /></td>
                        <td valign="middle" align="left" class="font12 pad-rgt5"><a href="javascript:checkFriendlyLinkAvailability(<?php echo $property_id; ?>);javascript:void(0);"><img src="<?php echo SITE_IMAGES;?>check-availability.gif" alt="Check availability" name="checkavailability" border="0" id="checkavailability" /></a></td>
                        <td valign="middle" align="left" class="font12 pad-rgt5"><div id="resultId"></div></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="left" valign="top" class="pad-top20">

                <table border="0" cellspacing="0" cellpadding="0" width="100%">
                    <tr>
                        <td colspan="2" valign="top" align="right" class="pad-btm15"><a href="javascript:void(0);" onclick="return frmSubmit();" class="button-blue">Save details</a></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</form>
</div>
