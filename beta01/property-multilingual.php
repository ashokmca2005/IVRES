<?php	
	require_once("includes/owner-top.php");

	//form submission
	$form_array = array();
	$errorMsg 	= "no";

	if(isset($_GET['property_id']) && $_GET['property_id'] !=""){
		$property_id 	= $_GET['property_id'];
		$lang_code 		= $_GET['lang_code'];

		
	}

	// Owner property details submit : start here 
	if($_POST['securityKey']==md5(OWNERPROPERTYDETAILS)){		
		if(trim($_POST['txtPropertyName']) == ''){
			$form_array['txtPropertyName'] = 'Please enter a name for your property';
			$errorMsg	= 'yes';
		}else{
			$p_name = trim($_POST['txtPropertyName']);
		}
		if(trim($_POST['txtPropertyTitle']) == ''){
			$form_array['txtPropertyTitle'] = 'Please enter a title for your advert';
			$errorMsg	= 'yes';
		}else{
			$p_title = trim($_POST['txtPropertyTitle']);
		}
		if($_POST['txtPropertyType'] == ''){
			$form_array['txtPropertyType'] = 'Please select a property type';
			$errorMsg	= 'yes';
		}else{
			$p_type = $_POST['txtPropertyType'];
		}

		if($errorMsg == 'no' && $errorMsg != 'yes'){
			if($propertyObj->fun_editProperty($property_id) === true){
				$form_array['error_msg'] = "Property details successfully updated!";
				$propertyObj->fun_updatePropertyLastUpdate($property_id);
				echo "<script> location.href = window.location; </script>";
			} else {
				$form_array['error_msg'] = "Error: We are unable to update your property detail!";
			}
		} else {
			$form_array['error_msg'] = "Please submit your form again!";
		}

	}
	// Owner property details submit : end here 
	//property name
	$propertyName	 	= $propertyObj->fun_getPropertyName($property_id);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo $sitetitle;?> :: Owner :: Add / Edit Property</title>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo tranText('charset'); ?>" />
    <META HTTP-EQUIV="Content-language" CONTENT="<?php echo tranText('lang_iso'); ?>">
    <link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo SITE_URL; ?>favicon.ico" />
    <link rel="SHORTCUT ICON" href="<?php echo SITE_URL; ?>favicon.ico"/>
    <link href="<?php echo SITE_CSS_INCLUDES_PATH;?>common.css" rel="stylesheet" type="text/css" />
</head>
<body bgcolor="#FFFFFF">
<div  style=" border:5px #3300FF solid; margin:10px;">
    <div style="background-color:#FFFFFF;">
    <form name="frmProperty" id="frmPropertyId" method="post" action="<?php echo $linkdet;?>">
    <input type="hidden" name="securityKey" value="<?php echo md5(FRMSUBMIT);?>" />
    <input type="hidden" name="property_id" id="property_id" value="<?php echo $property_id;?>">
    <input type="hidden" name="lang_code" id="lang_code" value="<?php echo $lang_code;?>">
    <table width="90%" border="0" cellspacing="0" cellpadding="0">
        <tr><td align="left" valign="top" style="padding-top:10px; padding-left:25px;"><h1> Add/Edit Property: <?php echo $propertyName; ?></h1></td></tr>
        <tr>
            <td align="left" valign="top" style="padding-top:10px; padding-left:25px;">
                <table width="570" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
                    <tr>
                    	<td align="left" valign="top">
                        	<strong><?php echo ucwords(str_replace("_", " ", $_GET['field']));?></strong>&nbsp;<img src="images/flag/<?php echo $lang_code;?>.png" width="18" border="0" alt="<?php echo $lang_code;?>" />
                        </td>
                    </tr>
                    <tr height="10px"><td></td></tr>
                    <tr>
                        <td align="left" valign="top">
                        <?php 
						if(isset($_GET['type']) && $_GET['type'] != "") {
							switch ($_GET['type']) {
								case 'textbox':
									echo '<input name="'.$_GET['field'].'" id="'.$_GET['field'].'" type="text" class="Textfield280" value="" maxlength="'.$_GET['limit'].'" />';
								break;
	
								case 'textarea':
									echo '<textarea name="'.$_GET['field'].'" id="'.$_GET['field'].'"  cols="5" rows="5"></textarea>';
								break;
							}
						}
						?>
                        </td>
                    </tr>
                    <tr height="10px"><td></td></tr>
                    <tr>
                        <td valign="top" align="left"><a href="javascript:void(0);" onclick="return frmSubmit();"><img src="<?php echo SITE_IMAGES;?>save details button.png" alt="save" border="0" /></a></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    </form>
    </div>
</div>
<!--wrapper -->
</body>
</html>
