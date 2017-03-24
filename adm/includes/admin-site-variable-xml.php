<?php
// Form submision
$form_array 	= array();
$error_msg		= 'no';
$seo_id 		= $_REQUEST['seo_id'];

if($_POST['securityKey'] == md5(ADDSEO)){
	$seo_url 			= $_POST['seo_url'];
	$seo_title 			= $_POST['seo_title'];
	$seo_keywords 		= $_POST['seo_keywords'];
	$seo_description 	= $_POST['seo_description'];
	$seo_id 			= $seoObj->fun_addSeo($seo_url, $seo_title, $seo_keywords, $seo_description);

	if(isset($seo_id) && $seo_id !="") {
		echo "<script>location.href = 'admin-site-variables.php?sec=seo&subsec=edit&seo_id=".$seo_id."';</script>";
	} else {
		echo "<script>location.href = 'admin-site-variables.php?sec=seo';</script>";
	}
}

if($_POST['securityKey'] == md5(EDITSEO)){
	$seo_url 			= $_POST['seo_url'];
	$seo_title 			= $_POST['seo_title'];
	$seo_keywords 		= $_POST['seo_keywords'];
	$seo_description 	= $_POST['seo_description'];
	$seoObj->fun_editSeo($seo_id, $seo_url, $seo_title, $seo_keywords, $seo_description);
	echo "<script>location.href = 'admin-site-variables.php?sec=seo&subsec=edit&seo_id=".$seo_id."';</script>";
}

if(isset($_GET['subsec']) && $_GET['subsec'] !=""){
	if($_GET['subsec'] == 'edit') {
		$seo_id 	= $_REQUEST['seo_id'];
		$seoInfoArr = $seoObj->fun_getSeoInfo($seo_id);
		$addtitle 	= "Edit Meta Info";
		$edit 		= TRUE;
	} else {
		$addtitle 	= "Add Meta Info";
		$edit 		= FALSE;
	}
	?>
	<script language="javascript" type="text/javascript">
        function frmValidateAddSeo() {
            var shwError = false;
            if(document.frmAddSeo.seo_url.value == "") {
                document.getElementById("seo_url_errorid").innerHTML = "Please enter URL";
                document.frmAddSeo.seo_url.focus();
                shwError = true;
            }
    
            if(document.frmAddSeo.seo_title.value == "") {
                document.getElementById("seo_title_errorid").innerHTML = "Please enter title";
                document.frmAddSeo.seo_title.focus();
                shwError = true;
            }
    
            if(document.frmAddSeo.seo_keywords.value == "") {
                document.getElementById("seo_keywords_errorid").innerHTML = "Please enter keywords";
                document.frmAddSeo.seo_keywords.focus();
                shwError = true;
            }
    
            if(document.frmAddSeo.seo_description.value == "") {
                document.getElementById("seo_description_errorid").innerHTML = "Please enter description";
                document.frmAddSeo.seo_description.focus();
                shwError = true;
            }
    
            if(shwError == true) {
                return false;
            } else {
                document.frmAddSeo.submit();
            }
        }
        
        function chkblnkTxtError(strFieldId, strErrorFieldId) {
            if(document.getElementById(strFieldId).value != "") {
                document.getElementById(strErrorFieldId).innerHTML = "";
            }
        }
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
                            <form name="frmAddSeo" id="frmAddSeo" action="admin-site-variables.php?sec=seo<?php if($edit == true) { echo "&subsec=edit&seo_id=".$seo_id; } ?>" method="post" >
                            <input type="hidden" name="securityKey" id="securityKey" value="<?php if($edit == true) { echo md5("EDITSEO"); } else { echo md5("ADDSEO"); } ?>">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
                                <tr><td height="5" colspan="2" valign="top">&nbsp;</td></tr>
                                <tr>
                                    <td valign="top"><a href="admin-site-variables.php?sec=seo" class="back">Back to List</a></td>
                                    <td align="right" valign="top">&nbsp;</td>
                                </tr>
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
                                                                        <td height="23" align="right" valign="top" class="admleftBg">Url</td>
                                                                        <td valign="top"><input name="seo_url" id="seo_url_id" class="inpuTxt260" value="<?php echo $seoInfoArr['seo_url']; ?>" type="text" /><span class="pdError1 pad-lft10" id="seo_url_errorid"></span></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td height="23" align="right" valign="top" class="admleftBg">Title</td>
                                                                        <td valign="top"><input name="seo_title" id="seo_title_id" class="inpuTxt260" value="<?php echo $seoInfoArr['seo_title']; ?>" type="text" /><span class="pdError1 pad-lft10" id="seo_title_errorid"></span></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td height="23" align="right" valign="top" class="admleftBg">Keywords</td>
                                                                        <td valign="top"><input name="seo_keywords" id="seo_keywords_id" class="inpuTxt260" value="<?php echo $seoInfoArr['seo_keywords']; ?>" type="text" /><span class="pdError1 pad-lft10" id="seo_keywords_errorid"></span></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td height="23" align="right" valign="top" class="admleftBg">Description</td>
                                                                        <td valign="top"><input name="seo_description" id="seo_description_id" class="inpuTxt260" value="<?php echo $seoInfoArr['seo_description']; ?>" type="text" /><span class="pdError1 pad-lft10" id="seo_description_errorid"></span></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td colspan="2" align="right" valign="top" class="header">
                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                <tr>
                                                                                    <td align="right" valign="bottom" colspan="2">
                                                                                        <a href="admin-site-variables.php?sec=seo" style="text-decoration: none;"><img src="images/cancelN.png" border="0" width="66" height="21" alt="Cancel"></a>&nbsp;<a href="javascript:void(0);" onClick="frmValidateAddSeo();" style="text-decoration:none;"><img src="images/saveApproveN.png" alt="Save Now" width="117" height="21" border="0" /></a>
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
	<?php
} else {
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
	<tr>
		<td valign="top" class="SectionSubHead"><?php echo $addtitle;?></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td height="10" colspan="2" valign="top">&nbsp;</td>
	</tr>
	<tr>
		<td  colspan="2" valign="top" class="blueBotBorder"><img src="images/spacer.gif" height="8" alt="One" /></td>
	</tr>
	<tr>
		<td colspan="2" valign="top" class="pad-top15">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
				<tr>
					<td valign="top">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td valign="top">No SEO info added!</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<?php
}
?>
