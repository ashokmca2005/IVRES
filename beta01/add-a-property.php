<?php	
	require_once("includes/owner-top.php");
?>
<?php	
	//form submission
	$form_array = array();
	$errorMsg 	= "no";

	if($_POST['securityKey']==md5("ADDNEWPROPERTY")) {
		if($_POST['txtPropertyType'] == '0') {
			$form_array['txtPropertyType'] = 'Please select a property type';
			$errorMsg = 'yes';
		}

		if(trim($_POST['txtPropertyName']) == '') {
			$form_array['txtPropertyName'] = 'Please enter a name for your property';
			$errorMsg = 'yes';
		}

		if(trim($_POST['txtPropertyTitle']) == '') {
			$form_array['txtPropertyTitle'] = 'Please enter a title for your advert';
			$errorMsg = 'yes';
		}
		if($_POST['txtPropertyCountry'] == '' || $_POST['txtPropertyCountry'] == '0') {
			$form_array['txtPropertyLocation'] = 'Please select country';
			$errorMsg = 'yes';
		}
		if($_POST['txtPropertyArea'] == '' || $_POST['txtPropertyArea'] == '0') {
			$form_array['txtPropertyLocation'] = 'Please select region';
			$errorMsg = 'yes';
		}
		/*
		if($_POST['txtPropertyRegion'] == '' || $_POST['txtPropertyRegion'] == '0') {
			$form_array['txtPropertyLocation'] = 'Please select city';
			$errorMsg = 'yes';
		}
		if($_POST['txtPropertyLocation'] == '') {
			$form_array['txtPropertyLocation'] = 'Please enter address';
			$errorMsg = 'yes';
		}
		*/
		if($errorMsg == 'no' && $errorMsg != 'yes') {
			$property_type 	= $_POST['txtPropertyType'];
			$property_name 	= fun_db_input($_POST['txtPropertyName']);
			$property_title = fun_db_input($_POST['txtPropertyTitle']);
			$country_id		= $_POST['txtPropertyCountry'];
			$area_id 		= $_POST['txtPropertyArea'];
			/*
			$region_id 		= $_POST['txtPropertyRegion'];
			$subregion_id 	= $_POST['txtPropertySubRegion'];
			$location_name 	= $_POST['txtPropertyLocation'];
			// Add address 
			$location_id = $locationObj->fun_addLocations($region_id, $location_name, '', '', '', '', '', 2);
			*/

			$region_id 		= $_POST['txtPropertyRegion'];
			$subregion_id 	= $_POST['txtPropertySubRegion'];
			$location_id 	= $_POST['txtPropertyLocation'];

			// Add New Property
			$property_id 	= $propertyObj->fun_addProperty('', $property_type, '', $property_name, $property_title, '', '', $country_id, $area_id, $region_id, $subregion_id, $location_id);
			$propertyFriendlyName = $property_name.' '.$locationObj->fun_getAreaNameById($area_id).' '.$locationObj->fun_getCountryNameById($country_id);
			// update friendly_link
			$propertyObj->fun_generateFriendlyLink($property_id, $propertyFriendlyName);

			// Assign property to user
			if($propertyObj->fun_assignPropertyToOwner($property_id, $user_id) > 0) {
				/*
				//Add property fee to cart
				$products_id = 6;
				if($propertyObj->fun_checkPropertyUserBasket($user_id, $products_id, $property_id) == false) {
					$products_price 	= $productObj->fun_getProductPrice($products_id);
					$products_quantity  = 1;
					$propertyObj->fun_addPropertyUserBasket($user_id, $products_id, $property_id, $products_quantity, $products_price);
				}
				*/
				$usersObj->sendAddPropertyConfirmationEmailToOwner($user_id, $property_id);
				// redirect to edit property
				redirectURL("owner-property.php?pid=".$property_id);
			} else {
				// redirect to add property
				redirectURL(SITE_URL."add-a-property");
			}
		}
	} else {
		$form_array['error_msg'] = "Please submit your form again!";
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo $seo_title;?></title>
    <meta name="description" content="<?php echo $seo_description;?>" />
    <meta name="keywords" content="<?php echo $seo_keywords;?>" />
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo tranText('charset'); ?>" />
    <META HTTP-EQUIV="Content-language" CONTENT="<?php echo tranText('lang_iso'); ?>">
    <link rel="icon" type="image/vnd.microsoft.icon" href="<?php echo SITE_URL; ?>favicon.ico" />
    <link rel="SHORTCUT ICON" href="<?php echo SITE_URL; ?>favicon.ico"/>
    <link href="<?php echo SITE_CSS_INCLUDES_PATH;?>common.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>common.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>owner.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>dhtmlwindow.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>dargPop.js"></script>
	<script language="javascript" type="text/javascript">
		var req = ajaxFunction();
		/*
		* For location : Start here
		*/
		function chkSelectCountry() {
			var getID=document.getElementById("txtPropertyCountryId").value;
			if(getID !="" && getID != "0"){
				sendAreaRequest(getID);
				document.getElementById("txtPropertyAreaId").value = "0";
			}
			if(getID == "0" || getID =="") {
				document.getElementById("txtPropertyCountryId").value = "0";
				document.getElementById("txtPropertyAreaId").value = "0";
			}
		}

		function chkSelectArea() {
			var getID=document.getElementById("txtPropertyAreaId").value;
			if(getID !="" && getID != "0"){
				sendRegionRequest(getID);
			}
			if(getID == "0" || getID =="") {
				document.getElementById("txtPropertyAreaId").value = "0";
			}
		}
		function sendAreaRequest(id) { 
			req.open('get', 'selectAreaXml.php?id=' + id); 
			req.onreadystatechange = handleAreaResponse; 
			req.send(null); 
		} 
		function sendRegionRequest(id) { 
			req.open('get', 'selectRegionXml.php?id=' + id); 
			req.onreadystatechange = handleRegionResponse; 
			req.send(null); 
		} 

		function handleAreaResponse() { 
			var arrayOfId = new Array();
			var arrayOfNames = new Array();
			if(req.readyState == 4) { 
				var response = req.responseText; 
				xmlDoc=req.responseXML;
				var root = xmlDoc.getElementsByTagName('ntowns')[0];
				if(root != null) {
					document.getElementById("txtPropertyAreaId").style.display = "block";
					var items = root.getElementsByTagName("ntown");
					for (var i = 0 ; i < items.length ; i++) {
						var item = items[i];
						var id = item.getElementsByTagName("id")[0].firstChild.nodeValue;
						arrayOfId[i] = id;
						var name = item.getElementsByTagName("name")[0].firstChild.nodeValue;

						arrayOfNames[i] = name;
						//alert("item #" + i + ": ID=" + id + " Name=" + name);
					}
					if( arrayOfId.length > 0) {
						var p_city=document.getElementById("txtPropertyAreaId");
						p_city.length=0;
						p_city.options[0]=new Option("Select Region...","");
						for(var j=0; j<arrayOfId.length; j++) {
							p_city.options[j+1]=new Option(arrayOfNames[j], arrayOfId[j]);
						}
					} else {
						var p_city=document.getElementById("txtPropertyAreaId");
						p_city.length=0;
						p_city.options[0]=new Option("Select Region...","");
					}
				} else {
					var p_city=document.getElementById("txtPropertyAreaId");
					p_city.length=0;
					p_city.options[0]=new Option("Select Region...","");
				}
			} 
		} 

		function handleRegionResponse() { 
			var arrayOfId = new Array();
			var arrayOfNames = new Array();
			if(req.readyState == 4) { 
				var response = req.responseText; 
				xmlDoc=req.responseXML;
				var root = xmlDoc.getElementsByTagName('ntowns')[0];
				if(root != null) {
					document.getElementById("txtPropertyRegionId").style.display = "block";
					var items = root.getElementsByTagName("ntown");
					for (var i = 0 ; i < items.length ; i++) {
						var item = items[i];
						var id = item.getElementsByTagName("id")[0].firstChild.nodeValue;
						arrayOfId[i] = id;
						var name = item.getElementsByTagName("name")[0].firstChild.nodeValue;
						arrayOfNames[i] = name;
						//alert("item #" + i + ": ID=" + id + " Name=" + name);
					}
					if( arrayOfId.length > 0) {
						var p_city=document.getElementById("txtPropertyRegionId");
						p_city.length=0;
						p_city.options[0]=new Option("Select City...","0");
						for(var j=0; j<arrayOfId.length; j++) {
							p_city.options[j+1]=new Option(arrayOfNames[j],arrayOfId[j]);
						}
					} else {
						var p_city=document.getElementById("txtPropertyRegionId");
						p_city.length=0;
						p_city.options[0]=new Option("Select City...","0");
					}
				} else {
					var p_city=document.getElementById("txtPropertyRegionId");
					p_city.length=0;
					p_city.options[0]=new Option("Select City...","0");
				}
			} 
		} 
		/*
		* For location : End here
		*/

		function validateAddProperty(){
			if(document.getElementById("txtPropertyTypeId").value == "0") {
				document.getElementById("showErrorPropertyTypeId").innerHTML = "Please select property type";
				document.getElementById("txtPropertyTypeId").focus();
				return false;
			}
		
			if(document.getElementById("txtPropertyNameId").value == "") {
				document.getElementById("showErrorPropertyNameId").innerHTML = "Please enter property name";
				return false;
			}
		
			if(document.getElementById("txtPropertyTitleId").value == "") {
				document.getElementById("showErrorPropertyTitleId").innerHTML = "Please enter property title";
				return false;
			}

			if(document.getElementById("txtPropertyCountryId").value == "" || document.getElementById("txtPropertyCountryId").value == "0" ) {
				document.getElementById("showErrorPropertyLocationId").innerHTML = "Please select country";
				return false;
			}

			if(document.getElementById("txtPropertyAreaId").value == "" || document.getElementById("txtPropertyAreaId").value == "0" ) {
				document.getElementById("showErrorPropertyLocationId").innerHTML = "Please select region";
				return false;
			}
			/*
			if(document.getElementById("txtPropertyRegionId").value == "" || document.getElementById("txtPropertyRegionId").value == "0") {
				document.getElementById("showErrorPropertyLocationId").innerHTML = "Please select city";
				return false;
			}

			if(document.getElementById("txtPropertyLocationId").value == "") {
				document.getElementById("showErrorPropertyLocationId").innerHTML = "Please enter address";
				return false;
			}
			*/
		}

		function cancelAddProperty(){
			window.location = 'owner-home.php';
		}
		
		function setDefaultCountry(strCountryId) {
			document.getElementById("txtPropertyCountryId").value = strCountryId;
			chkSelectCountry();
		}
    </script>
	<script language="javascript" type="text/javascript">
		var x, y;
		function show_coords(event){	
			x=event.clientX;
			y=event.clientY;
			x = x-160;
			y = y+4;
			//alert(x);alert(y);
		}
	
		function toggleLayer(whichLayer){
			var output = document.getElementById(whichLayer).innerHTML;
			if(whichLayer == 'ANP-Example')
			{		
				output = '<div style="z-index:5;">'+output+'</div>';
				var googlewin=dhtmlwindow.open("Example", "inline", output, "", "width=320px,height=300px,resize=0,scrolling=0,center=1,xAxis="+x+",yAxis="+y+"", "recal");
			}
			else if(whichLayer == 'ANP-Pop')
			{
				var googlewin=dhtmlwindow.open("Example", "inline", output, "", "width=320px,height=300px,resize=0,scrolling=0,center=1,xAxis="+x+",yAxis="+y+"", "recal");
			}
			
			googlewin.onclose=function(){ //Run custom code when window is being closed (return false to cancel action):
				return true
			}
		}
		
		function closeWindow(){	
			document.getElementById("Example").style.display="none";
		}
	</script>
</head>
<body onmousedown="show_coords(event);">
<!-- Main Wrapper Starts Here -->
<div id="wrapper">
    <!-- Header Include Starts Here -->
    <div id="header" align="center">
        <?php require_once(SITE_INCLUDES_PATH.'header.php'); ?>
    </div>
    <!-- Header Include End Here -->
	<?php require_once(SITE_INCLUDES_PATH.'holidayadvsearch.php'); ?>
	<?php //require_once(SITE_INCLUDES_PATH.'breadcrumb.php'); ?>
    <div id="pg-wrapper" align="center"><h1 class="page-heading"><?php echo tranText('add_a_new_property'); ?></h1></div>
    <div id="main">
        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="left" valign="top">
					<?php require_once(SITE_INCLUDES_PATH.'owner-left-links.php'); ?>
                </td>
                <td width="30" align="left" valign="top" style="border-right:thin #efefef solid;">&nbsp;</td>
                <td align="left" valign="top" class="font12" style="padding-left:10px;">
					<?php require_once(SITE_INCLUDES_PATH.'addnewproperty.php'); ?>
                </td>
            </tr>
        </table>
    </div>
</div>
<!-- Main Wrapper End Here -->
<!-- Footer Include Starts Here -->
<div id="footer">
    <?php require_once(SITE_INCLUDES_PATH.'footer.php'); ?>
</div>
<!-- Footer Include End Here -->
</body>
</html>
