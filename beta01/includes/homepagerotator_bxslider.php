<?php
$bannerList 	= $bannerObj->fun_getBannerArr4Home();
if(count($bannerList) > 0) {
?>
<script language="javascript" type="text/javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>jquery.bxslider.min.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>jquery.easing.1.3.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo SITE_JS_INCLUDES_PATH;?>jquery.fitvids.js"></script>
<script type="text/javascript">
	(function($){	
		$(function(){
			$('.bxslider').bxSlider({
				auto: true,
				//adaptiveHeight: true,
				//autoControls: true,
				//captions: true,
				pager: false,
				controls: false,
				mode: 'fade'
			});
		});
	}(jQuery))
</script>
<link rel="stylesheet" type="text/css" href="<?php echo SITE_CSS_INCLUDES_PATH;?>jquery.bxslider.css">
		<?php
        $strBanHTML = '';
        $strBanHTML .= '<div id="bx-wrapper">';
        $strBanHTML .= '<ul class="bxslider">';
        for($i =0; $i < count($bannerList); $i++) {
            $banner_id 			= $bannerList[$i]['banner_id'];
            $banner_img 		= SITE_URL."upload/banners-logos/banners/".$bannerList[$i]['banner_img'];
            $banner_title  		= $bannerList[$i]['banner_title'];
            $banner_desc 		= fun_db_output($bannerList[$i]['banner_desc']);
            $banner_link 		= $bannerList[$i]['banner_link'];
            $strBanHTML .= '<li>';
            $strBanHTML .= '<img src="'.$banner_img.'" title="'.$banner_title.'" alt="'.$banner_title.'" style="margin:0px auto;" border="0" >';
            //$strBanHTML .= '<div class="slider-description">';
            //$strBanHTML .= '<div class="description-wrapper">';
            //$strBanHTML .= '<p align="left"><a href="'.$banner_link.'" style="font-family:Arial, Helvetica, sans-serif;font-size:16px;font-style:italic;color:#194166;text-decoration:none; line-height:20px; padding:15px 30px 15px 10px; background-image:url(images/orange-arrow-big.png);background-position:right;background-repeat:no-repeat;">'.$banner_title.'</a></p>';
			//$strBanHTML .= '<h4>'.$banner_title.'</h4>';
			//$strBanHTML .= '<p>'.$banner_desc.'</p>';
            //$strBanHTML .= '</div>';
            //$strBanHTML .= '</div>';
            $strBanHTML .= '</li>';
        }
        $strBanHTML .= '</ul>';
        $strBanHTML .= '</div>';
        echo $strBanHTML;
        ?>
<?php
}
?>
