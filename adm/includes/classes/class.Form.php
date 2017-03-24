<?

Class Form{

	var $inputs   = array();
	var $is_valid = TRUE;
	var $error_message = "There was a problem with your submission. <br /> Please correct the errors below and resubmit.";
	var $created_on_field = FALSE;
	var $updated_on_field = FALSE;
	var $created_by_field = FALSE;
	var $updated_by_field = FALSE;

	var $table = FALSE;
	var $field_id = FALSE;
	var $object_name = "Record";
	var $record_infos = FALSE;
	
	var $message = FALSE;
	var $db_updated = FALSE;
	var $edit_mode = FALSE;
	
	var $executeAfterValidation = FALSE;
	var $executeBeforeInsert 	= FALSE;
	var $executeAfterInsert 	= FALSE;
	var $executeAfterUpdate 	= FALSE;
	var $executeBeforeUpdate 	= FALSE;
	
	function Form($object_name=FALSE, $table=FALSE, $field_id=FALSE, $add_submit_input = TRUE){
		$this->table = $table;
		$this->field_id = $field_id;
		if($object_name){
			$this->object_name = $object_name;
		}
		
		if($add_submit_input){
			$i = new InputHidden("submitted");
			$i->value = 1;
			$this->AddInput($i);
		}
	}
	
	function GetIValue($input_name){
		return $this->inputs[$input_name]->value;
	}

	function SetIValue($input_name, $value){
		$this->inputs[$input_name]->value = $value;
	}
	
	function &GetInput($input_name){
		return $this->inputs[$input_name];
	}
	
	function AddInput($input){
		$this->inputs[$input->name] = $input;
	}
	
	function GetValuesFromRequest($db = FALSE){
		foreach($this->inputs as $i){
			if(!$i->ignore_request_value){
				$this->inputs[$i->name]->GetValueFromRequest($db);
			}
		}
	}
	
	function GetValuesFromArray($p_arr){
		if(sizeof($p_arr) > 0){
			foreach($this->inputs as $i){
				if(isset($p_arr[$i->name])){
					$this->inputs[$i->name]->SetValue($p_arr[$i->name]);
				}
			}
		}
	}
	
	function SetInputsDisplay(){
		foreach($this->inputs as $i){
			$this->inputs[$i->name]->SetDisplay($this);
		}
	}
	
	function LoadingDataFromTable($db){
		foreach($this->inputs as $i){
			$this->inputs[$i->name]->LoadingDataFromTable($db, $this->inputs[$this->field_id]);
		}
	}
	
	function SetCurrentValues($p_arr, $db, $field_id_value){
		if(sizeof($p_arr) > 0){
			foreach($this->inputs as $i){
				$this->inputs[$i->name]->SetCurrentValue($p_arr[$i->name], $db, $this->field_id, $field_id_value);
			}
		}
	}
	
	function Validate(){
		foreach($this->inputs as $i){
			if(!$this->inputs[$i->name]->Validate()){
				$this->is_valid = FALSE;
			}
		}
		if($this->executeAfterValidation){
			call_user_func($this->executeAfterValidation, $this);
		}
	}
	
	function &GetInputId(){
		foreach($this->inputs as $i){
			if($i->field_name == $this->field_id){
				return $this->inputs[$i->name];
			}
		}
	}
	
	function &GetInputWithField($field){
		foreach($this->inputs as $i){
			if($i->field_name == $field){
				return $this->inputs[$i->name];
			}
		}
	}
	
	function InputExists($input_name){
		return isset($this->inputs[$input_name]);
	}
	
	function BeforeUpdateDatabase(){
		foreach($this->inputs as $i){
		  $this->inputs[$i->name]->BeforeUpdateDatabase();
		}
    }
	
	function UpdateDatabase($db){
		#Call SavingValues for each item 
			$insert_executed = FALSE;
			$this->BeforeUpdateDatabase();
	
			#Get id input
			//print_r($this->inputs);

			$input_id = &$this->GetInputId();			

# Call Before insert function
			if(!($input_id->value > 0)){
				if($this->executeBeforeInsert){
					call_user_func($this->executeBeforeInsert, $this);
				}
# -------------------------				
			}else{
# Call Before update function
				if($this->executeBeforeUpdate){
					call_user_func($this->executeBeforeUpdate, $this);
				}
			}
# -------------------------				
			$rs = $db->createRecordset("SELECT * FROM ".$this->table." LIMIT 1");
			$all_fields = $db->getFieldNames($rs);
			
			foreach($all_fields as $f){
				foreach($this->inputs as $i){
					if($f != $this->field_id && $i->field_name == $f && $i->update_db){
							$values[] = $i->value;
							$fields[] = $f;						
					}
				}
			}

	    	$db->insertOrUpdateFields($this->table, $this->field_id, 
									  $input_id->value, $fields, $values);

			if(!($input_id->value > 0)){
				if(strlen($input_id->value) == 0){
					$input_id->value = &$db->getIdentity();
				}
				
				$insert_executed = TRUE;
				
				if($this->created_on_field){
					$db->doSql("UPDATE ".$this->table." SET ".
									  $this->created_on_field." = UNIX_TIMESTAMP(NOW()) 
									  WHERE ".$this->field_id."='".$this->inputs[$this->field_id]->value."'");
				}
				if($this->created_by_field){
					$db->doSql("UPDATE ".$this->table." SET ".
									  $this->created_by_field." = '".$this->person_name."' 
									  WHERE ".$this->field_id."='".$this->inputs[$this->field_id]->value."'");
				}
			}
			if($this->updated_on_field){
				$db->doSql("UPDATE ".$this->table." SET ".
								  $this->updated_on_field." = UNIX_TIMESTAMP(NOW()) 
								  WHERE ".$this->field_id."='".$this->inputs[$this->field_id]->value."'");
			}
			
			if($this->updated_by_field){
				$db->doSql("UPDATE ".$this->table." SET ".
								  $this->updated_by_field." = '".$this->person_name."' 
								  WHERE ".$this->field_id."='".$this->inputs[$this->field_id]->value."'");
			}

		#Call AfterSavingValues for each item 
			foreach($this->inputs as $i){
				$this->inputs[$i->name]->AfterUpdateDatabase($db, $this->field_id, $this->inputs[$this->field_id]->value, $this->table);
			}
			
   			$this->db_updated = TRUE;
			$this->edit_mode = TRUE;
			$this->message = $this->object_name." saved.";
			
			if($insert_executed){
				# Call After insert function
				if($this->executeAfterInsert){
					call_user_func($this->executeAfterInsert, $this);
				}
				# -------------------------				
			}else{
				# Call After update function
				if($this->executeAfterUpdate){
					call_user_func($this->executeAfterUpdate, $this);
				}
				# -------------------------				
			}
			
			
			return TRUE;
	}
	
	function SetError($p_new_message = FALSE){
		$this->is_valid = FALSE;
		if($p_new_message){
			$this->message = $p_new_message;
		}
	}
	
	function DeleteRecord($db){
		$id = $this->GetInputId();
		if($id->value >0){
			foreach($this->inputs as $i){
				$this->inputs[$i->name]->DeleteRecord($db, $this->field_id, $this->inputs[$this->field_id]->value, $this->table);
			}
			
			$db->deleteRow($this->table, $this->field_id, $id->value);
		}
	}
	
	function SetInvalidInput($p_inputname, $p_inputmsg){
		$this->inputs[$p_inputname]->is_valid = FALSE;
		$this->inputs[$p_inputname]->errorMsg = $p_inputmsg;
		$this->is_valid = FALSE;
	}
	
	function AddErrorsInDisplay($before_error = "", $after_error=""){
		foreach($this->inputs as $i){
			if(!$i->is_valid){
				$this->inputs[$i->name]->display = $this->inputs[$i->name]->display.$before_error.
												   "<p class=\"input_error\">".$i->errorMsg."</p>".$after_error;
			}
		}
		
	}

	function ChangeEnable($val){
		foreach($this->inputs as $i){
			$this->inputs[$i->name]->enable = $val;
		}
		
	}

	function ReadDatabase($db, $update_values = FALSE){
		if($this->table && $this->field_id && $this->inputs[$this->field_id]->value){
			$sql = "SELECT * FROM ".$this->table." WHERE ".$this->field_id." = '".$this->inputs[$this->field_id]->value."'";
			$rs  = $db->createRecordset($sql);
			$db_values = $db->fetchArray($rs);

			$this->SetCurrentValues($db_values, $db, $this->inputs[$this->field_id]->value);
			$this->edit_mode = TRUE;
		}
		if($update_values){
			$this->GetValuesFromArray($db_values);
		}
		
		return $db_values;
		
	}
	
	function Process($db){
		$this->GetValuesFromRequest($db);
		#Read data from table
		$db_values = $this->ReadDatabase($db);
   		if(form_isset("submitted")){
    		$this->Validate();
    		if($this->is_valid){
    			$this->UpdateDatabase($db);
    		}else{
				$this->message = $this->error_message;
			}
   		}else{
    		$this->GetValuesFromArray($db_values);
			$this->LoadingDataFromTable($db);
   		}
		$this->SetInputsDisplay();
	}
}

Class Input{
	
	var $name      = "";
	var $display   = "";
	var $value     = "";
	var $label     = "";
	var $required  = FALSE;
	var $errorMsg  = "";
	var $is_valid  = TRUE;
	var $focus     = FALSE;
	var $hidden    = FALSE;
	var $field_name = FALSE;
	var $update_db = TRUE;
	var $ignore_amps = FALSE;
	var $do_not_show = FALSE;
	var $max_chars   = FALSE;
	var $min_chars   = FALSE;
	var $fixed_chars = FALSE;
	
	var $enable    = TRUE;
	var $ignore_request_value = FALSE;
	
	var $onChangeEvent = "";
	var $onClickEvent  = "";
	var $onKeyUpEvent = "";
	var $onblurEvant = "";
	var $required_message = "This field is required";
	
	var $default_value = "";
	var $description = FALSE;
	
	function Init(){
		$this->field_name = $this->name;
	}
	
	function Input($p_name, $p_label = ""){
		$this->name    = $p_name;
		$this->value   = $p_value;
		$this->label   = $p_label;
		
		$this->Init();
	}
	
	function SetValue($p_val){
		$this->value = stripslashes($p_val);
	}
	
	function Validate(){
		$rez = TRUE;
		if($this->value == "" && $this->required){
			$this->is_valid = FALSE;		
			$this->errorMsg = $this->required_message;
			$rez            = FALSE;
		}elseif($this->min_chars && (strlen($this->value) < $this->min_chars)){
			$this->is_valid = FALSE;		
			$this->errorMsg = "Minumum characters required is ".$this->min_chars;
			$rez            = FALSE;
		}elseif($this->max_chars && (strlen($this->value) > $this->max_chars)){
			$this->is_valid = FALSE;		
			$this->errorMsg = "Maximum characters allowed is ".$this->max_chars;
			$rez            = FALSE;
		}elseif($this->fixed_chars && (strlen($this->value) != $this->fixed_chars)){
			$this->is_valid = FALSE;		
			$this->errorMsg = "Value must have ".$this->fixed_chars." characters";
			$rez            = FALSE;
		}
		
		return $rez;
	}
	
	function GetValueFromRequest(){
		if(!form_isset($this->name)){
			$this->SetValue($this->default_value);
		}else{
			$this->SetValue(stripslashes(_form_gp($this->name)));
		}
	}
	
	function SetCurrentValue($p_current_val){
	}
	
	function BeforeUpdateDatabase(){
	}

	function AfterUpdateDatabase(){
	}

	function DeleteRecord(){
	}

	function LoadingDataFromTable(){
	}
	
}

Class InputText extends Input{

	var $maxlength = 200;
	var $size      = 25;
	var $regex_validations = array();
	
	function AddRegexValidation($regex, $message){
		$this->regex_validations[] = array("regex" => $regex, "message" => $message);
	}
	
	function Validate(){
		Input::Validate();
		
		if(!$this->is_valid) return FALSE;
		
		if(sizeof($this->regex_validations) > 0 && ($this->value != "")){
			foreach($this->regex_validations as $v){
				if(!preg_match($v["regex"], $this->value)){
					$this->is_valid = FALSE;
					$this->errorMsg = $v["message"];
					return FALSE;
				}
			}
		}
		return TRUE;
	}
	
	function SetDisplay(){
		$disable = ($this->enable)? "" : " disabled ";
		$html  = "<input type=\"text\" onChange=\"".$this->onChangeEvent."\" onClick=\"".$this->onClickEvent."\" name=\"".$this->name."\"  id=\"".$this->name."\" value=\"".html_escapeHTML($this->value, $this->ignore_amps)."\" ";
		$html .= "maxlength=\"".$this->maxlength."\"  size=\"".$this->size."\" $disable />";	
		$this->display = $html;
	}
}

Class InputPassword extends InputText{

	function SetDisplay(){
		$disable = ($this->enable)? "" : " disabled ";
		$html  = "<input type=\"password\" onChange=\"".$this->onChangeEvent."\" onClick=\"".$this->onClickEvent."\" name=\"".$this->name."\"  id=\"".$this->name."\" ";
		$html .= "maxlength=\"".$this->maxlength."\"  size=\"".$this->size."\" $disable />";	
		$this->display = $html;
	}
}

Class InputDisplay extends Input{
	function GetValueFromRequest(){
		$this->value = $this->default_value;
	}

	function SetDisplay(){
		$html = nl2br($this->value);	
		$this->display = $html;
	}
}

Class InputSelect extends Input{

	var $select_values = array();
	var $all_values = array();
	var $strin="";
	
	function SetDisplay(){
		$disable = ($this->enable)? "" : " disabled ";
	
		$html = "<select name=\"".$this->name."\" id=\"".$this->name."\" onChange=\"".$this->onChangeEvent."\" onClick=\"".$this->onClickEvent."\" $disable>";
		
		if(is_array($this->select_values)){
			foreach($this->select_values as $val){
				$html .= "<option value=\"".$val["value"]."\" ".
						($this->value == $val["value"]? "selected" : "").">".$val["text"]."</option>";
			}
		}
		
		$html .="</select>";	
		$this->display = $html;
	}
	
	function AddValuesFromTable($db, $table, $field_id, $text_field, $order_by=FALSE){
		$sql = "SELECT $field_id value, $text_field text FROM $table ".(($order_by)? "ORDER BY $order_by" : "");
		$rs = $db->createRecordset($sql);
		$values = $db->fetchAll($rs);		
		if(is_array($this->select_values)){
			$this->select_values = array_merge($this->select_values, $values);
		}else{
			$this->select_values = $values;
		}
	}

	function AddSelectedValuesFromTable($db, $table, $field_id, $text_field, $where_key, $where_value, $order_by=FALSE){
		//if(!is_array($where_value))
		//{
			$sql = "SELECT $field_id value, $text_field text FROM $table WHERE $where_key = ".$where_value." ".(($order_by)? "ORDER BY $order_by" : "");
			//echo $sql;
		//}
		/*else
		{
			$sql = "SELECT $field_id value, $text_field text FROM $table WHERE $where_key = ";
			for($i=0; $i<count($where_value); $i++)
			{
				if($i==0)
				{
					$sql .= $where_value[$i];
				}
				else
				{
					$sql .= " AND $where_key = ".$where_value[$i];
				}
			}
		}*/
		$rs = $db->createRecordset($sql);
		$values = $db->fetchAll($rs);		
		if(is_array($this->select_values)){
			$this->select_values = array_merge($this->select_values, $values);
		}else{
			$this->select_values = $values;
		}
	}

	function AddSelectedValuesFromTable1($db, $table1, $field_id1, $table2, $field_id2, $text_field, $where_key, $where_value, $order_by=FALSE){
		//if(!is_array($where_value))
		//{
	$sql1 = "SELECT primary_town_id FROM department_area_relation WHERE department_id =".$where_value;
	$rs1 = $db->createRecordset($sql1);
	$ptown_id = $db->fetchAll($rs1);
	$count = 0;
	$ptown = "";
	foreach($ptown_id as $val)
	{
		if((count($ptown_id)-1) == $count)
		{
			$ptown .= "'".$val["primary_town_id"]."'"; 
		}
		else
		{
			$ptown .= "'".$val["primary_town_id"]."'".", "; 
		}
		$count++;
	}	
	if($ptown == "")
	$ptown = "'0'";
		
			$sql = "SELECT DISTINCT(tab1.$field_id1) value, 
						   tab1.$text_field text 
				      FROM $table1 tab1 
				 LEFT JOIN $table2 tab2 
				 	    ON tab1.$field_id1 = tab2.$field_id2 
					 WHERE tab2.$where_key IN(".$ptown.") ".(($order_by)? "ORDER BY tab1.$order_by" : "");
			//echo $sql;
		//}
		/*else
		{
			$sql = "SELECT $field_id value, $text_field text FROM $table WHERE $where_key = ";
			for($i=0; $i<count($where_value); $i++)
			{
				if($i==0)
				{
					$sql .= $where_value[$i];
				}
				else
				{
					$sql .= " AND $where_key = ".$where_value[$i];
				}
			}
		}*/
		$rs = $db->createRecordset($sql);
		$values = $db->fetchAll($rs);		
		if(is_array($this->select_values)){
			$this->select_values = array_merge($this->select_values, $values);
		}else{
			$this->select_values = $values;
		}
	}

	function AddValueFirst($p_val, $p_text){
		if(is_array($this->select_values)){
			$this->select_values = array_merge(array(array("value" => $p_val, "text" => $p_text)), $this->select_values);
		}else{
			$this->select_values = array(array("value" => $p_val, "text" => $p_text));
		}
	}

	function AddValueLast($p_val, $p_text){
		if(is_array($this->select_values)){
			$this->select_values = array_merge($this->select_values, array(array("value" => $p_val, "text" => $p_text)));
		}else{
			$this->select_values = array(array("value" => $p_val, "text" => $p_text));
		}
	}
	
	function AddValuesFromArray($p_arr){
		foreach($p_arr as $v){
			if(is_array($v)){
				$this->select_values = array_merge($this->select_values, $p_arr) ;
				break;
			}else{
				$this->select_values[] = array("value" => $v, "text" => $v);
			}
		}
	}
	
	function Validate(){
		$rez = TRUE;
		if($this->value == "" && $this->required){
			#Check if value is empty
			$this->errorMsg = "This field is required";
			$this->is_valid = FALSE;		
			$rez            = FALSE;
			
		}elseif(isset($this->select_values)){
			#Check if value is in values array 
			$found = FALSE;
			foreach($this->select_values as $val){
				if($val["value"] == $this->value){
					$found = TRUE;
					break;
				}
			}
			if(!$found){
				$this->errorMsg = "Invalid value";
				$this->is_valid = FALSE;
				$rez            = FALSE;
			}
		}
		return $rez;
	}
}

Class InputSelectMultiple extends Input{

	var $selected_values = array();
	var $select_values = array();
	var $all_values = array();
	var $strin="";
	
	function SetDisplay(){
		$disable = ($this->enable)? "" : " disabled ";
	
		$html = "<select name=\"".$this->name."[]"."\" id=\"".$this->name."\" onChange=\"".$this->onChangeEvent."\" onClick=\"".$this->onClickEvent."\" $disable multiple>";
		
		if(is_array($this->select_values)){
			$p_values = $this->selected_values;
			$arr = $this->select_values;
			for($i = 0; $i<count($this->select_values); $i++)
			{
				$check = FALSE;
				for($j = 0; $j<count($p_values); $j++)
				{
					if($this->select_values[$i]["value"] == $p_values[$j][0])
					{
						$check = TRUE;
					}
				
				}
				$html .= "<option value=\"".$this->select_values[$i]["value"]."\" ".
						($check ? "selected" : "").">".$this->select_values[$i]["text"]."</option>";
			}
		}
		
		$html .="</select>";
		$this->display = $html;
	}
	
	function AddValuesFromTable($db, $table, $field_id, $text_field, $order_by=FALSE, $selected_values){
		$sql = "SELECT $field_id value, $text_field text FROM $table ".(($order_by)? "ORDER BY $order_by" : "");
		$rs = $db->createRecordset($sql);
		$values = $db->fetchAll($rs);
		$this->selected_values = $selected_values;	
		if(is_array($this->select_values)){
			$this->select_values = array_merge($this->select_values, $values);
		}else{
			$this->select_values = $values;
		}
	}
	
	/*function AddSelectedValuesFromTable($db, $table, $field_id, $text_field, $order_by=FALSE, $values)
	{
	
	}*/
	
	function AddSelectedValuesFromTable($db, $table, $field_id, $text_field, $where_key, $where_value, $order_by=FALSE){
		//if(!is_array($where_value))
		//{
			$sql = "SELECT $field_id value, $text_field text FROM $table WHERE $where_key = ".$where_value." ".(($order_by)? "ORDER BY $order_by" : "");
			//echo $sql;
		//}
		/*else
		{
			$sql = "SELECT $field_id value, $text_field text FROM $table WHERE $where_key = ";
			for($i=0; $i<count($where_value); $i++)
			{
				if($i==0)
				{
					$sql .= $where_value[$i];
				}
				else
				{
					$sql .= " AND $where_key = ".$where_value[$i];
				}
			}
		}*/
		$rs = $db->createRecordset($sql);
		$values = $db->fetchAll($rs);		
		if(is_array($this->select_values)){
			$this->select_values = array_merge($this->select_values, $values);
		}else{
			$this->select_values = $values;
		}
	}

	function AddValueFirst($p_val, $p_text){
		if(is_array($this->select_values)){
			$this->select_values = array_merge(array(array("value" => $p_val, "text" => $p_text)), $this->select_values);
		}else{
			$this->select_values = array(array("value" => $p_val, "text" => $p_text));
		}
	}

	function AddValueLast($p_val, $p_text){
		if(is_array($this->select_values)){
			$this->select_values = array_merge($this->select_values, array(array("value" => $p_val, "text" => $p_text)));
		}else{
			$this->select_values = array(array("value" => $p_val, "text" => $p_text));
		}
	}
	
	function AddValuesFromArray($p_arr){
		foreach($p_arr as $v){
			if(is_array($v)){
				$this->select_values = array_merge($this->select_values, $p_arr) ;
				break;
			}else{
				$this->select_values[] = array("value" => $v, "text" => $v);
			}
		}
	}
	
	/*function Validate(){
		$rez = TRUE;
		if($this->value == "" && $this->required){
			#Check if value is empty
			$this->errorMsg = "This field is required";
			$this->is_valid = FALSE;		
			$rez            = FALSE;
			
		}elseif(isset($this->select_values)){
			#Check if value is in values array 
			$found = FALSE;
			foreach($this->select_values as $val){
				if($val["value"] == $this->value){
					$found = TRUE;
					break;
				}
			}
			if(!$found){
				$this->errorMsg = "Invalid value";
				$this->is_valid = FALSE;
				$rez            = FALSE;
			}
		}
		return $rez;
	}*/
}

Class InputCheck extends Input{

	var $yes = "";
	var $no  = "";

	function SetDisplay(){
		$disable = ($this->enable)? "" : " disabled ";
		$html = "<input type=\"checkbox\" name=\"".$this->name."\" onChange=\"".$this->onChangeEvent."\" onClick=\"".$this->onClickEvent."\" id=\"".$this->name."\" ".
			    (($this->value == $this->yes) ? "checked" : "")." $disable />";	
		$this->display = $html;
	}
	
	function SetValidValues($p_yes, $p_no){
		$this->yes = $p_yes;
		$this->no  = $p_no;
	}
	
	function SetValue($p_val){
		if($p_val == "on" || $p_val == $this->yes){
			$this->value = $this->yes;
		}else{
			$this->value = $this->no;
		}
	}
}

Class InputTextArea extends Input{

	var $maxlength = 2;
	var $cols      = 35;
	var $rows      = 4;
	var $css_file = "main.css";
	var $xml_file = "styles.xml";
	
	var $base_url = TRUE;

	var $xstandard = FALSE;
	var $xstandard_path = "";
	var $width = 600;
	var $height = 400;
	var $xstandard_base = "";
	
	var $fckeditor = FALSE;
	
	var $manage_img_src = FALSE;
	
	function SetDisplay(){
	
		$disable = ($this->enable)? "" : " disabled ";
		if($this->manage_img_src){
			$this->value = html_addImgPaths($this->value, $this->base_url);
		}
	
		if($this->xstandard){
    		$html = '<object type="application/x-xstandard" id="'.$this->name.'" name="'.$this->name.'" 
			width="'.$this->width.'" height="'.$this->height.'">
    		<param name="Value" value="'.htmlentities($this->value).'" />
    		<param name="CSS" value="'.$this->xstandard_path.'/'.$this->css_file.'" />
    		<param name="Styles" value="'.$this->xstandard_path.'/'.$this->xml_file.'" />
		
    		<param name="ClassImageFloatLeft" value="left" />
    		<param name="ClassImageFloatRgt" value="right" />
    		<param name="Base" value="'.$this->xstandard_base.'" />
		
    		</object>';
		}elseif($this->fckeditor){
			
			require_once("FCKeditor/fckeditor.php");
			
			$oFCKeditor = new FCKeditor($this->name) ;
			$oFCKeditor->BasePath = WEB_ROOT_ADMIN."/FCKeditor/" ;
			
			$oFCKeditor->Value = $this->value;
			$oFCKeditor->ToolbarSet = "Custom";
			$oFCKeditor->Height = $this->height;
			$oFCKeditor->Width = $this->width;
			$html = $oFCKeditor->CreateHtml() ;

			
		}else{
			$html  = "<textarea type=\"text\" name=\"".$this->name."\" onChange=\"".$this->onChangeEvent."\" onKeyUp=\"".$this->onKeyUpEvent."\" onClick=\"".$this->onClickEvent."\" id=\"".$this->name."\" ";
			$html .= " maxlength=\"".$this->maxlength."\" cols=\"".$this->cols."\" rows=\"".$this->rows."\" $disable >";
			$html .= $this->value."</textarea>";	
		}
		$this->display = $html;
	}

	function SetValue($p_value){
		Input::SetValue($p_value);

		if($this->manage_img_src){
			$this->value = html_removeImgPaths($this->value);
		}
	}
	
}

Class InputHidden extends Input{
	
	var $hidden = TRUE;
	var $html_visible = TRUE;
	
	function SetDisplay(){
		if ($this->html_visible) {
			$html  = "<input type=\"hidden\" name=\"".$this->name."\" id=\"".$this->name."\" value=\"".$this->value."\" />";	
		}else{
			$html  = "";
		}
		$this->display = $html;
	}
}

Class InputInvisible extends Input{
	
	var $hidden = TRUE;
	
	function SetDisplay(){
		$this->display = "";
	}
}

Class InputFile extends Input{

	var $base_url = "";
	var $base_path = "";
	var $new_value     = "";
	var $remove_text   = "Remove current file";
	var $show_remove   = TRUE;
	var $valid_extensions = FALSE;
		
	function SetDisplay(){
		$disable = ($this->enable)? "" : " disabled ";
		if($this->value != ""){
			$html  = "<a target=\"_blank\" class=\"attached-file\" href=\"".$this->base_url."/".$this->value."\" />".$this->value."</a>";	
			$html  .= " <br /><input type=\"checkbox\" name=\"".$this->name."_remove\"  id=\"".$this->name."_remove\" $disable /> ".$this->remove_text;	
		}else{
			$html  = "<input type=\"file\" name=\"".$this->name."\"  id=\"".$this->name."\" $disable />";
		}
		$this->display = $html;
	}

	function GetValueFromRequest($array = FALSE, $name = FALSE){
		if($array && $name){
			if(is_uploaded_file($_FILES[$array]['tmp_name'][$name])){
				$this->new_value = $_FILES[$array]['name'][$name];
			}
		}else{
			if(is_uploaded_file($_FILES[$this->name]['tmp_name'])){
				$this->new_value = $_FILES[$this->name]['name'];
			}
		}
	}

	function SetCurrentValue($p_current_val){
		$this->SetValue($p_current_val);
	}
	
	function Validate(){
		$rez = TRUE;
		if($this->value == "" && $this->required && $this->new_value == ""){
			$this->is_valid = FALSE;		
			$this->errorMsg = "This field is required";
			$rez            = FALSE;
		}elseif(($this->new_value !== "") && 
		        ($this->valid_extensions) &&
				!file_hasExtensions($this->new_value, $this->valid_extensions)){
			$this->is_valid = FALSE;		
			$is_are = (sizeof($this->valid_extensions) > 1) ? "types are: " : "type is ";
			$this->errorMsg = "Invalid file type. Accepted file $is_are".join(", ", $this->valid_extensions);
			$rez            = FALSE;
		}
		
		return $rez;
	}

	function BeforeUpdateDatabase(){
		if($this->new_value != ""){
			$this->RemoveCurrentFile();
			$this->SetValue($this->new_value);
			$this->MoveNewFile();
		}elseif(form_isset($this->name."_remove")){
			$this->RemoveCurrentFile();
			$this->SetValue("");
		}
	}	

	function RemoveCurrentFile(){
		$file = $this->base_path."/".$this->value;
		if(file_exists($file)){
			@unlink($file);
		}
	}

	function MoveNewFile(){
		$this->value = file_uniqueName($this->base_path, $this->value);
		$file = $this->base_path."/".$this->value;
		copy($_FILES[$this->name]["tmp_name"], $file);
	}
	
	function DeleteRecord(){
		$this->RemoveCurrentFile();
	}
}

class InputImage extends InputFile{
	
	var $max_image_size   = 2000000;
	var $max_image_width  = FALSE;
	var $max_image_height = FALSE;
	var $remove_text   = "Remove current picture";
	var $fixed = FALSE;
	var $resize = FALSE;

	var $msg_file_size = "";
	var $msg_file_type = "";
	var $msg_pic_dimensions = "";
	var $msg_pic_dimensions_fixed = "";

	var $valid_extensions = array("JPG", "GIF", "PNG");

	function SetMessages(){
		if(!$this->msg_file_size){
			$this->msg_file_size = "The size of the file exceeds the max allowed size. (max size: ".$this->max_image_size." B)";
		}
		if(!$this->msg_file_type){
			$this->msg_file_type = "This is an invalid image type or the file is corrupted";
		}
		if(!$this->msg_pic_dimensions){
			$this->msg_pic_dimensions  = "Picture dimensions of uploaded image are invalid (";
			$this->msg_pic_dimensions .= ($this->max_image_width > 0) ? " max width: ".$this->max_image_width." px" : "";
			$this->msg_pic_dimensions .= ($this->max_image_height > 0) ? " max height: ".$this->max_image_height." px" : "";
			$this->msg_pic_dimensions .= ")";
		}
		if(!$this->msg_pic_dimensions_fixed){
			$this->msg_pic_dimensions_fixed  = "Picture dimensions of uploaded image are invalid the image should have exactly ";
			$this->msg_pic_dimensions_fixed .= ($this->max_image_width > 0) ? " width: ".$this->max_image_width." px" : "";
			$this->msg_pic_dimensions_fixed .= ($this->max_image_height > 0) ? " height: ".$this->max_image_height." px" : "";
		}
	}
	
	function Validate(){
		$rez = TRUE;
		$this->SetMessages();
		
	#Default validation
		InputFile::Validate();
		if(!$this->is_valid){
			return FALSE;
		}
	#Check file size
		if(!$this->resize){
			$file = $_FILES[$this->name]['tmp_name'];
			if(is_uploaded_file($file)){
				if((filesize($file) > $this->max_image_size) && $this->max_image_size){
					$this->is_valid = FALSE;		
					$this->errorMsg = $this->msg_file_size;
					$rez            = FALSE;
				}else{
					$img_size = @getimagesize($file);
					if(!$img_size){
						$this->is_valid = FALSE;		
						$this->errorMsg = $this->msg_file_type;
						$rez            = FALSE;
					}elseif($this->fixed 
						 && (($this->max_image_width && ($img_size[0] != $this->max_image_width))
						 || ($this->max_image_height && ($img_size[1] != $this->max_image_height))
							)){
						$this->is_valid = FALSE;		
						$this->errorMsg = $this->msg_pic_dimensions_fixed;
						$rez            = FALSE;
					}elseif(
							($this->max_image_width && ($img_size[0] > $this->max_image_width))
						 || ($this->max_image_height && ($img_size[1] > $this->max_image_height))){
						$this->is_valid = FALSE;		
						$this->errorMsg = $this->msg_pic_dimensions;
						$rez            = FALSE;
					}
				}
			}
		}

		
		return $rez;
	}
	
	function SetDisplay(){
		$disable = ($this->enable)? "" : " disabled ";
		if($this->value != ""){
			$html  = "<img src=\"".$this->base_url."/".$this->value."\" />";	
			$html  .= "<br /><input type=\"checkbox\" name=\"".$this->name."_remove\"  id=\"".$this->name."_remove\" $disable /> ".$this->remove_text;	
		}else{
			$html  = "<input type=\"file\" name=\"".$this->name."\"  id=\"".$this->name."\" $disable />";	
		}
		$this->display = $html;
	}
	
	function MoveNewFile(){
		InputFile::MoveNewFile();
		if($this->resize && $this->max_image_width){
			$file = $this->base_path."/".$this->value;
			image_makeThumbnail($file, $file, $this->max_image_width);
		}
	}


}

Class InputSubmit extends Input{

	function SetDisplay(){
		$disable = ($this->enable)? "" : " disabled ";
		$html  = "<input type=\"submit\" default name=\"".$this->name."\"  id=\"".$this->name."\" value=\"".$this->value."\" $disable />";	
		$this->display = $html;
	}
	
	function SetValue($p_value){
		if($p_value != ""){
			$this->value = $p_value;
		}
	}
}

Class InputMultipleCheck extends InputSelect{

	var $display_columns = 4;
	var $values = array();
	var $connection_table = FALSE;
	var $connection_field = FALSE;

	function SetDisplay(){
		$disable = ($this->enable)? "" : " disabled ";
		$html = "<table><tr>";
		for($i=0; $i<sizeof($this->select_values); $i++){
			if(($i % $this->display_columns) == 0 && ($i > 0)){
				$html .= "</tr><tr>";
			}
			$v = $this->select_values[$i];
			$checked = is_array($this->values) ? ((in_array($v["value"], $this->values)) ? "checked": "") : "";
			
			$html  .= "<td><input type=\"checkbox\" name=\"".$this->name."[".$v["value"].
					 "]\"  id=\"".$this->name."[".$v["value"]."]\" $checked $disable /> ".$v["text"]."</td>";	
		}
		$html .= "</tr></table>";
		$this->display = $html;
	}

	function GetValueFromRequest(){
		if(!form_isset($this->name) && is_array($this->default_value)){
			foreach($this->default_value as $v){
				$values[$v] = "on";
			}
		}else{
			$values = _form_gp($this->name);
		}
		if(is_array($values)){
			$values = array_keys($values);
			$this->values = $values;
		}
	}	

	function Validate(){
		$rez = TRUE;
		if(sizeof($this->values) == 0 && $this->required){
			#Check if value is empty
			$this->errorMsg = "This field is required";
			$this->is_valid = FALSE;		
			$rez            = FALSE;
			
		}elseif(isset($this->select_values)){
			#Check if values are in values array 
			$all_correct = TRUE;
/*			foreach($this->values as $val){
				if(!in_array($val, $this->select_values)){
					echo $val." - ";
					$all_correct = FALSE;
					break;
				}
			}*/
			if(!$all_correct){
				$this->errorMsg = "Invalid value(s)";
				$this->is_valid = FALSE;
				$rez            = FALSE;
			}
		}
		return $rez;
	}

	function AfterUpdateDatabase($db, $field_id, $field_id_value, $table_name){
		if($this->connection_table && $this->connection_field && $this->connection_field_id){
	       	if(sizeof($this->values) > 0){
	       	    $db->updateConnectionTable($this->connection_table, $this->connection_field, 
										   $field_id, $field_id_value, $this->values);
	       	}else{				
			    $db->deleteRow($this->connection_table, $field_id, $field_id_value);
			}
		}
	}

	function DeleteRecord($db, $field_id, $field_id_value, $table_name){
	    $db->deleteRow($this->connection_table, $field_id, $field_id_value);
	}
	
	function SetCurrentValue($value, $db, $field_id, $field_id_value){
		if(!form_isset("submitted")){
   			$sql = "SELECT ".$this->connection_field." FROM ".$this->connection_table." WHERE $field_id = $field_id_value";		
   			$rs  = $db->createRecordset($sql);
   			$this->values = $db->fetchColumn($rs, $this->connection_field);
		}
	}
	
}

Class InputImageList extends InputImage{
	
	//var $base_url = FALSE;
	//var $base_path = FALSE;
	var $display_columns = 4;
	var $default_width = 150;
	var $display_name = "PICTURE_";
	var $select_values = array();
	var $delete_values = FALSE;
	
	var $connection_table = FALSE;
	var $connection_field = FALSE;
	var $connection_field_id = FALSE;
	
	var $show_note  = TRUE;
	var $add_tag_in = FALSE;
	var $add_tag_xstandard = FALSE;
	var $add_tag_fckeditor = FALSE;
	
	var $updateable = TRUE;	
	
	var $content_area_name = "Body";
	var $note = FALSE;
	
	function SetNote(){
		if(!$this->note){
			if($this->add_tag_xstandard){
				$this->note = "<b>Note:</b> Click an image to be added in \"".$this->content_area_name."\" content. 
							 <br />The image will be added at the begining of the \"".$this->content_area_name."\" and then you can drag 
							 and drop it.";
			}elseif($this->add_tag_fckeditor){
				$this->note = "<b>Note:</b> Click an image to be added in \"".$this->content_area_name."\" content. 
							 <br />The image will be added at cursor position.";
			}
		}
	}				 
	
	function GetValueFromRequest(){	
		#Get the new file if one uploaded
		if(is_uploaded_file($_FILES[$this->name]['tmp_name'])){
			$this->value = $_FILES[$this->name]['name'];
		}
	}	

	function SetDisplay(){
		$this->SetNote();

		$disable = ($this->enable)? "" : " disabled ";

		if(sizeof($this->select_values) > 0){
			$html .= "<table border=\"0\" width=\"100%\"id=\"image-list\"><tr>";

			if($this->show_note && $this->add_tag_in){
				$html .= "<td colspan=\"".$this->display_columns."\"><p class=\"note\">".$this->note."</p></td></tr><tr>";
			}

			for($i=0; $i<sizeof($this->select_values); $i++){
				if((($i % $this->display_columns) == 0) && ($i > 0)){
					$html .= "</tr><tr>";
				}
				$f = $this->select_values[$i];
				
				$size = image_resize($this->base_path."/".$f["text"], $this->default_width, $this->default_width);
				$size = "width=\"".$size["width"]."\" height=\"".$size["height"]."\"";
				
				if($this->add_tag_in){
					if($this->add_tag_xstandard){
						$img_tag = "<img height= src=\'".$f["text"]."\' class=\'left\' alt=\'\' />";
						$onclick = " onclick=\"addContent('".$this->add_tag_in."', '$img_tag'); return false;\"";
						$anchor_start = "<a href=\"javascript:void(0)\" $onclick>";
						$anchor_end = "</a>";
					}elseif($this->add_tag_fckeditor){
						
						$img_size = image_getSize($this->base_path."/".$f["text"]);
						if($img_size){
							$html_size = "width=\'".$img_size[0]."\' height=\'".$img_size[1]."\' ";
						}
						
						$img_tag = "<img  $html_size src=\'".$this->base_url."/".$f["text"]."\' class=\'left\' alt=\'\' />";
						$onclick = " onclick=\"FCKeditor_insertHTML('".$this->add_tag_in."', '$img_tag'); return false;\"";
						$anchor_start = "<a href=\"javascript:void(0)\" $onclick>";
						$anchor_end = "</a>";
					}
				}else{
					$anchor_start = "";
					$anchor_end = "";
				}
				
				$html  .= "<td width=\"50%\">";
				if($this->updateable){
					$html  .= "<p class=\"remove-image\"><input type=\"checkbox\" name=\"".$this->name."_remove_image_".$f["value"]."\" /> Remove</p>";
				}
				$html  .= $anchor_start."<img src=\"".$this->base_url."/".$f["text"]."\" $size border=\"0\"/>$anchor_end<br />
						   </td>";	
			}
			$html .= "</tr></table>";
		}else{
			$html = "<b>No images uploaded</b><br />";
		}
		if($this->updateable){
			$html  .= "Add New <input type=\"file\" name=\"".$this->name."\"  id=\"".$this->name."\" $disable />";	
		}
		
		$this->display = $html;
	}

	function AfterUpdateDatabase($db, $field_id, $field_id_value){
		#Remove marked images
		if($this->connection_table){
		
			#Delete checked images from database 
			$this->delete_values = array();
			if($this->select_values){
				foreach($this->select_values as $v){
			 		if(form_isset($this->name."_remove_image_".$v["value"])){
			 			$this->delete_values[] = $v["value"];
			 		}
				}
			}
			
			foreach($this->delete_values as $i){
				$db->doSql("DELETE FROM ".$this->connection_table." WHERE $field_id = '$field_id_value'
							  AND ".$this->connection_field_id." = '".$i."'");
				$this->RemoveImage($i);
			}

			#Delete checked images from select_values
			$temp_values = array();
			for($i=0; $i < sizeof($this->select_values); $i++){
				if(!in_array($this->select_values[$i]["value"], $this->delete_values)){
					$temp_values[] = $this->select_values[$i];
				}
			}
			$this->select_values = $temp_values;
			
			if($this->value !=""){
				#Add new image if uploaded
				$this->MoveNewFile();
				$db->InsertFields($this->connection_table, array($field_id, $this->name), 
															 array($field_id_value, $this->value));
				$this->select_values[] = array("value" => $db->getIdentity(), "text" => $this->value);
			}
		}
		if(!$this->updateable){
			$this->SetCurrentValue("", $db, $field_id, $field_id_value);
		}

	}
	
	function RemoveImage($value){
		foreach($this->select_values as $t){
			if($t["value"] == $value){
				$file = $this->base_path."/".$t["text"];
			}
		}
		if(file_exists($file)){
			@unlink($file);
		}
	}

	function DeleteRecord($db, $field_id, $field_id_value, $table_name){
		foreach($this->select_values as $t){
			$file = $this->base_path."/".$t["text"];
			if(is_file($file)){
				@unlink($file);
			}
		}
		$db->doSql("DELETE FROM ".$this->connection_table." WHERE $field_id = '$field_id_value'");
	}

	function SetCurrentValue($value, $db, $field_id, $field_id_value){
		//if(!form_isset("submitted")){
   			$sql = "SELECT ".$this->connection_field_id." value, ".$this->connection_field." text FROM ".
				   $this->connection_table." WHERE $field_id = '$field_id_value'";		
   			$rs  = $db->createRecordset($sql);
   			$this->select_values = $db->fetchAll($rs);
		//}
	}
	
}

Class InputDate extends Input{

	var $day   = 0;
	var $month = 0;
	var $year  = 0;
	
	var $years_before = 1;
	var $years_after  = 1;
	
	var $null_values = FALSE;

	function Init(){
		Input::Init();
		$this->day   = date("j");
		$this->month = date("n");
		$this->year  = date("Y");
		
		$this->value = 0;
		$this->default_value = time();
	}

	function GetValueFromRequest(){	
		if(!form_isset($this->name."_day") && !form_isset($this->name."_month") && !form_isset($this->name."_year")){
			$this->value = $this->default_value;
		}else{
			$this->day = form_int($this->name."_day", $this->day);
			$this->month = form_int($this->name."_month", $this->month);
			$this->year = form_int($this->name."_year", $this->year);
			$this->value = mktime(0, 0, 0, $this->month, $this->day, $this->year);
		}
	}
	
	function Validate(){
		$rez = TRUE;
		if(!checkdate($this->month, $this->day, $this->year)){
			$this->errorMsg = "Invalid date";
			$this->is_valid = FALSE;		
			$rez            = FALSE;
		}else{
			$this->value = mktime(0, 0, 0, $this->month, $this->day, $this->year);
		}
		
		return $rez;
	}
	
	function SplitDate(){
		if($this->is_valid){
			$date = getdate($this->value);
			$this->day   = $date["mday"];
			$this->month = $date["mon"];
			$this->year  = $date["year"];
		}
	}
	
	function SetDisplay(){
		$this->SplitDate();		
		$disable = ($this->enable)? "" : " disabled ";
	
		$html  = "<select name=\"".$this->name."_month\" id=\"".$this->name."_month\" $disable >";
		$html .= ($this->null_values)? "<option value=\"\"></option>" : "";
		$html .= html_optionsFromArray(calendar_GetMonthsValues(), $this->month, calendar_GetMonthsLongNames());
		$html .="</select>";
		
		$html .= "<select name=\"".$this->name."_day\" id=\"".$this->name."_day\" $disable >";
		$html .= ($this->null_values)? "<option value=\"\"></option>" : "";
		$html .= html_optionsFromArray(calendar_GetDays(), $this->day);
		$html .="</select>";
		
		$html .= "<select name=\"".$this->name."_year\" id=\"".$this->name."_year\" $disable >";
		$html .= ($this->null_values)? "<option value=\"\"></option>" : "";
		$html .= html_optionsFromArray(calendar_GetYears($this->years_before, $this->years_after), $this->year);
		$html .="</select>";
		
		$this->display = $html;
	}
}

Class InputSeparator extends Input{
	
	var $separator = TRUE;
	
	function SetDisplay(){
		$html = $this->label;
		$this->display = $html;
	}
}

Class InputDetailsList extends Input{
	var $table = FALSE;
	var $field_id = FALSE;
	var $inputs = array();
	var $forms = array();
	
	var $order_by = FALSE;
	
	function AddInput($input){
		$this->inputs[$input->name] = $input;
	}
	
	function GetValueFromRequest($db){
		foreach($_REQUEST as $key => $value){
			$vdet = explode("_xx_", $key);
			if(sizeof($vdet) == 2 && $vdet[0] == $this->table){
				$this->CreateForm($vdet[1], $value);
			}
		}
	}

	function Validate(){
		$rez = TRUE;
		for($i=0; $i<sizeof($this->forms); $i++){
			$f = &$this->forms[$i];
			if(!form_isset("del_".$f->table."_xx_".$f->object_name)){
				$f->Validate();
				if(!$f->is_valid){
					$rez = FALSE;
					$f->AddErrorsInDisplay();
					$this->is_valid = FALSE;
				}
			}
		}
		
		return $rez;
	}
	
	function LoadingDataFromTable($db, $i, $field_id=FALSE, $field_id_value=FALSE){
		$fname = ($field_id)? $field_id : $i->name;
		$fvalue = ($field_id_value)? $field_id_value : $i->value;
		
		$sql  = "SELECT * FROM ".$this->table." WHERE ".$fname."= '".$fvalue."'";
		$sql .= ($this->order_by)? " ORDER BY ".$this->order_by : "";
		
		$rs = $db->createRecordset($sql);
		$rows = $db->fetchAll($rs);
		
		foreach($rows as $row){
			$this->CreateForm($row[$this->field_id], $row);
		}
	}
	
	function CreateForm($id, $values, $add = TRUE){
		$f =  new Form($id, $this->table, $this->field_id, FALSE);
		foreach($this->inputs as $i){
			$i->SetValue($values[$i->name]);
			$i->SetCurrentValue($values[$i->name]);
			$x = $i->name;
			if($x == "image"){
				$i->GetValueFromRequest($this->table."_xx_".$id, $i->name);
			}
			$i->name  = $this->table."_xx_".$id."[".$i->name."]";
			$f->AddInput($i);
		}
		if($add){
			$this->forms[] = $f;
		}else{
			return $f;
		}
	}
	
	
	
	function SetDisplay(&$main_form){
	
		if(form_isset($this->table."_add_new") 
			&& $this->is_valid
			&& $main_form->is_valid){
			$this->CreateForm("-1", array());
		}
		for($i=0; $i<sizeof($this->forms); $i++){
			$this->forms[$i]->SetInputsDisplay();
			$this->forms[$i]->AddErrorsInDisplay();
		}
	
   		$html .= "<table border=\"0\" cellspacing=\"2\" width=\"1\">";
		if(sizeof($this->forms) > 0){
    		$html .= "<tr>";
            foreach($this->inputs as $i){
				if($i->label){
            		$html .= "<td class=\"list-details-header\">".$i->label."</td>";
				}
            }
       		$html .= "<td class=\"list-details-header\">&nbsp;</td>";
    		$html .= "</tr>";
    		foreach($this->forms as $f){
    			$html .= "<tr>";
    			foreach($f->inputs as $i){
					if($i->label){
    					$html .= "<td class=\"list-details-data\">".$i->display."</td>";
					}else{
						$html .= $i->display;
					}
    			}
    			$html .= "<td class=\"list-details-data\"><input type=\"submit\" name=\"del_".
							$this->table."_xx_".$f->object_name."\" value=\"Del\" /></td></tr>";
    		}
		}
		$html .= "</table>";
		$html .= "<p class=\"list-details-add\"><input type=\"submit\" name=\"".$this->table."_add_new\" value=\"Add >>\"></p>";
		
		$this->display = $html;
	}
	
	function AfterUpdateDatabase($db, $field_id, $field_id_value){
		for($i=0; $i<sizeof($this->forms); $i++){
			$f = &$this->forms[$i];
			// Remove form if requested
			if(form_isset("del_".$f->table."_xx_".$f->object_name)){
				$db->deleteRow($this->table, $this->field_id, $f->object_name);
				array_splice($this->forms, $i, 1);
			}else{
				$input_id = &$f->GetInputWithField($field_id);
				$input_id->value = $field_id_value;
				$f->UpdateDatabase($db);
			}
		}
		$this->forms = array();
		$this->LoadingDataFromTable($db, null, $field_id, $field_id_value);

	}
	
}

#For dummy
function x($val, $die = 0){
	echo "<pre>";
	print_r($val);
	if($die){
		die();
	}
}

?>
