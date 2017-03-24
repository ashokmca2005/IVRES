<?php  echo stripslashes($pageInfo['page_discription'])?>
<map name="registeryourproperty" id="registeryourproperty">
    <area shape="rect" coords="40,411,339,463" href="<?php if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] != "") { echo SITE_URL."holiday-register-as-owner";} else { echo "javascript:frmSubmit();void(0);";} ?>" target="_top" />
</map>
