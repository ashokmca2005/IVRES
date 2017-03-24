<?php
	if(isset($_GET['sortby']) && $_GET['sortby'] != "") {
		$strQuery = " ORDER BY ";
		switch($_GET['sortby']){
			case 'areaid':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$areaiddr 	= 0;
					$areanamedr	= 1;
					$arealatdr 	= 1;
					$arealondr 	= 1;
				} else {
					$dr = "DESC";
					$areaiddr 	= 1;
					$areanamedr	= 1;
					$arealatdr 	= 1;
					$arealondr 	= 1;
				}
				$strQuery .= " A.area_id ".$dr;
			break;
			case 'areaname':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$areaiddr 	= 1;
					$areanamedr	= 0;
					$arealatdr 	= 1;
					$arealondr 	= 1;
				} else {
					$dr = "DESC";
					$areaiddr 	= 1;
					$areanamedr	= 1;
					$arealatdr 	= 1;
					$arealondr 	= 1;
				}
				$strQuery .= " A.area_name ".$dr;
			break;
			case 'arealat':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$areaiddr 	= 1;
					$areanamedr	= 1;
					$arealatdr 	= 0;
					$arealondr 	= 1;
				} else {
					$dr = "DESC";
					$areaiddr 	= 1;
					$areanamedr	= 1;
					$arealatdr 	= 1;
					$arealondr 	= 1;
				}
				$strQuery .= " A.latitude ".$dr;
			break;
			case 'arealon':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$areaiddr 	= 1;
					$areanamedr	= 1;
					$arealatdr 	= 1;
					$arealondr 	= 0;
				} else {
					$dr = "DESC";
					$areaiddr 	= 1;
					$areanamedr	= 1;
					$arealatdr 	= 1;
					$arealondr 	= 1;
				}
				$strQuery .= " A.longitude ".$dr;
			break;
		}
	} else {
		$strQuery 	= "";
		$areaiddr 	= 1;
		$areanamedr	= 1;
		$arealatdr 	= 1;
		$arealondr 	= 1;
	}
	$areaListArr = $locationObj->fun_getAreasArr($country_id, $strQuery);
	if(is_array($areaListArr) && count($areaListArr) > 0){
	?>
		<script language="javascript" type="text/javascript">
		/* --------- Script for sort list links : start here ----------- */
		function sortList(str){
			location.href = str;
		}
		/* --------- Script for sort list links : end here ----------- */
		function confirmDel(id) {
			if(confirm("Do you want to delete this region!\n Make sure it is not used anywhere!")) {
				document.frmAddArea.txtAreaId.value = id;
				document.frmAddArea.submit();
			} else {
				return false;
			}
		}
		</script>
		<form name="frmAddArea" id="frmAddArea" action="admin-site-variables.php?sec=manloca" method="post">
			<input type="hidden" name="securityKey" id="securityKey" value="<?php echo md5("DELAREA"); ?>">
			<input type="hidden" name="txtAreaId" id="txtAreaId" value="">
		</form>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td valign="top" class="SectionSubHead"><?php echo $addtitle;?></td>
				<td>&nbsp;</td>
			</tr>
			<tr><td colspan="2" valign="top">&nbsp;</td></tr>
			<tr>
				<td valign="top"><a href="admin-site-variables.php?sec=manloca" class="back">Back to Country List</a></td>
				<td align="right" valign="top"><a href="admin-site-variables.php?sec=manloca&action=add&show=area&countryid=<?php echo $country_id; ?>" class="back">Add a new Region/State</a></td>
			</tr>
			<tr>
				<td colspan="2" valign="top" class="pad-top5">
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EventListing">
						<thead>
							<tr>
								<th width="15%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-site-variables.php?sec=manloca&show=area&countryid=".$country_id."&sortby=areaid&dr=".$areaiddr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "areaid")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?> ><div>Region ID</div></th>
								<th width="45%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-site-variables.php?sec=manloca&show=area&countryid=".$country_id."&sortby=areaname&dr=".$areanamedr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "areaname")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?> ><div>Region Name</div></th>
								<th width="20%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-site-variables.php?sec=manloca&show=area&countryid=".$country_id."&sortby=arealat&dr=".$arealatdr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "arealat")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>Latitude</div></th>
								<th width="20%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-site-variables.php?sec=manloca&show=area&countryid=".$country_id."&sortby=arealon&dr=".$arealondr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "arealon")){echo "class=\"rightOver\" onmouseout=\"this.className = 'rightOver';\" ";}else{echo "onmouseout=\"this.className = 'right';\"";}?>><div>Longitude</div></th>
								<th width="20%" scope="col" class="right">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							<?php
							for($i=0; $i < count($areaListArr); $i++){
								$area_id 			= $areaListArr[$i]['area_id'];
								$country_id 		= $areaListArr[$i]['country_id'];
								$area_name 			= ucwords($areaListArr[$i]['area_name']);
								$latitude 			= $areaListArr[$i]['latitude'];
								$longitude 			= $areaListArr[$i]['longitude'];
							?>
								<tr>
									<td class="left"><a href="admin-site-variables.php?sec=manloca&action=edit&show=area&countryid=<?php echo $country_id;?>&areaid=<?php echo $area_id;?>"><?php echo fill_zero_left($area_id, "0", (6-strlen($area_id)));?></a></td>
									<td><a href="admin-site-variables.php?sec=manloca&show=region&areaid=<?php echo $area_id;?>"><?php echo $area_name;?></a></td>
									<td><?php echo $latitude;?></td>
									<td><?php echo $longitude;?></td>
									<td class="right"><a href="javascript:void(0);" onclick="confirmDel(<?php echo $area_id;?>);">delete</a></td>
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
			<tr><td colspan="2" valign="top">No Region/State added for <?php echo $country_name;?>!</td></tr>
			<tr><td colspan="2" valign="top">&nbsp;</td></tr>
			<tr>
				<td valign="top"><a href="admin-site-variables.php?sec=manloca" class="back">Back to Country List</a></td>
				<td align="right" valign="top"><a href="admin-site-variables.php?sec=manloca&action=add&show=area&countryid=<?php echo $country_id; ?>" class="back">Add a new Region/State</a></td>
			</tr>
		</table>
	<?php
	}
?>