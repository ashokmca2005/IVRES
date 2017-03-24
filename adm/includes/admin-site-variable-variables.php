<?php
$detail_array 	= array();
$error_msg		= 'no';

if($_POST['securityKey']==md5(ADDSITEVARIABLE)){		
	$txtSiteVariableId 		= trim($_POST['txtSiteVariableId']);
//	$txtVName 				= trim($_POST['txtVName']);
	$txtValue 				= trim($_POST['txtValue']);

	if($error_msg == 'no') {
		$site_variable_id 	= $systemObj->fun_editSiteVariable($txtSiteVariableId, $txtValue);
		if($site_variable_id){
			echo "<script>location.href = window.location;</script>";
		} else {
			$detail_array['error_msg'] = "Error: We are unable to add your review!";
		}
	} else {
		$detail_array['error_msg'] = "Please submit your form again!";
	}
}



$svid = $_GET['svid'];
if(isset($svid) && $svid !=""){
$siteVariableInfoArr 	= $systemObj->fun_getSiteVariableInfo($svid);
?>
<script type="text/javascript" src="../tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		mode : "exact",
		elements : "txtReviewTxtId",
		handle_event_callback : "myHandleEvent",
		theme : "simple",
		plugins : 'advlink,advimage',
		relative_urls : false,
		remove_script_host : false
	});

	//event such as key or mouse press
	function myHandleEvent(e){
		if(e.type=="keyup"){
			chkblnkEditorTxtError("txtReviewTxtId", "txtReviewTxtErrorId");	
		}
		return true;
	}
</script>
<!-- /TinyMCE -->
<script language="javascript" type="text/javascript">
	var req = ajaxFunction();
	function frmValidateAddReview() {
		var shwError = false;
		

		if(document.frmAddSiteVariable.txtValue.value == "") {
			document.getElementById("txtLNameErrorId").innerHTML = "Please enter variable value.";
			document.frmAddSiteVariable.txtValue.focus();
			shwError = true;
		}

		if(shwError == true) {
			return false;
		} else {
			document.frmAddSiteVariable.submit();
		}
	}

</script>

 <form name="frmAddSiteVariable" id="frmAddSiteVariable" action="admin-site-variables.php?sec=vari&svid=<?php echo $siteVariableInfoArr['site_variable_id']; ?>" method="post">
<input type="hidden" name="securityKey" id="securityKey" value="<?php echo md5("ADDSITEVARIABLE")?>">
<input type="hidden" name="txtSiteVariableId" id="txtSiteVariableId" value="<?php echo $siteVariableInfoArr['site_variable_id']; ?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
    <tr><td height="10" colspan="2" valign="top">&nbsp;</td></tr>
    <tr>
        <td valign="top"><a href="admin-site-variables.php?sec=vari" class="back">Back to List</a></td>
        <td align="right" valign="top">&nbsp;</td>
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
                                                        <td>
                                                            Reference ID : <?php echo fill_zero_left($siteVariableInfoArr['site_variable_id'], "0", (6-strlen($siteVariableInfoArr['site_variable_id'])));?>
                                                        </td>
                                                        <td align="right" valign="bottom"><a href="admin-pending-approval.php?sec=review" style="text-decoration:none;"><img src="images/cancelChangesN.png" alt="Cancel" width="119" height="21" border="0" /></a>&nbsp;<a href="javascript:void(0);" onclick="frmValidateAddReview();" style="text-decoration:none;"><img src="images/saveChangesN.png" alt="Save Approve" width="108" height="21" border="0" /></a></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td height="23"  align="right" valign="top" class="admleftBg">Variable Name</td>
                                            <td  valign="top"><?php echo $siteVariableInfoArr['site_variable_name']; ?></td>
                                        </tr>
                                        <tr>
                                            <td height="23"  align="right" valign="top" class="admleftBg">Variable Value</td>
                                            <td  valign="top"><input name="txtValue" id="txtValueId" type="text" class="inpuTxt260" value="<?php echo $siteVariableInfoArr['site_variable_value']; ?>" onkeydown="chkblnkTxtError('txtLNameId', 'txtLNameErrorId');" onkeyup="chkblnkTxtError('txtLNameId', 'txtLNameErrorId');" /><span class="pdError1 pad-lft10" id="txtLNameErrorId"></span></td>
                                        </tr>
              							<tr>
											<td colspan="2" align="right" valign="top" class="header">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">
													<tr>
														<td>Reference ID : <?php echo fill_zero_left($siteVariableInfoArr['site_variable_id'], "0", (6-strlen($siteVariableInfoArr['site_variable_id'])));?></td>
														<td align="right" valign="bottom"><a href="admin-site-variables.php?sec=vari" style="text-decoration:none;"><img src="images/cancelChangesN.png" alt="Cancel" width="119" height="21" /></a>&nbsp;<a href="javascript:void(0);" onclick="frmValidateAddReview();" style="text-decoration:none;"><img src="images/saveChangesN.png" alt="Save Approve" width="108" height="21" border="0" /></a></td>
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
<?php
} else {

 	if(isset($_GET['sortby']) && $_GET['sortby'] != ""){
		$strQuery = " ORDER BY ";
		switch($_GET['sortby']){
			case 'site_variable_id':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$site_variable_iddr 		= 0;
					$site_variable_namedr		= 1;
					$site_variable_valuedr 		= 1;
				} else {
					$dr = "DESC";
					$site_variable_iddr 		= 1;
					$site_variable_namedr		= 1;
					$site_variable_valuedr 		= 1;
				}
				$strQuery .= " A.site_variable_id ".$dr;
			break;
			case 'site_variable_name':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$site_variable_iddr 		= 1;
					$site_variable_namedr		= 0;
					$site_variable_valuedr 		= 1;
				} else {
					$dr = "DESC";
					$site_variable_iddr 		= 1;
					$site_variable_namedr		= 1;
					$site_variable_valuedr 		= 1;
				}
				$strQuery .= " A.site_variable_name ".$dr;
			break;
			case 'site_variable_value':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$site_variable_iddr 		= 1;
					$site_variable_namedr		= 1;
					$site_variable_valuedr 		= 0;
				} else {
					$dr = "DESC";
					$site_variable_iddr 		= 1;
					$site_variable_namedr		= 1;
					$site_variable_valuedr 		= 1;
				}
				$strQuery .= " A.site_variable_value ".$dr;
			break;
		}
	} else {
				$site_variable_iddr 		= 1;
				$site_variable_namedr		= 1;
				$site_variable_valuedr 		= 1;
	}

	$siteVariableArr 				= $systemObj->fun_getSiteVariableArr($strQuery);
//	$hotpropArr				= $propertyObj->fun_getCollateralHotPropertyArr($strQuery);
	if(is_array($siteVariableArr) && count($siteVariableArr) > 0){
	?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr><td colspan="2" valign="top">&nbsp;</td></tr>
			<tr>
				<td colspan="2" valign="top">
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EventListing">
						<thead>
							<tr>
								<th width="10%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-site-variables.php?sec=vari&sortby=site_variable_id&dr=".$site_variable_iddr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "site_variable_id")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?> ><div>ID</div></th>
								<th width="30%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-site-variables.php?sec=vari&sortby=site_variable_name&dr=".$site_variable_namedr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "site_variable_name")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>Variable Name</div></th>
								<th width="15%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-site-variables.php?sec=vari&sortby=site_variable_value&dr=".$site_variable_valuedr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "site_variable_value")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?> ><div>Variable Value</div></th>
							</tr>
						</thead>
						<tbody>
							<?php
                            for($i=0; $i < count($siteVariableArr); $i++){
                                $site_variable_id 			= $siteVariableArr[$i]['site_variable_id'];
                                $site_variable_name 		= $siteVariableArr[$i]['site_variable_name'];
                                $site_variable_value 		= $siteVariableArr[$i]['site_variable_value'];									
                            ?>
                                <tr>
                                    <td class="left"><a href="admin-site-variables.php?sec=vari&svid=<?php echo $site_variable_id;?>"><?php echo fill_zero_left($site_variable_id, "0", (6-strlen($site_variable_id)));?></a></td>
                                    <td><?php echo $site_variable_name; ?></td>
                                    <td class="right"><?php echo $site_variable_value; ?></td>
                                </tr>
                            <?php
                            }
                            ?>
						</tbody>
					</table>
				</td>
			</tr>
			<tr><td colspan="2" valign="top">&nbsp;</td></tr>
		</table>

    <!-- Main Table : End here -->
<?php
}

}
?>