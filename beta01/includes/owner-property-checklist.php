<script language="javascript" type="text/javascript">
function frmChecklistFormSubmit(strSubTab){
	var strSubTab = strSubTab;
	var strAction = document.frmPropertyChecklist.action;
	strAction += "&che="+strSubTab;
	document.frmPropertyChecklist.action = strAction;
//	alert(document.frmPropertyChecklist.action);
	document.frmPropertyChecklist.submit();
}

function shouwUpdate(){
	document.getElementById("strShowUpdateId").value = "yes";
}
</script>
<!--ChecklistTab Content Starts Here -->
<form name="frmPropertyChecklist" method="post" action="<?php echo $_SERVER['PHP_SELF']."?sec=che&pid=".$propertyInfo['property_id']."&che=5";?>">
<input type="hidden" name="securityKey" value="<?php echo md5(OWNERPROPERTYCHECKLIST);?>" />
<input type="hidden" name="strShowUpdate" id="strShowUpdateId" value="no"/>
<div class="width690">
  <div class="FloatLft">
  <h2 class="page-heading">Checklist</h2>
 <?php /*?> <img src="<?php echo SITE_IMAGES;?>checklist-head.gif" alt="Checklist" /><?php */?>
  </div>
  <div class="FloatRgt" style="padding-top: 5px;"><input type="image" src="<?php echo SITE_IMAGES;?>save-these-details.gif" onclick="shouwUpdate();" onmouseover="this.src='<?php echo SITE_IMAGES;?>save-these-details-over.gif'" onmouseout="this.src='<?php echo SITE_IMAGES;?>save-these-details.gif'" alt="Save these details" name="Save" width="126" height="21" border="0" id="Save" /></div>
</div>
<div class="width690 dash31"></div>
<div class="width690 font12 pad-btm15" style="width:694px;">
<table border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td>By completing this checklist you will potentially open yourself up to more enquiries. Holiday makers will fill in the same checklist and they will match their requirements against your property, the more your property matches their requirements, the more chance they will get in touch.</td>
    </tr>
</table>
</div>
<!--ChecklistSubTab Starts Here -->
<div id="ChecklistSubTab"></div>
<!-- Type of people Starts Here -->
<div style="display: none;" id="1">
    <div class="width690 font12">
        <table width="690" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td>
                    <ul>
                        <li><img src="<?php echo SITE_IMAGES;?>chklst-bg.gif" alt="CheckList" width="41" height="29" /></li>
                        <li><a href="javascript:frmChecklistFormSubmit('1')" title="Type of people"><img src="<?php echo SITE_IMAGES;?>type-of-people-s.gif" alt="Type of people" border="0" /></a></li>
                        <li><a href="javascript:frmChecklistFormSubmit('2')" title="Type of holiday"><img src="<?php echo SITE_IMAGES;?>type-of-holiday-ns.gif" alt="Type of holiday" border="0" /></a></li>
                        <li><a href="javascript:frmChecklistFormSubmit('3')" title="Accomodation Type"><img src="<?php echo SITE_IMAGES;?>accomodation-type-ns.gif" alt="Accomodation Type" border="0" /></a></li>
                        <li><a href="javascript:frmChecklistFormSubmit('4')" title="Amenities and Features"><img src="<?php echo SITE_IMAGES;?>amenities-features-ns.gif" alt="Amenities and Features" border="0" /></a></li>
                        <li><a href="javascript:frmChecklistFormSubmit('5')" title="Confirm"><img src="<?php echo SITE_IMAGES;?>confirm-ns.gif" alt="Confirm" border="0" /></a></li>
                        <li><img src="<?php echo SITE_IMAGES;?>chklst-bg.gif" alt="CheckList" width="44" height="29" /></li>
                    </ul>
                </td>
            </tr>
            <tr>
                <td class="pad-top20 pad-btm20">
                    <span class="owner-headings">What type of holidaymaker would suit your property? </span>(Tick all that apply)<br />
                    <br />
                    Remember to be as honest as you can, there’s nothing worse than turning up to a holiday home and finding it isn’t suitable! It might also be worth asking other people, another opinion is always useful.
                </td>
            </tr>
            <tr>
                <td>
                    <?php
                    $propertyObj->fun_createPropertyCheckListPeopleType($propertyInfo['property_id']);
                    ?>
                </td>
            </tr>
        </table>
    </div>
</div>
<!-- Formating Ok -->

<!-- Type of people Ends Here -->
<!-- Type of holiday Starts Here -->
<div style="display:none;" id="2">
  <div class="width690 font12">
	<table width="690" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td><ul>
			<li><img src="<?php echo SITE_IMAGES;?>chklst-bg.gif" alt="CheckList" width="41" height="29" /></li>
			<li><a href="javascript:frmChecklistFormSubmit('1')" title="Type of people"><img src="<?php echo SITE_IMAGES;?>type-of-people-ns.gif" alt="Type of people" border="0" /></a></li>
			<li><a href="javascript:frmChecklistFormSubmit('2')" title="Type of holiday"><img src="<?php echo SITE_IMAGES;?>type-of-holiday-s.gif" alt="Type of holiday" border="0" /></a></li>
			<li><a href="javascript:frmChecklistFormSubmit('3')" title="Accomodation Type"><img src="<?php echo SITE_IMAGES;?>accomodation-type-ns.gif" alt="Accomodation Type" border="0" /></a></li>
			<li><a href="javascript:frmChecklistFormSubmit('4')" title="Amenities and Features"><img src="<?php echo SITE_IMAGES;?>amenities-features-ns.gif" alt="Amenities and Features" border="0" /></a></li>
			<li><a href="javascript:frmChecklistFormSubmit('5')" title="Confirm"><img src="<?php echo SITE_IMAGES;?>confirm-ns.gif" alt="Confirm" border="0" /></a></li>
			<li><img src="<?php echo SITE_IMAGES;?>chklst-bg.gif" alt="CheckList" width="44" height="29" /></li>
		  </ul>
          </td>
	  </tr>
	  <tr>
		<td class="pad-top20 pad-btm20"><span class="owner-headings">What type of holiday would people have at this property? </span>(Tick all that apply)</td>
	  </tr>
    <tr>
        <td>
            <?php
            $propertyObj->fun_createPropertyCheckListHolidayType($propertyInfo['property_id']);
            ?>
        </td>
    </tr>
	</table>
  </div>
</div>
<!-- Type of holiday Ends Here -->
<!-- Accomodation Type Starts Here -->
<div style="display:none;" id="3">
  <div class="width690 font12">
	<table width="690" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td><ul>
			<li><img src="<?php echo SITE_IMAGES;?>chklst-bg.gif" alt="CheckList" width="41" height="29" /></li>
			<li><a href="javascript:frmChecklistFormSubmit('1')" title="Type of people"><img src="<?php echo SITE_IMAGES;?>type-of-people-ns.gif" alt="Type of people" border="0" /></a></li>
			<li><a href="javascript:frmChecklistFormSubmit('2')" title="Type of holiday"><img src="<?php echo SITE_IMAGES;?>type-of-holiday-ns.gif" alt="Type of holiday" border="0" /></a></li>
			<li><a href="javascript:frmChecklistFormSubmit('3')" title="Accomodation Type"><img src="<?php echo SITE_IMAGES;?>accomodation-type-s.gif" alt="Accomodation Type" border="0" /></a></li>
			<li><a href="javascript:frmChecklistFormSubmit('4')" title="Amenities and Features"><img src="<?php echo SITE_IMAGES;?>amenities-features-ns.gif" alt="Amenities and Features" border="0" /></a></li>
			<li><a href="javascript:frmChecklistFormSubmit('5')" title="Confirm"><img src="<?php echo SITE_IMAGES;?>confirm-ns.gif" alt="Confirm" border="0" /></a></li>
			<li><img src="<?php echo SITE_IMAGES;?>chklst-bg.gif" alt="CheckList" width="44" height="29" /></li>
		  </ul></td>
	  </tr>
	  <tr>
		<td class="pad-top20 pad-btm20"><span class="owner-headings">How would you describe your property? </span>(Tick all that apply)</td>
	  </tr>
	  <tr>
		<td>
            <?php
            $propertyObj->fun_createPropertyCheckListAccommodationType($propertyInfo['property_id']);
            ?>
          </td>
	  </tr>
	</table>
  </div>
</div>
<!-- Accomodation Type Ends Here -->
<!-- Amenities and Features Starts Here -->
<div style="display:none;" id="4">
  <div class="width690 font12">
	<table width="690" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td><ul>
			<li><img src="<?php echo SITE_IMAGES;?>chklst-bg.gif" alt="CheckList" width="41" height="29" /></li>
			<li><a href="javascript:frmChecklistFormSubmit('1')" title="Type of people"><img src="<?php echo SITE_IMAGES;?>type-of-people-ns.gif" alt="Type of people" border="0" /></a></li>
			<li><a href="javascript:frmChecklistFormSubmit('2')" title="Type of holiday"><img src="<?php echo SITE_IMAGES;?>type-of-holiday-ns.gif" alt="Type of holiday" border="0" /></a></li>
			<li><a href="javascript:frmChecklistFormSubmit('3')" title="Accomodation Type"><img src="<?php echo SITE_IMAGES;?>accomodation-type-ns.gif" alt="Accomodation Type" border="0" /></a></li>
			<li><a href="javascript:frmChecklistFormSubmit('4')" title="Amenities and Features"><img src="<?php echo SITE_IMAGES;?>amenities-features-s.gif" alt="Amenities and Features" border="0" /></a></li>
			<li><a href="javascript:frmChecklistFormSubmit('5')" title="Confirm"><img src="<?php echo SITE_IMAGES;?>confirm-ns.gif" alt="Confirm" border="0" /></a></li>
			<li><img src="<?php echo SITE_IMAGES;?>chklst-bg.gif" alt="CheckList" width="44" height="29" /></li>
		  </ul></td>
	  </tr>
	  <tr>
		<td class="pad-top20 pad-btm20"><span class="owner-headings">What ammenities and features does your property have? </span>(Tick all that apply)</td>
	  </tr>
	  <tr>
		<td>
            <?php
            $propertyObj->fun_createPropertyCheckListAmenitiesFeatures($propertyInfo['property_id']);
            ?>
          </td>
	  </tr>
	</table>
  </div>
</div>
<!-- Amenities and Features Ends Here -->
<!-- Confirm Starts Here -->
<div style="display:none;" id="5">
<div class="width690 font12">
<table width="690" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td>
            <ul>
                <li><img src="<?php echo SITE_IMAGES;?>chklst-bg.gif" alt="CheckList" width="41" height="29" /></li>
                <li><a href="javascript:frmChecklistFormSubmit('1')" title="Type of people"><img src="<?php echo SITE_IMAGES;?>type-of-people-ns.gif" alt="Type of people" border="0" /></a></li>
                <li><a href="javascript:frmChecklistFormSubmit('2')" title="Type of holiday"><img src="<?php echo SITE_IMAGES;?>type-of-holiday-ns.gif" alt="Type of holiday" border="0" /></a></li>
                <li><a href="javascript:frmChecklistFormSubmit('3')" title="Accomodation Type"><img src="<?php echo SITE_IMAGES;?>accomodation-type-ns.gif" alt="Accomodation Type" border="0" /></a></li>
                <li><a href="javascript:frmChecklistFormSubmit('4')" title="Amenities and Features"><img src="<?php echo SITE_IMAGES;?>amenities-features-ns.gif" alt="Amenities and Features" border="0" /></a></li>
                <li><a href="javascript:frmChecklistFormSubmit('5')" title="Confirm"><img src="<?php echo SITE_IMAGES;?>confirm-s.gif" alt="Confirm" border="0" /></a></li>
                <li><img src="<?php echo SITE_IMAGES;?>chklst-bg.gif" alt="CheckList" width="44" height="29" /></li>
            </ul>
        </td>
    </tr>
    <tr><td class="pad-top20 owner-headings">Review your checklist</td></tr>
    <tr><td>Here's your properties holiday checklist, please review these choices.</td></tr>
    <!--Error row starts here -->
    <tr><td class="red bold">You must complete ALL sections for your property to be matched against holidaymaker requirements </td></tr>
    <!--Error row ends here -->
    <tr>
        <td style="padding-top:30px; padding-bottom:10px;">
            <table width="690" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="298" valign="top">
                        <table width="298" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td valign="top">
                                    <?php
                                    $propertyObj->fun_createPropertyCheckListPeopleTypeReview($propertyInfo['property_id']);
                                    ?>
                                </td>
                            </tr>
                            <tr><td valign="top" height="30">&nbsp;</td></tr>
                            <tr>
                                <td valign="top">
                                    <?php
                                    $propertyObj->fun_createPropertyCheckListHolidayTypeReview($propertyInfo['property_id']);
                                    ?>
                                </td>
                            </tr>
                            <tr><td valign="top" height="30">&nbsp;</td></tr>
                            <tr>
                                <td valign="top">
                                    <?php
                                    $propertyObj->fun_createPropertyCheckListAccommodationTypeReview($propertyInfo['property_id']);
                                    ?>
                                </td>
                            </tr>
                            <tr><td valign="top"></td></tr>
                        </table>
                    </td>
                    <td width="92" valign="top">&nbsp;</td>
                    <td width="298" valign="top">
                        <?php
                        $propertyObj->fun_createPropertyCheckListAmenitiesFeaturesReview($propertyInfo['property_id']);
                        ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</div>
</div>
<!-- Confirm Ends Here -->
<?php 
if(isset($_GET['che']) && $_GET['che'] !=""){
	$checklistSubTab = $_GET['che'];
}
else{
	$checklistSubTab = 1;
}
?>
<script language="javascript" type="text/javascript">
	open_div('ChecklistSubTab', <?php echo $checklistSubTab;?>);
</script>
<!-- ChecklistSubTab Ends Here -->
<div class="width690 dash41"></div>
<div class="width690">
  <div class="FloatRgt"><input type="image" src="<?php echo SITE_IMAGES;?>save-these-details.gif" onclick="shouwUpdate();" onmouseover="this.src='<?php echo SITE_IMAGES;?>save-these-details-over.gif'" onmouseout="this.src='<?php echo SITE_IMAGES;?>save-these-details.gif'" alt="Save these details" name="Save" width="126" height="21" border="0" id="Save" /></div>
</div>
<div class="width690 dash-btm pad-btm7">&nbsp;</div>
<!--ChecklistTab Content Ends Here -->
</form>
</div>