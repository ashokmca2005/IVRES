<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td align="left" valign="top" class="width240">
            <?php require_once(SITE_INCLUDES_PATH.'holidayhome-left.php'); ?>
        </td>
        <td width="10" align="left" valign="top" style="border-left:1px dashed #44afe1;">&nbsp;</td>
        <td align="left" valign="top" class="width745">
            <form name="frmHolidayChecklist" method="post" action="<?php echo "holiday-create-checklist.php?chklst=".$next."";?>">
            <input type="hidden" name="securityKey" value="<?php echo md5(HOLIDAYPROPERTYCHECKLIST);?>" />
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td>
                        <div class="RegFormMain">
                        <p class="Registration"><img src="images/create-chklst.gif" alt="Registration" width="225" height="27" class="Registration" /></p>
                        </div>
                        <p class="RegFormTxt">Answer these 4 questions about the type of holiday you're after. We'll then match what you're looking for with ALL our properties and give you a % match for each. It might just help you find the perfect place.</p>
                        <div class="height7">&nbsp;</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php require_once(SITE_INCLUDES_PATH.$mainpage); ?>
                    </td>
                </tr>
            </table>
            </form>
        </td>
    </tr>
</table>
