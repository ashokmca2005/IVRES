<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td class="font12 pad-lft20 vAlignProp-left">
        <p class="pad-top5">
        <div class="pad-lft15 FloatLft pad-top2"><img src="<?php echo SITE_IMAGES;?>my-favourities.gif" alt="my favorites"/></div><div class="black pad-lft5 FloatLft">Add to favouritess</div>
        </p>
        <p><img src="<?php echo SITE_IMAGES;?>AddtoFav-Top.gif" class="pad-top5" /></p>
        <table width="192" height="266" cellpadding="0" cellspacing="0" bgcolor="#F4F4F4">
        <tr>
            <td class="Favorites">
                <a href="javascript:printme();">Print property</a> 
                <a href="topdf.php?pid=<?php echo $property_id;?>" target="_blank">Download PDF</a> 
                <a href="javascript:showSection(3);">Check availabilty</a> 
                <a href="javascript:showSection(2);">View prices</a> 
                <a href="javascript:toggleLayer('holiday-email-to-friend-pop');">Email a friend</a> 
                <a href="javascript:toggleLayer('holiday-more-properties-pop');">More properties from this owner(23)</a> 
                <a href="affiliates-books.php">Books of interest</a> 
                <a href="affiliates-flights.php">Flight prices</a> 
                <a href="affiliates-car-hire.php">Car hire</a> 
                <a href="javascript:showSection(8);">Contact the owner</a> 
                
            </td>
        </tr>
        <tr>
        	<td>
            <!-- Popup Table for Email Friend -->
            	<div id="holiday-email-to-friend-pop" class='ANP-Popfav' style="position:relative;">
                
                <div style="position:absolute;  left:-405px; top:-270px; z-index:999">
                <table width="425" border="0" cellspacing="0" cellpadding="0">
                <tr>
                <td align="right"><img src="<?php echo SITE_IMAGES;?>poplefttop.png" alt="ANP" /></td>
                <td width="350" class="topp"></td>
                <td><img src="<?php echo SITE_IMAGES;?>poprighttop1.png" alt="ANP"/></td>
                </tr>
                <tr>
                <td width="15" class="leftp"></td>
                <td  align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
                
                <tr>
                <td width="340" align="left" valign="top" class="head">Email this to a friend</td>
                <td width="15" align="right" valign="top" class="pad-rgt5"><a href="javascript:toggleLayer('holiday-email-to-friend-pop');"><img src="<?php echo SITE_IMAGES;?>pop-up-cross.gif" alt="Close" border="0" title="Close" /></a></td>
                </tr>
                <tr>
                <td  align="left" valign="top" class="PopTxt">
                <div class="owner-headings2">
                Method1</div>                          </td>
                <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                <td  align="left" valign="top" class="PopTxt"><table width="100%" cellspacing="0" cellpadding="0">
                
                
                </table>
                For sending only this property (<span class="red">*</span> Required fields)</td>
                <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                <td  align="left" valign="top" class="pad-lft10"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="font12">
                <tr>
                <td width="100" valign="top" class="pad-top7">Your Name<span class="red">*</span></td>
                <td valign="top" class="pad-top7"><input name="textfield" type="text" class="Textfield270" id="textfield" style="width:270px;" /></td>
                </tr>
                <tr>
                <td valign="top">&nbsp;</td>
                <td valign="top">&nbsp;</td>
                </tr>
                <tr>
                <td valign="top">Your email<span class="red">*</span></td>
                <td valign="top"><input name="textfield2" type="text" class="Textfield270" id="textfield2" style="width:270px;" /></td>
                </tr>
                <tr>
                <td valign="top">&nbsp;</td>
                <td valign="top">&nbsp;</td>
                </tr>
                <tr>
                <td valign="top">Friends email<span class="red">*</span></td>
                <td valign="top"><input name="textfield3" type="text" class="Textfield270" id="textfield3" style="width:270px;" /></td>
                </tr>
                <tr>
                <td valign="top" class="pad-topbtm2">&nbsp;</td>
                <td valign="top" class="pad-topbtm2">
                <span class="blackText"><strong>NB:</strong></span> To enter more than one friend insert a ( , ) comma between adresses</td>
                </tr>
                <tr>
                <td valign="top">&nbsp;</td>
                <td valign="top">&nbsp;</td>
                </tr>
                <tr>
                <td valign="top">Subject<span class="red">*</span></td>
                <td valign="top"><input name="textfield4" type="text" class="Textfield270" id="textfield4" style="width:270px;" value="Check out these great properties" /></td>
                </tr>
                <tr>
                <td valign="top" class="pad-btm7">&nbsp;</td>
                <td valign="top" class="pad-btm7">&nbsp;</td>
                </tr>
                <tr>
                <td valign="top" class="pad-btm7">Message</td>
                <td valign="top" class="pad-btm7"><textarea name="textfield5" class="Textarea370" id="textfield5" style="width:270px;">Have a look at these properties I've picked out on rentownersvillas.com. Let me know what you think</textarea></td>
                </tr>
                <tr>
                <td valign="top">&nbsp;</td>
                <td align="right" valign="top"><a href="#" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('Image48','','<?php echo SITE_IMAGES;?>send-mail-over.gif',1)"><img src="<?php echo SITE_IMAGES;?>send-mail-out.gif" alt="Send mail" name="Image48" width="103" height="28" border="0" id="Image48" /></a></td>
                </tr>
                
                </table></td>
                <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                <td  align="left" valign="top" class="dash25">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                <td  align="left" valign="top" class="PopTxt"><div class="owner-headings2">Method 2</div>                          </td>
                <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                <td align="left" valign="top" class="PopTxt">
                <p class="pad-btm7">For sending multiple properties</p>                          </td>
                <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                <td  align="left" valign="top" class="PopTxt">
                <p class="pad-btm7">Just click on the link below and add this property to your favourite list.</p>                          </td>
                <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                <td  align="left" valign="top" class="PopTxt pad-btm7">
                <p class="pad-btm7">
                <a href="#" class="favLink">Add to favouritess</a>                          </p>                          </td>
                <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                <td  align="left" valign="top" class="PopTxt">Then when you are ready to send these to your friends just go to <a href="#" class="blue-link">my favourites</a> and you can choose which ones you send in one email</td>
                <td align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                <td  align="left" valign="top" class="PopTxt">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                </tr>
                
                
                </table></td>
                <td width="15" class="rightp" valign="top"><img src="<?php echo SITE_IMAGES;?>pop-arrow.png" vspace="90"/></td>
                </tr>
                <tr>
                <td align="right" valign="top"><img src="<?php echo SITE_IMAGES;?>popleftbtm.png" alt="ANP"/></td>
                <td width="340" class="bottomp"  height="10"></td>
                <td><img src="<?php echo SITE_IMAGES;?>poprightbtm1.png" alt="ANP"/></td>
                </tr>
                </table>
                </div>
                </div>
                <!-- End Pop Up -->
                
                <!-- ################## Popup Table for more properties ################################### --> 
                <div id="holiday-more-properties-pop" class='ANP-Popfav' style="position:relative;">
                <div style="position:absolute; left:-400px; top:-270px; z-index:999">
			    <table width="420" border="0" cellspacing="0" cellpadding="0">
<tr>
					  <td><img src="<?php echo SITE_IMAGES;?>poplefttop.png" alt="ANP" /></td>
					  <td width="400" class="topp"></td>
    <td><img src="<?php echo SITE_IMAGES;?>poprighttop1.png" alt="ANP" /></td>
		          </tr>
				    <tr>
					  <td class="leftp"></td>
					  <td  align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
                        <tr>
                          <td colspan="2" align="right" valign="top" class="pad-rgt5"><a href="javascript:toggleLayer('holiday-more-properties-pop');"><img src="<?php echo SITE_IMAGES;?>pop-up-cross.gif" alt="Close" border="0" title="Close" /></a></td>
                        </tr>
                        <tr>
                          <td width="400" align="left" valign="top" class="head">More properties from the owner</td>
                          <td width="15" align="right" valign="top"><a href="#" onclick="javascript:toggleLayer('holiday-more-properties-pop');"></a></td>
                        </tr>
                        <tr>
                          <td  align="left" valign="top" class="PopTxt">
                          </td>
                          <td align="left" valign="top">&nbsp;</td>
                        </tr>
                        <tr>
                          <td  align="left" valign="top" class="PopTxt"><table width="100%" cellspacing="0" cellpadding="0">
                             
                              
                          </table>
                            <table border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td colspan="2" class="dash25">&nbsp;</td>
                              </tr>
                              <tr>
                                <td valign="top">
                                
                                <div class="pad-top5"><img src="<?php echo SITE_IMAGES;?>thumb88x66.gif" alt="<?php echo $sitetitle; ?>" width="88" height="66" /></div>
                                <div class="pad-top5">
                                  <a href="#" class="arrowLink">View details</a></div></td>
                                <td valign="top" class="pad-lft20"><table border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td>Grand Villa GAshokt: Luxury villa for 28 with pool &amp; very stunning sea views</td>
                                  </tr>
                                  <tr>
                                    <td><a href="#" class="blue-link">Kommetjie</a></td>
                                  </tr>
                                  <tr>
                                    <td>R10,100 - &pound;20,000 pw</td>
                                  </tr>
                                  <tr>
                                    <td>Sleep 28</td>
                                  </tr>
                                  <tr>
                                    <td>14 bedrooms</td>
                                  </tr>
                                </table></td>
                              </tr>
                            </table></td>
                          <td align="left" valign="top">&nbsp;</td>
                        </tr>
                        <tr>
                          <td  align="left" valign="top" class="PopTxt"><table border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td colspan="2" class="dash25">&nbsp;</td>
                            </tr>
                            <tr>
                              <td valign="top"><div class="pad-top5"><img src="<?php echo SITE_IMAGES;?>thumb88x66.gif" alt="<?php echo $sitetitle; ?>" width="88" height="66" /></div>
                                  <div class="pad-top5"> <a href="#" class="arrowLink">View details </a></div></td>
                              <td valign="top" class="pad-lft20"><table border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td>Grand Villa GAshokt: Luxury villa for 28 with pool &amp; very stunning sea views</td>
                                  </tr>
                                  <tr>
                                    <td><a href="#" class="blue-link">Kommetjie</a></td>
                                  </tr>
                                  <tr>
                                    <td>R10,100 - &pound;20,000 pw</td>
                                  </tr>
                                  <tr>
                                    <td>Sleep 28</td>
                                  </tr>
                                  <tr>
                                    <td>14 bedrooms</td>
                                  </tr>
                              </table></td>
                            </tr>
                          </table></td>
                          <td align="left" valign="top">&nbsp;</td>
                        </tr>
                        <tr>
                          <td  align="left" valign="top" class="PopTxt"><table border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td colspan="2" class="dash25">&nbsp;</td>
                            </tr>
                            <tr>
                              <td valign="top"><div class="pad-top5"><img src="<?php echo SITE_IMAGES;?>thumb88x66.gif" alt="<?php echo $sitetitle; ?>" width="88" height="66" /></div>
                                  <div class="pad-top5"> <a href="#" class="arrowLink">View details </a></div></td>
                              <td valign="top" class="pad-lft20"><table border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td>Grand Villa GAshokt: Luxury villa for 28 with pool &amp; very stunning sea views</td>
                                  </tr>
                                  <tr>
                                    <td><a href="#" class="blue-link">Kommetjie</a></td>
                                  </tr>
                                  <tr>
                                    <td>R10,100 - &pound;20,000 pw</td>
                                  </tr>
                                  <tr>
                                    <td>Sleep 28</td>
                                  </tr>
                                  <tr>
                                    <td>14 bedrooms</td>
                                  </tr>
                              </table></td>
                            </tr>
                          </table></td>
                          <td align="left" valign="top">&nbsp;</td>
                        </tr>
                        <tr>
                          <td  align="left" valign="top" class="PopTxt">&nbsp;</td>
                          <td align="left" valign="top">&nbsp;</td>
                        </tr>
                        
                      </table></td>
					  <td width="15" class="rightp" valign="top"><img src="<?php echo SITE_IMAGES;?>pop-arrow.png" vspace="115" /></td>
				    </tr>
				    <tr>
					  <td><img src="<?php echo SITE_IMAGES;?>popleftbtm.png" alt="ANP"/></td>
					  <td width="400" class="bottomp"></td>
					  <td><img src="<?php echo SITE_IMAGES;?>poprightbtm1.png" alt="ANP"/></td>
				    </tr>
</table>
			  </div>
              </div>
              <!-- ################## Pop Table end ################################### -->  
                
            </td>
        </tr>
        </table>
        <p><img src="<?php echo SITE_IMAGES;?>AddtoFav-Bottom1.gif"  /></p></td>
    </tr>
</table>
