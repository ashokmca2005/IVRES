<?php
// Form submision
$detail_array 	= array();
$error_msg		= 'no';
if($_POST['securityKey'] == md5(ADDLANGUAGES)){
	$display_arr 	= $_POST['display_status'];
	$systemObj->fun_setLanguageDisplay($display_arr);
	echo "<script>location.href = 'admin-site-variables.php?sec=lang';</script>";
}

$languageArr 	= $systemObj->fun_getLangArr();
?>
<script language="javascript" type="text/javascript">
	function frmValidateAddLanguage() {
		var shwError = false;

/*
		if(document.frmAddLanguages.txtEUR.value == "") {
            document.getElementById("txtEURErrorId").innerHTML = "Please enter EUR rate";
            document.frmAddLanguages.txtEUR.focus();
            shwError = true;
        }

		if(document.frmAddLanguages.txtUSD.value == "") {
            document.getElementById("txtUSDErrorId").innerHTML = "Please enter USD rate";
            document.frmAddLanguages.txtUSD.focus();
            shwError = true;
        } 

        if(document.frmAddLanguages.txtGBP.value == "") {
            document.getElementById("txtGBPErrorId").innerHTML = "Please enter GBP rate";
            document.frmAddLanguages.txtGBP.focus();
            shwError = true;
        } 
*/
		
		if(shwError == true) {
			return false;
		} else {
			document.frmAddLanguages.submit();
		}
	}
</script>
<form name="frmAddLanguages" id="frmAddLanguages" action="admin-site-variables.php?sec=lang" method="post">
<input type="hidden" name="securityKey" id="securityKey" value="<?php echo md5("ADDLANGUAGES")?>">
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
    <tr><td width="90" class="SectionSubHead pad-btm12"><?php echo $addtitle;?></td></tr>
	<tr>
		<td valign="top" class="adminBox1" style="padding:10px;">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr style="background-color:#CCCCCC; height:25px;">
                    <td valign="middle" align="left" style="padding-left:5px;"><strong>Code</strong></td>
                    <td valign="middle" align="left"><strong>Name</strong></td>
                    <td valign="middle" align="center" style="padding-right:5px;"><strong>Active</strong></td>
				</tr>
                <tr height="10px"><td colspan="3"></td></tr>
				<?php
                for($i =0; $i < count($languageArr); $i++) {
                    $lang_code 		= $languageArr[$i]['lang_code'];
                    $name 			= $languageArr[$i]['name'];
                    $display_status = $languageArr[$i]['display_status'];
                    $checked 		= ($display_status == 1)?'checked="checked"':'';
                    $trBg 			= ($i%2 == 0)?'#EEEEEE':'#FFFFFF';
                    //$chkdiabled		= ($lang_code == 'en')?'disabled="disabled"':'';
                    $chkdiabled		= 'disabled="disabled"';
                
                    echo '<tr style="background-color:'.$trBg.'; height:25px;">';
                    echo '<td valign="middle" align="left" style="padding-left:5px;">'.$lang_code.'</td>';
                    echo '<td valign="middle" align="left">'.$name.'</td>';
                    echo '<td valign="middle" align="center" style="padding-right:5px;"><input type="checkbox" name="display_status[]" id="display_status'.$i.'" value="'.$lang_code.'" '.$checked.' '.$chkdiabled.' /></td>';
                    echo '</tr>';
                }
                ?>
			</table>
		</td>
	</tr>
	<tr><td valign="top">&nbsp;</td></tr>
	<tr>
		<td valign="top">
			<p class="FloatLft pad-rgt5"><a href="admin-site-variables.php?sec=lang"><img src="images/cancel-admin.png" alt="Cancel"/></a></p>
			<p class="Floatlft"><a href="javascript:void(0);" onclick="frmValidateAddLanguage();" title="Add Currency" style="text-decoration:none;"><img src="images/save-changes-admin.png" alt="Save Changes"/></a></p>
		</td>
	</tr>
</table>
</form>