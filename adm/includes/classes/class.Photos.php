<?php
class Photos{

	function Photos(){//Class Constructor

	}

	function image_resize($file, $p_indw, $p_indh){ 
	
		$imgsize = @getimagesize($file);
		if(!$imgsize){
			return FALSE;
		}
		$p_width      = 0;
		$p_height     = 0;
		
		$p_crt_width  = $imgsize[0];
		$p_crt_height = $imgsize[1];
	
		if ($p_indw <> 0 and $p_indh <> 0){
			//rezise for width/height restrictions
			if ($p_crt_width>$p_crt_height){
					if ($p_crt_width>$p_indw){
					  $p_width = $p_indw;
					  $p_height = intval(($p_crt_height*$p_indw)/$p_crt_width);
					}else{
					   $p_width = $p_crt_width;
					   $p_height = $p_crt_height;
					}
					if ($p_height>$p_indh){
					   $p_width = intval(($p_width*$p_indh)/$p_height);
					   $p_height = $p_indh;
					}
					
			}else{
					if ($p_crt_height>$p_indh){
					  $p_height = $p_indh;
					  $p_width = intval(($p_crt_width*$p_indh)/$p_crt_height);
					}else{
					   $p_width = $p_crt_width;
					   $p_height = $p_crt_height;
					}
					if ($p_width>$p_indw){
					  $p_height = intval(($p_height*$p_indw)/$p_width);
					  $p_width = $p_indw;
					}
			}
		}//end
		
		if ($p_indh <> 0 and $p_indw == 0){
		//resize for height restrictions
			if ($p_crt_height > $p_indh){
				$p_height = $p_indh;
				$p_width = intval(($p_crt_width*$p_indh)/$p_crt_height);
			}else{
				$p_width  = $p_crt_width;
				$p_height = $p_crt_height;
			}
		}
		
		if ($p_indw <> 0 and $p_indh == 0){
		//resize for width restrictions
			if ($p_crt_width > $p_indw){
				$p_width = $p_indw;
				$p_height = intval(($p_crt_height*$p_indw)/$p_crt_width);
			}else{
				$p_width  = $p_crt_width;
				$p_height = $p_crt_height;			
			}
		}
	
		return array("width" => $p_width, "height" => $p_height);
		
	}
	
	function image_getSize($file){ 
		$imgsize = @getimagesize($file);
		if(!$imgsize){
			return FALSE;
		}else{
			return $imgsize;
		}
	}
	
	/**
	* @return string
	* @param $o_file string    Filename of image to make thumbnail of
	* @param $t_file string    Filename to use for thumbnail
	* @desc Takes an image and makes a jpeg thumbnail defaulted to 100px high
	*/
	function image_makeThumbnail($o_file, $t_file, $rez_width = 100, $rez_height = 0) {
		$image_info = getImageSize($o_file) ; // see EXIF for faster way
		switch ($image_info['mime']) {
			case 'image/gif':
				if (imagetypes() & IMG_GIF)  { // not the same as IMAGETYPE
					$o_im = imageCreateFromGIF($o_file) ;
				} else {
					$ermsg = 'GIF images are not supported<br />';
				}
				break;
			case 'image/jpeg':
				if (imagetypes() & IMG_JPG)  {
					$o_im = imageCreateFromJPEG($o_file) ;
				} else {
					$ermsg = 'JPEG images are not supported<br />';
				}
				break;
			case 'image/png':
				if (imagetypes() & IMG_PNG)  {
					$o_im = imageCreateFromPNG($o_file) ;
				} else {
					$ermsg = 'PNG images are not supported<br />';
				}
				break;
			case 'image/wbmp':
				if (imagetypes() & IMG_WBMP)  {
					$o_im = imageCreateFromWBMP($o_file) ;
				} else {
					$ermsg = 'WBMP images are not supported<br />';
				}
				break;
			default:
				$ermsg = $image_info['mime'].' images are not supported<br />';
				break;
		}
		
		if (!isset($ermsg)) {
			$o_wd = imagesx($o_im) ;
			$o_ht = imagesy($o_im) ;
			// thumbnail width = target * original width / original height
			//$t_wd = round($o_wd * $t_ht / $o_ht) ; 
			//$t_wd = round($o_wd * $t_ht / $o_ht) ; 
	
			$target = image_resize($o_file, $rez_width, $rez_height);
			$t_ht = $target["height"];
			$t_wd = $target["width"];
			
			$t_im = imageCreateTrueColor($t_wd, $t_ht);
			
			imageCopyResampled($t_im, $o_im, 0, 0, 0, 0, $t_wd, $t_ht, $o_wd, $o_ht);
			
			imageJPEG($t_im,$t_file);
			
			imageDestroy($o_im);
			imageDestroy($t_im);
		}
		return isset($ermsg)?$ermsg:FALSE;
	}
	
	function image_getSizeForHTML($file){ 
	
		$imgsize = @getimagesize($file);
		if(!$imgsize){
			return FALSE;
		}else{
			return $imgsize[3];
		}
	}
}
?>