<?php
	if($_SERVER["SERVER_NAME"] == "localhost") {
		require_once($_SERVER["DOCUMENT_ROOT"]."/ivres/beta01/includes/application-top.php");
	} else {
		require_once($_SERVER["DOCUMENT_ROOT"]."projects/ivres/1/includes/application-top.php");
	}
	require_once(SITE_CLASSES_PATH."class.Property.php");
	$propertyObj 	= new Property();
	$txtRegionId 	= $_REQUEST['id'];
?>
<select name="txtLocationId" id="txtLocationId">
    <option value="" selected="selected">Please Select...</option>
    <?php $propertyObj->fun_getLocationListOptionsWithTotalProp('', $txtRegionId);?>
</select>
