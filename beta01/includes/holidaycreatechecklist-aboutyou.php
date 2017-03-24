    <div id="aboutYou" class="RegFormMain">
    <!-- checklist tab : start here -->
        <ul>
            <li><img src="images/chklst-bg.gif" alt="CheckList" width="50" height="29" /></li>
            <li><a href="javascript: submtFrmChecklist('aboutyou');" title="About You"><img src="images/chklst-au-s.gif" width="91" height="29" border="0" /></a></li>
            <li><a href="javascript: submtFrmChecklist('holiday');" title="Holiday Type"><img src="images/chklst-ht-ns.gif" width="99" height="29" border="0" /></a></li>
            <li><a href="javascript: submtFrmChecklist('accommodation');" title="Accomodation Type"><img src="images/chklst-at-ns.gif" width="147" height="29" border="0" /></a></li>
            <li><a href="javascript: submtFrmChecklist('feature');" title="What are you looking for?"><img src="images/chklst-wrulf-ns.gif" width="177" height="29" border="0" /></a></li>
            <li><a href="javascript: submtFrmChecklist('confirm');" title="Confirm"><img src="images/chklst-c-ns.gif" width="76" height="29" border="0" /></a></li>
            <li><img src="images/chklst-bg.gif" alt="CheckList" width="50" height="29" /></li>
        </ul>
    <!-- checklist tab : end here -->
    
    <!-- tab content : starts here -->
    <div class="tcontent1">
        <h2 class="chklistQ">Q1. What type of holidaymaker are you?</h2>

        <div class="RegFormMain1">
		<?php
			$usersObj->fun_createHolidayCheckListPeopleType($user_id);
        ?>
        </div>
        <p class="Dash">&nbsp;</p>
        <p class="FloatLft">
            <input type="image" src="<?php echo SITE_IMAGES;?>next.gif" alt="Next" name="Next" width="69" height="28" border="0" id="Next" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Next','','<?php echo SITE_IMAGES;?>next-over.gif',1)" >
        </p>
    </div>
    <!-- tab content : starts here -->
                    
    </div>
