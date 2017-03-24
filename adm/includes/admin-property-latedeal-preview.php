
<script language="javascript" type="text/javascript">
function frmEdit() {
	var linkspe =  <?php echo $linkspe; ?>;
	document.frmPropDeals.action = linkspe+"&spe=edit";
	document.frmPropDeals.submit();
}

function frmSubmit() {
	if(document.frmPropDeals.txtTermsCondition.checked == false) {
		document.getElementById("txtDealErrorMsg").innerHTML = "Please read and agree to the T&C's!";
		return false;
	} else {
		var linkspe =  <?php echo $linkspe; ?>;
		document.frmPropDeals.action = linkspe;
		document.frmPropDeals.submit();
	}
}

</script>

<div style="clear:both;">
<form name="frmPropDeals" action="<?php echo $_SERVER['REQUEST_URI']; ?>&spe=pre" method="post">
<input type="hidden" name="securityKey" value="<?php echo md5(OWNERPROPERTYDEALS);?>" />

<input type="hidden" name="txtDayFrom0" value="<?php echo $txtDayFrom0;?>" />
<input type="hidden" name="txtMonthFrom0" value="<?php echo $txtMonthFrom0;?>" />
<input type="hidden" name="txtYearFrom0" value="<?php echo $txtYearFrom0;?>" />

<input type="hidden" name="txtDayTo0" value="<?php echo $txtDayTo0;?>" />
<input type="hidden" name="txtMonthTo0" value="<?php echo $txtMonthTo0;?>" />
<input type="hidden" name="txtYearTo0" value="<?php echo $txtYearTo0;?>" />

<input type="hidden" name="txtCurrencyType" value="<?php echo $txtCurrencyType;?>" />
<input type="hidden" name="txtOrgNightPrice0" value="<?php echo $txtOrgNightPrice0;?>" />
<input type="hidden" name="txtSaleNightPrice0" value="<?php echo $txtSaleNightPrice0;?>" />
<input type="hidden" name="txtRemoveDealFrom0" value="<?php echo $txtRemoveDealFrom0;?>" />

<input type="hidden" name="txtPrpertyRef" value="<?php echo $txtPrpertyRef;?>" />

<table width="690" border="0" cellspacing="0" cellpadding="0" class="font12">
    <tr>
        <td align="left" colspan="2" valign="top" class="pad-btm3">
            <div class="FloatLft"><h2 class="page-heading-red">Late deals</h2></div>
            <div class="FloatRgt"><a href="admin-pending-approval.php?sec=<?php echo $sec;?>&subsec=spe&spe=ove&pid=<?php echo $property_id;?>"><img src="<?php echo SITE_IMAGES;?>view-my-latedeals.png" /></a></div>
        </td>
    </tr>
    <tr><td colspan="2" align="left" valign="top" class="dash25">&nbsp;</td></tr>
    <tr><td colspan="2" align="left" valign="top"><div class="owner-headings pad-btm20">Preview your late deal</div></td></tr>
    <tr>
        <td colspan="2" align="left" valign="top">
            <table border="0" cellspacing="0" cellpadding="0" width="100%" class="latedealLiting">
                <tr>
                    <th>Time left</th>
                    <th>Price / night</th>
                    <th>Save</th>
                    <th align="left">Details</th>
                    <th>Dates</th>
                    <th>&nbsp;</th>
                </tr>
                <tr class="lineHight14">
                    <td width="65" align="center"><span class="font14"><?php echo $strTimeLeft; ?></span></td>
                    <td width="75" align="center"><span class="red16"><?php echo $strPricePerNight; ?></span></td>
                    <td width="40" align="center"><span class="red16"><?php echo $strPercentSave."%"; ?></span></td>
                    <td width="300">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0"> 
                            <tr>
                                <td width="100">
                                    <div class="latedealPhoto"><img src="<?php echo $strThumbUrl;?>" width="88" height="66" alt="<?php echo $strThumbCap;?>" title="<?php echo $strThumbCap;?>" align="middle" /></div>
                                </td>
                                <td width="135" class="dash-right">
                                    <strong class="black"><?php echo $strPropertyName;?></strong><br />
                                    <?php echo ucwords($strPropLocArr['region_pname']);?><br />
                                    <?php echo ucwords($strPropLocArr['region_name']);?><br />
                                    <?php echo ucwords($strPropLocArr['location_name']);?>
                                </td>
                                <td width="95">
                                    <?php 
									if(count($strPropertyTotalBeds) > 1) {
										echo $strPropertyTotalBeds." bed<br />";
									} else if(count($strPropertyTotalBeds) == 1) {
										echo $strPropertyTotalBeds." beds<br />";
									}
									?>

                                    <?php 
									if(count($strPropertyTotalBaths) > 1) {
										echo $strPropertyTotalBaths." bathrooms<br />";
									} else if(count($strPropertyTotalBaths) == 1) {
										echo $strPropertyTotalBaths." bathrooms<br />";
									}
									?>
                                    swimming pool<br />
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td width="100" class="font11">
                        <strong class="black">
						<?php 
                        if((int)$strNights > 1) {
                            echo $strNights." nights";
                        } else if((int)$strNights == 1) {
                            echo $strNights." night";
                        }
                        ?>
                        </strong>
                        <br />
                        <?php echo date('D M j, Y', $strUnixDateFrom); ?><br />
                        to<br />
                        <?php echo date('D M j, Y', $strUnixDateTo); ?>
                    </td>
                    <td width="70" class="right">&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr><td colspan="2" align="left" valign="top" height="5"></td></tr>
    <tr>
        <td colspan="2" valign="top" class="latedealBox">
            <table border="0" width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td><input type="checkbox" class="checkbox" name="txtTermsCondition" id="txtTermsConditionId" value="1" /></td>
                    <td valign="top" class="pad-lft5">Tick here if you have read and agree to the <a href="javascript:popcontact('terms.html')" class="blue-link">Terms and Conditions</a> for placing this late deal</td>
                </tr>
                <tr><td colspan="2"  height="12"></td></tr>
                <tr>
                    <td colspan="2" class="pad-rgt20">
                        <div class="FloatLft"><a href="javascript:toggleLayer1('late-deal-cancel-pop');"><img src="<?php echo SITE_IMAGES;?>cancel-admin.png" alt="Cancel"/></a></div>
                        <div class="FloatLft pad-lft5">
                            <input type="image" src="<?php echo SITE_IMAGES;?>edit.png" alt="Edit" onclick="return frmEdit();" >
                        </div>
                        <div class="FloatLft pad-lft5">
                            <input type="image" src="<?php echo SITE_IMAGES;?>confirm-update.png" alt="Submit" onclick="return frmSubmit();" >
                        </div>
                        <div class="FloatLft pad-lft5  pad-top3" align="left" style="font-size:12px; color:#FF0000; font-weight:bold;" id="txtDealErrorMsg">&nbsp;</div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>



    <tr>
        <td colspan="2" align="left" valign="top">
            <div id="late-deal-cancel-pop" class="box cursor1" style="display:none; position:absolute; left:300px; top:570px;">
            <!--[if IE]><iframe id="iframe" frameborder="0" style="position:absolute;top:3px;left:3px;width:280px; height:148px;"></iframe><![endif]-->
            <div class="content">
            <div onMouseDown="dragStart(event, 'late-deal-cancel-pop');" style="position:relative; z-index:999;left:0px;width:300px;height:158px;">
                        <table width="255" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td align="right"><img src="<?php echo SITE_IMAGES;?>poplefttop.png" alt="ANP" /></td>
                                <td class="topp"></td>
                                <td><img src="<?php echo SITE_IMAGES;?>poprighttop1.png" alt="ANP" /></td>
                            </tr>
                            <tr>
                                <td class="leftp"></td>
                                <td width="245" align="left" valign="top" bgcolor="#FFFFFF" style="padding:12px;"> 
                                    <table width="245" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td align="left" valign="top" class="head">
                                                Are you sure you want<br />
                                                to cancel this late deal?
                                            </td>
                                            <td width="15" align="right" valign="top"><a href="javascript:toggleLayer1('late-deal-cancel-pop');"><img src="<?php echo SITE_IMAGES;?>pop-up-cross.gif" alt="Close" title="Close" border="0" /></a></td>
                                        </tr>
                                        <tr>
                                            <td  align="left" valign="top" class="PopTxt">
                                                <table width="98%" border="0" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td class="pad-rgt10 pad-top5">You will not be able to retrieve the information once you have cancelled it.</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="pad-top10">
                                                            <div class="FloatLft"><a href="javascript:toggleLayer1('late-deal-cancel-pop');"><img src="<?php echo SITE_IMAGES;?>nokeepit-gray.gif" alt="Keep it" /></a></div>
                                                            <div class="FloatLft pad-lft5"><a href="javascript:location.href='<?php echo $linkspe;?>'"><img src="<?php echo SITE_IMAGES;?>cancelit-gray.gif" alt="Cancel it" /></a></div>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td  align="left" valign="top" class="PopTxt">&nbsp;</td>
                                        </tr>
                                    </table>                               
                                </td>
                                <td class="rightp" width="15"></td>
                            </tr>
                            <tr>
                                <td align="right"><img src="<?php echo SITE_IMAGES;?>popleftbtm.png" alt="ANP" /></td>
                                <td width="270" class="bottomp"></td>
                                <td align="left"><img src="<?php echo SITE_IMAGES;?>poprightbtm1.png" alt="ANP"/></td>
                            </tr>
                        </table>
                    </div>
            </div>
            </div>
            
                    
        </td>
    </tr>
</table>
</form>
</div>