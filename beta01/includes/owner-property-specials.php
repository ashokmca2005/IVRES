<?php 
	if(isset($_REQUEST['spe']) && $_REQUEST['spe'] != ''){
		switch($_REQUEST['spe']){
			case 'main':
				$page_name = 'special-main.php';
			break;
			case 'cre';
				$page_name = 'create-special-deals.php';
			break;			
			case 'pre';
				$page_name = 'special-deals-preview.php';
			break;
			case 'tha';
				$page_name = 'special-thanks.php';
			break;
			case 'ove';
				$page_name = 'special-deals-overview.php';
			break;
		}
	}else{
		$page_name = 'special-main.php';
	}
?>
<!--Specials Content Starts Here -->

<div class="width690">
	
	<?php include_once("includes/".$page_name);?>
	
<!--Specials Content Ends Here -->
</div>