<?php
namespace VDM\Lib\DataTypes;

trait DataTypeChkVals {
	
	/**
	 * Checks the value being assigned to the vars array.
	 */
	private function chkvals($name, $value){
		$result = FALSE;
		$matches = array();
		//check if var has already been set
		if(array_key_exists($name, $this->vars)){
			
			//data type for the var
			$var_dt = $this->vars[$name];
			
			//properties for the data type
			$data_type = $this->data_types[$var_dt];
			
			//get max_len and function name to call to verify the var's value
			$max_len = $data_type['length'];
			$data_check = $data_type['data_check'];
			$php_type = $data_type['php_type'];
			
			$php_check = "is_${php_type}";
			
			//check the php type
			if($php_check($value) || is_null($value)){
				
				//check length
				if((is_string($value) && strlen($value) <= $max_len) || 
					(is_int($value) && $value <= $max_len))
				{
					//check for disallowed patterns
					if(preg_match('/'.VDM_DISALLOWED_PATTERNS.'/', $value,$matches) == 0){
						
						//check the var
						if($this->$data_check($value,$max_len)){
							
							$result = TRUE;
						}
					}
					else{
						$this->dtstatus = "Found disallowed chars";
						//print_r($matches);
					}
					
				}
				else{
					$this->dtstatus = "Exceeds max length ${max_len}";
				}
			}
			else{
				$this->dtstatus = "Data type does not match PHP type Is ${php_type}";
			}
		}
		
		return $result;
	}
}
?>