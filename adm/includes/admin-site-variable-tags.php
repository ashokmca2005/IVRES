<?php
// Form submision
$detail_array 	= array();
$error_msg		= 'no';

if($_POST['securityKey']==md5(TAGDELETE)){
	if($_GET['subsec'] == 'edittags') {
		$id = $_GET['tagid'];
		$propertyObj->fun_delTag($id);
		echo "<script> location.href='admin-site-variables.php?sec=tags';</script>";
	}
}

if($_POST['securityKey']==md5(ADDTAG)){
	$tag_name 	= $_POST['txtTagName'];
	$id 		= $propertyObj->fun_getPropertyTagCodeByName($tag_name);
	echo "<script>location.href = 'admin-site-variables.php?sec=tags&subsec=edittags&tagid=".$id."';</script>";
}

if($_POST['securityKey']==md5(EDITTAG)){
	if(isset($_GET['tagid']) && $_GET['tagid'] != "") {
		$id 		= $_GET['tagid'];
		$tag_name 	= $_POST['txtTagName'];
		$propertyObj->fun_edittags($id, $tag_name);
		echo "<script>location.href = 'admin-site-variables.php?sec=tags&subsec=edittags&tagid=".$id."';</script>";
	}
}

?>
<?php
if(isset($_GET['subsec']) && $_GET['subsec'] !=""){
	switch($_GET['subsec']){ // Add edit section for category
	case 'addtags':
	case 'edittags':
		if($_GET['subsec'] == 'edittags') {
			$tagid 			= $_GET['tagid'];
			$tagInfoArr 	= $propertyObj->fun_getTagInfo($tagid);
			$addtitle 		= "Edit tags";
			$edit 			= TRUE;
		} else {
			$addtitle = "Add new tags";
			$edit = FALSE;
		}
	?>
		<script language="javascript" type="text/javascript">
			var req = ajaxFunction();
            function frmValidateAddTag() {
                var shwError = false;
                if(document.frmAddTag.txtTagName.value == "") {
                    document.getElementById("txtTagNameErrorId").innerHTML = "Please enter tag name.";
                    document.frmAddTag.txtTagName.focus();
                    shwError = true;
                }
        
                if(shwError == true) {
                    return false;
                } else {
                    document.frmAddTag.submit();
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
                                <form name="frmAddTag" id="frmAddTag" action="admin-site-variables.php?sec=tags<?php if($edit == true) { echo "&subsec=edittags&tagid=".$tagid; } ?>" method="post" enctype="multipart/form-data" >
                                <input type="hidden" name="securityKey" id="securityKey" value="<?php if($edit == true) { echo md5("EDITTAG"); } else { echo md5("ADDTAG"); } ?>">
                                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
                                    <tr><td height="5" colspan="2" valign="top">&nbsp;</td></tr>
                                    <tr>
                                        <td valign="top"><a href="admin-site-variables.php?sec=tags" class="back">Back to List</a></td>
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
                                                                            <td colspan="2" align="right" valign="top" class="header">
                                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                    <tr>
                                                                                        <td align="right" valign="bottom" colspan="2">
                                                                                            <a href="admin-site-variables.php?sec=tags" style="text-decoration: none;"><img src="images/cancelN.png" alt="Preview" border="0" height="21" width="66"></a>&nbsp;<a href="javascript:void(0);" onclick="frmValidateAddTag();" style="text-decoration:none;"><img src="images/saveApproveN.png" alt="Save & approve" border="0" height="21" width="117"></a>
                                                                                        </td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td height="23" align="right" valign="top" class="admleftBg">tag name</td>
                                                                            <td  valign="top"><input name="txtTagName" id="txtTagNameId" class="inpuTxt260" value="<?php echo $tagInfoArr['tag_name']; ?>" type="text" /><span class="pdError1 pad-lft10" id="txtTagNameErrorId"></span></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="2" align="right" valign="top" class="header">
                                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                    <tr>
                                                                                        <td align="right" valign="bottom" colspan="2">
                                                                                            <a href="admin-site-variables.php?sec=tags" style="text-decoration: none;"><img src="images/cancelN.png" alt="Preview" border="0" height="21" width="66"></a>&nbsp;<a href="javascript:void(0);" onclick="frmValidateAddTag();" style="text-decoration:none;"><img src="images/saveApproveN.png" alt="Save & approve" border="0" height="21" width="117"></a>
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
	break;
	}
} else {
	if(isset($_GET['sortby']) && $_GET['sortby'] != ""){
		$strQuery = " ORDER BY ";
		switch($_GET['sortby']){
			case 'tagid':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$tagiddr 			= 0;
					$tagnamedr			= 1;
					$updateondr 		= 1;
					$createdondr 		= 1;
					$statusdr 			= 1;
				} else {
					$dr = "DESC";
					$tagiddr 			= 1;
					$tagnamedr			= 1;
					$updateondr 		= 1;
					$createdondr 		= 1;
					$statusdr 			= 1;
				}
				$strQuery .= " A.id ".$dr;
			break;
			case 'tagname':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$tagiddr 			= 1;
					$tagnamedr			= 0;
					$updateondr 		= 1;
					$createdondr 		= 1;
					$statusdr 			= 1;
				} else {
					$dr = "DESC";
					$tagiddr 			= 1;
					$tagnamedr			= 1;
					$updateondr 		= 1;
					$createdondr 		= 1;
					$statusdr 			= 1;
				}
				$strQuery .= " A.tag_name ".$dr;
			break;
			case 'updateon':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$tagiddr 			= 1;
					$tagnamedr			= 1;
					$updateondr 		= 0;
					$createdondr 		= 1;
					$statusdr 			= 1;
				} else {
					$dr = "DESC";
					$tagiddr 			= 1;
					$tagnamedr			= 1;
					$updateondr 		= 1;
					$createdondr 		= 1;
					$statusdr 			= 1;
				}
				$strQuery .= " A.updated_on ".$dr;
			break;
			case 'createdon':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$tagiddr 			= 1;
					$tagnamedr			= 1;
					$updateondr 		= 1;
					$createdondr 		= 0;
					$statusdr 			= 1;
				} else {
					$dr = "DESC";
					$tagiddr 			= 1;
					$tagnamedr			= 1;
					$updateondr 		= 1;
					$createdondr 		= 1;
					$statusdr 			= 1;
				}
				$strQuery .= " A.created_on ".$dr;
			break;
			case 'status':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$tagiddr 			= 1;
					$tagnamedr			= 1;
					$updateondr 		= 1;
					$createdondr 		= 1;
					$statusdr 			= 0;
				} else {
					$dr = "DESC";
					$tagiddr 			= 1;
					$tagnamedr			= 1;
					$updateondr 		= 1;
					$createdondr 		= 1;
					$statusdr 			= 1;
				}
				$strQuery .= " A.status ".$dr;
			break;
		}
	}
	else{
		$tagiddr 			= 1;
		$tagnamedr			= 1;
		$updateondr 		= 1;
		$createdondr 		= 1;
		$statusdr 			= 1;
	}
	//echo $strQuery;
	$tagListArr = $propertyObj->fun_getCollateralTagsArr($strQuery);
	//print_r($tagListArr);
	if(count($tagListArr) > 0){
	?>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
            <tr>
                <td valign="top" class="SectionSubHead"><?php echo $addtitle;?></td>
                <td>&nbsp;</td>
            </tr>
            <tr><td height="10" colspan="2" valign="top">&nbsp;</td></tr>
    
    <?php /*?>
            <tr>
                <td valign="top" style="display:none;"><a href="admin-site-variables.php?sec=tags&subsec=addcat" title="Add Travel Category"><img src="images/add-edit-category.png" width="140" height="22" alt="Add Category" /></a>&nbsp;<a href="admin-site-variables.php?sec=tags&subsec=addtvlguid" title="Add Resources"><img src="images/add-new-guide.png" alt="Add Travel Guide" width="122" height="22" /></a></td>
                <td align="right" valign="top">
                    <form name="frmSearchTvl" id="frmSearchTvl" action="admin-site-variables.php?sec=tags" method="post">
                    <table border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td class="blackTxt14 pad-rgt5">Search </td>
                            <td class="pad-rgt5"><input name="txtSearchTvlGuid" id="txtSearchtagid" type="text" class="Textfield210" value="Enter reference" onclick="return bnkTvlGuidSearch();" onblur="return restoreTvlGuidSearch();" autocomplete="off" /></td>
                            <td><a href="#"><img src="images/search-btn.gif" alt="Send"/></a></td>
                        </tr>
                    </table>
                    </form>
                </td>
            </tr>
    
    <?php */?>        
            <tr><td  colspan="2" valign="top" class="blueBotBorder"><img src="images/spacer.gif" height="8" alt="One" /></td></tr>
            <tr>
                <td colspan="2" valign="top" class="pad-top15">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
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
                        <tr>
                            <td valign="top" class="pad-top7">
                                <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EventListing">
                                    <thead>
                                        <tr>
                                            <th width="25%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-site-variables.php?sec=tags&sortby=tagid&dr=".$tagiddr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "tagid")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?> ><div>id</div></th>
                                            <th width="40%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-site-variables.php?sec=tags&sortby=tagname&dr=".$tagnamedr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "tagname")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>Name</div></th>
                                            <th width="20%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-site-variables.php?sec=tags&sortby=updateon&dr=".$updateondr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "updateon")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>Last updated</div></th>
                                            <th width="15%" scope="col" class="right" onmouseover="this.className = 'rightOver';" onclick="sortList('<?php echo "admin-site-variables.php?sec=tags&sortby=createdon&dr=".$createdondr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "createdon")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>Added Date</div></th>
    <?php /*?>
                                            <th width="15%" scope="col" class="right" onmouseover="this.className = 'rightOver';" onclick="sortList('<?php echo "admin-site-variables.php?sec=tags&sortby=status&dr=".$statusdr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "status")){echo "class=\"rightOver\" onmouseout=\"this.className = 'rightOver';\" ";}else{echo "onmouseout=\"this.className = 'right';\"";}?>><div>Status</div></th>
    <?php */?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    for($i=0; $i < count($tagListArr); $i++){
                                    $id 				= $tagListArr[$i]['id'];
                                    $tag_name 			= $tagListArr[$i]['tag_name'];
                                    $created_on 		= date('M d, Y', $tagListArr[$i]['created_on']);
                                    $updated_on 		= date('M d, Y', $tagListArr[$i]['updated_on']);
                                    ?>
                                        <tr>
                                            <td class="left"><?php echo fill_zero_left($id, "0", (6-strlen($id)));?></td>
                                            <td><a href="admin-site-variables.php?sec=tags&subsec=edittags&tagid=<?php echo $id;?>"><?php echo $tag_name;?></a></td>
                                            <td><?php echo $updated_on;?></td>
                                            <td class="right"><?php echo $created_on;?></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr><td valign="top">&nbsp;</td></tr>
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

<?php /*?>
            <tr>
                <td valign="top"><a href="admin-site-variables.php?sec=tags&subsec=addtag" title="Add Taravel Category"><img src="images/add-edit-category.png" width="140" height="22" alt="Add Category" /></a>&nbsp;<a href="admin-site-variables.php?sec=tags&subsec=addtvlguid" title="Add Travel Guide"><img src="images/add-new-guide.png" alt="Add Travel Guide" width="122" height="22" /></a></td>
                <td align="right" valign="top">&nbsp;</td>
            </tr>
<?php */?>
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
                                        <td valign="top">No Tag Added!</td>
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
