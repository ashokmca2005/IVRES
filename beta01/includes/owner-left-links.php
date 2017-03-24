<style type="text/css">
.owner-left-nav {
	font-family:Arial, Helvetica, sans-serif;
	border-bottom:1px dashed #44afe1;
	padding-bottom:10px;
	line-height: 35px;
	font-size: 12px;
	margin-left:10px;
	margin-top:5px;
	float:left;
}

.owner-left-nav ul {
	list-style-type: none;
	margin-left:0px;
}

.owner-left-nav ul li {
	display:list-item;
	width:190px;
}

.owner-left-nav ul li a {
	padding-left:35px;
	text-decoration: none;
	color: #0085c6;
	padding-top:7px;
	padding-bottom:7px;
	font-weight:bold;
}

.owner-left-nav ul li a:hover {
	text-decoration: underline;
}

.owner-left-nav ul li a.myhomepage {
	background: url(images/icon-1.jpg) no-repeat left;
}

.owner-left-nav ul li a.myproperties {
	background: url(images/icon-2.jpg) no-repeat left;
}

.owner-left-nav ul li a.addnewproperty {
	background: url(images/icon-3.jpg) no-repeat left;
}

.owner-left-nav ul li a.myenquiries {
	background: url(images/icon-4.jpg) no-repeat left;
}

.owner-left-nav ul li a.mybookings {
	background: url(images/icon-4.jpg) no-repeat left;
}

.owner-left-nav ul li a.addlatedeal {
	background: url(images/icon-5.jpg) no-repeat left;
}

.owner-left-nav ul li a.latedeals {
	background: url(images/icon-6.jpg) no-repeat left;
}
.owner-left-nav ul li a.featuredproperty {
	background: url(images/icon-7.jpg) no-repeat left;
}
.owner-left-nav ul li a.myprofilesettings {
	background: url(images/icon-8.jpg) no-repeat left;
}
.owner-left-nav ul li a.tellyourfriends {
	background: url(images/icon-9.jpg) no-repeat left;
}
.owner-left-nav ul li a.ownercomments {
	background: url(images/icon-10.jpg) no-repeat left;
}
.owner-left-nav ul li a.helpfaqs {
	background: url(images/icon-11.jpg) no-repeat left;
}
.owner-left-nav ul li a.contactus {
	background: url(images/icon-12.jpg) no-repeat left;
}
.owner-left-nav ul li a.myshoppingcart {
	background: url(images/icon-13.jpg) no-repeat left;
}

</style>
<div>
<div class="listing">
    <p class="font14-darkgrey" align="left"><?php echo tranText('hi'); ?> <?php echo ucwords($users_first_name);?></p>
    <p class="blue12normal" align="left">Owner ID: <?php echo fill_zero_left($user_id, "0", (6-strlen($user_id))); ?></p>
</div>
<div class="owner-left-nav">
    <ul>
        <li><a href="<?php echo SITE_URL;?>owner-home" class="myhomepage"><?php echo tranText('my_homepage'); ?></a></li>
        <li><a href="<?php echo SITE_URL;?>owner-my-properties" class="myproperties"><?php echo tranText('my_properties'); ?><span>(<?php if(isset($total_properties) && $total_properties > 1) { echo $total_properties; } else { echo $total_properties; }?>)</span></a></li>
		<?php
        $ownerPackage 	= $propertyObj->fun_checkOwnerPackageCredit($user_id);
        if($ownerPackage == false) {
		?>
        <li><a href="<?php echo SITE_URL;?>list-your-property" class="addnewproperty"><?php echo tranText('add_new_property'); ?></a></li>
        <?php 
		} else {
		?>
        <li><a href="<?php echo SITE_URL;?>add-a-property" class="addnewproperty"><?php echo tranText('add_new_property'); ?></a></li>
        <?php 
		}
		?>
    </ul>
</div>
<div class="owner-left-nav">
    <ul>
        <li><a href="<?php echo SITE_URL;?>owner-enquiries" class="myenquiries"><?php echo tranText('my_enquiries'); ?></a></li>
		<?php /*?>
        <li><a href="<?php echo SITE_URL;?>owner-propertybookings" class="mybookings"><?php echo tranText('my_bookings'); ?></a></li>
		<?php */?>
        <li><a href="<?php echo SITE_URL;?>owner-late-deals.php" class="addlatedeal"><?php echo tranText('add_a_late_deal'); ?></a></li>
        <?php
        if(count($propertyObj->fun_getOwnerPropertyDealsShowArr($user_id)) > 0) {
        ?>
        <li><a href="<?php echo SITE_URL;?>owner-late-deals.php?sec=ove" class="latedeals"><?php echo tranText('late_deals'); ?><span>(<?php echo count($propertyObj->fun_getOwnerPropertyDealsShowArr($user_id));?>)</span></a></li>
        <?php
        }
        ?>
        <li><a href="<?php echo SITE_URL;?>owner-featured-properties" class="featuredproperty"><?php echo tranText('featured_property'); ?><span>(<?php echo $propertyObj->fun_countOwnerHotProperty($user_id); ?>)</span></a></li>
        <li><a href="<?php echo SITE_URL;?>owner-profile-settings" class="myprofilesettings"><?php echo tranText('my_profile_settings'); ?></a></li>
    </ul>
</div>
<div class="owner-left-nav">
    <ul>
        <li><a href="<?php echo SITE_URL;?>owner-tell-your-friends" class="tellyourfriends"><?php echo tranText('tell_your_friends'); ?></a></li>
        <li><a href="<?php echo SITE_URL;?>owner-testimonials" class="ownercomments"><?php echo tranText('owner_comments'); ?></a></li>
        <li><a href="<?php echo SITE_URL;?>owner-help" class="helpfaqs"><?php echo tranText('help_faqs'); ?></a></li>
        <li><a href="<?php echo SITE_URL;?>owner-contact-us" class="contactus"><?php echo tranText('contact_us'); ?></a></li>
    </ul>
</div>
<div class="owner-left-nav">
    <ul>
        <li><a href="<?php echo SITE_URL;?>owner-shopping-cart" class="myshoppingcart"><?php echo tranText('shopping_cart'); ?>&nbsp;<br /><span class="pad-lft30"><?php if(isset($owner_cart_items) && ($owner_cart_items > 1)) {echo "(".$owner_cart_items." items: ".$owner_cart_amt.")"; } else if(isset($owner_cart_items) && ($owner_cart_items == 1)) {echo "(".$owner_cart_items." item: ".$owner_cart_amt.")";} else {echo "(0 item)";} ?></span></a></li>
    </ul>
</div>
<div style="clear:both;">&nbsp;</div>
</div>

