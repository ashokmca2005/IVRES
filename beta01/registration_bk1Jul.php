<?php	
	if($_SERVER["SERVER_NAME"] == "localhost") {
		require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/includes/application-top.php");
	} else {
		require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
	}
	require_once(SITE_CLASSES_PATH."class.Users.php");
	require_once(SITE_CLASSES_PATH."class.UserSetting.php");
	require_once(SITE_CLASSES_PATH."class.Property.php");
	require_once(SITE_CLASSES_PATH."class.Location.php");
	require_once(SITE_CLASSES_PATH."class.Email.php");

	$usersObj 		= new Users();
	$userSettingObj	= new UserSetting();
	$propertyObj 	= new Property();
	$locationObj 	= new Location();
	
	
	if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !=""){ // login then redirect to its home page
		redirectURL($_SESSION['ses_user_home']);
	} else {
		$user_id = "";
	}

	// Form submission
	$form_array 	= array();
	$errorMsg = 'no';
	
	if($_POST['securityKey']==md5("NEWREGISTRATION")) {
		if(trim($_POST['txtUserFName']) == '') {
			$form_array['txtUserFName'] = 'First Name required';
			$errorMsg = 'yes';
		}
		if(trim($_POST['txtUserLName']) == '') {		
			$form_array['txtUserLName'] = 'Last Name required';
			$errorMsg = 'yes';
		}
		if($_POST['txtUserEmail'] == '') {
			$form_array['txtUserEmail'] = 'Please enter a valid email address';
			$errorMsg = 'yes';
		} else {
			if(preg_match(EMAIL_ID_REG_EXP_PATTERN, $_POST['txtUserEmail'])) {
				// Check if email already exist
				if($usersObj->fun_checkEmailAddress($_POST['txtUserEmail']) === true) {
					$form_array['txtUserEmail'] = 'Email address already exists <a href=javascript:toggleLayer1("signup"); style="font-size:11px; color:#357bdc; text-decoration:none;">Sign in</a>';
					$errorMsg = 'yes';
				}
			} else {
				$form_array['txtUserEmail'] = 'Please enter a valid email address';
				$errorMsg = 'yes';
			}
		}

		if((trim($_POST['txtUserPasswrd']) == '') || (strlen($_POST['txtUserPasswrd']) < 6)) {
			$form_array['txtUserPasswrd'] = 'Minimum of 6 character password required';
			$errorMsg = 'yes';
		}

		if((trim($_POST['txtConfirmPassword']) == '') || (trim($_POST['txtConfirmPassword']) != trim($_POST['txtUserPasswrd']))){
			$form_array['txtConfirmPassword'] = 'Please confirm your password';
			$errorMsg = 'yes';
		}


		if(isset($_POST['txtIsOwner']) && (trim($_POST['txtIsOwner']) == '1')) {
			if($_POST['txtDOBDay'] == ''){		
				$form_array['txtDOBDay'] = 'Please enter a date';
				$errorMsg = 'yes';
			}
			if($_POST['txtDOBDay'] != '' && $_POST['txtDOBMonth'] == ''){
				$form_array['dobVal'] = 'Please enter a month';
				$errorMsg = 'yes';
			}
			if($_POST['txtDOBDay'] != '' && $_POST['txtDOBMonth'] != '' && $_POST['txtDOBYear'] == ''){
				$form_array['dobVal'] = 'Please enter a year';
				$errorMsg = 'yes';
			}
			if($_POST['txtDOBDay'] != '' && $_POST['txtDOBMonth'] != '' && $_POST['txtDOBYear'] != ''){
				$yyyy	= $_POST['txtDOBYear'];
				$mm		= $_POST['txtDOBMonth'];
				$dd		= $_POST['txtDOBDay'];
				$chkDob = fun_check_date($yyyy, $mm, $dd);
				if($chkDob['code'] == false){
					$form_array['dobVal'] = $chkDob['codemsg'];			
					$errorMsg = 'yes';
				}
			}	
			if($_POST['txtRCountry'] == ''){
				$form_array['txtRCountry'] = 'Please select your country';
				$errorMsg = 'yes';
			}
		}

		if(($_SESSION['security_code'] == $_POST['image_vcode']) && ($errorMsg == 'no') && ($errorMsg != 'yes')){		
			// register as owner
			$txtUserFName 	= trim($_POST['txtUserFName']);
			$txtUserLName 	= trim($_POST['txtUserLName']);
			$txtUserEmail 	= trim($_POST['txtUserEmail']);
			$txtUserPasswrd	= trim($_POST['txtUserPasswrd']);
			if(isset($_POST['txtIsOwner']) && (trim($_POST['txtIsOwner']) == '1')) {
				$txtDOBDay 		= trim($_POST['txtDOBDay']);
				$txtDOBMonth 	= trim($_POST['txtDOBMonth']);
				$txtDOBYear 	= trim($_POST['txtDOBYear']);
				$txtAddress1 	= trim($_POST['txtAddress1']);
				$txtAddress2 	= trim($_POST['txtAddress2']);
				$txtTown 		= trim($_POST['txtTown']);
				$txtState 		= trim($_POST['txtState']);
				$txtZip 		= trim($_POST['txtZip']);
				$txtCountry 	= trim($_POST['txtCountry']);
				$txtRCountry 	= trim($_POST['txtRCountry']);
			} else {
				$txtDOBDay 		= "";
				$txtDOBMonth 	= "";
				$txtDOBYear 	= "";
				$txtAddress1 	= "";
				$txtAddress2 	= "";
				$txtTown 		= "";
				$txtState 		= "";
				$txtZip 		= "";
				$txtCountry 	= "";
				$txtRCountry 	= "";
			}
			$txtIsOwner 	= trim($_POST['txtIsOwner']);
			$user_id 		= $usersObj->fun_registerUser($txtUserEmail, $txtUserPasswrd, $txtUserFName, $txtUserLName, $txtUserEmail, $txtDOBDay, $txtDOBMonth, $txtDOBYear, $txtAddress1, $txtAddress2, $txtTown, $txtState, $txtZip, $txtCountry, $txtRCountry, $txtIsOwner);
			if($user_id != "") {
				if($txtIsOwner == "1") {
					// for contact numbers
					$txtContactNumberType 	= $_POST['txtContactNumberType'];
					$txtContactCountry 		= $_POST['txtContactCountry'];
					$txtContactNumber 		= $_POST['txtContactNumber'];
					$usersObj->fun_updateUserContactNumbers($user_id, $txtContactNumberType, $txtContactCountry, $txtContactNumber);				
					// for contact languages
					$txtContactLanguage 	= $_POST['txtContactLanguage'];
					$usersObj->fun_updateUserContactLanguages($user_id, $txtContactLanguage);
				}

				// For user settings
				if(isset($_POST['txtUserSetting']) && count($_POST['txtUserSetting']) > 0) {
					$usersObj->fun_updateUserSettings($user_id, $_POST['txtUserSetting']);
				}
				$_SESSION['registraton_id'] 	= $user_id;
				$_SESSION['registraton_pass'] 	= $txtUserPasswrd;

				if($usersObj->sendActivationEmailToUserNew($user_id)) {
					redirectURL("registration2.php");
				}
/*
				if($txtIsOwner == "1") {
					redirectURL("owner-home.php");
				} else {
					redirectURL("home.php");
				}
*/
			} else {
				redirectURL("registration");
			}
		} else {
			$form_array['error_msg'] = "Codes must match!";
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo $seo_title;?></title>
    <meta name="description" content="<?php echo $seo_description;?>" />
    <meta name="keywords" content="<?php echo $seo_keywords;?>" />
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo tranText('charset'); ?>" />
    <META HTTP-EQUIV="Content-language" CONTENT="<?php echo tranText('lang_iso'); ?>">
    <link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo SITE_URL; ?>favicon.ico" />
    <link rel="SHORTCUT ICON" href="<?php echo SITE_URL; ?>favicon.ico"/>
    <link rel="stylesheet" type="text/css" href="<?php echo SITE_CSS_INCLUDES_PATH;?>common.css" />
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>common.js"></script>
	<script type="text/javascript" language="JavaScript" src="<?php echo SITE_JS_INCLUDES_PATH;?>dargPop.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>dhtmlwindow.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>pop-up.js"></script>
    <script type="text/javascript" language="javascript">
  		var x, y;
		function show_coords(event){	
			x=event.clientX;
			y=event.clientY;
			x = x-160;
			y = y+4;
		//	alert(x);alert(y);
		}

	    function showRow(strId){
            var strId = strId;
            document.getElementById(strId).style.display = "block";
        }

        function removeContactNumber(strId) {
            var strNumberId = "txtContactNumber"+strId;
            document.getElementById(strNumberId).value = "";
            document.frmPropertyContacts.submit();
        }
        function addEvent() {
            var strTable = "";
            var ni = document.getElementById('myDiv');
            var numi = document.getElementById('theValue');
            var num = (document.getElementById("theValue").value -1)+ 2;
            numi.value = num;
            var divIdName = "my"+num+"Div";
            var strcontype = "<?php $propertyObj->fun_getPropertyContactNoTypeOptionsList(); ?>";
            var strconnamefav = "<?php $propertyObj->fun_getCountriesISDOptionsList('', " WHERE countries_name IN ('United States', 'United Kingdom') ORDER BY countries_name IN ('United States', 'United Kingdom')"); ?>";
            var strconname = "<?php $propertyObj->fun_getCountriesISDOptionsList(); ?>";
            var newdiv = document.createElement('div');
            newdiv.setAttribute("id",divIdName);
            strTable += "<table cellspacing='0' cellpadding='0'>";
            strTable += "<tr>";
            strTable += "<td colspan='4' height='5'>";
            strTable += "</td>";
            strTable += "</tr>";
            strTable += "<tr>";
            strTable += "<td align='left'>";
            strTable += "<select name='txtContactNumberType[]' class='select94'>";
            strTable += "<option value=''>Select Type</option>";
            strTable += strcontype;
            strTable += "</select>";
            strTable += "<td class='pad-lft10'>";
            strTable += "<select name='txtContactCountry[]' id='txtContactCountryId' class='select128'>";
            strTable += "<option value='' style='font-style:normal; background-color:#D0E0F1;COLOR:#000000' disabled='disabled' selected='selected'>Select Country ...</option>";
            strTable += strconnamefav;
            strTable += "<option value='' style='font-style:normal;background-color:#D0E0F1;COLOR:#000000' disabled='disabled'> ---------------------------------------------- </option>";
            strTable += strconname;
            strTable += "</select>";
            strTable += "</td>";
            strTable += "<td class='pad-lft10'><input type='text' name='txtContactNumber[]' class='txtBox160' maxlength='15' /></td>";
            strTable += "<td class='pad-lft10 pad-top1' valign='middle'><a href=\"javascript:;\" class='delete-contact' onclick=\"removeElement(\'"+divIdName+"\')\">Delete</a></td>";
            strTable += "</tr>";
            strTable += "</table>";
            newdiv.innerHTML = strTable;
            ni.appendChild(newdiv);
        }
        function removeElement(divNum) {
            var d = document.getElementById('myDiv');
            var olddiv = document.getElementById(divNum);
            d.removeChild(olddiv);
        }
        function addEvent1() {
            var strTable1 = "";
            var ni = document.getElementById('myDiv1');
            var numi = document.getElementById('theValue');
            var num = (document.getElementById("theValue").value -1)+ 2;
            numi.value = num;
            var divIdName = "my"+num+"Div";
            var strlang = "<?php $usersObj->fun_getLanguagesOptionsList(); ?>";
            var newdiv = document.createElement('div');
            newdiv.setAttribute("id",divIdName);
            strTable1 += "<table cellspacing='0' cellpadding='0'>";
            strTable1 += "<tr>";
            strTable1 += "<td height='5'>";
            strTable1 += "</td>";
            strTable1 += "</tr>";
            strTable1 += "<tr>";
            strTable1 += "<td align='left'>";
            strTable1 += "<select name='txtContactLanguage[]' class='select230'>";
            strTable1 += "<option value='' style='font-style:normal; background-color:#D0E0F1;COLOR:#000000' disabled='disabled' selected='selected'>Select Language ...</option>";
            strTable1 += strlang;
            strTable1 += "</select>";
            strTable1 += "</td>";
            strTable1 += "<td class='pad-lft10 pad-top1' valign='middle'> <a href=\"javascript:void(0);\" class='delete-language' onclick=\"removeElement1(\'"+divIdName+"\')\">Delete</a></td>";
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

		function validateRegister(){
			if(document.getElementById("txtUserFNameId").value == "") {
				document.getElementById("showErrorUserFNameId").innerHTML = "First Name required";
				document.getElementById("txtUserFNameId").focus();
				return false;
			}

			if(document.getElementById("txtUserLNameId").value == "") {
				document.getElementById("showErrorUserLNameId").innerHTML = "Last Name required";
				document.getElementById("txtUserLNameId").focus();
				return false;
			}

			if(document.getElementById("txtUserEmailId").value == "") {
				document.getElementById("showErrorUserEmailId").innerHTML = "Enter valid email address";
				document.getElementById("txtUserEmailId").focus();
				return false;
			} else {
				var emailRegxp = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
				var txtemail = document.getElementById("txtUserEmailId").value;
				if (emailRegxp.test(txtemail)!= true){
					document.getElementById("showErrorUserEmailId").innerHTML = "Enter valid email address";
					document.getElementById("txtUserEmailId").value = "";
					document.getElementById("txtUserEmailId").focus();
					return false;
				}
			}

			if(document.getElementById("txtUserPasswrdId").value == "") {
				document.getElementById("showErrorPassword").innerHTML = "Password required";
				document.getElementById("txtUserPasswrdId").focus();
				return false;
			}

			if(document.getElementById("txtTermsId").checked == false) {
				document.getElementById("showErrorTerms").innerHTML = "<font style='color:#FF0000;'>Need to check</font>";
				document.getElementById("txtTermsId").focus();
				return false;
			}

			document.frmUserProfile.submit();
		}

		function setUserType(strId) {
			var strOwnerId = "txtOwnerId";
			var strHolidayId = "txtHolidayId";
			var txtIsOwnerId = "txtIsOwnerId";
			switch(strId) {
				case 0:
					if(document.getElementById(strHolidayId).checked == true) {
						document.getElementById(txtIsOwnerId).value = document.getElementById(strHolidayId).value;
						document.getElementById(strOwnerId).checked = "";
						if(document.getElementById("ownerMsgId")) {
							document.getElementById("ownerMsgId").style.display = "none";
						}
						if(document.getElementById("ownerDisplayId")) {
							document.getElementById("ownerDisplayId").style.display = "none";
						}
						document.getElementById("ownerTxtId").style.display = "none";
						document.getElementById("holidayTxtId").style.display = "block";
					} else {
						document.getElementById(txtIsOwnerId).value = document.getElementById(strOwnerId).value;
						document.getElementById(strOwnerId).checked = "checked";
						if(document.getElementById("ownerMsgId")) {
							document.getElementById("ownerMsgId").style.display = "block";
						}
						if(document.getElementById("ownerDisplayId")) {
							document.getElementById("ownerDisplayId").style.display = "block";
						}
						document.getElementById("ownerTxtId").style.display = "block";
						document.getElementById("holidayTxtId").style.display = "none";
					}
				break;
				case 1:
					if(document.getElementById(strOwnerId).checked == true) {
						document.getElementById(txtIsOwnerId).value = document.getElementById(strOwnerId).value;
						document.getElementById(strHolidayId).checked = "";
						if(document.getElementById("ownerMsgId")) {
							document.getElementById("ownerMsgId").style.display = "block";
						}
						if(document.getElementById("ownerDisplayId")) {
							document.getElementById("ownerDisplayId").style.display = "block";
						}
						document.getElementById("ownerTxtId").style.display = "block";
						document.getElementById("holidayTxtId").style.display = "none";
					} else {
						document.getElementById(txtIsOwnerId).value = document.getElementById(strHolidayId).value;
						document.getElementById(strHolidayId).checked = "checked";
						if(document.getElementById("ownerMsgId")) {
							document.getElementById("ownerMsgId").style.display = "none";
						}
						if(document.getElementById("ownerDisplayId")) {
							document.getElementById("ownerDisplayId").style.display = "none";
						}
						document.getElementById("ownerTxtId").style.display = "none";
						document.getElementById("holidayTxtId").style.display = "block";
					}
				break;
			}
		}
    
        function cancelRegistration() {
            window.location = 'index.php';
        }

        function chkblnkTxtError(strFieldId, strErrorFieldId) {
            if(document.getElementById(strFieldId).value != "") {
                document.getElementById(strErrorFieldId).innerHTML = "";
            }
        }
    </script>
</head>
<body onmousedown="show_coords(event);" >
<!-- Main Wrapper Starts Here -->
<div id="wrapper">
    <!-- Header Include Starts Here -->
    <div id="header">
        <?php require_once(SITE_INCLUDES_PATH.'header.php'); ?>
    </div>
    <!-- Header Include End Here -->
    <div id="main">
        <div id="forinner">
            <?php require_once(SITE_INCLUDES_PATH.'holidayadvsearch.php'); ?>
            <div class="littlefont nav8">
                <?php require_once(SITE_INCLUDES_PATH.'breadcrumb.php'); ?>
            </div>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="left" valign="top" class="width240">
                        <?php require_once(SITE_INCLUDES_PATH.'holidayhotproperty-left.php'); ?>
                    </td>
                    <td width="10" align="left" valign="top" style="border-left:1px dashed #44afe1;">&nbsp;</td>
                    <td align="left" valign="top" class="width745 pad-lft15">
                        <?php require_once(SITE_INCLUDES_PATH.'holidayregister.php'); ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
<!-- Main Wrapper End Here -->
<!-- Footer Include Starts Here -->
<div id="footer">
    <?php require_once(SITE_INCLUDES_PATH.'footer.php'); ?>
</div>
<!-- Footer Include End Here -->
</body>
</html>

