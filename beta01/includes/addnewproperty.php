<table width="690" border="0" cellspacing="0" cellpadding="0" class="font12">
    <tr><td align="left" valign="bottom" class="pad-top20 pad-btm10">This shouldn&rsquo;t take long &amp; remember you can edit your property listing at any time. There is also &ldquo;Help&rdquo; along the way &amp; you can &ldquo;Preview&rdquo; your property at any point to see how renters will see it.</td></tr>
    <tr>
        <td align="left" valign="bottom">
            <form name="frmProperty" id="frmProperty" action="<?php if($property_id != ""){echo $_SERVER['PHP_SELF']."?pid=".$property_id;}else{echo $_SERVER['PHP_SELF'];}?>" method="post">
                <input type="hidden" name="securityKey" value="<?php echo md5(ADDNEWPROPERTY);?>" />
                <table width="100%" border="0" cellpadding="5" cellspacing="0">
                    <tr>
                        <td width="155" align="right" valign="top"><?php echo tranText('property_type'); ?><span class="red">*</span></td>
                        <td width="235" valign="middle">
                            <span class="RegFormRight">
                                <?php if(isset($_POST['txtPropertyType'])){ $property_type = $_POST['txtPropertyType']; } else { $property_type = $propertyInfo['property_type']; } ?>
                                <select name="txtPropertyType" id="txtPropertyTypeId" class="selectBox216">
                                <option value="0">Please Select...</option>
                                <?php $propertyObj->fun_getPropertyTypeOptionsList($property_type);?>
                                </select>
                            </span>
                        </td>
                        <td width="274" valign="top"><span class="pdError1" id="showErrorPropertyTypeId"><?php if(array_key_exists('txtPropertyType', $form_array)) echo $form_array['txtPropertyType'];?></span></td>
                    </tr>
                    <tr>
                        <td width="155" align="right" valign="top"><?php echo tranText('property_name'); ?><span class="red">*</span></td>
                        <td width="235" valign="middle">
                        <span class="RegFormRight">
                            <input name="txtPropertyName" id="txtPropertyNameId" type="text" class="txtBox241" value="<?php if(isset($_POST['txtPropertyName'])){echo $_POST['txtPropertyName'];}else{echo $propertyInfo['property_name'];}?>" maxlength="25" onKeyDown="limitText(this.form.txtPropertyName,this.form.txtNameCountdown,25);" onKeyUp="limitText(this.form.txtPropertyName,this.form.txtNameCountdown,25);" onFocus="showField('txtNameCountdownId');" />
                        </span>
                        </td>
                        <td width="274" valign="top">
                        <span class="pdError1" id="showErrorPropertyNameId">
                            <?php 
                            if(array_key_exists('txtPropertyName', $form_array)) {
                                echo $form_array['txtPropertyName'];
                            } else {
                                echo "<span id=\"txtNameCountdownId\"><input readonly type=\"text\" name=\"txtNameCountdown\" onfocus=\"this.form.txtPropertyTitle.focus();\" size=\"1\" value=\"25\" style=\"padding:0 2px 0 2px;background-color:#FFFFFF; top:-1px; left:-7px; position:relative; text-align:left; width: 30px; border:0px solid #FFFFFF; color:#FF0000; \"></span>";
                            }
                            ?>
                        </span>
                        </td>
                    </tr>
                    <tr>
                        <td width="155" align="right" valign="top"><?php echo tranText('property_headline'); ?><span class="red">*</span></td>
                        <td width="235" valign="middle">
                        <span class="RegFormRight">
                            <textarea name="txtPropertyTitle" id="txtPropertyTitleId" onKeyDown="limitText(this.form.txtPropertyTitle,this.form.txtTitleCountdown,70);" onKeyUp="limitText(this.form.txtPropertyTitle,this.form.txtTitleCountdown,70);" onFocus="showField('txtTitleCountdownId');" class="Textarea226"><?php if(isset($_POST['txtPropertyTitle'])){echo $_POST['txtPropertyTitle'];}else{echo $propertyInfo['property_title'];}?></textarea>
                        </span>
                        </td>
                        <td width="274" valign="top">
                        <span class="pdError1" id="showErrorPropertyTitleId">
                            <?php 
                            if(array_key_exists('txtPropertyTitle', $form_array)) {
                                echo $form_array['txtPropertyTitle'];
                            } else {
                                echo "<span id=\"txtTitleCountdownId\"><input readonly type=\"text\" name=\"txtTitleCountdown\" onfocus=\"this.form.txtPropertyTitle.focus();\" size=\"1\" value=\"70\" style=\"padding:0 2px 0 2px;background-color:#FFFFFF; top:-1px; left:-7px; position:relative; text-align:left; width: 30px; border:0px solid #FFFFFF; color:#FF0000; \"></span>";
                            }
                            ?>
                        </span>
                        </td>
                    </tr>
                    <tr>
                        <td width="155" align="right" valign="middle">&nbsp;</td>
                        <td colspan="2" valign="middle">
                        <a href="javascript:toggleLayer1('ANP-Example');" title="See example" class="blue-link"><?php echo tranText('see_examples'); ?></a>
                        <span class="black">NB:</span><?php echo tranText('this_will_appear_as_the_headline_on_all_search_listings_so_make_it_good'); ?>
                        <div id="ANP-Example" class="box cursor1" style="display:none; position:absolute; left:330px; top:435px;">
                            <!--[if IE]><iframe id="iframe" frameborder="0" style="position:absolute;top:3px;left:2px;width:312px; height:173px;"></iframe><![endif]-->
                            <div class="content">
                                <div onMouseDown="dragStart(event, 'ANP-Example');" style="position:relative; z-index:999;left:0px;width:320px;">
                                    <table width="320" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td align="right"><img src="<?php echo SITE_IMAGES;?>poplefttop.png" alt="ANP" height="10" width="10" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo SITE_IMAGES;?>poplefttop.png', sizingMethod='scale');" /></td>
                                            <td class="topp"></td>
                                            <td><img src="<?php echo SITE_IMAGES;?>poprighttop1.png" alt="ANP"  height="10" width="15" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo SITE_IMAGES;?>poprighttop1.png', sizingMethod='scale');"/></td>
                                        </tr>
                                        <tr>
                                            <td class="leftp"></td>
                                            <td width="290" align="left" valign="top" bgcolor="#FFFFFF" style="padding:6px;">
                                                <table width="290" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td align="left" valign="top" class="font14-black"><?php echo tranText('see_examples'); ?></td>
                                                        <td width="15" align="right" valign="top" class="pad-rgt4"><a href="javascript:toggleLayer1('ANP-Example');"><img src="<?php echo SITE_IMAGES;?>pop-up-cross.gif" alt="Close" title="Close" border="0" /></a></td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left" valign="top" style="padding-top:10px;">
                                                        Stunning Beachfront Luxury<br />
                                                        <br />
                                                        Stunning beachfront suite at the prestigious Residencias Molino de Agua where the river meets the ocean.
                                                        </td>
                                                        <td align="left" valign="top"></td>
                                                    </tr>
                                                    <tr><td colspan="2" height="10"></td></tr>
                                                    <tr><td colspan="2" align="left" valign="top"><a href="javascript:toggleLayer1('ANP-Example');"><img src="<?php echo SITE_IMAGES;?>ANP-Pop-Cancel.gif" alt="Cancel" name="Cancel" width="48" height="21" border="0" /></a></td></tr>
                                                </table>
                                            </td>
                                            <td class="rightp" width="10"></td>
                                        </tr>
                                        <tr>
                                            <td align="right"><img src="<?php echo SITE_IMAGES;?>popleftbtm.png" alt="ANP" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo SITE_IMAGES;?>popleftbtm.png', sizingMethod='crop');" width="10" height="10"/></td>
                                            <td  class="bottomp"></td>
                                            <td align="left"><img src="<?php echo SITE_IMAGES;?>poprightbtm1.png" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo SITE_IMAGES;?>poprightbtm1.png', sizingMethod='crop');" width="15" height="10" alt="ANP"/></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>                    
                        </td>
                    </tr>
                    <tr>
                        <td width="155" align="right" valign="top"><?php echo tranText('select_country'); ?><span class="red">*</span></td>
                        <td width="235" valign="middle">
                            <select name="txtPropertyCountry" id="txtPropertyCountryId" onchange="return chkSelectCountry();" style="display:block;" class="select216_5">
                                <option value=""><?php echo tranText('select_country'); ?>...</option>
                                <?php $locationObj->fun_getCountriesOptionsList('', " ");?>
                            </select>
                        </td>
                        <td width="274" valign="top">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="155" align="right" valign="top"><?php echo tranText('select_region'); ?><span class="red">*</span></td>
                        <td width="235" valign="middle">
                            <select name="txtPropertyArea" id="txtPropertyAreaId" style="display:block;" class="select216_5">
                                <option value="0" selected><?php echo tranText('select_region'); ?>...</option>
                                <?php 
                                    //$locationObj->fun_getAreaListOptions('', '');
                                ?>
                            </select>
                        </td>
                        <td width="274" valign="top"><span class="pdError1" id="showErrorPropertyLocationId"><?php if(array_key_exists('txtPropertyLocation', $form_array)) echo $form_array['txtPropertyLocation'];?></span></td>
                    </tr>
					<?php /*?>
                    <tr>
                        <td width="155" align="right" valign="top"><?php echo tranText('select_region'); ?><span class="red">*</span></td>
                        <td width="235" valign="middle">
                            <select name="txtPropertyArea" id="txtPropertyAreaId" onchange="return chkSelectArea();" style="display:block;" class="select216_5">
                                <option value="0" selected><?php echo tranText('select_region'); ?>...</option>
                                <?php 
                                    //$locationObj->fun_getAreaListOptions('', '');
                                ?>
                            </select>
                        </td>
                        <td width="274" valign="top">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="155" align="right" valign="top"><?php echo tranText('select_city'); ?><span class="red">*</span></td>
                        <td width="235" valign="middle">
                            <select name="txtPropertyRegion" id="txtPropertyRegionId" style="display:block;" class="select216_5">
                                <option value="0"><?php echo tranText('select_city'); ?>...</option>
                                <?php 
                                    //$locationObj->fun_getRegionListOptions('', '0', '');
                                ?>
                            </select>
                        </td>
                        <td width="274" valign="top">&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="155" align="right" valign="top">Address<span class="red">*</span></td>
                        <td width="235" valign="middle">
							<input name="txtPropertyLocation" id="txtPropertyLocationId" class="inpuTxt260" style="display:block;" value="">
                        </td>
                        <td width="274" valign="top"><span class="pdError1" id="showErrorPropertyLocationId"><?php if(array_key_exists('txtPropertyLocation', $form_array)) echo $form_array['txtPropertyLocation'];?></span></td>
                    </tr>
					<?php */?>
                    <tr>
                        <td align="right" valign="middle">&nbsp;</td>
                        <td colspan="2" valign="middle"><em>Location not found, <a href="<?php echo SITE_URL;?>owner-contact-us?sbj=2" target="_blank" class="blue-link">suggest your location</a></em></td>
                    </tr>
                    <tr>
                        <td align="right" valign="middle">&nbsp;</td>
                        <td colspan="2" valign="middle">
                        <input type="image" src="<?php echo SITE_IMAGES;?>nexstep.gif" alt="Submit" name="Submit" width="90" height="27" border="0" id="SubmitId"  onclick="return validateAddProperty();"></td>
                    </tr>
                </table>
            </form>
        </td>
    </tr>
</table>
