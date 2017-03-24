<?
class Pagination{
	var $rows = array();
	var $rows_on_page = 10;
	var $add_params = FALSE;
	var $seo_params = FALSE;
	var $current_page = 1;
	var $max_page_scroll = 4;
	var $page_param = "page";
	
	var $rez_pages = 1;
	var $rez_rows_count = 0;
	var $rez_first_row  = 0;
	var $rez_last_row   = 0;
		
	function Pagination(&$rows, $add_params = FALSE,  $rows_on_page = 10, $seo_params = FALSE){
		$this->rows = &$rows;
		$this->rows_on_page = $rows_on_page;
		$this->add_params = $add_params;
		$this->seo_params = $seo_params;
		
		#Get page parameter from form
		$this->current_page = form_int($this->page_param, 1);
	}
	
	function Process(){
		$this->Calculate();
		if(is_array($this->rows)){
			$this->rows = array_splice($this->rows, $this->rez_first_row, $this->rows_on_page);
		}else{
			if(mysql_num_rows($this->rows) > 0 && $this->rez_first_row <= mysql_num_rows($this->rows)){
				mysql_data_seek($this->rows, $this->rez_first_row);
			}
				$result = array();
				for($i=0; $i<$this->rows_on_page; $i++){
					if($row = mysql_fetch_array($this->rows)){
						$result[] = $row;
					}else{
						break;
					}
					//$row = mysql_fetch_array($this->rows);
					//$result[] = $row;
				}
				$this->rows = $result;
//			}else{
//				$this->rows = array();
//			}
		}
		
		#Create result object
		$rez["first_row"] = $this->rez_first_row+1;
		$rez["last_row"]  = $this->rez_last_row+1;
		$rez["total_rows"]= $this->rez_rows_count;
		if($this->rez_pages > 1){
			$pages = array();
			for($i=1; $i<=$this->rez_pages; $i++){
				if($i >= ($this->current_page-$this->max_page_scroll) && 
				   $i <= ($this->current_page+$this->max_page_scroll)){
					$p["no"]   = $i;
					$link      = $this->GetPageLink($i);
					$p["link"] = ($i != $this->current_page) ? $link : FALSE;
					$pages[] = $p;
				}
			}
			$rez["pages"] = $pages;
		}
		if($this->current_page > 1){
			$rez["first"] = $this->GetPageLink(1);
			$rez["prev"]  = $this->GetPageLink($this->current_page - 1);
		}
		if($this->current_page < $this->rez_pages){
			$rez["next"]  = $this->GetPageLink($this->current_page + 1);
			$rez["last"]  = $this->GetPageLink($this->rez_pages);
		}

		return $rez;
	}

	function GetPageLink($page_no){
		if($this->seo_params != "") {
			return $this->seo_params."/".$this->page_param."_".$page_no.str_replace("=", "_", str_replace("&", "/", $this->add_params));
		} else {
			return $_SERVER["PHP_SELF"]."?".$this->page_param."=".$page_no.$this->add_params;
		}
	}
	
	function Calculate(){
		if(is_array($this->rows)){
			$this->rez_rows_count = sizeof($this->rows);
		}else{
			$this->rez_rows_count = mysql_num_rows($this->rows);
		}
		$this->rez_pages      = ceil($this->rez_rows_count / $this->rows_on_page);
		$this->rez_first_row  = ($this->current_page-1) * $this->rows_on_page;
		$this->rez_last_row   = $this->rez_first_row + $this->rows_on_page;
		if($this->rez_last_row > $this->rez_rows_count){
			$this->rez_last_row = $this->rez_rows_count -1;
		}else{
			$this->rez_last_row--;
		}
	
		#Got to last page is current page is greater than max number of pages
		if($this->current_page > $this->rez_pages){
			$this->current_page = $this->rez_pages;
		}
	}
}
?>