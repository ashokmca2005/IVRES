<?php 
	$page	 = form_int("page",1)+0;
	$sortby  = form_int("sortby",0,0,5);
	$sortdir = form_int("sortdir",0,0,1);
	if (form_isset("reverse")) {
		$sortdir = 1-$sortdir;
	}
	
	switch($sortdir) {
		case 0 :
			$orderDir = "ASC";
		break;
		case 1 :
			$orderDir = "DESC";
		break;
	}

	switch($sortby) {
		case 0:
			$sortField  = "A.testimonial_id";
		break;
		case 1:
			$sortField  = "A.testimonial_id";
		break;
		default:
			$sortField = "A.testimonial_id";
		break;
	}

	$search_query = "";
	$strQueryParameter		= " ORDER BY " . $sortField . " " . $orderDir. " LIMIT ".(int)(($page-1)*(int)GLOBAL_RECORDS_PER_PAGE).", ".GLOBAL_RECORDS_PER_PAGE;
	$strQueryCountParameter	= " ORDER BY " . $sortField . " " . $orderDir;


	$rsQuery				= $testiObj->fun_getTestimonialsArr($strQueryParameter);
	$rsQueryCount			= $testiObj->fun_getTestimonialsArr($strQueryCountParameter);

	$testimonialListArr 		= $dbObj->fetchAssoc($rsQuery);

	// Determine the pagination
	$return_query 		= $search_query."&".$sort_query."&page=$page";
	$pag 				= new Pagination($rsQueryCount, $search_query."&".$sort_query, GLOBAL_RECORDS_PER_PAGE);
	$pag->current_page 	= $page;
	$pagination  		= $pag->Process();
?>
<table width="690" border="0" cellspacing="0" cellpadding="0" class="font12 pad-btm500">
<?php
if(is_array($testimonialListArr) && count($testimonialListArr) > 0) {
?>
        <td align="left" valign="top">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                	<td valign="top" class="pad-rgt10" width="50%">
                    <div><h1 class="page-headingNew"><?php echo tranText('what_people_are_saying'); ?></h1></div>
                    <div class="pad-top5 pad-rgt5">
                       <p><?php echo tranText('below_are_just_some_of_the_things_people_have_been_saying_about_yoursite'); ?> </p><br /><?php echo tranText('we_publish_nearly_every_comment_good_and_bad_in_order_to_give_you_a_fair_and_unbiased_reflection_of_the_site'); ?>.<br /> <?php echo tranText('we_have_very_broad_shoulders_and_will_change_what_isnt_working_for_you'); ?> !!
                    </div>
                    </td>
                    <td valign="top">
                        <div class="FloatRgt">
                            <div class="gradientV">
                                <div class="left">
                                    <div class="right">
                                    <p class="FloatLft pad-rgt5 font14"><span class="pink14arial"><?php echo tranText('got_something_to_say'); ?>?</span></p>
                                    <p class="FloatLft pad-left7"><a href="holiday-testimonials-add.php" style="text-decoration:none"><img src="images/tellus-gray.gif" alt="Tell us"></a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr><td colspan="2" class="height20">&nbsp;</td></tr>
<?php /*?>
                <tr>
                    <td colspan="2" valign="top" class="pad-rgt10">
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td width="41%" align="left" valign="top" class="pad-btm10 pad-left2"><strong><?php if(isset($pagination['total_rows']) && $pagination['total_rows'] > 1) { echo "Showing ".$pagination['first_row']." to ".$pagination['last_row']." of ".$pagination['total_rows']." enquiries";} else if(isset($pagination['total_rows']) && $pagination['total_rows'] == 1){echo "Showing ".$pagination['first_row']." to ".$pagination['last_row']." of ".$pagination['total_rows']." enquiry";} ?></strong></td>
                                <td width="59%" align="right" valign="top" class="paging pad-btm10 pad-left2">
                                <?php
                                if(isset($pagination['pages']) && $pagination['pages'] != "") {
                                    if(isset($pagination['prev']) && $pagination['prev'] !="") {
                                        echo "<a href=\"".$pagination['prev']."\" class=\"previous\">Previous</a>";
                                    }
									if(($pagination['pages'][0]['no']) > 1) {
										echo "<span>...</span>";
									}
                                    foreach($pagination['pages'] as $key => $value) {
                                        if(isset($value['link']) && $value['link'] != "") {
                                            echo "<a href=\"".$value['link']."\">".($value['no'])."</a>";
                                        } else {
                                            echo "<span>".($value['no'])."</span>";
                                        }
                                    }
									if(($pagination['pages'][count($pagination['pages'])-1]['no']) < ($pagination['total_rows']/GLOBAL_RECORDS_PER_PAGE)) {
										echo "<span>...</span>";
									}
                                    if(isset($pagination['next']) && $pagination['next'] !="") {
                                        echo "<a href=\"".$pagination['next']."\" class=\"next\">Next</a>";
                                    }
                                } else {
                                    echo "&nbsp;";
                                }
                                ?>
                                </td>
                            </tr>                
                        </table>
                    </td>
                </tr>
<?php */?>
				<?php
                for($i =0; $i < count($testimonialListArr); $i++) {
                    $testimonial_id 			= $testimonialListArr[$i]['testimonial_id'];
                    $testimonial_name 			= $testimonialListArr[$i]['testimonial_name'];
                    $testimonial_description 	= $testimonialListArr[$i]['testimonial_description'];
                    $site_rating				= $testimonialListArr[$i]['site_rating'];

                    $user_fname					= $testimonialListArr[$i]['user_fname'];
                    $user_lname					= $testimonialListArr[$i]['user_lname'];
					$user_full_name 			= ucwords($user_fname." ".$user_lname);
                    $user_email					= $testimonialListArr[$i]['user_email'];
                    $user_country				= $testimonialListArr[$i]['user_country'];
                    $created_on 				= date('M j, Y', $testimonialListArr[$i]['created_on']);
					$country_name	= $locationObj->fun_getCountryNameById($user_country);
					$txtCreateBy 	= "<strong>Added by :</strong> ".$user_full_name." <strong>Date added :</strong> ".$created_on.". <strong>Country :</strong> ".$country_name;
                    echo "<tr><td colspan=\"2\" height=\"18\" class=\"dash25\"></td></tr>";
                    echo "<tr><td colspan=\"2\" align=\"left\" valign=\"top\" class=\"pad-btm10 pad-top10\">";
					for ( $k=0; $k < (int)$site_rating; $k++ ) {
						echo "<img src=\"".SITE_IMAGES."yellow-star.gif\" alt=\"Star\" />&nbsp;";
					}
                    echo "</td></tr>";
                    echo "<tr><td colspan=\"2\" align=\"left\" valign=\"top\"><span class=\"gray18Arial\">".ucfirst($testimonial_name)."</span> </td></tr>";
                    echo "<tr><td colspan=\"2\" align=\"left\" valign=\"top\" class=\"font11 pad-btm10 pad-top7\">".$txtCreateBy."</td></tr>";
                    echo "<tr><td colspan=\"2\" align=\"left\" valign=\"top\" class=\"pad-btm10\">".ucfirst($testimonial_description)."</td></tr>";
                }
                ?>
<?php /*?>
                <tr>
                    <td colspan="2" valign="top" class="pad-rgt10 pad-top10">
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td width="41%" align="left" valign="top" class="pad-btm10 pad-left2"><strong><?php if(isset($pagination['total_rows']) && $pagination['total_rows'] > 1) { echo "Showing ".$pagination['first_row']." to ".$pagination['last_row']." of ".$pagination['total_rows']." enquiries";} else if(isset($pagination['total_rows']) && $pagination['total_rows'] == 1){echo "Showing ".$pagination['first_row']." to ".$pagination['last_row']." of ".$pagination['total_rows']." enquiry";} ?></strong></td>
                                <td width="59%" align="right" valign="top" class="paging pad-btm10 pad-left2">
                                <?php
                                if(isset($pagination['pages']) && $pagination['pages'] != "") {
                                    if(isset($pagination['prev']) && $pagination['prev'] !="") {
                                        echo "<a href=\"".$pagination['prev']."\" class=\"previous\">Previous</a>";
                                    }
									if(($pagination['pages'][0]['no']) > 1) {
										echo "<span>...</span>";
									}
                                    foreach($pagination['pages'] as $key => $value) {
                                        if(isset($value['link']) && $value['link'] != "") {
                                            echo "<a href=\"".$value['link']."\">".($value['no'])."</a>";
                                        } else {
                                            echo "<span>".($value['no'])."</span>";
                                        }
                                    }
									if(($pagination['pages'][count($pagination['pages'])-1]['no']) < ($pagination['total_rows']/GLOBAL_RECORDS_PER_PAGE)) {
										echo "<span>...</span>";
									}
                                    if(isset($pagination['next']) && $pagination['next'] !="") {
                                        echo "<a href=\"".$pagination['next']."\" class=\"next\">Next</a>";
                                    }
                                } else {
                                    echo "&nbsp;";
                                }
                                ?>
                                </td>
                            </tr>                
                        </table>
                    </td>
                </tr>
<?php */?>
            </table>
        </td>
    </tr>
<?php
} else {
?>
    <tr>
        <td align="left" valign="top" class="pad-top10">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                	<td valign="top" class="pad-rgt10" width="50%">
                    <div><h1 class="page-headingNew"><?php echo tranText('what_people_are_saying'); ?>?</h1></div>
                    <div class="pad-top5 pad-rgt5">
                    <p><?php echo tranText('below_are_just_some_of_the_things_people_have_been_saying_about_yoursite'); ?>  <br /><br /><?php echo tranText('we_publish_nearly_every_comment_good_and_bad_in_order_to_give_you_a_fair_and_unbiased_reflection_of_the_site'); ?>. <?php echo tranText('we_have_very_broad_shoulders_and_will_change_what_isnt_working_for_you'); ?>!!</p>
                    </div>
                    </td>
                    <td valign="top" class="pad-top20">
                        <div class="FloatRgt pad-top20">
                            <div class="gradientV">
                                <div class="left">
                                    <div class="right">
                                    <p class="FloatLft pad-top3 pad-rgt5 font14"><span class="pink14arial"><?php echo tranText('got_something_to_say'); ?>?</span></p>
                                    <p class="FloatLft pad-left7"><a href="holiday-testimonials-add.php" style="text-decoration:none" class="button-grey">Tell us</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
<?php
}
?>    
</table>