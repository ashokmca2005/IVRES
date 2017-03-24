<?php
// Form submision
$form_array 	= array();
$error_msg		= 'no';
$seo_id 		= $_REQUEST['seo_id'];

if($_POST['securityKey'] == md5(ADDSEO)){
	$seo_url 			= $_POST['seo_url'];
	$seo_title 			= $_POST['seo_title'];
	$seo_keywords 		= $_POST['seo_keywords'];
	$seo_description 	= $_POST['seo_description'];
	$seo_id 			= $seoObj->fun_addSeo($seo_url, $seo_title, $seo_keywords, $seo_description);

	if(isset($seo_id) && $seo_id !="") {
		echo "<script>location.href = 'admin-site-variables.php?sec=seo&subsec=edit&seo_id=".$seo_id."';</script>";
	} else {
		echo "<script>location.href = 'admin-site-variables.php?sec=seo';</script>";
	}
}

if($_POST['securityKey'] == md5(EDITSEO)){
	$seo_url 			= $_POST['seo_url'];
	$seo_title 			= $_POST['seo_title'];
	$seo_keywords 		= $_POST['seo_keywords'];
	$seo_description 	= $_POST['seo_description'];
	$seoObj->fun_editSeo($seo_id, $seo_url, $seo_title, $seo_keywords, $seo_description);
	echo "<script>location.href = 'admin-site-variables.php?sec=seo&subsec=edit&seo_id=".$seo_id."';</script>";
}

if(isset($_GET['subsec']) && $_GET['subsec'] !=""){
	if($_GET['subsec'] == 'edit') {
		$seo_id 	= $_REQUEST['seo_id'];
		$seoInfoArr = $seoObj->fun_getSeoInfo($seo_id);
		$addtitle 	= "Edit Meta Info";
		$edit 		= TRUE;
	} else {
		$addtitle 	= "Add Meta Info";
		$edit 		= FALSE;
	}
	?>
	<script language="javascript" type="text/javascript">
        function frmValidateAddSeo() {
            var shwError = false;
            if(document.frmAddSeo.seo_url.value == "") {
                document.getElementById("seo_url_errorid").innerHTML = "Please enter URL";
                document.frmAddSeo.seo_url.focus();
                shwError = true;
            }
    
            if(document.frmAddSeo.seo_title.value == "") {
                document.getElementById("seo_title_errorid").innerHTML = "Please enter title";
                document.frmAddSeo.seo_title.focus();
                shwError = true;
            }
    
            if(document.frmAddSeo.seo_keywords.value == "") {
                document.getElementById("seo_keywords_errorid").innerHTML = "Please enter keywords";
                document.frmAddSeo.seo_keywords.focus();
                shwError = true;
            }
    
            if(document.frmAddSeo.seo_description.value == "") {
                document.getElementById("seo_description_errorid").innerHTML = "Please enter description";
                document.frmAddSeo.seo_description.focus();
                shwError = true;
            }
    
            if(shwError == true) {
                return false;
            } else {
                document.frmAddSeo.submit();
            }
        }
        
        function chkblnkTxtError(strFieldId, strErrorFieldId) {
            if(document.getElementById(strFieldId).value != "") {
                document.getElementById(strErrorFieldId).innerHTML = "";
            }
        }
    </script>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
        <tr>
            <td valign="top" class="SectionSubHead"><?php echo $addtitle;?></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2" valign="top">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
                    <tr>
                        <td valign="top">
                            <!-- main body : Start here -->
                            <form name="frmAddSeo" id="frmAddSeo" action="admin-site-variables.php?sec=seo<?php if($edit == true) { echo "&subsec=edit&seo_id=".$seo_id; } ?>" method="post" >
                            <input type="hidden" name="securityKey" id="securityKey" value="<?php if($edit == true) { echo md5("EDITSEO"); } else { echo md5("ADDSEO"); } ?>">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
                                <tr><td height="5" colspan="2" valign="top">&nbsp;</td></tr>
                                <tr>
                                    <td valign="top"><a href="admin-site-variables.php?sec=seo" class="back">Back to List</a></td>
                                    <td align="right" valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="2" valign="top">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
                                            <tr>
                                                <td valign="top" class="pad-top7">
                                                    <table width="690" border="0" cellspacing="0" cellpadding="0" class="font12">
                                                        <tr>
                                                            <td align="left" valign="top">
                                                                <table width="100%" border="0" cellspacing="0" cellpadding="10" class="eventForm">
                                                                    <tr>
                                                                        <td height="23" align="right" valign="top" class="admleftBg">Url</td>
                                                                        <td valign="top"><input name="seo_url" id="seo_url_id" class="inpuTxt260" value="<?php echo $seoInfoArr['seo_url']; ?>" type="text" /><span class="pdError1 pad-lft10" id="seo_url_errorid"></span></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td height="23" align="right" valign="top" class="admleftBg">Title</td>
                                                                        <td valign="top"><input name="seo_title" id="seo_title_id" class="inpuTxt260" value="<?php echo $seoInfoArr['seo_title']; ?>" type="text" /><span class="pdError1 pad-lft10" id="seo_title_errorid"></span></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td height="23" align="right" valign="top" class="admleftBg">Keywords</td>
                                                                        <td valign="top"><input name="seo_keywords" id="seo_keywords_id" class="inpuTxt260" value="<?php echo $seoInfoArr['seo_keywords']; ?>" type="text" /><span class="pdError1 pad-lft10" id="seo_keywords_errorid"></span></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td height="23" align="right" valign="top" class="admleftBg">Description</td>
                                                                        <td valign="top"><input name="seo_description" id="seo_description_id" class="inpuTxt260" value="<?php echo $seoInfoArr['seo_description']; ?>" type="text" /><span class="pdError1 pad-lft10" id="seo_description_errorid"></span></td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td colspan="2" align="right" valign="top" class="header">
                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                <tr>
                                                                                    <td align="right" valign="bottom" colspan="2">
                                                                                        <a href="admin-site-variables.php?sec=seo" style="text-decoration: none;"><img src="images/cancelN.png" border="0" width="66" height="21" alt="Cancel"></a>&nbsp;<a href="javascript:void(0);" onClick="frmValidateAddSeo();" style="text-decoration:none;"><img src="images/saveApproveN.png" alt="Save Now" width="117" height="21" border="0" /></a>
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
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            </form>
                            <!-- main body : End here -->
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
	<?php
} else {
	if(isset($_GET['sortby']) && $_GET['sortby'] != ""){
		$strQuery = " ORDER BY ";
		switch($_GET['sortby']){
			case 'url':
				if($_GET['dr'] == "1"){
					$dr 				= "ASC";
					$urldr 				= 1;
					$titledr			= 0;
					$updateddr 			= 1;
					$activedr 			= 1;
				} else {
					$dr 				= "DESC";
					$urldr 				= 1;
					$titledr			= 1;
					$updateddr 			= 1;
					$activedr 			= 1;
				}
				$strQuery .= " A.seo_url ".$dr;
			break;
			case 'title':
				if($_GET['dr'] == "1"){
					$dr 				= "ASC";
					$urldr 				= 1;
					$titledr			= 0;
					$updateddr 			= 1;
					$activedr 			= 1;
				} else {
					$dr 				= "DESC";
					$urldr 				= 1;
					$titledr			= 1;
					$updateddr 			= 1;
					$activedr 			= 1;
				}
				$strQuery .= " A.seo_title ".$dr;
			break;
			case 'updated':
				if($_GET['dr'] == "1"){
					$dr 				= "ASC";
					$urldr 				= 1;
					$titledr			= 1;
					$updateddr 			= 1;
					$activedr 			= 1;
				} else {
					$dr 				= "DESC";
					$urldr 				= 1;
					$titledr			= 1;
					$updateddr 			= 1;
					$activedr 			= 1;
				}
				$strQuery .= " A.updated_on ".$dr;
			break;
			case 'active':
				if($_GET['dr'] == "1"){
					$dr 				= "ASC";
					$urldr 				= 1;
					$titledr			= 1;
					$updateddr 			= 1;
					$activedr 			= 1;
				} else {
					$dr 				= "DESC";
					$urldr 				= 1;
					$titledr			= 1;
					$updateddr 			= 1;
					$activedr 			= 1;
				}
				$strQuery .= " A.active ".$dr;
			break;
		}
	} else {
		$urldr 				= 1;
		$titledr			= 1;
		$updateddr 			= 1;
		$activedr 			= 1;
	}

	$seoListArr = $seoObj->fun_getSEOArr($strQuery);
	//print_r($seoListArr);
	if(count($seoListArr) > 0){
	?>
    <script language="javascript" type="text/javascript">
		var req = ajaxFunction();
		var x, y;
		function toggleLayer(whichLayer){
            var output = document.getElementById(whichLayer).innerHTML;
            if(whichLayer == 'ANP-Example') {		
                output = '<div style="z-index:5;">'+output+'</div>';
                var googlewin=dhtmlwindow.open("Example", "inline", output, "", "width=295px,height=470px,resize=0,scrolling=0,center=1,xAxis="+x+",yAxis="+y+"", "recal");
            } else if(whichLayer == 'seo-delete-pop') {		
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
		
		function delSEOItem(){
			closeWindow();
			if(document.getElementById("txtDelItem").value != "") {
				var seo_id = document.getElementById("txtDelItem").value;
				req.onreadystatechange = handleDeletetSEOResponse;
				req.open('get', 'includes/ajax/seodeleteXml.php?seo_id='+seo_id); 
				req.send(null);   
			}
		}
		function handleDeletetSEOResponse(){
			if(req.readyState == 4){
				var response = req.responseText;
				xmlDoc = req.responseXML;
				var root = xmlDoc.getElementsByTagName('seos')[0];
				if(root != null){
					var items = root.getElementsByTagName("seo");
					for (var i = 0 ; i < items.length ; i++){
						var item 	= items[i];
						var seostatus 	= item.getElementsByTagName("seostatus")[0].firstChild.nodeValue;
						if(seostatus == "seo deleted."){
							window.location = location.href;
						}
					}
				}
			}
		}
    </script>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
        <tr>
            <td valign="top" class="SectionSubHead"><?php echo $addtitle;?></td>
            <td>&nbsp;</td>
        </tr>
        <tr><td height="10" colspan="2" valign="top">&nbsp;</td></tr>
        <tr>
            <td valign="top"><a href="admin-site-variables.php?sec=seo&subsec=add" title="Add SEO"><img src="images/add-new.png" width="93" height="23" border="0" alt="Add SEO" /></a></td>
            <td align="right" valign="top">&nbsp;</td>
        </tr>
        <tr><td  colspan="2" valign="top" class="blueBotBorder"><img src="images/spacer.gif" height="8" alt="One" /></td></tr>
        <tr>
            <td colspan="2" valign="top" class="pad-top15">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
                    <tr>
                        <td valign="top" class="pad-top7">
                            <input type="hidden" name="txtDelItem" id="txtDelItem" value="" />
                            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EventListing">
                                <thead>
                                    <tr>
                                        <th width="10%" scope="col" ><div>&nbsp;</div></th>
                                        <th width="25%" scope="col" onMouseOver="this.className = 'RollOver';" onClick="sortList('<?php echo "admin-site-variables.php?sec=seo&sortby=title&dr=".$titledr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "title")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>Title</div></th>
                                        <th width="30%" scope="col" onMouseOver="this.className = 'RollOver';" onClick="sortList('<?php echo "admin-site-variables.php?sec=seo&sortby=url&dr=".$urldr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "url")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?> ><div>URL</div></th>
										<th width="15%" scope="col" onMouseOver="this.className = 'RollOver';" onClick="sortList('<?php echo "admin-site-variables.php?sec=seo&sortby=updated&dr=".$updateddr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "updated")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>Last update</div></th>
										<th width="10%" scope="col" onMouseOver="this.className = 'RollOver';" onClick="sortList('<?php echo "admin-site-variables.php?sec=seo&sortby=active&dr=".$activedr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "active")){echo "class=\"rightOver\" onmouseout=\"this.className = 'rightOver';\" ";}else{echo "onmouseout=\"this.className = 'right';\"";}?>><div>Status</div></th>
                                        <th width="10%" scope="col" class="right" onMouseOver="this.className = 'rightOver';" ><div>Action</div></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                for($i=0; $i < count($seoListArr); $i++){
									$seo_id 			= $seoListArr[$i]['seo_id'];
									$seo_url 			= $seoListArr[$i]['seo_url'];
									$seo_title			= $seoListArr[$i]['seo_title'];
									$updated_on			= date('M d, Y', $seoListArr[$i]['updated_on']);
									$active				= ($seoListArr[$i]['active'] == 1)?"Active":"Not Active";
                                ?>
                                    <tr>
                                        <td><a href="admin-site-variables.php?sec=seo&subsec=edit&seo_id=<?php echo $seo_id;?>">Edit</a></td>
                                        <td><?php echo $seo_title;?></td>
                                        <td><?php echo $seo_url;?></td>
                                        <td><?php echo $updated_on;?></td>
                                        <td><?php echo $active;?></td>
                                        <td class="right" align="center"><a href="javascript:delItem(<?php echo $seo_id ; ?>);toggleLayer('seo-delete-pop');" class="removeText">Delete</a></td>
                                    </tr>
                                <?php
                                }
                                ?>
                                </tbody>
                            </table>
                            <div id="seo-delete-pop" style="display:none; position:absolute; background:transparent; left:300px; top:500px;">
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
                                                                <td class="pad-right10 pad-top5"><strong>You will be delete this SEO info and not be restored!</strong></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="pad-top10">
                                                                    <div class="FloatLft"><a href="javascript:closeWindow();void(0);" ><img src="<?php echo SITE_IMAGES;?>cancel-admin.png" alt="Keep it" /></a></div>
                                                                    <div class="FloatLft pad-lft5"><a href="javascript:delSEOItem();"><img src="<?php echo SITE_IMAGES;?>delete.gif" alt="Delete it" onMouseOver="this.src='<?php echo SITE_IMAGES; ?>delete_h.gif'" onMouseOut="this.src='<?php echo SITE_IMAGES; ?>delete.gif'" /></a></div>
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
                    <tr><td valign="top">&nbsp;</td></tr>
                    <!--
                    <tr>
                        <td valign="top">
                            <table cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td class="paging pad-btm10 pad-left2" align="left" valign="top"><strong>357 Results</strong> </td>
                                    <td class="paging pad-btm10 pad-left2" align="right" valign="top"><a href="#" class="back">Previous</a><a href="#">1</a><a href="#">2</a><a href="#">3</a><span>4</span><a href="#">5</a><a href="#">6</a> ...<a href="#">23</a><a href="#" class="next">Next</a> </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    -->
                </table>
            </td>
        </tr>
    </table>
	<?php
	} else {
	?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
        <tr>
            <td valign="top" class="SectionSubHead"><?php echo $addtitle;?></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td height="10" colspan="2" valign="top">&nbsp;</td>
        </tr>
        <tr>
            <td valign="top"><a href="admin-site-variables.php?sec=seo&subsec=add" title="Add SEO"><img src="images/add-new.png" width="93" height="23" border="0" alt="Add SEO" /></a></td>
            <td align="right" valign="top">&nbsp;</td>
        </tr>
        <tr>
            <td  colspan="2" valign="top" class="blueBotBorder"><img src="images/spacer.gif" height="8" alt="One" /></td>
        </tr>
        <tr>
            <td colspan="2" valign="top" class="pad-top15">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
                    <tr>
                        <td valign="top">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td valign="top">No SEO info added!</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
	<?php
	}
}
?>
