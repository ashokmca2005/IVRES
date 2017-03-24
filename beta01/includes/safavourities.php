<?php 
	$propListArr = $propertyObj->fun_getPropertyUserFavouritesArr($user_id);
?>
<script language="javascript" type="text/javascript">
	function validateFrmLocSearch(){
		if(document.getElementById('SearchLocFld1').value == "eg Camps Bay or Cape Town ..."){
			document.getElementById('SearchLocFld1').value = "";
		}
	}
</script>
<link href="<?php echo SITE_URL;?>css/pop-up-cal.css" rel="stylesheet" type="text/css" />
<table width="690" border="0" cellspacing="0" cellpadding="0" class="font12">
<?php
if(is_array($propListArr) && count($propListArr) > 0) {
?>
    <tr>
        <td align="left" valign="top">
			<?php require_once(SITE_INCLUDES_PATH.'safavourities-show-listing.php'); ?>
        </td>
    </tr>
<?php
} else {
?>
    <tr>
        <td valign="top" class="pad-top20">
            <span class="pink14arial">You currently have no favourite properties <img src="<?php echo SITE_IMAGES;?>smiles/icon_sad.gif" alt="smiles" /></span>
        </td>
    </tr>
    <tr>
        <td valign="top" class="pad-top20">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="left" valign="top" class="width22">&nbsp;</td>
                    <td align="left" valign="top" class="font12 pad-btm26">
                        <form action="<?php echo SITE_URL; ?>property-search-results.php" method="post" name="frmLocSearch" id="frmLocSearch" onsubmit="validateFrmLocSearch()">
                        <input type="hidden" name="searchKey" value="<?php echo md5(LOCATIONSEARCH)?>" />
                        <div class="gradientBox690">
                            <div class="top">
                                <div class="btm">
                                    <div class="content" style="padding-left:30px;">
                                        <table border="0" cellpadding="4" cellspacing="0">
                                            <tr>
                                                <td  align="left" valign="middle" class="gray18Arial">Find accommodation in</td>
                                                <td  align="left" valign="middle"><input type="text" name="txtLocSearch" id="SearchLocFld1" class="searchBox" style="width:300px;" value="eg Camps Bay or Cape Town ..." onclick="return bnkLocSearch();" onblur="return restoreLocSearch();" autocomplete="off" /></td>
                                                <td align="left" valign="middle"><input type="image" src="<?php echo SITE_IMAGES;?>search-new.png" alt="Search" /></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                    </td>
                    <td align="left" valign="top" class="width18">&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
<?php
}
?>    
</table>