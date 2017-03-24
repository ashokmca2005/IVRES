<?php 
	$propListArr = $propertyObj->fun_getPropertyUserSavedArr($_SESSION['ses_user_id']);
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td align="left" valign="top" class="width240">
            <?php require_once(SITE_INCLUDES_PATH.'holidayhotproperty-left.php'); ?>
        </td>
        <td width="10" align="left" valign="top" style="border-left:1px dashed #44afe1;">&nbsp;</td>
        <td align="left" valign="top" class="width745">
			<?php require_once(SITE_INCLUDES_PATH.'holidaysavedproperties-show.php'); ?>
        </td>
    </tr>
</table>
