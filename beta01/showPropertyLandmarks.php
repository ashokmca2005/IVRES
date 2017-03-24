<?php	
	require_once("adm/includes/common.php");
	require_once("adm/includes/database-table.php");
	require_once("adm/includes/classes/class.DB.php");
	$dbObj = new DB();
	$dbObj->fun_db_connect();
	require_once(SITE_CLASSES_PATH."class.Property.php");
	$propertyObj 	= new Property();
?>
<?php	
if(isset($_GET['pid']) && $_GET['pid'] !=""){
	$property_id 	= $_GET['pid'];
	$distance_type 	= $_GET['distance'];
	
	$propertyObj->fun_updateLandmarkDistanceType($property_id, $distance_type);
	?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td align="left" valign="top" class="pad-btm10">
			How far away are the following from your property?<br />
			If the airport is 12.3km away then select km from the dropdown and then 12.3 into the box next to airport.<br /><br />
			<span class="black">NB:</span> Leave a field blank if it too far away to be useful
			</td>
		</tr>
		<tr>
			<td align="left" valign="top" class="pad-btm10">
				<!--++++++   THIS TABLE IS FOR SHOW ALL DISTANCES START HERE  ++++++-->
				<?php
					$propertyObj->fun_createPropertyLandmarks($property_id, $distance_type);
				?>
				<!--++++++   THIS TABLE IS FOR SHOW ALL DISTANCES END HERE  ++++++-->
			</td>
		</tr>
		<tr>
			<td align="left" valign="top" bgcolor="#e8eaee">
				<?php
					$propertyObj->fun_createPropertyExtrAshokdmarks($property_id);
				?>
				<input type="hidden" value="<?php echo ($propertyObj->fun_countPropertyExtrAshokdmarks($property_id)+1); ?>" id="theValue" />
				<div id="myDiv1"> </div>                                
			</td>
		</tr>
		<tr>
			<td align="left" valign="top" class="pad-btm15 pad-top10"><a href="javascript:void(0);" onclick="addEvent();" class="add-photo">Add another distance</a> Such as distance from a local landmark or feature</td>
		</tr>
	</table>
<?php
}
?>
		
