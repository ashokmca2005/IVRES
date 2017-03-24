<?php
if(isset($_REQUEST['del_id']) && $_REQUEST['del_id'] <> ''){
	$banner_id 		= $_REQUEST['del_id'];
	$banner_info 	= $bannerObj->fun_get_newBannerInfo($banner_id);
	$banner_image 	= $banner_info[0]['banner_name'];
	@unlink("../upload/banners-logos/banners/".$banner_image);
	@unlink("../upload/banners-logos/banners/120x60/".$banner_image);
	@unlink("../upload/banners-logos/banners/200x200/".$banner_image);
	@unlink("../upload/banners-logos/banners/468x60/".$banner_image);
	@unlink("../upload/banners-logos/banners/562x332/".$banner_image);
	$bannerObj->fun_del_newBanner($banner_id);
}
$bannerArr = $bannerObj->fun_get_newBannerArr();
$total_num_of_record = count($bannerArr);
?>
<?php if($total_num_of_record > 0){?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr><td colspan="2" valign="top" align="right"><a href="admin-site-variables.php?sec=banneradd" style="color:#666666;">Add Banner</a></td></tr>
		<tr><td colspan="2" valign="top">&nbsp;</td></tr>
		<tr>
			<td colspan="2" valign="top">
				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EventListing">
					<thead>
						<tr>
							<th width="10%" scope="col" onMouseOver="this.className = 'RollOver';" onClick="sortList('<?php echo "admin-site-variables.php?sec=ptype&sortby=site_variables_code&dr=".$featurecodedr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "property_features_id")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?> ><div>ID</div></th>
							<th width="25%" scope="col" onMouseOver="this.className = 'RollOver';" onClick="sortList('<?php echo "admin-site-variables.php?sec=ptype&sortby=site_variables_name&dr=".$featuretitledr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "resourcecat")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?> ><div>Caption</div></th>
							<th width="25%" scope="col" onMouseOver="this.className = 'RollOver';" onClick="sortList('<?php echo "admin-site-variables.php?sec=ptype&sortby=site_variables_created&dr=".$featureaddeddatedr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "resourceaddeddate")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>Image</div></th>
							<th width="25%" scope="col" onMouseOver="this.className = 'RollOver';" onClick="sortList('<?php echo "admin-site-variables.php?sec=ptype&sortby=site_variables_updated&dr=".$featureupdatedr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "evnttitle")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>Updated Date</div></th>
							<th width="15%" scope="col" class="right" onMouseOver="this.className = 'rightOver';" onClick="sortList('<?php echo "admin-site-variables.php?sec=ptype&sortby=site_variables_status&dr=".$featurestatusdr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "resourcestatus")){echo "class=\"rightOver\" onmouseout=\"this.className = 'rightOver';\" ";}else{echo "onmouseout=\"this.className = 'right';\"";}?>><div>Delete</div></th>
						</tr>
					</thead>
					<tbody>
						<?php
						for($i=0; $i < count($bannerArr); $i++){
							$banner_id 			= $bannerArr[$i]['banner_id'];
							$banner_name 		= SITE_URL."upload/banners-logos/banners/".$bannerArr[$i]['banner_name'];
							$banner_caption  	= $bannerArr[$i]['banner_caption'];
							$banner_link   		= $bannerArr[$i]['banner_link'];
							$banner_update   	= date("M d, Y", $bannerArr[$i]['updated_on']);
							?>
							<tr>
								<td class="left"><?php echo fill_zero_left($banner_id, "0", (6-strlen($banner_id)));?></td>
								<td><?php echo $banner_caption;?></td>
								<td><a href="<?php echo $banner_link;?>" title="Link--<?php echo $banner_link;?>"><img src="<?php echo $banner_name;?>" border="0" width="120px"></a></td>
								<td><?php echo $banner_update;?></td>
								<td class="right"><a href="admin-site-variables.php?sec=banner&del_id=<?php echo $banner_id;?>" onClick="javascript: alert('Are you sure you want to delete this banner!!');"><img src="../images/delete-admin.gif" border="0"></a></td>
							</tr>
						<?php }?>
					</tbody>
				</table>
			</td>
		</tr>
		<tr><td colspan="2" valign="top">&nbsp;</td></tr>
	</table>
<?php }else{?>
	<table width="100%" align="center" cellpadding="3" cellspacing="0">
		<tr><td valign="top" align="right"><a href="admin-site-variables.php?sec=banneradd" style="color:#666666;">Add Banner</a></td></tr>
		<tr><td>No banner found!!</td></tr>
	</table>
<?php }?>