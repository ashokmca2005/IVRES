<?php
	if(isset($_GET['sortby']) && $_GET['sortby'] != "") {
		//$strQuery = " AND A.countries_id ='84' ORDER BY ";
		 $strQuery = " ORDER BY ";
		switch($_GET['sortby']){
			case 'countryid':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$countryiddr 	= 0;
					$countrynamedr	= 1;
					$countryisodr 	= 1;
					$countryisddr 	= 1;
					$countrylatdr 	= 1;
					$countrylondr 	= 1;
				} else {
					$dr = "DESC";
					$countryiddr 	= 1;
					$countrynamedr	= 1;
					$countryisodr 	= 1;
					$countryisddr 	= 1;
					$countrylatdr 	= 1;
					$countrylondr 	= 1;
				}
				$strQuery .= " A.countries_id ".$dr;
			break;
			case 'countryname':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$countryiddr 	= 1;
					$countrynamedr	= 0;
					$countryisodr 	= 1;
					$countryisddr 	= 1;
					$countrylatdr 	= 1;
					$countrylondr 	= 1;
				} else {
					$dr = "DESC";
					$countryiddr 	= 1;
					$countrynamedr	= 1;
					$countryisodr = 1;
					$countryisddr 	= 1;
					$countrylatdr 	= 1;
					$countrylondr 	= 1;
				}
				$strQuery .= " A.countries_name ".$dr;
			break;
			case 'countryiso':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$countryiddr 	= 1;
					$countrynamedr	= 1;
					$countryisodr 	= 0;
					$countryisddr 	= 1;
					$countrylatdr 	= 1;
					$countrylondr 	= 1;
				} else {
					$dr = "DESC";
					$countryiddr 	= 1;
					$countrynamedr	= 1;
					$countryisodr 	= 1;
					$countryisddr 	= 1;
					$countrylatdr 	= 1;
					$countrylondr 	= 1;
				}
				$strQuery .= " A.countries_iso_code_3 ".$dr;
			break;
			case 'countryisd':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$countryiddr 	= 1;
					$countrynamedr	= 1;
					$countryisodr 	= 1;
					$countryisddr 	= 0;
					$countrylatdr 	= 1;
					$countrylondr 	= 1;
				} else {
					$dr = "DESC";
					$countryiddr 	= 1;
					$countrynamedr	= 1;
					$countryisodr 	= 1;
					$countryisddr 	= 1;
					$countrylatdr 	= 1;
					$countrylondr 	= 1;
				}
				$strQuery .= " A.countries_isd_code ".$dr;
			break;
			case 'countrylat':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$countryiddr 	= 1;
					$countrynamedr	= 1;
					$countryisodr 	= 1;
					$countryisddr 	= 1;
					$countrylatdr 	= 0;
					$countrylondr 	= 1;
				} else {
					$dr = "DESC";
					$countryiddr 	= 1;
					$countrynamedr	= 1;
					$countryisodr 	= 1;
					$countryisddr 	= 1;
					$countrylatdr 	= 1;
					$countrylondr 	= 1;
				}
				$strQuery .= " A.latitude ".$dr;
			break;
			case 'countrylon':
				if($_GET['dr'] == "1"){
					$dr = "ASC";
					$countryiddr 	= 1;
					$countrynamedr	= 1;
					$countryisodr 	= 1;
					$countryisddr 	= 1;
					$countrylatdr 	= 1;
					$countrylondr 	= 0;
				} else {
					$dr = "DESC";
					$countryiddr 	= 1;
					$countrynamedr	= 1;
					$countryisodr 	= 1;
					$countryisddr 	= 1;
					$countrylatdr 	= 1;
					$countrylondr 	= 1;
				}
				$strQuery .= " A.longitude ".$dr;
			break;
		}
	} else {
//		$strQuery 	= " AND A.countries_id ='84' ";
        $strQuery 	= " ";
		$countryiddr 	= 1;
		$countrynamedr	= 1;
		$countryisodr 	= 1;
		$countryisddr 	= 1;
		$countrylatdr 	= 1;
		$countrylondr 	= 1;
	}
	$countryListArr = $locationObj->fun_getCountriesArr($strQuery);
	if(is_array($countryListArr) && count($countryListArr) > 0){
	?>
		<script language="javascript" type="text/javascript">
		/* --------- Script for sort list links : start here ----------- */
		function sortList(str){
			location.href = str;
		}
		/* --------- Script for sort list links : end here ----------- */
		</script>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td valign="top" class="SectionSubHead"><?php echo $addtitle;?></td>
				<td>&nbsp;</td>
			</tr>
			<tr><td colspan="2" valign="top">&nbsp;</td></tr>
			<tr>
				<td colspan="2" valign="top">
					<table width="100%" border="0" cellpadding="0" cellspacing="0" class="EventListing">
						<thead>
							<tr>
								<th width="15%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-site-variables.php?sec=manloca&sortby=countryid&dr=".$countryiddr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "countryid")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?> ><div>Country ID</div></th>
								<th width="35%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-site-variables.php?sec=manloca&sortby=countryname&dr=".$countrynamedr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "countryname")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?> ><div>Country Name</div></th>
								<th width="10%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-site-variables.php?sec=manloca&sortby=countryiso&dr=".$countryisodr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "countryiso")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>ISO Code</div></th>
								<th width="10%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-site-variables.php?sec=manloca&sortby=countryisd&dr=".$countryisddr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "countryisd")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>ISD Code</div></th>
								<th width="15%" scope="col" onmouseover="this.className = 'RollOver';" onclick="sortList('<?php echo "admin-site-variables.php?sec=manloca&sortby=countrylat&dr=".$countrylatdr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "countrylat")){echo "class=\"current\" onmouseout=\"this.className = 'current';\" ";}else{echo "onmouseout=\"this.className = 'RollOut';\"";}?>><div>Latitude</div></th>
								<th width="15%" scope="col" class="right" onmouseover="this.className = 'rightOver';" onclick="sortList('<?php echo "admin-site-variables.php?sec=manloca&sortby=countrylon&dr=".$countrylondr;?>');" <?php if(isset($_GET['sortby']) && ($_GET['sortby'] == "countrylon")){echo "class=\"rightOver\" onmouseout=\"this.className = 'rightOver';\" ";}else{echo "onmouseout=\"this.className = 'right';\"";}?>><div>Longitude</div></th>
							</tr>
						</thead>
						<tbody>
							<?php
							for($i=0; $i < count($countryListArr); $i++){
								$countries_id 			= $countryListArr[$i]['countries_id'];
								$countries_name 		= ucwords($countryListArr[$i]['countries_name']);
								$countries_iso_code_3 	= $countryListArr[$i]['countries_iso_code_3'];
								$countries_isd_code 	= $countryListArr[$i]['countries_isd_code'];
								$latitude 				= $countryListArr[$i]['latitude'];
								$longitude 				= $countryListArr[$i]['longitude'];
							?>
								<tr>
									<td class="left"><a href="admin-site-variables.php?sec=manloca&action=edit&countryid=<?php echo $countries_id;?>"><?php echo fill_zero_left($countries_id, "0", (6-strlen($countries_id)));?></a></td>
									<td><a href="admin-site-variables.php?sec=manloca&show=area&countryid=<?php echo $countries_id;?>"><?php echo $countries_name;?></a></td>
									<td><?php echo $countries_iso_code_3;?></td>
									<td><?php echo $countries_isd_code;?></td>
									<td><?php echo $latitude;?></td>
									<td class="right"><?php echo $longitude;?></td>
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
			<tr><td valign="top">No country countrylat!</td></tr>
		</table>
	<?php
	}
?>