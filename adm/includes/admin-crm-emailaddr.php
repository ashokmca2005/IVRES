<?php
	if(isset($_GET['sortby']) && $_GET['sortby'] != ""){
		$strQuery = " ORDER BY ";
		switch($_GET['sortby']){
			case 'emailid':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$emailiddr 			= 0;
					$emailaddressdr		= 1;
					$addeddatedr 		= 1;
					$verifieddr 		= 1;
				} else {
					$dr = "DESC";
					$emailiddr 			= 1;
					$emailaddressdr		= 1;
					$addeddatedr 		= 1;
					$verifieddr 		= 1;
				}
				$strQuery .= " A.id ".$dr;
			break;
			case 'emailaddress':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$emailiddr 			= 1;
					$emailaddressdr		= 0;
					$addeddatedr 		= 1;
					$verifieddr 		= 1;
				} else {
					$dr = "DESC";
					$emailiddr 			= 1;
					$emailaddressdr		= 1;
					$addeddatedr 		= 1;
					$verifieddr 		= 1;
				}
				$strQuery .= " A.user_email ".$dr;
			break;
			case 'addeddate':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$emailiddr 			= 1;
					$emailaddressdr		= 1;
					$addeddatedr 		= 0;
					$verifieddr 		= 1;
				} else {
					$dr = "DESC";
					$emailiddr 			= 1;
					$emailaddressdr		= 1;
					$addeddatedr 		= 1;
					$verifieddr 		= 1;
				}
				$strQuery .= " A.created_on ".$dr;
			break;
			case 'verified':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$emailiddr 			= 1;
					$emailaddressdr		= 1;
					$addeddatedr 		= 1;
					$verifieddr 		= 0;
				} else {
					$dr = "DESC";
					$emailiddr 			= 1;
					$emailaddressdr		= 1;
					$addeddatedr 		= 1;
					$verifieddr 		= 1;
				}
				$strQuery .= " A.active ".$dr;
			break;
		}
	} else {
		$emailiddr 			= 1;
		$emailaddressdr		= 1;
		$addeddatedr 		= 1;
		$verifieddr 		= 1;
	}

	$userArr 				= $usersObj->fun_getUserNewsLetterArr($strQuery);
	if(is_array($userArr) && count($userArr) > 0){
	?>
	<script language="javascript" type="text/javascript">
		var req = ajaxFunction();
		var x, y;
		function toggleLayer(whichLayer){
            var output = document.getElementById(whichLayer).innerHTML;
            if(whichLayer == 'ANP-Example') {		
                output = '<div style="z-index:5;">'+output+'</div>';
                var googlewin=dhtmlwindow.open("Example", "inline", output, "", "width=295px,height=470px,resize=0,scrolling=0,center=1,xAxis="+x+",yAxis="+y+"", "recal");
            } else if(whichLayer == 'crm-delete-pop') {		
                var x1 = x-150;
                var y1 = y-100;
                output = '<div style="z-index:5;">'+output+'</div>';
                var googlewin=dhtmlwindow.open("Example", "inline", output, "", "width=298px,height=160px,resize=1,scrolling=0,center=1,xAxis="+x1+",yAxis="+y1+"", "recal");
            }
        
            googlewin.onclose=function(){ //Run custom code when window is being closed (return false to cancel action):
                return true
            }
        }
        
        function closeWindow(){	
            document.getElementById("Example").style.display="none";
        }
        
        function closeWindowNRefresh(){
            document.getElementById("Example").style.display="none";
            window.location = location.href;
        }
		function delItem(strId) {
			document.getElementById("txtDelItem").value = strId;
		}
		
		function delNewsletterItem(){
			closeWindow();
			if(document.getElementById("txtDelItem").value != "") {
				var strPropertyId = document.getElementById("txtDelItem").value;
				req.onreadystatechange = handleDeleteNewletterItemResponse;
				req.open('get', 'includes/ajax/crmemaildeleteXml.php?id='+strPropertyId); 
				req.send(null);   
			}
		}
		function handleDeleteNewletterItemResponse(){
			if(req.readyState == 4){
				var response = req.responseText;
				xmlDoc = req.responseXML;
				var root = xmlDoc.getElementsByTagName('newsletters')[0];
				if(root != null){
					var items = root.getElementsByTagName("newsletter");
					for (var i = 0 ; i < items.length ; i++){
						var item 				= items[i];
						var newsletterstatus 		= item.getElementsByTagName("newsletterstatus")[0].firstChild.nodeValue;
						if(newsletterstatus == "newsletter deleted."){
							window.location = location.href;
						}
					}
				}
			}
		}
        </script>

		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr><td colspan="2" valign="top">&nbsp;</td></tr>
			<tr>
				<td colspan="2" valign="top">
					<input type="hidden" name="txtDelItem" id="txtDelItem" value="" />
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EventListing">
						<thead>
							<tr>
								<th width="10%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-crm.php?sec=emailaddr&sortby=emailid&dr=".$emailiddr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "emailid")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?> ><div>ID</div></th>
								<th width="30%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-crm.php?sec=emailaddr&sortby=emailaddress&dr=".$emailaddressdr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "emailaddress")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>Email address</div></th>
								<th width="15%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-crm.php?sec=emailaddr&sortby=addeddate&dr=".$addeddatedr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "addeddate")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?> ><div>Added Date</div></th>
								<th width="10%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-crm.php?sec=emailaddr&sortby=verified&dr=".$verifieddr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "verified")){echo "class=\"rightOver\" onmouseout=\"this.className = 'rightOver';\" ";}else{echo "onmouseout=\"this.className = 'right';\"";}?>><div>Verified</div></th>
								<th width="10%" scope="col" class="right" onmouseover="this.className = 'rightOver';" ><div>Action</div></th>
							</tr>
						</thead>
						<tbody>
							<?php
                            for($i=0; $i < count($userArr); $i++){
                                $id 				= $userArr[$i]['id'];
                                $user_email 		= $userArr[$i]['user_email'];
                                $added_date 		= date('d M, Y', $userArr[$i]['created_on']);
								if($userArr[$i]['active'] == "1") {
									$status 		=  "Yes";
								} else {
									$status 		=  "No";
								}
                            ?>
                                <tr>
                                    <td class="left"><?php echo fill_zero_left($id, "0", (6-strlen($id)));?></td>
                                    <td><?php echo $user_email; ?></td>
                                    <td><?php echo date('M j, Y', strtotime($added_date)); ?></td>
                                    <td><?php echo $status; ?></td>
                                    <td class="right" align="center"><a href="javascript:delItem(<?php echo $id; ?>);toggleLayer('crm-delete-pop');" class="removeText">Delete</a></td>
                                </tr>
                            <?php
                            }
                            ?>
						</tbody>
					</table>
                    <div id="crm-delete-pop" style="display:none; position:absolute; background:transparent; left:300px; top:500px;">
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
                                                                    <td class="pad-rgt10 pad-top5"><strong>You will be delete this newsletter email and not be restored!</strong></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="pad-top10">
                                                                        <div class="FloatLft"><a href="javascript:closeWindow();void(0);" ><img src="<?php echo SITE_IMAGES;?>cancel-admin.png" alt="Keep it" /></a></div>
                                                                        <div class="FloatLft pad-lft5"><a href="javascript:delNewsletterItem();"><img src="<?php echo SITE_IMAGES;?>delete.gif" alt="Delete it" onmouseover="this.src='<?php echo SITE_IMAGES; ?>delete_h.gif'" onmouseout="this.src='<?php echo SITE_IMAGES; ?>delete.gif'" /></a></div>
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
			<tr><td colspan="2" valign="top">&nbsp;</td></tr>
		</table>
	<?php
	} else {
		?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr><td valign="top">No email added!</td></tr>
		</table>
		<?php
	}
?>
