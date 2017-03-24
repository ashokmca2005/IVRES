<?php
if(isset($user_id) && $user_id !=""){
?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td valign="top"><a href="admin-pending-approval.php?sec=newusers" class="arrowLinkback">Back to list</a></td>
            <td align="right" valign="top">
                <a href="#" class="arrowLinkback">Previous</a>&nbsp; <span class="boldblack12">|</span> &nbsp; 
                <a href="#" class="arrowLinkNext">Next</a>
            </td>
        </tr>
    </table>
<?php
} else {
?>
    <!-- Main Table : Start here -->
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td valign="top">abc</td>
        </tr>
    </table>
    <!-- Main Table : End here -->
<?php
}
?>