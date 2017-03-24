<?php
if(isset($user_id) && $user_id !=""){
?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td valign="top"><a href="admin-pending-approval.php?sec=newusers" class="arrowLinkback">Back to list</a></td>
            <td align="right" valign="top">
                <a href="#" class="arrowLinkback">Previous</a>&nbsp; <span class="boldblack12">|</span> &nbsp; 
                <a href="#" class="arrowLinkNext">Next</a>
            </td>
        </tr>
    </table>
<?php
} else {
?>
    <!-- Main Table : Start here -->
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
            <tr>
              <td class="SectionSubHead pad-btm12"><?php echo $addtitle;?></td>
            </tr>
            <tr>
              <td valign="top" class="pad-btm12"><table width="350" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="260">Total payments all time</td>
                  <td align="right">123,332</td>
                </tr>
                <tr>
                  <td>Avg payments per month - all time</td>
                  <td align="right">12,122</td>
                </tr>
                <tr>
                  <td>Avg payments per month - last 12 months</td>
                  <td align="right">234</td>
                </tr>
                <tr>
                  <td>Avg payments per month - last 3 months</td>
                  <td align="right">432</td>
                </tr>   
              </table></td>
            </tr>
            <tr>
              <td class="SectionSubHead pad-btm15"><table border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td class="blackTxt14 pad-rgt5">Select Year</td>
                  <td><select name="select" class="Listmenu80" id="select">
                    <option>2008</option>
                  </select>                  </td>
                </tr>
              </table></td></tr>             
            <tr>
              <td valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="EventListing2">
                <thead>
                  <tr>
                    <th class="left tableHeader" scope="col">&nbsp;</th>
                    <th align="center" class="tableHeader" scope="col">Jan</th>
                    <th align="center" scope="col" class="tableHeader">Feb</th>
                    <th align="center" scope="col" class="tableHeader">Mar</th>
                    <th align="center" scope="col" class="tableHeader">Apr</th>
                    <th align="center" scope="col" class="tableHeader">May </th>
                    <th align="center" scope="col" class="tableHeader">Jun</th>
                    <th align="center" scope="col" class="tableHeader">Jul</th>
                    <th align="center" scope="col" class="tableHeader">Aug</th>
                    <th align="center" scope="col" class="tableHeader">Sep</th>
                    <th align="center" scope="col" class="tableHeader">Oct</th>
                    <th align="center" scope="col" class="tableHeader">Nov</th>
                    <th align="center" class="right tableHeader" scope="col">Dec</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td align="left" class="left">Total payments</td>
                    <td align="center">0000.00</td>
                    <td align="center">0000.00</td>
                    <td align="center">0000.00</td>
                    <td align="center">0000.00</td>
                    <td align="center">0000.00</td>
                    <td align="center">0000.00</td>
                    <td align="center">0000.00</td>
                    <td align="center">0000.00</td>
                    <td align="center">0000.00</td>
                    <td align="center">0000.00</td>
                    <td align="center">0000.00</td>
                    <td align="center" class="right">0000.00</td>
                  </tr>
                  <tr>
                    <td align="left" class="left">% change on<br />
                      previous month</td>
                    <td align="center">0000.00</td>
                    <td align="center">0000.00</td>
                    <td align="center">0000.00</td>
                    <td align="center">0000.00</td>
                    <td align="center">0000.00</td>
                    <td align="center">0000.00</td>
                    <td align="center">0000.00</td>
                    <td align="center">0000.00</td>
                    <td align="center">0000.00</td>
                    <td align="center">0000.00</td>
                    <td align="center">0000.00</td>
                    <td align="center" class="right">0000.00</td>
                  </tr>
                  <tr>
                    <td align="left" class="left">Actual change<br />
                      on previous<br />
                      month</td>
                    <td align="center">0000.00</td>
                    <td align="center">0000.00</td>
                    <td align="center">0000.00</td>
                    <td align="center">0000.00</td>
                    <td align="center">0000.00</td>
                    <td align="center">0000.00</td>
                    <td align="center">0000.00</td>
                    <td align="center">0000.00</td>
                    <td align="center">0000.00</td>
                    <td align="center">0000.00</td>
                    <td align="center">0000.00</td>
                    <td align="center" class="right">0000.00</td>
                  </tr>
                </tbody>
              </table></td>
            </tr>
            <tr>
              <td valign="top" class="pad-btm20">&nbsp;</td>
            </tr>
            <tr>
              <td valign="top" class="owner-headings">Individual Payment statistics and status</td>
            </tr>     
            <tr>
              <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
                <tr>
                  <td valign="top">Display 11-20 of 230</td>
                  <td align="right" valign="top" class="Paging"><a href="#">First</a> <a href="#">&lt;</a> <a href="#">1</a> | 2 | <a href="#">3</a> | <a href="#">4</a> | <a href="#">5</a> | <a href="#">6</a> | <a href="#">7</a> | <a href="#">8</a> | <a href="#">9</a> | <a href="#">10</a>...<a href="#">23</a> <a href="#">&gt;</a> <a href="#">Last</a></td>
                </tr>
                <tr>
                  <td colspan="2" valign="top" class="pad-top13"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="EventListing">
                      <thead>
                        <tr>
                          <th scope="col" class="left">&nbsp;</th>
                          <th class="current" scope="col" onmouseover="this.className = 'RollOver';" onmouseout="this.className = 'current';"><div><a href="#">Name</a></div></th>
                          <th  scope="col" onmouseover="this.className = 'RollOver';" onmouseout="this.className = 'RollOut';"><div><a href="#">Country</a></div></th>
                          <th  scope="col" onmouseover="this.className = 'RollOver';" onmouseout="this.className = 'RollOut';"><div><a href="#">No. of<br />
                            Props</a></div></th>
                          <th  scope="col" onmouseover="this.className = 'RollOver';" onmouseout="this.className = 'RollOut';"><div><a href="#">Total Payments</a></div></th>
                          <th scope="col" onmouseover="this.className = 'RollOver';" onmouseout="this.className = 'RollOut';"><div><a href="#">Avg payment<br />
                            per month</a></div></th>
                          <th scope="col" onmouseover="this.className = 'RollOver';" onmouseout="this.className = 'RollOut';"><div><a href="#">Avg payment per<br />
                            prop / month</a></div></th>
                          <th align="left" class="right" scope="col" onmouseover="this.className = 'rightOver';" onmouseout="this.className = 'right';"><div><a href="#">Total outstanding</a></div></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td width="40" class="left"><a href="Admin-Sitecollateral-OwnerGuidesViews.php">View</a></td>
                          <td width="200">Mister Cabin</td>
                          <td width="55" align="center">UK</td>
                          <td width="75" align="center">5</td>
                          <td width="65" align="center">00,000</td>
                          <td width="90" align="right">12</td>
                          <td width="125" align="right">12</td>
                          <td width="60" align="right" class="right">12</td>
                        </tr>
                        <tr>
                          <td class="left"><a href="Admin-Sitecollateral-OwnerGuidesViews.php">View</a></td>
                          <td>Ashok Green</td>
                          <td align="center">SA</td>
                          <td align="center">4</td>
                          <td align="center">00,000</td>
                          <td align="right">123</td>
                          <td align="right">123</td>
                          <td align="right" class="right">123</td>
                        </tr>
                        <tr>
                          <td class="left"><a href="Admin-Sitecollateral-OwnerGuidesViews.php">View</a></td>
                          <td>Mister Cabin</td>
                          <td align="center">SA</td>
                          <td align="center">4</td>
                          <td align="center">00,000</td>
                          <td align="right">1,123</td>
                          <td align="right">1,1123</td>
                          <td align="right" class="right">1,1123</td>
                        </tr>
                        <tr>
                          <td class="left"><a href="Admin-Sitecollateral-OwnerGuidesViews.php">View</a></td>
                          <td>Ashok Green</td>
                          <td align="center">SA</td>
                          <td align="center">1</td>
                          <td align="center">00,000</td>
                          <td align="right">23</td>
                          <td align="right">23</td>
                          <td align="right" class="right">23</td>
                        </tr>
                        <tr>
                          <td class="left"><a href="Admin-Sitecollateral-OwnerGuidesViews.php">View</a></td>
                          <td>Mister Cabin</td>
                          <td align="center">SA</td>
                          <td align="center">1</td>
                          <td align="center">00,000</td>
                          <td align="right">12</td>
                          <td align="right">12</td>
                          <td align="right" class="right">12</td>
                        </tr>
                        <tr>
                          <td class="left"><a href="Admin-Sitecollateral-OwnerGuidesViews.php">View</a></td>
                          <td>Ashok Green</td>
                          <td align="center">SA</td>
                          <td align="center">1</td>
                          <td align="center">00,000</td>
                          <td align="right">123</td>
                          <td align="right">123</td>
                          <td align="right" class="right">12</td>
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
        </table>
    <!-- Main Table : End here -->
<?php
}
?>