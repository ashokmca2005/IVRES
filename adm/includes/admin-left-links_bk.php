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
$reguser	 	= (is_array($reguserArr))?count($reguserArr):0;
$collhotprop	= (is_array($colhotArr))?count($colhotArr):0;

?>
<table border="0" cellspacing="0" cellpadding="0">
    <tr><td style="cursor:"><img src="images/left-panel-top.gif" alt="UniqueSleeps" width="218" height="20"/></td></tr>
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
                            <tr>
                                <td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-collateral.php?sec=hotprop")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-collateral.php?sec=hotprop">Feature properties(<?php echo $collhotprop; ?>)</a></td>
                            </tr>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr>
                                <td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-collateral.php?sec=resuser")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-collateral.php?sec=resuser">Registered users (<?php echo $reguser; ?>)</a></td>
                            </tr>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr>
                                <td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-collateral.php?sec=review")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-collateral.php?sec=review">Reviews (<?php echo $reviews; ?>)</a></td>
                            
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr>
                                <td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-collateral.php?sec=trvlguide")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-collateral.php?sec=trvlguide">Travel guides (<?php echo $trvguide; ?>)</a></td>
                            </tr>
<?php /*?>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr>
                                <td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-collateral.php?sec=enquiries")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-collateral.php?sec=enquiries">Enquiries (<?php echo $enq; ?>)</a></td>
                            </tr>
<?php */?>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr>
                            <td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-collateral.php?sec=quote")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-collateral.php?sec=quote">Quotes &amp; Testimonials (<?php echo $testimonials; ?>)</a></td>
                            </tr>
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
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-variables.php?sec=foot")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>" width="200"><a href="admin-site-variables.php?sec=foot">Footers</a></td></tr>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-variables.php?sec=prom")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>" width="200"><a href="admin-site-variables.php?sec=prom">Promo panels</a></td></tr>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-variables.php?sec=seo")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>" width="200"><a href="admin-site-variables.php?sec=seo">SEO</a></td></tr>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
<?php /*?>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-variables.php?sec=home")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-variables.php?sec=home">Home Banners</a></td></tr>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
<?php */?>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-variables.php?sec=banner")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-variables.php?sec=banner">Banners</a></td></tr>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-variables.php?sec=curr")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-variables.php?sec=curr">Currencies</a></td></tr>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-variables.php?sec=rate")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-variables.php?sec=rate">Site rates and charges</a></td></tr>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-variables.php?sec=disc")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-variables.php?sec=disc">Discounts & Promotions <?php //echo "(".$promocodes.")"; ?></a></td></tr>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-variables.php?sec=resource")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-variables.php?sec=resource">Resources (<?php echo $resources; ?>)</a></td></tr>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
                           <?php /*?> <tr>
                                <td class="AdminLeftLinks"><a href="#">Variables</a></td>
                            </tr><?php */?>
						    <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-variables.php?sec=vari")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-variables.php?sec=vari">Variables</a></td></tr>
                          <!--  <tr><td><div class="AdminLeftDash"></div></td></tr>-->
                           <?php /*?> <tr>
                                <td class="AdminLeftLinks"><a href="#">System variables</a></td>
                            </tr><?php */?>
                            <?php /*?><tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-variables.php?sec=sysv")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-variables.php?sec=sysv">System variables</a></td></tr><?php */?>
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
							<tr><td><div class="AdminLeftDash"></div>
                           <!-- <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-cms.php?page_id=".md5(''))){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-cms.php?page_id=<?php echo md5('');?>">Add a content</a></td></tr>
							<tr><td><div class="AdminLeftDash"></div>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-cms.php?page_id=".md5(''))){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-cms.php?page_id=<?php echo md5('');?>">List of content</a></td></tr>-->

                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-cms.php?page_id=".md5('18'))){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-cms.php?page_id=<?php echo md5('18');?>">Property Managers</a></td></tr>
							<tr><td><div class="AdminLeftDash"></div></td></tr>
							<tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-cms.php?page_id=".md5('2'))){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-cms.php?page_id=<?php echo md5('2');?>">Planning Your Holiday</a></td></tr>
							<tr><td><div class="AdminLeftDash"></div></td></tr>
							<tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-cms.php?page_id=".md5('3'))){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-cms.php?page_id=<?php echo md5('3');?>">Useful home-mod</a></td></tr>
							<tr><td><div class="AdminLeftDash"></div></td></tr>
				
                          	<tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-cms.php?page_id=".md5('44'))){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-cms.php?page_id=<?php echo md5('44');?>">Welcome Note</a></td></tr>
							<tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-cms.php?page_id=".md5('4'))){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-cms.php?page_id=<?php echo md5('4');?>">How to book</a></td></tr>
							<tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-cms.php?page_id=".md5('54'))){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-cms.php?page_id=<?php echo md5('54');?>">event note</a></td></tr>
							<tr><td><div class="AdminLeftDash"></div></td></tr>
							
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-cms.php?page_id=".md5('27'))){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-cms.php?page_id=<?php echo md5('27');?>">Help </a></td></tr>
							<tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-cms.php?page_id=".md5('22'))){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-cms.php?page_id=<?php echo md5('22');?>">FAQ&prime;s</a></td></tr>
							<tr><td><div class="AdminLeftDash"></div></td></tr>
				
                 
							<tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-cms.php?page_id=".md5('1'))){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>" width="200"><a href="admin-site-cms.php?page_id=<?php echo md5('1');?>">A to Z Countries</a></td></tr>
							<tr><td><div class="AdminLeftDash"></div></td></tr>
							<tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-cms.php?page_id=".md5('7'))){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-cms.php?page_id=<?php echo md5('7');?>">Letting Advice</a></td></tr>
							<tr><td><div class="AdminLeftDash"></div></td></tr>
							<tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-cms.php?page_id=".md5('26'))){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-cms.php?page_id=<?php echo md5('26');?>">Privacy Policy</a></td></tr>
							<tr><td><div class="AdminLeftDash"></div></td></tr>
							<tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-cms.php?page_id=".md5('5'))){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>" width="200"><a href="admin-site-cms.php?page_id=<?php echo md5('5');?>">Checklist</a></td></tr>
							<tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-cms.php?page_id=".md5('29'))){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-cms.php?page_id=<?php echo md5('29');?>">Sitemap</a></td></tr>
							<tr><td><div class="AdminLeftDash"></div></td></tr>
							
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-cms.php?page_id=".md5('34'))){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-cms.php?page_id=<?php echo md5('34');?>">Site Security</a></td></tr>
							<tr><td><div class="AdminLeftDash"></div></td></tr>
							<tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-cms.php?page_id=".md5('31'))){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-cms.php?page_id=<?php echo md5('31');?>">Term & Conditions</a></td></tr>
							<tr><td><div class="AdminLeftDash"></div></td></tr>
							<tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-cms.php?page_id=".md5('10'))){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-cms.php?page_id=<?php echo md5('10');?>">Company Description</a></td></tr>
							<tr><td><div class="AdminLeftDash"></div></td></tr>
							<tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-cms.php?page_id=".md5('11'))){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-cms.php?page_id=<?php echo md5('11');?>">Carrier Oportunities</a></td></tr>
							<tr><td><div class="AdminLeftDash"></div></td></tr>
					
					
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-cms.php?page_id=".md5('12'))){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-cms.php?page_id=<?php echo md5('12');?>">Why Booking With Us</a></td></tr>
							<tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-cms.php?page_id=".md5('14'))){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-cms.php?page_id=<?php echo md5('14');?>">Legal Information</a></td></tr>
							<tr><td><div class="AdminLeftDash"></div></td></tr>
							<tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-cms.php?page_id=".md5('15'))){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-cms.php?page_id=<?php echo md5('15');?>">advertise</a></td></tr>
							<tr><td><div class="AdminLeftDash"></div></td></tr>
						
				
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-cms.php?page_id=".md5('40'))){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-cms.php?page_id=<?php echo md5('40');?>">Home promo</a></td></tr>
							<tr><td><div class="AdminLeftDash"></div></td></tr>
											
                  
							<tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-cms.php?page_id=".md5('41'))){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-cms.php?page_id=<?php echo md5('41');?>">Contact us</a></td></tr>
							<tr><td><div class="AdminLeftDash"></div></td></tr>
							<tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-cms.php?page_id=".md5('43'))){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-cms.php?page_id=<?php echo md5('43');?>">Worldwide accommodation</a></td></tr>
							<tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-cms.php?page_id=".md5('48'))){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-cms.php?page_id=<?php echo md5('48');?>">See Example Details</a></td></tr>
							<tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-cms.php?page_id=".md5('50'))){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-cms.php?page_id=<?php echo md5('50');?>">Home Advertise</a></td></tr>
					
					
							<tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-cms.php?page_id=".md5('49'))){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-cms.php?page_id=<?php echo md5('49');?>">See Example Prices</a></td></tr>
							<tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-cms.php?page_id=".md5('51'))){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-cms.php?page_id=<?php echo md5('51');?>">Advertisement</a></td></tr>
							<tr><td><div class="AdminLeftDash"></div></td></tr>
					
                
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-cms.php?page_id=".md5('52'))){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-cms.php?page_id=<?php echo md5('52');?>">Contact description</a></td></tr>
							<tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="AdminLeftLinks" style="color:#990000;"><strong>Owner Section</strong></td></tr>
							<tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-cms.php?page_id=".md5('35'))){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-cms.php?page_id=<?php echo md5('35');?>">Owner help</a></td></tr>
							<tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-cms.php?page_id=".md5('36'))){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-cms.php?page_id=<?php echo md5('36');?>">Owner about us</a></td></tr>
							<tr><td><div class="AdminLeftDash"></div></td></tr>
						
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-cms.php?page_id=".md5('37'))){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-cms.php?page_id=<?php echo md5('37');?>">Owner terms</a></td></tr>
							<tr><td><div class="AdminLeftDash"></div></td></tr>
							<tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-cms.php?page_id=".md5('46'))){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-cms.php?page_id=<?php echo md5('46');?>">Owner add late deal</a></td></tr>
							<tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-cms.php?page_id=".md5('47'))){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-cms.php?page_id=<?php echo md5('47');?>">Owner add featured property</a></td></tr>
							<tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-cms.php?page_id=".md5('38'))){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-cms.php?page_id=<?php echo md5('38');?>">Owner privacy policy</a></td></tr>
							<tr><td><div class="AdminLeftDash"></div></td></tr>
							<tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-cms.php?page_id=".md5('45'))){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-cms.php?page_id=<?php echo md5('45');?>">Owner home</a></td></tr>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
							<tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-cms.php?page_id=".md5('39'))){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-cms.php?page_id=<?php echo md5('39');?>">Owner sitemap</a></td></tr>
							<tr><td><div class="AdminLeftDash"></div></td></tr>
							
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-cms.php?page_id=".md5('42'))){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-cms.php?page_id=<?php echo md5('42');?>">Owner login</a></td></tr>
                            <tr><td><div class="AdminLeftDash"></div></td></tr>
							
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-site-cms.php?page_id=".md5('53'))){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-site-cms.php?page_id=<?php echo md5('53');?>">Owner Photo</a></td></tr>
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
                           <?php /*?> <tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-statistics.php?sec=fina")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-statistics.php?sec=fina">Financial stats</a></td></tr><?php */?>
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
<?php /*?>                            <tr><td><div class="AdminLeftDash"></div></td></tr>
                            <tr><td class="<?php if(strstr($_SERVER['REQUEST_URI'], "admin-crm.php?sec=newslettr")){echo "AdminLeftLinksActive";}else{echo "AdminLeftLinks";}?>"><a href="admin-crm.php?sec=newslettr">Newsletters</a></td></tr>
<?php */?>                            <tr><td>&nbsp;</td></tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr><td class="pad-btm15"><img src="images/left-panel-bottom.gif" alt="UniqueSleeps" width="218" height="20" /></td></tr>
</table>