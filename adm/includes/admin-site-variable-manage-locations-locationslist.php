<?php
	if(isset($_GET['sortby']) && $_GET['sortby'] != "") {
		$strQuery = " ORDER BY ";
		switch($_GET['sortby']){
			case 'locationid':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$locationiddr 	= 0;
					$locationnamedr	= 1;
					$locationlatdr 	= 1;
					$locationlondr 	= 1;
				} else {
					$dr = "DESC";
					$locationiddr 	= 1;
					$locationnamedr	= 1;
					$locationlatdr 	= 1;
					$locationlondr 	= 1;
				}
				$strQuery .= " A.location_id ".$dr;
			break;
			case 'locationname':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$locationiddr 	= 1;
					$locationnamedr	= 0;
					$locationlatdr 	= 1;
					$locationlondr 	= 1;
				} else {
					$dr = "DESC";
					$locationiddr 	= 1;
					$locationnamedr	= 1;
					$locationlatdr 	= 1;
					$locationlondr 	= 1;
				}
				$strQuery .= " A.location_name ".$dr;
			break;
			case 'locationlat':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$locationiddr 	= 1;
					$locationnamedr	= 1;
					$locationlatdr 	= 0;
					$locationlondr 	= 1;
				} else {
					$dr = "DESC";
					$locationiddr 	= 1;
					$locationnamedr	= 1;
					$locationlatdr 	= 1;
					$locationlondr 	= 1;
				}
				$strQuery .= " A.latitude ".$dr;
			break;
			case 'locationlon':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$locationiddr 	= 1;
					$locationnamedr	= 1;
					$locationlatdr 	= 1;
					$locationlondr 	= 0;
				} else {
					$dr = "DESC";
					$locationiddr 	= 1;
					$locationnamedr	= 1;
					$locationlatdr 	= 1;
					$locationlondr 	= 1;
				}
				$strQuery .= " A.longitude ".$dr;
			break;
		}
	} else {
		$strQuery 	= "";
		$locationiddr 	= 1;
		$locationnamedr	= 1;
		$locationlatdr 	= 1;
		$locationlondr 	= 1;
	}
	$locationListArr = $locationObj->fun_getLocationArr($region_id, $strQuery);
	if(is_array($locationListArr) && count($locationListArr) > 0){
	?>
		<script language="javascript" type="text/javascript">
		/* --------- Script for sort list links : start here ----------- */
		function sortList(str){
			location.href = str;
		}
		/* --------- Script for sort list links : end here ----------- */
		function confirmDel(id) {
			if(confirm("Do you want to delete this location!\n Make sure it is not used anywhere!")) {
				document.frmAddLocation.txtLocationId.value = id;
				document.frmAddLocation.submit();
			} else {
				return false;
			}
		}
		</script>
		<form name="frmAddLocation" id="frmAddLocation" action="admin-site-variables.php?sec=manloca" method="post">
			<input type="hidden" name="securityKey" id="securityKey" value="<?php echo md5("DELLOCATION"); ?>">
			<input type="hidden" name="txtLocationId" id="txtLocationId" value="">
		</form>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td valign="top" class="SectionSubHead"><?php echo $addtitle;?></td>
				<td>&nbsp;</td>
			</tr>
			<tr><td colspan="2" valign="top">&nbsp;</td></tr>
			<tr>
				<td valign="top"><a href="admin-site-variables.php?sec=manloca&show=region&areaid=<?php echo $area_id;?>" class="back">Back to Area/City List</a></td>
				<td align="right" valign="top"><a href="admin-site-variables.php?sec=manloca&action=add&show=location&regionid=<?php echo $region_id;?>" class="back">Add a new location</a></td>
			</tr>
			<tr>
				<td colspan="2" valign="top" class="pad-top5">
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EventListing">
						<thead>
							<tr>
								<th width="15%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-site-variables.php?sec=manloca&sortby=locationid&dr=".$locationiddr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "locationid")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?> ><div>location ID</div></th>
								<th width="35%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-site-variables.php?sec=manloca&sortby=locationname&dr=".$locationnamedr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "locationname")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?> ><div>location Name</div></th>
								<th width="20%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-site-variables.php?sec=manloca&sortby=locationlat&dr=".$locationlatdr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "locationlat")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>Latitude</div></th>
								<th width="20%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-site-variables.php?sec=manloca&sortby=locationlon&dr=".$locationlondr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "locationlon")){echo "class=\"rightOver\" onmouseout=\"this.className = 'rightOver';\" ";}else{echo "onmouseout=\"this.className = 'right';\"";}?>><div>Longitude</div></th>
								<th width="10%" scope="col" class="right">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							<?php
							for($i=0; $i < count($locationListArr); $i++){
								$location_id 		= $locationListArr[$i]['location_id'];
								$region_id 			= $locationListArr[$i]['region_id'];
								$location_name 		= ucwords($locationListArr[$i]['location_name']);
								$latitude 			= $locationListArr[$i]['latitude'];
								$longitude 			= $locationListArr[$i]['longitude'];
							?>
								<tr>
									<td class="left"><a href="admin-site-variables.php?sec=manloca&action=edit&show=location&regionid=<?php echo $region_id;?>&locationid=<?php echo $location_id;?>"><?php echo fill_zero_left($location_id, "0", (6-strlen($location_id)));?></a></td>
									<td><?php echo $location_name;?></td>
									<td><?php echo $latitude;?></td>
									<td><?php echo $longitude;?></td>
									<td class="right"><a href="javascript:void(0);" onclick="confirmDel(<?php echo $location_id;?>);">delete</a></td>
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
			<tr><td colspan="2" valign="top">No location added for <?php echo $region_name;?>!</td></tr>
			<tr><td colspan="2" valign="top">&nbsp;</td></tr>
			<tr>
				<td valign="top"><a href="admin-site-variables.php?sec=manloca&show=region&areaid=<?php echo $area_id;?>" class="back">Back to Area/City List</a></td>
				<td align="right" valign="top"><a href="admin-site-variables.php?sec=manloca&action=add&show=location&regionid=<?php echo $region_id;?>" class="back">Add a new location</a></td>
			</tr>
		</table>
	<?php
	}
?>