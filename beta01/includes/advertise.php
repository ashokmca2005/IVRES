<div class="pad-lft10 pad-top15" align="center">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
        <tr><td align="left" valign="top"><h1 class="page-headingNew">Choose your "Pay Per Lead" Package</h1></td></tr>
        <tr>
            <td align="center" valign="top" class="pad-lft25 pad-btm10">
                <script language="javascript" type="text/javascript">
                    function choosePrd(str) {
                        //alert(str);
                        document.getElementById("products_id").value = str;
                        document.frmUserPackage.submit();
                    }
                </script>
                <form name="frmUserPackage" id="frmUserPackage" action="<?php if($_SESSION['ses_user_home'] == SITE_URL."owner-home") { echo SITE_URL."owner-shopping-cart";} else {echo SITE_URL."owner-login";} ?>" method="post">
                    <input type="hidden" name="securityKey" value="<?php echo md5("SELECTPACKAGE");?>" />
                    <input type="hidden" name="products_id" id="products_id" value="" />
                    <input type="hidden" name="txtIsOwner" value="1" />
                    <style type="text/css">
                        .box-testimonial {
                            font-family:Verdana, Arial, Helvetica, sans-serif;
                            font-size:12px;
                            font-weight:normal;
                            color:#2aa0fc;
                            text-align:center;
                            vertical-align:middle;
                            margin:0px;
                            display:block;
                            float:right;
                            border:thin solid #ccc;
                            -moz-border-radius:5px;
                            -webkit-border-radius:5px;
                            border-radius:5px;
                            box-shadow:0px 5px 10px #ccc;
                            background-color:#fff;
                            padding:5px 10px 5px 10px;
                        }
                        .box-testimonial p {
                            font-family:Verdana, Arial, Helvetica, sans-serif;
                            font-size:12px;
                            font-weight:normal;
                            text-align:left;
                            color:#333;
                            border-bottom:thin #CCCCCC solid; 
                            margin:0px 5px 0px 5px;
                            padding:10px 0px 10px 0px;
                        }

                        .box-package {
                            font-family:Verdana, Arial, Helvetica, sans-serif;
                            font-size:12px;
                            font-weight:normal;
                            color:#2aa0fc;
                            text-align:center;
                            vertical-align:middle;
                            margin:0px;
                            display:block;
                            float:left;
                            border:thin solid #ccc;
                            -moz-border-radius:5px;
                            -webkit-border-radius:5px;
                            border-radius:5px;
                            box-shadow:0px 5px 10px #ccc;
                            background-color:#fff;
                            padding:5px 10px 5px 10px;
                        }
                        *html .box-package {
                            font-family:Verdana, Arial, Helvetica, sans-serif;
                            font-size:12px;
                            font-weight:normal;
                            color:#2aa0fc;
                            text-align:center;
                            vertical-align:middle;
                            margin:0px;
                            display:block;
                            float:left;
                            border:thin solid #ccc;
                            -moz-border-radius:5px;
                            -webkit-border-radius:5px;
                            border-radius:5px;
                            box-shadow:0px 5px 10px #ccc;
                            background-color:#fff;
                            padding:5px 10px 5px 10px;
                        }
                        .box-package H2 {
                            font-family:Verdana, Arial, Helvetica, sans-serif;
                            font-size:20px;
                            font-weight:bold;
                            color:#2aa0fc;
                        }
                        .price-txt {
                            font-family:Verdana, Arial, Helvetica, sans-serif;
                            font-size:24px;
                            font-weight:bold;
                            color:#2aa0fc;
                        }
                        .orange-txt {
                            font-family:Verdana, Arial, Helvetica, sans-serif;
                            font-size:12px;
                            font-weight:normal;
                            color:#f8983c;
                        }
                        .box-package p {
                            font-family:Verdana, Arial, Helvetica, sans-serif;
                            font-size:12px;
                            font-weight:normal;
                            color:#333;
                            border-bottom:thin #CCCCCC solid; 
                            margin:0px 5px 0px 5px;
                            padding:10px 0px 10px 0px;
                        }
                        .select-button {
                            font-family:Arial, Helvetica, sans-serif;
                            font-size:15px;
                            font-weight:bold;
                            color:#fff;
                            text-transform:uppercase;
                            width:100px;
                            height:30px;
                            background-color:#f8983c;
                            background-image: -moz-linear-gradient(top, #f8983c, #f8983c);
                            border:thin #f8983c solid; 
                            border-radius:5px;
                            -o-border-radius:5px;
                            -moz-border-radius:5px;
                            text-align:center;
                            vertical-align: middle;
                            cursor:pointer;
                            padding:5px 5px 5px 5px;
                        }
                    </style>
                    <div class="pad-btm5">
                        <div class="box-package" style="width:180px;margin-top:47px;">
                            <H2>BASIC <br />PACKAGE</H2>
                            $<span class="price-txt"><?php echo $basic_products_price; ?></span>
                            <br /><br />
                            <p><span class="orange-txt"><?php echo $basic_products_credit; ?></span> Leads</p>
							<?php /*?>
                            <p><span class="orange-txt">1000</span> text description</p>
                            <p>Monthly Reporting</p>
                            <p><span class="orange-txt">No</span> Monthly Newsletters</p>
                            <p>Account Representative</p>
                            <p><span class="orange-txt">No</span> Personal Weblink</p>
                            <p><span class="orange-txt"><strong>Google Map</strong></span></p>
							<?php */?>
                            <br />
                            <input type="button" name="addtocart1" id="addtocart1" class="select-button" value="Sign Up" onclick="return choosePrd(<?php echo $basic_products_id; ?>);" />
                            <br />
                        </div>
                        <div class="box-package" style="width:200px;margin-top:29px; margin-left:-10px;">
                            <H2>BRONZE <br />PACKAGE</H2>
                            $<span class="price-txt"><?php echo $bronze_products_price; ?></span>
                            <br /><br /><br />
                            <p><span class="orange-txt"><?php echo $bronze_products_credit; ?></span> Leads</p>

							<?php /*?>
                            <p><span class="orange-txt">12</span> Photos</p>
                            <p><span class="orange-txt">1000</span> text description</p>
                            <p>Monthly Reporting</p>
                            <p><span class="orange-txt">No</span> Monthly Newsletters</p>
                            <p>Account Representative</p>
                            <p><span class="orange-txt">No</span> Personal Weblink</p>
                            <p><span class="orange-txt">No</span> Video Tour Link</p>
                            <p><span class="orange-txt"><strong>Google Map</strong></span></p>
							<?php */?>
                            <br /><br />
                            <input type="button" name="addtocart1" id="addtocart1" class="select-button" value="Sign Up" onclick="return choosePrd(<?php echo $bronze_products_id; ?>);" />
                            <br /><br />
                        </div>
                        <div class="box-package" style="width:220px;margin-top:15px; margin-left:-10px;">
                            <H2>SILVER <br />PACKAGE</H2>
                            $<span class="price-txt"><?php echo $silver_products_price; ?></span>
                            <br /><br />
                            <br /><br />
                            <p><span class="orange-txt"><?php echo $silver_products_credit; ?></span> Leads</p>
							<?php /*?>
                            <p><span class="orange-txt">2000</span> text description</p>
                            <p>Monthly Reporting</p>
                            <p>Monthly Newsletters</p>
                            <p>Account Representative</p>
                            <p><span class="orange-txt">No</span> Personal Weblink</p>
                            <p>Video Tour Link</p>
                            <p><span class="orange-txt"><strong>Google Map</strong></span></p>
							<?php */?>
                            <br />
                            <br /><br />
                            <input type="button" name="addtocart1" id="addtocart1" class="select-button" value="Sign Up" onclick="return choosePrd(<?php echo $silver_products_id; ?>);" />
                            <br />
                            <br />
                        </div>
                        <div class="box-package" style="width:240px; margin-left:-10px;">
                            <H2>GOLD <br />PACKAGE</H2>
                            $<span class="price-txt"><?php echo $gold_products_price; ?></span>
                            <br /><br />
                            <br /><br /><br />
                            <p><span class="orange-txt"><?php echo $gold_products_credit; ?></span> Leads</p>
							<?php /*?>
                            <p><span class="orange-txt">Unlimited</span> text description</p>
                            <p>Monthly Reporting</p>
                            <p>Monthly Newsletters</p>
                            <p>Account Representative</p>
                            <p>Personal Weblink</p>
                            <p>Video Tour Link</p>
                            <p>City Page featured Rental spot</p>
                            <p><span class="orange-txt"><strong>Google Map</strong></span></p>
							<?php */?>
                            <br />
                            <br />
                            <br />
                            <br />
                            <input type="button" name="addtocart1" id="addtocart1" class="select-button" value="Sign Up" onclick="return choosePrd(<?php echo $gold_products_id; ?>);" />
                            <br />
                            <br />
                        </div>
                    </div>
                </form>
            </td>
        </tr>
    </table>
</div>
