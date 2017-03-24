<?php
/*
* Records for left link
*/
//New Properties
$newpropArr 	= $propertyObj->fun_getPendingApprovalNewPropertyArr();
$updatedpropArr	= $propertyObj->fun_getPendingApprovalUpdatedPropertyArr();
$suspendpropArr	= $propertyObj->fun_getPendingApprovalSuspendedPropertyArr();
$hotpropArr		= $propertyObj->fun_getPendingApprovalHotPropertyArr();
$dealListArr	= $propertyObj->fun_getPendingApprovalLateDealsArr();
$newuserArr 	= $usersObj->fun_getPendingApprovalNewUserArr();
$reviewListArr 	= $propertyObj->fun_getPendingApprovalPropertyReviewsArr();
$evntListArr 	= $eventObj->fun_getPendingApprovalEventsArr();
$resourceListArr= $resObj->fun_getPendingApprovalResourcesArr();
$testiListArr	= $testiObj->fun_getPendingApprovalTestimonialsArr();
$tvlguidListArr = $tvlguidObj->fun_getCollateralTravelsArr();

$propArr 		= $propertyObj->fun_getCollateralPropertyArr();
$enquiryListArr = $propertyObj->fun_getPropertyEnquiryInfoArr();
$bookingListArr = $propertyObj->fun_getPropertyBookingInfoArr();
$reguserArr 	= $usersObj->fun_getCollateralUserArr();
$colhotArr 		= $propertyObj->fun_getCollateralHotPropertyArr();

$newprop 		= (is_array($newpropArr))?count($newpropArr):0;
$updatedprop 	= (is_array($updatedpropArr))?count($updatedpropArr):0;
$suspendprop 	= (is_array($suspendpropArr))?count($suspendpropArr):0;
$hotprop	 	= (is_array($hotpropArr))?count($hotpropArr):0;
$newuser	 	= (is_array($newuserArr))?count($newuserArr):0;
$reviews 		= (is_array($reviewListArr))?count($reviewListArr):0;
$events	 		= (is_array($evntListArr))?count($evntListArr):0;
$resources 		= (is_array($resourceListArr))?count($resourceListArr):0;
$testimonials	= (is_array($testiListArr))?count($testiListArr):0;
$dealprop		= (is_array($dealListArr))?count($dealListArr):0;
$trvguide		= (is_array($tvlguidListArr))?count($tvlguidListArr):0;

$prop			= (is_array($propArr))?count($propArr):0;
$enq			= (is_array($enquiryListArr))?count($enquiryListArr):0;
$books			= (is_array($bookingListArr))?count($bookingListArr):0;
$reguser	 	= (is_array($reguserArr))?count($reguserArr):0;
$collhotprop	= (is_array($colhotArr))?count($colhotArr):0;

?>
<table border="0" cellspacing="0" cellpadding="0">
    <tr><td style="cursor:"><img src="images/left-panel-top.gif" width="218" height="20"/></td></tr>
    <tr>
        <td class="RegLeftPanel">
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
                <tr>
                    <td style="padding-bottom:15px;">
                        <img <?php if(isset($_COOKIE['showHidePAMenuSrc']) && $_COOKIE['showHidePAMenuSrc']!=""){$srcPA = $_COOKIE['showHidePAMenuSrc']; echo "src='$srcPA'";}else{echo "src=\"images/PendingApproval-close.gif\"";}?> alt="Pending / Approval" id="adminPAMenusId" onclick="changePAMenusImageSrc(this.src, this.id);showHideAdminMenus('PAMenuId');SetCookie('showHidePAMenuSrc', this.src);" class="cursor"  />
                    </td>
                </tr>
                <tr>
                    <td style="padding-left:5px;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" id="PAMenuId" <?php if(isset($_COOKIE['showHidePAMenuId']) && $_COOKIE['showHidePAMenuId']=="block"){echo "style=\"display:block;\"";}else{echo "style=\"display:none;\"";}?> >
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-pending-approval.php?sec=newprop")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>" width="200"><a href="admin-pending-approval.php?sec=newprop">New properties (<?php echo $newprop; ?>)</a></td></tr>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-pending-approval.php?sec=updtprop")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-pending-approval.php?sec=updtprop">Updated properties (<?php echo $updatedprop; ?>)</a></td></tr>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-pending-approval.php?sec=suspendprop")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-pending-approval.php?sec=suspendprop">Suspended properties (<?php echo $suspendprop; ?>)</a></td></tr>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-pending-approval.php?sec=hotprop")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-pending-approval.php?sec=hotprop">Featured properties (<?php echo $hotprop; ?>)</a></td></tr>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-pending-approval.php?sec=dealprop")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-pending-approval.php?sec=dealprop">Late Deals (<?php echo $dealprop; ?>)</a></td></tr>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-pending-approval.php?sec=newusers")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-pending-approval.php?sec=newusers">New users (<?php echo $newuser; ?>)</a></td></tr>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-pending-approval.php?sec=review")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-pending-approval.php?sec=review">Reviews (<?php echo $reviews; ?>)</a></td></tr>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-pending-approval.php?sec=event")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-pending-approval.php?sec=event">Excursions (<?php echo $events; ?>)</a></td></tr>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-pending-approval.php?sec=testi")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-pending-approval.php?sec=testi">Testimonials (<?php echo $testimonials; ?>)</a></td></tr>
                            <tr><td>&nbsp;</td></tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding-bottom:20px;">
                        <img <?php if(isset($_COOKIE['showHideColMenuSrc']) && $_COOKIE['showHideColMenuSrc']!=""){$srcCol = $_COOKIE['showHideColMenuSrc']; echo "src='$srcCol'";}else{echo "src=\"images/Collateral-close.gif\"";}?> alt="Collateral" id="adminColMenusId" onclick="changeColMenusImageSrc(this.src, this.id);showHideAdminMenus('ColMenuId');SetCookie('showHideColMenuSrc', this.src);" class="cursor" />
                    </td>
                </tr>
                <tr>
                    <td style="padding-left:5px;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" id="ColMenuId" <?php if(isset($_COOKIE['showHideColMenuId']) && $_COOKIE['showHideColMenuId']=="block"){echo "style=\"display:block;\"";}else{echo "style=\"display:none;\"";}?> >
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-collateral.php?sec=prop")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>" width="200"><a href="admin-collateral.php?sec=prop">Properties (<?php echo $prop; ?>)</a></td></tr>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-collateral.php?sec=hotprop")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-collateral.php?sec=hotprop">Feature properties(<?php echo $collhotprop; ?>)</a></td></tr>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-collateral.php?sec=resuser")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-collateral.php?sec=resuser">Registered users (<?php echo $reguser; ?>)</a></td></tr>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-collateral.php?sec=review")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-collateral.php?sec=review">Reviews (<?php echo $reviews; ?>)</a></td>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-collateral.php?sec=trvlguide")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-collateral.php?sec=trvlguide">Travel guides (<?php echo $trvguide; ?>)</a></td></tr>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-collateral.php?sec=enquiries")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-collateral.php?sec=enquiries">Enquiries (<?php echo $enq; ?>)</a></td></tr>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-collateral.php?sec=booking")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-collateral.php?sec=booking">Bookings (<?php echo $books; ?>)</a></td></tr>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-collateral.php?sec=quote")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-collateral.php?sec=quote">Quotes &amp; Testimonials (<?php echo $testimonials; ?>)</a></td></tr>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-collateral.php?sec=backlink")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-collateral.php?sec=backlink">Backlinks (<?php echo $backlinks; ?>)</a></td></tr>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td>&nbsp;</td></tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding-bottom:20px;">
                        <img <?php if(isset($_COOKIE['showHideSVMenuSrc']) && $_COOKIE['showHideSVMenuSrc']!=""){$srcSV = $_COOKIE['showHideSVMenuSrc']; echo "src='$srcSV'";}else{echo "src=\"images/SiteVariables-close.gif\"";}?> alt="Site Variables" id="adminSVMenusId" onclick="changeSVMenusImageSrc(this.src, this.id);showHideAdminMenus('SVMenuId');SetCookie('showHideSVMenuSrc', this.src);" class="cursor" />
                    </td>
                </tr>
                <tr>
                    <td style="padding-left:5px;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" id="SVMenuId" <?php if(isset($_COOKIE['showHideSVMenuId']) && $_COOKIE['showHideSVMenuId']=="block"){echo "style=\"display:block;\"";}else{echo "style=\"display:none;\"";}?> >
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-variables.php?sec=manloca")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>" width="200"><a href="admin-site-variables.php?sec=manloca">Manage locations</a></td></tr>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-variables.php?sec=lang")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>" width="200"><a href="admin-site-variables.php?sec=lang">Languages</a></td></tr>
							<?php /*?>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-variables.php?sec=foot")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>" width="200"><a href="admin-site-variables.php?sec=foot">Footers</a></td></tr>
							<?php */?>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-variables.php?sec=prom")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>" width="200"><a href="admin-site-variables.php?sec=prom">Promo panels</a></td></tr>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-variables.php?sec=seo")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>" width="200"><a href="admin-site-variables.php?sec=seo">SEO</a></td></tr>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
							<?php /*?>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-variables.php?sec=home")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-variables.php?sec=home">Home Banners</a></td></tr>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-variables.php?sec=banner")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-variables.php?sec=banner">Banners</a></td></tr>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
							<?php */?>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-variables.php?sec=curr")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-variables.php?sec=curr">Currencies</a></td></tr>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
							<?php /*?>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-variables.php?sec=rate")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-variables.php?sec=rate">Site rates and charges</a></td></tr>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
							<?php */?>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-variables.php?sec=package")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-variables.php?sec=package">Site packages</a></td></tr>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-variables.php?sec=disc")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-variables.php?sec=disc">Discounts & Promotions <?php //echo "(".$promocodes.")"; ?></a></td></tr>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-variables.php?sec=resource")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-variables.php?sec=resource">Resources (<?php echo $resources; ?>)</a></td></tr>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
						    <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-variables.php?sec=vari")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-variables.php?sec=vari">Variables</a></td></tr>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
						    <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-sitemap-generator.php")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-sitemap-generator.php">Run Sitemap</a></td></tr>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-variables.php?sec=import")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-variables.php?sec=import">Import XML Feed</a></td></tr>
							<?php /*?>
                            <tr><td class="AdminLeftLinks"><a href="#">System variables</a></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-variables.php?sec=sysv")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-variables.php?sec=sysv">System variables</a></td></tr>
                            <?php */?>
                            <tr><td>&nbsp;</td></tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding-bottom:20px;">
                        <img <?php if(isset($_COOKIE['showHideCMSMenuSrc']) && $_COOKIE['showHideCMSMenuSrc'] != ""){$srcStats = $_COOKIE['showHideCMSMenuSrc']; echo "src='$srcStats'";}else{echo "src=\"images/cms_straight.jpg\"";}?> alt="CMS" id="adminCMSMenusId" onclick="changeCMSMenusImageSrc(this.src, this.id);showHideAdminMenus('CMSMenuId');SetCookie('showHideCMSMenuSrc', this.src);" class="cursor"/>
                    </td>
                </tr>
				<tr>
                    <td style="padding-left:5px;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" id="CMSMenuId" <?php if(isset($_COOKIE['showHideCMSMenuId']) && $_COOKIE['showHideCMSMenuId']=="block"){echo "style=\"display:block;\"";}else{echo "style=\"display:none;\"";}?> >
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-cms.php?page_type=0")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-cms.php?page_type=0">Static pages</a></td></tr>
							<tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-cms.php?page_type=1")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-cms.php?page_type=1">Dynamic pages</a></td></tr>
							<tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-cms.php?page_type=1&sec=add")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-cms.php?page_type=1&sec=add">Add a new page</a></td></tr>
							<tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td>&nbsp;</td></tr>
                        </table>
                    </td>
                </tr>		
                <tr>
                    <td style="padding-bottom:20px;">
                        <img <?php if(isset($_COOKIE['showHideStatsMenuSrc']) && $_COOKIE['showHideStatsMenuSrc']!=""){$srcStats = $_COOKIE['showHideStatsMenuSrc']; echo "src='$srcStats'";}else{echo "src=\"images/Statistics-close.gif\"";}?> alt="Statistics" id="adminStatsMenusId" onclick="changeStatsMenusImageSrc(this.src, this.id);showHideAdminMenus('StatsMenuId');SetCookie('showHideStatsMenuSrc', this.src);" class="cursor"/>
                    </td>
                </tr>
                <tr>
                    <td style="padding-left:5px;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" id="StatsMenuId" <?php if(isset($_COOKIE['showHideStatsMenuId']) && $_COOKIE['showHideStatsMenuId']=="block"){echo "style=\"display:block;\"";}else{echo "style=\"display:none;\"";}?> >
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-statistics.php?sec=over")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-statistics.php?sec=over">Overview</a></td></tr>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-statistics.php?sec=prop")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-statistics.php?sec=prop">Property stats</a></td></tr>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-statistics.php?sec=user")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-statistics.php?sec=user">User stats</a></td></tr>
							<?php /*?>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-statistics.php?sec=fina")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-statistics.php?sec=fina">Financial stats</a></td></tr>
							<?php */?>
                            <tr><td>&nbsp;</td></tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding-bottom:20px;">
                        <img <?php if(isset($_COOKIE['showHideCRMMenuSrc']) && $_COOKIE['showHideCRMMenuSrc']!=""){$srcCRM = $_COOKIE['showHideCRMMenuSrc']; echo "src='$srcCRM'";}else{echo "src=\"images/CRM-close.gif\"";}?> alt="CRM" id="adminCRMMenusId" onclick="changeCRMMenusImageSrc(this.src, this.id);showHideAdminMenus('CRMMenuId');SetCookie('showHideCRMMenuSrc', this.src);" class="cursor"/>
                    </td>
                </tr>
                <tr>
                    <td style="padding-left:5px;">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" id="CRMMenuId" <?php if(isset($_COOKIE['showHideCRMMenuId']) && $_COOKIE['showHideCRMMenuId']=="block"){echo "style=\"display:block;\"";}else{echo "style=\"display:none;\"";}?> >
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-crm.php?sec=emailaddr")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-crm.php?sec=emailaddr">Emails addresses</a></td></tr>
							<?php /*?>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-crm.php?sec=newslettr")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-crm.php?sec=newslettr">Newsletters</a></td></tr>
                            <?php */?>
                            <tr><td>&nbsp;</td></tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr><td class="pad-btm15"><img src="images/left-panel-bottom.gif" width="218" height="20" /></td></tr>
</table>