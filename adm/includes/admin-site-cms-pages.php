<?php
if(isset($_GET['sec']) && $_GET['sec'] !="") {
	?>
	<script type="text/javascript" language="javascript">
	function chkblnkTxtError(strFieldId, strErrorFieldId){
		if(document.getElementById(strFieldId).value != ""){
		  document.getElementById(strErrorFieldId).innerHTML = "";
		}
	}
	
	function validatefrm(){
		var alreadyFocussed = false;
		document.frmPage.page_discription_id.value = tinyMCE.get('page_discription_id').getContent();
	
		if(document.getElementById("page_title_id").value == "") {
			document.getElementById("page_title_errorid").innerHTML = "Page title required";
			document.getElementById("page_title_id").focus();
			return false;
		}
	
		if(document.getElementById("page_content_title_id").value == "") {
			document.getElementById("page_content_title_errorid").innerHTML = "Page content title required";
			document.getElementById("page_content_title_id").focus();
			return false;
		}
	
	
		if(document.getElementById("page_seo_title_id").value == "") {
			document.getElementById("page_seo_title_errorid").innerHTML = "SEO title required";
			document.getElementById("page_seo_title_id").focus();
			return false;
		}
	
		if(document.getElementById("page_seo_keyword_id").value == "") {
			document.getElementById("page_seo_keyword_errorid").innerHTML = "SEO keyword required";
			document.getElementById("page_seo_keyword_id").focus();
			return false;
		}
	
		if(document.getElementById("page_seo_discription_id").value == "") {
			document.getElementById("page_seo_discription_errorid").innerHTML = "SEO discription required";
			document.getElementById("page_seo_discription_id").focus();
			return false;
		}
	
		if(document.frmPage.page_discription_id.value == "") {
			document.getElementById("page_discription_errorid").innerHTML = "Page description required";
			document.getElementById("page_discription_id").focus();
			if(!alreadyFocussed){
				document.frmPage.page_discription_id.focus();
				alreadyFocussed = true;
			}
			return false;
		}
	
		document.frmPage.submit();
	}
	</script>
	<!-- TinyMCE -->
	<script type="text/javascript" src="../tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
	<script type="text/javascript">
		tinyMCE.init({
			mode : "exact",
			elements : "page_discription_id",
			theme : "advanced",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			plugins : 'advlink,advimage',
			relative_urls : false,
			remove_script_host : false
			
		});
	
		function myHandleEvent(e){
			if(e.type=="keyup"){
				chkblnkEditorTxtError("page_discription_id", "page_discription_errorid");	
			}
			return true;
		}
	</script>
	<!-- /TinyMCE -->
	<?php
	if(isset($page_id) && $page_id !=""){
		$pageInfo 	    = $cmsObj->fun_getPageInfo($page_id);
		$page_type 		= $pageInfo['page_type'];
		?>
		<form name="frmPage" id="frmPage" method="post" action="admin-site-cms.php?page_type=<?php echo $page_type;?>&sec=edit&page_id=<?php echo $page_id;?>">
			<input type="hidden" name="securityKey" id="securityKey" value="<?php echo md5("EDITPAGE"); ?>">
			<input type="hidden" name="page_id" id="page_id" value="<?php echo $page_id; ?>">
			<input type="hidden" name="page_type" id="page_type" value="<?php echo $page_type; ?>">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
                <tr><td height="5" colspan="2" valign="top">&nbsp;</td></tr>
                <?php if(isset($message) && $message <> ''){?>
                    <tr><td height="5" colspan="2" valign="top"><?php echo $message;?></td></tr>
                <?php }?>
                <tr>
                    <td colspan="2" valign="top">
                        <table width="100%" border="0" cellspacing="0" cellpadding="10" class="eventForm">
                            <tr>
                                <td colspan="2" align="right" valign="top" class="header">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr><td align="right" valign="bottom" colspan="2"><a href="javascript:void(0);" onClick="validatefrm();" style="text-decoration:none;"><img src="images/saveChangesN.png" alt="Save Approve" width="108" height="21" border="0" /></a></td></tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td height="23" align="right" valign="top" class="admleftBg">Page Title</td>
                                <td valign="top"><input type="text" name="page_title" id="page_title_id" class="inpuTxt510" value="<?php if(isset($_POST['page_title'])){echo $_POST['page_title'];}else{echo $pageInfo['page_title'];}?>" onkeydown="chkblnkTxtError('page_title_id', 'page_title_errorid');" onkeyup="chkblnkTxtError('page_title_id', 'page_title_errorid');" />&nbsp;<span class="pdError1 pad-lft10" id="page_title_errorid"><?php if(array_key_exists('page_title_error', $form_array)) echo $form_array['page_title_error'];?> </span></td>
                            </tr>
                            <tr>
                                <td height="23" align="right" valign="top" class="admleftBg">Page Content Title</td>
                                <td valign="top"><input type="text" name="page_content_title" id="page_content_title_id" class="inpuTxt510" value="<?php if(isset($_POST['page_content_title'])){echo $_POST['page_content_title'];}else{echo $pageInfo['page_content_title'];}?>" onkeydown="chkblnkTxtError('page_content_title_id', 'page_content_title_errorid');" onkeyup="chkblnkTxtError('page_content_title_id', 'page_content_title_errorid');" />&nbsp;<span class="pdError1 pad-lft10" id="page_content_title_errorid"><?php if(array_key_exists('page_content_title_error', $form_array)) echo $form_array['page_content_title_error'];?> </span></td>
                            </tr>
                            <tr>
                                <td height="23" align="right" valign="top" class="admleftBg">SEO Title</td>
                                <td valign="top"><input type="text" name="page_seo_title" id="page_seo_title_id" class="inpuTxt510" value="<?php if(isset($_POST['page_seo_title'])){echo $_POST['page_seo_title'];}else{echo $pageInfo['page_seo_title'];}?>" onkeydown="chkblnkTxtError('page_seo_title_id', 'page_seo_title_errorid');" onkeyup="chkblnkTxtError('page_seo_title_id', 'page_seo_title_errorid');" />&nbsp;<span class="pdError1 pad-lft10" id="page_seo_title_errorid"><?php if(array_key_exists('page_seo_title_error', $form_array)) echo $form_array['page_seo_title_error'];?> </span></td>
                            </tr>
                            <tr>
                                <td height="23" align="right" valign="top" class="admleftBg">SEO Keyword</td>
                                <td valign="top"><input type="text" name="page_seo_keyword" id="page_seo_keyword_id" class="inpuTxt510" value="<?php if(isset($_POST['page_seo_keyword'])){echo $_POST['page_seo_keyword'];}else{echo $pageInfo['page_seo_keyword'];}?>" onkeydown="chkblnkTxtError('page_seo_keyword_id', 'page_seo_keyword_errorid');" onkeyup="chkblnkTxtError('page_seo_keyword_id', 'page_seo_keyword_errorid');" />&nbsp;<span class="pdError1 pad-lft10" id="page_seo_keyword_errorid"><?php if(array_key_exists('page_seo_keyword_error', $form_array)) echo $form_array['page_seo_keyword_error'];?> </span></td>
                            </tr>
                            <tr>
                                <td height="23" align="right" valign="top" class="admleftBg">SEO Description</td>
                                <td valign="top"><input type="text" name="page_seo_discription" id="page_seo_discription_id" class="inpuTxt510" value="<?php if(isset($_POST['page_seo_discription'])){echo $_POST['page_seo_discription'];}else{echo $pageInfo['page_seo_discription'];}?>" onkeydown="chkblnkTxtError('page_seo_discription_id', 'page_seo_discription_errorid');" onkeyup="chkblnkTxtError('page_seo_discription_id', 'page_seo_discription_errorid');" />&nbsp;<span class="pdError1 pad-lft10" id="page_seo_discription_errorid"><?php if(array_key_exists('page_seo_discription_error', $form_array)) echo $form_array['page_seo_discription_error'];?> </span></td>
                            </tr>
                            <tr>
                                <td height="23" align="right" valign="top" class="admleftBg">Page Discription</td>
                                <td valign="top"><textarea type="text" name="page_discription" id="page_discription_id" class="txtarea_540x300" onkeydown="chkblnkTxtError('page_discription_id', 'page_discription_errorid');" onkeyup="chkblnkTxtError('page_discription_id', 'page_discription_errorid');" /><?php if(isset($_POST['page_discription'])){echo $_POST['page_discription'];}else{echo $pageInfo['page_discription'];}?></textarea> &nbsp;<span class="pdError1 pad-lft10" id="page_discription_errorid"> <?php if(array_key_exists('page_discription_error', $form_array)) echo $form_array['page_discription_error'];?></span></td>
                            </tr>
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
		<form name="frmPage" id="frmPage" method="post" action="admin-site-cms.php?page_type=1&sec=add">
			<input type="hidden" name="securityKey" id="securityKey" value="<?php echo md5("ADDPAGE"); ?>">
			<input type="hidden" name="page_type" id="page_type" value="1">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
                <tr><td height="5" colspan="2" valign="top">&nbsp;</td></tr>
                <?php if(isset($message) && $message <> ''){?>
                    <tr><td height="5" colspan="2" valign="top"><?php echo $message;?></td></tr>
                <?php }?>
                <tr>
                    <td colspan="2" valign="top">
                        <table width="100%" border="0" cellspacing="0" cellpadding="10" class="eventForm">
                            <tr>
                                <td colspan="2" align="right" valign="top" class="header">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr><td align="right" valign="bottom" colspan="2"><a href="javascript:void(0);" onClick="validatefrm();" style="text-decoration:none;"><img src="images/saveChangesN.png" alt="Save Approve" width="108" height="21" border="0" /></a></td></tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td height="23" align="right" valign="top" class="admleftBg">Page Title</td>
                                <td valign="top"><input type="text" name="page_title" id="page_title_id" class="inpuTxt510" value="<?php if(isset($_POST['page_title'])){echo $_POST['page_title'];}?>" onkeydown="chkblnkTxtError('page_title_id', 'page_title_errorid');" onkeyup="chkblnkTxtError('page_title_id', 'page_title_errorid');" />&nbsp;<span class="pdError1 pad-lft10" id="page_title_errorid"><?php if(array_key_exists('page_title_error', $form_array)) echo $form_array['page_title_error'];?> </span></td>
                            </tr>
                            <tr>
                                <td height="23" align="right" valign="top" class="admleftBg">Page Content Title</td>
                                <td valign="top"><input type="text" name="page_content_title" id="page_content_title_id" class="inpuTxt510" value="<?php if(isset($_POST['page_content_title'])){echo $_POST['page_content_title'];}?>" onkeydown="chkblnkTxtError('page_content_title_id', 'page_content_title_errorid');" onkeyup="chkblnkTxtError('page_content_title_id', 'page_content_title_errorid');" />&nbsp;<span class="pdError1 pad-lft10" id="page_content_title_errorid"><?php if(array_key_exists('page_content_title_error', $form_array)) echo $form_array['page_content_title_error'];?> </span></td>
                            </tr>
                            <tr>
                                <td height="23" align="right" valign="top" class="admleftBg">SEO Title</td>
                                <td valign="top"><input type="text" name="page_seo_title" id="page_seo_title_id" class="inpuTxt510" value="<?php if(isset($_POST['page_seo_title'])){echo $_POST['page_seo_title'];}?>" onkeydown="chkblnkTxtError('page_seo_title_id', 'page_seo_title_errorid');" onkeyup="chkblnkTxtError('page_seo_title_id', 'page_seo_title_errorid');" />&nbsp;<span class="pdError1 pad-lft10" id="page_seo_title_errorid"><?php if(array_key_exists('page_seo_title_error', $form_array)) echo $form_array['page_seo_title_error'];?> </span></td>
                            </tr>
                            <tr>
                                <td height="23" align="right" valign="top" class="admleftBg">SEO Keyword</td>
                                <td valign="top"><input type="text" name="page_seo_keyword" id="page_seo_keyword_id" class="inpuTxt510" value="<?php if(isset($_POST['page_seo_keyword'])){echo $_POST['page_seo_keyword'];}?>" onkeydown="chkblnkTxtError('page_seo_keyword_id', 'page_seo_keyword_errorid');" onkeyup="chkblnkTxtError('page_seo_keyword_id', 'page_seo_keyword_errorid');" />&nbsp;<span class="pdError1 pad-lft10" id="page_seo_keyword_errorid"><?php if(array_key_exists('page_seo_keyword_error', $form_array)) echo $form_array['page_seo_keyword_error'];?> </span></td>
                            </tr>
                            <tr>
                                <td height="23" align="right" valign="top" class="admleftBg">SEO Description</td>
                                <td valign="top"><input type="text" name="page_seo_discription" id="page_seo_discription_id" class="inpuTxt510" value="<?php if(isset($_POST['page_seo_discription'])){echo $_POST['page_seo_discription'];}?>" onkeydown="chkblnkTxtError('page_seo_discription_id', 'page_seo_discription_errorid');" onkeyup="chkblnkTxtError('page_seo_discription_id', 'page_seo_discription_errorid');" />&nbsp;<span class="pdError1 pad-lft10" id="page_seo_discription_errorid"><?php if(array_key_exists('page_seo_discription_error', $form_array)) echo $form_array['page_seo_discription_error'];?> </span></td>
                            </tr>
                            <tr>
                                <td height="23" align="right" valign="top" class="admleftBg">Page Discription</td>
                                <td valign="top"><textarea type="text" name="page_discription" id="page_discription_id" class="txtarea_540x300" onkeydown="chkblnkTxtError('page_discription_id', 'page_discription_errorid');" onkeyup="chkblnkTxtError('page_discription_id', 'page_discription_errorid');" /><?php if(isset($_POST['page_discription'])){echo $_POST['page_discription'];}?></textarea> &nbsp;<span class="pdError1 pad-lft10" id="page_discription_errorid"> <?php if(array_key_exists('page_discription_error', $form_array)) echo $form_array['page_discription_error'];?></span></td>
                            </tr>
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
        case 0: $sortField  = "A.updated_on"; $orderDir = "DESC"; break;
        default: $sortField = "A.updated_on"; $orderDir = "DESC"; break;
    }
	if(isset($_REQUEST['page_type']) && $_REQUEST['page_type'] != "") { $page_type = form_text("page_type"); $page_type = stripslashes($page_type); }
    
	if(isset($page_type) && $page_type != "") { $search_query .= "&page_type=" . html_escapeURL($page_type); }

    if(isset($_COOKIE['cook_records_per_page']) && $_COOKIE['cook_records_per_page'] != "") {
        $records_per_page = $_COOKIE['cook_records_per_page'];
    } else {
        $records_per_page = GLOBAL_RECORDS_PER_PAGE;
    }
    
    $where_clause   		= " WHERE A.page_type='".$page_type."'" ;

    $strQueryParameter		= $where_clause." ORDER BY " . $sortField . " " . $orderDir. " LIMIT ".(int)(($page-1)*(int)$records_per_page).", ".$records_per_page;
    $strQueryCountParameter	= $where_clause." ORDER BY " . $sortField . " " . $orderDir;
    
    $rsQuery				= $cmsObj->fun_getPageArr($strQueryParameter);
    $rsQueryCount			= $cmsObj->fun_getPageArr($strQueryCountParameter);
    
    $sort_query   = "sortby=" . html_escapeURL($sortby) ."&sortdir=" . html_escapeURL($sortdir);
    
    if($dbObj->getRecordCount($rsQueryCount) > 0) {
    
        $pageListArr 			= $dbObj->fetchAssoc($rsQuery);
        $total_pages 			= $dbObj->getRecordCount($rsQueryCount);
        // Determine the pagination
        //	$return_query 		= $search_query."&".$sort_query."&page=$page";
        $return_query 		= $search_query."&page=$page";
        $pag 				= new Pagination($rsQueryCount, $search_query, $records_per_page);
        $pag->current_page 	= $page;
        $pagination  		= $pag->Process();
    ?>
    <script language="javascript" type="text/javascript">
		var req = ajaxFunction();
		function delItem(strId) {
			document.getElementById("txtDelItem").value = strId;
		}
		function delPageItem(){
			closeWindow();
			if(document.getElementById("txtDelItem").value != "") {
				var page_id = document.getElementById("txtDelItem").value;
				req.onreadystatechange = handleDeletetPageResponse;
				req.open('get', 'includes/ajax/pagedeleteXml.php?page_id='+page_id); 
				req.send(null);   
			}
		}

		function handleDeletetPageResponse(){
			if(req.readyState == 4){
				var response = req.responseText;
				xmlDoc = req.responseXML;
				var root = xmlDoc.getElementsByTagName('pages')[0];
				if(root != null){
					var items = root.getElementsByTagName("page");
					for (var i = 0 ; i < items.length ; i++){
						var item 				= items[i];
						var pagestatus 		= item.getElementsByTagName("pagestatus")[0].firstChild.nodeValue;
						if(pagestatus == "page deleted."){
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
            <td valign="top">
                 <strong><?php if(isset($pagination['total_rows']) && $pagination['total_rows'] > 1) { echo "Showing ".$pagination['first_row']." to ".$pagination['last_row']." of ".$pagination['total_rows']." pages";} else if(isset($pagination['total_rows']) && $pagination['total_rows'] == 1){echo "Showing ".$pagination['first_row']." to ".$pagination['last_row']." of ".$pagination['total_rows']." page";} ?></strong>
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
                            <th width="10%" class="left" scope="col"><div>Page Id</div></th>
                            <th width="50%" class="RollOut" scope="col" align="left"><div>Title</div></th>
                            <th width="20%" class="RollOut" scope="col" align="center"><div>Last updates</div></th>
                            <th width="20%" class="right" scope="col"><div>Action</div></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        for($i=0; $i < count($pageListArr); $i++) {
                            $page_id     	= $pageListArr[$i]['page_id'];
                            $page_title 	= $pageListArr[$i]['page_title'];
                            $page_type 		= $pageListArr[$i]['page_type'];
                            $active 		= $pageListArr[$i]['active'];
                            $updated_on 	= date("Y-d-m", $pageListArr[$i]['updated_on']);
                        ?>
                            <tr>
                                <td class="left"><?php echo fill_zero_left($page_id, "0", (6-strlen($page_id)));?></td>
                                <td align="left"><?php echo $page_title;?></td>
                                <td align="center"><?php echo $updated_on;?></td>
                                <td class="right" align="center">
                                <a href="admin-site-cms.php?page_type=<?php echo $page_type; ?>&sec=edit&page_id=<?php echo $page_id; ?>" class="link" style="text-decoration:none;">Edit</a>
								<?php
                                if(isset($page_type) && $page_type == '1') {
                                ?>
                                &nbsp;|&nbsp;<a href="javascript:delItem(<?php echo $page_id; ?>);toggleLayer('page-delete-pop');" class="removeText">Delete</a>
								<?php
                                }
                                ?>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
                <div id="page-delete-pop" style="display:none; position:absolute; background:transparent; left:300px; top:500px;">
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
                                                        <td class="pad-rgt10 pad-top5"><strong>You want to delete this page!</strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="pad-top10">
                                                            <div class="FloatLft"><a href="javascript:closeWindow();void(0);" ><img src="<?php echo SITE_IMAGES;?>cancel-admin.png" alt="Keep it" /></a></div>
                                                            <div class="FloatLft pad-lft5"><a href="javascript:delPageItem();"><img src="<?php echo SITE_IMAGES;?>delete.gif" alt="Delete it" onmouseover="this.src='<?php echo SITE_IMAGES; ?>delete_h.gif'" onmouseout="this.src='<?php echo SITE_IMAGES; ?>delete.gif'" /></a></div>
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
        <tr>
            <td valign="top">No page available!</td>
        </tr>
    </table>
    <?php
    }
}
?>
