<script language="javascript" type="text/javascript">
	function frmEdit() {
		document.getElementById("txtTermsCondition").value = "";
		document.frmPropHot.action = "owner-hot-property.php";
		document.frmPropHot.submit();
	}
	
	function frmSubmit() {
		document.getElementById("txtTermsCondition").value = "1";
		document.frmPropHot.action = "owner-hot-property.php?sec=thk";
		document.frmPropHot.submit();
	}
	
	function cancelAddHotProperty() {
		window.location = 'owner-home.php';	
	}
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr><td align="left" valign="top" class="pad-top25"><h1 class="page-headingNew">Preview</h1></td></tr>
    <tr>
        <td align="left" valign="top">
        <form name="frmPropHot" action="owner-hot-property.php?sec=thk" method="post">
            <input type="hidden" name="securityKey" value="<?php echo md5(OWNERHOTPROPERTY);?>" />
            <input type="hidden" name="txtPrpertyRef" value="<?php echo $txtPrpertyRef;?>" />
            <input type="hidden" name="txtDayFrom0" value="<?php echo $txtDayFrom0;?>" />
            <input type="hidden" name="txtMonthFrom0" value="<?php echo $txtMonthFrom0;?>" />
            <input type="hidden" name="txtYearFrom0" value="<?php echo $txtYearFrom0;?>" />
            <input type="hidden" name="txtWeeks" value="<?php echo $txtWeeks;?>" />
            <input type="hidden" name="txtConfirm" value="1" />
            <input type="hidden" name="txtTermsCondition" id="txtTermsCondition" value="" />
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr><td valign="top" class="pad-btm10"><strong>This is how your featured property will appear on the site.</strong><br />Please check it carefully.</td></tr>
                <tr><td valign="top" class="dash25">&nbsp;</td></tr>
                <tr>
                    <td valign="top">
                        <table width="100%" border="0" cellspacing="0" cellpadding="1">
                            <tr>
                                <td width="49%" align="right">Featured property goes live on the site :</td>
                                <td width="51%" align="left"><strong><?php echo date('F d, Y', strtotime($txtYearFrom0."-".$txtMonthFrom0."-".$txtDayFrom0)); ?></strong></td>
                            </tr>
                            <tr>
                                <td align="right">For :</td>
                                <td align="left"><strong><?php echo $txtWeeks;?> weeks</strong></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr><td valign="top" class="dash25">&nbsp;</td></tr>
                <tr><td align="right" valign="top"><a href="javascript:cancelAddHotProperty();" class="button-grey" style="text-decoration:none;">Cancel</a>&nbsp;&nbsp;<a href="javascript:frmEdit();" class="button-grey" style="text-decoration:none;">Edit</a>&nbsp;&nbsp;<a href="javascript:frmSubmit();" class="button-blue" style="text-decoration:none;">Confirm</a></td></tr>
            </table>
        </form>
        </td>
    </tr>
</table>