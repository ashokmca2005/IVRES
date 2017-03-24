<?php
$cur_year 	= date('Y');
$year 		= (isset($_GET['year']) && $_GET['year'] != "")?$_GET['year']:date('Y');
?>
<!-- Main Table : Start here -->
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
    <tr>
        <td class="SectionSubHead pad-btm12">
            <table border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td class="blackTxt14 pad-rgt5">Select Year</td>
                    <td>
                        <select name="select" class="Listmenu80" id="select">
                        <?php
						for($i = 2010; $i <= $cur_year; $i++) {
							if($year == $i)
								echo '<option value="'.$i.'" selected="selected">'.$i.'</option>';
							else
								echo '<option value="'.$i.'">'.$i.'</option>';
						}
						?>
                        </select>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="owner-headings">Registrations</td>
    </tr>
    <tr>
        <td valign="top">
		<?php
            $usersObj->fun_createUserStats($year);
        ?>
        </td>
    </tr>
    <tr>
        <td valign="top" class="pad-btm20">&nbsp;</td>
    </tr>
    <tr>
        <td valign="top" class="owner-headings">Owner</td>
    </tr>
    <tr>
        <td valign="top">
		<?php
            $usersObj->fun_createOwnerStats($year);
        ?>
        </td>
    </tr>
    <tr>
        <td valign="top" class="pad-btm20">&nbsp;</td>
    </tr>
    <tr>
        <td valign="top" class="owner-headings">Property</td>
    </tr>
    <tr>
        <td valign="top">
		<?php
            $propertyObj->fun_createPropertyStats($year);
        ?>
        </td>
    </tr>
    <tr>
        <td valign="top" class="pad-btm20">&nbsp;</td>
    </tr>
    <tr>
        <td valign="top" class="pad-btm20">&nbsp;</td>
    </tr>
</table>
<!-- Main Table : End here -->
