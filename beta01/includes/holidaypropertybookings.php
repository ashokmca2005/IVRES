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

	$rsQuery				= $propertyObj->fun_getPropertyUserBookingArr($user_id, $strQueryParameter);
	$rsQueryCount			= $propertyObj->fun_getPropertyUserBookingArr($user_id, $strQueryCountParameter);
	if(isset($txtcountryids) && $txtcountryids != "") { $search_query .= "&txtcountryids=" . html_escapeURL($txtcountryids); }

	$bookingsListArr 		= $dbObj->fetchAssoc($rsQuery);

	// Determine the pagination
	$return_query 		= $search_query."&".$sort_query."&page=$page";
	$pag 				= new Pagination($rsQueryCount, $search_query."&".$sort_query, GLOBAL_RECORDS_PER_PAGE);
	$pag->current_page 	= $page;
	$pagination  		= $pag->Process();
//	print_r($bookingsListArr);
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
<?php
if(is_array($bookingsListArr) && count($bookingsListArr) > 0) {
?>
    <tr>
        <td align="left" valign="top">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
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
                </tr>
                <tr>
                    <td valign="top" class="pad-rgt10">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EventListing">
                            <thead>
                                <tr>
                                    <th width="15%" scope="col"><div>Booking ID</div></th>
									<?php /*?>
                                    <th width="20%" scope="col"><div>From</div></th>
									<?php */?>
                                    <th width="15%" scope="col"><div>Prop ID</div></th>
                                    <th width="40%" scope="col"><div>Property name</div></th>
                                    <th width="23%" scope="col"><div>Date</div></th>
                                    <th width="7%" scope="col">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
							<?php
                            for($i =0; $i < count($bookingsListArr); $i++) {
                                $booking_id 		= $bookingsListArr[$i]['booking_id'];
                                $user_id 			= $bookingsListArr[$i]['user_id'];
                                $owner_id 			= $bookingsListArr[$i]['owner_id'];
                                $property_id 		= $bookingsListArr[$i]['property_id'];
                                $user_name			= $bookingsListArr[$i]['user_name'];
                                $property_name 		= $propertyObj->fun_getPropertyName($property_id);
                                $created_on 		= $bookingsListArr[$i]['created_on'];
                                echo "<tr>";
                                echo "<td align=\"left\">".fill_zero_left($booking_id, "0", (9-strlen($booking_id)))."</td>";
//                                echo "<td align=\"left\">".ucfirst($user_name)."</td>";
                                echo "<td align=\"left\">".fill_zero_left($property_id, "0", (6-strlen($property_id)))."</td>";
                                echo "<td align=\"left\">".ucfirst($property_name)."</td>";
                                echo "<td align=\"left\">";
								echo date('M j, Y', $created_on);
								if($propertyObj->fun_getPropertyBookingViewStatus($booking_id) != true) {
									echo "&nbsp;&nbsp;<img src=\"".SITE_IMAGES."mark-new.png\" alt=\"New Booking\" width=\"32\" height=\"14\" />";
								}
								echo "</td>";
                                echo "<td align=\"center\"><a href=\"holiday-booking.php?booking=".$booking_id."&pid=".$property_id."\" class=\"blue-link\">View</a></td>"; 
								echo "</tr>";
                            }
                            ?>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
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
                </tr>
            </table>
        </td>
    </tr>
<?php
} else {
?>
    <tr><td valign="top" class="pad-top10"><span class="font16-darkgrey">You currently have no bookings ;-(</span></td></tr>
    <tr><td valign="top" class="pad-top10"><a href="<?php echo SITE_URL; ?>home" style="text-decoration:none;"><img src="<?php echo SITE_IMAGES;?>myhomepage.gif" alt="My homepage" /></a></td></tr>
<?php
}
?>    
</table>