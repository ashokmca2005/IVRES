<?php
class CreateImage{
	
	function createResizedImage($src_path, $dest_path, $max_width, $max_height) {
		if($max_width < 1 && $max_height < 1) {
			return false;
		}
	
		$size		= getimagesize($src_path);
		$width		= $size[0];
		$height		= $size[1];
	
		$x_ratio	= $max_width / $width;
		$y_ratio	= $max_height / $height;
	
		if (($height <= $max_height) && ($width <= $max_width)){
			$tn_height = $height;
			$tn_width = $width;
		}elseif (($x_ratio * $height) < $max_height){
			$tn_height = ceil($x_ratio * $height);
			$tn_width = $max_width;
		}
		else{
			$tn_width	= ceil($y_ratio * $width);
			$tn_height	= $max_height;
		}
	
		$system			= explode(".",$src_path);
		$ext			= array_pop($system);
	
		$system			= explode(".",$src_path);
		$ext			= array_pop($system);
	
		if ($ext == 'jpeg' || $ext == 'jpg') { $src = imagecreatefromjpeg($src_path);}
		if ($ext == 'gif') { $src = imagecreatefromgif($src_path);}
		if ($ext == 'png') { $src = imagecreatefrompng($src_path);}
	
		$dst = imagecreatetruecolor($tn_width,$tn_height);
		imagecopyresized($dst, $src, 0, 0, 0, 0, $tn_width, $tn_height, $width, $height);
		header('Content-type: image/jpeg');
		imagejpeg($dst,$dest_path,90); //100 for quality (range  (0-100)
		imagedestroy($src);
		imagedestroy($dst);
	}
}	
?>