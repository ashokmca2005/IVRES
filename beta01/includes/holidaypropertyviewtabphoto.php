<div id="tab_menu-1">
    <ul>
        <li><a href="#showSectionTop" onclick="return showSection(1);" title="Description">Overview</a></li>
        <li><a href="#showSectionPhotos" onclick="return showSection(2);" title="Photos" class="current">Photos</a></li>
        <li><a href="#showSectionLocation" onclick="return showSection(3);" title="Location">Location</a></li>
        <li><a href="#showSectionAbout" onclick="return showSection(4);" title="Amenities">Amenities</a></li>
        <li><a href="#showSectionCalendar" onclick="return showSection(5);" title="Availability">Availability</a></li>
        <li><a href="#showSectionPrice" onclick="return showSection(6);" title="Prices">Rates</a></li>
        <li><a href="#showSectionReview" onclick="return showSection(7);" title="Reviews">Read / Add Review(s)</a></li>
		<?php
        if($booking_on == true) {
        ?>
        <li><a href="javascript:void(0);" onclick="submitTripDuration('<?php echo $date_from;?>', <?php echo $date_to;?>)" title="Book Now" style="color:#e89c4e;">Book Now</a></li>
        <?php
        }
        ?>
    </ul>
</div>
<table border="0" align="left" cellpadding="0" cellspacing="0"  width="100%">
    <tr>
        <td valign="top">
		<?php
            if(count($propertyPhotosInfo) > 0) {
                $image_placer = PROPERTY_IMAGES_THUMB88x66_PATH."image_placer.gif";
                echo '<table width="100%" style="padding-top:20px;" cellspacing="0" cellpadding="2">';
                for( $i = 0; $i < count($propertyPhotosInfo); $i = $i+2){
                    $photoid_1 		= $propertyPhotosInfo[$i+0]['photo_id'];
                    $photoid_2 		= $propertyPhotosInfo[$i+1]['photo_id'];
                    echo '<tr>';
                    echo '<td style="border:1px solid #D8E7F2; color:#666; padding:2px;" align="center" valign="top">';
                    if( isset( $photoid_1 ) && $photoid_1 !="" ) {
                        $propertythumbid= "propertythumbid".$photoid_1;
                        $photocap_1 	= ($propertyPhotosInfo[$i+0]['photo_caption'] !="")?ucfirst($propertyPhotosInfo[$i+0]['photo_caption']):"&nbsp;";
                        $photocap_1		= addslashes($photocap_1);
                        $photourl_1 	= PROPERTY_IMAGES_LARGE480x360_PATH.$propertyPhotosInfo[$i+0]['photo_url'];
                        $photothumb_1 	= PROPERTY_IMAGES_LARGE480x360_PATH.$propertyPhotosInfo[$i+0]['photo_url'];
                        echo "<img src=\"".$photothumb_1."\" id=\"".$propertythumbid."\" alt=\"".$property_name."\" title=\"".$property_name.": ".$property_title."\" width=\"350\" />";
                        echo "<p class\"pad-top5 pad-btm5\">".$photocap_1."</p>";
                    }
                    echo "</td>";
                    echo "<td>&nbsp;</td>";
                    echo '<td style="border:1px solid #D8E7F2; color:#666; padding:2px;" align="center" valign="top">';
                    if( isset( $photoid_2 ) && $photoid_2 !="" ) {
                        $propertythumbid= "propertythumbid".$photoid_2;
                        $photocap_2 	= ($propertyPhotosInfo[$i+1]['photo_caption'] !="")?ucfirst($propertyPhotosInfo[$i+1]['photo_caption']):"&nbsp;";
                        $photocap_2		= addslashes($photocap_2);
                        $photourl_2 	= PROPERTY_IMAGES_LARGE480x360_PATH.$propertyPhotosInfo[$i+1]['photo_url'];
                        $photothumb_2 	= PROPERTY_IMAGES_LARGE480x360_PATH.$propertyPhotosInfo[$i+1]['photo_url'];
                        echo "<img src=\"".$photothumb_2."\" id=\"".$propertythumbid."\" alt=\"".$property_name."\" title=\"".$property_name.": ".$property_title."\" width=\"350\" />\n";
                        echo "<p class\"pad-top5 pad-btm5\">".$photocap_2."</p>";
                    }
                    echo '</td>';
                    echo '</tr>';
                    echo '<tr><td colspan="3">&nbsp;</td></tr>';
                }
                echo "</table>";
            }
        ?>
        </td>
    </tr>
</table>