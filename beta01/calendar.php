<link href="css/dhtmlwindow.css"  rel="stylesheet" type="text/css" />
<link href="css/pop-up-cal.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="includes/js/dhtmlwindow.js" type="text/javascript"></script>
<script language="javascript">
// JavaScript Document
var req = ajaxFunction();

//	var cnt = 0;
	function find_cal(a,ct){
		var url="get_cal.php";
		url=url+"?timestamp="+a+"&ct="+ct;
		req.onreadystatechange=function(){
			if (req.readyState==4){
				var object;
				object = req.responseText;				
				var googlewin=dhtmlwindow.open("CalendarDiv", "inline", object, "Calendar", "width=235px,height=285px,resize=0,scrolling=0,center=1,xAxis=220,yAxis=220", "recal");
				googlewin.onclose=function(){ //Run custom code when window is being closed (return false to cancel action):
					return true
				}
			}
		}
		req.open("GET",url,true);
		req.send(null);
	}
	
	function insert_date(dt,sid){
		var dateString = String(dt);
		var dateBody = dateString.split("/");
	
		var strMonthId = "mID"+sid;
		var strDayId = "dID"+sid;
		var strYearId = "yID"+sid;

		document.getElementById(strMonthId).value = parseInt(dateBody[0]);
		document.getElementById(strDayId).value = parseInt(dateBody[1]);
		document.getElementById(strYearId).value = parseInt(dateBody[2]);
		document.getElementById("CalendarDiv").style.display = "none";
	}

	function close_calendar(){		
		document.getElementById("CalendarDiv").style.display = "none";
	}
</script>

<div id="priceCalendar" style="background-color:transparent;"></div>

<?php 
	$month_array = array('', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
	$cnt = "0";
?>
<table border="0" cellpadding="0" cellspacing="0">	
	<tr class="bg3">
		<td colspan="5">Select a date: 
			<select id="mID0" name="mID[]">
				<?php for($i=1,$j=1; $i<count($month_array); $i++,$j++){?>
					<?php if($i<9){ $j = '0'.$i;}?>
					<option value="<?php echo $i;?>"><?php echo $month_array[$i];?></option>
				<?php }?>
			</select>
			<select id="dID0" name="dID[]">
				<?php for($i=1; $i<32; $i++){?>
					<option value="<?php echo $i;?>"><?php echo $i;?></option>
				<?php }?>
			</select>
			<select id="yID0" name="yID[]">
				<?php for($i=2008; $i<2014; $i++){?>
					<option value="<?php echo $i;?>"><?php echo $i;?></option>
				<?php }?>
			</select>
			<a href="JavaScript:find_cal(<?php echo time()?>,<?php echo $cnt?>)"><img src="images/calendar.gif" border="0"/></a>
		</td>
	</tr>
</table>