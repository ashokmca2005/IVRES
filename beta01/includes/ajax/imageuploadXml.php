<?php
session_start();
header("Content-type: text/xml; charset=\"UTF-8\"");
header("Cache-Control: no-cache, must-revalidate");
//A date in the past
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

require_once("../../adm/includes/common.php");
require_once("../../adm/includes/database-table.php");
require_once("../../adm/includes/classes/class.DB.php");
require_once("../../adm/includes/functions/general.php");

$dbObj = new DB();
$dbObj->fun_db_connect();

//$dbObj->mySqlSafeQuery("UPDATE ".TABLE_PROPERTY_PHOTO_ALL." SET photo_caption='test25', photo_url='1_600x450.jpg', photo_thumb='1_88x66.jpg' WHERE photo_id='1'");
$strXml ="";
$strXmlContent ="";
if(isset($_POST['id'])){
	$uploadFile=$_GET['dirname']."/".$_FILES[$_POST['id']]['name'];
	if(!is_dir($_GET['dirname'])){
		echo '<script> alert("Failed to find the final upload directory: "+'.$_GET['dirname'].');</script>';
	}
	if (!@copy($_FILES[$_POST['id']]['tmp_name'], $_GET['dirname'].'/'.$_FILES[$_POST['id']]['name'])){	
		echo '<script> alert("Failed to upload file");</script>';
	}
	else{
		//Step I: make thumbnails and rename original file
		if(isset($_POST['txtUploadPhotoId']) && $_POST['txtUploadPhotoId'] !=""){

			$photo_id 		= $_POST['txtUploadPhotoId'];
			$property_id 	= $_POST['txtUploadPropertyId'];
			$photo_caption 	= $_POST['txtUploadPhotoCaption'];

			$property_img = basename($_FILES[$_POST['id']]['name']);
			$extn=split("\.",$property_img);
			
			
			$photo_main 	= $property_id."_".$photo_id."_photo.".$extn[1];
			$photo_thumb 	= $property_id."_".$photo_id."_photo_thumb.".$extn[1];
			
			$uploadphotodir = $_GET['dirname'].'/property_images/large/';
			$uploadthumbdir = $_GET['dirname'].'/property_images/thumbnail/';
			$uploadphotofile = $uploadphotodir . $photo_main;
			$uploadthumbfile = $uploadthumbdir . $photo_thumb;
//			$uploadtempfile = $_GET['dirname'].'/'.$property_img;

			if (move_uploaded_file($_FILES[$_POST['id']]['tmp_name'], $uploadphotofile)){
				@copy($uploadphotofile, $uploadthumbfile);
				$strUpdateQuery = "UPDATE ".TABLE_PROPERTY_PHOTO_ALL." SET photo_caption='$photo_caption', photo_url='$photo_main', photo_thumb='$photo_thumb' WHERE photo_id='$photo_id'";
				$dbObj->mySqlSafeQuery($strUpdateQuery);
//				@unlink($uploadtempfile);
			} 
			else{
				$photo_main 	= "";
				$photo_thumb 	= "";
			}
			//Step II: delete any file make thumbnails and rename original file
			$strXmlContent ="";
			$strXmlContent .="<photo>\n";
			$strXmlContent .="<photoid>".$photo_id."</photoid>\n";
			$strXmlContent .="<photosrc><![CDATA[".$uploadthumbfile."]]></photosrc>\n";
			$strXmlContent .="<photocap>".$photo_caption."</photocap>\n";
			$strXmlContent .="<photostatus>File uploaded.</photostatus>\n";
			$strXmlContent .="</photo>\n";
		}
		else{
			$photo_caption 	= $_POST['txtUploadPhotoCaption'];
			$property_id 	= $_POST['txtUploadPropertyId'];

			$cur_unixtime 	= time ();
			if(isset($_SESSION['ses_admin_id']) && $_SESSION['ses_admin_id'] !=""){
				$cur_user_id 	= $_SESSION['ses_admin_id'];
			}
			else if(isset($_SESSION['ses_modarator_id']) && $_SESSION['ses_modarator_id'] !=""){
				$cur_user_id 	= $_SESSION['ses_modarator_id'];
			}
			else if(isset($_SESSION['ses_user_id']) && $_SESSION['ses_user_id'] !=""){
				$cur_user_id 	= $_SESSION['ses_user_id'];
			}
			else{
				$cur_user_id 	= "";
			}
			
			// Insert with blank data
			$strInsQuery = "INSERT INTO ".TABLE_PROPERTY_PHOTO_ALL."(photo_id, property_id, photo_caption, photo_url, photo_thumb, created_on, created_by, updated_on, updated_by, photo_main) VALUES('', '$property_id', '', '', '', '".$cur_unixtime."', '".$cur_user_id."', '".$cur_unixtime."', '".$cur_user_id."', '0')";
			$dbObj->mySqlSafeQuery($strInsQuery);
			$photo_id = $dbObj->getIdentity();

			$property_img = basename($_FILES[$_POST['id']]['name']);
			$extn=split("\.",$property_img);

			$photo_main 	= $property_id."_".$photo_id."_photo.".$extn[1];
			$photo_thumb 	= $property_id."_".$photo_id."_photo_thumb.".$extn[1];
			
			$uploadphotodir = $_GET['dirname'].'/property_images/large/';
			$uploadthumbdir = $_GET['dirname'].'/property_images/thumbnail/';
			$uploadphotofile = $uploadphotodir . $photo_main;
			$uploadthumbfile = $uploadthumbdir . $photo_thumb;
//			$uploadtempfile = $_GET['dirname'].'/'.$property_img;

			if (move_uploaded_file($_FILES[$_POST['id']]['tmp_name'], $uploadphotofile)){
				@copy($uploadphotofile, $uploadthumbfile);
				$strUpdateQuery = "UPDATE ".TABLE_PROPERTY_PHOTO_ALL." SET photo_caption='$photo_caption', photo_url='$photo_main', photo_thumb='$photo_thumb' WHERE photo_id='$photo_id'";
				$dbObj->mySqlSafeQuery($strUpdateQuery);
//				@unlink($uploadtempfile);
			} 
			else{
				$photo_main 	= "";
				$photo_thumb 	= "";
			}

			//Step II: delete any file make thumbnails and rename original file
			$strXmlContent ="";
			$strXmlContent .="<photo>\n";
			$strXmlContent .="<photoid>".$photo_id."</photoid>\n";
			$strXmlContent .="<photosrc><![CDATA[".trim($uploadthumbfile)."]]></photosrc>\n";
			$strXmlContent .="<photostatus>File uploaded.</photostatus>\n";
			$strXmlContent .="</photo>\n";
		}
	}
	
}
else{
	$property_id = $_GET['propertyid'];
	$uploadFile=$_GET['dirname']."/".$_GET['filename'];
	if (file_exists($uploadFile)){

		$strSelectQuery = "SELECT * FROM ".TABLE_PROPERTY_PHOTO_ALL." WHERE property_id='$property_id' ORDER BY photo_id DESC";
		$rs = $dbObj->createRecordset($strSelectQuery);
		$arr = $dbObj->fetchAssoc($rs);
		if(count($arr) > 0){
			$photo_id 	= $arr[0]['photo_id'];
			$uploadFile	= 'upload/property_images/thumbnail/'.$arr[0]['photo_thumb'];
		}

		$strXmlContent ="";
		$strXmlContent .="<photo>\n";
		$strXmlContent .="<photoid>".$photo_id."</photoid>\n";
		if($uploadFile == "/" || $uploadFile == "" || $uploadFile == "upload/"){
			$strXmlContent .="<photosrc><![CDATA[images/image-thumbnail.gif]]></photosrc>\n";
			$strXmlContent .="<photostatus>Uploading File. Please wait...</photostatus>\n";
		}
		else{
		$strXmlContent .="<photosrc><![CDATA[".$uploadFile."]]></photosrc>\n";
		$strXmlContent .="<photostatus>File uploaded.</photostatus>\n";
		}
		$strXmlContent .="</photo>\n";
	}
	else{
		$strXmlContent ="";
		$strXmlContent .="<photo>\n";
		$strXmlContent .="<photoid>0</photoid>\n";
		$strXmlContent .="<photosrc><![CDATA[images/image-thumbnail.gif]]></photosrc>\n";
		$strXmlContent .="<photostatus>Uploading File. Please wait...</photostatus>\n";
		$strXmlContent .="</photo>\n";
	}
}
$strXml = "";
$strXml ="<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
$strXml .="<photos>\n";
$strXml .=trim($strXmlContent);
$strXml .="</photos>";
echo $strXml;
?>
