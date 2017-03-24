<?php
if($message_id == "" && isset($_GET['msgid']) && $_GET['msgid'] !=""){
	$message_id 		= $_GET['msgid'];
	$messageInfoArr 	= $messageObj->fun_getMessageInfo($message_id);
	$message_subject 	= $messageInfoArr['message_subject'];
	$message_body 		= $messageInfoArr['message_body'];
	$message_received_on= date('F d, Y', strtotime($messageInfoArr['message_created_on']));
	$sender_fname 		= $messageInfoArr['user_fname'];
	$sender_lname 		= $messageInfoArr['user_lname'];
	$sender_full_name 	= $sender_fname." ".$sender_lname;
} else {
	$userInboxArr 		= $messageObj->fun_getUserInboxArr($user_id);
	$userOutboxArr 		= $messageObj->fun_getUserOutboxArr($user_id);
}

if(isset($message_id) && $message_id !=""){
?>
<table width="690" border="0" cellspacing="0" cellpadding="0" class="font12">
    <tr>
        <td align="left" valign="top">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td height="31" align="left" valign="middle" class="dash-btm"><div align="left"><a href="owner-messages.php" class="back-messages">Back to messages</a></div></td>
                    <td height="31" align="left" valign="middle" class="dash-btm"><div align="right"><a href="#" class="print-messages">Print this message</a></div></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr><td align="left" valign="top" class="pad-btm10 pad-top20 owner-headings">From</td></tr>
    <tr>
        <td align="left" valign="top">
            <table width="690" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="120" height="20" align="left" valign="top" class="dash-btm">Subject</td>
                    <td height="20" align="left" valign="top" class="dash-btm bold black"><?php echo $message_subject;?></td>
                </tr>
                <tr>
                    <td width="120" height="20" align="left" valign="top" class="dash-btm pad-topbtm2">From</td>
                    <td height="20" align="left" valign="top" class="dash-btm bold black pad-topbtm2"><?php echo $sender_full_name;?></td>
                </tr>
                <tr>
                    <td width="120" height="20" align="left" valign="top" class="dash-btm pad-topbtm2">Received</td>
                    <td height="20" align="left" valign="top" class="dash-btm bold black pad-topbtm2"><?php echo $message_received_on;?></td>
                </tr>

<!--
                <tr>
                    <td width="120" height="20" align="left" valign="top" class="dash-btm pad-topbtm2">Telephone</td>
                    <td height="20" align="left" valign="top" class="dash-btm bold black pad-topbtm2">+44 (0) 1572 826666</td>
                </tr>
                <tr><td colspan="2" align="left" valign="top" class="pad-top20 owner-headings">Details of enquiry</td></tr>
                <tr>
                    <td width="120" height="20" align="left" valign="top" class="dash-btm pad-">Adult</td>
                    <td height="20" align="left" valign="top" class="dash-btm bold black">2</td>
                </tr>
                <tr>
                    <td width="120" height="20" align="left" valign="top" class="dash-btm pad-topbtm2">Children</td>
                    <td height="20" align="left" valign="top" class="dash-btm bold black pad-topbtm2">3</td>
                </tr>
                <tr>
                    <td width="120" height="20" align="left" valign="top" class="dash-btm pad-topbtm2">Infants</td>
                    <td height="20" align="left" valign="top" class="dash-btm bold black pad-topbtm2">1</td>
                </tr>
                <tr>
                    <td width="120" height="20" align="left" valign="top" class="dash-btm pad-topbtm2">Arrival date</td>
                    <td height="20" align="left" valign="top" class="dash-btm bold black pad-topbtm2">June 13, 2007</td>
                </tr>
                <tr>
                    <td width="120" height="20" align="left" valign="top" class="dash-btm pad-topbtm2">Departure date</td>
                    <td height="20" align="left" valign="top" class="dash-btm bold black pad-topbtm2">August 13, 2007</td>
                </tr>
                <tr>
                    <td width="120" height="20" align="left" valign="top" class="dash-btm pad-topbtm2">Flexibility</td>
                    <td height="20" align="left" valign="top" class="dash-btm bold black pad-topbtm2">Yes, + / - 7 days</td>
                </tr>
-->
            </table>
        </td>
    </tr>
    <tr>
        <td align="left" valign="top" class="pad-top20 pad-btm15">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="left" valign="top"><div align="left" class="owner-headings1">Message</div></td>
                    <td align="left" valign="top"><div align="right"><a href="#" class="delete-photo">Delete this message</a></div></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="left" valign="top">
			<?php echo $message_body;?>
        </td>
    </tr>
    <tr><td align="left" valign="top"><div class="width690 dash41">&nbsp;</div></td></tr>
    <tr><td align="left" valign="top" class="owner-headings">Reply to this message</td></tr>
    <tr>
        <td align="left" valign="top">
            <textarea class="messages-reply" name="textarea">Please type your reply to this message here</textarea>
        </td>
    </tr>
    <tr>
        <td align="left" valign="top">
            <p class="FloatLft" style="padding-top: 10px;"><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Homepage','','images/cancel-small-over.gif',1)"><img src="images/cancel-small.gif" alt="Cancel" name="Cancel" width="57" height="21" border="0" id="Homepage" /></a></p>
            <p class="FloatLft" style="padding-left: 10px; padding-top: 10px;"><a href="checklist.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Continue','','images/send-small-over.gif',1)"><img src="images/send-small.gif" alt="Send" name="Send" width="51" height="21" border="0" id="Continue" /></a></p>
        </td>
    </tr>
</table>
<?
}
else{
?>
<table width="690" border="0" cellspacing="0" cellpadding="0" class="font12">
    <tr>
        <td align="left" valign="top" class="pad-top15 pad-btm10">
            <div id="checkList"></div>
            <!--Tab1 Starts Here -->
            <div style="display:none;" id="Inbox" class="RegFormMain">
                <!--Tabbing Starts Here -->
                <ul class="messages-tab">
                <li class="messages-list1"></li>
                <li class="messages-list" id="current"><span class="left"><a href="javascript: open_div('checkList', 'Inbox');void(0);" title="Inbox"><img src="images/tab-inbox-selected.gif" width="31" height="29" border="0" align="top" /><span class="numbermsg">(<?php echo $messageObj->fun_countNewMessageInbox($user_id);?> new)</span></a></span></li>
                <li class="messages-list"><span class="left"><a href="javascript: open_div('checkList', 'Sent');void(0);" title="Sent"><img src="images/tab-sent-un-selected.gif" width="28" height="29" border="0" align="top" /></a></span></li>
                <li class="messages-list2">
                <a href="#">First</a> &lt; <a href="#">1</a> | 2 | <a href="#">3</a> | <a href="#">4</a> | <a href="#">5</a>|  <a href="#">6</a> | <a href="#">7</a> | <a href="#">8</a> | <a href="#">9</a> | <a href="#">10</a> ...<a href="#">23</a> &gt; <a href="#">Last</a>
                </li>
                </ul>
                <!--Tabbing Ends Here -->
                <!--Tab1 Content Starts Here -->
                <div class="inboxcontent">
                <form id="form1" name="form1" method="post" action="">
                <table width="690" border="0" cellpadding="0" cellspacing="0">
                    <tr><td class="pad-btm10 pad-top10"><div align="left"><a href="#" class="print-messages">Delete all marked</a></div></td></tr>
                    <tr>
                        <td>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="collapse">
                                <tr>
                                    <td class="MessagesHeadChkBoxTd"><input type="checkbox" class="checkbox" name="checkbox" /></td>
                                    <td class="MessagesHeadFromTd">From</td>
                                    <td class="MessagesHeadSubjectTd">Subject</td>
                                    <td class="MessagesHeadDateTd">Date received</td>
                                </tr>
								<?php
                                foreach($userInboxArr as $value){
                                    $message_id = $value['message_id'];
                                    $message_type = $value['message_type'];
                                    $message_subject = $value['message_subject'];
                                    $message_created_on = date('F d, Y', strtotime($value['message_created_on']));
                                    $message_reciever_rflag = $value['message_reciever_rflag'];
                                    if($message_reciever_rflag =="1"){
                                        $row_class = "MessagesRead";
                                    }
                                    else{
                                        $row_class = "MessagesUnread";
                                    }
                                    $message_reciever_dflag = $value['message_reciever_dflag'];
                                    $sender_fname = $value['user_fname'];
                                    $sender_lname = $value['user_lname'];
                                    $sender_full_name = $sender_fname." ".$sender_lname;
                                ?>
                                <tr class="<?php echo $row_class;?>">
                                    <td align="center"><input type="checkbox" class="checkbox" name="txtCheckMessage[]" value="<?php echo $message_id;?>"/></td>
                                    <td class="pad-lft15 mails-bdr" onclick="MM_goToURL('parent','owner-messages.php?msgid=<?php echo $message_id;?>');return document.MM_returnValue" style="cursor:pointer;"><?php echo ucwords($sender_full_name);?></td>
                                    <td class="mails mails-bdr" onclick="MM_goToURL('parent','owner-messages.php?msgid=<?php echo $message_id;?>');return document.MM_returnValue" style="cursor:pointer;"><?php echo ucfirst($message_subject);?></td>
                                    <td class="mails"><?php echo $message_created_on;?></td>
                                </tr>
								<?php
                                }
                                ?>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td valign="middle" class="pad-top20"><div align="right" class="pagination"><a href="#">First</a> &lt; <a href="#">1</a> | 2 | <a href="#">3</a> | <a href="#">4</a> | <a href="#">5</a>|  <a href="#">6</a> | <a href="#">7</a> | <a href="#">8</a> | <a href="#">9</a> | <a href="#">10</a> ...<a href="#">23</a> &gt; <a href="#">Last</a></div></td>
                    </tr>
                </table>
                </form>
                </div>
                <!--Tab1 Content Ends Here -->
            </div>
            <!--Tab1 Ends Here -->
            <!--Tab2 Starts Here -->
            <div style="display: none;" id="Sent" class="RegFormMain">
                <!--Tabbing Starts Here -->
                <ul class="messages-tab">
                <li class="messages-list1"></li>
                <li class="messages-list"><span class="left"><a href="javascript: open_div('checkList', 'Inbox');void(0);" title="Inbox"><img src="images/tab-inbox-un-selected.gif" width="31" height="29" border="0" align="top" /><span class="numbermsg">(<?php echo $messageObj->fun_countNewMessageInbox($user_id);?> new)</span></a></span></li>
                <li class="messages-list" id="current"><span class="left"><a href="javascript: open_div('checkList', 'Sent');void(0);" title="Sent"><img src="images/tab-sent-selected.gif" width="28" height="29" border="0" align="top" /></a></span></li>
                <li class="messages-list2"><a href="#">First</a> &lt; <a href="#">1</a> | 2 | <a href="#">3</a> | <a href="#">4</a> | <a href="#">5</a>|  <a href="#">6</a> | <a href="#">7</a> | <a href="#">8</a> | <a href="#">9</a> | <a href="#">10</a> ...<a href="#">23</a> &gt; <a href="#">Last</a></li>
                </ul>
                <!--Tabbing Ends Here -->
                <!--Tab2 Content Starts Here -->
                <div class="sentcontent">
                <form id="form1" name="form1" method="post" action="">
                <table width="690" border="0" cellpadding="0" cellspacing="0">
                    <tr><td class="pad-btm10 pad-top10"><div align="left"><a href="#" class="print-messages">Delete all marked</a></div></td></tr>
                    <tr>
                        <td>
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="collapse">
                                <tr>
                                    <td class="MessagesHeadChkBoxTd"><input type="checkbox" class="checkbox" name="checkbox" /></td>
                                    <td class="MessagesHeadFromTd">To</td>
                                    <td class="MessagesHeadSubjectTd">Subject</td>
                                    <td class="MessagesHeadDateTd">Date Sent</td>
                                </tr>
								<?php
                                foreach($userOutboxArr as $value){
                                    $message_id = $value['message_id'];
                                    $message_type = $value['message_type'];
                                    $message_subject = $value['message_subject'];
                                    $message_created_on = date('F d, Y', strtotime($value['message_created_on']));
                                    $message_sender_rflag = $value['message_sender_rflag'];
                                    if($message_sender_rflag =="1"){
                                        $row_class = "MessagesRead";
                                    }
                                    else{
                                        $row_class = "MessagesUnread";
                                    }
                                    $message_sender_dflag = $value['message_sender_dflag'];
                                    $reciever_fname = $value['user_fname'];
                                    $reciever_lname = $value['user_lname'];
                                    $reciever_full_name = $reciever_fname." ".$reciever_lname;
                                ?>
                                <tr class="<?php echo $row_class;?>">
                                    <td align="center"><input type="checkbox" class="checkbox" name="txtCheckMessage[]" value="<?php echo $message_id;?>"/></td>
                                    <td class="mails-bdr pad-lft15" onclick="MM_goToURL('parent','#');return document.MM_returnValue" style="cursor:pointer;"><?php echo ucwords($reciever_full_name);?></td>
                                    <td class="mails mails-bdr" onclick="MM_goToURL('parent','#');return document.MM_returnValue" style="cursor:pointer;"><?php echo ucfirst($message_subject);?></td>
                                    <td class="mails"><?php echo $message_created_on;?></td>
                                </tr>
								<?php
                                }
                                ?>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td valign="middle" class="pad-top20"><div align="right" class="pagination"><a href="#">First</a> &lt; <a href="#">1</a> | 2 | <a href="#">3</a> | <a href="#">4</a> | <a href="#">5</a>|  <a href="#">6</a> | <a href="#">7</a> | <a href="#">8</a> | <a href="#">9</a> | <a href="#">10</a> ...<a href="#">23</a> &gt; <a href="#">Last</a></div></td>
                    </tr>
                </table>
                </form>
                </div>
                <!--Tab2 Content Ends Here -->
            </div>
            <!--Tab2 Ends Here -->
        </td>
    </tr>
</table>
<?php
}
?>