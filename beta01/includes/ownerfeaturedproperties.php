<?php 
	$page	 = form_int("page",1)+0;
	$sortby  = form_int("sortby",0,0,5);
	$sortdir = form_int("sortdir",0,0,1);
	if (form_isset("reverse")) {
		$sortdir = 1-$sortdir;
	}
	
	switch($sortdir) {
		case 0 :
			$orderDir = "ASC";
		break;
		case 1 :
			$orderDir = "DESC";
		break;
	}

	switch($sortby) {
		case 0:
			$sortField  = "A.property_id";
		break;
		case 1:
			$sortField  = "A.property_id";
		break;
		default:
			$sortField = "A.property_id";
		break;
	}

	$search_query = "";
	$strQueryParameter		= " ORDER BY " . $sortField . " " . $orderDir. " LIMIT ".(int)(($page-1)*(int)GLOBAL_RECORDS_PER_PAGE).", ".GLOBAL_RECORDS_PER_PAGE;
	$strQueryCountParameter	= " ORDER BY " . $sortField . " " . $orderDir;

	$rsQuery				= $propertyObj->fun_getOwnerHotPropertyArr($user_id, $strQueryParameter);
	$rsQueryCount			= $propertyObj->fun_getOwnerHotPropertyArr($user_id, $strQueryCountParameter);
//	if(isset($txtcountryids) && $txtcountryids != "") { $search_query .= "&txtcountryids=" . html_escapeURL($txtcountryids); }

	$hotpropertiesListArr 		= $dbObj->fetchAssoc($rsQuery);

	// Determine the pagination
	$return_query 		= $search_query."&".$sort_query."&page=$page";
	$pag 				= new Pagination($rsQueryCount, $search_query."&".$sort_query, GLOBAL_RECORDS_PER_PAGE);
	$pag->current_page 	= $page;
	$pagination  		= $pag->Process();
	//print_r($hotpropertiesListArr);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
<?php
if(is_array($hotpropertiesListArr) && count($hotpropertiesListArr) > 0) {
?>	<tr>
        <td align="left" valign="top">
			<script language="javascript" type="text/javascript">
				function delPropHot(strId) {
					var txtdelPropHotId = strId;
					document.frmPropFeatures.txtdelPropHotId.value = txtdelPropHotId;
				}
				function frmSubmit() {
					document.frmPropFeatures.submit();
				}
            </script>
            <form name="frmPropFeatures" action="<?php echo SITE_URL; ?>owner-featured-properties" method="post">
            <input type="hidden" name="securityKey" value="<?php echo md5(OWNERPROPERTYDELHOT);?>" />
            <input type="hidden" name="txtdelPropHotId" value="" />
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                    <td align="right" valign="top" class="pad-top10">
                        <a href="<?php echo SITE_URL; ?>owner-hot-property" style="text-decoration:none;"><img src="<?php echo SITE_IMAGES;?>addfeaturedproperty-gray.gif" /></a>
                    </td>
                </tr>
                <tr><td valign="top">&nbsp;</td></tr>
				<?php /*?>                
                <tr>
                    <td valign="top" class="pad-rgt10">
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td width="41%" align="left" valign="top" class="pad-btm10 pad-left2"><strong><?php if(isset($pagination['total_rows']) && $pagination['total_rows'] > 1) { echo "Showing ".$pagination['first_row']." to ".$pagination['last_row']." of ".$pagination['total_rows']."";} else if(isset($pagination['total_rows']) && $pagination['total_rows'] == 1){echo "Showing ".$pagination['first_row']." to ".$pagination['last_row']." of ".$pagination['total_rows']."";} ?></strong></td>
                                <td width="59%" align="right" valign="top" class="paging pad-btm10 pad-left2">
                                <?php
                                if(isset($pagination['pages']) && $pagination['pages'] != "") {
                                    if(isset($pagination['prev']) && $pagination['prev'] !="") {
                                        echo "<a href=\"".$pagination['prev']."\" class=\"previous\">Previous</a>";
                                    }
                                    if(($pagination['pages'][0]['no']) > 1) {
                                        echo "<span>...</span>";
                                    }
                                    foreach($pagination['pages'] as $key => $value) {
                                        if(isset($value['link']) && $value['link'] != "") {
                                            echo "<a href=\"".$value['link']."\">".($value['no'])."</a>";
                                        } else {
                                            echo "<span>".($value['no'])."</span>";
                                        }
                                    }
                                    if(($pagination['pages'][count($pagination['pages'])-1]['no']) < ($pagination['total_rows']/GLOBAL_RECORDS_PER_PAGE)) {
                                        echo "<span>...</span>";
                                    }
                                    if(isset($pagination['next']) && $pagination['next'] !="") {
                                        echo "<a href=\"".$pagination['next']."\" class=\"next\">Next</a>";
                                    }
                                } else {
                                    echo "&nbsp;";
                                }
                                ?>
                                </td>
                            </tr>                
                        </table>
                    </td>
                </tr>
                <?php */?>                
                <tr>
                    <td valign="top" class="pad-rgt10">
                        <div class="pad-btm20">
                            <table border="0" cellspacing="0" cellpadding="0" width="100%" class="latedealLiting">
                                <tr>
                                    <th><?php echo tranText('property'); ?>ID</th>
                                    <th align="left" style="padding-left:15px;"><?php echo tranText('details'); ?></th>
                                    <th align="left"><?php echo tranText('date'); ?></th>
                                    <th><?php echo tranText('weeks'); ?></th>
                                    <th align="left"><?php echo tranText('status'); ?></th>
                                    <th align="left" style="border-right:none;"><?php echo tranText('action'); ?></th>
                                </tr>
                            <?php
                            for($i =0; $i < count($hotpropertiesListArr); $i++) {
                                $property_hot_id 	= $hotpropertiesListArr[$i]['property_hot_id'];
                                $property_id 		= $hotpropertiesListArr[$i]['property_id'];
                                $start_date 		= $hotpropertiesListArr[$i]['start_date'];
                                $total_weeks		= $hotpropertiesListArr[$i]['total_weeks'];
                                $property_name 		= $propertyObj->fun_getPropertyName($property_id);
								$property_status 	= $propertyObj->fun_getPropertyStatusId($property_id);
                                $status 			= $hotpropertiesListArr[$i]['status'];
                                list($y, $m, $d) = split("-", $start_date);
								if(mktime(0, 0, 0, $m, ($d+($total_weeks*7)), $y) > mktime(0, 0, 0, date("m"), date("d"), date("Y")) && $property_status=="2") {
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
                                    }
                                } else {
                                    $strStatus = "Expired";
                                }
            
            
                                $propertyInfoArr		= $propertyObj->fun_getPropertyInfo($property_id);
                                if(count($propertyInfoArr) > 0){
                                    $strPropertyName 		= ucwords($propertyInfoArr['property_name']);
                                    $strPropertyTotalBeds	= $propertyInfoArr['total_beds'];
                                    $strPropertyTotalBaths	= $propertyInfoArr['total_bathrooms'];
                                }
                            
                                $strThumbArr = $propertyObj->fun_getPropertyMainThumb($property_id);
                                if(is_array($strThumbArr)) {
                                    //$strThumbUrl = PROPERTY_IMAGES_THUMB88x66_PATH.$strThumbArr[0]['photo_thumb'];
                                    $strThumbCap = $strThumbArr[0]['photo_caption'];
									$pos = strpos($strThumbArr[0]['photo_thumb'], "rentalo.com");
									if($pos === false) {
										$strThumbUrl = PROPERTY_IMAGES_THUMB88x66_PATH.$strThumbArr[0]['photo_thumb'];
									} else {
										$strThumbUrl = $strThumbArr[0]['photo_thumb'];
									}
                                } else {
                                    $strThumbUrl = PROPERTY_IMAGES_THUMB88x66_PATH."no-image-small.gif";
                                    $strThumbCap = "No Image";
                                }
                                $strPropLocArr = $propertyObj->fun_getPropertyLocInfoArr($property_id);
                                ?>
                                <tr class="lineHight14" <?php if(($i%2) != 0) { echo "style=\"background:#FFFFFF;\""; } ?>>
                                    <td width="40" align="center"><span class="font14"><?php echo fill_zero_left($property_id, "0", (6-strlen($property_id))); ?></span></td>
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
                                                    ?>
                                                    <?php 
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
                                        <br />
                                        <?php echo date('M j, Y', mktime(0, 0, 0, $m , $d, $y)); ?><br />
                                        to<br />
                                        <?php echo date('M j, Y', mktime(0, 0, 0,$m , ($d+(7*$total_weeks)), $y)); ?>
                                    </td>
                                    <td width="75" align="center"><span class="font14"><?php echo $total_weeks; ?></span></td>
                                    <td width="135"><?php echo $strStatus; ?></td>
                                    <td width="70" class="right" align="left" valign="middle">
                                        <a href="<?php echo SITE_URL; ?>owner-hot-property.php?sec=edit&prophotid=<?php echo $property_hot_id; ?>"><?php echo tranText('edit'); ?></a><br />
                                        <a href="javascript:delPropHot(<?php echo $property_hot_id; ?>);toggleLayer('prop-hot-delete-pop');"><?php echo tranText('delete'); ?></a>
                                    </td>
                                </tr>
                                <?php
                                }
                            ?>
                            </table>
                        </div>
                    </td>
                </tr>
				<?php /*?>
				<tr>
                    <td valign="top" class="pad-rgt10 pad-top10">
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td width="41%" align="left" valign="top" class="pad-btm10 pad-left2"><strong><?php if(isset($pagination['total_rows']) && $pagination['total_rows'] > 1) { echo "Showing ".$pagination['first_row']." to ".$pagination['last_row']." of ".$pagination['total_rows']."";} else if(isset($pagination['total_rows']) && $pagination['total_rows'] == 1){echo "Showing ".$pagination['first_row']." to ".$pagination['last_row']." of ".$pagination['total_rows']."";} ?></strong></td>
                                <td width="59%" align="right" valign="top" class="paging pad-btm10 pad-left2">
                                <?php
                                if(isset($pagination['pages']) && $pagination['pages'] != "") {
                                    if(isset($pagination['prev']) && $pagination['prev'] !="") {
                                        echo "<a href=\"".$pagination['prev']."\" class=\"previous\">Previous</a>";
                                    }
									if(($pagination['pages'][0]['no']) > 1) {
										echo "<span>...</span>";
									}
                                    foreach($pagination['pages'] as $key => $value) {
                                        if(isset($value['link']) && $value['link'] != "") {
                                            echo "<a href=\"".$value['link']."\">".($value['no'])."</a>";
                                        } else {
                                            echo "<span>".($value['no'])."</span>";
                                        }
                                    }
									if(($pagination['pages'][count($pagination['pages'])-1]['no']) < ($pagination['total_rows']/GLOBAL_RECORDS_PER_PAGE)) {
										echo "<span>...</span>";
									}
                                    if(isset($pagination['next']) && $pagination['next'] !="") {
                                        echo "<a href=\"".$pagination['next']."\" class=\"next\">Next</a>";
                                    }
                                } else {
                                    echo "&nbsp;";
                                }
                                ?>
                                </td>
                            </tr>                
                        </table>
                    </td>
                </tr>
				<?php */?>
                <tr>
                    <td align="left" valign="top" height="5">
                    <div id="prop-hot-delete-pop" style="display:none; position:absolute; background:transparent; left:300px; top:500px;">
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
                                                <td align="left" valign="top" class="head">Are you sure you want<br />to delete this featured property?</td>
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
        </td>
    </tr>
<?php
} else {
?>
    <tr>
        <td align="right" valign="top" class="pad-top15">
            <a href="<?php echo SITE_URL; ?>owner-hot-property" style="text-decoration:none;" class="button-blue">Add featured property</a>
        </td>
    </tr>
<?php
}
?>
</table>