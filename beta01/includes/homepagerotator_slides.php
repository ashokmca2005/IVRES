<?php
$bannerList 	= $bannerObj->fun_getBannerArr4Home();
if(count($bannerList) > 0) {
?>
<script language="javascript" type="text/javascript">
// Speed of the automatic slideshow
var slideshowSpeed = 6000;

// Variable to store the images we need to set as background
// which also includes some text and url's.

<?php	
$strBanHTML = 'var photos = [ {';
for($i =0; $i < count($bannerList); $i++) {
	$banner_id 			= $bannerList[$i]['banner_id'];
	$banner_img 		= SITE_URL."upload/banners-logos/banners/".$bannerList[$i]['banner_img'];
	$banner_title  		= $bannerList[$i]['banner_title'];
	$banner_desc 		= fun_db_output($bannerList[$i]['banner_desc']);
	$banner_link 		= $bannerList[$i]['banner_link'];

	$strBanHTML .= '"title" : "'.$banner_title.'",';
	$strBanHTML .= '"image" : "'.$banner_img.'",';
	$strBanHTML .= '"url" : "'.$banner_link.'"';
	if($i < (count($bannerList)-1))
	$strBanHTML .= '}, {';
	else
	$strBanHTML .= '}';
}
$strBanHTML .= '];';
echo $strBanHTML;
?>

(function($){	
  $(function(){
		
	// Backwards navigation
	$("#back").click(function() {
		stopAnimation();
		navigate("back");
	});
	
	// Forward navigation
	$("#next").click(function() {
		stopAnimation();
		navigate("next");
	});
	
	var interval;
	$("#control").toggle(function(){
		stopAnimation();
	}, function() {
		// Change the background image to "pause"
		$(this).css({ "background-image" : "url(images/btn_pause.png)" });
		
		// Show the next image
		navigate("next");
		
		// Start playing the animation
		interval = setInterval(function() {
			navigate("next");
		}, slideshowSpeed);
	});
	
	
	var activeContainer = 1;	
	var currentImg = 0;
	var animating = false;
	var navigate = function(direction) {
		// Check if no animation is running. If it is, prevent the action
		if(animating) {
			return;
		}
		
		// Check which current image we need to show
		if(direction == "next") {
			currentImg++;
			if(currentImg == photos.length + 1) {
				currentImg = 1;
			}
		} else {
			currentImg--;
			if(currentImg == 0) {
				currentImg = photos.length;
			}
		}
		
		// Check which container we need to use
		var currentContainer = activeContainer;
		if(activeContainer == 1) {
			activeContainer = 2;
		} else {
			activeContainer = 1;
		}
		
		showImage(photos[currentImg - 1], currentContainer, activeContainer);
		
	};
	
	var currentZindex = -1;
	var showImage = function(photoObject, currentContainer, activeContainer) {
		animating = true;
		
		// Make sure the new container is always on the background
		currentZindex--;
		
		// Set the background image of the new active container
		$("#headerimg" + activeContainer).css({
			"background-image" : "url(" + photoObject.image + ")",
			"display" : "block",
			"z-index" : currentZindex
		});
		
		// Hide the header text
		$("#headertxt").css({"display" : "none"});
		
		// Set the new header text
		$("#pictureduri")
			.attr("href", photoObject.url)
			.html(photoObject.title);
		
		// Fade out the current container
		// and display the header text when animation is complete
		$("#headerimg" + currentContainer).fadeOut(function() {
			setTimeout(function() {
				$("#headertxt").css({"display" : "block"});
				animating = false;
			}, 500);
		});
	};
	
	var stopAnimation = function() {
		// Change the background image to "play"
		$("#control").css({ "background-image" : "url(images/btn_play.png)" });
		
		// Clear the interval
		clearInterval(interval);
	};
	
	// We should statically set the first image
	navigate("next");
	
	// Start playing the animation
	interval = setInterval(function() {
		navigate("next");
	}, slideshowSpeed);
	
  });	
}(jQuery))


</script>
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo SITE_CSS_INCLUDES_PATH;?>slider.css">
<div id="slider" style="overflow:hidden; height:390px;">
	<!-- jQuery handles to place the header background images -->
	<div id="headerimgs">
		<div id="headerimg1" class="headerimg"></div>
		<div id="headerimg2" class="headerimg"></div>
	</div>
	<!-- Search -->
    <div id="search">
		<script language="javascript" type="text/javascript">
            function validateFrmHomeSearch(){
                var str = document.getElementById('SearchLocFld2').value;
                if(str == "Where are you going?" || str == ""){
                    return false;
                } else {
                    doSearch(str);
                    return false;
                }
            }
        
            function doSearch(pid) { 
                req.open('get', '<?php echo SITE_URL;?>get-property-url-ajax.php?pid=' + pid); 
                req.onreadystatechange = handleSearch; 
                req.send(null); 
            } 
        
            function handleSearch(){
                if(req.readyState == 4) { 
                    var response = req.responseText; 
                    xmlDoc = req.responseXML;
                    var root = xmlDoc.getElementsByTagName('properties')[0];
                    if(root != null) {
                        var items = root.getElementsByTagName("property");
                        var item = items[0];
                        var propertyurl = item.getElementsByTagName("link")[0].firstChild.nodeValue;
                        if(propertyurl == "no url."){
                            document.getElementById("frmLocSearch").submit();
                        } else {
                            window.location = propertyurl;
                        }
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            }
        </script>
        <script type="text/javascript">
            $(document).ready(function(){
                $( "#SearchLocFld2" ).autocomplete({
                    source: "<?php echo SITE_URL;?>autocompletelocationsearch.php",
                    minLength: 2
                });
            });
        </script>
        <form action="<?php echo SITE_URL; ?>accommodation" method="post" name="frmLocSearch" id="frmLocSearch" onsubmit="return validateFrmHomeSearch();">
            <input type="hidden" name="searchKey" value="<?php echo md5(LOCATIONSEARCH)?>" />
            <span class="font20">Find Your Perfect Holiday Location</span><br />
            <input type="text" name="txtLocSearch" id="SearchLocFld2" placeholder="Where are you going?" class="homeSearch" autocomplete="off" />
            <br />
            <input type="submit" alt="Search" class="button157x32" value="<?php echo tranText('search_now'); ?>" />
        </form>
    </div>
	<!-- Slideshow controls -->
	<div id="headernav-outer">
		<div id="headernav">
			<div id="back" class="btn"></div>
			<div id="control" class="btn"></div>
			<div id="next" class="btn"></div>
		</div>
	</div>
	<!-- jQuery handles for the text displayed on top of the images -->
	<div id="headertxt">
        <a href="#" id="pictureduri" style="font-family:Arial, Helvetica, sans-serif;font-size:16px;font-style:italic;color:#194166;text-decoration:none; line-height:40px; padding:15px 30px 15px 10px; background-image:url(images/orange-arrow-big.png);background-position:right;background-repeat:no-repeat;"></a>
	</div>
</div>
<?php
}
?>
