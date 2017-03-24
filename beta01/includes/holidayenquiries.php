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
			$sortField  = "A.enquiry_id";
		break;
		case 1:
			$sortField  = "A.enquiry_id";
		break;
		default:
			$sortField = "A.enquiry_id";
		break;
	}

	$search_query = "";
	$strQueryParameter		= " ORDER BY " . $sortField . " " . $orderDir. " LIMIT ".(int)(($page-1)*(int)GLOBAL_RECORDS_PER_PAGE).", ".GLOBAL_RECORDS_PER_PAGE;
	$strQueryCountParameter	= " ORDER BY " . $sortField . " " . $orderDir;

	$rsQuery				= $propertyObj->fun_getPropertyUserEnquiryArr($user_id, $strQueryParameter);
	$rsQueryCount			= $propertyObj->fun_getPropertyUserEnquiryArr($user_id, $strQueryCountParameter);
	if(isset($txtcountryids) && $txtcountryids != "") { $search_query .= "&txtcountryids=" . html_escapeURL($txtcountryids); }

	$enquiriesListArr 		= $dbObj->fetchAssoc($rsQuery);

	// Determine the pagination
	$return_query 		= $search_query."&".$sort_query."&page=$page";
	$pag 				= new Pagination($rsQueryCount, $search_query."&".$sort_query, GLOBAL_RECORDS_PER_PAGE);
	$pag->current_page 	= $page;
	$pagination  		= $pag->Process();
//	print_r($enquiriesListArr);
?>
<script type="text/javascript" language="javascript">
	var req = ajaxFunction();
	function delEnquiry(strId) {
		document.getElementById("txtDelItem").value = strId;
	}
	function delMessage(){
		closeWindow();
		if(document.getElementById("txtDelItem").value != "") {
			var strMessageId = document.getElementById("txtDelItem").value;
			req.onreadystatechange = handleDeleteMessageItemResponse;
			req.open('get', '<?php echo SITE_URL;?>messagedeleteXml.php?enquiry_id='+strMessageId+'&customer_id=<?php echo $user_id;?>'); 
			req.send(null);   
		}
	}

	function handleDeleteMessageItemResponse(){
		if(req.readyState == 4){
			var response = req.responseText;
			xmlDoc = req.responseXML;
			var root = xmlDoc.getElementsByTagName('enquirys')[0];
			if(root != null){
				var items = root.getElementsByTagName("enquiry");
				for (var i = 0 ; i < items.length ; i++){
					var item 				= items[i];
					var enquirystatus 		= item.getElementsByTagName("enquirystatus")[0].firstChild.nodeValue;
					if(enquirystatus == "enquiry deleted."){
						location.href = window.location;
					}
				}
			}
		}
	}
</script>

<table width="690" border="0" cellspacing="0" cellpadding="0" class="font12">
    <?php
if(is_array($enquiriesListArr) && count($enquiriesListArr) > 0) {
?>
    <tr>
        <td align="left" valign="top">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <?php /*?>
				<tr>
                    <td valign="top" class="pad-rgt10">
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td width="41%" align="left" valign="top" class="pad-btm10 pad-left2"><strong><?php if(isset($pagination['total_rows']) && $pagination['total_rows'] > 1) { echo "Showing ".$pagination['first_row']." to ".$pagination['last_row']." of ".$pagination['total_rows']." enquiries";} else if(isset($pagination['total_rows']) && $pagination['total_rows'] == 1){echo "Showing ".$pagination['first_row']." to ".$pagination['last_row']." of ".$pagination['total_rows']." enquiry";} ?></strong></td>
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
                            <form name="frmUserEnquiry" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <input type="hidden" name="securityKey" id="securityKey" value="<?php echo md5(DELENQUIRY); ?>" />
                            <input type="hidden" name="txtDelItem" id="txtDelItem" value="" />
                            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EventListing">
                                <thead>
                                    <tr>
                                        <th width="10%" scope="col">
                                            <div>Enquiry ID</div>
                                        </th>
                                        <th width="20%" scope="col">
                                            <div>From</div>
                                        </th>
                                        <th width="10%" scope="col">
                                            <div>Prop ID</div>
                                        </th>
                                        <th width="25%" scope="col">
                                            <div>Property name</div>
                                        </th>
                                        <th width="20%" scope="col">
                                            <div>Date</div>
                                        </th>
                                        <th width="15%" scope="col">
                                            <div>Action</div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
                                for($i =0; $i < count($enquiriesListArr); $i++) {
                                    $enquiry_id 		= $enquiriesListArr[$i]['enquiry_id'];
                                    $enquiry_char 		= $enquiriesListArr[$i]['enquiry_char'];
                                    $user_id 			= $enquiriesListArr[$i]['user_id'];
                                    $property_id 		= $enquiriesListArr[$i]['property_id'];
                                    $user_name			= $enquiriesListArr[$i]['user_name'];
                                    $property_name 		= $propertyObj->fun_getPropertyName($property_id);
                                    $created_on 		= $enquiriesListArr[$i]['created_on'];
                                    $delete_status 		= $enquiriesListArr[$i]['delete_status'];
                                    if($delete_status != "1" && $delete_status != "2") {
                                        echo "<tr>";
                                        echo "<td align=\"left\">".fill_zero_left($enquiry_id, "0", (9-strlen($enquiry_id)))."(".$enquiry_char.")</td>";
                                        echo "<td align=\"left\">".ucfirst($user_name)."</td>";
                                        echo "<td align=\"left\">".fill_zero_left($property_id, "0", (6-strlen($property_id)))."</td>";
                                        echo "<td align=\"left\">".ucfirst($property_name)."</td>";
                                        echo "<td align=\"left\">";
                                        echo date('M j, Y', $created_on);
                                        if($propertyObj->fun_getPropertyEnquiryViewStatus($enquiry_id) != true) {
                                            echo "&nbsp;&nbsp;<img src=\"".SITE_IMAGES."mark-new.png\" alt=\"New Enquiry\" width=\"32\" height=\"14\" />";
                                        }
                                        echo "</td>";
                                        echo "<td align=\"center\">";
                                        echo "<a href=\"holiday-enquiries.php?enquiry=".$enquiry_id."&pid=".$property_id."\" class=\"blue-link\">View</a>&nbsp;&nbsp;|&nbsp;&nbsp;";
                                        echo "<a href=\"javascript:delEnquiry(".$enquiry_id.");toggleLayer('enquiry-delete-pop');\" class=\"blue-link\">Delete</a>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                            <div id="enquiry-delete-pop" style="display:none; position:absolute; background:transparent; left:300px; top:500px;">
                                <div style="position:relative; z-index:999;left:0px;width:250px;height:170px;">
                                    <table width="230" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td align="right"><img src="<?php echo SITE_IMAGES;?>poplefttop.png" alt="ANP" height="10" width="10" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo SITE_IMAGES;?>poplefttop.png', sizingMethod='scale');" /></td>
                                            <td class="topp"></td>
                                            <td><img src="<?php echo SITE_IMAGES;?>poprighttop1.png" alt="ANP"  height="10" width="15" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo SITE_IMAGES;?>poprighttop1.png', sizingMethod='scale');"/></td>
                                        </tr>
                                        <tr>
                                            <td class="leftp"></td>
                                            <td width="220" align="left" valign="top" bgcolor="#FFFFFF" style="padding:12px;">
                                                <table width="220" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td align="left" valign="top" class="head"><span class="pink14arial">Are you sure?</span></td>
                                                        <td width="15" align="right" valign="top"><a href="javascript:closeWindow();void(0);" ><img src="<?php echo SITE_IMAGES;?>pop-up-cross.gif" alt="Close" title="Close" border="0" /></a></td>
                                                    </tr>
                                                    <tr>
                                                        <td  align="left" valign="top" class="PopTxt">
                                                            <table width="98%" border="0" cellpadding="0" cellspacing="0">
                                                                <tr>
                                                                    <td class="pad-rgt10 pad-top5"><strong>You wont be able to see this message again!</strong></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="pad-top10">
                                                                        <div class="FloatLft"><a href="javascript:closeWindow();void(0);" ><img src="<?php echo SITE_IMAGES;?>cancel-admin.png" alt="Keep it" /></a></div>
                                                                        <div class="FloatLft pad-lft5"><a href="javascript:delMessage();"><img src="<?php echo SITE_IMAGES;?>delete.gif" alt="Delete it" /></a></div>
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
                        </form>
                    </td>
                </tr>
				<?php /*?>
                <tr>
                    <td valign="top" class="pad-rgt10 pad-top10">
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td width="41%" align="left" valign="top" class="pad-btm10 pad-left2"><strong>
                                    <?php if(isset($pagination['total_rows']) && $pagination['total_rows'] > 1) { echo "Showing ".$pagination['first_row']." to ".$pagination['last_row']." of ".$pagination['total_rows']." enquiries";} else if(isset($pagination['total_rows']) && $pagination['total_rows'] == 1){echo "Showing ".$pagination['first_row']." to ".$pagination['last_row']." of ".$pagination['total_rows']." enquiry";} ?>
                                    </strong></td>
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
            </table>
        </td>
    </tr>
    <?php
} else {
?>
    <tr>
        <td valign="top" class="pad-top20"> <span class="pink14arial">You currently have no enquiry <img src="<?php echo SITE_IMAGES;?>smiles/icon_sad.gif" alt="smiles" /></span> </td>
    </tr>
    <?php
}
?>
</table>
