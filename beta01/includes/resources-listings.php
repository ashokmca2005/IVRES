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
			$sortField  = "A.resource_id";
		break;
		case 1:
			$sortField  = "A.resource_id";
		break;
		default:
			$sortField = "A.resource_id";
		break;
	}

	$search_query = "";
	$strQueryParameter		= " ORDER BY " . $sortField . " " . $orderDir. " LIMIT ".(int)(($page-1)*(int)GLOBAL_RECORDS_PER_PAGE).", ".GLOBAL_RECORDS_PER_PAGE;
	$strQueryCountParameter	= " ORDER BY " . $sortField . " " . $orderDir;

	$rsQuery				= $resObj->fun_getResourcesByCategoryArr($resources_categories_id, $strQueryParameter);
	$rsQueryCount			= $resObj->fun_getResourcesByCategoryArr($resources_categories_id, $strQueryCountParameter);
	if(isset($resources_categories_id) && $resources_categories_id != "") { $search_query .= "&catid=" . html_escapeURL($resources_categories_id); }
	$sort_query   = "sortby=" . html_escapeURL($sortby) ."&sortdir=" . html_escapeURL($sortdir);

	$resourcesListArr 		= $dbObj->fetchAssoc($rsQuery);

	// Determine the pagination
	$return_query 		= $search_query."&".$sort_query."&page=$page";
	$pag 				= new Pagination($rsQueryCount, $search_query."&".$sort_query, GLOBAL_RECORDS_PER_PAGE);
	$pag->current_page 	= $page;
	$pagination  		= $pag->Process();

?>
<table width="690" border="0" cellspacing="0" cellpadding="0" class="font12">
    <tr>
        <td align="left" valign="top">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                	<td valign="top" class="pad-rgt10" width="50%">
                    <div class="pad-top15 pad-rgt5">
						<?php echo tranText('the_resources_section_is_designed_to_help_you_find_local_services_such_as_car_hire_sporting_facilities_and_restaurants_if_you_have_a_travel_related_product_or_service_then_just_add_it_to_the_site'); ?></div>
                    </td>
                    <td valign="top" class="pad-top20">
                        <div class="FloatRgt pad-top20">
                            <div class="gradientV">
                                <div class="left">
                                    <div class="right">
                                    <p class="FloatLft pad-top3 pad-rgt5 font14"><span class="pink14arial"><?php echo tranText('add_your_own_resource'); ?></span></p>
                                    <p class="FloatLft pad-left7"><a href="<?php echo SITE_URL; ?>resources-add.php" style="text-decoration:none"><input type="submit" alt="Search" class="button85x30" value="Submit"/></a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr><td colspan="2" class="height20">&nbsp;</td></tr>
				<?php
                if(is_array($resourcesListArr) && count($resourcesListArr) > 0) {
                ?>
                <tr>
                    <td colspan="2" valign="top" class="pad-rgt10">
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td width="41%" align="left" valign="top" class="pad-btm10 pad-left2"><strong><?php if(isset($pagination['total_rows']) && $pagination['total_rows'] > 1) { echo "Showing ".$pagination['first_row']." to ".$pagination['last_row']." of ".$pagination['total_rows']." results";} else if(isset($pagination['total_rows']) && $pagination['total_rows'] == 1){echo "Showing ".$pagination['first_row']." to ".$pagination['last_row']." of ".$pagination['total_rows']." result";} ?></strong></td>
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
                <tr><td colspan="2" class="dash25" valign="top">&nbsp;</td></tr>
                <tr>
                    <td colspan="2" valign="top" class="pad-rgt10">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
							<?php
                            for($i =0; $i < count($resourcesListArr); $i++) {
                                $resource_id 				= $resourcesListArr[$i]['resource_id'];
                                $resource_cat_ids 			= $resourcesListArr[$i]['resource_cat_ids'];
                                $resource_name 				= fun_db_output($resourcesListArr[$i]['resource_name']);
                                $resource_description 		= fun_db_output($resourcesListArr[$i]['resource_description']);

                                $resource_area_id 			= $resourcesListArr[$i]['resource_area_id'];
                                $resource_region_id 		= $resourcesListArr[$i]['resource_region_id'];
                                $resource_sub_region_id 	= $resourcesListArr[$i]['resource_sub_region_id'];
                                $resource_location_id 		= $resourcesListArr[$i]['resource_location_id'];

                                $resource_link 				= $resourcesListArr[$i]['resource_link'];
                                $resource_mc_link 			= $resourcesListArr[$i]['resource_mc_link'];
                                $status 					= $resourcesListArr[$i]['status'];
                                $active_on 					= $resourcesListArr[$i]['active_on'];
                                $active_by 					= $resourcesListArr[$i]['active_by'];
                                $created_on 				= $resourcesListArr[$i]['created_on'];
                                $created_by 				= $resourcesListArr[$i]['created_by'];
                                $updated_on 				= $resourcesListArr[$i]['updated_on'];
                                $updated_by 				= $resourcesListArr[$i]['updated_by'];
                                $active 					= $resourcesListArr[$i]['active'];
                                echo "<tr>";
                                echo "<td align=\"left\" class=\"pad-top5\"><a href=\"".$resource_link."\" target=\"_blank\" style=\"text-decoration:none;\"><span class=\"blue14\">".ucfirst($resource_name)."</span></a></td>";
                                echo "</tr>";
                                echo "<tr>";
                                echo "<td align=\"left\" class=\"pad-btm10\">".ucfirst($resource_description)."</td>";
                                echo "</tr>";
                            }
                            ?>
                        </table>
                    </td>
                </tr>
                <tr><td colspan="2" class="dash25" valign="top">&nbsp;</td></tr>
                <tr>
                    <td colspan="2" valign="top" class="pad-rgt10 pad-top10">
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td width="41%" align="left" valign="top" class="pad-btm10 pad-left2"><strong><?php if(isset($pagination['total_rows']) && $pagination['total_rows'] > 1) { echo "Showing ".$pagination['first_row']." to ".$pagination['last_row']." of ".$pagination['total_rows']." results";} else if(isset($pagination['total_rows']) && $pagination['total_rows'] == 1){echo "Showing ".$pagination['first_row']." to ".$pagination['last_row']." of ".$pagination['total_rows']." result";} ?></strong></td>
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
				<?php
                }
                ?>
            </table>
        </td>
    </tr>
</table>