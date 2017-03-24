<script language="javascript" type="text/javascript">
	function validateFrmLocSearch(){
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
<form action="<?php echo SITE_URL; ?>accommodation" method="post" name="frmLocSearch" id="frmLocSearch" onsubmit="return validateFrmLocSearch();">
<input type="hidden" name="searchKey" value="<?php echo md5(LOCATIONSEARCH)?>" />
<table width="960px" align="center" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="45px" align="left"><img src="<?php echo SITE_IMAGES;?>add-white-icon.jpg" /></td>
        <td width="65px" align="left"><h5>Search:</h5></td>
        <td><input type="text" size="40" name="txtLocSearch" id="SearchLocFld2" placeholder="Where are you going?" class="topAdvSearch" autocomplete="off" /></td>
        <td width="45px" align="left"><input type="submit" alt="Search" class="button32x32" value="<?php echo tranText('go'); ?>" /></td>
        <td width="115px" align="left" class="nav1 font12"><a href="<?php echo SITE_URL; ?>accommodation"><?php echo tranText('advanced_search'); ?></a></td>
		<?php
        if((strpos($_SERVER['HTTP_REFERER'], "owner-property.php?sec=") == true) || (strpos($_SERVER['HTTP_REFERER'], "admin-pending-approval.php?sec=") == true) || (isset($_SESSION['property_preview_close_url']) && $_SESSION['property_preview_close_url'] != "")) {
        ?>
            <td width="130px" align="center" class="nav7"><a href="javascript:void(0);">Back to results</a></td>
            <td width="33px" align="center"><img src="<?php echo SITE_IMAGES;?>icon-15.jpg" /></td>
            <td width="140px" align="center" class="nav7"><a href="javascript:void(0);">Add to shortlist</a></td>
            <td width="33px" align="center"><img src="<?php echo SITE_IMAGES;?>icon-16.jpg" /></td>
            <td width="45px" align="center" class="nav7"><a href="javascript:void(0);">Print</a></td>
        <?php
        } else {
        ?>
            <td width="130px" align="center" class="nav7"><a href="#" onClick="history.back();">Back to results</a></td>
            <td width="33px" align="center"><img src="<?php echo SITE_IMAGES;?>icon-15.jpg" /></td>
            <td width="140px" align="center" class="nav7">
		<?php
            if(isset($propFavId) && $propFavId !=""){
                echo "<a href=\"javascript:addFavourite('".$property_id."', '".$user_id."')\" id=\"showAddFavouriteLinkId\" style=\"display:none;\">Add to shortlist</a>";
                echo "<a href=\"javascript:removeFavourite('".$property_id."', '".$user_id."')\" id=\"showRemoveFavouriteLinkId\" style=\"display:block;\">Remove favourite</a>";
            } else {
                if(isset($user_id) && $user_id != ""){
                    echo "<a href=\"javascript:addFavourite('".$property_id."', '".$user_id."')\"  id=\"showAddFavouriteLinkId\" style=\"display:block;\">Add to shortlist</a>";
                    echo "<a href=\"javascript:removeFavourite('".$property_id."', '".$user_id."')\" id=\"showRemoveFavouriteLinkId\" style=\"display:none;\">Remove favourite</a>";
                } else {
                    echo "<a href=\"".SITE_URL."owner-login\">Add to shortlist</a>";
                }
            }
        ?>
        </td>
        <td width="33px" align="center"><img src="<?php echo SITE_IMAGES;?>icon-16.jpg" /></td>
        <td width="45px" align="center" class="nav7"><a href="javascript:printme();">Print</a></td>
		<?php
        }
        ?>
        <td width="33px" align="center"><img src="<?php echo SITE_IMAGES;?>icon-17.jpg" /></td>
        <td align="right" class="nav7"><a href="#showSectionTop" onclick="return showSection(2);">Book now</a></td>
    </tr>
</table>
</form>
