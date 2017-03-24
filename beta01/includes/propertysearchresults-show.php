<table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
<?php
if(is_array($propListArr) && count($propListArr) > 0) {
	/*
    if(is_array($destinationInfoArr) && count($destinationInfoArr) > 0) {
		$area_name = ucwords($destinationInfoArr['destination_name']);
		$area_desc = ucfirst($destinationInfoArr['destination_desc']);
	} else {
		$area_name = tranText('worldwide');
		$area_desc = tranText('site_notes_worldwide_accommodation');
	}
	*/
    ?>
	<?php /*?>
	<tr>
        <td align="left"  valign="top">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="left" class="gray14"><?php echo $area_name; ?>&nbsp;<?php echo tranText('accommodation'); ?></td>
                    <td width="45px" align="center"><img src="<?php echo SITE_IMAGES;?>view-map.jpg" /></td>
                    <td width="80px"><h4 class="nav7"><a href="javascript:void(0);" onclick="changeMapMode();">View Map</a></h4></td>
                    <td width="45px" align="center"><img src="<?php echo SITE_IMAGES;?>new-search.jpg" /></td>
                    <td width="90px"><h4 class="nav7"><a href="<?php echo SITE_URL; ?>accommodation" onclick="removeSearch();">New Search</a></h4></td>
                </tr>
            </table>
            <p class="font12 pad-top10"><?php echo $area_desc;?></p>
        </td>
    </tr>
    <tr><td align="left" valign="top">&nbsp;</td></tr>
    <tr>
        <td bgcolor="#e7e6e6">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <th width="60px" height="40" align="right" scope="col"><?php echo tranText('view_by'); ?></th>
                    <th width="200px" height="40" align="left" scope="col" class="pad-lft10">
                    <select name="txtSortBy" id="txtSortById" class="Listmenu195" onchange="return sortby();">
                        <option value="0"><?php echo tranText('availability_last_updated'); ?></option>
                        <option value="1" <?php if(isset($sortby) && $sortby == "1") { echo " selected=\"selected\""; }?> ><?php echo tranText('price_low_to_high'); ?></option>
                        <option value="2" <?php if(isset($sortby) && $sortby == "2") { echo " selected=\"selected\""; }?> ><?php echo tranText('price_high_to_low'); ?></option>
                        <option value="3" <?php if(isset($sortby) && $sortby == "3") { echo " selected=\"selected\""; }?> ><?php echo tranText('number_of_Reviews'); ?></option>
                        <option value="4" <?php if(isset($sortby) && $sortby == "4") { echo " selected=\"selected\""; }?> ><?php echo tranText('special_offers_First'); ?></option>
                    </select>
                    </th>
                    <th width="150px" height="40" align="right" scope="col"><?php echo tranText('only_show_late_deals'); ?></th>
                    <th width="20px" height="40" scope="col" class="pad-lft10">
                    <input name="txtShowDeal" type="checkbox" class="checkbox" id="txtShowDealId" value="1" onclick="return showlatedeal();" <?php if(isset($latedeal) && $latedeal == "1") { echo "checked=\"checked\""; }?> />
                    </th>
                    <th width="150px" height="40" align="right" scope="col"><?php echo tranText('view_prices_in'); ?>-</th>
                    <th width="200px" height="40" align="left" scope="col" class="pad-lft10">
                    <select name="txtCurrencyType" id="txtCurrencyType" class="Listmenu195" onchange="convertCurrency(this.value);">
                        <?php $propertyObj->fun_getCurrenciesOptionsListWithCodeSymbl($currency_code); ?>
                    </select>
                    </th>
				</tr>
            </table>
        </td>
	</tr>
	<?php */?>
    <tr>
        <td align="left" valign="middle" class="pad-btm5">
            <ul style="width:680px;">
                <li class="pad-top15" style="width:230px;"><?php if(isset($pagination['total_rows']) && $pagination['total_rows'] > 1) { echo "Showing ".$pagination['first_row']." to ".$pagination['last_row']." of ".$pagination['total_rows']." rental properties";} else if(isset($pagination['total_rows']) && $pagination['total_rows'] == 1){echo "Showing ".$pagination['first_row']." to ".$pagination['last_row']." of ".$pagination['total_rows']." rental property";} ?></li>
                <li id="listing-head">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <th width="60px" align="right" scope="col">
							<?php /*?>
							<?php echo tranText('view_by'); ?>
							<?php */?>
                            </th>
                            <th width="200px" align="left" scope="col" class="pad-lft10">
                            <select name="txtSortBy" id="txtSortById" class="Listmenu195" onchange="return sortby();">
                                <option value="0"><?php echo tranText('availability_last_updated'); ?></option>
                                <option value="1" <?php if(isset($sortby) && $sortby == "1") { echo " selected=\"selected\""; }?> ><?php echo tranText('price_low_to_high'); ?></option>
                                <option value="2" <?php if(isset($sortby) && $sortby == "2") { echo " selected=\"selected\""; }?> ><?php echo tranText('price_high_to_low'); ?></option>
                                <option value="3" <?php if(isset($sortby) && $sortby == "3") { echo " selected=\"selected\""; }?> ><?php echo tranText('number_of_Reviews'); ?></option>
                                <option value="4" <?php if(isset($sortby) && $sortby == "4") { echo " selected=\"selected\""; }?> ><?php echo tranText('special_offers_First'); ?></option>
                            </select>
                            </th>
							<?php /*?>
                            <th width="150px" height="40" align="right" scope="col"><?php echo tranText('only_show_late_deals'); ?></th>
                            <th width="20px" height="40" scope="col" class="pad-lft10">
                            <input name="txtShowDeal" type="checkbox" class="checkbox" id="txtShowDealId" value="1" onclick="return showlatedeal();" <?php if(isset($latedeal) && $latedeal == "1") { echo "checked=\"checked\""; }?> />
                            </th>
                            <th width="150px" height="40" align="right" scope="col"><?php echo tranText('view_prices_in'); ?>-</th>
                            <th width="200px" height="40" align="left" scope="col" class="pad-lft10">
                            <select name="txtCurrencyType" id="txtCurrencyType" class="Listmenu195" onchange="convertCurrency(this.value);">
                                <?php $propertyObj->fun_getCurrenciesOptionsListWithCodeSymbl($currency_code); ?>
                            </select>
                            </th>
							<th width="90px"><h4 class="nav7"><a href="<?php echo SITE_URL; ?>accommodation" onclick="removeSearch();">New Search</a></h4></th>
							<?php */?>
                            <th align="center"><a href="javascript:void(0);" class="listing-liston">List</a><a href="javascript:void(0);" onclick="changeMapMode();" class="listing-mapoff">Map</a></th>
                        </tr>
                    </table>
                </li>
            </ul>
        </td>
    </tr>
    <tr>
        <td align="left" valign="top">
			<?php require_once(SITE_INCLUDES_PATH.'propertysearchresults-show-listing.php'); ?>
        </td>
    </tr>
    <tr>
        <td align="left" valign="middle" class="pad-top5 pad-btm5">
            <ul>
                <li class="paging pad-lft5" style="float:right; clear:right;">
                    <?php
                    if(isset($pagination['pages']) && $pagination['pages'] != "") {
                        if(isset($pagination['prev']) && $pagination['prev'] !="") {
                            echo "<a href=\"".$pagination['prev']."\" class=\"previous\">Previous</a>";
                        }
                        if(($pagination['pages'][0]['no']) > 1) {
                            echo "<span>...</span>";
                        }
                        foreach($pagination['pages'] as $key => $value) {
                            if(isset($value['link']) && $value['link'] != "") {
                                echo "<a href=\"".$value['link']."\">".($value['no'])."</a>";
                            } else {
                                echo "<span>".($value['no'])."</span>";
                            }
                        }
                        if(($pagination['pages'][count($pagination['pages'])-1]['no']) < ($pagination['total_rows']/GLOBAL_RECORDS_PER_PAGE)) {
                            echo "<span>...</span>";
                        }
                        if(isset($pagination['next']) && $pagination['next'] !="") {
                            echo "<a href=\"".$pagination['next']."\" class=\"next\">&gt;&gt;Next</a>";
                        }
                    } else {
                        echo "&nbsp;";
                    }
                    ?>
                </li>
            </ul>
        </td>
    </tr>
<?php
} else {
	if(isset($shwnoresults) && $shwnoresults == "yes") {
	?>
		<tr><td align="left" valign="top" class="pad-top15"><span class="pink18arialbold">Oops, there’s no results for that search</span></td></tr>
		<tr><td align="left" valign="top" class="pad-top15 font14">Try broadening you&rsquo;re search using the Refine search panel</td></tr>
	<?php
	}
}
?>
</table>