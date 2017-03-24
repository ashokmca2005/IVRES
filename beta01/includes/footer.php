<div class="footer-wrap">
    <div class="node-links">
        <ul>
            <li><strong>Top 5 vacation rentals locations</strong></li>
			<?php $propertyObj->fun_createPropertyPopularDestination4Footer(); ?>
        </ul>
    </div>
    <div class="node-links">
        <ul>
            <li><strong>Vacation rentals let information</strong></li>
			<?php
            if($_SESSION['ses_user_home'] == SITE_URL."owner-home") {
            ?>
                <li><a href="<?php echo SITE_URL;?>add-a-property"><strong>List your property</strong></a></li>
            <?php
            } else if($_SESSION['ses_user_home'] == SITE_URL."home"){
            ?>
                <li><a href="<?php echo SITE_URL; ?>holiday-register-as-owner"><strong>List your property</strong></a></li>
            <?php
            } else {
            ?>
                <li><a href="<?php echo SITE_URL; ?>list-your-property"><strong>List your property</strong></a></li>
            <?php
            }
            ?>
            <li><a href="<?php echo SITE_URL; ?>tell-your-friends"><strong>Tell your friends</strong></a></li>
            <li><a href="<?php echo SITE_URL; ?>resources"><strong>Resources</strong></a></li>
            <li><a href="<?php echo SITE_URL; ?>help"><strong>Frequently Asked Questions</strong></a></li>
			<?php /*?>
            <li><a href="<?php echo SITE_URL; ?>pages/cost-information"><strong>Cos information</strong></a></li>
            <li><a href="<?php echo SITE_URL; ?>pages/payments"><strong>Payments</strong></a></li>
			<?php */?>
        </ul>
    </div>
    <div class="node-links">
        <ul>
            <li><strong>More about rentownersvillas.com</strong></li>
		<?php
		if($_SESSION['ses_user_home'] == SITE_URL."owner-home") {
		?>
            <li><a href="<?php echo SITE_URL; ?>owner-contact-us"><strong><?php echo tranText('contact'); ?></strong></a></li>
            <li><a href="<?php echo SITE_URL; ?>owner-about-us"><strong><?php echo tranText('about_us'); ?></strong></a></li>
            <li><a href="<?php echo SITE_URL; ?>owner-testimonials"><strong><?php echo tranText('testimonials'); ?></strong></a></li>
            <li><a href="<?php echo SITE_URL; ?>show-terms"><strong><?php echo tranText('terms'); ?></strong></a></li>
        <?php
        } else {
		?>
            <li><a href="<?php echo SITE_URL; ?>contact-us"><strong><?php echo tranText('contact'); ?></strong></a></li>
            <li><a href="<?php echo SITE_URL; ?>about-us"><strong><?php echo tranText('about_us'); ?></strong></a></li>
            <li><a href="<?php echo SITE_URL; ?>testimonials"><strong><?php echo tranText('testimonials'); ?></strong></a></li>
            <li><a href="<?php echo SITE_URL; ?>show-terms"><strong><?php echo tranText('terms'); ?></strong></a></li>
        <?php
        }
        ?>
        </ul>
    </div>
</div>
<div class="footer-note">
    <div class="footer-wrap-1">
        <ul>
            <li style="float:left;">&copy; <?php echo date("Y");?> rentownersvillas.com</li>
            <li style="float:right;">Powered by <strong>IDNS Vacation Rental Script</strong></li>
        </ul>
    </div>
</div>
