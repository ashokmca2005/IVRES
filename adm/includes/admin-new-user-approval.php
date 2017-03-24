<?php
if(isset($user_id) && $user_id !=""){
$strQuery = " AND A.user_id='".$user_id."'";
$usrInfoArr = $usersObj->fun_getUserShortInfoArr($strQuery);
$usr_id 			= $usrInfoArr[0]['user_id'];
$usr_fname			= ucwords($usrInfoArr[0]['user_fname']);
$usr_lname			= ucwords($usrInfoArr[0]['user_lname']);
$usr_name 			= ucwords($usrInfoArr[0]['user_fname']." ".$usrInfoArr[0]['user_lname']);
$usr_email 			= $usrInfoArr[0]['user_email'];
$usr_registered_on 	= date('M d, Y', strtotime($usrInfoArr[0]['registered_on']));
$is_admin 			= $usrInfoArr[0]['is_admin'];
$is_moderator 		= $usrInfoArr[0]['is_moderator'];
$is_owner 			= $usrInfoArr[0]['is_owner'];
if($is_owner == "1") {
	$usr_dob 			= date('M d, Y', strtotime($usrInfoArr[0]['user_dob']));
	$usr_address1		= $usrInfoArr[0]['user_address1'];
	$usr_address2		= $usrInfoArr[0]['user_address2'];
	$usr_town			= $usrInfoArr[0]['user_town'];
	$usr_state			= $usrInfoArr[0]['user_state'];
	$usr_zip			= $usrInfoArr[0]['user_zip'];
	$usr_country		= $usrInfoArr[0]['user_country'];
	$usr_rcountry		= $usrInfoArr[0]['user_rcountry'];

	if($usr_country > 0) {
		$usr_country_name	= $locationObj->fun_getCountryNameById($usr_country);
	} else {
		$usr_country_name	= "";
	}
	if($usr_rcountry > 0) {
		$usr_rcountry_name	= $locationObj->fun_getCountryNameById($usr_rcountry);
	} else {
		$usr_rcountry_name	= "";
	}

	//user contact number
	$userContactInfoArr	= $usersObj->fun_getUserContactNumberArr($user_id);
	if(is_array($userContactInfoArr) && count($userContactInfoArr) > 0) {
		$contact_number = $userContactInfoArr[0]['contact_number'];	
	}
	//user languages
	$userLanguageInfoArr= $usersObj->fun_getUserContactLanguageArr($user_id);
	if(is_array($userLanguageInfoArr) && count($userLanguageInfoArr) > 0) {
		$language_id 		= $userLanguageInfoArr[0]['language_id'];
		$language_name 		= $usersObj->fun_getLanguageNameById($language_id);
	}
}
$usr_type	 		= ($is_admin == 1 ? "Admin" : ($is_moderator == 1 ? "Moderator" : ($is_owner == 1 ? "Owner" : "Holiday Maker")));
$usr_status 		= ($usrInfoArr[0]['user_status']=='1' ? "Approved" : "Pending approval");
//User setting array
$userSettingInfoArr	  = $userSetting->fun_getUserSettingInfo($usr_id);

//print_r($userSettingInfoArr);
?>
<script language="javascript" type="text/javascript">
var req = ajaxFunction(); 
function sbmtUsrApproval(strId){
	var strId = strId;
	req.open('get', 'includes/ajax/admin-user-pending-approvalXml.php?usrid=' + strId + '&mode=approve'); 
	req.onreadystatechange = handleApprovalResponse; 
	req.send(null); 
}

function sbmtUsrDecline(strId){
	document.getElementById("showDeclineReasonId").style.display = "block";
	var strId = strId;
	req.open('get', 'includes/ajax/admin-user-pending-approvalXml.php?usrid=' + strId + '&mode=decline'); 
	req.onreadystatechange = handleApprovalResponse; 
	req.send(null); 
}

function sbmtUsrSuspend(strId) {
	var strId = strId;
	req.open('get', 'includes/ajax/admin-user-pending-approvalXml.php?usrid=' + strId + '&mode=suspend'); 
	req.onreadystatechange = handleApprovalResponse; 
	req.send(null); 
}

function sbmtUsrDelete(strId) {
/*
	var strId = strId;
	req.open('get', 'includes/ajax/admin-user-pending-approvalXml.php?usrid=' + strId + '&mode=delete'); 
	req.onreadystatechange = handleApprovalResponse; 
	req.send(null); 
*/
}

function handleApprovalResponse() { 
	if(req.readyState == 4){ 
		var response = req.responseText; 
		xmlDoc=req.responseXML;
		var root = xmlDoc.getElementsByTagName('users')[0];
		if(root != null){
			var items = root.getElementsByTagName("user");
			var item = items[0];
			var userstatus = item.getElementsByTagName("userstatus")[0].firstChild.nodeValue;
			if(userstatus == "Approved") {
				document.getElementById("userStatusShowId").innerHTML 	= "<font color='#CF0000' size='2'><strong>"+userstatus+"</strong></font>";
			} else if(userstatus == "Declined") {
				document.getElementById("userStatusShowId").innerHTML 	= "<font color='#CF0000' size='2'><strong>"+userstatus+"</strong></font>";
			} else if(userstatus == "Suspended") {
				document.getElementById("userStatusShowId").innerHTML 	= "<font color='#CF0000' size='2'><strong>"+userstatus+"</strong></font>";
			} else if(userstatus == "Deleted") {
				window.location = 'admin-pending-approval.php?sec=newusers';
			} else{
				document.getElementById("userStatusShowId").innerHTML 	= "<font color='#CF0000' size='2'><strong>Error, try later!</strong></font>";
			}
		} else {
			document.getElementById("userStatusShowId").innerHTML 	= "<font color='#CF0000' size='2'><strong>Error, try later!</strong></font>";
		}
	} else {
		document.getElementById("userStatusShowId").innerHTML 	= "<font color='#CF0000' size='2'><strong>Please wait...</strong></font>";
	}
} 
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td valign="top"><a href="admin-pending-approval.php?sec=newusers" class="arrowLinkback">Back to list</a></td>
        <td align="right" valign="top">
            <a href="#" class="arrowLinkback">Previous</a>&nbsp; <span class="boldblack12">|</span> &nbsp; 
            <a href="#" class="arrowLinkNext">Next</a>
        </td>
    </tr>
    <tr><td colspan="2" valign="top" class="dash15">&nbsp;</td></tr>
    <tr>
        <td colspan="2" valign="top">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td valign="top" width="150">Type</td>
                    <td valign="top"><?php echo $usr_type; ?></td>
                </tr>
                <tr>
                    <td valign="top">ID</td>
                    <td valign="top"><a href="#" class="blueTxt"><?php echo fill_zero_left($usr_id, "0", (6-strlen($usr_id))); ?></a></td>
                </tr>
                <tr>
                    <td valign="top">Date added</td>
                    <td valign="top"><?php echo $usr_registered_on; ?></td>
                </tr>
                <tr>
                    <td valign="top">First name</td>
                    <td valign="top"><?php echo $usr_fname; ?></td>
                </tr>
                <tr>
                    <td valign="top">Last name</td>
                    <td valign="top"><?php echo $usr_lname; ?></td>
                </tr>
                <tr>
                    <td valign="top">Email address</td>
                    <td valign="top"><?php echo $usr_email; ?></td>
                </tr>
                <tr>
                    <td valign="top">Birthdate</td>
                    <td valign="top"><?php echo $usr_dob; ?></td>
                </tr>
                <tr>
                    <td valign="top">Country of residence</td>
                    <td valign="top"><?php echo $usr_rcountry_name; ?></td>
                </tr>
                <tr>
                    <td valign="top">Contact numbers</td>
                    <td valign="top"><?php echo $contact_number; ?></td>
                </tr>
                <tr>
                    <td valign="top">Languages spoken</td>
                    <td valign="top"><?php echo $language_name; ?></td>
                </tr>
                <tr>
                    <td valign="top">Contact address</td>
                    <td valign="top"><?php echo $usr_address1." ".$usr_address2; ?></td>
                </tr>
                <tr>
                    <td valign="top">Town / City</td>
                    <td valign="top"><?php echo $usr_town; ?></td>
                </tr>
                <tr>
                    <td valign="top">County / state / province</td>
                    <td valign="top"><?php echo $usr_state; ?></td>
                </tr>
                <tr>
                    <td valign="top">Postcode / ZIP</td>
                    <td valign="top"><?php echo $usr_zip; ?></td>
                </tr>
                <tr>
                    <td valign="top">Country</td>
                    <td valign="top"><?php echo $usr_rcountry_name; ?></td>
                </tr>
            </table>
        </td>
    </tr>

	<?php
    if(is_array($userSettingInfoArr) && count($userSettingInfoArr) > 0) {
    ?>
        <tr><td colspan="2" valign="top" class="dash15">&nbsp;</td></tr>
        <tr>
            <td colspan="2" valign="top">
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td valign="top" width="150"><strong>User Settings</strong></td>
                        <td valign="top">&nbsp;</td>
                    </tr>
                    <?php
                        for($j=0; $j < count($userSettingInfoArr); $j++) {
                            echo "<tr>";
                            echo "<td valign=\"top\" width=\"150\">&nbsp;</td>";
                            echo "<td>".$userSettingInfoArr[$j]['setting_name']."</td>";
                            echo "</tr>";
                        }
                    ?>
                </table>
            </td>
        </tr>
    <?php
    }
    ?>
    <tr><td colspan="2" valign="top" class="dash15">&nbsp;</td></tr>
    <tr>
        <td colspan="2" valign="top" class="adminBox">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="80" valign="top" class="owner-headings6">Status</td>
                    <td valign="bottom" class="black pad-top2"><div id="userStatusShowId"><strong><?php echo ucfirst($usr_status);?></strong></div></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td class="pad-top13">
                        <?php if($usrInfoArr[0]['user_status'] != "1"){?><a href="javascript:sbmtUsrApproval(<?php echo $usr_id;?>);"><img src="<?php echo SITE_ADMIN_IMAGES;?>approve.gif" alt="Approve"/></a><?php } else{?><img src="<?php echo SITE_ADMIN_IMAGES;?>approve.gif" alt="Approve"/><?php }?>
                        <?php if($usrInfoArr[0]['user_status'] != "0"){?><a href="javascript:sbmtUsrSuspend(<?php echo $usr_id;?>);"><img src="<?php echo SITE_ADMIN_IMAGES;?>suspend.gif" class="pad-left3" alt="Suspend"/></a><?php } else{?><img src="<?php echo SITE_ADMIN_IMAGES;?>suspend.gif" class="pad-left3" alt="Suspend"/><?php }?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr><td colspan="2" valign="top">&nbsp;</td></tr>
	<?php
	$userOrderHistoryArr 	= $cartObj->fun_getUserOrderHistoryArr($usr_id, "4");
	if(is_array($userOrderHistoryArr) && count($userOrderHistoryArr)) {
	?>
		<tr><td colspan="2" valign="top" class="font18-darkgrey" style="padding-bottom:20px;">Payment history</td></tr>
		<?php
		$offer_code = "";
		for($i = 0; $i < count($userOrderHistoryArr); $i++) {
			$orders_id 				= $userOrderHistoryArr[$i]['orders_id'];
			$orderProductsArr 		= $cartObj->fun_getOrderProductsArr($orders_id);
			$offer_code 			= $cartObj->fun_getOrderUserPromoCode($orders_id, $usr_id);
		?>
			<tr>
				<td colspan="2" valign="top">
					<table width="100%" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td valign="top" bgcolor="#e2e2e2">
								<table width="100%" border="0" cellpadding="0" cellspacing="5">
									<tr>
										<td width="130" valign="top" style="padding-left:5px;"><strong>Date purchased</strong></td>
										<td><?php echo date('M d, Y', $cartObj->fun_getOrderDate($orders_id)); ?></td>
									</tr>
									<tr>
										<td valign="top" style="padding-left:5px;"><strong>Total amount paid</strong></td>
										<td><?php echo number_format($cartObj->fun_getOrderPaidAmount($orders_id), 2); ?></td>
									</tr>
									<tr>
										<td valign="top" style="padding-left:5px;"><strong>Offer code</strong></td>
										<td><?php echo $offer_code; ?></td>
									</tr>
								</table>
							</td>
						</tr>
						<tr><td valign="top">&nbsp;</td></tr>
						<?php
						if(is_array($orderProductsArr) && count($orderProductsArr)) {
						?>
							<tr>
								<td valign="top">
									<table width="100%" border="0" cellpadding="0" cellspacing="0">
										<tbody style="font-size:11px;">
										<tr class="font12-darkgrey">
											<td width="20%" style="padding-left:10px;">Reference</td>
											<td width="35%">Description</td>
											<td width="20%" align="right">Cost per unit</td>
											<td width="10%" align="center">Units</td>
											<td width="15%" align="right" style="padding-right:10px;">Total cost</td>
										</tr>
										</tbody>
									</table>
								</td>
							</tr>
							<?php
							for($j = 0; $j < count($orderProductsArr); $j++) {
								$products_id 		= $orderProductsArr[$j]['products_id'];
								$products_name 		= $orderProductsArr[$j]['products_name'];
								$products_price 	= number_format($orderProductsArr[$j]['products_price'], 2);
								$final_price 		= number_format($orderProductsArr[$j]['final_price'], 2);
								$products_quantity 	= $orderProductsArr[$j]['products_quantity'];
								$reference 			= $cartObj->fun_getPropertyReference($orders_id, $products_id);
							?>
								<tr>
									<td valign="top">
										<table width="100%" border="0" cellpadding="0" cellspacing="0">
											<tbody style="font-size:11px;">
											<tr>
												<td width="20%" style="padding-left:10px;"><?php echo fill_zero_left($reference, "0", (6-strlen($reference))); ?></td>
												<td width="35%"><?php echo $products_name; ?></td>
												<td width="20%" align="right"><?php echo $products_price; ?></td>
												<td width="10%" align="center"><?php echo $products_quantity; ?></td>
												<td width="15%" align="right" style="padding-right:10px;"><?php echo $final_price; ?></td>
											</tr>
											</tbody>
										</table>
									</td>
								</tr>
							<?php
							}
						}
						?>
					</table>
				</td>
			</tr>
			<tr><td colspan="2" valign="top">&nbsp;</td></tr>
		<?php
		}
		?>
	<?php
	}
	?>
    <tr><td colspan="2" valign="top">&nbsp;</td></tr>
</table>
<?php
} else {
	if(isset($_GET['sortby']) && $_GET['sortby'] != "") {
		$strQuery = " ORDER BY ";
		switch($_GET['sortby']){
			case 'usrid':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$usriddr 	= 0;
					$usrnamedr	= 1;
					$usremaildr = 1;
					$usrtypedr 	= 1;
					$usradddr 	= 1;
					$statusdr 	= 1;
				}
				else{
					$dr = "DESC";
					$usriddr 	= 1;
					$usrnamedr	= 1;
					$usremaildr = 1;
					$usrtypedr 	= 1;
					$usradddr 	= 1;
					$statusdr 	= 1;
				}
				$strQuery .= " A.user_id ".$dr;
			break;
			case 'usrname':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$usriddr 	= 1;
					$usrnamedr	= 0;
					$usremaildr = 1;
					$usrtypedr 	= 1;
					$usradddr 	= 1;
					$statusdr 	= 1;
				}
				else{
					$dr = "DESC";
					$usriddr 	= 1;
					$usrnamedr	= 1;
					$usremaildr = 1;
					$usrtypedr 	= 1;
					$usradddr 	= 1;
					$statusdr 	= 1;
				}
				$strQuery .= " A.user_fname ".$dr;
			break;
			case 'usremail':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$usriddr 	= 1;
					$usrnamedr	= 1;
					$usremaildr = 0;
					$usrtypedr 	= 1;
					$usradddr 	= 1;
					$statusdr 	= 1;
				}
				else{
					$dr = "DESC";
					$usriddr 	= 1;
					$usrnamedr	= 1;
					$usremaildr = 1;
					$usrtypedr 	= 1;
					$usradddr 	= 1;
					$statusdr 	= 1;
				}
				$strQuery .= " A.user_email ".$dr;
			break;
			case 'usrtype':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$usriddr 	= 1;
					$usrnamedr	= 1;
					$usremaildr = 1;
					$usrtypedr 	= 0;
					$usradddr 	= 1;
					$statusdr 	= 1;
				}
				else{
					$dr = "DESC";
					$usriddr 	= 1;
					$usrnamedr	= 1;
					$usremaildr = 1;
					$usrtypedr 	= 1;
					$usradddr 	= 1;
					$statusdr 	= 1;
				}
				$strQuery .= " A.is_admin ".$dr.", A.is_moderator ".$dr.", A.is_owner ".$dr;
			break;
			case 'added':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$usriddr 	= 1;
					$usrnamedr	= 1;
					$usremaildr = 1;
					$usrtypedr 	= 1;
					$usradddr 	= 0;
					$statusdr 	= 1;
				}
				else{
					$dr = "DESC";
					$usriddr 	= 1;
					$usrnamedr	= 1;
					$usremaildr = 1;
					$usrtypedr 	= 1;
					$usradddr 	= 1;
					$statusdr 	= 1;
				}
				$strQuery .= " A.created_on ".$dr;
			break;
			case 'status':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$usriddr 	= 1;
					$usrnamedr	= 1;
					$usremaildr = 1;
					$usrtypedr 	= 1;
					$usradddr 	= 1;
					$statusdr 	= 0;
				}
				else{
					$dr = "DESC";
					$usriddr 	= 1;
					$usrnamedr	= 1;
					$usremaildr = 1;
					$usrtypedr 	= 1;
					$usradddr 	= 1;
					$statusdr 	= 1;
				}
				$strQuery .= " A.user_status ".$dr;
			break;
		}
	} else {
		$strQuery 	= "";
		$usriddr 	= 1;
		$usrnamedr	= 1;
		$usremaildr = 1;
		$usrtypedr 	= 1;
		$usradddr 	= 1;
		$statusdr 	= 1;
	}
	$usrListArr = $usersObj->fun_getPendingApprovalNewUserArr($strQuery);
	if(is_array($usrListArr) && count($usrListArr) > 0){
	?>
		<script language="javascript" type="text/javascript">
        /* --------- Script for sort list links : start here ----------- */
        function sortList(str){
        //	alert(str);
            location.href = str;
        }
        /* --------- Script for sort list links : end here ----------- */
        </script>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr><td colspan="2" valign="top">&nbsp;</td></tr>
			<tr>
				<td colspan="2" valign="top">
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EventListing">
						<thead>
							<tr>
								<th width="7%" class="left" scope="col">&nbsp;</th>
								<th width="9%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-pending-approval.php?sec=newusers&sortby=usrid&dr=".$usriddr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "usrid")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?> ><div>ID</div></th>
								<th width="14%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-pending-approval.php?sec=newusers&sortby=usrname&dr=".$usrnamedr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "usrname")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?> ><div>Name</div></th>
								<th width="22%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-pending-approval.php?sec=newusers&sortby=usremail&dr=".$usremaildr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "usremail")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>Email address</div></th>
								<th width="15%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-pending-approval.php?sec=newusers&sortby=usrtype&dr=".$usrtypedr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "usrtype")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>Type</div></th>
								<th width="15%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-pending-approval.php?sec=newusers&sortby=added&dr=".$usradddr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "added")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>Date registered</div></th>
								<th width="18%" scope="col" class="right" onmouseover="this.className = 'rightOver';" onclick="sortList('<?php echo "admin-pending-approval.php?sec=newusers&sortby=status&dr=".$statusdr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "status")){echo "class=\"rightOver\" onmouseout=\"this.className = 'rightOver';\" ";}else{echo "onmouseout=\"this.className = 'right';\"";}?>><div>Status</div></th>
							</tr>
						</thead>
						<tbody>
							<?php
                            for($i=0; $i < count($usrListArr); $i++){
                            $usr_id 			= $usrListArr[$i]['user_id'];
                            $usr_name 			= ucwords($usrListArr[$i]['user_fname']." ".$usrListArr[$i]['user_lname']);
                            $usr_email 			= $usrListArr[$i]['user_email'];
                            $usr_registered_on 	= date('M d, Y', strtotime($usrListArr[$i]['registered_on']));
                            $is_admin 			= $usrListArr[$i]['is_admin'];
                            $is_moderator 		= $usrListArr[$i]['is_moderator'];
                            $is_owner 			= $usrListArr[$i]['is_owner'];
                            $usr_type	 		= ($is_admin == 1 ? "Admin" : ($is_moderator == 1 ? "Moderator" : ($is_owner == 1 ? "Owner" : "Holiday Maker")));
                            $usr_status 		= ($usrListArr[$i]['user_status']=='1' ? "Approved" : "Pending approval");
                            ?>
                                <tr>
                                    <td class="left"><a href="admin-pending-approval.php?sec=newusers&usrid=<?php echo $usr_id;?>">View</a></td>
                                    <td><?php echo fill_zero_left($usr_id, "0", (6-strlen($usr_id)));?></td>
                                    <td><?php echo $usr_name;?></td>
                                    <td><?php echo $usr_email;?></td>
                                    <td><?php echo $usr_type;?></td>
                                    <td><?php echo $usr_registered_on;?></td>
                                    <td class="right"><?php echo $usr_status;?></td>
                                </tr>
                            <?php
                            }
                            ?>
						</tbody>
					</table>
				</td>
			</tr>
			<tr><td colspan="2" valign="top">&nbsp;</td></tr>
		</table>
	<?php
	} else {
	?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr><td valign="top">No new user registered!</td></tr>
        </table>
	<?php
	}
}
?>