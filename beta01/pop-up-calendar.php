<?php 
	$month_array = array('', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
	$cnt = 0;
?>
<table border="0" cellpadding="0" cellspacing="0">	
	<tr class="bg3">
		<td colspan="5">Select a date: 
			<select id="mID" name="mID">
				<?php for($i=1,$j=1; $i<count($month_array); $i++,$j++){?>
					<?php if($i<9){ $j = '0'.$i;}?>
					<option value="<?php echo $i;?>"><?php echo $month_array[$i];?></option>
				<?php }?>
			</select>
			<select id="dID" name="dID">
				<?php for($i=1; $i<32; $i++){?>
					<option value="<?php echo $i;?>"><?php echo $i;?></option>
				<?php }?>
			</select>
			<select id="yID" name="yID">
				<?php for($i=2008; $i<2014; $i++){?>
					<option value="<?php echo $i;?>"><?php echo $i;?></option>
				<?php }?>
			</select>
			<a href="JavaScript:find_cal(<?php echo time()?>,<?php echo $cnt?>)"><img src="images/calendar.gif" border="0"/></a>
		</td>
	</tr>
</table>