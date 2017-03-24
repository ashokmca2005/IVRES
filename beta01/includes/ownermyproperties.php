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
	$where_clause = "";

	if($_POST['txtFilter']==1){		
		$txtKeyword 	= $_POST['txtKeyword'];
		$txtProperty 	= $_POST['txtProperty'];

		if(isset($txtProperty) && $txtProperty !="") {
			$where_clause .= " AND A.property_id='".$txtProperty."' ";
		} else if(isset($txtKeyword) && $txtKeyword !="") {
			$bolExecute = false;
			if ($txtKeyword!=FALSE && $txtKeyword!=''){
				$arrKeyword = explode(" " ,$txtKeyword);
				for ($intCounter=0;$intCounter<=count($arrKeyword)-1;$intCounter++){
					if (strlen(trim($arrKeyword[$intCounter])) > 0 )
					$txtKeywordQuery = $txtKeywordQuery . " B.property_name LIKE '%" . $arrKeyword[$intCounter] . "%' OR ";
				}
				$where_clause = $where_clause . " AND (" . substr($txtKeywordQuery,0,strlen($txtKeywordQuery)-4) . ")";
				$bolExecute = true;
			}
		}
	}

	$strQueryParameter		= $where_clause." ORDER BY " . $sortField . " " . $orderDir. " LIMIT ".(int)(($page-1)*(int)GLOBAL_RECORDS_PER_PAGE).", ".GLOBAL_RECORDS_PER_PAGE;
	$strQueryCountParameter	= $where_clause." ORDER BY " . $sortField . " " . $orderDir;

	$rsQuery				= $propertyObj->fun_getOwnerPropertiesArr($user_id, $strQueryParameter);
	$rsQueryCount			= $propertyObj->fun_getOwnerPropertiesArr($user_id, $strQueryCountParameter);
	if(isset($txtcountryids) && $txtcountryids != "") { $search_query .= "&txtcountryids=" . html_escapeURL($txtcountryids); }
	$propertiesListArr 		= $dbObj->fetchAssoc($rsQuery);
	// Determine the pagination
	$return_query 		= $search_query."&".$sort_query."&page=$page";
	$pag 				= new Pagination($rsQueryCount, $search_query."&".$sort_query, GLOBAL_RECORDS_PER_PAGE);
	$pag->current_page 	= $page;
	$pagination  		= $pag->Process();
//	print_r($propertiesListArr);
?>
<?php
if(is_array($propertiesListArr) && count($propertiesListArr) > 0) {
?>
	<script language="javascript" type="text/javascript">
        function getFilter(){
            if((document.getElementById("txtKeyPropertyId").value != "") || (document.getElementById("txtKeywordId").value != "")) {
                document.getElementById("frmFilter").action = "owner-my-properties.php";
                document.getElementById("frmFilter").submit();
            } else {
                alert("Enter property id or keywords!");
                document.getElementById("txtKeywordId").focus();
                return false;
            }
        }
    </script>
    <table width="690px" border="0" cellspacing="0" cellpadding="0" class="font12">
        <tr>
            <td valign="top" colspan="2" class="pad-top20">
            <form name="frmFilter" id="frmFilter" method="post">
            <input type="hidden" name="txtFilter" id="txtFilter" value="1" />
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="left" valign="top" class="pad-btm5">
                            <table border="0" cellspacing="0" cellpadding="0" style="display:block">
                                <tr>
                                    <td valign="middle" width="100px" style="color:#009bd4;	"><strong><?php echo tranText('filter_properties'); ?></strong></td>
                                    <td class="pad-rgt5" style="font-weight:normal;"><?php echo tranText('keywords'); ?></td>
                                    <td class="pad-rgt5"><input type="text" name="txtKeyword" id="txtKeywordId" class="Textfield80 blackText" value="<?php if(isset($_POST['txtKeyword']) && $_POST['txtKeyword'] != "") { echo $_POST['txtKeyword'];} else {echo "";}?>" /></td>
                                    <td class="pad-left5 pad-rgt10">or</td>
                                    <td class="pad-rgt5"><?php echo tranText('property_id'); ?></td>
                                    <td class="pad-rgt5"><input type="text" name="txtProperty" id="txtKeyPropertyId" class="Textfield80 blackText" value="<?php if(isset($_POST['txtProperty']) && $_POST['txtProperty'] != "") { echo $_POST['txtProperty'];} else {echo "";}?>" /></td>
                                    <td class="pad-rgt5"><a href="javascript:void(0);" onclick="return getFilter();" class="button-blue">Go</a></td>
                                    <td><a href="<?php echo SITE_URL;?>owner-my-properties" style="text-decoration:none;"> <?php echo tranText('clear'); ?></a></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr><td height="10" colspan="2" valign="top" class="dash-top"></td></tr>
                </table>
            </form>
            </td>
        </tr>
        <tr>
            <td align="left" class="gray14"><?php if(isset($pagination['total_rows']) && $pagination['total_rows'] > 1) { echo "Showing ".$pagination['first_row']." to ".$pagination['last_row']." of ".$pagination['total_rows']." properties";} else if(isset($pagination['total_rows']) && $pagination['total_rows'] == 1){echo "Showing ".$pagination['first_row']." to ".$pagination['last_row']." of ".$pagination['total_rows']." property";} ?></td>
            <td align="center" class="pad-top5 pad-btm5">
            <ul>
                <li class="paging pad-lft5" style="float:right; clear:right;">
					<?php
                        if(isset($pagination['pages']) && $pagination['pages'] != "") {
                            if(isset($pagination['prev']) && $pagination['prev'] !="") {
                                echo "<a href=\"".$pagination['prev']."\"class=\"previous\"><strong>Previous</strong></a>";
                            }
                            if(($pagination['pages'][0]['no']) > 1) {
                                echo "<span>...</span>";
                            }
                            foreach($pagination['pages'] as $key => $value) {
                                if(isset($value['link']) && $value['link'] != "") {
                                    echo "<a href=\"".$value['link']."\" style=\"border:1px solid #b2b2b2;\">".($value['no'])."</a>";
                                } else {
                                    echo "<span>".($value['no'])."</span>";
                                }
                            }
                            if(($pagination['pages'][count($pagination['pages'])-1]['no']) < ($pagination['total_rows']/GLOBAL_RECORDS_PER_PAGE)) {
                                echo "<span>...</span>";
                            }
                            if(isset($pagination['next']) && $pagination['next'] !="") {
                                echo"<align=\"center\">&gt;&gt;";
                                echo "<a href=\"".$pagination['next']."\"class=\"next\"><strong>Next</strong></a>";
                            }
                        } else {
                            echo "&nbsp;";
                        }
					?>
                </li>
            </ul>
            </td>
        </tr>
    </table>
    <table width="690px" border="0" cellspacing="0" cellpadding="0" class="font12 pad-top10">
	<?php
    for($j = 0; $j < count($propertiesListArr); $j++) {
        $property_id 			= $propertiesListArr[$j]['property_id'];
        $property_name 			= $propertiesListArr[$j]['property_name'];
        $property_title			= $propertiesListArr[$j]['property_title'];
        $propThumbInfoArr 		= $propertyObj->fun_getPropertyMainThumb($property_id);
        if(count($propThumbInfoArr) > 0){
            if($propThumbInfoArr[0]['photo_thumb'] != "") {
                //$photo_thumb 	= PROPERTY_IMAGES_LARGE244x183_PATH.$propThumbInfoArr[0]['photo_url'];
				$pos = strpos($propThumbInfoArr[0]['photo_url'], "rentalo.com");
				if($pos === false) {
					$photo_thumb = PROPERTY_IMAGES_LARGE244x183_PATH.$propThumbInfoArr[0]['photo_url'];
				} else {
					$photo_thumb = $propThumbInfoArr[0]['photo_url'];
				}
            } else {
                $photo_thumb 	= PROPERTY_IMAGES_LARGE244x183_PATH."image-thumbnail.gif";
            }
            $photo_caption 		= $propThumbInfoArr[0]['photo_caption'];
        } else {
            $photo_thumb 		= PROPERTY_IMAGES_LARGE244x183_PATH."image-thumbnail.gif";
            $photo_caption 		= "No Image";
        }
        ?>
            <tr>
                <td class="pad-rgt5"><img src="<?php echo $photo_thumb;?>" alt="<?php echo $photo_caption;?>" width="244" height="183" /></td>
                <td valign="top">
                    <h6><?php echo ucfirst($property_name)." - ".fill_zero_left($property_id, "0", (6-strlen($property_id)));?></h6>
                    <table width="190px" class="nav7 pad-top5" border="0" cellspacing="0" cellpadding="0">
                        <!-- Buy Leads -->
                        <?php
                        $package_credit = $propertyObj->fun_getOwnerPackageCreditByPropertyId($property_id);
                        if(!isset($package_credit) || $package_credit < 1) {
                        ?>
                            <tr>
                                <td width="25px"><img src="<?php echo SITE_IMAGES;?>add-icon.jpg" /></td>
                                <td height="25"><a href="<?php echo SITE_URL; ?>list-your-property"><?php echo tranText('Buy Leads'); ?></a></td>
                            </tr>
                        <?php
                        }
                        ?>
                        <tr>
                            <td width="25px"><img src="<?php echo SITE_IMAGES;?>add-icon.jpg" /></td>
                            <td height="25"><a href="<?php echo "owner-property.php?sec=pho&pid=".$property_id;?>"><?php echo tranText('add_images'); ?></a></td>
                        </tr>
                        <tr>
                            <td><img src="images/add-icon.jpg" /></td>
                            <td height="25"><a href="<?php echo "owner-late-deals.php?pid=".$property_id;?>"><?php echo tranText('add_late_deal'); ?></a></td>
                        </tr>
                        <tr>
                            <td><img src="images/add-icon.jpg" /></td>
                            <td height="25"><a href="<?php echo "owner-hot-property.php?pid=".$property_id;?>"><?php echo tranText('add_featured_property'); ?></a></td>
                        </tr>
                        <tr>
                            <td><img src="images/add-icon.jpg" /></td>
                            <td height="25"><a href="javascript:poppropertypreview('holiday-property-preview.php?pid=<?php echo $property_id; ?>')"><?php echo tranText('preview_advert'); ?> </a></td>
                        </tr>
                        <tr><td height="40" colspan="2" valign="bottom"><a href="<?php echo "owner-property.php?sec=det&pid=".$property_id;?>" class="button-blue" style="color:#FFFFFF; text-decoration:none;"><?php echo tranText('edit_property'); ?></a></td></tr>
                    </table>
                </td>
                <td valign="top">
                    <?php $propertyObj->fun_createPropertyStat4Owner($property_id); ?>
                </td>
            </tr>
            <tr><td colspan="3"><div style="border-top:thin #efefef solid;padding:10px 0px 0px 0px; margin-top:10px;">&nbsp;</div></td></tr>
        <?php
    }
	?>
        </table>
	<?php
}
?>
