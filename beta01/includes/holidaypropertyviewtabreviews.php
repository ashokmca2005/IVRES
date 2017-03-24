<div id="tab_menu-1">
    <ul>
        <li><a href="#showSectionOverview" onclick="return showSection(1);" title="Description">Property details</a></li>
		<?php /*?>
        <li><a href="#showSectionPhotos" onclick="return showSection(2);" title="Photos">Photos</a></li>
		<?php */?>
        <li><a href="#showSectionLocation" onclick="return showSection(3);" title="Location">Location</a></li>
        <li><a href="#showSectionAbout" onclick="return showSection(4);" title="Amenities">Amenities</a></li>
        <li><a href="#showSectionCalendar" onclick="return showSection(5);" title="Availability">Availability</a></li>
        <li><a href="#showSectionPrice" onclick="return showSection(6);" title="Prices">Rates</a></li>
        <li><a href="#showSectionReview" onclick="return showSection(7);" title="Reviews" class="current">Reviews</a></li>
		<?php /*?>
        <li style="margin-right:0px; margin-left:6px;"><a href="<?php echo SITE_URL;?>property-owner-profile.php?pid=<?php echo $property_id;?>" title="Owner">Owner profile</a></li>
		<?php */?>
        <li style="margin-right:0px; margin-left:6px;"><a href="#showSectionOwner" onclick="return showSection(8);" title="Owner">Owner profile</a></li>
		<?php
        if($booking_on == true) {
        ?>
        <li><a href="javascript:void(0);" onclick="submitTripDuration('<?php echo $date_from;?>', <?php echo $date_to;?>)" title="Book Now" style="color:#e89c4e;">Book Now</a></li>
        <?php
        }
        ?>
    </ul>
</div>
<?php
	//if(isset($_GET['review']) && $_GET['review'] =="all") {
		$show_reviews	= $total_reviews;
	//} else {
		//$show_reviews	= ($total_reviews > 3)?'3':$total_reviews;
	//}

	if(is_array($reviewArr)) {
		foreach($reviewArr as $key => $value) {
			$reviewerUserEmailsArr[$key] = $value['user_email'];
		}
	}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
    <?php
    if(count($reviewArr) < 1) {
    ?>
    <tr>
        <td align="left" valign="top" class="pad-top10">
            <div class="FloatLft pad-top10"><h2><strong><?php echo tranText('this_property_has_not_yet_been_reviewed'); ?></strong></h2></div>
            <div class="FloatRgt">
                <p class="FloatLft pad-top3 pad-rgt5 font14-darkgrey"><?php echo tranText('stayed_here_why_not_write_a_review_for_this_property'); ?></p>
                <p class="FloatLft"><a href="<?php echo SITE_URL; ?>holiday-write-review.php?pid=<?php echo $property_id;?>&review=compose"><img src="<?php echo SITE_IMAGES;?>rateproperty-gray.gif" /></a></p>
            </div>
        </td>
    </tr>
    <?php
    } else {
    ?>
    <tr>
        <td align="left" valign="top" class="pad-top10">
            <div class="FloatLft pad-top10">
				<?php $propertyObj->fun_createPropertyReviewAvgScore($property_id); ?>
            </div>
            <?php
            if(is_array($reviewerUserEmailsArr) && in_array($users_email_id, $reviewerUserEmailsArr)) {
            // do nothing
            } else {
            ?>
            <div class="FloatRgt">
                <p class="FloatLft pad-top5 pad-rgt5 font14-darkgrey"><?php echo tranText('stayed_here_why_not_write_a_review_for_this_property'); ?></p>
                <p class="FloatLft"><a href="<?php echo SITE_URL; ?>holiday-write-review.php?pid=<?php echo $property_id;?>&review=compose"><img src="<?php echo SITE_IMAGES;?>rateproperty-gray.gif" /></a></p>
            </div>
            <?php
            }
            ?>									
        </td>
    </tr>
    <?php
    for($i =0; $i < $show_reviews; $i++) {
        $review_id 		= $reviewArr[$i]['review_id'];
        $user_rating 	= $reviewArr[$i]['property_rating'];
        $review_title 	= $reviewArr[$i]['review_title'];
        $review_txt 	= $reviewArr[$i]['review_txt'];
        $created_on 	= date('M j, Y', $reviewArr[$i]['created_on']);
        $user_fname 	= $reviewArr[$i]['user_fname'];
        $user_lname 	= $reviewArr[$i]['user_lname'];
        $user_name 		= ucwords($user_fname." ".$user_lname);
        $country_name	= $locationObj->fun_getCountryNameById($reviewArr[$i]['user_country']);
        $txtCreateBy 	= "<strong>Added by :</strong> ".$user_name." <strong>Date added :</strong> ".$created_on.". <strong>Country :</strong> ".$country_name;
/*							
        $voteArr = $propertyObj->fun_getPropertyReviewsVoteInfo($review_id);
        if(is_array($voteArr)) {
            $voter_ids	 	= $voteArr['voter_ids'];
            $total_vote 	= $voteArr['total_vote'];
            $yes_vote 		= $voteArr['yes_vote'];
            if($total_vote > 0) {
                $txtHelpful = $yes_vote." out of ".$total_vote." people found this review helpful";
                $vote_unit = (int)(($total_vote*100) / 5);
                $review_rank = (int)(($yes_vote*100) / $vote_unit);
            } else {
                $txtHelpful = "&nbsp;";
                $review_rank = 0;
            }
        }
*/

    ?>
    <tr>
        <td align="left" valign="top" class="pad-btm10 pad-top15">
        <?php 
        for($j=0; $j < 5; $j++) {
            if($j < $user_rating) {
                echo "<img src=\"".SITE_IMAGES."star-rated.gif\" alt=\"Star\" />&nbsp;";
            } else {
                echo "<img src=\"".SITE_IMAGES."star-notrated.gif\" alt=\"Star\" />&nbsp;";
            }
        }
        ?>
        </td>
    </tr>
    <tr><td align="left" valign="top"><h2><strong><?php echo ucfirst($review_title); ?></strong></h2></td></tr>
    <tr><td align="left" valign="top" class="font11 pad-btm10 pad-top5"><?php echo $txtCreateBy; ?></td></tr>
    <tr><td align="left" valign="top" class="pad-btm10"><?php echo ucfirst($review_txt); ?></td></tr>
    <tr><td height="18" class="dash25"></td></tr>
    <?php
    }
    }
    ?>
</table>
