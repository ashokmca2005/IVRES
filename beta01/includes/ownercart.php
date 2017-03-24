<?php
if($_POST['securityKey']==md5("ADDPROMOCODE")){
	$txtPromotionalCode 	= trim($_POST['txtPromotionalCode']);
	if($txtPromotionalCode != "" && $txtPromotionalCode != "Enter promo code here") {
		$promoInfoArr 			= $promoObj->fun_getPromoInfoByCode($txtPromotionalCode);
		$promo_cat_ids 			= $promoInfoArr['promo_cat_ids'];
		$promo_reduction 		= $promoInfoArr['promo_reduction'];
		$promo_reduction_type 	= $promoInfoArr['promo_reduction_type'];
		$promo_takeup 			= $promoInfoArr['promo_takeup'];
		$promo_by_quantity 		= $promoInfoArr['promo_by_quantity'];
		$promo_start_date 		= $promoInfoArr['promo_start_date'];
		$promo_end_date 		= $promoInfoArr['promo_end_date'];
		$active 				= $promoInfoArr['active'];
		
		$cur_time 				= time();
		$productIdsArr 			= $promoObj->fun_getPromoProductsArrByCatIds($promo_cat_ids);
		//print_r($productIdsArr);

		$userPromoCount 		= $promoObj->fun_countPromoUserCode($txtPromotionalCode, $user_id);
		$applypromo = false;
		if($promo_by_quantity == "0" && strtotime($promo_start_date) <= $cur_time && $cur_time <= strtotime($promo_end_date)) {
			$applypromo = true;
		} else if($promo_by_quantity == "1" && $promo_takeup > 0  && strtotime($promo_start_date) <= $cur_time && $cur_time <= strtotime($promo_end_date) && $userPromoCount < 1) {
			$applypromo = true;
		}
	}
}
?>
<script language="javascript" type="text/javascript">
	var req = ajaxFunction();
	function updateQuantity(strQuantity, strBasketId) {
		if(strQuantity != "" && strBasketId != "") {
			req.onreadystatechange = handleUpdateQuanityResponse;
			req.open('get', '<?php echo SITE_URL;?>basketupdatequantityXml.php?quantity='+strQuantity+'&basketid='+strBasketId); 
			req.send(null);   
		}
	}

	function handleUpdateQuanityResponse(){
		if(req.readyState == 4){
			var response = req.responseText;
			xmlDoc = req.responseXML;
			var root = xmlDoc.getElementsByTagName('baskets')[0];
			if(root != null){
				var items = root.getElementsByTagName("basket");
				for (var i = 0 ; i < items.length ; i++){
					var item 				= items[i];
					var basketstatus 		= item.getElementsByTagName("basketstatus")[0].firstChild.nodeValue;
					if(basketstatus == "basket updated."){
						location.href = window.location;
					}
				}
			}
		}
	}

	function delBasketItem(){
		closeWindow();
		if(document.getElementById("txtDelItem").value != "") {
			var strBasketId = document.getElementById("txtDelItem").value;
			req.onreadystatechange = handleDeleteBasketItemResponse;
			req.open('get', '<?php echo SITE_URL;?>basketdeleteXml.php?basketid='+strBasketId); 
			req.send(null);   
		}
	}
	function handleDeleteBasketItemResponse(){
		if(req.readyState == 4){
			var response = req.responseText;
			xmlDoc = req.responseXML;
			var root = xmlDoc.getElementsByTagName('baskets')[0];
			if(root != null){
				var items = root.getElementsByTagName("basket");
				for (var i = 0 ; i < items.length ; i++){
					var item 				= items[i];
					var basketstatus 		= item.getElementsByTagName("basketstatus")[0].firstChild.nodeValue;
					if(basketstatus == "basket deleted."){
						location.href = window.location;
					}
				}
			}
		}
	}

	function chkPromotionalCode() {
		var strGetId = "txtPromotionalCodeId";
		if(document.getElementById(strGetId).value != "" || document.getElementById(strGetId).value != "Enter promo code here") {
			var pcode = document.getElementById(strGetId).value;
			var userId = "<?php echo $user_id; ?>";
			req.onreadystatechange = handleChkPromotionalCodeResponse;
			req.open('get', '<?php echo SITE_URL;?>chekpromocodeXml.php?usr='+userId+'&pcode='+pcode); 
			req.send(null);   
		}
	}

	function handleChkPromotionalCodeResponse(){
		if(req.readyState == 4){
			var response = req.responseText;
			xmlDoc = req.responseXML;
			//alert(req.responseText);
			var root = xmlDoc.getElementsByTagName('itms')[0];
			if(root != null){
				var items = root.getElementsByTagName("itm");
				var item = items[0];
				var itmstatus = item.getElementsByTagName("itmstatus")[0].firstChild.nodeValue;
				if(itmstatus == "available."){
					addPromotionalCode();
				} else {
					document.getElementById("txtPromotionalCodeErrorId").innerHTML = "Invalid Promotion code.";
				}
			}
		}
	}

/*
	function addPromotionalCode() {
		var strGetId = "txtPromotionalCodeId";
		var strPutId = "txtPromotionalCodesId";
		var txtGetCodes = document.getElementById(strGetId).value;
		var txtPutCodes = document.getElementById(strPutId).value;
		if(txtPutCodes != "") {
			document.getElementById(strPutId).value = txtPutCodes+","+txtGetCodes;
		} else {
			document.getElementById(strPutId).value = txtGetCodes;
		}
	}
*/
	function addPromotionalCode() {
		var strGetId = "txtPromotionalCodeId";
		var strPutId = "txtPromotionalCodesId";
		var txtGetCodes = document.getElementById(strGetId).value;
		var txtPutCodes = document.getElementById(strPutId).value;
		document.getElementById(strPutId).value = txtGetCodes;
	}

	function calculatePromoDiscount(){
		document.getElementById("securityKey").value = "<?php echo md5('ADDPROMOCODE')?>";
		document.frmUserCart.submit();
	}

/*
	function calculatePromoDiscount() {
		var strCodeId = "txtPromotionalCodesId";
		var txtCodes = document.getElementById(strCodeId).value;
		if(txtCodes != "") {
			var userId = "<?php //echo $user_id; ?>";
			req.onreadystatechange = handleCalculatePromotionalCodeResponse;
			req.open('get', '<?php //echo SITE_URL;?>getpromotionalcodesDiscount.php?usr='+userId+'&pcodes='+txtCodes); 
			req.send(null);   
		}
	}

	function handleCalculatePromotionalCodeResponse(){
		if(req.readyState == 4){
			var response = req.responseText;
			var val = response.split("~");
			var strTxt = "<span class=\"gray18Arial\">Total :</span><span class=\"pink18\"> R"+val[0]+"</span><br>\n";
			strTxt += "<span class=\"pink12arial\"><strong>This price includes a R"+val[1]+" discount</strong></span>";
			document.getElementById("txtBasketTotalAmtId").innerHTML = strTxt;
		}
	}
*/
	function checkout(){
		document.getElementById("securityKey").value = "<?php echo md5('CHECKOUT')?>";
		document.frmUserCart.action = "<?php echo SITE_URL;?>checkout.php?action=process";
		document.frmUserCart.submit();
	}

	function delItem(strId) {
		document.getElementById("txtDelItem").value = strId;
	}

	function submitBacklinkActivation(pid) {
		if(pid != "") {
			req.onreadystatechange = handleSubmitBacklinkResponse;
			req.open('get', '<?php echo SITE_URL;?>addBacklinkActivationXml.php?pid='+pid); 
			req.send(null);   
		}
	}


	function handleSubmitBacklinkResponse(){
		if(req.readyState == 4){
			var response = req.responseText;
			xmlDoc = req.responseXML;
			var root = xmlDoc.getElementsByTagName('backlinks')[0];
			if(root != null){
				var items = root.getElementsByTagName("backlink");
				var item = items[0];
				var backlinkid = item.getElementsByTagName("backlinkid")[0].firstChild.nodeValue;
				if(backlinkid != "invalid"){
					location.href = '<?php echo SITE_URL."owner-backlink-activation.php?id=";?>'+backlinkid;
				} else {
					document.getElementById("showErrorValidStatus").innerHTML = "Invalid Request";
				}
			}
		}
	}
</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
<?php
$ownerCartItemsArr = $cartObj->fun_getOwnerCartItemsArr($user_id);
if(is_array($ownerCartItemsArr) && count($ownerCartItemsArr) > 0) {
?>
    <tr><td class="pad-top5">&nbsp;</td></tr>
    <tr>
        <td align="left" valign="top" style="border:#CCCCCC thin solid; padding:5px;">
            <h3>Order Summary</h3>
            <!-- Main cart section: start here -->
                <form name="frmUserCart" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="hidden" name="securityKey" id="securityKey" value="<?php echo md5("USERCART"); ?>" />
                <input type="hidden" name="txtUserId" id="txtUserId" value="<?php echo $user_id; ?>" />
                <input type="hidden" name="txtPromotionalCodes" id="txtPromotionalCodesId" value="<?php echo $_POST['txtPromotionalCodes']; ?>" />
                <input type="hidden" name="txtDelItem" id="txtDelItem" value="" />
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
                    <tr>
                        <td valign="top" class="pad-top15">
                            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EventListing">
                                <tbody style="font-size:11px;">
                                <tr class="font12-darkgrey">
                                    <td width="15%"><?php echo tranText('reference'); ?></td>
                                    <td width="25%"><?php echo tranText('description'); ?></td>
                                    <td width="20%" align="right"><?php echo tranText('cost_per_unit'); ?></td>
                                    <td width="10%" align="center"><?php echo tranText('units'); ?></td>
                                    <td width="15%" align="right" style="padding-right:0px;"><?php echo tranText('total_cost'); ?></td>
                                    <td width="15%" align="left" class="right">&nbsp;</td>
                                </tr>
                                <?php
                                //print_r($ownerCartItemsArr);
                                $total_payble_amt 	= 0;
                                $total_discount 	= 0;
                                $hiddenHTML 		= "";
                                for($i=0; $i<count($ownerCartItemsArr); $i++){
                                    $user_basket_id 		= $ownerCartItemsArr[$i]['user_basket_id'];
                                    $property_id	 		= $ownerCartItemsArr[$i]['property_id'];
                                    $products_id 			= $ownerCartItemsArr[$i]['products_id'];
                                    $products_name 			= $ownerCartItemsArr[$i]['products_name'];
                                    $hiddenHTML .= "<input type=\"hidden\" name=\"txtPropertyIds[".$i."]\" id=\"txtPropertyIds".$i."\" value=\"".$property_id."\" />";
                                    $hiddenHTML .= "<input type=\"hidden\" name=\"txtProductIds[".$i."]\" id=\"txtProductIds".$i."\" value=\"".$products_id."\" />";
                                    $hiddenHTML .= "<input type=\"hidden\" name=\"txtProductPrice[".$i."]\" id=\"txtProductPrice".$i."\" value=\"".$ownerCartItemsArr[$i]['products_price']."\" />";
                                    $hiddenHTML .= "<input type=\"hidden\" name=\"txtProductQuantity[".$i."]\" id=\"txtProductQuantity".$i."\" value=\"".$ownerCartItemsArr[$i]['user_basket_quantity']."\" />";
                                    if(($applypromo == true) && in_array($products_id, $productIdsArr)) {
                                        $products_org_price 		= "$".number_format($ownerCartItemsArr[$i]['products_price']).".00";
                                        $products_org_price_txt		= "<s>".$products_org_price."</s>";
                                        if($promo_reduction_type == "0") {
                                            $total_discount += ($ownerCartItemsArr[$i]['products_price']*$promo_reduction)/100;
                                            $ownerCartItemsArr[$i]['products_price'] = ($ownerCartItemsArr[$i]['products_price'] - (($ownerCartItemsArr[$i]['products_price']*$promo_reduction)/100));
                                        } else {
                                            $total_discount += $promo_reduction;
                                            $tmpPrice = $ownerCartItemsArr[$i]['products_price'];
                                            $ownerCartItemsArr[$i]['products_price'] = ($tmpPrice - (int)$promo_reduction);
                                        }
                                        $products_price 		= "$".number_format($ownerCartItemsArr[$i]['products_price']).".00";
                                        $products_price_txt		= $products_org_price_txt."&nbsp;&nbsp;<span class=\"pink12\">".$products_price."</span>";
                                    } else {
                                        $products_org_price 	= "";
                                        $products_org_price_txt	= "";
                                        $products_price 		= "$".number_format($ownerCartItemsArr[$i]['products_price']).".00";
                                        $products_price_txt		= $products_price;
                                    }
                                    $hiddenHTML .= "<input type=\"hidden\" name=\"txtProductFinalPrice[".$i."]\" id=\"txtProductFinalPrice".$i."\" value=\"".($ownerCartItemsArr[$i]['products_price']*$ownerCartItemsArr[$i]['user_basket_quantity'])."\" />";
                                    $property_id 			= $ownerCartItemsArr[$i]['property_id'];
                                    if($products_name == "Extra images") {
                                        $user_basket_quantity	= $ownerCartItemsArr[$i]['user_basket_quantity'];
                                        $total_payble_amt 	+= number_format(($ownerCartItemsArr[$i]['products_price']*$user_basket_quantity));
                                        if(($applypromo == true) && in_array($products_id, $productIdsArr)) {
                                            $final_price 		= "<span class=\"pink12\">$".number_format($ownerCartItemsArr[$i]['products_price']*$user_basket_quantity).".00</span>";
                                        } else {
                                            $final_price 		= "$".number_format($ownerCartItemsArr[$i]['products_price']*$user_basket_quantity).".00";
                                        }
                                    } else if($products_name == "Featured property listing") {
                                        $user_basket_quantity	= $ownerCartItemsArr[$i]['user_basket_quantity'];
                                        $total_payble_amt 		+= number_format(($ownerCartItemsArr[$i]['products_price']*$user_basket_quantity));
                                        if(($applypromo == true) && in_array($products_id, $productIdsArr)) {
                                            $final_price 		= "<span class=\"pink12\">$".number_format($ownerCartItemsArr[$i]['products_price']*$user_basket_quantity).".00</span>";
                                        } else {
                                            $final_price 		= "$".number_format($ownerCartItemsArr[$i]['products_price']*$user_basket_quantity).".00";
                                        }
                                        $products_name = "Featured property listing for ".$user_basket_quantity." weeks";
                                        $user_basket_quantity	= "";
                                    } else {
                                        $user_basket_quantity	= "";
                                        $total_payble_amt 		+= number_format(($ownerCartItemsArr[$i]['products_price']));
                                        if(($applypromo == true) && in_array($products_id, $productIdsArr)) {
                                            $final_price 		= "<span class=\"pink12\">$".number_format($ownerCartItemsArr[$i]['products_price']).".00</span>";
                                        } else {
                                            $final_price 		= "$".number_format($ownerCartItemsArr[$i]['products_price']).".00";
                                        }

                                    }
                                    $user_basket_date_added = $ownerCartItemsArr[$i]['user_basket_date_added'];
                                ?>
                                <tr>
                                    <td class="left"><?php echo fill_zero_left($property_id, "0", (6-strlen($property_id)));?></td>
                                    <td align="left" class="pad-lft10">
                                    <?php
                                    if($products_name !=""){
                                        switch($products_name){
                                            case 'Extra images':
                                                echo "additional images";
                                            break;
                                            case 'Extra videos':
                                                echo "additional videos";
                                            break;
                                            default:
                                                echo $products_name;
                                        }
                                    }
                                     
                                     ?>
                                    </td>
                                    <td align="right" class="pad-lft15 pad-topbtm10"><?php echo $products_price_txt; ?></td>
                                    <td align="right" class="pad-topbtm10 pad-lft15">
                                    <?php
                                    if($user_basket_quantity !=""){
                                        echo "<select name=\"select4\" class=\"RegFormDate\" onchange=\"updateQuantity(this.value, '".$user_basket_id."', '".$user_basket_id."');\" >";
                                        for($k=1; $k<=35; $k++){
                                            if($k == $user_basket_quantity){
                                                echo "<option value=\"$k\" selected>$k</option>";
                                            } else{
                                                echo "<option value=\"$k\">$k</option>";
                                            }
                                        }
                                        echo "</select>";
                                    }
                                    ?>
                                    </td>
                                    <td align="right" class="pad-lft15 pad-topbtm10"><?php echo $final_price;?></td>
                                    <td align="right" class="pad-topbtm10">
                                        <?php
                                        //if($products_id != "6" && $products_id != "14" && $products_id != "15" && $products_id != "16" && $products_id != "17") {
                                        ?>
                                            <a href="javascript:delItem(<?php echo $user_basket_id; ?>);toggleLayer('cart-item-delete-pop');" class="removeText"><?php echo tranText('remove'); ?></a>
                                        <?php
                                        //}
                                        ?>
                                    </td>
                                </tr>
                                <?php
                                }
                                ?>
								<?php /*?>                                        
                                <tr>
                                    <td class="pad-lft25 pad-topbtm10">VAT</td>
                                    <td align="left" class="pad-topbtm10 pad-lft10">at 17.5%</td>
                                    <td align="right" class="pad-lft15 pad-topbtm10">&nbsp;</td>
                                    <td align="right" class="pad-lft15 pad-topbtm10">&nbsp;</td>
                                    <td align="right" class="pad-topbtm10 pad-lft25">R<?php echo number_format((($total_payble_amt*17.5)/100), 2);?></td>
                                    <td align="right" class="pad-topbtm10">&nbsp;</td>
                                </tr>
								<?php */?>										
                                <tr>
                                    <td colspan="3" class="pad-lft25 pad-topbtm10"><div id="txtPromotionalCodeErrorId" class="pdError1"></div></td>
                                    <td align="left" colspan="3" class="pad-topbtm10">
                                        <div id="txtBasketTotalAmtId" class="pad-lft25">
                                            <?php
                                            if($applypromo == true && $total_discount > 0) {
                                                echo "<input type=\"hidden\" name=\"txtPromoApply\" id=\"txtPromoApplyId\" value=\"1\" />";
                                                echo "<span class=\"gray18Arial\">Total :</span><span class=\"gray18Arial\"> $".number_format($total_payble_amt, 2)."</span><br /><span class=\"pink12arial\"><strong>This price includes a $".number_format($total_discount, 2)." discount</strong></span>";
                                            } else {
                                                echo "<input type=\"hidden\" name=\"txtPromoApply\" id=\"txtPromoApplyId\" value=\"0\" />";
                                                echo "<span class=\"gray18Arial\">Total :</span><span class=\"gray18Arial\"> $".number_format($total_payble_amt, 2)."</span>";
                                            }
                                        ?>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div id="cart-item-delete-pop" style="display:none; position:absolute; background:transparent; left:300px; top:500px;">
                                <div style="position:relative; z-index:999;left:0px;width:250px;height:170px;">
                                    <table width="230" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td align="right"><img src="<?php echo SITE_IMAGES;?>poplefttop.png" alt="ANP" height="10" width="10" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo SITE_IMAGES;?>poplefttop.png', sizingMethod='scale');" /></td>
                                            <td class="topp"></td>
                                            <td><img src="<?php echo SITE_IMAGES;?>poprighttop1.png" alt="ANP"  height="10" width="15" style="filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo SITE_IMAGES;?>poprighttop1.png', sizingMethod='scale');"/></td>
                                        </tr>
                                        <tr>
                                            <td class="leftp"></td>
                                            <td width="220" align="left" valign="top" bgcolor="#FFFFFF" style="padding:12px;"> 
                                                <table width="220" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td align="left" valign="top" class="head"><span class="pink14arial">Are you sure?</span></td>
                                                        <td width="15" align="right" valign="top"><a href="javascript:closeWindow();void(0);" ><img src="<?php echo SITE_IMAGES;?>pop-up-cross.gif" alt="Close" title="Close" border="0" /></a></td>
                                                    </tr>
                                                    <tr>
                                                        <td  align="left" valign="top" class="PopTxt">
                                                            <table width="98%" border="0" cellpadding="0" cellspacing="0">
                                                                <tr>
                                                                    <td class="pad-rgt10 pad-top5"><strong>You will be able to add this item again ... but it won't be easy!</strong></td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="pad-top10">
                                                                        <div class="FloatLft"><a href="javascript:closeWindow();void(0);" ><img src="<?php echo SITE_IMAGES;?>cancel-admin.png" alt="Keep it" /></a></div>
                                                                        <div class="FloatLft pad-lft5"><a href="javascript:delBasketItem();" class="button-blue">Delete</a></div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td  align="left" valign="top" class="PopTxt">&nbsp;</td>
                                                    </tr>
                                                </table>                               
                                            </td>
                                            <td class="rightp" width="15"></td>
                                        </tr>
                                        <tr>
                                            <td align="right"><img src="<?php echo SITE_IMAGES;?>popleftbtm.png" alt="ANP" /></td>
                                            <td width="270" class="bottomp"></td>
                                            <td align="left"><img src="<?php echo SITE_IMAGES;?>poprightbtm1.png" alt="ANP"/></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr><td valign="top">&nbsp;</td></tr>
                    <!-- Promo code script: started here -->
                    <tr>
                        <td valign="top">
                            <div class="gradientBox690thin">
                                <div class="top">
                                    <div class="btm">
                                        <div class="content" style="padding:5px 5px 5px 10px;">
                                            <table width="100%" border="0" cellpadding="1" cellspacing="0">
                                                <tr>
                                                    <td align="left" valign="middle"><span class="pink14arial"><?php echo tranText('do_you_have_a_promo_code'); ?></span></td>
                                                    <td align="left" valign="middle"><input name="txtPromotionalCode" id="txtPromotionalCodeId" type="text" class="Textfield280" onclick="return bnkPromotionalCode();" onblur="restorePromotionalCode();chkPromotionalCode();" value="<?php if(isset($_POST['txtPromotionalCode']) && $_POST['txtPromotionalCode'] !="") { echo $_POST['txtPromotionalCode'];} else { echo "Enter promo code here";} ?>" /></td>
                                                    <td align="right" valign="middle"><a href="javascript:void(0);" onclick="return calculatePromoDiscount();" style="text-decoration:none;" class="button-grey" >Calculate discuount price</a></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr><td valign="top">&nbsp;</td></tr>
                    <!-- Promo code script: End here -->
                    <tr>
                        <td valign="top" align="right">
                        <?php echo tranText('by_clicking_checkout_you_agree_to_the'); ?> <a href="javascript:popcontact('terms.html')" class="blue-link"><?php echo tranText('terms_and_conditions'); ?></a>
                        </td>
                    </tr>
                    <tr>
                        <td valign="top" class="pad-top15">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td valign="top" align="left"><img src="<?php echo SITE_IMAGES;?>paymentcard.gif" alt="Payment" width="253" /></td>
                                    <td width="115px" align="right">
                                        <?php echo $hiddenHTML; ?>
                                        <a href="javascript:void(0);" onclick="return checkout();" style="text-decoration:none;" class="button-blue">Checkout</a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                </form>
            <!-- Main cart section: start here -->
        </td>
    </tr>
    <tr><td class="pad-top5">&nbsp;</td></tr>
    <?php
	/*
	if(isset($_GET['pid']) && $_GET['pid'] !="") {
		if($propertyObj->fun_checkPropertyProductPayments("6", $_GET['pid']) == false) {
			?>
			<tr>
				<td align="left" valign="top" style="border:#CCCCCC thin solid; padding:5px;">
					<h3>Fee Ad</h3>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="font12">
                        <tr>
                            <td valign="top" class="pad-top15">
                                <strong>Activation by Backlink</strong><br /><br />
                                To ensure that your listing can be unlocked, you must insert a link from <?php echo SITE_URL;?> to your website. 
                                <a href="javascript:void(0);" onclick="MM_openWindow('property-backlink-pop-up.php?pid=<?php echo $_GET['pid'];?>', 'childwindow', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=700,height=500')" class="blue-link" style="text-decoration:none;">Here</a> you will find the backlink to insert on your website.<br /><br />
                            </td>
                        </tr>
                        <tr>
                            <td align="right" valign="buttom" class="pad-top5">
                                <span class="pdError1" id="showErrorValidStatus" style="padding-right:10px;">&nbsp;</span><br /><br />
                            	<a href="javascript:void(0);" onclick="submitBacklinkActivation(<?php echo $_GET['pid'];?>);" class="button-red" style="text-decoration:none;">Activation</a>
                            </td>
                        </tr>
                        <tr><td class="pad-btm5">&nbsp;</td></tr>
                    </table>
				</td>
			</tr>
			<?php
		}
	}
	*/
	?>
<?php
} else {
?>
    <tr><td valign="top" class="pad-top10"><span class="font16-darkgrey">You currently have no items in your shopping basket ;-(</span></td></tr>
    <tr><td valign="top" class="pad-top10"><a href="<?php echo SITE_URL; ?>owner-home" style="text-decoration:none;" class="button-blue">Back to homepage</a></td></tr>

<?php
}
?>    
</table>