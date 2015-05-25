<?php
namespace VDM\Lib\DataTypes;

/**
 * This trait ensures that the array containg vars conforms to 
 * the allowed parameters
 */

trait DataTypeChkVars {
	
	/**
	 * Checks that the array contains allowed keys and values
	 */
	private function chkvar($vars){
		$result = FALSE;
		
		if($this->chkvar_type_allowed($vars)){
			
			foreach ($vars as $key => $value) {
				
				if($value !== 'path' && $value !== 'dir' && $value !== 'url'){
					
					if($this->check_string($key,MAXLEN_VAR)){
						$result = TRUE;
					}
					else{
						$result = FALSE;
					}
				}
				//paths are used to identify array keys and must be checked differentlyy
				elseif ($value == 'path' || $value == 'dir' || $value == 'url') {
					
					if($this->check_path_var($key)){
						$result = TRUE;
					}
					else {
						$result = FALSE;
					}
					
				}
				
			}
		}
		else {
			$result = FALSE;
		}
		
		return $result;
	}
	
	private function chkvar_type_allowed($vars){
		$result = array_diff($vars, $this->allowed_types);
		
		//if result is greater than 0 there is an invalid data type in the array
		if(count($result)>0){
			return FALSE;
		}
		
		return TRUE;
	}
	
}

?>