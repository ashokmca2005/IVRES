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
				preloadImages: 'visible',
				pager: false,
				//mode: 'fade',
				controls: false,
				onSliderLoad: function() {
				//alert("testing");
				document.getElementById("bx-search-wrap").style.display ="block";
				}
			});
		});
	}(jQuery))
</script>
<link rel="stylesheet" type="text/css" href="<?php echo SITE_CSS_INCLUDES_PATH;?>jquery.bxslider.css">
		<?php
        echo '<div id="bx-wrapper" align="center">';
        echo '<ul class="bxslider">';
        for($i =0; $i < count($bannerList); $i++) {
            $banner_id 			= $bannerList[$i]['banner_id'];
            $banner_img 		= SITE_URL."upload/banners-logos/banners/".$bannerList[$i]['banner_img'];
            $banner_title  		= $bannerList[$i]['banner_title'];
            $banner_desc 		= fun_db_output($bannerList[$i]['banner_desc']);
            $banner_link 		= $bannerList[$i]['banner_link'];
            echo '<li>';
            echo '<a href="'.$banner_link.'" style="text-decoration:none;"><img src="'.$banner_img.'" title="'.$banner_title.'" alt="'.$banner_title.'" style="margin:0px auto;" border="0" ></a>';
            //echo '<div class="slider-description">';
            //echo '<div class="description-wrapper">';
            //echo '<p align="left"><a href="'.$banner_link.'" style="font-family:Arial, Helvetica, sans-serif;font-size:16px;font-style:italic;color:#194166;text-decoration:none; line-height:20px; padding:15px 30px 15px 10px; background-image:url(images/orange-arrow-big.png);background-position:right;background-repeat:no-repeat;">'.$banner_title.'</a></p>';
			//echo '<h4>'.$banner_title.'</h4>';
			//echo '<p>'.$banner_desc.'</p>';
            //echo '</div>';
            //echo '</div>';
            echo '</li>';
        }
        echo '</ul>';
		?>
            <div id="bx-search">
				<?php require_once(SITE_INCLUDES_PATH.'holidayhomesearch.php'); ?>
            </div>
		<?php
        echo '</div>';
        ?>
<?php
}
?>
