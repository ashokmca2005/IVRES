<?php
/********
MODIFY ON 04 Jun, 2008    By Ashok Kumar
CLASS FOR IMAGE UPLOAD,IMAGE CROP,IMAGE RESIZE,SIMPLE UPLOAD
//FOR RESIZE AND CROP THERE SHOULD BE FILE EXISTS IN SOMEWHERE THEN WE USE THAT FILE FOR OPERATION
WE USED DIRECTLY getResizeImage AND getCropImage
*********/
Class Image
{
	var $pathFile;
	var $originalFileName;	
	var $SO;
	var $sizeMaxFileName = 20;
	var $extensionFile;
	var $nameFile;
    var $CurrentBit=0;
   function Image()
	{
	}
	function setPath($pathFile)
	{
		$this->pathFile = $pathFile;
	}

	function setSizeMaxFileName($sizeMaxFileName)
	{
		$this->sizeMaxFileName = $sizeMaxFileName;
	}

	function setOriginalFileName($originalFileName)
	{
		$this->originalFileName = $originalFileName;
	}

	function getOriginalFileName()
	{
		return $this->originalFileName;
	}
	function getNameFile()
	{
		return $this->nameFile;
	}
	function RandomName($nameLength) {
	    $name = "";
	    for ($index = 1; $index <= $nameLength; $index++) 
		{
			 mt_srand((double) microtime() * 1000000);
	         $randomNumber = mt_rand(1, 62);
	         if ($randomNumber < 11)
	              $name .= Chr($randomNumber + 48 - 1); // [ 1,10] => [0,9]
	         else if ($randomNumber < 37)
	              $name .= Chr($randomNumber + 65 - 10); // [11,36] => [A,Z]
	         else
	              $name .= Chr($randomNumber + 97 - 36); // [37,62] => [a,z]
	    }
		$name = $name."_".time();
		$this->formatNameFile();
		$this->formatExtensionFile();
		$this->originalFileName = $this->nameFile."_".$name.".".$this->extensionFile;	    
	}
	function InvalidCaracter($var)
	{
		$a="ÁáÉéÍíÓóÚúÇçÃãÀàÂâÊêÎîÔôÕõÛû& -!@#$%¨&*()_+}=}{[]^~?/:;><,'´`\"\\º";
		$b="AaEeIiOoUuCcAaAaAaEeIiOoOoUue___________________________________";
		$var = strtr($var,$a,$b);
		$var = strtolower($var);
		return $var;
	}
	function formatNameFile()
	{
		$originalFileName = $this->originalFileName;	
		$posDivisionNameExtension = strpos($originalFileName,".");
	    $nameFile  = substr($originalFileName,0,$posDivisionNameExtension);	
		$nameFile  = $this->InvalidCaracter($nameFile);				
		$this->nameFile = $nameFile;
	}
	function formatExtensionFile()
	{
		$originalFileName = $this->originalFileName;
		$invertFile = strrev($originalFileName);
		$posDivisionNameExtension = strpos($invertFile,".");
	    $extensionFile = substr($invertFile,0,$posDivisionNameExtension);
		$extensionFile = strrev($extensionFile);
		$extensionFile = $this->InvalidCaracter($extensionFile);
		$this->extensionFile = $extensionFile;
	}	
	function getExtensionFile()
	{
		return $this->extensionFile;
	}		
	function setNameAndExtension()
	{
		$this->formatNameFile();
		$this->formatExtensionFile();
	}
	function formatOriginalFileName()
	{
		$this->formatNameFile();
		$this->formatExtensionFile();
		$sizeFileName = strlen($this->nameFile);		
		if ($sizeFileName>$this->sizeMaxFileName)
		{ 
	         $this->nameFile = substr($this->nameFile,0,$this->sizeMaxFileName); 
		}
		$this->originalFileName = $this->nameFile. "." .$this->extensionFile;
	}
	function setSO($SO)
	{
		$this->SO = $SO;
	}
	function getDivisionDIR()
	{
		$SO = $this->SO;
		$SO = strtolower($SO);
		switch ($SO)
		{
			case "w":
				$divisionDir = "\\";
				break;
			case "l":
				$divisionDir = "/";
				break;
			case "u":
				$divisionDir = "/";
				break;
		}

		return $divisionDir;
	}
    //FILE IS A FILENAME WITHOUT FULLPATH
	function isFileExist($file)
	{
		$x="";
		$file = $this->originalFileName;
		$openDir = @opendir($this->pathFile);
		while (($filesServer=@readdir($openDir))!=false)
		{
			if (is_file($this->pathFile.$this->getDivisionDIR().$filesServer)):
				if ($filesServer==$file)
				{
					$x = true;
					break;
				}
				else
				{
					$x = false;
				}
			else:
				$x = false;
			endif;
		
		}
		@closedir($openDir);
		return $x;
	}
    //FILE IS A FILENAME WITHOUT FULLPATH i.e. $_FILES['name']
    function uploadCopyFile($file,$final_name)
	{
		$x = false;
        if($final_name!="")
            $path_upload_main = $this->pathFile.$this->getDivisionDIR().$final_name;
        else
    		$path_upload_main = $this->pathFile.$this->getDivisionDIR().$this->originalFileName;
		$openDir = @opendir($this->pathFile);
		if (@copy($file,$path_upload_main)):
			if (@is_uploaded_file($file))
			{
                   $x = true;
			}
		endif;
		@closedir($openDir);
		return  $x;
	}
     //FILE IS A FILENAME WITHOUT FULLPATH i.e.  $_FILES['tmp_name']
	function uploadMoveFile($file,$final_name="")
	{
		$x = false;
        if($final_name!="")
            $pathUpload = $this->pathFile.$this->getDivisionDIR().$final_name;
        else
		    $pathUpload = $this->pathFile.$this->getDivisionDIR().$this->originalFileName;
 		if (@move_uploaded_file($file,$pathUpload)):
			if (@is_uploaded_file($file))
			{
				$x = true;
			}
		endif;
		return $x;
	}
/******FOR COYING IMAGE ONE TO OTHER PLACE //RETURN TRUE/FASLE
    image_name_field= IS A FILENAME WITHOUT FULLPATH i.e.$_FILES['name']
    folder_path =IS A FOLDER PATH WITHOUT FILENAME
    final_name= FULLPATH WITH FILENAME IN THAT UPLOADED FILE IS STORED
  ****/
function upload_copyimage($image_name_field, $folder_path,$final_name="")
	   {
		$this->setSizeMaxFileName(25);
		$this->setSO("l");        //FOR WINDOWS USER w ELSE l
		$this->setPath($folder_path);
		$this->setOriginalFileName($image_name_field);
		$this->formatOriginalFileName();
		$this->setNameAndExtension();

		$nameFileFull  = $this->getOriginalFileName();
         if (($this->isFileExist($image_name_field))):
					$upload_result=false;
         else:
		    	if (!($this->uploadCopyFile($image_name_field,$final_name))):
							$upload_result=true;
				else:
							$upload_result=true;
					endif;
			endif;
		
		return $upload_result;
		}
 /******FOR MOVING IMAGE ONE TO OTHER PLACE //RETURN TRUE/FASLE
    image_name_field= IS A FILENAME WITHOUT FULLPATH i.e.$_FILES['tmp_name']
    folder_path =IS A FOLDER PATH WITHOUT FILENAME
    final_name= FULLPATH WITH FILENAME IN WHICH UPLOADED FILE IS STORED
  ****/
function upload_moveimage($image_temp_name, $folder_path,$final_name="")
	   {
		$this->setSizeMaxFileName(25);
		$this->setSO("l");//FOR WINDOWS USER w ELSE l
		$this->setPath($folder_path);
		$this->setOriginalFileName($image_temp_name);
		$this->formatOriginalFileName();
		$this->setNameAndExtension();
		$nameFileFull  = $this->getOriginalFileName();
         if (($this->isFileExist($image_temp_name))):
					$upload_result=false;
         else:
		    	if (!($this->uploadMoveFile($image_temp_name,$final_name))):
							$upload_result=true;
				else:
							$upload_result=true;
					endif;
			endif;

		return $upload_result;
		}
/****USED BY getCrop
    RETURN CROPING IMAGE FOR GIVVEN WIDTH AND HEIGHT
    TYPE =IS SIDE OF CROP HEIGHT OR WIDTH
****/
function crop_image($old_image,$new_image,$width,$height,$type="")
{
	$dimensions = getimagesize($old_image);
    $old_x=$dimensions[0];
	$old_y=$dimensions[1];
	
	if ($old_x < $width)
	{
		$width=$old_x;
	}
	if ($old_y < $height) 
	{
		$height=$old_y;
	}
	$canvas = imagecreatetruecolor($width,$height);
	$system= substr(strrchr($old_image, "."), 1 );
	if (preg_match('/png/',$system))
		{
			$piece = imagecreatefrompng($old_image);
		}
	else if (preg_match('/gif/',$system))
		{
			$piece = imagecreatefromgif($old_image);
		}
	else $piece = imagecreatefromjpeg($old_image);

		$newwidth = $dimensions[0] ;/// 2;
		$newheight = $dimensions[1];// / 2;
	if ($newwidth>$width)
	{
		$cropLeft = ($newwidth/2) - ($width/2);
		$newwidth=$width;
	}
	else 	$cropLeft = 0;
	if ($newheight > $height)
	{
		$cropHeight = ($newheight/2) - ($height/2);
		$newheight=$height;
	}
	else 	$cropHeight = 0;//($newheight);

   if($system=="gif")
   {
  	$transparent = imagecolorallocate($canvas, "255", "255", "255");
  	imagefill($canvas, 0, 0, $transparent);
   }
	// Generate the cropped image
	@imagecopyresized($canvas, $piece, 0,0, $cropLeft, $cropHeight,$newwidth, $newheight, $width, $height);
    if (preg_match('/png/',$system))
		{
			imagepng($canvas,$new_image);
		}
	else if (preg_match('/gif/',$system))
		{
			imagegif($canvas,$new_image,90);
		}
	else imagejpeg($canvas,$new_image,90);
    @imagedestroy($canvas);
	@imagedestroy($piece);
	
}
//USED BY getCrop
//RETURN RESIZED IMAGE FOR GIVEN WIDTH AND HEIGHT
function resize_crop($name,$filename,$new_w,$new_h)
{
    $system= substr(strrchr($name, "."), 1 );
	if (preg_match('/jpg|jpeg/',$system))
		{
			$src_img=imagecreatefromjpeg($name);
		}
	else if (preg_match('/png/',$system))
		{
			$src_img=imagecreatefrompng($name);
		}
	else if (preg_match('/gif/',$system))
		{
			$src_img=imagecreatefromgif($name);
		}
	else $src_img=imagecreatefromjpeg($name);	

//echo $src_img;

	$old_x=imagesx($src_img);
	$old_y=imagesy($src_img);
	if ($old_x > $old_y)
	{
		$thumb_w=$old_x*($new_h/$old_y);
		$thumb_h=$new_h;
		if($thumb_w<$new_w)
			{
				$diff=($new_w-$thumb_w);
				$thumb_w=$new_w;
				$thumb_h=($new_h+$diff);
    		}
		}
	if ($old_x < $old_y)
	{
		$thumb_w=$new_w;
		$thumb_h=$old_y*($new_w/$old_x);
		if($thumb_h<$new_h)
			{
				$diff=($new_h-$thumb_h);
				$thumb_h=$new_h;
				$thumb_w=($new_w+$diff);
			}
	}

	if ($old_x == $old_y)
	{
		if($new_w>$new_h)
		{
			$thumb_w=$new_w;
			$thumb_h=$new_w;
		}
		else if($new_w<$new_h)
		{
			$thumb_w=$new_h;
			$thumb_h=$new_h;
		}
		else
		{
		$thumb_w=$new_w;
		$thumb_h=$new_h;
		}
	}

	$dst_img= imagecreatetruecolor($thumb_w,$thumb_h);
     if($system=="gif")
     {
    	$transparent = imagecolorallocate($dst_img, "255", "255", "255");
    	imagefill($dst_img, 0, 0, $transparent);
     }
	imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y);
	if (preg_match("/png/",$system))
		{
			imagepng($dst_img,$filename);
		}
	else if (preg_match('/gif/',$system))
		{
			imagegif($dst_img,$filename); 
		}
	else 
		{
			imagejpeg($dst_img,$filename);
		}
	imagedestroy($dst_img);
	imagedestroy($src_img);
}
   //USED BY   getResize
function resizenew($name,$filename,$new_w,$new_h)
{
	$system= substr(strrchr($name, "."), 1 );
	if (preg_match('/jpg|jpeg/',$system))
		{
			$src_img=imagecreatefromjpeg($name);
		}
	else if (preg_match('/png/',$system))
		{
			$src_img=imagecreatefrompng($name);
		}
	else if (preg_match('/gif/',$system))
		{
			$src_img=imagecreatefromgif($name);
		}
	else $src_img=imagecreatefromjpeg($name);

	$old_x=@imagesx($src_img);//200
	$old_y=@imagesy($src_img);//200
	if ($old_x > $old_y)
	{//lowest value assigned to final
			if($new_w>$new_h)
			{
				$thumb_h=$new_h;
				$thumb_w=$old_x*($new_h/$old_y);
                if($thumb_w>$new_w)
				{
					$thumb_w=$new_w;
					$thumb_h=($new_w*$old_y)/$old_x;
				}
			}
			else if($new_w<$new_h)
			{
				$thumb_w=$new_w;
				$thumb_h=($new_w*$old_y)/$old_x;
               if($thumb_h>$new_h)
				{
					$thumb_h=$new_h;
					$thumb_w=$old_x*($new_h/$old_y);
				}
			}
			else
			{
				$thumb_w=$new_w;
				$thumb_h=($new_w*$old_y)/$old_x;
                if($thumb_h>$new_h)
				{
					$thumb_h=$new_h;
					$thumb_w=$old_x*($new_h/$old_y);
				}
			}
		}
	if ($old_x < $old_y) 
	{ //lowest value assigned to final
			if($new_w>$new_h)
			{
				$thumb_h=$new_h;
				$thumb_w=$old_x*($new_h/$old_y);
                if($thumb_w>$new_w)
				{
					$thumb_w=$new_w;
					$thumb_h=($new_w*$old_y)/$old_x;
				}
			}
			else if($new_w<$new_h)
			{
				$thumb_w=$new_w;
				$thumb_h=($new_w*$old_y)/$old_x;
                if($thumb_h>$new_h)
				{
					$thumb_h=$new_h;
					$thumb_w=$old_x*($new_h/$old_y);
				}
			}
			else
			{
				$thumb_h=$new_h;
				$thumb_w=$old_x*($new_h/$old_y);
                 if($thumb_w>$new_w)
				{
					$thumb_w=$new_w;
					$thumb_h=($new_w*$old_y)/$old_x;
				}
			}
	}

	if ($old_x == $old_y) //both same
	{ //lowest value assigned to final
		if($new_w>$new_h)
		{
			$thumb_h=$new_h;
			$thumb_w=($new_h*$old_x)/$old_y;
             if($thumb_w>$new_w)
				{
					$thumb_w=$new_w;
					$thumb_h=($new_w*$old_y)/$old_x;
				}

		}
		else if($new_w<$new_h)
		{
			$thumb_w=$new_w;
			$thumb_h=($new_w*$old_y)/$old_x;
            if($thumb_h>$new_h)
				{
					$thumb_h=$new_h;
					$thumb_w=$old_x*($new_h/$old_y);
				}
		}
		else
		{
			$thumb_w=$new_w;
			$thumb_h=$new_h;
		}
	}

	$dst_img= @imagecreatetruecolor($thumb_w,$thumb_h);
     if($system=="gif")
     {
    	$transparent = @imagecolorallocate($dst_img, "255", "255", "255");
    	@imagefill($dst_img, 0, 0, $transparent);
     }
	@imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y);
	if (preg_match("/png/",$system))
		{
			imagepng($dst_img,$filename);
		}
	else if (preg_match('/gif/',$system))
		{
			imagegif($dst_img,$filename);
		}
	else
		{
			imagejpeg($dst_img,$filename); 
		}
	imagedestroy($dst_img);
	imagedestroy($src_img);
}
/*****
    //FOR RETURN FINAL IMAGE AFTER RESIZE AND CROP
    $final_path=FULLPATH WITH FILENAME IN WHICH CROPPED IMAGE WILL STORED
    $path= PATH WITHOUT FILENAME IN WHICH $file_name WAS STORED
    //SAMPLE=getCrop($ORIGINAL_FOLDER,"2.JPG",PHOTO_CROP_WIDTH,PHOTO_CROP_HEIGHT,$final_path);
*****/
function getCrop($path,$file_name,$width,$height,$final_path)
{

	   	$fold_large=$path."/".$file_name;
		@chmod($fold_large,0777);
		$size = @getimagesize($fold_large);//300/293
				 if($size[0]>$width && $size[1]>$height)//both large
				 {//resize + crop
					 $new_name=$path."/rajbl_".$file_name;
					 $this->resize_crop($fold_large,$new_name,$width,$height);
					 @chmod($new_name,0777);
					 $this->crop_image($new_name,$final_path,$width,$height);
					 $final=$final_path;
					 @unlink($new_name);
				 }
				 else if($size[0]>$width && $size[1]<=$height)
				 {//crop on width
					 $new_w=$width;
					 $new_h=$size[1];
					 $type="w";
					 $this->crop_image($fold_large,$final_path,$new_w,$new_h,$type);
					 $final =$final_path;	
				 }
				 else if($size[0]<=$width && $size[1]>$height)
				 {//crop on height
					 $new_w=$size[0];
					 $new_h=$height;
					 $type="h";
					 $this->crop_image($fold_large,$final_path,$new_w,$new_h,$type);
					 $final =$final_path;
				 }
				 else //both small , size[0]<=width && siize[1]<=height
				 {//no operation//only upload
					@copy($fold_large, $final_path);
					 $final =$final_path;
				 }
				@chmod($final,0777);

			return $final;	 
}
/****
    //FOR RETURN FINAL IMAGE AFTER RESIZE
    $final_path=FULLPATH WITH FILENAME IN WHICH CROPPED IMAGE WILL STORED
    $path= PATH WITHOUT FILENAME IN WHICH $file_name WAS STORED
    $file_name=ONLY FILENAME WHICH WAS STORED IN $path
    //SAMPLE=getResize($ORIGINAL_FOLDER,"2.JPG",PHOTO_CROP_WIDTH,PHOTO_CROP_HEIGHT,$final_path);
***/
function getResize($path,$file_name,$width,$height,$final_path)
{
    	$fold_large=$path."/".$file_name;
		@chmod($fold_large,0777);
		$size = @getimagesize($fold_large);//300/293
		 if($size[0]<=$width && $size[1]<=$height)
		 {
			 //no operation//only upload
					@copy($fold_large, $final_path);
					 $final =$final_path;
		 }
		 else
		 {
				$this->resizenew($fold_large,$final_path,$width,$height);
				$final=$final_path;
		 }
		@chmod($final,0777);
	return $final;
}
/*****
    //FOR RETURN FINAL IMAGE AFTER RESIZE AND CROP
    $final_path=FULLPATH WITH FILENAME IN WHICH CROPPED IMAGE WILL STORED
    $path= PATH WITHOUT FILENAME IN WHICH $file_name WAS STORED
    //SAMPLE=getCrop($ORIGINAL_FOLDER,"2.JPG",PHOTO_CROP_WIDTH,PHOTO_CROP_HEIGHT,$final_path);
*****/
function getCropImage($path,$file_name,$width,$height,$final_path)
{
    $system= substr(strrchr($file_name, "."), 1 );
  	if (preg_match('/bmp/',$system))
    {
        $temp_path1=$path."/".$file_name;
    	$temp_val="raj.png";
    	$temp_path2=$path."/".$temp_val;
    	@chmod($temp_path1,0777);
    	$ret=$this->imagecreatefrombmp($temp_path1,$temp_path2);
    	@chmod($temp_path2,0777);
        $final_path= substr($final_path, 0, -3)."png";
    }
    else
    {
            $temp_val=$file_name;
    }

	$image_new =$this->getCrop($path,$temp_val,$width,$height,$final_path);
    if (preg_match('/bmp/',$system))
    {
    	@unlink($temp_path2);
    }
	return $image_new;
}
/****
    //FOR RETURN FINAL IMAGE AFTER RESIZE
    $final_path=FULLPATH WITH FILENAME IN WHICH CROPPED IMAGE WILL STORED
    $path= PATH WITHOUT FILENAME IN WHICH $file_name WAS STORED
    $file_name=ONLY FILENAME WHICH WAS STORED IN $path
    //SAMPLE=getResizeImage($ORIGINAL_FOLDER,"2.JPG",PHOTO_CROP_WIDTH,PHOTO_CROP_HEIGHT,$final_path);
***/
function getResizeImage($path,$file_name,$width,$height,$final_path)
{
    $system= substr(strrchr($file_name, "."), 1 );
  	if (preg_match('/bmp/',$system))
    {
        $temp_path1=$path."/".$file_name;
    	$temp_val="raj.png";
    	$temp_path2=$path."/".$temp_val;
    	@chmod($temp_path1,0777);
    	$ret=$this->imagecreatefrombmp($temp_path1,$temp_path2);
    	@chmod($temp_path2,0777);
        $final_path= substr($final_path, 0, -3)."png";
    }
    else
    {
            $temp_val=$file_name;
    }
    $image_new =$this->getResize($path,$temp_val,$width,$height,$final_path);
    if (preg_match('/bmp/',$system))
    {
    	@unlink($temp_path2);
    }
	return $image_new;
}

//FOR DYNAMIC CREATE DIR UPLOAD FILES ON IT OBNE BY ONE//24/8
//RETURN TOTAL FILES IN GIVEN DIR
function total_file($dir)
{
		if ($dh = opendir($dir))
		{
		$i=0;
        while (($file = readdir($dh)) !== false)
			{
				if ($file != "." && $file != "..")
				{
					if($file!="Thumbs.db")
						$i++;
				}
			}
        closedir($dh);
		}
	return $i;
}
//RETURN TOTAL DIR FOR GIVEN FOLDER/DIR
//FOLD IS EXCEPTIONAL FOLDER IN GIVEN DIR
function total_dir($dir,$fold)
{
   	if ($dh = opendir($dir))
		{
		$i=0;
        while (($file = readdir($dh)) !== false)
			{

				if ($file != "." && $file != "..")
				{

					if($fold!="")
					{

						if (is_dir($dir."/".$file) && $file!=$fold)
						{
							$i++;
						}
					}
					else
					{

						if (is_dir($dir."/".$file))
						{
							$i++;
						}	
					}
					
				}
			}
        closedir($dh);
		}
		
	return $i;
}
//CREATE FOLDER NAMED DIR
function create_folder($dir)
{
	mkdir($dir);
	@chmod($dir,0777);
	
}
/*****
    //FOR DYNAMICALLY GENERATE FOLDER AND COPY IMAGE FILE IN IT
    $fold_path=FOLDER PATH WITHOUT FILENAME IN WHICH FOLDER STORED
    $max_file=HOW MUCH FILE WILL STORED IN THAT FOLDER
    $file_name=ONLY FILENAME THAT WILL STORED IN SOME FOLDER(FINAL FILENAME) NEW NAME OF FILE
    $temp_name=TEMP NAME OR FILENAME(ORIGINAL FILE)$_FILES['NAME']/$_FILES['TMP_NAME']
            OR FULLPATH WITH FILENAME IN WHICH UPLOADED FILE WAS STORED
     $fold=EXTRA FOLDER WHICH IS LOCATED IN $fold_path
    //SAMPLE=increment_folder("var/html/www/wamba_ccc/picture",MAX_FILE,"1.JPG",temp_name/finalpath,images);
****/
function increment_folder($fold_path,$max_file,$file_name,$temp_name,$fold="")
{
	$total_dir = $this->total_dir($fold_path,$fold);
	if($total_dir>0)
	{
	for($i=1;$i<=$total_dir;$i++)
		{
			$old_dir = $fold_path."/".$i;
			$new_dir=  $fold_path."/".($i+1);
    			if($this->total_file($old_dir)<$max_file)
    				{
    				@copy($temp_name,$old_dir."/".$file_name);
    				$ret_val= $old_dir;
    				}
    			else
    				{
    					if(!is_dir($new_dir))
    					{
    						$this->create_folder($new_dir);
    						$ret_val= $this->increment_folder($fold_path,$max_file,$file_name,$temp_name,$fold);
    					}
    				}
		}//end for
	}//end if
	else
		{
			$new_dir=$fold_path."/"."1";
			$this->create_folder($new_dir);
			$ret_val= $this->increment_folder($fold_path,$max_file,$file_name,$temp_name,$fold);
		}//END ELSE
		
	return $ret_val;
}//END function increment_folder
/* *START BMP SECTION
*------------------------------------------------------------
*                   BMP Image functions
*------------------------------------------------------------

*/
/*
*------------------------------------------------------------
*                    ImageBMP//for creatin new bmp files
*------------------------------------------------------------
*            - Creates new BMP file
*
*         Parameters:  $img - Target image
*                      $file - Target file to store
*                            - if not specified, bmp is returned
*           Returns: if $file specified - true if OK
                     if $file not specified - image data
*/
function imagebmp($img,$file="",$RLE=0)
{
	$ColorCount=imagecolorstotal($img);
	$Transparent=imagecolortransparent($img);
	$IsTransparent=$Transparent!=-1;
	if($IsTransparent) $ColorCount--;
	if($ColorCount==0) {$ColorCount=0; $BitCount=24;};
	if(($ColorCount>0)and($ColorCount<=2)) {$ColorCount=2; $BitCount=1;};
	if(($ColorCount>2)and($ColorCount<=16)) { $ColorCount=16; $BitCount=4;};
	if(($ColorCount>16)and($ColorCount<=256)) { $ColorCount=0; $BitCount=8;};
                $Width=imagesx($img);
                $Height=imagesy($img);
                $Zbytek=(4-($Width/(8/$BitCount))%4)%4;
                if($BitCount<24) $palsize=pow(2,$BitCount)*4;
                $size=(floor($Width/(8/$BitCount))+$Zbytek)*$Height+54;
                $size+=$palsize;
                $offset=54+$palsize;

                // Bitmap File Header
                $ret = 'BM';                        // header (2b)
                $ret .= $this->int_to_dword($size);        // size of file (4b)
                $ret .= $this->int_to_dword(0);        // reserved (4b)
                $ret .= $this->int_to_dword($offset);        // byte location in the file which is first byte of IMAGE (4b)
                // Bitmap Info Header
                $ret .= $this->int_to_dword(40);        // Size of BITMAPINFOHEADER (4b)
                $ret .= $this->int_to_dword($Width);        // width of bitmap (4b)
                $ret .= $this->int_to_dword($Height);        // height of bitmap (4b)
                $ret .= $this->int_to_word(1);        // biPlanes = 1 (2b)
                $ret .= $this->int_to_word($BitCount);        // biBitCount = {1 (mono) or 4 (16 clr ) or 8 (256 clr) or 24 (16 Mil)} (2b)
                $ret .= $this->int_to_dword($RLE);        // RLE COMPRESSION (4b)
                $ret .= $this->int_to_dword(0);        // width x height (4b)
                $ret .= $this->int_to_dword(0);        // biXPelsPerMeter (4b)
                $ret .= $this->int_to_dword(0);        // biYPelsPerMeter (4b)
                $ret .= $this->int_to_dword(0);        // Number of palettes used (4b)
                $ret .= $this->int_to_dword(0);        // Number of important colour (4b)
                // image data

                $CC=$ColorCount;
                $sl1=strlen($ret);
                if($CC==0) $CC=256;
                if($BitCount<24)
                   {
                    $ColorTotal=imagecolorstotal($img);
                     if($IsTransparent) $ColorTotal--;

                     for($p=0;$p<$ColorTotal;$p++)
                     {
                      $color=imagecolorsforindex($img,$p);
                       $ret.=$this->inttobyte($color["blue"]);
                       $ret.=$this->inttobyte($color["green"]);
                       $ret.=$this->inttobyte($color["red"]);
                       $ret.=$this->inttobyte(0); //RESERVED
                     };

                    $CT=$ColorTotal;
                  for($p=$ColorTotal;$p<$CC;$p++)
                       {
                      $ret.=$this->inttobyte(0);
                      $ret.=$this->inttobyte(0);
                      $ret.=$this->inttobyte(0);
                      $ret.=$this->inttobyte(0); //RESERVED
                     };
                   };


		if($BitCount<=8)
		{
		
		 for($y=$Height-1;$y>=0;$y--)
		 {
		  $bWrite="";
		  for($x=0;$x<$Width;$x++)
		   {
		   $color=imagecolorat($img,$x,$y);
		   $bWrite.=$this->decbinx($color,$BitCount);

		   if(strlen($bWrite)==8)
		    {
		     $retd.=$this->inttobyte($this->bindec($bWrite));
		     $bWrite="";
		    };
		   };
		
		  if((strlen($bWrite)<8)and(strlen($bWrite)!=0))
		    {
		     $sl=strlen($bWrite);
		     for($t=0;$t<8-$sl;$t++)
		      $sl.="0";
		     $retd.=$this->inttobyte($this->bindec($bWrite));
		    };
		 for($z=0;$z<$Zbytek;$z++)
		   $retd.=$this->inttobyte(0);
		 };
		};

		if(($RLE==1)and($BitCount==8))
		{
		 for($t=0;$t<strlen($retd);$t+=4)
		  {
		   if($t!=0)
		   if(($t)%$Width==0)
		    $ret.=chr(0).chr(0);

		   if(($t+5)%$Width==0)
		   {
		     $ret.=chr(0).chr(5).substr($retd,$t,5).chr(0);
		     $t+=1;
		   }
		   if(($t+6)%$Width==0)
		    {
		     $ret.=chr(0).chr(6).substr($retd,$t,6);
		     $t+=2;
		    }
		    else
		    {
		     $ret.=chr(0).chr(4).substr($retd,$t,4);
		    };
		  };
		  $ret.=chr(0).chr(1);
		}
		else
		{
		$ret.=$retd;
		};


                if($BitCount==24)
                {
                for($z=0;$z<$Zbytek;$z++)
                 $Dopl.=chr(0);

                for($y=$Height-1;$y>=0;$y--)
                 {
                 for($x=0;$x<$Width;$x++)
                        {
                           $color=imagecolorsforindex($img,ImageColorAt($img,$x,$y));
                           $ret.=chr($color["blue"]).chr($color["green"]).chr($color["red"]);
                        }
                 $ret.=$Dopl;
                 };

                 };

		  if($file!="")
		   {
		    $r=($f=fopen($file,"w"));
		    $r=$r and fwrite($f,$ret);
		    $r=$r and fclose($f);
		    return $r;
		   }
		  else
		  {
		   echo $ret;
		  };
}
//end function 

/*
*------------------------------------------------------------
*                    ImageCreateFromBmp
*------------------------------------------------------------
*            - Reads image from a BMP file
*         Parameters:  $file - Target file to load
*            Returns: Image ID
*/

function imagecreatefrombmp($file,$filename)
{
	   //	global $this->CurrentBit, $echoMode;
		$f=fopen($file,"r");
		$Header=fread($f,2);
		if($Header=="BM")
		{
			 $Size=$this->freaddword($f);
			 $Reserved1=$this->freadword($f);
			 $Reserved2=$this->freadword($f);
			 $FirstByteOfImage=$this->freaddword($f);

			 $SizeBITMAPINFOHEADER=$this->freaddword($f);
			 $Width=$this->freaddword($f);
			 $Height=$this->freaddword($f);
			 $biPlanes=$this->freadword($f);
			 $biBitCount=$this->freadword($f);
			 $RLECompression=$this->freaddword($f);
			 $WidthxHeight=$this->freaddword($f);
			 $biXPelsPerMeter=$this->freaddword($f);
			 $biYPelsPerMeter=$this->freaddword($f);
			 $NumberOfPalettesUsed=$this->freaddword($f);
			 $NumberOfImportantColors=$this->freaddword($f);

			if($biBitCount<24)
			 {
			
			  $img=imagecreate($Width,$Height);
			  $Colors=pow(2,$biBitCount);
			  for($p=0;$p<$Colors;$p++)
			   {
			    $B=$this->freadbyte($f);
			    $G=$this->freadbyte($f);
			    $R=$this->freadbyte($f);
			    $Reserved=$this->freadbyte($f);
			    $Palette[]=imagecolorallocate($img,$R,$G,$B);
			   };
			
			if($RLECompression==0)
			{
			   $Zbytek=(4-ceil(($Width/(8/$biBitCount)))%4)%4;
			
			for($y=$Height-1;$y>=0;$y--)
			    {
			     $this->CurrentBit=0;
			     for($x=0;$x<$Width;$x++)
			      {
			         $C=$this->freadbits($f,$biBitCount);
			       imagesetpixel($img,$x,$y,$Palette[$C]);
			      };
			    if($this->CurrentBit!=0) {$this->freadbyte($f);};
			    for($g=0;$g<$Zbytek;$g++)
			     $this->freadbyte($f);
			     };
				};
			};

		
		if($RLECompression==1) //$BI_RLE8
		{
			$y=$Height;
			
			$pocetb=0;
			
			while(true)
			{
			$y--;
			$prefix=$this->freadbyte($f);
			$suffix=$this->freadbyte($f);
			$pocetb+=2;
			
			$echoit=false;
			
			if($echoit)echo "Prefix: $prefix Suffix: $suffix<BR>";
			if(($prefix==0)and($suffix==1)) break;
			if(feof($f)) break;
		
			while(!(($prefix==0)and($suffix==0)))
			{
			 if($prefix==0)
			  {
			   $pocet=$suffix;
			   $Data.=fread($f,$pocet);
			   $pocetb+=$pocet;
			   if($pocetb%2==1) {$this->freadbyte($f); $pocetb++;};
			  };
			 if($prefix>0)
			  {
			   $pocet=$prefix;
			   for($r=0;$r<$pocet;$r++)
			    $Data.=chr($suffix);
			  };
			 $prefix=$this->freadbyte($f);
			 $suffix=$this->freadbyte($f);
			 $pocetb+=2;
			 if($echoit) echo "Prefix: $prefix Suffix: $suffix<BR>";
			};

			for($x=0;$x<strlen($Data);$x++)
			 {
			  imagesetpixel($img,$x,$y,$Palette[ord($Data[$x])]);
			 };
			$Data="";
			
			};
			
			};
		if($RLECompression==2) //$BI_RLE4
		{
		$y=$Height;
		$pocetb=0;
		while(true)
		{
			$y--;
			$prefix=$this->freadbyte($f);
			$suffix=$this->freadbyte($f);
			$pocetb+=2;
			
			$echoit=false;

			if($echoit)echo "Prefix: $prefix Suffix: $suffix<BR>";
			if(($prefix==0)and($suffix==1)) break;
			if(feof($f)) break;
		
		while(!(($prefix==0)and($suffix==0)))
		{
		 if($prefix==0)
		  {
		   $pocet=$suffix;
		
		   $this->CurrentBit=0;
		   for($h=0;$h<$pocet;$h++)
		    $Data.=chr($this->freadbits($f,4));
		   if($this->CurrentBit!=0) $this->freadbits($f,4);
		   $pocetb+=ceil(($pocet/2));
		   if($pocetb%2==1) {$this->freadbyte($f); $pocetb++;};
		  };
		 if($prefix>0)
		  {
		   $pocet=$prefix;
		   $i=0;
		   for($r=0;$r<$pocet;$r++)
		    {
		    if($i%2==0)
		     {
		      $Data.=chr($suffix%16);
		     }
		     else
		     {
		      $Data.=chr(floor($suffix/16));
		     };
		    $i++;
		    };
		  };
		 $prefix=$this->freadbyte($f);
		 $suffix=$this->freadbyte($f);
		 $pocetb+=2;
		 if($echoit) echo "Prefix: $prefix Suffix: $suffix<BR>";
		};

		for($x=0;$x<strlen($Data);$x++)
		 {
		  imagesetpixel($img,$x,$y,$Palette[ord($Data[$x])]);
		 };
		$Data="";
		
		};
		
		};
		
		
		 if($biBitCount==24)
		{
		 $img=imagecreatetruecolor($Width,$Height);
		 $Zbytek=$Width%4;
		
		   for($y=$Height-1;$y>=0;$y--)
		    {
		     for($x=0;$x<$Width;$x++)
		      {
		       $B=$this->freadbyte($f);
		       $G=$this->freadbyte($f);
		       $R=$this->freadbyte($f);
		       $color=imagecolorexact($img,$R,$G,$B);
		       if($color==-1) $color=imagecolorallocate($img,$R,$G,$B);
		       imagesetpixel($img,$x,$y,$color);
		      }
		    for($z=0;$z<$Zbytek;$z++)
		     $this->freadbyte($f);
		   };
		};
		@imagepng($img,$filename);
		return $filename;
		};
		fclose($f);
}//end of functin imagecreatefrombmp
/*
* Helping functions:
*-------------------------
*
* freadbyte($file) - reads 1 byte from $file
* freadword($file) - reads 2 bytes (1 word) from $file
* freaddword($file) - reads 4 bytes (1 dword) from $file
* freadlngint($file) - same as freaddword($file)
* decbin8($d) - returns binary string of d zero filled to 8
* RetBits($byte,$start,$len) - returns bits $start->$start+$len from $byte
* freadbits($file,$count) - reads next $count bits from $file
* RGBToHex($R,$G,$B) - convert $R, $G, $B to hex
* int_to_dword($n) - returns 4 byte representation of $n
* int_to_word($n) - returns 2 byte representation of $n
*/
function freadbyte($f)
{
 return ord(fread($f,1));
}

function freadword($f)
{
	 $b1=$this->freadbyte($f);
	 $b2=$this->freadbyte($f);
	 return $b2*256+$b1;
}


function freadlngint($f)
{
		return $this->freaddword($f);
}

function freaddword($f)
{
	 $b1=$this->freadword($f);
	 $b2=$this->freadword($f);
	 return $b2*65536+$b1;
}
function RetBits($byte,$start,$len)
{
	$bin=$this->decbin8($byte);
	$r=bindec(substr($bin,$start,$len));
	return $r;

}

function freadbits($f,$count)
{
	 //global $this->CurrentBit,$SMode;
	 $Byte=$this->freadbyte($f);
	 $LastCBit=$this->CurrentBit;
	 $this->CurrentBit+=$count;
	 if($this->CurrentBit==8)
	  {
	   $this->CurrentBit=0;
	  }
	 else
	  {
	   fseek($f,ftell($f)-1);
	  };
	return $this->RetBits($Byte,$LastCBit,$count);
}



function RGBToHex($Red,$Green,$Blue)
  {
	   $hRed=dechex($Red);if(strlen($hRed)==1) $hRed="0$hRed";
	   $hGreen=dechex($Green);if(strlen($hGreen)==1) $hGreen="0$hGreen";
	   $hBlue=dechex($Blue);if(strlen($hBlue)==1) $hBlue="0$hBlue";
	   return($hRed.$hGreen.$hBlue);
  }

  function int_to_dword($n)
        {
                return chr($n & 255).chr(($n >> 8) & 255).chr(($n >> 16) & 255).chr(($n >> 24) & 255);
        }
 function int_to_word($n)
        {
                return chr($n & 255).chr(($n >> 8) & 255);
        }


function decbin8($d)
{
	return $this->decbinx($d,8);
}

function decbinx($d,$n)
{
	$bin=decbin($d);
	$sbin=strlen($bin);
	for($j=0;$j<$n-$sbin;$j++)
	 $bin="0$bin";
	return $bin;
}

function inttobyte($n)
{
	return chr($n);
}

//end of bmp section

// function added by ashok : 2 Jun, 2008
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