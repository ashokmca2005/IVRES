<?php
//$refersubmit = 1;
if($refersubmit!=""){
?>
<!-- Owner refer a friends thanks: Starts Here -->
<table width="690" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td align="left" valign="bottom" class="pad-btm20 pad-top22"><img src="images/refer-a-friend-heading.gif" alt="Recommend A Service"/></td>
        <td align="right" valign="bottom" class="pad-btm20 pad-top20"><a href="#" class="LeftArrow">View friends I&rsquo;ve already refered</a></td>
    </tr>
    <tr><td colspan="2" align="left" valign="top" class="pad-btm20"><img src="images/rounded-box.gif" width="690" height="160" /></td></tr>
    <tr><td colspan="2" align="left" valign="top" class="owner-headings">Thanks</td></tr>
    <tr>
        <td colspan="2" align="left" valign="top">
            Your friends will shortly be receiving an email with those details. As soon as they register a property on rentownersvillas.com we&rsquo;ll credit your account with a month&rsquo;s FREE Hot Property listing. If your friends are a bit slow off the mark then you can send them upto 3 reminder emails. Why not <a href="#" class="blue-link">view people you&rsquo;ve already referred</a> and give them a nudge to sign up now.
        </td>
    </tr>
    <tr><td colspan="2" align="left" valign="top" class="dash25">&nbsp;</td></tr>
    <tr><td colspan="2" align="left" valign="top" height="8px"></td></tr>
    <tr>
        <td colspan="2" align="left" valign="top">
            <p class="FloatLft"><a href="owner-home.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image29','','images/homepage-over-fr.gif',1)"><img src="images/homepage-out.gif" alt="Homepage" name="Image29" border="0" id="Image29" /></a></p>
            <p class="FloatLft pad-lft10"><a href="owner-refer-a-friend.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image30','','images/refer-more-friend-out.gif',1)"><img src="images/refer-more-friend.gif" alt="Refer More Friend" name="Image30" border="0" id="Image30" /></a></p>
        </td>
    </tr>
</table>
<!-- Owner refer a friends thanks: End Here -->
<?php
}
else{
?>
<!-- Owner refer a friend Home Content: Starts Here -->
<table width="690" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td align="left" valign="bottom" class="pad-btm20 pad-top25">
        <h1 class="page-heading">Refer a friend</h1> 
       <!-- <img src="images/refer-a-friend-heading.gif" alt="Recommend A Service"/>-->
        </td>
        <td align="right" valign="bottom" class="pad-btm20 pad-top20"><a href="#" class="LeftArrow">View friends I&rsquo;ve already refered</a></td>
    </tr>
    <tr><td colspan="2" align="left" valign="top" class="pad-btm20"><img src="images/rounded-box.gif" /></td></tr>
    <tr><td colspan="2" align="left" valign="top" class="owner-headings">It&rsquo;s easy</td></tr>
    <tr>
        <td colspan="2" align="left" valign="top" class="pad-btm15">
            1 friend = 1 month of FREE Hot Property advertising for both you and them. The more friends that add their property&rsquo;s to One Location then the more free advertising you receive*
        </td>
    </tr>
    <tr>
        <td colspan="2" align="left" valign="top">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td width="95" align="left" valign="top" class="pad-top2">Friends email <span class="red">*</span></td>
                    <td align="left" valign="top"><input type="text" name="textfield" class="ServicesTxtFld" /></td>
                </tr>
                <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    <td align="left" valign="top" class="pad-btm5">NB: To add more than one friend simply separate addresses with a comma</td>
                </tr>
                <tr>
                    <td align="left" valign="top" class="pad-top2">Subject <span class="red">*</span></td>
                    <td align="left" valign="top" class="pad-btm10"><input name="textfield3" type="text" class="ServicesTxtFld" value="Join One Location and get something for nothing" /></td>
                </tr>
                <tr>
                    <td align="left" valign="top" class="pad-top2">Message <span class="red">*</span></td>
                    <td align="left" valign="top" class="pad-btm20"><textarea name="textarea2" cols="" rows="" class="MessageTextArea">This is great - if you add your property to One Location we both get 1 month's free Hot Property Advertising.</textarea></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2" align="left" valign="middle" class="grayStrip pad-lft10" >
            By submitting this review you are agreeing to our Terms &amp; Conditions. To read the T&amp;C's <a href="owner-terms-conditions.php" class="blue-link">click here</a>.
        </td>
    </tr>
    <tr><td colspan="2" align="left" valign="top" class="dash25">&nbsp;</td></tr>
    <tr>
        <td colspan="2" align="left" valign="top">
            <p class="FloatLft"><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Cancel','','images/cancel-57x28-over.gif',1)"><img src="images/cancel-57x28-normal.gif" alt="Cancel" name="Cancel" border="0" id="Cancel" /></a></p>
            <p class="FloatRgt"><a href="Thanks-Friend.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image28','','images/send-over.gif',1)"><img src="images/send-out.gif" alt="send" name="Image28" border="0" id="Image28" /></a></p>
        </td>
    </tr>
</table>
<!-- Owner refer a friend Home Content: End Here -->
<?php
}
?>