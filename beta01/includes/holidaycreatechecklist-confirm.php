    <div id="aboutYou" class="RegFormMain">
    <!-- checklist tab : start here -->
        <ul>
            <li><img src="<?php echo SITE_IMAGES;?>chklst-bg.gif" alt="CheckList" width="50" height="29" /></li>
            <li><a href="holiday-create-checklist.php?chklst=aboutyou" title="About You"><img src="<?php echo SITE_IMAGES;?>chklst-au-ns.gif" width="91" height="29" border="0" /></a></li>
            <li><a href="holiday-create-checklist.php?chklst=holiday" title="Holiday Type"><img src="<?php echo SITE_IMAGES;?>chklst-ht-ns.gif" width="99" height="29" border="0" /></a></li>
            <li><a href="holiday-create-checklist.php?chklst=accommodation" title="Accomodation Type"><img src="<?php echo SITE_IMAGES;?>chklst-at-ns.gif" width="147" height="29" border="0" /></a></li>
            <li><a href="holiday-create-checklist.php?chklst=feature" title="What are you looking for?"><img src="<?php echo SITE_IMAGES;?>chklst-wrulf-ns.gif" width="177" height="29" border="0" /></a></li>
            <li><a href="holiday-create-checklist.php?chklst=confirm" title="Confirm"><img src="<?php echo SITE_IMAGES;?>chklst-c-s.gif" width="76" height="29" border="0" /></a></li>
            <li><img src="<?php echo SITE_IMAGES;?>chklst-bg.gif" alt="CheckList" width="50" height="29" /></li>
        </ul>
    <!-- checklist tab : end here -->
    
    <!-- tab content : starts here -->
        <div class="tcontent1">
            <h2 class="chklistQ">Review your checklist<p class="RegFormTxt">Here's your holiday checklist, please review these choices.</p></h2>
            <div class="ChkLstConfirm">

                <table width="690" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="298" valign="top">
                            <table width="298" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td valign="top">
                                        <?php
                                        $usersObj->fun_createHolidayCheckListPeopleTypeReview($user_id);
                                        ?>
                                    </td>
                                </tr>
                                <tr><td valign="top" height="30">&nbsp;</td></tr>
                                <tr>
                                    <td valign="top">
                                        <?php
                                        $usersObj->fun_createHolidayCheckListHolidayTypeReview($user_id);
                                        ?>
                                    </td>
                                </tr>
                                <tr><td valign="top" height="30">&nbsp;</td></tr>
                                <tr>
                                    <td valign="top">
                                        <?php
                                        $usersObj->fun_createHolidayCheckListAccommodationTypeReview($user_id);
                                        ?>
                                    </td>
                                </tr>
                                <tr><td valign="top"></td></tr>
                            </table>
                        </td>
                        <td width="92" valign="top">&nbsp;</td>
                        <td width="298" valign="top">
                            <?php
                            $usersObj->fun_createHolidayCheckListAmenitiesFeaturesReview($user_id);
                            ?>
                        </td>
                    </tr>
                </table>
				<?php
                if (!isset($_SESSION['ses_user_id']) || $_SESSION['ses_user_id'] =="" ) {
                ?>
                    <div class="ChkLstExclamation"><span class="black">Note:</span> Please <a href="registration.php">Register</a> or <a href="login.php">Sign in</a> to use this checklist next time you visit the site</div>
                <?php
                } else {
				?>
                    <div>&nbsp;</div>
                <?php
				}
                ?>
	            </div>
            <span class="ChkLstDashExclamation">&nbsp;</span>
            <p class="FloatLft">
                <input type="hidden" name="txtClearChecklist" value="yes" />
                <input type="image" src="<?php echo SITE_IMAGES;?>clear-checklist.gif" alt="Clear Checklist" name="ClearChecklist" width="99" height="28" border="0" id="ClearChecklist" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('ClearChecklist','','<?php echo SITE_IMAGES;?>clear-checklist-over.gif',1)" >
            </p>
            <p class="FloatLft" style="padding-left: 10px;"><a href="property-search-results.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('ViewProperties','','<?php echo SITE_IMAGES;?>view-properties-over.gif',1)"><img src="<?php echo SITE_IMAGES;?>view-properties.gif" alt="View Properties" name="ViewProperties" width="139" height="28" border="0" id="ViewProperties" /></a></p>
        </div>
    <!-- tab content : starts here -->
                    
    </div>
