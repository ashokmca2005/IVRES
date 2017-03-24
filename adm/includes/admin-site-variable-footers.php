<?php
	require_once(SITE_CLASSES_PATH."class.CMS.php");
	$cmsobj         = new Cms();
$page_id  = md5('9');
$pageInfo = $cmsObj->fun_getPageInfo($page_id);
if(isset($_POST['securityKey']) && $_POST['securityKey'] == md5("EDITPAGE")){
	$page_id = $_POST['pageId'];
	$cmsObj->fun_updatePage($_POST);
	$message = "The page informationa is successfully updated.";
	$pageInfo = $cmsObj->fun_getPageInfo($page_id);
}
?>
<script language="javascript" type="text/javascript">
function frmValidateEditPage(){
	var arr_msg         = Array();
	var count           = arr_msg.length;
	var alreadyFocussed = false;

	if(document.getElementById('txtPageTitleId').value == ""){
		document.getElementById('txtPageTitleErrorId').innerHTML = "Error: Please enter page title.";
		if(!alreadyFocussed){
			document.getElementById('txtPageTitleErrorId').focus();
			alreadyFocussed = true;
		}
		count++;
	}
	
	document.frmEditFooter.txtPageDescription.value = tinyMCE.get('txtPageDescriptionId').getContent();
	if(document.frmEditFooter.txtPageDescription.value == ""){
		document.getElementById("txtPageDescriptionErrorId").innerHTML = "Error: Please enter page discription.";
		if(!alreadyFocussed){
			document.frmEditFooter.txtPageDescription.focus();
			alreadyFocussed = true;
		}
		count++;
	}

	if(count == 0){
		document.frmEditFooter.submit();
	}else{
		return false;
	}
}

function chkblnkTxtError(strFieldId, strErrorFieldId){
	if(document.getElementById(strFieldId).value != ""){
		document.getElementById(strErrorFieldId).innerHTML = "";
	}
}

function chkblnkEditorTxtError(strFieldId, strErrorFieldId){
	if(tinyMCE.get(strFieldId).getContent() != ""){
		document.getElementById(strErrorFieldId).innerHTML = "";
	}
}

</script>
<!-- TinyMCE -->
<script type="text/javascript" src="../tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		mode : "exact",
		elements : "txtPageDescriptionId",
		theme : "advanced",
		plugins : 'advlink,advimage',
		relative_urls : false,
		remove_script_host : false
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		content_css : "../css/holiday.css, ../css/owner.css"    // resolved to http://domain.mine/mysite/mycontent.css
		
	});

	function myHandleEvent(e){
		if(e.type=="keyup"){
			chkblnkEditorTxtError("txtPageDescriptionId", "txtPageDescriptionErrorId");	
		}
		return true;
	}
</script>
<!-- /TinyMCE -->
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
    <tr>
        <td valign="top" class="SectionSubHead">Site Footer</td>
        <td valign="top">&nbsp;</td>
    </tr>
    <tr>
        <td valign="top" colspan="2">
            <form name="frmEditFooter" id="frmEditFooter" action="admin-site-variables.php?sec=foot" method="post" >
                <input type="hidden" name="securityKey" id="securityKey" value="<?php echo md5("EDITPAGE");?>">
                <input type="hidden" name="pageId" id="pageId" value="<?php echo $page_id;?>" />
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
                    <tr><td height="5" colspan="2" valign="top">&nbsp;</td></tr>
                    <?php if(isset($message) && $message <> ''){?>
                        <tr><td height="5" colspan="2" valign="top"><?php echo $message;?></td></tr>
                    <?php }?>
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
                                                                    <tr><td align="right" valign="bottom" colspan="2"><a href="javascript:void(0);" onClick="frmValidateEditPage();" style="text-decoration:none;"><img src="images/saveChangesN.png" alt="Save Approve" width="108" height="21" border="0" /></a></td></tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td height="23" align="right" valign="top" class="admleftBg">Page Title</td>
                                                            <td valign="top"><input name="txtPageTitle" id="txtPageTitleId" class="inpuTxt260" value="<?php echo stripslashes($pageInfo['page_title']);?>" type="text" /><span class="pdError1 pad-lft10" id="txtPageTitleErrorId"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td height="23" align="right" valign="top" class="admleftBg">Page Discription</td>
                                                            <td valign="top">
                                                                <textarea name="txtPageDescription" id="txtPageDescriptionId" cols="" rows="" class="txtarea_540x300"><?php echo stripslashes($pageInfo['page_discription']);?></textarea>
                                                                <span class="pdError1 pad-lft10" id="txtPageDescriptionErrorId"></span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td height="23" align="right" valign="top" class="admleftBg">Created On</td>
                                                            <td valign="top"><?php echo date('M d, Y', $pageInfo['created_on']);?></td>
                                                        </tr>
                                                        <tr>
                                                            <td height="23" align="right" valign="top" class="admleftBg">Updated On</td>
                                                            <td valign="top"><?php echo date('M d, Y', $pageInfo['updated_on']);?></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" align="right" valign="top" class="header">
                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                    <tr><td align="right" valign="bottom" colspan="2"><a href="javascript:void(0);" onClick="frmValidateEditPage();" style="text-decoration:none;"><img src="images/saveChangesN.png" alt="Save Approve" width="108" height="21" border="0" /></a></td></tr>
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
        </td>
    </tr>
</table>
