<?php	
if(isset($_REQUEST['id']) && $_REQUEST['id'] != ''){
	$id  = $_REQUEST['id'];
}
// Form submission
$form_array = array();
$errorMsg 	= 'no';

//Edit backlink submit : Start here 
if($_POST['securityKey']==md5("EDITBACKLINK")){	
	if(trim($_POST['property_id']) == ''){		
		$form_array['property_id_error'] = 'Property id required';
		$errorMsg = 'yes';
	}
	if(trim($_POST['backlink']) == ''){		
		$form_array['backlink_error'] = 'Backlink required';
		$errorMsg = 'yes';
	}
	if(trim($_POST['status']) == ''){
		$form_array['status_error'] = 'Status required';
		$errorMsg = 'yes';
	}

   if($errorMsg == 'no' && $errorMsg != 'yes') {
		$id 			= $_POST['id'];
		$property_id 	= $_POST['property_id'];
		$backlink 		= $_POST['backlink'];
		$backlinkcode	= $_POST['backlinkcode'];
		$status 		= $_POST['status'];
		$cid 			= $propertyObj->fun_editPropertyBackLink($id, $property_id, $backlink, $backlinkcode, $status);
		if(isset($cid) && $cid != "") {
			$redirect_url 	= "admin-collateral.php?sec=backlink&subsec=edit&id=".$id;
			redirectURL($redirect_url);
		} else {
			die("Error :: Duplicate activation link!");
			exit;
		}
	} else {
		$form_array['error_msg'] = "Please submit your form again!";
	}	
}
//Edit backlink submit : End here 

//Add a new backlink submit : Start here 
if($_POST['securityKey']==md5("ADDBACKLINK")) {		
	if(trim($_POST['property_id']) == ''){		
		$form_array['property_id_error'] = 'Property id required';
		$errorMsg = 'yes';
	}
	if(trim($_POST['backlink']) == ''){		
		$form_array['backlink_error'] = 'Backlink required';
		$errorMsg = 'yes';
	}
	if(trim($_POST['status']) == ''){
		$form_array['status_error'] = 'Status required';
		$errorMsg = 'yes';
	}
	if($errorMsg == 'no' && $errorMsg != 'yes') {
		$property_id 	= trim($_POST['property_id']);
		$backlink 		= trim($_POST['backlink']);
		$backlinkcode	= $_POST['backlinkcode'];
		$status 		= trim($_POST['status']);
		$id 			= $propertyObj->fun_addPropertyBackLink($property_id, $backlink, $backlinkcode, $status);
		if(isset($id) && $id != "") {
			$redirect_url 	= "admin-collateral.php?sec=backlink&subsec=edit&id=".$id;
			redirectURL($redirect_url);
		} else {
			die("Error :: Duplicate activation link!");
			exit;
		}
		/*
		echo "<script>location.href = window.location;</script>";
		*/
	} else {
		$form_array['error_msg'] = "Please submit your form again!";
	}
}
//Add a new backlink submit : End here 

if(isset($_GET['subsec']) && $_GET['subsec'] !="") {
	switch($_GET['subsec']) {
		case "add":
		case "edit":
			if(isset($id) && $id !=""){
				$infoArr 	= $propertyObj->fun_getPropertyBacklinkInfo($id);
			}
			?>
			<script language="javascript" type="text/javascript">
				var req = ajaxFunction();
				function validateBackLink() { 
					var id = document.getElementById('id').value;
					if(id != "") {
						req.onreadystatechange = function() {
							if (req.readyState==4) {
								var response = req.responseText; 
								xmlDoc = req.responseXML;
								var root = xmlDoc.getElementsByTagName('backlinks')[0];
								if(root != null) {
									var items = root.getElementsByTagName("backlink");
									var item = items[0];
									var backlinkstatus = item.getElementsByTagName("backlinkstatus")[0].firstChild.nodeValue;
									if(backlinkstatus == "valid"){
										document.getElementById("showErrorValidStatus").innerHTML = "Valid backlink";
									} else {
										document.getElementById("showErrorValidStatus").innerHTML = "Invalid backlink";
									}
								}
							}
						}
						req.open('get', 'includes/ajax/validateBacklinkXml.php?id=' + id);
						req.send(null); 
					}
				}

				function validate(){
					if(document.getElementById("property_id").value == "") {
						document.getElementById("showErrorPropertyId").innerHTML = "Property id required";
						document.getElementById("property_id").focus();
						return false;
					}
					if(document.getElementById("backlink").value == "") {
						document.getElementById("showErrorBacklinkId").innerHTML = "Backlink required";
						document.getElementById("backlink").focus();
						return false;
					}
					if(document.getElementById("status").value == "") {
						document.getElementById("showErrorStatusId").innerHTML = "Status required";
						document.getElementById("status").focus();
						return false;
					}
					document.frmBacklink.submit();
				}
				
				function chkblnkTxtError(strFieldId, strErrorFieldId) {
					if(document.getElementById(strFieldId).value != "") {
						document.getElementById(strErrorFieldId).innerHTML = "";
					}
				}
			</script>
			<script type="text/javascript" language="javascript">
				function showRow(strId){
					var strId = strId;
					document.getElementById(strId).style.display = "block";
				}
				function removeContactNumber(strId) {
					var strNumberId = "txtContactNumber"+strId;
					document.getElementById(strNumberId).value = "";
					document.frmPropertyContacts.submit();
				}
				function addEvent() {
					var strTable = "";
					var ni = document.getElementById('myDiv');
					var numi = document.getElementById('theValue');
					var num = (document.getElementById("theValue").value -1)+ 2;
					numi.value = num;
					var divIdName = "my"+num+"Div";
					var strcontype = "<?php $propertyObj->fun_getPropertyContactNoTypeOptionsList(); ?>";
					var strconnamefav = "<?php $propertyObj->fun_getCountriesISDOptionsList('', " WHERE countries_name IN ('United States', 'United Kingdom') ORDER BY countries_name IN ('United States', 'United Kingdom')"); ?>";
					var strconname = "<?php $propertyObj->fun_getCountriesISDOptionsList(); ?>";
					var newdiv = document.createElement('div');
					newdiv.setAttribute("id",divIdName);
					strTable += "<table cellspacing='0' cellpadding='0'>";
					strTable += "<tr>";
					strTable += "<td colspan='4' height='5'>";
					strTable += "</td>";
					strTable += "</tr>";
					strTable += "<tr>";
					strTable += "<td align='left'>";
					strTable += "<select name='txtContactNumberType[]' class='NumberType'>";
					strTable += "<option value=''>Select Type</option>";
					strTable += strcontype;
					strTable += "</select>";
					strTable += "<td class='pad-lft10'>";
					strTable += "<select name='txtContactCountry[]' id='txtContactCountryId' class='select128'>";
					strTable += "<option value='' style='font-style:normal; background-color:#D0E0F1;COLOR:#000000' disabled='disabled' selected='selected'>Select Country ...</option>";
					strTable += strconnamefav;
					strTable += "<option value='' style='font-style:normal;background-color:#D0E0F1;COLOR:#000000' disabled='disabled'> ---------------------------------------------- </option>";
					strTable += strconname;
					strTable += "</select>";
					strTable += "</td>";
					strTable += "<td class='pad-lft10'><input type='text' name='txtContactNumber[]' class='ContactNumber' maxlength='15' /></td>";
					strTable += "<td class='pad-lft10 pad-top1' valign='middle'><a href=\"javascript:;\" class='delete-photo' onclick=\"removeElement(\'"+divIdName+"\')\">Delete</a></td>";
					strTable += "</tr>";
					strTable += "</table>";
					newdiv.innerHTML = strTable;
					ni.appendChild(newdiv);
				}
				function removeElement(divNum) {
					var d = document.getElementById('myDiv');
					var olddiv = document.getElementById(divNum);
					d.removeChild(olddiv);
				}
				function addEvent1() {
					var strTable1 = "";
					var ni = document.getElementById('myDiv1');
					var numi = document.getElementById('theValue');
					var num = (document.getElementById("theValue").value -1)+ 2;
					numi.value = num;
					var divIdName = "my"+num+"Div";
					var strlang = "<?php $propertyObj->fun_getLanguagesOptionsList(); ?>";
					var newdiv = document.createElement('div');
					newdiv.setAttribute("id",divIdName);
					strTable1 += "<table cellspacing='0' cellpadding='0'>";
					strTable1 += "<tr>";
					strTable1 += "<td height='5'>";
					strTable1 += "</td>";
					strTable1 += "</tr>";
					strTable1 += "<tr>";
					strTable1 += "<td align='left'>";
					strTable1 += "<select name='txtContactLanguage[]' class='select230'>";
					strTable1 += "<option value='' style='font-style:normal; background-color:#D0E0F1;COLOR:#000000' disabled='disabled' selected='selected'>Select Language ...</option>";
					strTable1 += strlang;
					strTable1 += "</select>";
					strTable1 += "</td>";
					strTable1 += "<td class='pad-lft10 pad-top1' valign='middle'> <a href=\"javascript:;\" class='delete-photo' onclick=\"removeElement1(\'"+divIdName+"\')\">Delete</a></td>";
					strTable1 += "</tr>";
					strTable1 += "</table>";
					newdiv.innerHTML = strTable1;
					ni.appendChild(newdiv);
				}
				function removeElement1(divNum) {
					var d = document.getElementById('myDiv1');
					var olddiv = document.getElementById(divNum);
					d.removeChild(olddiv);
				}
			</script>
			<form name="frmBacklink" id="frmBacklink" method="post" action="admin-collateral.php?sec=backlink">
			<input type="hidden" name="securityKey" id="securityKey" value="<?php if(isset($id) && $id !=""){ echo md5("EDITBACKLINK");} else {echo md5("ADDBACKLINK");} ?>">
			<input type="hidden" name="id" id="id" value="<?php if(isset($id) && $id !=""){ echo $id;} ?>">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
				<tr><td height="10" colspan="2" valign="top">&nbsp;</td></tr>
				<tr>
					<td valign="top"><a href="admin-collateral.php?sec=backlink" class="back">Back to List</a></td>
					<td align="right" valign="top">
                    <a href="javascript:void(0);" onclick="return validateBackLink();" class="button-blue" style="text-decoration:none;">Validate Backlink</a>
                    <br /><br />
                    <span class="pdError1" id="showErrorValidStatus" style="margin-right:10px;">&nbsp;</span>
                    </td>
				</tr>
				<tr>
					<td colspan="2" valign="top" class="pad-top5">
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
							<tr>
								<td valign="top" class="pad-top7">
									<table width="690" border="0" cellspacing="0" cellpadding="0" class="font12">
										<tr>
											<td align="left" valign="top">
												<table width="100%" border="0" cellspacing="0" cellpadding="10" class="eventForm">
													<tr>
														<td colspan="2" align="right" valign="top" class="header">
															<table width="100%" border="0" cellspacing="0" cellpadding="0">
																<tr>
																	<td align="right" valign="bottom" colspan="2">
																		<a href="admin-collateral.php?sec=backlink" style="text-decoration: none;"><img src="images/cancelN.png" alt="Cancel" border="0" height="21" width="66"></a>&nbsp;<input type="image" src="images/saveChangesN.png" alt="Save approve" name="SaveChange" width="108" height="21" border="0" id="SaveChangeId"  onclick="return validateSaveProfile();">
																	</td>
																</tr>
															</table>
														</td>
													</tr>
													<tr>
														<td colspan="2" valign="top">
															<table width="100%" border="0" cellspacing="0" cellpadding="0">
																<tr>
																	<td valign="top">
                                                                        <!-- Edit section start here -->
                                                                        <table width="100%" border="0" cellpadding="5" cellspacing="0">
                                                                            <tr>
                                                                                <td width="155" align="right" valign="middle">Property id</td>
                                                                                <td width="235" valign="middle"><span class="RegFormRight"><input type="text" name="property_id" id="property_id" class="RegFormFldowner" value="<?php if(isset($_POST['property_id'])){echo $_POST['property_id'];}else{echo $infoArr['property_id'];}?>" /></span></td>
                                                                                <td width="274" valign="top"><span class="pdError1" id="showErrorPropertyId"><?php if(array_key_exists('property_id', $form_array)) echo $form_array['property_id'];?></span></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td align="right" valign="middle">Backlink</td>
                                                                                <td valign="middle"><span class="RegFormRight"><input type="text" name="backlink" id="backlink" class="RegFormFldowner" value="<?php if(isset($_POST['backlink'])){echo $_POST['backlink'];}else{echo $infoArr['backlink'];}?>" onkeydown="chkblnkTxtError('backlink', 'showErrorBacklinkId');" onkeyup="chkblnkTxtError('backlink', 'showErrorBacklinkId');" /></span></td>
                                                                                <td valign="top"><span class="pdError1" id="showErrorBacklinkId"><?php if(array_key_exists('backlink', $form_array)) echo $form_array['backlink'];?></span></td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td align="right" valign="middle">Backlink code</td>
                                                                                <td valign="middle">
                                                                                <textarea name="backlinkcode" id="backlinkcode" cols="" rows="" class="txtarea_500x80" onkeydown="chkblnkTxtError('backlinkcode', 'showErrorBacklinkCodeId');" onkeyup="chkblnkTxtError('backlinkcode', 'showErrorBacklinkCodeId');" ><?php if(isset($_POST['backlinkcode'])){echo $_POST['backlinkcode'];}else{echo $infoArr['backlinkcode'];}?></textarea>
                                                                                </td>
                                                                                <td valign="top"><span class="pdError1" id="showErrorBacklinkCodeId"><?php if(array_key_exists('backlinkcode', $form_array)) echo $form_array['backlinkcode'];?></span></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td align="right" valign="middle">Status</td>
                                                                                <td valign="middle">
                                                                                    <select name="status" id="status" class="select230">
                                                                                        <option value="1" <?php if($infoArr['status'] == 1) {echo "selected=\"selected\"";} ?> >Pending</option>
                                                                                        <option value="2" <?php if($infoArr['status'] == 2) {echo "selected=\"selected\"";} ?> >Approved</option>
                                                                                        <option value="3" <?php if($infoArr['status'] == 3) {echo "selected=\"selected\"";} ?> >Declined</option>
                                                                                        <option value="4" <?php if($infoArr['status'] == 4) {echo "selected=\"selected\"";} ?> >Suspended</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td valign="top"><span class="pdError1" id="showErrorStatusId"><?php if(array_key_exists('status', $form_array)) echo $form_array['status'];?></span></td>
                                                                            </tr>
                                                                            <tr><td colspan="3" align="left" valign="top" class="dash25">&nbsp;</td></tr>
                                                                        </table>
                                                                        <!-- Edit section end here -->
																	</td>
																</tr>
															</table>
														</td>
													</tr>
													<tr>
														<td colspan="2" align="right" valign="top" class="header">
															<table width="100%" border="0" cellspacing="0" cellpadding="0">
																<tr>
																	<td align="right" valign="bottom" colspan="2">
																		<a href="admin-collateral.php?sec=backlink" style="text-decoration: none;"><img src="images/cancelN.png" alt="Cancel" border="0" height="21" width="66"></a>&nbsp;<input type="image" src="images/saveChangesN.png" alt="Save approve" name="SaveChange" width="108" height="21" border="0" id="SaveChangeId"  onclick="return validate();">
																	</td>
																</tr>
															</table>
														</td>
													</tr>
												</table>
											</td>
										</tr>
									</table>
								</td>
							</tr>
							<tr><td valign="top">&nbsp;</td></tr>
							<tr><td valign="top">&nbsp;</td></tr>
						</table>
					</td>
				</tr>
			</table>
			</form>
			<?php
		break;
	}
} else {
	//$sec = $_GET['sec'];
	if(isset($_POST['txtFilter']) && $_POST['txtFilter'] == "1"){		
		$txtBacklink 	= $_POST['txtBacklink'];
    	$strQuery 		= " AND A.id='".$txtBacklink."' ";
	}
	if(isset($_GET['sortby']) && $_GET['sortby'] != "") {
		$strQuery = " ORDER BY ";
		switch($_GET['sortby']){
			case 'id':
				if($_GET['dr'] == "1"){
					$dr 			= "ASC";
					$iddr 			= 0;
					$propertyiddr	= 1;
					$crawldatedr 	= 1;
					$linkadddr 		= 1;
					$statusdr 		= 1;
				} else {
					$dr 			= "DESC";
					$iddr 			= 1;
					$propertyiddr	= 1;
					$crawldatedr 	= 1;
					$linkadddr 		= 1;
					$statusdr 		= 1;
				}
				$strQuery .= " A.id ".$dr;
			break;
			case 'propertyid':
				if($_GET['dr'] == "1"){
					$dr 			= "ASC";
					$iddr 			= 1;
					$propertyiddr	= 0;
					$crawldatedr 	= 1;
					$linkadddr 		= 1;
					$statusdr 		= 1;
				} else {
					$dr 			= "DESC";
					$iddr 			= 1;
					$propertyiddr	= 1;
					$crawldatedr 	= 1;
					$linkadddr 		= 1;
					$statusdr 		= 1;
				}
				$strQuery .= " A.property_id ".$dr;
			break;
			case 'crawldate':
				if($_GET['dr'] == "1"){
					$dr 			= "ASC";
					$iddr 			= 1;
					$propertyiddr	= 1;
					$crawldatedr 	= 1;
					$linkadddr 		= 1;
					$statusdr 		= 1;
				} else {
					$dr 			= "DESC";
					$iddr 			= 1;
					$propertyiddr	= 1;
					$crawldatedr 	= 1;
					$linkadddr 		= 1;
					$statusdr 		= 1;
				}
				$strQuery .= " A.crawldate ".$dr;
			break;
			case 'addeddate':
				if($_GET['dr'] == "1"){
					$dr 			= "ASC";
					$iddr 			= 1;
					$propertyiddr	= 1;
					$crawldatedr 	= 1;
					$linkadddr 		= 0;
					$statusdr 		= 1;
				} else {
					$dr 			= "DESC";
					$iddr 			= 1;
					$propertyiddr	= 1;
					$crawldatedr 	= 1;
					$linkadddr 		= 1;
					$statusdr 		= 1;
				}
				$strQuery .= " A.created_on ".$dr;
			break;
			case 'status':
				if($_GET['dr'] == "1"){
					$dr 			= "ASC";
					$iddr 			= 1;
					$propertyiddr	= 1;
					$crawldatedr 	= 1;
					$linkadddr 		= 1;
					$statusdr 		= 0;
				} else {
					$dr 			= "DESC";
					$iddr 			= 1;
					$propertyiddr	= 1;
					$crawldatedr 	= 1;
					$linkadddr 		= 1;
					$statusdr 		= 1;
				}
				$strQuery .= " A.status ".$dr;
			break;
		}
	} else {
		//$strQuery 	= "";
		$iddr 			= 1;
		$propertyiddr	= 1;
		$crawldatedr 	= 1;
		$linkadddr 		= 1;
		$statusdr 		= 1;
	}
	$listArr = $propertyObj->fun_getPropertyBackLinkArr($strQuery);
	if(is_array($listArr) && count($listArr) > 0){
	?>
		<script language="javascript" type="text/javascript">
			function sortList(str){
			//	alert(str);
				location.href = str;
			}
        </script>
        <script language="javascript" type="text/javascript">
			var req = ajaxFunction();
		 	var x, y;	
			function getFilter(){
				var id = document.getElementById("txtBacklinkId").value;
				if(id == "") {
					alert("Enter advert id!");
					document.getElementById("txtBacklinkId").focus();
					return false;
				} else {
					document.getElementById("frmFilter").action = "admin-collateral.php?sec=backlink";
					document.getElementById("frmFilter").submit();
				}
            }

		   function toggleLayer(whichLayer){
				var output = document.getElementById(whichLayer).innerHTML;
				if(whichLayer == 'ANP-Example') {		
					output = '<div style="z-index:5;">'+output+'</div>';
					var googlewin=dhtmlwindow.open("Example", "inline", output, "", "width=295px,height=470px,resize=0,scrolling=0,center=1,xAxis="+x+",yAxis="+y+"", "recal");
				} else if(whichLayer == 'backlink-delete-pop') {		
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
			
			function delLinkItem(){
				closeWindow();
				if(document.getElementById("txtDelItem").value != "") {
					var strBacklinkId = document.getElementById("txtDelItem").value;
					req.onreadystatechange = handleDeleteBackLinkItemResponse;
					req.open('get', 'includes/ajax/backlinkdeleteXml.php?id='+strBacklinkId); 
					req.send(null);   
				}
			}

			function handleDeleteBackLinkItemResponse(){
				if(req.readyState == 4){
					var response = req.responseText;
					xmlDoc = req.responseXML;
					var root = xmlDoc.getElementsByTagName('backlinks')[0];
					if(root != null){
						var items = root.getElementsByTagName("backlink");
						for (var i = 0 ; i < items.length ; i++){
							var item 				= items[i];
							var backlinkstatus 		= item.getElementsByTagName("backlinkstatus")[0].firstChild.nodeValue;
							if(backlinkstatus == "backlink deleted."){
								window.location = location.href;
							}
						}
					}
				}
			}

			function getFilter(){
				var id = document.getElementById("txtBacklinkId").value;
				if(id == "") {
					alert("Enter backlink id!");
					document.getElementById("txtBacklinkId").focus();
					return false;
				} else {
					document.getElementById("frmFilter").action = "admin-collateral.php?sec=backlink";
					document.getElementById("frmFilter").submit();
				}
            }

			function showFilter(strInt){
				if(parseInt(strInt) > 0) {
					document.getElementById("filterTbl").style.display = "block";
				} else {
					location.href = "admin-collateral.php?sec=backlink";
				}
            }
        </script>		
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
            <td colspan="2" valign="top">
                <form name="frmFilter" id="frmFilter" method="post">
                <input type="hidden" name="txtFilter" id="txtFilter" value="1" />
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
                    <tr><td height="10" colspan="2" valign="top" class="dash-top"></td></tr>
                    <tr>
                        <td valign="top">
                            <table border="0" cellspacing="0" cellpadding="2" class="boldTitle" style="padding-bottom:10px;">
                                <tr>
                                    <td><input name="radio" type="radio" class="radio" id="radio1" value="1" <?php if(!isset($_POST['txtFilter']) || $_POST['txtFilter'] != "1") { echo "checked=\"checked\"";} else {echo "";}?> onclick="return showFilter(0);" /></td>
                                    <td>View all</td>
                                    <td class="pad-lft20"><input name="radio" type="radio" class="radio" id="radio2" value="2" <?php if(isset($_POST['txtFilter']) && $_POST['txtFilter'] == "1") { echo "checked=\"checked\"";} else {echo "";}?> onclick="return showFilter(1);"/></td>
                                    <td>Filter Backlinks</td>
                                </tr>
                            </table>
                        </td>
                        <td align="right" valign="top">
                            <table border="0" cellspacing="0" cellpadding="0" id="filterTbl" style="display:<?php if(isset($_POST['txtFilter']) && $_POST['txtFilter'] == "1") { echo "block";} else {echo "none";}?>">
                                <tr>
                                    <td class="blackTxt14 pad-rgt5" style="font-weight:normal;">Advert ID</td>
                                    <td class="pad-rgt5"><input type="text" name="txtBacklink" id="txtBacklinkId" class="Textfield80 blackText" value="<?php if(isset($_POST['txtBacklink']) && $_POST['txtBacklink'] != "") { echo $_POST['txtBacklink'];} else {echo "";}?>" /></td>
                                    <td><a href="javascript:void(0);" onclick="return getFilter();"><img src="images/show-admin.gif" alt="Send" border="0" /></a></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr><td height="10" colspan="2" valign="top" class="dash-top"></td></tr>
                </table>
            </form>
            </td>
        </tr>
            <tr><td colspan="2" valign="top">&nbsp;</td></tr>
            <tr>
                <td valign="top">Display <?php echo count($listArr); ?>-<?php echo count($listArr); ?> of <?php echo count($listArr); ?></td>
                <td align="right" valign="top" class="Paging">
                <!--
                <a href="#">First</a> <a href="#">&lt;</a> <a href="#">1</a> | 2 | <a href="#">3</a> | <a href="#">4</a> | <a href="#">5</a> | <a href="#">6</a> | <a href="#">7</a> | <a href="#">8</a> | <a href="#">9</a> | <a href="#">10</a>...<a href="#">23</a> <a href="#">&gt;</a> <a href="#">Last</a>
                -->
                <a href="admin-collateral.php?sec=backlink&subsec=add" class="button-blue" style="text-decoration:none;">Add new Backlink</a>
                </td>
            </tr>
            <tr><td colspan="2" valign="top">&nbsp;</td></tr>
            <tr>
                <td colspan="2" valign="top">
                    <input type="hidden" name="txtDelItem" id="txtDelItem" value="" />
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EventListing">
                        <thead>
                            <tr>
                                <th width="12%" class="left" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-collateral.php?sec=backlink&sortby=id&dr=".$iddr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "id")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?> ><div>Advert ID</div></th>
                                <th width="13%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-collateral.php?sec=backlink&sortby=propertyid&dr=".$propertyiddr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "propertyid")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?> ><div>Property ID</div></th>
                                <th width="30%" scope="col" onmouseover="this.className = 'RollOver';"><div>Advert Link</div></th>
                                <th width="15%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-collateral.php?sec=backlink&sortby=crawldate&dr=".$crawldatedr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "crawldate")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>Crawl date</div></th>
                                <th width="15%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-collateral.php?sec=backlink&sortby=addeddate&dr=".$addeddatedr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "addeddate")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>Added date</div></th>
                                <th width="10%" scope="col" class="right" onmouseover="this.className = 'rightOver';" onclick="sortList('<?php echo "admin-collateral.php?sec=backlink&sortby=status&dr=".$statusdr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "status")){echo "class=\"rightOver\" onmouseout=\"this.className = 'rightOver';\" ";}else{echo "onmouseout=\"this.className = 'right';\"";}?>><div>Status</div></th>
                                <th width="10%" scope="col"><div>Action</div></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            for($i=0; $i < count($listArr); $i++){
                            $id 			= $listArr[$i]['id'];
                            $property_id 	= $listArr[$i]['property_id'];
                            $backlink 		= $listArr[$i]['backlink'];
                            $crawldate 		= date('M d, Y', strtotime($listArr[$i]['crawldate']));
                            $addeddate 		= date('M d, Y', $listArr[$i]['created_on']);
                            $crawlfailed 	= $listArr[$i]['crawlfailed'];
                            $status 		= ($listArr[$i]['status']=='1' ? "Approved" : "Pending approval");
							switch($listArr[$i]['status']) {
								case '1':
									$status = "Pending approval";
								break;
								case '2':
									$status = "Approved";
								break;
								case '3':
									$status = "Declined";
								break;
								case '4':
									$status = "Suspended";
								break;
								default:
									$status = "Suspended";
								break;
							}
                            ?>
                                <tr>
                                    <td class="left"><a href="admin-collateral.php?sec=backlink&subsec=edit&id=<?php echo $id;?>"><?php echo fill_zero_left($id, "0", (6-strlen($id)));?></a></td>
                                    <td><?php echo fill_zero_left($property_id, "0", (6-strlen($property_id)));?></td>
                                    <td><?php echo $backlink;?></td>
                                    <td><?php echo $crawldate;?><?php echo "<br>Failed: ".$crawlfailed;?></td>
                                    <td><?php echo $addeddate;?></td>
                                    <td class="right"><?php echo $status;?></td>
                                    <td><a href="javascript:delItem(<?php echo $id; ?>);toggleLayer('backlink-delete-pop');" class="removeText">Delete</a></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <div id="backlink-delete-pop" style="display:none; position:absolute; background:transparent; left:300px; top:500px;">
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
                                                            <td class="pad-rgt10 pad-top5"><strong>You will be delete this backlink!</strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="pad-top10">
                                                                <div class="FloatLft"><a href="javascript:closeWindow();void(0);" ><img src="<?php echo SITE_IMAGES;?>cancel-admin.png" alt="Keep it" /></a></div>
                                                                <div class="FloatLft pad-lft5"><a href="javascript:delLinkItem();"><img src="<?php echo SITE_IMAGES;?>delete.gif" alt="Delete it" onmouseover="this.src='<?php echo SITE_IMAGES; ?>delete_h.gif'" onmouseout="this.src='<?php echo SITE_IMAGES; ?>delete.gif'" /></a></div>
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
            <tr><td valign="top">No backlink added!</td></tr>
        </table>
	<?php
	}
}

?>
