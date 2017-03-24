<?php
	if(isset($_GET['sortby']) && $_GET['sortby'] != "") {
		$strQuery = " ORDER BY ";
		switch($_GET['sortby']){
			case 'regionid':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$regioniddr 	= 0;
					$regionnamedr	= 1;
					$regionlatdr 	= 1;
					$regionlondr 	= 1;
				} else {
					$dr = "DESC";
					$regioniddr 	= 1;
					$regionnamedr	= 1;
					$regionlatdr 	= 1;
					$regionlondr 	= 1;
				}
				$strQuery .= " A.region_id ".$dr;
			break;
			case 'regionname':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$regioniddr 	= 1;
					$regionnamedr	= 0;
					$regionlatdr 	= 1;
					$regionlondr 	= 1;
				} else {
					$dr = "DESC";
					$regioniddr 	= 1;
					$regionnamedr	= 1;
					$regionlatdr 	= 1;
					$regionlondr 	= 1;
				}
				$strQuery .= " A.region_name ".$dr;
			break;
			case 'regionlat':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$regioniddr 	= 1;
					$regionnamedr	= 1;
					$regionlatdr 	= 0;
					$regionlondr 	= 1;
				} else {
					$dr = "DESC";
					$regioniddr 	= 1;
					$regionnamedr	= 1;
					$regionlatdr 	= 1;
					$regionlondr 	= 1;
				}
				$strQuery .= " A.latitude ".$dr;
			break;
			case 'regionlon':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$regioniddr 	= 1;
					$regionnamedr	= 1;
					$regionlatdr 	= 1;
					$regionlondr 	= 0;
				} else {
					$dr = "DESC";
					$regioniddr 	= 1;
					$regionnamedr	= 1;
					$regionlatdr 	= 1;
					$regionlondr 	= 1;
				}
				$strQuery .= " A.longitude ".$dr;
			break;
		}
	} else {
		$strQuery 	= "";
		$regioniddr 	= 1;
		$regionnamedr	= 1;
		$regionlatdr 	= 1;
		$regionlondr 	= 1;
	}
	$regionListArr = $locationObj->fun_getRegionsArr($area_id, $strQuery);
	if(is_array($regionListArr) && count($regionListArr) > 0){
	?>
		<script language="javascript" type="text/javascript">
		/* --------- Script for sort list links : start here ----------- */
		function sortList(str){
			location.href = str;
		}
		/* --------- Script for sort list links : end here ----------- */
		function confirmDel(id) {
			if(confirm("Do you want to delete this region!\n Make sure it is not used anywhere!")) {
				document.frmAddRegion.txtRegionId.value = id;
				document.getElementById("frmAddRegion").submit();
			} else {
				return false;
			}
		}
		</script>
		<form name="frmAddRegion" id="frmAddRegion" action="admin-site-variables.php?sec=manloca" method="post">
			<input type="hidden" name="securityKey" id="securityKey" value="<?php echo md5("DELREGION"); ?>">
			<input type="hidden" name="txtRegionId" id="txtRegionId" value="">
		</form>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td valign="top" class="SectionSubHead"><?php echo $addtitle;?></td>
				<td>&nbsp;</td>
			</tr>
			<tr><td colspan="2" valign="top">&nbsp;</td></tr>
			<tr>
				<td valign="top"><a href="admin-site-variables.php?sec=manloca&show=area&countryid=<?php echo $country_id; ?>" class="back">Back to Region/State List</a></td>
				<td align="right" valign="top"><a href="admin-site-variables.php?sec=manloca&action=add&show=region&areaid=<?php echo $area_id;?>" class="back">Add a new Area/City</a></td>
			</tr>
			<tr>
				<td colspan="2" valign="top" class="pad-top5">
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EventListing">
						<thead>
							<tr>
								<th width="15%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-site-variables.php?sec=manloca&sortby=regionid&dr=".$regioniddr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "regionid")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?> ><div>Region ID</div></th>
								<th width="35%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-site-variables.php?sec=manloca&sortby=regionname&dr=".$regionnamedr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "regionname")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?> ><div>Region Name</div></th>
								<th width="20%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-site-variables.php?sec=manloca&sortby=regionlat&dr=".$regionlatdr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "regionlat")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>Latitude</div></th>
								<th width="20%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-site-variables.php?sec=manloca&sortby=regionlon&dr=".$regionlondr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "regionlon")){echo "class=\"rightOver\" onmouseout=\"this.className = 'rightOver';\" ";}else{echo "onmouseout=\"this.className = 'right';\"";}?>><div>Longitude</div></th>
								<th width="10%" scope="col" class="right">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							<?php
							for($i=0; $i < count($regionListArr); $i++){
								$region_id 			= $regionListArr[$i]['region_id'];
								$area_id 			= $regionListArr[$i]['area_id'];
								$region_name 		= ucwords($regionListArr[$i]['region_name']);
								$latitude 			= $regionListArr[$i]['latitude'];
								$longitude 			= $regionListArr[$i]['longitude'];
							?>
								<tr>
									<td class="left"><a href="admin-site-variables.php?sec=manloca&action=edit&show=region&areaid=<?php echo $area_id;?>&regionid=<?php echo $region_id;?>"><?php echo fill_zero_left($region_id, "0", (6-strlen($region_id)));?></a></td>
									<td><a href="admin-site-variables.php?sec=manloca&show=location&regionid=<?php echo $region_id;?>"><?php echo $region_name;?></a></td>
									<td><?php echo $latitude;?></td>
									<td><?php echo $longitude;?></td>
									<td class="right"><a href="javascript:void(0);" onclick="confirmDel(<?php echo $region_id;?>);">delete</a></td>
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
			<tr>
				<td valign="top" class="SectionSubHead"><?php echo $addtitle;?></td>
				<td>&nbsp;</td>
			</tr>
			<tr><td colspan="2" valign="top">&nbsp;</td></tr>
			<tr><td colspan="2" valign="top">No Area/City added for <?php echo $area_name;?>!</td></tr>
			<tr><td colspan="2" valign="top">&nbsp;</td></tr>
			<tr>
				<td valign="top"><a href="admin-site-variables.php?sec=manloca&show=area&countryid=<?php echo $country_id; ?>" class="back">Back to Region List</a></td>
				<td align="right" valign="top"><a href="admin-site-variables.php?sec=manloca&action=add&show=region&areaid=<?php echo $area_id;?>" class="back">Add a new Area/City</a></td>
			</tr>
		</table>
	<?php
	}
?>