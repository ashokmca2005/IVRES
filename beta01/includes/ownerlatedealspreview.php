<script language="javascript" type="text/javascript">
function frmEdit() {
	document.frmPropDeals.txtTermsCondition.value = "0";
	document.frmPropDeals.action = "owner-late-deals.php";
	document.frmPropDeals.submit();
}

function frmSubmit() {
	document.frmPropDeals.txtTermsCondition.value = "1";
	document.frmPropDeals.action = "owner-late-deals.php?sec=ove";
	document.frmPropDeals.submit();
}
</script>
<form name="frmPropDeals" action="owner-late-deals.php?sec=ove" method="post">
<input type="hidden" name="securityKey" value="<?php echo md5(OWNERPROPERTYDEALS);?>" />
<input type="hidden" name="txtDayFrom0" value="<?php echo $txtDayFrom0;?>" />
<input type="hidden" name="txtMonthFrom0" value="<?php echo $txtMonthFrom0;?>" />
<input type="hidden" name="txtYearFrom0" value="<?php echo $txtYearFrom0;?>" />
<input type="hidden" name="txtDayTo0" value="<?php echo $txtDayTo0;?>" />
<input type="hidden" name="txtMonthTo0" value="<?php echo $txtMonthTo0;?>" />
<input type="hidden" name="txtYearTo0" value="<?php echo $txtYearTo0;?>" />
<input type="hidden" name="txtCurrencyType" value="<?php echo $txtCurrencyType;?>" />
<input type="hidden" name="txtOrgWeekPrice0" value="<?php echo $txtOrgWeekPrice0;?>" />
<input type="hidden" name="txtSaleWeekPrice0" value="<?php echo $txtSaleWeekPrice0;?>" />
<input type="hidden" name="txtRemoveDealFrom0" value="<?php echo $txtRemoveDealFrom0;?>" />
<input type="hidden" name="txtMinStay" value="<?php echo $txtMinStay;?>" />
<input type="hidden" name="txtMinStayType" value="<?php echo $txtMinStayType;?>" />
<input type="hidden" name="txtPrpertyRef" value="<?php echo $txtPrpertyRef;?>" />
<input type="hidden" name="txtTermsCondition" value="0" />
<?php
if(isset($_POST['txtPropertyDealId']) && $_POST['txtPropertyDealId'] !="") {
?>
<input type="hidden" name="txtPropertyDealId" value="<?php echo $_POST['txtPropertyDealId'];?>" />
<?php
}
?>
<table width="690" border="0" cellspacing="0" cellpadding="0" class="font12">
    <tr>
        <td align="left" colspan="2" valign="top">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                    <td width="66%" valign="top" class="pad-top10 pad-rgt10">
                        <div class="FloatLft"><span class="latedealGray"><span style="font-weight:normal; font-size:26px;">Preview your</span> Late</span> <span class="latedealPink">deals</span> </div>
                    </td>
                    <td width="34%" valign="top" class="pad-lft20 pad-top12">&nbsp;</td>
                </tr>
                <tr>
                	<td align="left" colspan="2" valign="top">
                        Please check these details carefully. Remember you can always change them later but it's best to get it right first time, it might just save you getting incorrect enquiries !!
                    </td>
                </tr>
            </table>                    
        </td>
    </tr>
    <tr><td align="left" colspan="2" valign="top">&nbsp;</td></tr>
    <tr>
        <td colspan="2" align="left" valign="top" class="pad-top10 pad-btm5">
		<?php
            $propThumbInfoArr = $propertyObj->fun_getPropertyMainThumb($txtPrpertyRef);
            if(count($propThumbInfoArr) > 0){
                if($propThumbInfoArr[0]['photo_thumb'] != "") {
                    //$photo_thumb 	= PROPERTY_IMAGES_THUMB168x126_PATH.$propThumbInfoArr[0]['photo_thumb'];

					$pos = strpos($propThumbInfoArr[0]['photo_thumb'], "rentalo.com");
					if($pos === false) {
						$photo_thumb = PROPERTY_IMAGES_THUMB168x126_PATH.$propThumbInfoArr[0]['photo_thumb'];
					} else {
						$photo_thumb = $propThumbInfoArr[0]['photo_thumb'];
					}
                } else {
                    $photo_thumb 	= PROPERTY_IMAGES_THUMB168x126_PATH."no-image-small.gif";
                }
                $photo_caption 		= $propThumbInfoArr[0]['photo_caption'];
            } else {
                $photo_thumb 		= PROPERTY_IMAGES_THUMB168x126_PATH."no-image-small.gif";
                $photo_caption 		= "No Image";
            }
        
            $propBedInfoArr 		= $propertyObj->fun_getPropertyBedAllInfoArr($txtPrpertyRef);
            if(is_array($propBedInfoArr) && (count($propBedInfoArr) > 0)){
                if($propBedInfoArr[0]['total_beds'] > 0) {
					$total_beds 	= $propBedInfoArr[0]['total_beds'].(($propBedInfoArr[0]['total_beds'] > 1)?" beds":" bed");
                }
                if($propBedInfoArr[0]['scomfort_beds'] > 0) {
					$scomfort_beds 	= (($propBedInfoArr[0]['scomfort_beds'] > 1)?" sleeps ":" sleeps ").$propBedInfoArr[0]['scomfort_beds'];
                }
            } else {
                $total_beds 	= "";
                $scomfort_beds 	= "";
            }
            
            $propBathInfoArr 	= $propertyObj->fun_getPropertyBathAllInfoArr($txtPrpertyRef);
            if(is_array($propBathInfoArr) && (count($propBathInfoArr) > 0) && ($propBathInfoArr[0]['total_bathrooms'] > 0)){
				$total_bathrooms= $propBathInfoArr[0]['total_bathrooms'].(($propBathInfoArr[0]['total_bathrooms'] > 1)?" Bathrooms":" Bathroom");
            } else {
                $total_bathrooms= "";
            }
        
            $propPoolInfo	 	= $propertyObj->fun_verifyPropertyByPropertyFacility($txtPrpertyRef, "15");
            if($propPoolInfo) {
                $show_swimming= "<span>Swimming pool</span>";
            } else {
                $show_swimming 	= "";
            }
			$propPriceInfoArr	= $propertyObj->fun_getPropertyPriceFromInfoArr($txtPrpertyRef);
			if(is_array($propPriceInfoArr) && (count($propPriceInfoArr) > 0)){
				$users_currency_symbol	= $propertyObj->fun_findPropertyCurrencySymbol($txtPrpertyRef);

/*
				if($propPriceInfoArr['min_per_night_price'] > 0 && $propPriceInfoArr['max_per_night_price'] > 0 && $propPriceInfoArr['min_per_night_price'] != $propPriceInfoArr['max_per_night_price']) {
					$min_per_night_price 		= number_format($propPriceInfoArr['min_per_night_price']);
					$max_per_night_price 		= number_format($propPriceInfoArr['max_per_night_price']);
					$show_price 				= "<span id=\"price_currency_symbol_id1".$i."\">".$users_currency_symbol."</span><span id=\"price_currency_price_id1".$i."\" >".$min_per_night_price."</span> - <span id=\"price_currency_symbol_id2".$i."\" >".$users_currency_symbol."</span><span id=\"price_currency_price_id2".$i."\">".$max_per_night_price." p/d</span><br />";
				} else if($propPriceInfoArr['min_per_week_price'] > 0 && $propPriceInfoArr['max_per_week_price'] > 0 && $propPriceInfoArr['min_per_week_price'] != $propPriceInfoArr['max_per_week_price']) {
					$min_per_week_price 		= number_format($propPriceInfoArr['min_per_week_price']);
					$max_per_week_price 		= number_format($propPriceInfoArr['max_per_week_price']);
					$show_price 				= "<span id=\"price_currency_symbol_id1".$i."\">".$users_currency_symbol."</span><span id=\"price_currency_price_id1".$i."\" >".$min_per_week_price."</span> - <span id=\"price_currency_symbol_id2".$i."\" >".$users_currency_symbol."</span><span id=\"price_currency_price_id2".$i."\">".$max_per_week_price." p/w</span><br />";
				} else if($propPriceInfoArr['min_per_night_price'] > 0) {
					$min_per_night_price 		= number_format($propPriceInfoArr['min_per_night_price']);
					$show_price 				= "From <span id=\"price_currency_symbol_id1".$i."\">".$users_currency_symbol."</span><span id=\"price_currency_price_id1".$i."\" >".$min_per_night_price." per night</span><br />";
				} else if($propPriceInfoArr['min_per_week_price'] > 0) {
					$min_per_week_price 		= number_format($propPriceInfoArr['min_per_week_price']);
					$show_price 				= "From <span id=\"price_currency_symbol_id1".$i."\">".$users_currency_symbol."</span><span id=\"price_currency_price_id1".$i."\" >".$min_per_week_price." per week</span><br />";
				} else {
					$show_price 				= "<br />";
				}
*/
				if($propPriceInfoArr['min_per_week_price'] > 0) {
					$min_per_week_price 		= number_format($propPriceInfoArr['min_per_week_price']);
					$show_price 				= "From <span id=\"price_currency_symbol_id1".$i."\">".$users_currency_symbol."</span><span id=\"price_currency_price_id1".$i."\" >".$min_per_week_price." per week</span><br />";
				} else {
					$show_price 				= "<br />";
				}


			} else {
				$show_price 		= "<br />";
			}
        ?>
        <div class="box-t_premium">
            <div class="box-r_premium">
                <div class="box-b_premium">
                    <div class="box-l_premium">
                        <div class="box-tr_premium">
                            <div class="box-br_premium">
                                <div class="box-bl_premium">
                                    <div class="box-tl_premium">
                                        <p class="white"><strong>SPECIAL OFFER!</strong> HOLIDAY PRICE REDUCED BY <?php echo $strPercentSave."%"; ?> (<?php echo date('M d', $strUnixDateFrom); ?> - <?php echo date('M d', $strUnixDateTo); ?>)</p>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listingTable">
                                            <tr><td colspan="2" align="left" valign="top" class=" pad-btm5"></td></tr>
                                            <tr>
                                                <td colspan="2" align="left" valign="top" class="pad-top10 pad-btm10">
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="listingTable">
                                                        <tr>
                                                            <td width="35%" valign="top"><img src="<?php echo $photo_thumb;?>" alt="<?php echo $photo_caption;?>" width="244" height="183" /></td>
                                                            <td width="42%" valign="top" class="pad-lft15 pad-rgt10">
                                                                <div class="pink16arial pad-top7 pad-btm7"><?php echo $strPropertyName;?></div>
                                                                <p class="font14"><strong><?php echo $strPropertyTitle;?></strong></p>
                                                                <p><?php echo $strPropertyDesc." ... <a href=\"javascript:void(0);\">read more</a>"; ?></p>
                                                                <p style="padding-top:5px;">
                                                                    <?php $propertyObj->fun_createPropertyCustomerReview($txtPrpertyRef); ?>
                                                                </p>
                                                            </td>
                                                            <td width="23%" valign="top" class="pad-lft15 pad-top5">
                                                                <table width="100%" border="0" cellspacing="0" cellpadding="1">
                                                                    <tr><td height="10"></td></tr>
                                                                    <tr>
                                                                        <td style="line-height:20px; font-weight:bold;" height="122" valign="top">
                                                                        <?php echo $show_price; ?>
                                                                        <?php echo $total_beds."<br />"; ?>
                                                                        <?php echo $scomfort_beds."<br />"; ?>
                                                                        <?php echo $total_bathrooms."<br />"; ?>
                                                                        <?php echo $show_swimming; ?>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </td>
    </tr>
    <tr><td colspan="2" class="dash25">&nbsp;</td></tr>
    <tr>
        <td align="right" valign="middle" class="pad-top5">&nbsp;</td>
        <td valign="middle" class="pad-top5" style="padding-left:260px;">
            <div class="FloatLft"><a href="javascript:toggleLayer1('late-deal-cancel-pop');"><img src="<?php echo SITE_IMAGES;?>cancel-gray.gif" alt="Cancel"/></a></div>
            <div class="FloatLft pad-lft5">
                <input type="image" src="<?php echo SITE_IMAGES;?>editnew-gray.gif" alt="Edit" onclick="return frmEdit();" >
            </div>
            <div class="FloatLft pad-lft5">
                <input type="image" src="<?php echo SITE_IMAGES;?>confirm.gif" alt="Submit" onclick="frmSubmit();" >
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="2" align="left" valign="top">
            <div id="late-deal-cancel-pop" class="box cursor1" style="display:none; position:absolute; left:355px; top:500px;">
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
                                                            <div class="FloatLft"><a href="javascript:toggleLayer1('late-deal-cancel-pop');"><img src="<?php echo SITE_IMAGES;?>nokeepit-gray.gif" alt="Keep it" style="width:100px;" /></a></div>
                                                            <div class="FloatLft pad-lft5">
                                                            <a href="<?php echo SITE_URL; ?>owner-late-deals.php?sec=ove"><img src="<?php echo SITE_IMAGES;?>cancelit-gray.gif" alt="Cancel it" style="width:100px;" /></a>
                                                            </div>
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
  
