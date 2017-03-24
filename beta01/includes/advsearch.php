<?php 
$dayname 	= array('01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31');
$monthname 	= array('01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'May','06'=>'Jun','07'=>'Jul','08'=>'Aug','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec');
$yearname 	= array(date('Y')+0,date('Y')+1,date('Y')+2,date('Y')+3);
$stayname 	= array('01','02','03','04','05','06','07','08','09','10','11','12','13','14');
?>
<script language="javascript">
// JavaScript Document
	var req = ajaxFunction();
	var x1 = "";
	var y1 = "";

	function find_cal(a,ct){
		var url="<?php echo SITE_URL; ?>get_cal.php";
		url=url+"?timestamp="+a+"&ct="+ct;
		req.onreadystatechange=function(){
			if (req.readyState==4){
				var object;
				object = req.responseText;				
				x1 = x+160;
				y1 = y-153;
				var googlewin=dhtmlwindow.open("CalendarDiv", "inline", object, " ", "width=235px,height=285px,resize=0,scrolling=0,center=1,xAxis="+x1+",yAxis="+y1+"", "recal");
				googlewin.onclose=function(){ //Run custom code when window is being closed (return false to cancel action):
					return true
				}
			}
		}
		req.open("GET",url,true);
		req.send(null);
	}

	function find_cal1(a,ct){
		var url="<?php echo SITE_URL; ?>get_cal1.php";
		url=url+"?timestamp="+a+"&ct="+ct;
		req.onreadystatechange=function(){
			if (req.readyState==4){
				var object;
				object = req.responseText;				
				x1 = x-75;
				y1 = y-153;
				var googlewin=dhtmlwindow.open("CalendarDiv", "inline", object, " ", "width=235px,height=285px,resize=0,scrolling=0,center=1,xAxis="+x1+",yAxis="+y1+"", "recal");
				googlewin.onclose=function(){ //Run custom code when window is being closed (return false to cancel action):
					return true
				}
			}
		}
		req.open("GET",url,true);
		req.send(null);
	}

	function find_cal2(a,ct){
		var url="<?php echo SITE_URL; ?>get_cal1.php";
		url=url+"?timestamp="+a+"&ct="+ct;
		req.onreadystatechange=function(){
			if (req.readyState==4){
				var object;
				object = req.responseText;				
				var googlewin=dhtmlwindow.open("CalendarDiv", "inline", object, " ", "width=235px,height=285px,resize=0,scrolling=0,center=1,xAxis="+x1+",yAxis="+y1+"", "recal");
				googlewin.onclose=function(){ //Run custom code when window is being closed (return false to cancel action):
					return true
				}
			}
		}
		req.open("GET",url,true);
		req.send(null);
	}

	function find_cal3(a,ct){
		var url="<?php echo SITE_URL; ?>get_cal.php";
		url=url+"?timestamp="+a+"&ct="+ct;
		req.onreadystatechange=function(){
			if (req.readyState==4){
				var object;
				object = req.responseText;				
				var googlewin=dhtmlwindow.open("CalendarDiv", "inline", object, " ", "width=235px,height=285px,resize=0,scrolling=0,center=1,xAxis="+x1+",yAxis="+y1+"", "recal");
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
	
		var strDayId = "txtDay"+sid;
		var strMonthId = "txtMonth"+sid;
		var strYearId = "txtYear"+sid;

		document.getElementById(strMonthId).value = String(dateBody[0]);
		document.getElementById(strDayId).value = String(dateBody[1]);
		document.getElementById(strYearId).value = String(dateBody[2]);
		if(sid == "From0") {
			fill_to_from_date();
		}
		document.getElementById("CalendarDiv").style.display = "none";
	}

	function fill_to_from_date() {
		if(document.getElementById("txtDayFrom0").value != "" && document.getElementById("txtMonthFrom0").value != "" && document.getElementById("txtYearFrom0").value != "") {
			document.getElementById("txtDayTo0").value = document.getElementById("txtDayFrom0").value;
			document.getElementById("txtMonthTo0").value = document.getElementById("txtMonthFrom0").value;
			document.getElementById("txtYearTo0").value = document.getElementById("txtYearFrom0").value;
		}
	} 

	function close_calendar(){		
		document.getElementById("CalendarDiv").style.display = "none";
	}
</script>
<form name="frmAdvSearch" id="frmAdvSearch" action="<?php echo SITE_URL."accommodation"; ?>" method="post" >
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
    <tr>
        <td>
            <table width="1029" border="0" cellspacing="5" cellpadding="0" class="form_row" >
                <tr><td><h3 class="title">Where would you like to go?</h3></td></tr>
                <tr>
                    <td width="232"> Destination or keywords</td>
                    <td width="782"><input type="text" name="destinations" id="destinations" class="searchBox1" value="eg Los Angeles or Chicago ..." onclick="return bnkAdvSearch();" onblur="return restoreAdvSearch();" autocomplete="off"  style="width:400px;"/></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <table width="1029" border="0" cellspacing="5" cellpadding="0" class="form_row">
                <tr><td width="280"><h3 class="title">When would you like to go?</h3></td></tr>
                <tr>
                    <td>
                        <table width="636" border="0" cellspacing="5" cellpadding="0">
                            <tr>
                                <td class="pad-rgt5" width="89" align="right">Arrival</td>
                                <td width="637" colspan="2" align="left" valign="top" class="pad-btm3">
                                    <table border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td>
                                                <table border="0" cellpadding="1" cellspacing="0">
                                                    <tr>
                                                        <td>
                                                        <select name="txtDayFrom0" id="txtDayFrom0" class="Listmenu45" onchange="fill_to_from_date();">
                                                            <option value=""> - - </option>
                                                            <?
                                                            foreach($dayname as $key => $value)	{
                                                            ?>
                                                                <option value="<?php echo $value;?>" <? if(isset($txtDayFrom0) && ($value == $txtDayFrom0)){echo "selected";} else{echo "";}?>><?php echo ($key+1)?></option>
                                                            <?
                                                            }
                                                            ?>
                                                        </select>										
                                                        </td>
                                                        <td>
                                                        <select name="txtMonthFrom0" id="txtMonthFrom0" class="Listmenu55" onchange="fill_to_from_date();">										
                                                            <option value=""> - - </option>
                                                            <?
                                                            foreach ($monthname as $key => $value) {
                                                            ?>
                                                                <option value="<?php echo $key?>" <? if(isset($txtMonthFrom0) && ($key==$txtMonthFrom0)){echo "selected";} else{echo "";}?>><?php echo $value;?></option>
                                                            <?
                                                            }
                                                            ?>
                                                        </select>
                                                        </td>
                                                        <td align="right">
                                                        <select name="txtYearFrom0" id="txtYearFrom0" class="Listmenu60" onchange="fill_to_from_date();">
                                                            <option value=""> - - </option>
                                                            <?
                                                            foreach ($yearname as $value) {
                                                            ?>
                                                                <option value="<?php echo $value;?>" <? if(isset($txtYearFrom0) && ($value==$txtYearFrom0)){echo "selected";} else{echo "";}?>><?php echo $value;?></option>
                                                            <?
                                                            }
                                                            ?>
                                                        </select>										
                                                        </td>
                                                        <td align="right"><a href="JavaScript:find_cal(<?php echo time()?>,'From0');"><img src="<?php echo SITE_IMAGES;?>calender.gif" alt="calendar" /></a></td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td class="pad-rgt5 pad-lft10">Departure</td>
                                            <td>
                                                <table border="0" cellpadding="1" cellspacing="0" class="pink12arial">
                                                    <tr>
                                                        <td>
                                                            <select name="txtDayTo0" id="txtDayTo0" class="Listmenu45">
                                                                <option value=""> - - </option>
                                                                <?
                                                                foreach($dayname as $key => $value)	{
                                                                ?>
                                                                    <option value="<?php echo $value;?>" <? if(isset($txtDayTo0) && ($value==$txtDayTo0)){echo "selected";} else{echo "";}?>><?php echo ($key+1)?></option>
                                                                <?
                                                                }
                                                                ?>
                                                            </select>										
                                                        </td>
                                                        <td>
                                                            <select name="txtMonthTo0" id="txtMonthTo0" class="Listmenu55">										
                                                                <option value=""> - - </option>
                                                                <?
                                                                foreach ($monthname as $key => $value) {
                                                                ?>
                                                                    <option value="<?php echo $key?>" <? if(isset($txtMonthTo0) && ($key==$txtMonthTo0)){echo "selected";} else{echo "";}?>><?php echo $value;?></option>
                                                                <?
                                                                }
                                                                ?>
                                                            </select>										
                                                        </td>
                                                        <td align="right">
                                                            <select name="txtYearTo0" id="txtYearTo0" class="Listmenu60">
                                                                <option value=""> - - </option>
                                                                <?
                                                                foreach ($yearname as $value) {
                                                                ?>
                                                                    <option value="<?php echo $value;?>" <? if(isset($txtYearTo0) && ($value==$txtYearTo0)){echo "selected";} else{echo "";}?>><?php echo $value;?></option>
                                                                <?
                                                                }
                                                                ?>
                                                            </select>										
                                                        </td>
                                                        <td align="right"><a href="JavaScript:find_cal(<?php echo time()?>,'To0');"><img src="<?php echo SITE_IMAGES;?>calender.gif" alt="calendar" /></a></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>                                                                
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr><td class="pad-lft10"><input type="image" src="<?php echo SITE_IMAGES; ?>search.gif" alt="Search" /></td></tr>
</table>
</form>
