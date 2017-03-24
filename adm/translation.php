<?php
	require_once("includes/application-top-inner.php");
	//form submission
	$form_array = array();
	$errorMsg 	= "no";

//translation.php?section_id=1&section_ref_id='.$page_id.'&lang_code='.$lang_code.'&field_name=page_content_title&type=textbox&limit=0

	if(isset($_GET['section_id']) && $_GET['section_id'] !="" && isset($_GET['section_ref_id']) && $_GET['section_ref_id'] !=""){
		$section_id		= $_GET['section_id'];
		$section_ref_id	= $_GET['section_ref_id'];
		$lang_code 		= $_GET['lang_code'];
		$field_name 	= $_GET['field_name'];
		$type 			= $_GET['type'];
		$limit 			= $_GET['limit'];

		//section name & field name
		$section_name		= $dbObj->getField(TABLE_SECTION, "section_id", $section_id, "section_name");
		switch($section_id	) {
			case '1':
				$section_ref_name	= $dbObj->getField(TABLE_CMS, "page_id", $section_ref_id, "page_title");
			break;
			case '2':
				$section_ref_name	= $dbObj->getField(TABLE_PROPERTY, "property_id", $section_ref_id, "property_name");
			break;
		}
		$field_name_value 	= fun_db_output($dbObj->getField(TABLE_TRANSLATION, array("lang_code", "section_id", "section_ref_id", "field_name"), array($lang_code, $section_id, $section_ref_id, $field_name), "field_value"));
	}

	//Form submit : start here 
	if($_POST['securityKey']==md5(FRMSUBMIT)){		
		if(trim($_POST[$field_name]) == ''){
			$form_array['error_msg'] = 'Error: required field is empty!';
			$errorMsg	= 'yes';
		}
		if($errorMsg == 'no' && $errorMsg != 'yes'){
			$cur_unixtime 	= time ();
			if(isset($_SESSION['ses_admin_id']) && $_SESSION['ses_admin_id'] !=""){
				$cur_user_id 	= $_SESSION['ses_admin_id'];
			} else if(isset($_SESSION['ses_modarator_id']) && $_SESSION['ses_modarator_id'] !="") {
				$cur_user_id 	= $_SESSION['ses_modarator_id'];
			} else if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !="") {
				$cur_user_id 	= $_SESSION['ses_user_id'];
			} else {
				$cur_user_id 	= "";
			}
			//Check if entry available
			$sql 	= "SELECT id FROM ". TABLE_TRANSLATION." WHERE lang_code='".$lang_code."' AND section_id='".$section_id."' AND section_ref_id='".$section_ref_id."' AND field_name='".$field_name."' ";
			$rs 	= $dbObj->createRecordset($sql);
			if($dbObj->getRecordCount($rs) > 0){
				//update 
				$sqlUpdate = "UPDATE " . TABLE_TRANSLATION . " SET 
				field_value ='".fun_db_input($_POST[$field_name])."', 
				created_on ='".$cur_unixtime."', 
				created_by ='".$cur_user_id."', 
				updated_on ='".$cur_unixtime."', 
				updated_by ='".$cur_user_id."' 
				WHERE lang_code='".$lang_code."' AND section_id='".$section_id."' AND section_ref_id='".$section_ref_id."' AND field_name='".$field_name."' ";
				$dbObj->mySqlSafeQuery($sqlUpdate);
			} else {
				//insert
				$sqlInsert = "INSERT INTO " . TABLE_TRANSLATION . "(id, lang_code, section_id, section_ref_id, field_name, field_value, created_on, created_by, updated_on, updated_by) ";
				$sqlInsert .= "VALUES(null, '".$lang_code."', '".$section_id."', '".$section_ref_id."', '".$field_name."', '".fun_db_input($_POST[$field_name])."', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."')";
				$dbObj->mySqlSafeQuery($sqlInsert);
			}
			$form_array['error_msg'] = "translation successfully updated!";
		} else {
			$form_array['error_msg'] = "Please submit your form again!";
		}
	}
	//Form submit : end here 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo $sitetitle;?> :: Translation</title>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo tranText('charset'); ?>" />
    <META HTTP-EQUIV="Content-language" CONTENT="<?php echo tranText('lang_iso'); ?>">
    <link href="<?php echo SITE_CSS_INCLUDES_PATH;?>common.css" rel="stylesheet" type="text/css" />
    <script language="javascript" type="text/javascript">
		function frmSubmit() {
			if(document.getElementById("<?php echo $field_name; ?>").value == "") {
				document.getElementById("error_msg").innerHTML = "Error: required field is empty!";
				document.getElementById("<?php echo $field_name; ?>").focus();
				return false;
			} else {
				document.getElementById("frmTrs").submit();
			}
		}
	</script>
</head>
<body bgcolor="#FFFFFF">
<div  style=" border:5px #3300FF solid; margin:10px;">
    <div style="background-color:#FFFFFF;">
    <form name="frmTrs" id="frmTrs" method="post" action="<?php echo $_SERVER['PHP_SELF']."?section_id=".$section_id."&section_ref_id=".$section_ref_id."&lang_code=".$lang_code."&field_name=".$_GET['field_name']."&type=".$_GET['type']."&limit=".$_GET['limit'];?>">
    <input type="hidden" name="securityKey" value="<?php echo md5(FRMSUBMIT);?>" />
    <input type="hidden" name="section_id" id="section_id" value="<?php echo $section_id;?>">
    <input type="hidden" name="section_ref_id" id="section_ref_id" value="<?php echo $section_ref_id;?>">
    <input type="hidden" name="lang_code" id="lang_code" value="<?php echo $lang_code;?>">
    <table width="90%" border="0" cellspacing="0" cellpadding="0">
        <tr><td align="left" valign="top" style="padding-top:10px; padding-left:25px;"><h1>Translate <?php echo $section_name; ?>: <?php echo $section_ref_name; ?></h1></td></tr>
		<?php
			if($_POST['securityKey']==md5(FRMSUBMIT)){		
				echo '<tr><td align="left" valign="top" style="padding-top:10px; padding-left:25px; color:#BF0000;" id="error_msg">';
				echo $form_array['error_msg'];
				echo '</td></tr>';
			}
		?>
        <tr>
            <td align="left" valign="top" style="padding-top:10px; padding-left:25px;">
                <table width="570" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF">
                    <tr>
                    	<td align="left" valign="top">
                        	<strong><?php echo ucwords(str_replace("_", " ", $_GET['field_name']));?></strong>&nbsp;<img src="../images/flag/<?php echo $lang_code;?>.png" width="18" border="0" alt="<?php echo $lang_code;?>" />
                        </td>
                    </tr>
                    <tr height="10px"><td></td></tr>
                    <tr>
                        <td align="left" valign="top">
                        <?php 
						if(isset($_GET['type']) && $_GET['type'] != "") {
							switch ($_GET['type']) {
								case 'textbox':
									echo '<input name="'.$_GET['field_name'].'" id="'.$_GET['field_name'].'" type="text" class="Textfield280" value="'.((isset($_POST[$field_name]) && ($_POST[$field_name] != ""))?$_POST[$field_name]:$field_name_value).'" maxlength="'.$_GET['limit'].'" />';
								break;
	
								case 'textarea':
									echo '<textarea name="'.$_GET['field_name'].'" id="'.$_GET['field_name'].'" cols="80" rows="5">'.((isset($_POST[$field_name]) && ($_POST[$field_name] != ""))?$_POST[$field_name]:$field_name_value).'</textarea>';
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
