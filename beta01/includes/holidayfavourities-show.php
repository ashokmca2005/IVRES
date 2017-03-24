<table width="690" border="0" cellspacing="0" cellpadding="0" class="font12">
	<?php
    if(is_array($propListArr) && count($propListArr) > 0) {
    ?>
    <tr>
        <td width="690" colspan="2" align="left" valign="bottom">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr><td colspan="2" align="left" valign="top" class=" pad-btm5"></td></tr>
                <tr><td colspan="2" align="left" valign="top" class="pad-top10 pad-btm5">Displaying 1-<?php echo count($propListArr); ?> of <?php echo count($propListArr); ?> properties</td></tr>
                <tr>
					<td colspan="2" align="left" valign="top">
					<div class="pagination">
	<!--
	<a href="#">First</a> &lt; <a href="#">1</a> | 2 | <a href="#">3</a> | <a href="#">4</a> | <a href="#">5</a>| <a href="#">6</a> | <a href="#">7</a> | <a href="#">8</a> | <a href="#">9</a> | <a href="#">10</a> ...<a href="#">23</a> &gt; <a href="#">Last</a>
	-->
					</div>
					</td>
				</tr>
                <tr><td colspan="2" align="left" valign="top">&nbsp;</td></tr>
                <tr>
                    <td colspan="2" align="left" valign="top" class="pad-top2">
                    <!-- tabbing start -->
                    <div class="RegFormMain">
                        <!--Tabbing Starts Here -->
                        <ul>
                            <li class="tabRightBg" style="width:60px;"><div class="pad-top5">View by</div></li>
                            <li><a href="" title="Areas you are intrested in"><img src="images/tab-lowest-price-s.gif" border="0" /></a></li>
                            <li><a href="" title="Details of your enquiry"><img src="images/tab-highest-price-n.gif" border="0" /></a></li>
                            <li><a href="" title="Details of your enquiry"><img src="images/tab-customer-rating-n.gif" border="0" /></a></li>
                            <li><a href="" title="Details of your enquiry"><img src="images/tab-tourism-rating-n.gif" border="0" /></a></li>
                            <li><a href="" title="Details of your enquiry"><img src="images/tab-checklist-rating-n.gif" border="0" /></a></li>
                            <li class="tabRightBg" style="width:47px;"></li>
                        </ul>
                        <!--Tabbing Ends Here -->
                        <!--Tab1 Content Starts Here -->
                        <div class="tcontent1" style="padding-top:5px;">
                        <table border="0" cellspacing="0" cellpadding="1">
                            <tr>
                                <td valign="middle" class="pad-rgt10">Only show</td>
                                <td valign="middle"><input name="checkbox" type="checkbox" class="checkbox" id="checkbox" /></td>
                                <td valign="middle" class="pad-rgt5 pad-left3">Late deals</td>
                                <td valign="middle"><input name="checkbox1" type="checkbox" class="checkbox" id="checkbox1" /></td>
                                <td valign="middle" class="pad-rgt5 pad-left3">Early bird deals</td>
                                <td valign="middle"><input name="checkbox1" type="checkbox" class="checkbox" id="checkbox1" /></td>
                                <td valign="middle" class="pad-left3">Special offers</td>
                            </tr>
                            <tr><td colspan="7" align="left" valign="top" class=" pad-btm5"></td></tr>
                        </table>
						<?php require_once('holidayfavourities-show-listing.php'); ?>
                        </div>
                    </div>
                    </td>
                </tr>
                <tr><td colspan="2" align="left" valign="top" class=" pad-btm5"></td></tr>
                <tr>
					<td colspan="2" align="left" valign="top">
					<div class="pagination">
	<!--
	<a href="#">First</a> &lt; <a href="#">1</a> | 2 | <a href="#">3</a> | <a href="#">4</a> | <a href="#">5</a>| <a href="#">6</a> | <a href="#">7</a> | <a href="#">8</a> | <a href="#">9</a> | <a href="#">10</a> ...<a href="#">23</a> &gt; <a href="#">Last</a>
	-->
					</div>
					</td>
				</tr>
            </table>
        </td>
    </tr>
	<?php
    } else {
    ?>
    <tr>
        <td width="690" colspan="2" align="left" valign="bottom">
            <table width="690" border="0" cellspacing="0" cellpadding="0" class="font12">
				<tr>
					<td width="690" colspan="2" align="left" valign="bottom">
						<table width="690" border="0" cellspacing="0" cellpadding="0">
							<!-- Not Added to faviroute : Start Here -->
								<tr><td colspan="2" align="left" valign="top" class=" pad-top7"><span class="redHead "><br />No favourite property added </span> <br /><br /></td></tr>
							<!-- Not Added to faviroute : End Here -->
						</table>
					</td>
				</tr>
			</table>
        </td>
    </tr>
    <?php
	}
	?>
</table>
