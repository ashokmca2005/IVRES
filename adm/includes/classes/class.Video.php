<?php
class Video{

	function Video(){//Class Constructor
		$this->dbObj = new DB();
		$this->dbObj->fun_db_connect();		
	}
	
	function fun_addNewVideo($vi_name, $actionType){
		$vi_status 	= 1;
		$vi_type	= 0;//0 is for Free & 1 is for Paid
		/*-++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-*/
		/*-++++++++++++++++			THIS ARRAY IS FOR INSERT INTO ol_ow_tbl_video TABLE START	+++++++++++++++++++-*/
		$phArray 	= array(
							"video_name" => $vi_name,
							"video_caption" => $_POST['video_caption'],
							"video_type" => $vi_type,
							"video_status" => $vi_status,
							"video_last_modified" => date("Y-m-d H:i:s")
						);
		/*-++++++++++++++++			THIS ARRAY IS FOR INSERT INTO ol_ow_tbl_video TABLE END			++++++++++++++++++++-*/
		/*-+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-*/
				
		
		if($actionType=='ADD'){
		
			/*-++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-*/
			/*-++++++++++++++++			THIS QUERY IS FOR $phArray START	+++++++++++++++++++-*/
			$fields 	= "";
			$fieldsVals = "";
			$sqlInsert	= "";
			$cnt 		= 0;
			$uID		= 0;
			if(isset($_SESSION['session_uid'])){
				$uID 	= $_SESSION['session_uid'];
			}
			foreach($phArray as $keys => $values){
				$fields .= $keys;
				$fieldsVals .= "'" . fun_db_input($values) . "'";
				if($cnt < sizeof($phArray)-1){
					$fields .= ", ";
					$fieldsVals .= ", ";
				}
				$cnt++;
			}
			$sqlInsert  = "INSERT INTO " . TABLE_VIDEO . "(video_id, users_id, ".$fields.", video_added_date) ";
			$sqlInsert .= "VALUES(null, ".$uID.", ".$fieldsVals.", '".date("Y-m-d")."')";
			/*-++++++++++++++++			THIS QUERY IS FOR $phArray END	+++++++++++++++++++-*/
			/*-++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-*/
			
			$cntVideo = $this->fun_getVideoCount($uID);
			//echo "line = 52 ".$cntVideo;exit();
			if( $cntVideo == "" ){			
				$this->fun_getVideoCountInsert($uID);//INSERT INTO ol_ow_tbl_count_video TABLE
				
				$this->dbObj->fun_db_query($sqlInsert);//INSERT INTO ol_ow_tbl_video TABLE
				
				return $this->dbObj->fun_db_get_affected_rows();
				
			}else if( $cntVideo < 2 && $cntVideo > 0){				
				$incCntVideo = $cntVideo+1 ;
				$this->fun_getVideoCountUpdate($uID, $incCntVideo);//UPDATE TABLE ol_ow_tbl_count_photos				
				$this->dbObj->fun_db_query($sqlInsert);//INSERT INTO ol_ow_tbl_photos TABLE
				return $this->dbObj->fun_db_get_affected_rows();
			}else if( $cntVideo > 1 ){				
				$viMessage = 2;//If an owner already uploaded 1 free video then he will pay for more video
				return $viMessage;				
			}
		}
	}
	
	/*-++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-*/
	/*-++++++++++++++++			THIS FUNCTION IS FOR INSERT THE QUANTITY OF OWNER VIDEO START	+++++++++++++++++++-*/
	function fun_getVideoCountInsert($uID){
		$added_date = date("Y-m-d");
		$last_mod	= date("Y-m-d H:i:s");
		$quantity	= 1;
		$cntInsert 	= '';
		
		$cntInsert = "INSERT INTO " . TABLE_COUNT_VIDEO . "(cnt_video_id, users_id, cnt_video_quantity, cnt_video_added_date, cnt_video_last_modified) ";
		$cntInsert .= "VALUES(null, ".$uID.", ".$quantity.", '".$added_date."', '".$last_mod."' )";
		$this->dbObj->fun_db_query($cntInsert);
		return $this->dbObj->fun_db_get_affected_rows();
		//echo "class.video.php line no. => 84 <br>".$cntInsert;exit; 
	}
	/*-++++++++++++++++			THIS FUNCTION IS FOR INSERT THE QUANTITY OF OWNER VIDEO END	+++++++++++++++++++-*/
	/*-++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-*/
	
	
	/*-++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-*/
	/*-++++++++++++++++			THIS FUNCTION IS FOR FETCH THE QUANTITY OF OWNER VIDEO START	+++++++++++++++++++-*/
	function fun_getVideoCount($uID){
		$phArray 	= array();
		$videoCnt 	= 0;
		$sql = "SELECT * FROM " . TABLE_COUNT_VIDEO . " WHERE users_id='".(int)fun_db_input($uID)."'";
		$result = $this->dbObj->fun_db_query($sql);
		if($this->dbObj->fun_db_get_num_rows($result) > 0){
			$rowsArray = $this->dbObj->fun_db_fetch_rs_object($result);
			$phArray['cnt_video_id'] = fun_db_output($rowsArray->cnt_video_id);
			$phArray['users_id'] = fun_db_output($rowsArray->users_id);
			$phArray['cnt_video_quantity'] = fun_db_output($rowsArray->cnt_video_quantity);
			$phArray['cnt_video_added_date'] = fun_db_output($rowsArray->cnt_video_added_date);
			$phArray['cnt_video_last_modified'] = fun_db_output($rowsArray->cnt_video_last_modified);
		}
		$this->dbObj->fun_db_free_resultset($result);
		$videoCnt = $phArray['cnt_video_quantity'];
		return $videoCnt;
	}
	/*-++++++++++++++++			THIS FUNCTION IS FOR FETCH THE QUANTITY OF OWNER VIDEO END		+++++++++++++++++++-*/
	/*-++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-*/
	
	
	/*-++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-*/
	/*-++++++++++++++++			THIS FUNCTION IS FOR UPDATE THE QUANTITY OF OWNER VIDEO START	+++++++++++++++++++-*/
	function fun_getVideoCountUpdate($uID, $cntVideo){		
		
		$sqlUpdate = "UPDATE " . TABLE_COUNT_VIDEO . " SET cnt_video_quantity = ".(int)$cntVideo." WHERE users_id='".(int)$uID."'";		
		$this->dbObj->fun_db_query($sqlUpdate);
		//echo "class.video.php line no. => 119 <br>".$sqlUpdate;exit;
		return $this->dbObj->fun_db_get_affected_rows();		
	}
	/*-++++++++++++++++			THIS FUNCTION IS FOR UPDATE THE QUANTITY OF OWNER VIDEO END	+++++++++++++++++++-*/
	/*-++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-*/
	
	function fun_get_num_rows($sql){
		$totalRows = 0;
		$selected = "";
		$sql = trim($sql);
		if($sql==""){
			die("<font color='#ff0000' face='verdana' face='2'>Error: Query is Empty!</font>");
			exit;
		}
		$result = $this->dbObj->fun_db_query($sql);
		$totalRows = $this->dbObj->fun_db_get_num_rows($result);
		$this->dbObj->fun_db_free_resultset($result);
		return $totalRows;
	}
}
?>