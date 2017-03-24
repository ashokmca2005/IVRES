<?php	
	require_once("includes/owner-top.php");
?>
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