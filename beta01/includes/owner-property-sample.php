<?php
/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
/*++++++++++++++++++++++++				TABNAME TAB PHP CODE START HERE	 			+++++++++++++++++++++++++++*/
require_once("adm/includes/classes/class.Property.php");
$propertyObj = new Property();

$availability_array 	= array();
$error_msg		= 'no';

if($_POST['securityKey']==md5(OWNERPROPERTYAVAILABILITY)){		

	if($error_msg == 'no' && $errorMsg != 'yes'){

		if($propertyObj->fun_editProperty($property_id) === true){
			$detail_array['error_msg'] = "Property availablity details successfully updated!";
		}
		else{
			$detail_array['error_msg'] = "Error: We are unable to update your property availablity detail!";
		}
	}
	else{
		$detail_array['error_msg'] = "Please submit your form again!";
	}
}

//print_r($detail_array);

/*++++++++++++++++++++++++				DETAIL TAB PHP CODE END HERE	 			+++++++++++++++++++++++++++*/
/*+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++*/
?>
<!--ChecklistTab Content Starts Here -->
<script language="javascript" type="text/javascript">
var x1, y1;
function show_coords(event){
	x1=event.clientX;
	y1=event.clientY;
	//alert(x1);
	//alert(y1);
	x1= x1-150;
	y1= y1+8;
}

function toggleLayer(){
     
	var output 	= document.getElementById("avail-option").innerHTML;
	output 		= '<div style="z-index:5;">'+output+'</div>';
	var googlewin=dhtmlwindow.open("Example", "inline", output, "", "width=326px,height=200px,resize=0,scrolling=0,center=1,xAxis="+x1+",yAxis="+y1+"", "recal");
	
	googlewin.onclose=function(){ //Run custom code when window is being closed (return false to cancel action):
		return true
	}
}

function closeWindow(){
	document.getElementById("Example").style.display="none";
}

</script>
<?php
if(isset($property_id) && $property_id !=""){
	$propertyInfo = $propertyObj->fun_getPropertyInfo($property_id);
}
?>
<!--Availability Content Starts Here -->
<div class="width690 dash31">&nbsp;</div>
<form name="frmPropertyChecklist" method="post" action="<?php echo $_SERVER['PHP_SELF']."?sec=ava&pid=".$propertyInfo['property_id'];?>">
<input type="hidden" name="securityKey" value="<?php echo md5(OWNERPROPERTYAVAILABILITY);?>" />
<div class="width690">
	<div class="FloatLft"><img src="images/availability.gif" alt="Availability" /></div>
	<div class="FloatRgt" style="padding-top:3px;"><input type="image" src="images/save-these-details.gif" onmouseover="this.src='images/save-these-details-over.gif'" onmouseout="this.src='images/save-these-details.gif'" alt="Save these details" name="Save" width="126" height="21" border="0" id="Save" /></div>
</div>
<div class="width690 dash31">&nbsp;</div>
<!-- Calendar Header Ends Here -->
<div id="yearDiv"></div>
<div class="width690 dash41">&nbsp;</div>
<div class="width690">
  <div class="FloatRgt"><input type="image" src="images/save-these-details.gif" onmouseover="this.src='images/save-these-details-over.gif'" onmouseout="this.src='images/save-these-details.gif'" alt="Save these details" name="Save" width="126" height="21" border="0" id="Save" /></div>
</div>
<div class="width690 dash41">&nbsp;</div>
<!--ChecklistTab Content Ends Here -->
</form>
