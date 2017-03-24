<?php
if(isset($user_id) && $user_id !=""){
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
            <tr>
              <td valign="top" class="SectionSubHead"><?php echo $addtitle;?></td>
              <td valign="top" align="right" class="pad-btm20"><a href="#"><img src="images/add-request-admin.gif" alt="One" /></a></td>
            </tr>
            <tr>
              <td valign="top"><a href="Admin-Sitecollateral-NoticeboardRequestsListing.php" class="arrowLinkback">Back to list</a></td>
              <td align="right" valign="top">
              <a href="#" class="arrowLinkback">Previous</a>&nbsp; <span class="boldblack12">|</span> &nbsp; 
              <a href="#" class="arrowLinkNext">Next</a></td>
            </tr>
            <tr>
              <td height="8" colspan="2" valign="top" class="dash-top"></td>
            </tr>
            <tr>
              <td colspan="2" valign="top" class="pad-btm17"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="160" valign="top">Notice ID</td>
                  <td valign="top"><a href="#" class="blueTxt">951753</a></td>
                </tr>
                <tr>
                  <td valign="top">Posted by: Name</td>
                  <td valign="top"><a href="#" class="blueTxt">Mister Cabin</a></td>
                </tr>
                <tr>
                  <td valign="top">Posted by: ID</td>
                  <td valign="top">988563</td>
                </tr>
                <tr>
                  <td valign="top">Title</td>
                  <td valign="top">Looking for a lovely place in Kommetjie for the summer holiday</td>
                </tr>
                <tr>
                  <td valign="top">Noticeboard submitted to</td>
                  <td valign="top"><strong>Southern Suburbs:</strong> Kommetjie, Noordhoek, Capri, Fishhoek<br />
                    <strong>Northern Suburbs:</strong> Edgemead, Bothasig</td>
                </tr>
                <tr>
                  <td valign="top">Number of owners sent to</td>
                  <td valign="top">786</td>
                </tr>
                <tr>
                  <td valign="top">Number of owners replied</td>
                  <td valign="top">12</td>
                </tr>
                <tr>
                  <td valign="top">Date added</td>
                  <td valign="top">Jun 13, 2007</td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td colspan="2" valign="top" class="adminBox"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="80" valign="top" class="owner-headings5">Status</td>
                  <td valign="top" class="black pad-left7"><strong>LIVE</strong></td>
                </tr>
                
                <tr>
                  <td>&nbsp;</td>
                  <td class="pad-top15"><a href="#"><img src="images/suspend-admin.gif" alt="Approve"/></a> <a href="#"><img src="images/delete-admin.gif" alt="Decline" class="pad-left3"/></a> <a href="Admin-Sitecollateral-NoticeboardRequests.php"><img src="images/edit-admin.gif" class="pad-left3" alt="Suspend"/></a> </td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td colspan="2" valign="top">&nbsp;</td>
            </tr>
            
            <tr>
              <td colspan="2" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td valign="top" class="pad-top7"><p class="GreyFont16 pad-btm5">Family of four looking for a place to stay in Kommetjie or Noordhoek</p>
                      <p class="font11">By Ashok Green, Rutland</p>
                    <p class="font11">Posted: June 13, 2007</p>
                    <p class=" pad-top10">we have two dogs and need a place that allows pets, preferably within walking distance to the beach. we can travel up to the 25th January but have to be back for school team which starts on the 31st. We'd really like a pool and a garden as we have small children and security is key so the children can play outside. We have two dogs and need a place that allows pets, preferably within walking distance to the beach. We can travel up to the 25th January but have to be back for school term which starts on the 31st. We'd really like a pool and a garden as we have small children and security is key so the children can play outside.</p></td>
                </tr>
                <tr>
                  <td align="left" valign="top" class="pad-top15"><p class="owner-headings1">Destinations</p></td>
                </tr>
                <tr>
                  <td align="left" valign="top" class="pad-top7"><p class="boldblack12">Atlantic Seaboard North</p>
                      <p>All areas</p></td>
                </tr>
                <tr>
                  <td align="left" valign="top" class="pad-top5"><p class="boldblack12">Atlantic Seaboard South</p>
                      <p>Llandudno, Noordhoek, Kommetjie, Scarbrough, Newlands, Tokai, Muizenberg, Simonstown</p></td>
                </tr>
                <tr>
                  <td align="left" valign="top" class="pad-top15"><p class="owner-headings1">Details</p></td>
                </tr>
                <tr>
                  <td align="left" valign="top" class="pad-top7"><span class="boldblack12">Budget: </span> <span>&pound;100 - </span> &pound;300 per week</td>
                </tr>
                <tr>
                  <td align="left" valign="top"><span class="boldblack12">Travelling: </span> <span>2 adults, 2 children, 0 infants</span></td>
                </tr>
                <tr>
                  <td align="left" valign="top"><span class="boldblack12">Arrive: </span>June 14, 2007</td>
                </tr>
                <tr>
                  <td align="left" valign="top"><span class="boldblack12">Depart: </span>June 14, 2007</td>
                </tr>
                <tr>
                  <td align="left" valign="top"><span class="boldblack12">Flexible: </span>+ / - 7 days</td>
                </tr>
              </table></td>
            </tr>
            
            
            
        </table>
<?php
} else {
?>
    <!-- Main Table : Start here -->
   <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
          <tr>
              <td valign="top" class="SectionSubHead"><?php echo $addtitle;?></td>
              <td valign="top" align="right" class="pad-btm12"><a href="#"><img src="images/add-request-admin.gif" alt="One" /></a></td>
            </tr>
             <tr>
              <td height="10" colspan="2" valign="top" class="dash-top"></td>
            </tr>
            
            <tr>
              <td valign="top">
              <table border="0" cellspacing="0" cellpadding="2" class="boldTitle">
              <tr>
                <td><input name="radio" type="radio" class="radio" id="radio" value="radio" checked="checked" /></td>
                <td>View all</td>
                <td class="pad-lft20"><input name="radio" type="radio" class="radio" id="radio2" value="radio" /></td>
                <td>Filter</td>
              </tr>
            </table>

             </td>
              <td align="right" valign="top"><table border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td class="blackTxt14 pad-rgt5">Search </td>
                  <td class="pad-rgt5"><input name="textfield" type="text" class="Textfield210 blackText" id="textfield" value="ID, Name, Email address" /></td>
                  <td><a href="#"><img src="images/show-admin.gif" alt="Send"/></a></td>
                </tr>
              </table></td>
            </tr>
           
            
            <tr>
              <td  colspan="2" valign="top" class="blueBotBorder"><img src="images/spacer.gif" height="12" alt="One" /></td>
            </tr>
            <tr>
              <td colspan="2" valign="top" class="pad-top15"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
                
                <tr>
                  <td valign="top">Display 11-20 of 230</td>
                  <td align="right" valign="top" class="Paging"><a href="#">First</a> <a href="#">&lt;</a> <a href="#">1</a> | 2 | <a href="#">3</a> | <a href="#">4</a> | <a href="#">5</a> | <a href="#">6</a> | <a href="#">7</a> | <a href="#">8</a> | <a href="#">9</a> | <a href="#">10</a>...<a href="#">23</a> <a href="#">&gt;</a> <a href="#">Last</a></td>
                </tr>
               
                <tr>
                  <td colspan="2" valign="top" class="pad-top13"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="EventListing">
                      <thead>
                        <tr>
                          <th scope="col" class="left" onmouseover="this.className = 'leftOver';" onmouseout="this.className = 'left';"><div><a href="#">ID</a></div></th>
                          <th class="current" scope="col" onmouseover="this.className = 'RollOver';" onmouseout="this.className = 'current';"><div><a href="#">Posted by</a></div></th>
                          <th  scope="col" onmouseover="this.className = 'RollOver';" onmouseout="this.className = 'RollOut';"><div><a href="#">Title</a></div></th>
                          <th  scope="col" onmouseover="this.className = 'RollOver';" onmouseout="this.className = 'RollOut';"><div><a href="#">Owners sent to</a></div></th>
                          <th scope="col" onmouseover="this.className = 'RollOver';" onmouseout="this.className = 'RollOut';"><div><a href="#">Owners replied</a></div></th>
                          <th scope="col" onmouseover="this.className = 'RollOver';" onmouseout="this.className = 'RollOut';"><div><a href="#">Date added</a></div></th>
                          <th align="left" class="right" scope="col" onmouseover="this.className = 'rightOver';" onmouseout="this.className = 'right';"><div><a href="#">Status</a></div></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td width="30" class="left"><a href="Admin-Sitecollateral-NoticeboardRequestsViews.php">951753</a></td>
                          <td width="110"><a href="#">Mister Cabin</a></td>
                          <td width="170">A place for 3 people in Kommetjie</td>
                          <td width="30" align="center"><a href="#">23</a></td>
                          <td width="30" align="center"><a href="#">23</a></td>
                          <td width="70" align="center">Jun 12, 2007</td>
                          <td width="85" class="right">Pending approval</td>
                        </tr>
                        <tr>
                          <td class="left"><a href="Admin-Sitecollateral-NoticeboardRequestsViews.php">951753</a></td>
                          <td><a href="#">Ashok Green</a></td>
                          <td>A place for 3 people in Kommetjie</td>
                          <td align="center"><a href="#">756</a></td>
                          <td align="center"><a href="#">756</a></td>
                          <td align="center">Jun 12, 2007</td>
                          <td class="right">Pending approval</td>
                        </tr>
                        <tr>
                          <td class="left"><a href="Admin-Sitecollateral-NoticeboardRequestsViews.php">951753</a></td>
                          <td><a href="#">Maurice Williamson</a></td>
                          <td>A place for 3 people in Kommetjie</td>
                          <td align="center"><a href="#">111</a></td>
                          <td align="center"><a href="#">111</a></td>
                          <td align="center">Jun 12, 2007</td>
                          <td class="right">Pending approval</td>
                        </tr>
                        <tr>
                          <td class="left"><a href="Admin-Sitecollateral-NoticeboardRequestsViews.php">951753</a></td>
                          <td><a href="#">Mister Cabin</a></td>
                          <td>A place for 3 people in Kommetjie</td>
                          <td align="center"><a href="#">23</a></td>
                          <td align="center"><a href="#">23</a></td>
                          <td align="center">Jun 12, 2007</td>
                          <td class="right">Pending approval</td>
                        </tr>
                        <tr>
                          <td class="left"><a href="Admin-Sitecollateral-NoticeboardRequestsViews.php">951753</a></td>
                          <td><a href="#">Ashok Green</a></td>
                          <td>A place for 3 people in Kommetjie</td>
                          <td align="center"><a href="#">45</a></td>
                          <td align="center"><a href="#">45</a></td>
                          <td align="center">Jun 12, 2007</td>
                          <td class="right">Pending approval</td>
                        </tr>
                        <tr>
                          <td class="left"><a href="Admin-Sitecollateral-NoticeboardRequestsViews.php">951754</a></td>
                          <td><a href="#">Maurice Williamson</a></td>
                          <td>A place for 3 people in Kommetjie</td>
                          <td align="center"><a href="#">28</a></td>
                          <td align="center"><a href="#">28</a></td>
                          <td align="center">Jun 12, 2007</td>
                          <td class="right">Pending approval</td>
                        </tr>
                      </tbody>
                  </table></td>
                </tr>
                <tr>
                  <td colspan="2" valign="top">&nbsp;</td>
                </tr>
                <tr>
                  <td valign="top">&nbsp;</td>
                  <td align="right" valign="top" class="Paging"><a href="#">First</a> <a href="#">&lt;</a> <a href="#">1</a> | 2 | <a href="#">3</a> | <a href="#">4</a> | <a href="#">5</a> | <a href="#">6</a> | <a href="#">7</a> | <a href="#">8</a> | <a href="#">9</a> | <a href="#">10</a>...<a href="#">23</a> <a href="#">&gt;</a> <a href="#">Last</a></td>
                </tr>
              </table></td>
            </tr>
            <tr>
              <td colspan="2" valign="top">&nbsp;</td>
            </tr>
            
            <tr>
              <td colspan="2" valign="top">&nbsp;</td>
            </tr>
            
            
            
        </table>
    <!-- Main Table : End here -->
<?php
}
?>