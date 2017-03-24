<?php
//form submission
$form_array = array();
$errorMsg 	= "no";

// Edit page submit : Start here 
if($_POST['securityKey']==md5("EDITPBANNER")){	
	if(trim($_POST['banner_title']) == '') {
		$form_array['banner_title_error'] = 'Banner title required';
		$errorMsg = 'yes';
	}

	if(trim($_POST['banner_desc']) == '') {
		$form_array['banner_desc_error'] = 'Banner description required';
		$errorMsg = 'yes';
	}

	if(trim($_POST['banner_link']) == '') {
		$form_array['banner_link_error'] = 'Banner link required';
		$errorMsg = 'yes';
	}

   if($errorMsg == 'no' && $errorMsg != 'yes') {
		$banner_id 				= $_POST['banner_id'];
		$banner_title 			= $_POST['banner_title'];
		$banner_desc 			= $_POST['banner_desc'];
		$banner_link 			= $_POST['banner_link'];
		$start_date 			= $_POST['start_date'];
		$end_date 				= $_POST['end_date'];
		$active 				= 1;
		$banner_type 			= 1;

		if(isset($_FILES['banner_img']) && ($_FILES['banner_img']['name'] !="")) {
			$img 				= basename($_FILES['banner_img']['name']);
			$extn 				= @split("\.",$img);
			$banner_img 		= $banner_id."_banner.".$extn[1];
			$uploadbannerdir 	= '../upload/banners-logos/banners';
			$uploadbannerfile 	= $uploadbannerdir ."/". $banner_img;
			@move_uploaded_file($_FILES['banner_img']['tmp_name'], $uploadbannerfile);
		} else {
			$banner_img 		= $dbObj->getField(TABLE_BANNER, "banner_id", $banner_id, "banner_img");
		}
		$bannerObj->fun_editBanner($banner_id, $banner_title, $banner_desc, $banner_img, $banner_link, $banner_type, $start_date, $end_date, $active);
		$redirect_url 			= "admin-site-variables.php?sec=prom&subsec=edit&banner_id=".$banner_id;
		redirectURL($redirect_url);
	} else {
		$form_array['error_msg'] = "Please submit your form again!";
	}	
}
// Edit banner details submit : End here 

// add a new page submit : Start here 
if($_POST['securityKey']==md5("ADDBANNER")){	

	if(trim($_POST['banner_title']) == '') {
		$form_array['banner_title_error'] = 'Banner title required';
		$errorMsg = 'yes';
	}

	if(trim($_POST['banner_desc']) == '') {
		$form_array['banner_desc_error'] = 'Banner description required';
		$errorMsg = 'yes';
	}

	if(trim($_POST['banner_link']) == '') {
		$form_array['banner_link_error'] = 'Banner link required';
		$errorMsg = 'yes';
	}

	if($_FILES['banner_img']['name'] == '') {
		$form_array['banner_img_error'] = 'Banner photo required';
		$errorMsg = 'yes';
	}

	if($errorMsg == 'no' && $errorMsg != 'yes') {
		$banner_title 			= $_POST['banner_title'];
		$banner_desc 			= $_POST['banner_desc'];
		$banner_link 			= $_POST['banner_link'];
		$start_date 			= $_POST['start_date'];
		$end_date 				= $_POST['end_date'];
		$active 				= 1;
		$banner_type 			= 1;

		$banner_id 				= $bannerObj->fun_addBanner($banner_title, $banner_desc, $banner_img, $banner_link, $banner_type, $start_date, $end_date, $active);
		if(isset($_FILES['banner_img']) && ($_FILES['banner_img']['name'] !="")) {
			$img 				= basename($_FILES['banner_img']['name']);
			$extn 				= @split("\.",$img);
			$banner_img 		= $banner_id."_banner.".$extn[1];
			$uploadbannerdir 	= '../upload/banners-logos/banners';
			$uploadbannerfile 	= $uploadbannerdir ."/". $banner_img;
			@move_uploaded_file($_FILES['banner_img']['tmp_name'], $uploadbannerfile);
		} else {
			$banner_img 		= $dbObj->getField(TABLE_BANNER, "banner_id", $banner_id, "banner_img");
		}
		$bannerObj->fun_editBanner($banner_id, $banner_title, $banner_desc, $banner_img, $banner_link, $banner_type, $start_date, $end_date, $active);
		$redirect_url 			= "admin-site-variables.php?sec=prom&subsec=edit&banner_id=".$banner_id;
		redirectURL($redirect_url);
	} else {
		$form_array['error_msg'] = "Please submit your form again!";
	}	
}
// add a new page submit : End here 

if(isset($_GET['subsec']) && $_GET['subsec'] !="") {
	?>
	<script type="text/javascript" language="javascript">
	function chkblnkTxtError(strFieldId, strErrorFieldId){
		if(document.getElementById(strFieldId).value != ""){
		  document.getElementById(strErrorFieldId).innerHTML = "";
		}
	}
	
	function validatefrm(){
		<?php
		if($_GET['subsec'] =="add") {
		?>
		if(document.getElementById("banner_img_id").value == "") {
			document.getElementById("banner_img_errorid").innerHTML = "Banner image required";
			document.getElementById("banner_img_id").focus();
			return false;
		}
		<?php
		}
		?>

		if(document.getElementById("banner_title_id").value == "") {
			document.getElementById("banner_title_errorid").innerHTML = "Banner title required";
			document.getElementById("banner_title_id").focus();
			return false;
		}
	
		if(document.getElementById("banner_desc_id").value == "") {
			document.getElementById("banner_desc_errorid").innerHTML = "Banner Description required";
			document.getElementById("banner_desc_id").focus();
			return false;
		}
	
		/*
		if(document.getElementById("start_date_id").value == "") {
			document.getElementById("start_date_errorid").innerHTML = "SEO title required";
			document.getElementById("start_date_id").focus();
			return false;
		}
	
		if(document.getElementById("end_date_id").value == "") {
			document.getElementById("end_date_errorid").innerHTML = "SEO keyword required";
			document.getElementById("end_date_id").focus();
			return false;
		}
		*/
	
		if(document.getElementById("banner_link_id").value == "") {
			document.getElementById("banner_link_errorid").innerHTML = "Banner link required";
			document.getElementById("banner_link_id").focus();
			return false;
		}
		document.frmBanner.submit();
	}
	</script>
	<?php
	if(isset($banner_id) && $banner_id !=""){
		$bannerInfo 	= $bannerObj->fun_getBannerInfo($banner_id);
		$banner_type 	= $bannerInfo['banner_type'];
		?>
		<form name="frmBanner" id="frmBanner" method="post" action="admin-site-variables.php?sec=prom&subsec=edit&banner_id=<?php echo $banner_id;?>" enctype="multipart/form-data">
			<input type="hidden" name="securityKey" id="securityKey" value="<?php echo md5("EDITPBANNER"); ?>">
			<input type="hidden" name="banner_id" id="banner_id" value="<?php echo $banner_id; ?>">
			<input type="hidden" name="banner_type" id="banner_type" value="1">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
                <tr><td height="5" colspan="2" valign="top">&nbsp;</td></tr>
                <tr>
                    <td valign="top"><a href="admin-site-variables.php?sec=prom" class="back">Back to List</a></td>
                    <td align="right" valign="top"><a href="admin-site-variables.php?sec=prom&subsec=add">Add New Banner</a></td>
                </tr>
                <?php if(isset($message) && $message <> ''){?>
                    <tr><td height="5" colspan="2" valign="top"><?php echo $message;?></td></tr>
                <?php }?>
                <tr>
                    <td colspan="2" valign="top">
                        <table width="100%" border="0" cellspacing="0" cellpadding="10" class="eventForm">
                            <tr>
                                <td colspan="2" align="right" valign="top" class="header">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr><td align="right" valign="bottom" colspan="2"><a href="javascript:void(0);" onClick="return validatefrm();" style="text-decoration:none;"><img src="images/saveChangesN.png" alt="Save Approve" width="108" height="21" border="0" /></a></td></tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td height="23" align="right" valign="top" class="admleftBg">Banner Image</td>
                                <td valign="top">
                                <input type="file" name="banner_img" id="banner_img_id">
								<?php if(isset($bannerInfo['banner_img']) && $bannerInfo['banner_img'] != ''){?>
                                <br /><br />
                                <img src="<?php echo SITE_URL."upload/banners-logos/banners/".$bannerInfo['banner_img'];?>" border="0" width="200px">
								<?php }?>
                                </td>
                            </tr>
                            <tr>
                                <td height="23" align="right" valign="top" class="admleftBg">Banner Title</td>
                                <td valign="top"><input type="text" name="banner_title" id="banner_title_id" class="inpuTxt510" value="<?php if(isset($_POST['banner_title'])){echo $_POST['banner_title'];}else{echo $bannerInfo['banner_title'];}?>" onkeydown="chkblnkTxtError('banner_title_id', 'banner_title_errorid');" onkeyup="chkblnkTxtError('banner_title_id', 'banner_title_errorid');" />&nbsp;<span class="pdError1" id="banner_title_errorid"><?php if(array_key_exists('banner_title_error', $form_array)) echo $form_array['banner_title_error'];?></span></td>
                            </tr>
                            <tr>
                                <td height="23" align="right" valign="top" class="admleftBg">Banner Description</td>
                                <td valign="top"><textarea name="banner_desc" id="banner_desc_id" class="txtarea_540x300" onkeydown="chkblnkTxtError('banner_desc_id', 'banner_desc_errorid');" onkeyup="chkblnkTxtError('banner_desc_id', 'banner_desc_errorid');" ><?php if(isset($_POST['banner_desc'])){echo $_POST['banner_desc'];}else{echo $bannerInfo['banner_desc'];}?></textarea><br /><span class="pdError1" id="banner_desc_errorid"><?php if(array_key_exists('banner_desc_error', $form_array)) echo $form_array['banner_desc_error'];?></span></td>
                            </tr>
                            <tr>
                                <td height="23" align="right" valign="top" class="admleftBg">Banner Link</td>
                                <td valign="top"><input type="text" name="banner_link" id="banner_link_id" class="inpuTxt510" value="<?php if(isset($_POST['banner_link'])){echo $_POST['banner_link'];}else{echo $bannerInfo['banner_link'];}?>" onkeydown="chkblnkTxtError('banner_link_id', 'banner_link_errorid');" onkeyup="chkblnkTxtError('banner_link_id', 'banner_link_errorid');" /> &nbsp;<span class="pdError1 pad-lft10" id="banner_link_errorid"> <?php if(array_key_exists('banner_link_error', $form_array)) echo $form_array['banner_link_error'];?></span></td>
                            </tr>
							<?php /*?>
                            <tr>
                                <td height="23" align="right" valign="top" class="admleftBg">Start Date</td>
                                <td valign="top"><input type="text" name="start_date" id="start_date" class="inpuTxt510" value="<?php if(isset($_POST['start_date'])){echo $_POST['start_date'];}?>" style="width:200px;"/>&nbsp;<a href="JavaScript:find_cal(<?php if(isset($dateFromUnix)) {echo $dateFromUnix;} else {echo time();} ?>,'start_date');"><img src="images/calender.gif" alt="calendar" border="0" /></a></td>
                            </tr>
                            <tr>
                                <td height="23" align="right" valign="top" class="admleftBg">End Date</td>
                                <td valign="top"><input type="text" name="end_date" id="end_date" value="<?php if(isset($_POST['end_date'])){echo $_POST['end_date'];}?>" style="width:200px;" />&nbsp;<a href="JavaScript:find_cal(<?php if(isset($dateFromUnix)) {echo $dateFromUnix;} else {echo time();} ?>,'end_date');"><img src="images/calender.gif" alt="calendar" border="0" /></a></td>
                            </tr>
							<?php */?>
                            <tr>
                                <td colspan="2" align="right" valign="top" class="header">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr><td align="right" valign="bottom" colspan="2"><a href="javascript:void(0);" onClick="return validatefrm();" style="text-decoration:none;"><img src="images/saveChangesN.png" alt="Save Approve" width="108" height="21" border="0" /></a></td></tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr><td height="5" colspan="2" valign="top">&nbsp;</td></tr>
            </table>
        </form>
	<?php
	} else {
	?>
		<form name="frmBanner" id="frmBanner" method="post" action="admin-site-variables.php?sec=prom&subsec=add" enctype="multipart/form-data">
			<input type="hidden" name="securityKey" id="securityKey" value="<?php echo md5("ADDBANNER"); ?>">
			<input type="hidden" name="banner_type" id="banner_type" value="1">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
                <tr><td height="5" valign="top">&nbsp;</td></tr>
                <?php if(isset($message) && $message <> ''){?>
                    <tr><td height="5" valign="top"><?php echo $message;?></td></tr>
                <?php }?>
                <tr>
                    <td valign="top">
                        <table width="100%" border="0" cellspacing="0" cellpadding="10" class="eventForm">
                            <tr>
                                <td colspan="2" align="right" valign="top" class="header">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr><td align="right" valign="bottom" colspan="2"><a href="javascript:void(0);" onClick="return validatefrm();" style="text-decoration:none;"><img src="images/saveChangesN.png" alt="Save Approve" width="108" height="21" border="0" /></a></td></tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td height="23" align="right" valign="top" class="admleftBg">Banner Image</td>
                                <td valign="top"><input type="file" name="banner_img" id="banner_img_id">&nbsp;<span class="pdError1 pad-lft10" id="banner_img_errorid"><?php if(array_key_exists('banner_img_error', $form_array)) echo $form_array['banner_img_error'];?></span></td>
                            </tr>
                            <tr>
                                <td height="23" align="right" valign="top" class="admleftBg">Banner Title</td>
                                <td valign="top"><input type="text" name="banner_title" id="banner_title_id" class="inpuTxt510" value="<?php if(isset($_POST['banner_title'])){echo $_POST['banner_title'];}?>" onkeydown="chkblnkTxtError('banner_title_id', 'banner_title_errorid');" onkeyup="chkblnkTxtError('banner_title_id', 'banner_title_errorid');" />&nbsp;<span class="pdError1 pad-lft10" id="banner_title_errorid"><?php if(array_key_exists('banner_title_error', $form_array)) echo $form_array['banner_title_error'];?> </span></td>
                            </tr>
                            <tr>
                                <td height="23" align="right" valign="top" class="admleftBg">Banner Description</td>
                                <td valign="top"><textarea name="banner_desc" id="banner_desc_id" class="txtarea_540x300" onkeydown="chkblnkTxtError('banner_desc_id', 'banner_desc_errorid');" onkeyup="chkblnkTxtError('banner_desc_id', 'banner_desc_errorid');" ><?php if(isset($_POST['banner_desc'])){echo $_POST['banner_desc'];}?></textarea><br /><span class="pdError1" id="banner_desc_errorid"><?php if(array_key_exists('banner_desc_error', $form_array)) echo $form_array['banner_desc_error'];?></span></td>
                            </tr>
                            <tr>
                                <td height="23" align="right" valign="top" class="admleftBg">Banner Link</td>
                                <td valign="top"><input type="text" name="banner_link" id="banner_link_id" class="inpuTxt510" value="<?php if(isset($_POST['banner_link'])){echo $_POST['banner_link'];}?>" onkeydown="chkblnkTxtError('banner_link_id', 'banner_link_errorid');" onkeyup="chkblnkTxtError('banner_link_id', 'banner_link_errorid');" /> &nbsp;<span class="pdError1 pad-lft10" id="banner_link_errorid"> <?php if(array_key_exists('banner_link_error', $form_array)) echo $form_array['banner_link_error'];?></span></td>
                            </tr>
							<?php /*?>
                            <tr>
                                <td height="23" align="right" valign="top" class="admleftBg">Start Date</td>
                                <td valign="top"><input type="text" name="start_date" id="start_date" class="inpuTxt510" value="<?php if(isset($_POST['start_date'])){echo $_POST['start_date'];}?>" style="width:200px;"/>&nbsp;<a href="JavaScript:find_cal(<?php if(isset($dateFromUnix)) {echo $dateFromUnix;} else {echo time();} ?>,'start_date');"><img src="images/calender.gif" alt="calendar" border="0" /></a></td>
                            </tr>
                            <tr>
                                <td height="23" align="right" valign="top" class="admleftBg">End Date</td>
                                <td valign="top"><input type="text" name="end_date" id="end_date" value="<?php if(isset($_POST['end_date'])){echo $_POST['end_date'];}?>" style="width:200px;" />&nbsp;<a href="JavaScript:find_cal(<?php if(isset($dateFromUnix)) {echo $dateFromUnix;} else {echo time();} ?>,'end_date');"><img src="images/calender.gif" alt="calendar" border="0" /></a></td>
                            </tr>
							<?php */?>
                            <tr>
                                <td colspan="2" align="right" valign="top" class="header">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr><td align="right" valign="bottom" colspan="2"><a href="javascript:void(0);" onClick="return validatefrm();" style="text-decoration:none;"><img src="images/saveChangesN.png" alt="Save Approve" width="108" height="21" border="0" /></a></td></tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr><td height="5" valign="top">&nbsp;</td></tr>
            </table>
        </form>
	<?php
	}
} else {
    /*
    * Pagination : Start here
    */
    $page	 = form_int("page",1)+0;
    $sortby  = form_int("sortby",0,0,7);
    $sortdir = form_int("sortdir",0,0,1);
    if (form_isset("reverse")) {
        $sortdir = 1-$sortdir;
    }
    
    switch($sortdir) {
        case 0 : $orderDir = "ASC"; break;
        case 1 : $orderDir = "DESC"; break;
    }
    
    switch($sortby) {
        case 0: $sortField  = "A.banner_id"; $orderDir = "DESC"; break;
        default: $sortField = "A.banner_id"; $orderDir = "DESC"; break;
    }
	/*
	if(isset($_REQUEST['banner_type']) && $_REQUEST['banner_type'] != "") { $banner_type = form_text("banner_type"); $banner_type = stripslashes($banner_type); }
    
	if(isset($banner_type) && $banner_type != "") { $search_query .= "&banner_type=" . html_escapeURL($banner_type); }
	*/

    if(isset($_COOKIE['cook_records_per_page']) && $_COOKIE['cook_records_per_page'] != "") {
        $records_per_page = $_COOKIE['cook_records_per_page'];
    } else {
        $records_per_page = GLOBAL_RECORDS_PER_PAGE;
    }
    
    //$where_clause   		= " WHERE A.banner_type='".$banner_type."'" ;

    $strQueryParameter		= $where_clause." ORDER BY " . $sortField . " " . $orderDir. " LIMIT ".(int)(($page-1)*(int)$records_per_page).", ".$records_per_page;
    $strQueryCountParameter	= $where_clause." ORDER BY " . $sortField . " " . $orderDir;
    
    $rsQuery				= $bannerObj->fun_getBannerArr($strQueryParameter);
    $rsQueryCount			= $bannerObj->fun_getBannerArr($strQueryCountParameter);
    
    $sort_query   = "sortby=" . html_escapeURL($sortby) ."&sortdir=" . html_escapeURL($sortdir);
    
    if($dbObj->getRecordCount($rsQueryCount) > 0) {
        $bannerListArr 			= $dbObj->fetchAssoc($rsQuery);
        $total_banners 			= $dbObj->getRecordCount($rsQueryCount);
        // Determine the pagination
        //	$return_query 		= $search_query."&".$sort_query."&page=$page";
        $return_query 		= $search_query."&page=$page";
        $pag 				= new Pagination($rsQueryCount, $search_query, $records_per_page);
        $pag->current_page 	= $page;
        $pagination  		= $pag->Process();
    ?>
    <script language="javascript" type="text/javascript">
		var req = ajaxFunction();
		var x, y;
		function toggleLayer(whichLayer){
            var output = document.getElementById(whichLayer).innerHTML;
            if(whichLayer == 'ANP-Example') {		
                output = '<div style="z-index:5;">'+output+'</div>';
                var googlewin=dhtmlwindow.open("Example", "inline", output, "", "width=295px,height=470px,resize=0,scrolling=0,center=1,xAxis="+x+",yAxis="+y+"", "recal");
            } else if(whichLayer == 'banner-delete-pop') {		
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
		
		function delBannerItem(){
			closeWindow();
			if(document.getElementById("txtDelItem").value != "") {
				var banner_id = document.getElementById("txtDelItem").value;
				req.onreadystatechange = handleDeleteBannerResponse;
				req.open('get', 'includes/ajax/bannerdeleteXml.php?banner_id='+banner_id); 
				req.send(null);   
			}
		}
		function handleDeleteBannerResponse(){
			if(req.readyState == 4){
				var response = req.responseText;
				xmlDoc = req.responseXML;
				var root = xmlDoc.getElementsByTagName('banners')[0];
				if(root != null){
					var items = root.getElementsByTagName("banner");
					for (var i = 0 ; i < items.length ; i++){
						var item = items[i];
						var bannerstatus = item.getElementsByTagName("bannerstatus")[0].firstChild.nodeValue;
						if(bannerstatus == "banner deleted."){
							window.location = location.href;
						}
					}
				}
			}
		}
	</script>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr><td colspan="2" valign="top" align="right"><a href="admin-site-variables.php?sec=prom&subsec=add">Add Banner</a></td></tr>
        <tr><td colspan="2" valign="top">&nbsp;</td></tr>
        <tr>
            <td valign="top">
                 <strong><?php if(isset($pagination['total_rows']) && $pagination['total_rows'] > 1) { echo "Showing ".$pagination['first_row']." to ".$pagination['last_row']." of ".$pagination['total_rows']." banners";} else if(isset($pagination['total_rows']) && $pagination['total_rows'] == 1){echo "Showing ".$pagination['first_row']." to ".$pagination['last_row']." of ".$pagination['total_rows']." banner";} ?></strong>
            </td>
            <td align="right" valign="top" class="paging">
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
                        echo "<a href=\"".$pagination['next']."\" class=\"next\">&gt;&gt;Next</a>";
                    }
                } else {
                    echo "&nbsp;";
                }
                ?>
            </td>
        </tr>
        <tr><td colspan="2" valign="top">&nbsp;</td></tr>
        <tr>
            <td colspan="2" valign="top">
                <input type="hidden" name="txtDelItem" id="txtDelItem" value="" />
                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EventListing">
                    <thead>
                        <tr>
							<th width="10%" class="left" scope="col" align="center"><div>ID</div></th>
							<th width="25%" class="RollOut" scope="col" align="left"><div>Title</div></th>
							<th width="25%" class="RollOut" scope="col" align="center"><div>Banner</div></th>
                            <th width="25%" class="RollOut" scope="col" align="center"><div>Updated Date</div></th>
							<th width="15%" class="right" scope="col" align="center"><div>Action</div></th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
						for($i=0; $i < count($bannerListArr); $i++){
							$banner_id 			= $bannerListArr[$i]['banner_id'];
							$banner_title  		= $bannerListArr[$i]['banner_title'];
							$banner_img 		= SITE_URL."upload/banners-logos/banners/".$bannerListArr[$i]['banner_img'];
							$banner_update   	= date("M d, Y", $bannerListArr[$i]['updated_on']);
						?>
							<tr>
								<td class="left"><a href="admin-site-variables.php?sec=prom&subsec=edit&banner_id=<?php echo $banner_id;?>"><?php echo fill_zero_left($banner_id, "0", (6-strlen($banner_id)));?></a></td>
								<td><?php echo $banner_title;?></td>
								<td><img src="<?php echo $banner_img;?>" border="0" width="120px"></td>
                                <td><?php echo $banner_update;?></td>
                                <td class="right"><a href="admin-site-variables.php?sec=prom&subsec=edit&banner_id=<?php echo $banner_id;?>" class="link" style="text-decoration:none;">Edit</a>&nbsp;|&nbsp;<a href="javascript:delItem(<?php echo $banner_id; ?>);toggleLayer('banner-delete-pop');" class="removeText">Delete</a></td>
                            </tr>
						<?php }?>
                    </tbody>
                </table>
                <div id="banner-delete-pop" style="display:none; position:absolute; background:transparent; left:300px; top:500px;">
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
                                                        <td class="pad-rgt10 pad-top5"><strong>You want to delete this banner!</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="pad-top10">
                                                            <div class="FloatLft"><a href="javascript:closeWindow();void(0);" ><img src="<?php echo SITE_IMAGES;?>cancel-admin.png" alt="Keep it" /></a></div>
                                                            <div class="FloatLft pad-lft5"><a href="javascript:delBannerItem();"><img src="<?php echo SITE_IMAGES;?>delete.gif" alt="Delete it" onmouseover="this.src='<?php echo SITE_IMAGES; ?>delete_h.gif'" onmouseout="this.src='<?php echo SITE_IMAGES; ?>delete.gif'" /></a></div>
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
	<table width="100%" align="center" cellpadding="3" cellspacing="0">
		<tr><td valign="top" align="right"><a href="admin-site-variables.php?sec=prom&subsec=add">Add Banner</a></td></tr>
		<tr><td>No banner found!!</td></tr>
	</table>
    <?php
    }
}
?>
