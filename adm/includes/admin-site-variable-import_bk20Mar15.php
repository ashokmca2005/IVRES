<?php
// Form submision
$form_array 	= array();
$error_msg		= 'no';
if($_POST['securityKey'] == md5("ADDXML")){
	$propertyfeed   = $_FILES['propertyfeed']['name'];
	$uploaddir  	= '../upload';
	$uploadfile 	= $uploaddir ."/". $propertyfeed;
	if(move_uploaded_file($_FILES['propertyfeed']['tmp_name'], $uploadfile)){
		$xml = simplexml_load_file($uploadfile) or die("Error: Cannot create object");
		foreach($xml->listings->listing as $item) {
			echo "<pre>";
			print $item->id;
			echo "<br>";
			print $item->url;
			echo "<br>";
			print $item->inquiry_url;
			echo "<br>";
			print $item->category;
			echo "<br>";
			print $item->expire_time;
			echo "<br>";
			print $item->title;
			echo "<br>";
			print $item->description;
			echo "<br>";
			foreach($item->images->image_url as $image) {
				print $image;
				echo "<br>";
			}
			echo "<br>";
			print $item->keywords;
			echo "<br>";
			print $item->price;
			echo "<br>";
			print $item->price_period;
			echo "<br>";
			print $item->currency;
			echo "<br>";
			print $item->secondary_source;
			echo "<br><br><strong>Location:</strong> <br>";
			foreach($item->location as $loc) {
				print $loc->address;
				echo "<br>";
				print $loc->city;
				echo "<br>";
				print $loc->country_code;
				echo "<br>";
				print $loc->state_code;
				echo "<br>";
				print $loc->latitude;
				echo "<br>";
				print $loc->longitude;
				echo "<br>";
				print $loc->zip_code;
				echo "<br>";
			}

			echo "<br><br><strong>Attribute:</strong> <br>";
			foreach($item->attribute as $attri) {
				print $attri->bathrooms;
				echo "<br>";
				print $attri->bedrooms;
				echo "<br>";
				print $attri->sleeps;
				echo "<br>";
				print $attri->condition;
				echo "<br>";
				print $attri->disclaimer;
				echo "<br>";
			}

			echo "<br><br><strong>Not Available Dates:</strong> <br>";
			foreach($item->not_available_dates->not_available_date as $unavailable_date) {
				print $unavailable_date;
				echo "<br>";
			}

			echo "<br><br><strong>Pricing:</strong> <br>";
			foreach($item->pricing->price_range as $price) {
				print $price->name;
				echo "<br>";
				print $price->per_night;
				echo "<br>";
				print $price->per_night_weekend;
				echo "<br>";
				print $price->per_week;
				echo "<br>";
				print $price->per_month;
				echo "<br>";
				print $price->from_date;
				echo "<br>";
				print $price->to_date;
				echo "<br>";
				print $price->min_stay;
				echo "<br><br>";
			}
			echo "</pre>";
			echo "<br><br><br><hr>";
		}



	}
}
if(isset($_GET['subsec']) && $_GET['subsec'] !=""){
	$addtitle 	= "Add Meta Info";
	?>
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

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
	<?php
} else {
?>
<script language="javascript" type="text/javascript">
	function frmValidate(){
		var frm = document.frmImportXML;
		if(frm.propertyfeed.value == ''){
			alert("Error: Please select property feed.");
			frm.propertyfeed.focus();
			return false;
		}
		document.frmImportXML.submit();
	}
</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
	<tr>
		<td valign="top" class="SectionSubHead"><?php echo $addtitle;?></td>
		<td>&nbsp;</td>
	</tr>
    <tr><td  colspan="2" valign="top" class="blueBotBorder"><img src="images/spacer.gif" height="8" /></td></tr>
	<tr>
		<td colspan="2" valign="top" class="pad-top15">
            <form name="frmImportXML" id="frmImportXML" action="admin-site-variables.php?sec=import&subsec=add" method="post" enctype="multipart/form-data" >
            <input type="hidden" name="securityKey" id="securityKey" value="<?php echo md5("ADDXML"); ?>">
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
				<tr><td valign="top" width="350px">Select Property XML: <input type="file" name="propertyfeed" id="propertyfeed"></td><td valign="top" align="left"><a href="javascript:void(0);" onClick="frmValidate();" style="text-decoration:none;"><img src="images/submit.gif" width="85" height="30" border="0" /></a></td></tr>
			</table>
            </form>
		</td>
	</tr>
    <tr><td  colspan="2" valign="top" class="blueBotBorder"><img src="images/spacer.gif" height="8" /></td></tr>
</table>
<?php
}
?>
