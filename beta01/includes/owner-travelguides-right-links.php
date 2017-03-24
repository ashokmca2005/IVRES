<?php
if(isset($_GET['tvlguidid']) && $_GET['tvlguidid'] != "") {
	$trvl_guid_id 	= $_GET['tvlguidid'];
	$category_id 	= $tvlguidObj->fun_getTravelCatIdByTvlId($trvl_guid_id);
	$category_name 	= $tvlguidObj->fun_getTvlGuidCatNameByCatId($category_id);
} else {
	$trvl_guid_id 	= "";
	$category_id 	= "";
}
$topAttractionArr = $tvlguidObj->fun_getTravelTopAttractionList($category_id, $trvl_guid_id);
?>
<table width="198" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td align="left" valign="top">
            <table width="210" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
						<?php
                            if(is_array($topAttractionArr)) {
                                echo "<table width=\"185\" border=\"0\" align=\"right\" cellpadding=\"0\" cellspacing=\"0\">";
                                echo "<tr><td class=\"pad-btm15\"><span class=\"font14\">".$category_name."</span></td></tr>";
                                for($i=0; $i < count($topAttractionArr); $i++) {
                                    $trvl_guid_id 		= $topAttractionArr[$i]['trvl_guid_id'];
                                    $trvl_guid_title 	= ucfirst($topAttractionArr[$i]['trvl_guid_title']);
                                    echo "<tr><td class=\"pad-btm3 font12\"><a href=\"owner-travelguides.php?tvlguidid=".$trvl_guid_id."\" class=\"blue-link\">".$trvl_guid_title."</a></td></tr>";
                                }
                                echo "<tr><td class=\"pad-btm3 font12\">&nbsp;</td></tr>";
                                echo "</table>";
                            } else {
                                echo "&nbsp;";
                            }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td <?php if(is_array($topAttractionArr)) { echo "class=\"pad-top25 dash-top\""; } ?>>
                        <table width="185" border="0" align="right" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>
                                    <div class="content">
                                        <p class="font14">Suggest a travel guide you&rsquo;d like to see</p>
                                        <p class="pad-top10">We&rsquo;re adding guides all the time but if there&rsquo;s something you&rsquo;d like to see or you think we&rsquo;ve missed then please let us know.</p>
                                        <p class="pad-top15"><strong>We may even ask you to<br />help us put it together!</strong></p>
                                        <p class="pad-top15"><a href="mailto:info@rentownersvillas.com?subject=suggestions" style="text-decoration:none;"><img src="images/suggestGuideBtn.png" alt="Make Suggestion" width="113" height="27" /></a></p>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
