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
			$propertyObj->fun_importPropertyFromFeed($item);
		}
		$resultMsg = "Property Feed updated successfully!";
	}
}
if(isset($_GET['subsec']) && $_GET['subsec'] !=""){
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
                        <?php echo $resultMsg; ?>
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
