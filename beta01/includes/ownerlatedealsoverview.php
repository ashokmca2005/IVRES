<script language="javascript" type="text/javascript">
function delDeal(strId) {
	var dealId = strId;
	document.frmPropDeals.txtdelDealId.value = dealId;
}

function frmSubmit() {
	document.frmPropDeals.submit();
}
</script>

<form name="frmPropDeals" action="<?php echo SITE_URL; ?>owner-late-deals.php?sec=ove" method="post">
<input type="hidden" name="securityKey" value="<?php echo md5(OWNERPROPERTYDELDEALS);?>" />
<input type="hidden" name="txtdelDealId" value="" />
<table width="690" border="0" cellspacing="0" cellpadding="0" class="font12">
    <tr>
        <td align="left" colspan="2" valign="top">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                    <td width="66%" valign="top" class="pad-top10 pad-rgt10">
                        <div class="FloatLft"><span class="latedealGray"><span style="font-weight:normal; font-size:26px;"><?php echo tranText('your'); ?></span> <?php echo tranText('late'); ?></span> <span class="latedealPink"><?php echo tranText('deals'); ?></span> </div>
                        <div class="FloatLft pad-lft20"><a href="<?php echo SITE_URL; ?>owner-late-deals" style="text-decoration:none;" class="button-grey">Add a new late deal</a></div>
                    </td>
                    <td width="34%" valign="top" class="pad-lft20 pad-top12">&nbsp;</td>
                </tr>
            </table>                    
        </td>
    </tr>
    <tr><td align="left" colspan="2" valign="top">&nbsp;</td></tr>
	<?php
    $propertyDealsArr = $propertyObj->fun_getOwnerPropertyDealsShowArr($user_id);
    if(is_array($propertyDealsArr) && count($propertyDealsArr) > 0) { 
    ?>
    <tr>
        <td colspan="2" align="left" valign="top">
            <div class="pad-btm20">
                <table border="0" cellspacing="0" cellpadding="0" width="100%" class="latedealLiting">
                    <tr>
                        <th><?php echo tranText('price'); ?></th>
                        <th><?php echo tranText('savings'); ?></th>
                        <th align="left" style="padding-left:15px;"><?php echo tranText('details'); ?></th>
                        <th align="left"><?php echo tranText('date'); ?></th>
                        <th align="left"><?php echo tranText('status'); ?></th>
                        <th align="left" style="border-right:none;"><?php echo tranText('action'); ?></th>
                    </tr>
					<?php
                    for ($i = 0; $i < count($propertyDealsArr); $i++) {
                        $strDealId 				= $propertyDealsArr[$i]['id'];
                        $txtPrpertyRef			= $propertyDealsArr[$i]['property_id'];
                        $strDateFrom 			= $propertyDealsArr[$i]['start_on'];
                        $strDateTo 				= $propertyDealsArr[$i]['end_on'];
                        $txtOrgWeekPrice0 		= $propertyDealsArr[$i]['original_price'];
                        $txtSaleWeekPrice0 		= $propertyDealsArr[$i]['sale_price'];
                        $status 				= $propertyDealsArr[$i]['status'];

                        $strUnixDateFrom 		= strtotime($strDateFrom);
                        $strUnixDateTo	 		= strtotime($strDateTo);
                        $strUnixDateCur 		= time ();
    
                        if ($strUnixDateFrom > $strUnixDateCur)
                        {
                            $startDate = date("Y-m-d H:i:s", $strUnixDateCur);
                            $endDate = date("Y-m-d H:i:s", $strUnixDateFrom);
                             // exploding everything into seperate variabels
                            list($startDateDate, $startDateTime) = explode(" ", $startDate);
                            list($endDateDate, $endDateTime) = explode(" ", $endDate);
                    
                            list($startYear, $startMonth, $startDay) = explode("-", $startDateDate);
                            list($endYear, $endMonth, $endDay) = explode("-", $endDateDate);
                    
                            list($startHour, $startMinute, $startSecond) = explode(":", $startDateTime);
                            list($endHour, $endMinute, $endSecond) = explode(":", $endDateTime);
                    
                             // now we can start calculating
                             // difference in seconds
                            $secondDiff	= $endSecond - $startSecond;
                            if ($startSecond > $endSecond)
                            {
                                 // if the difference is negative, we add 60 seconds and increase the starting minute
                                $secondDiff += 60;
                                $startMinute++;
                            }
                            $minuteDiff	= $endMinute - $startMinute;
                            if ($startMinute > $endMinute)
                            {
                                $minuteDiff += 60;
                                $startHour++;
                            }
                            $hourDiff	= $endHour - $startHour;
                            if ($startHour > $endHour)
                            {
                                $hourDiff += 24;
                                $startDay++;
                            }
                    
                             // days in starting month
                            if ($endMonth > $startMonth || $endYear > $startYear)
                            {
                                if ($startDay > $endDay)
                                {
                                     // amount of days this month has
                                    $daysThisMonth = date("t", $startDate);
                                     // difference in days to the next month
                                    $dayDiff	= ($daysThisMonth - $startDay) + $endDay;
                                     // compensating for the months
                                    $startMonth++;
                                }
                                else
                                    $dayDiff = $endDay - $startDay;
                            }
                            else
                            {
                                $dayDiff = $endDay - $startDay;
                            }
                            $monthDiff	= $endMonth - $startMonth;
                            if ($startMonth > $endMonth)
                            {
                                $monthDiff += 12;
                                $startYear++;
                            }
                            $yearDiff	= $endYear - $startYear;
                             // we know all the differences, so we're outputting that
                            if ($yearDiff > 0)
                                $strTimeLeft = $yearDiff." yrs";
                            elseif ($monthDiff > 0)
                                $strTimeLeft = $monthDiff." months";
                            elseif ($dayDiff > 0)
                                $strTimeLeft = $dayDiff." days";
                            elseif ($hourDiff > 0)
                                $strTimeLeft = $hourDiff." hrs";
                            elseif ($minuteDiff > 0)
                                $strTimeLeft = $minuteDiff." mins";
                            elseif ($secondDiff > 0)
                                $strTimeLeft = $secondDiff." sec";
                            else
                                $strTimeLeft =  "";
                        }
                    
                        $strHrsLeft				= (int)(($strUnixDateFrom - $strUnixDateCur) / (60 * 60));
                        $strNights				= (int)(($strUnixDateTo - $strUnixDateFrom) / (60 * 60 * 24));
                        $txtCurrencySymbol 		= $propertyObj->fun_findPropertyCurrencySymbol($ref_id,'');
						$txtPropertyStatus 		= $propertyObj->fun_getPropertyStatusId($txtPrpertyRef);
                    
                        $strPricePerNight 		= $txtCurrencySymbol.(number_format($txtOrgWeekPrice0));
                        $strPercentSave 		= round(((($txtOrgWeekPrice0 - $txtSaleWeekPrice0) / $txtOrgWeekPrice0)*100), 0);

						if($strUnixDateTo > mktime(0, 0, 0, date("m"), date("d"), date("Y")) && $txtPropertyStatus == "2") {
							switch($status) {
								case '1':
									$strStatus = "Pending";
								break;
								case '2':
									$strStatus = "<span class=\"pink12\">LIVE</span>";
								break;
								case '3':
									$strStatus = "Expired";
								break;
								case '4':
									$strStatus = "Suspended";
								break;
							}
						} else {
							$strStatus = "Expired";
						}
                    
                        $propertyInfoArr		= $propertyObj->fun_getPropertyInfo($txtPrpertyRef);
                        if(count($propertyInfoArr) > 0){
                            $strPropertyName 		= ucwords($propertyInfoArr['property_name']);
                            $strPropertyTotalBeds	= $propertyInfoArr['total_beds'];
                            $strPropertyTotalBaths	= $propertyInfoArr['total_bathrooms'];
                        }
                    
                        $strThumbArr = $propertyObj->fun_getPropertyMainThumb($txtPrpertyRef);
                        if(is_array($strThumbArr)) {
                            $strThumbUrl = PROPERTY_IMAGES_THUMB88x66_PATH.$strThumbArr[0]['photo_thumb'];
                            $strThumbCap = $strThumbArr[0]['photo_caption'];
                        } else {
                            $strThumbUrl = PROPERTY_IMAGES_THUMB88x66_PATH."no-image-small.gif";
                            $strThumbCap = "No Image";
                        }
                        $strPropLocArr = $propertyObj->fun_getPropertyLocInfoArr($txtPrpertyRef);
                    ?>
                    <tr class="lineHight14" <?php if(($i%2) != 0) { echo "style=\"background:#FFFFFF;\""; } ?>>
                        <td width="75" align="center"><span class="pink16arial"><?php echo $strPricePerNight; ?></span></td>
                        <td width="40" align="center"><span class="pink16arial"><?php echo $strPercentSave."%"; ?></span></td>
                        <td width="330">
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="100"><div><img src="<?php echo $strThumbUrl;?>" width="88" height="66" alt="<?php echo $strThumbCap;?>" title="<?php echo $strThumbCap;?>" align="middle" /></div></td>
                                    <td width="135" class="dash-right">
                                        <strong class="black"><?php echo $strPropertyName;?></strong><br />
                                        <?php echo ucwords($strPropLocArr['region_pname']);?><br />
                                        <?php echo ucwords($strPropLocArr['region_name']);?><br />
                                        <?php echo ucwords($strPropLocArr['location_name']);?>
                                    </td>
                                    <td width="95">
                                        <?php 
                                        if((int)$strPropertyTotalBeds > 1) {
                                            echo $strPropertyTotalBeds." beds<br />";
                                        } else if((int)$strPropertyTotalBeds == 1) {
                                            echo $strPropertyTotalBeds." bed<br />";
                                        }

                                        if((int)$strPropertyTotalBaths > 1) {
                                            echo $strPropertyTotalBaths." bathrooms<br />";
                                        } else if((int)$strPropertyTotalBaths == 1) {
                                            echo $strPropertyTotalBaths." bathroom<br />";
                                        }
                                        ?>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <td width="135" class="font11">
                            <strong class="black"><?php echo $strTimeLeft; ?></strong> <br />
                            <br />
                            <?php echo date('D M j, Y', $strUnixDateFrom); ?><br />
                            to<br />
                            <?php echo date('D M j, Y', $strUnixDateTo); ?>
                        </td>
                        <td width="135"><?php echo $strStatus; ?></td>
                        <td width="70" class="right" align="left">
                            <a href="<?php echo SITE_URL; ?>owner-late-deals.php?sec=edit&dealid=<?php echo $strDealId; ?>">Edit</a><br />
                            <a href="javascript:delDeal(<?php echo $strDealId; ?>);toggleLayer('late-deal-delete-pop');">Delete</a>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                </table>
            </div>
        </td>
    </tr>
    <?php
    } else {
    ?>
	<tr><td colspan="2" valign="top"><span class="font16-darkgrey">You currently have no late deals ;-(</span></td></tr>
	<tr><td colspan="2" valign="top" class="pad-top10"><a href="<?php echo SITE_URL; ?>owner-home" style="text-decoration:none;" class="button-blue">My homepage</a></td></tr>
    <?php
    }
    ?>
    <tr>
        <td colspan="2" align="left" valign="top" height="5">
        <div id="late-deal-delete-pop" style="display:none; position:absolute; background:transparent; left:300px; top:500px;">
            <div style="position:relative; z-index:999;left:0px;width:275px;height:158px;">
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
                                    <td align="left" valign="top" class="head">Are you sure you want<br />to delete this late deal?</td>
                                    <td width="15" align="right" valign="top"><a href="javascript:closeWindow();void(0);" ><img src="<?php echo SITE_IMAGES;?>pop-up-cross.gif" alt="Close" title="Close" border="0" /></a></td>
                                </tr>
                                <tr>
                                    <td  align="left" valign="top" class="PopTxt">
                                        <table width="98%" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td class="pad-rgt10 pad-top5">You will not be able to retrieve the information once you have deleted it.</td>
                                            </tr>
                                            <tr>
                                                <td class="pad-top10">
                                                    <div class="FloatLft"><a href="javascript:closeWindow();void(0);" ><img src="<?php echo SITE_IMAGES;?>cancel-admin.png" alt="Keep it" /></a></div>
                                                    <div class="FloatLft pad-lft5"><a href="javascript:frmSubmit();"><img src="<?php echo SITE_IMAGES;?>delete.gif" alt="Delete it" /></a></div>
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
        </td>
    </tr>
</table>
</form>
                          