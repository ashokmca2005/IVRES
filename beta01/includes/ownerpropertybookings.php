<?php 
	$page	 = form_int("page",1)+0;
	$sortby  = form_int("sortby",0,0,5);
	$sortdir = form_int("sortdir",0,0,1);
	if (form_isset("reverse")) {
		$sortdir = 1-$sortdir;
	}
	
	switch($sortdir) {
		case 0 :
			$orderDir = "DESC";
		break;
		case 1 :
			$orderDir = "ASC";
		break;
	}

	switch($sortby) {
		case 0:
			$sortField  = "A.created_on";
		break;
		case 1:
			$sortField  = "A.created_on";
		break;
		default:
			$sortField = "A.created_on";
		break;
	}

	$search_query = "";
	$strQueryParameter		= " ORDER BY " . $sortField . " " . $orderDir. " LIMIT ".(int)(($page-1)*(int)GLOBAL_RECORDS_PER_PAGE).", ".GLOBAL_RECORDS_PER_PAGE;
	$strQueryCountParameter	= " ORDER BY " . $sortField . " " . $orderDir;

	$rsQuery				= $propertyObj->fun_getPropertyOwnerBookingArr($user_id, $strQueryParameter);
	$rsQueryCount			= $propertyObj->fun_getPropertyOwnerBookingArr($user_id, $strQueryCountParameter);
	if(isset($txtcountryids) && $txtcountryids != "") { $search_query .= "&txtcountryids=" . html_escapeURL($txtcountryids); }

	$bookingsListArr 		= $dbObj->fetchAssoc($rsQuery);

	// Determine the pagination
	$return_query 		= $search_query."&".$sort_query."&page=$page";
	$pag 				= new Pagination($rsQueryCount, $search_query."&".$sort_query, GLOBAL_RECORDS_PER_PAGE);
	$pag->current_page 	= $page;
	$pagination  		= $pag->Process();
//	print_r($bookingsListArr);
?>
<script type="text/javascript" language="javascript">
	var req = ajaxFunction();
	function delBooking(strId) {
		document.getElementById("txtDelItem").value = strId;
	}
	function delBookingMessage(){
		closeWindow();
		if(document.getElementById("txtDelItem").value != "") {
			var strMessageId = document.getElementById("txtDelItem").value;
			req.onreadystatechange = handleDeleteBookingMessageItemResponse;
			req.open('get', '<?php echo SITE_URL;?>bookingdeleteXml.php?booking_id='+strMessageId+'&owner_id=<?php echo $user_id;?>'); 
			req.send(null);   
		}
	}

	function handleDeleteBookingMessageItemResponse(){
		if(req.readyState == 4){
			var response = req.responseText;
			xmlDoc = req.responseXML;
			var root = xmlDoc.getElementsByTagName('bookings')[0];
			if(root != null){
				var items = root.getElementsByTagName("booking");
				for (var i = 0 ; i < items.length ; i++){
					var item 				= items[i];
					var enquirystatus 		= item.getElementsByTagName("bookingstatus")[0].firstChild.nodeValue;
					if(enquirystatus == "booking deleted."){
						location.href = window.location;
					}
				}
			}
		}
	}
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
<?php
if(is_array($bookingsListArr) && count($bookingsListArr) > 0) {
?>
    <tr>
        <td align="left" valign="top">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <?php /*?>
				<tr>
                    <td valign="top" class="pad-rgt10">
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td width="41%" align="left" valign="top" class="pad-btm10 pad-left2"><strong><?php if(isset($pagination['total_rows']) && $pagination['total_rows'] > 1) { echo "Showing ".$pagination['first_row']." to ".$pagination['last_row']." of ".$pagination['total_rows']." bookings";} else if(isset($pagination['total_rows']) && $pagination['total_rows'] == 1){echo "Showing ".$pagination['first_row']." to ".$pagination['last_row']." of ".$pagination['total_rows']." booking";} ?></strong></td>
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
                </tr><?php */?>
                <tr>
                    <td valign="top" class="pad-rgt10">
                        <form name="frmUserEnquiry" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" name="securityKey" id="securityKey" value="<?php echo md5(DELBOOKING); ?>" />
                        <input type="hidden" name="txtDelItem" id="txtDelItem" value="" />

                        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EventListing">
                            <thead>
                                <tr>
                                    <th width="10%" scope="col"><div>Booking ID</div></th>
                                    <th width="20%" scope="col"><div>From</div></th>
                                    <th width="10%" scope="col"><div>Prop ID</div></th>
                                    <th width="30%" scope="col"><div>Property name</div></th>
                                    <th width="23%" scope="col"><div>Date</div></th>
                                    <th width="7%" scope="col">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
							<?php
                            for($i =0; $i < count($bookingsListArr); $i++) {
                                $booking_id 		= $bookingsListArr[$i]['booking_id'];
                                $user_id 			= $bookingsListArr[$i]['user_id'];
                                $property_id 		= $bookingsListArr[$i]['property_id'];
                                $user_name			= $bookingsListArr[$i]['user_name'];
                                $property_name 		= $propertyObj->fun_getPropertyName($property_id);
                                $created_on 		= $bookingsListArr[$i]['created_on'];
								$delete_status 	    = $bookingsListArr[$i]['delete_status'];
							    if($delete_status != "1" && $delete_status != "3") {
                                echo "<tr>";
                                echo "<td align=\"left\">".fill_zero_left($booking_id, "0", (9-strlen($booking_id)))."</td>";
                                echo "<td align=\"left\">".ucfirst($user_name)."</td>";
                                echo "<td align=\"left\">".fill_zero_left($property_id, "0", (6-strlen($property_id)))."</td>";
                                echo "<td align=\"left\">".ucfirst($property_name)."</td>";
                                echo "<td align=\"left\">";
								echo date('M j, Y', $created_on);
								if($propertyObj->fun_getPropertyBookingViewStatus($booking_id) != true) {
									echo "&nbsp;&nbsp;<img src=\"".SITE_IMAGES."mark-new.png\" alt=\"New Booking\" width=\"32\" height=\"14\" />";
								}
								echo "</td>";
					            echo "<td align=\"center\">";
                                echo "<td align=\"center\"><a href=\"owner-propertybookings.php?booking=".$booking_id."&pid=".$property_id."\" class=\"blue-link\">View</a></td>"; 
								echo "<td align=\"center\"><a href=\"javascript:delBooking(".$booking_id.");toggleLayer('enquiry-booking-pop');\" class=\"blue-link\">Delete</a>";
								echo "</td>";
								echo "</tr>";
								}
                            }
                            ?>
                            </tbody>
                        </table>
                        <div id="enquiry-booking-pop" style="display:none; position:absolute; background:transparent; left:300px; top:500px;">
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
                                                                    <div class="FloatLft pad-lft5"><a href="javascript:delBookingMessage();"><img src="<?php echo SITE_IMAGES;?>delete.gif" alt="Delete it" /></a></div>
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
                <?php /*?><tr>
                    <td valign="top" class="pad-rgt10 pad-top10">
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td width="41%" align="left" valign="top" class="pad-btm10 pad-left2"><strong><?php if(isset($pagination['total_rows']) && $pagination['total_rows'] > 1) { echo "Showing ".$pagination['first_row']." to ".$pagination['last_row']." of ".$pagination['total_rows']." bookings";} else if(isset($pagination['total_rows']) && $pagination['total_rows'] == 1){echo "Showing ".$pagination['first_row']." to ".$pagination['last_row']." of ".$pagination['total_rows']." booking";} ?></strong></td>
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
                </tr><?php */?>
            </table>
        </td>
    </tr>
<?php
} else {
?>
    <tr><td valign="top" class="pad-top10"><span class="font16-darkgrey"><?php echo tranText('you_currently_have_no_bookings'); ?> ;-(</span></td></tr>
    <tr><td valign="top" class="pad-top10"><a href="<?php echo SITE_URL; ?>owner-home" style="text-decoration:none;" class="button-blue">My homepage</a></td></tr>
<?php
}
?>    
</table>