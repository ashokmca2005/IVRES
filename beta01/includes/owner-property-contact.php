<?php
$propertyContactLanguageArr = $propertyObj->fun_getPropertyContactLanguageArr($property_id);
$propertyContactNumberArr 	= $propertyObj->fun_getPropertyContactNumberArr($property_id);
$txtContactName 			= $propertyInfo['contact_name'];
$txtContactNameShow			= $propertyInfo['contact_name_show'];
$txtContactResponce 		= $propertyInfo['response_time'];
$txtContactResponceShow		= $propertyInfo['response_time_show'];
$txtContactResponceType 	= $propertyInfo['response_time_type'];

if($txtContactName == "") {
	$txtContactName 		= ucfirst($userInfoArr['user_fname']." ".$userInfoArr['user_lname']);
}

if(!is_array($propertyContactLanguageArr)) {
$propertyContactLanguageArr = $usersObj->fun_getUserContactLanguageArr($user_id);
}

if(!is_array($propertyContactNumberArr)) {
$propertyContactNumberArr = $usersObj->fun_getUserContactNumberArr($user_id);
}

//print_r($propertyContactLanguageArr);
?>

<script language="javascript" type="text/javascript">
	function addEvent1() {
		var strTable1 = "";
		var ni = document.getElementById('myDiv1');
		var numi = document.getElementById('theValue1');
		var num = (document.getElementById("theValue1").value -1)+ 2;
		numi.value = num;
		var divIdName = "my"+num+"Div1";
		
		var strcontype = "<?php $propertyObj->fun_getPropertyContactNoTypeOptionsList(); ?>";
		var strconnamefav = "<?php $propertyObj->fun_getCountriesISDOptionsList('', " WHERE countries_name IN ('United States', 'United Kingdom') ORDER BY countries_name IN ('United States', 'United Kingdom')"); ?>";
		var strconname = "<?php $propertyObj->fun_getCountriesISDOptionsList(); ?>";
		
		var newdiv = document.createElement('div');
		newdiv.setAttribute("id",divIdName);

		strTable1 += "<table border='0' cellspacing='0' cellpadding='0'>";
		strTable1 += "<tr>";
		strTable1 += "<td class='pad-rgt10 pad-btm10'>";
		strTable1 += "<select name='txtContactNumberType[]' id='txtContactNumberTypeId0' class='NumberType'>";
		strTable1 += "<option value=''>Select Type</option>";
		strTable1 += strcontype;
		strTable1 += "</select>";
		strTable1 += "</td>";
		strTable1 += "<td class='pad-rgt10 pad-btm10'>";
		strTable1 += "<select name='txtCountry[]'  id='txtCountryId0' class='Listmenu100' style='width:170px;'>";
		strTable1 += "<option value='' >Select country...</option>";
		strTable1 += strconnamefav;
		strTable1 += strconname;
		strTable1 += "</select>";
		strTable1 += "</td>";
		strTable1 += "<td class='pad-rgt10 pad-btm10'><input type='text' name='txtContactNumber[]' class='ContactNumber' maxlength='15' value=''/></td>";
		strTable1 += "<td class='pad-top2 pad-btm10' width='200'><a href=\"#\" onclick=\"removeElement1(\'"+divIdName+"\'); return false;\" class='removeText'>Delete</a></td>";
		strTable1 += "</tr>";
		strTable1 += "</table>";
		newdiv.innerHTML = strTable1;
		ni.appendChild(newdiv);
	}
	
	function removeElement1(divNum) {
		var d = document.getElementById('myDiv1');
		var olddiv = document.getElementById(divNum);
		d.removeChild(olddiv);
	}

	function addEvent2() {
		var strTable2 = "";
		var ni = document.getElementById('myDiv2');
		var numi = document.getElementById('theValue2');
		var num = (document.getElementById("theValue2").value -1)+ 2;
		numi.value = num;
		var divIdName = "my"+num+"Div2";
		
		var strlang = "<?php $propertyObj->fun_getLanguagesOptionsList(); ?>";
		
		var newdiv = document.createElement('div');
		newdiv.setAttribute("id",divIdName);
		newdiv.setAttribute("style", "padding-bottom:10px;");
		strTable2 += "<table border='0' cellspacing='0' cellpadding='0'>";
		strTable2 += "<tr>";
		strTable2 += "<td class='pad-rgt10'>";
		strTable2 += "<select name='txtContactLanguage[]' id='txtContactLanguageId0' class='select247'>";
		strTable2 += "<option value=''>Select Language ...</option>";
		strTable2 += strlang;
		strTable2 += "</select>";
		strTable2 += "</td>";
		strTable2 += "<td><a href=\"#\" onclick=\"removeElement2(\'"+divIdName+"\'); return false;\" class='removeText'>Delete</a></td>";
		strTable2 += "</tr>";
		strTable2 += "</table>";
		newdiv.innerHTML = strTable2;
		ni.appendChild(newdiv);
	}
	
	function removeElement2(divNum) {
		var d = document.getElementById('myDiv2');
		var olddiv = document.getElementById(divNum);
		d.removeChild(olddiv);
	}

	function addContact(){
		if(document.getElementById("txtContactNameId").value == ""){
			document.getElementById("contactErrorDiv").innerHTML = "Please enter contact name";
			document.getElementById("txtContactNameId").focus();
			return false;
		}
		frmSubmit();
	}

	function frmSubmit(){
		document.frmProperty.submit();
	}

	function deleteContactNumber(strId) {
		req.onreadystatechange = handleDeleteResponse;
		req.open('get', '<?php echo SITE_URL;?>contactnumdeleteXml.php?id='+strId); 
		req.send(null);   
	}

	function deleteContactLanguage(strId) {
		req.onreadystatechange = handleDeleteResponse;
		req.open('get', '<?php echo SITE_URL;?>contactlangdeleteXml.php?id='+strId); 
		req.send(null);   
	}

	function handleDeleteResponse() {
		if(req.readyState == 4) {
			var response=req.responseText;
//alert(response);
			xmlDoc=req.responseXML;
			var root = xmlDoc.getElementsByTagName('contacts')[0];
			if(root != null) {
				var items = root.getElementsByTagName("contact");
                var item = items[0];
                var contactstatus = item.getElementsByTagName("status")[0].firstChild.nodeValue;
                if(contactstatus == "Contact deleted.") {
                    window.location = location.href;
                }
			}
		}
	}
</script>
<form name="frmProperty" id="frmPropertyId" action="<?php echo $linkcon;?>" method="post">
    <input type="hidden" name="securityKey" value="<?php echo md5(OWNERPROPERTYCONTACTS)?>" />
    <div class="width690" style="padding-top:15px; padding-bottom:40px;">
        <div class="width690 pad-btm30">
            <div class="FloatLft pad-top5">
                <span class="font16-darkgrey pad-rgt5"><?php echo tranText('enter_your_contact_details_for_holiday_maker_enquiries'); ?></span>
                <div class="pad-top7"><?php echo tranText('these_will_be_displayed_on_your_listing'); ?></div>
            </div>
            <div class="FloatRgt pad-rgt4"><a href="#" onclick="addContact(); return false;" class="button-blue">save details</a></div>
        </div>                
        <table width="690" align="left" border="0" cellpadding="5" cellspacing="0">
            <tr>
                <td width="155" align="right" valign="middle"><?php echo tranText('contact_name'); ?></td>
                <td width="229" valign="middle"><span class="RegFormRight"><input type="text" name="txtContactName" id="txtContactNameId" class="RegFormFld" value="<?php echo $txtContactName;?>" /></span></td>
                <td width="264" valign="middle">&nbsp;</td>
            </tr>
            <tr>
                <td align="right" valign="top"><?php echo tranText('contact_number'); ?></td>
                <td colspan="2" valign="middle">
                    <table border="0" cellspacing="0" cellpadding="0">
                    <?php
                        if(is_array($propertyContactNumberArr) && count($propertyContactNumberArr) > 0) {
                            for($j = 0; $j < count($propertyContactNumberArr); $j++){
                                $contact_numberId 			= $propertyContactNumberArr[$j]['id'];
                                $contact_number_typeid 		= $propertyContactNumberArr[$j]['contact_number_typeid'];
                                $contact_number_countryid 	= $propertyContactNumberArr[$j]['contact_number_countryid'];
                                $contact_number 			= $propertyContactNumberArr[$j]['contact_number'];
                                $contact_number_show 		= $propertyContactNumberArr[$j]['contact_number_show'];
                                ?>
                                <tr id="rowAddNewContactNumerId<?php echo $j; ?>">
                                    <td class="pad-rgt10 pad-btm10">
                                    <select name="txtContactNumberType[]" id="txtContactNumberTypeId<?php echo $j; ?>" class="NumberType">
                                        <option value="">Select Type</option>
                                        <?php $propertyObj->fun_getPropertyContactNoTypeOptionsList($contact_number_typeid); ?>
                                    </select>
                                    </td>
                                    <td class="pad-rgt10 pad-btm10">
                                    <select name="txtCountry[]"  id="txtCountryId0" class="Listmenu100" style="width:170px;">
                                        <option value="" >Select country...</option>
                                        <?php 
                                            $strPopularCountry = " WHERE countries_name IN ('United States', 'United Kingdom') ORDER BY countries_name IN ('United States', 'United Kingdom')";
                                            $propertyObj->fun_getCountriesISDOptionsList('', $strPopularCountry);
                                            $propertyObj->fun_getCountriesISDOptionsList($contact_number_countryid);
                                        ?>
                                    </select>
                                    </td>
                                    <td class="pad-rgt10 pad-btm10"><input type="text" name="txtContactNumber[]" class="ContactNumber" maxlength="15" value="<?php echo $contact_number; ?>"/></td>
                                    <td class="pad-top2 pad-btm10" width="200">
                                        <?php if($j > 0) { echo "<a href=\"#\" onclick=\"deleteContactNumber(".$contact_numberId.");  return false;\" class=\"removeText\">Delete</a>";} else { echo "&nbsp;";} ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                        ?>
                        <tr id="rowAddNewContactNumerId0">
                            <td class="pad-rgt10 pad-btm10">
                            <select name="txtContactNumberType[]" id="txtContactNumberTypeId0" class="NumberType">
                                <option value="">Select Type</option>
                                <?php $propertyObj->fun_getPropertyContactNoTypeOptionsList($contact_number_typeid); ?>
                            </select>
                            </td>
                            <td class="pad-rgt10 pad-btm10">
                            <select name="txtCountry[]"  id="txtCountryId0" class="Listmenu100" style="width:170px;">
                                <option value="" >Select country...</option>
                                <?php 
                                    $strPopularCountry = " WHERE countries_name IN ('United States', 'United Kingdom') ORDER BY countries_name IN ('United States', 'United Kingdom')";
                                    $propertyObj->fun_getCountriesISDOptionsList('', $strPopularCountry);
                                    $propertyObj->fun_getCountriesISDOptionsList($contact_number_countryid);
                                ?>
                            </select>
                            </td>
                            <td class="pad-rgt10 pad-btm10"><input type="text" name="txtContactNumber[]" class="ContactNumber" maxlength="15" value=""/></td>
                            <td class="pad-top2 pad-btm10" width="200">&nbsp;</td>
                        </tr>
                        <?php
                        }
                        ?>
                        <tr>
                            <td colspan="4" valign="top">
                                <input type="hidden" value="0" id="theValue1" />
                                <div id="myDiv1"> </div>
                            </td>
                        </tr>
                        <tr><td colspan="4" class="blue14 pad-rgt5"><a href="#" onclick="addEvent1(); return false;" class="blue14 add-photo"><?php echo tranText('add_another_number'); ?></a></td></tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="right" valign="top"><?php echo tranText('language_spoken'); ?></td>
                <td colspan="2" valign="middle">
                    <table border="0" cellspacing="0" cellpadding="0">
                    <?php
                        if(is_array($propertyContactLanguageArr) && count($propertyContactLanguageArr) > 0) {
                            for($i = 0; $i < count($propertyContactLanguageArr); $i++) {
                                $contactLanguageId 	= $propertyContactLanguageArr[$i]['id'];
                                $language_id 		= $propertyContactLanguageArr[$i]['language_id'];
                                $language_show 		= $propertyContactLanguageArr[$i]['language_show'];
                                ?>
                                <tr id="rowAddNewLanguageId<?php echo $i; ?>">
                                    <td valign="top" colspan="2">
                                        <table border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td class="pad-rgt10 pad-btm10">
                                                    <select name="txtContactLanguage[]" id="txtContactLanguageId<?php echo $i; ?>" class="select247">
                                                        <option value="">Select Language ...</option>
                                                        <?php $propertyObj->fun_getLanguagesOptionsList($language_id); ?>
                                                    </select>                  
                                                </td>
                                                <td>
                                                    <?php if($i > 0) { echo "<a href=\"#\" onclick=\"deleteContactLanguage(".$contactLanguageId."); return false;\" class=\"removeText\">Delete</a>";} else { echo "&nbsp;";} ?>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                        ?>
                        <tr id="rowAddNewLanguageId0">
                            <td valign="top" colspan="2">
                                <table border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td class="pad-rgt10 pad-btm10">
                                            <select name="txtContactLanguage[]" id="txtContactLanguageId0" class="select247">
                                                <option value="">Select Language ...</option>
                                                <?php $propertyObj->fun_getLanguagesOptionsList(); ?>
                                            </select>                  
                                        </td>
                                        <td>&nbsp;</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                        <tr>
                            <td colspan="2">
                                <input type="hidden" value="0" id="theValue2" />
                                <div id="myDiv2"> </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="blue14 pad-rgt5"><a href="#" onclick="addEvent2(); return false;" class="blue14 add-photo"><?php echo tranText('add_another_language'); ?></a></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="right" valign="middle"><?php echo tranText('enquiry_response_time'); ?></td>
                <td valign="middle" colspan="2">
                    <table border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td class="pad-rgt10">
                                <select name="txtContactResponce" class="duration">
                                    <?php 
                                    for($k=1; $k<=30; $k++) {
                                        if($k == (int)$txtContactResponce) { $selected = "selected"; } else { $selected = ""; }
                                        echo "<option value=".$k." ".$selected.">".$k."</option>";
                                    }
                                    ?>
                                </select>	                  
                            </td>
                            <td class="pad-rgt10">
                                <select name="txtContactResponceType" class="duration-type">
                                    <option value="H" <?php if($txtContactResponceType == 'H'){ echo "selected";}else{echo "";}?>>Hours</option>
                                    <option value="M" <?php if($txtContactResponceType == 'M'){ echo "selected";}else{echo "";}?>>Minutes</option>
                                    <option value="D" <?php if($txtContactResponceType == 'D'){ echo "selected";}else{echo "";}?>>Days</option>
                                </select>														
                            </td>
                            <td class="pad-rgt10" colspan="2"><?php echo tranText('how_quickly_would_you_normally_respond_to_an_enquiry'); ?>?</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="right" valign="middle">&nbsp;</td>
                <td valign="middle" colspan="2"><div id="contactErrorDiv" class="pad-top5 error"><?php echo $form_array['contactError']; ?></div></td>
            </tr>
        </table>
        <div class="width690 pad-top5">
            <div class="FloatRgt"><a href="#" onclick="addContact(); return false;" class="button-blue">save details</a></div>
        </div>
    </div>
<!--ChecklistTab Content Ends Here -->
</form>
