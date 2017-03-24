<?php

?>
<table width="690" border="0" cellspacing="0" cellpadding="0" class="font12">
	<tr>
		<td align="left" class="pad-btm15 "><img src="images/special.gif" alt="Special"/></td>
		<td  align="right" class="pad-btm15 "><a href="<?php echo $_SERVER['PHP_SELF']."?sec=spe&spe=pre&pid=".$propertyInfo['property_id'].""?>"><img src="images/confirm-add-out.gif" onMouseOver="this.src='images/confirm-add-over.gif'" onmouseout="this.src='images/confirm-add-out.gif'" alt="Confirm and Add to Cart" name="Image42" border="0" id="Image42" /></a></td>
	</tr>
    <tr><td colspan="2" align="left" valign="top" class="dash-top">&nbsp;</td></tr>
	<tr>
		<td colspan="2" align="left" valign="top" class="owner-headings2">What type of offer is it ?</td>
	</tr>
	<tr>
		<td colspan="2" align="left" valign="top" class="pad-top2">All these deals essentially work on the same principal, either a special offer, such as a FREE Hamper on Arrival or are monetary incentives, such as money off when booking between certain dates. All you have to do is decide where you want your offer to be displayed.</td>
	</tr>
	<tr>
    <td colspan="2" align="left" valign="bottom" class="pad-top10">
        <table width="400" border="0" cellpadding="0" cellspacing="0" class="radioLabel">
            <tr>
                <td><input name="RadioGroup1" type="radio" id="RadioGroup1_0" value="radio1" checked="checked" /></td>
                <td>Late deal</td>
                <td><input name="RadioGroup1" type="radio" id="RadioGroup1_0" value="radio1" checked="checked" /></td>
                <td>Early bird deal</td>
                <td><input name="RadioGroup1" type="radio" id="RadioGroup1_0" value="radio1" checked="checked" /></td>
                <td>Special offer</td>
            </tr>
        </table>
    </td>
	</tr>
    <tr><td colspan="2" align="left" valign="top" class="dash41">&nbsp;</td></tr>
	<tr>
		<td colspan="2" align="left" valign="top" ><span class="owner-headings2">Title of this special offer </span> &nbsp;E.g. 50% discount on two weeks or more in August</td>
	</tr>
	<tr>
		<td colspan="2" align="left" valign="top" class="pad-top15"><input type="text" class="Textfield370" name="textfield" id="textfield" /></td>
	</tr>
    <tr><td colspan="2" align="left" valign="top" class="dash41">&nbsp;</td></tr>
    <tr><td colspan="2" align="left" valign="top" class=" owner-headings2">Will the price be reduced?</td></tr>
    <tr>
        <td colspan="2" align="left" valign="top">
            <table width="90" cellpadding="0" cellspacing="0" class="radioLabel">
                <tr>
                    <td valign="middle">
                        <input name="RadioGroup1" type="radio" onClick="open_div('OFFERDIV','yesDisplay');" class="pad-top7" id="RadioGroup1_3" value="radio1" checked="checked" />
                    </td>
                    <td valign="middle">
                    Yes
                    </td>
                    <td valign="middle">
                        <input type="radio" name="RadioGroup1" onClick="open_div('OFFERDIV','noDispaly');" value="radio2" id="RadioGroup1_4" />
                    </td>
                    <td valign="middle">No</td>
                </tr>
            </table>
        </td>
    </tr>
<tr>		
<td colspan="2">
    <div id="yesDisplay" style="display:none;">
    <table width="690" cellpadding="0" cellspacing="0" border="0">
        <tr height="15"><td></td></tr>
        <tr>
            <td colspan="2" align="left" valign="top" class=" pad-btm15">
                NB: These prices will appear automatically in <span class="red12">RED</span> on your price chart for the duration of your advert
            </td>
        </tr>
        <tr>
            <td colspan="2" align="left" valign="top" class="pad-btm20">Select currency  &nbsp;
            <label>					
                <select name="pr_currency" class="currency">
                    <option value="">Please select…</option>
                    <option value="ad">American Dollar ($)</option>
                    <option value="bp">British Pounds (&pound;)</option>
                    <option value="eu">Euro (&euro;)</option>
                    <option value="sar">Spainn Rand</option>
                </select>
            </label>
            </td>
        </tr>
<tr>
<td colspan="2" align="left" valign="top">
Minimum stay                   
<select name="select2" id="select2">
<?php for($i=1; $i<15; $i++){?>
<option value="<?php echo $i?>"><?php echo $i?></option>
<?php }?>
</select>
<select name="select3" id="select3">
<option value="day">Day</option>
<option value="week">Week</option>
</select>
&nbsp;Price per week                   
<input name="textfield3" type="text" class="Textfield50" id="textfield3" />
&nbsp;per midweek night                   
<input name="textfield4" type="text" class="Textfield50" id="textfield4" />
&nbsp;per weekend night                    
<input name="textfield5" type="text" class="Textfield50" id="textfield5" />
</td>
</tr>
</table>
</div>
<div id="OFFERDIV"></div>
<div id="noDispaly" style="display:none;"></div><strong></strong>
<script>open_div('OFFERDIV', 'yesDisplay');</script>			
</td>		
</tr>
<tr><td colspan="4" align="left" valign="top" class="dash41">&nbsp;</td></tr>
<tr>
<td colspan="2" align="left" valign="top"><span class=" owner-headings2 pad-top15">Describe your special offer</span>&nbsp; <a href="#" class="blue-link">View example</a></td>
</tr>
<tr>
<td colspan="2" align="left" valign="top" class="pad-top15 pad-btm20"><textarea name="textfield2" class="Textarea370" id="textfield2"></textarea></td>
</tr>
<tr>
<td colspan="2" align="left" valign="top" class="dash-top">&nbsp;</td>
</tr>
<tr>
<td colspan="2" align="left" valign="top" class=" owner-headings2">When and how long do you want this offer to be advertised for?</td>
</tr>
<tr>
<td colspan="2" align="left" valign="middle" class="pad-btm5">
Start displaying advert
<select name="from_date" id="from_date" class="PricesDate" style="width:38px;">
</select>
<script language="javascript" type="text/javascript">
buildPriceDate('from_date', 1, 31, '<?php echo $_POST['from_date']?>');
</script>
<select name="from_month" id="from_month" class="PricesDate">										
</select>
<script language="javascript" type="text/javascript">
buildPriceMonth('from_month', '<?php echo $_POST['from_month']?>');
</script>
<select name="from_year[]" id="from_year" class="PricesDate" style="width:52px;">										
</select>
<script language="javascript" type="text/javascript">						
var dateObj	= new Date();
var curYear = dateObj.getFullYear();									
var endYear	= curYear+3;
buildPriceYear('from_year', curYear, endYear, '<?php echo $_POST['from_year']?>');
</script>			
<img src="images/calender.gif" alt="calendar" align="absmiddle" /> &nbsp;for &nbsp;
<select name="from_date4" id="from_date4" class="PricesDate" style="width:38px;">
<?php for($i=1; $i<53; $i++){?>
<option value="<?php echo $i?>"><?php echo $i?></option>
<?php }?>
</select>
<select name="min_type2" class="PricesDays">
<option value="weeks">Week</option>
</select>
<span class=" radioLabel pad-lft20"> Advertising cost: &pound;100.00 </span>
</td>
</tr>
<tr>
<td colspan="2" align="left" valign="top" class="dash41">&nbsp;</td>
</tr>
<tr>
<td colspan="2" align="left" valign="top" class="pad-btm20 dash-btm"><p class="FloatLft"> <a href="#" ><img src="images/Cancel-48x21-normal.gif" onmouseover="this.src='images/Cancel-48x21-over.gif'" onmouseout="this.src='images/Cancel-48x21-normal.gif'" alt="Cancel" name="Image4" border="0" id="Image4" /></a> </p>
<p class="FloatRgt"><a href="<?php echo $_SERVER['PHP_SELF']."?sec=spe&spe=pre&pid=".$propertyInfo['property_id'].""?>"><img src="images/confirm-add-out.gif" onMouseOver="this.src='images/confirm-add-over.gif'" onmouseout="this.src='images/confirm-add-out.gif'" alt="Confirm and Add to Cart" name="Image42" border="0" id="Image42" /></a></p></td>
</tr>
</table>
<script>open_div('OFFERDIV', 'yesDispaly');</script>