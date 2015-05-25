<?php
namespace VDM\Lib\DataTypes;



/**
 * Checks all data coming in or out of the class
 */
trait DataChecks {
	
	protected $dir_hook;			//sets hooks for dir data checks functions
	
	/**
	 * Initializes trait
	 */
	private function init_DataChecks(){
		$this->dir_hook = null;
	}
	
	/**
	 * Check a string. Remove all characters that don't need to be checked then
	 * perform check on the remaining string
	 * @param $value String to check
	 * @param $max_len Maximum length the string is allowed to be
	 */
	private function check_aplhanum($value){
		/*
		 * remove chars that are allowed
		 * ASTRALL are chars any string can have
		 */
		$value = preg_replace('/('.VDM_ASTRALL.')/', '', $value);
		
		
		if(! ctype_alnum($value)){
			$this->dtstatus = "IS NOT alpha numeric";
			print_r($value);
			$result = FALSE;
		}
		else{
			$this->dtstatus = "IS alpha numeric";
			$result = TRUE;
		}
			
		//echo "Result for ${value} is -> ${result}<br>";
		return $result;
	}
	
	private function check_int(){
		return TRUE;
	}
	
	/**
	 * Checks that a path value matches one of the datatypes
	 */
	private function check_path($path_var){
		$variable = FALSE;
		
		if(is_int($path_var)){
			$variable = TRUE;
		}
		elseif($this->check_string($path_var)){
			$variable = TRUE;
		}
		elseif($this->check_json($path_var)){
			$variable = TRUE;
		}
		
		return $variable;
	}
	
	/**
	 * Check that components of a path are valid
	 */
	private function check_path_var($path){
		$path_check = explode('/',$path);
		$result = FALSE;
		
		//checks that max recursion is not excedded
		if(count($path_check)<=MAX_DEPTH){
			
			foreach ($path_check as $key => $path_val) {
				
				if(! $this->check_string($path_val,MAXLEN_VAR)){
					return FALSE;
				}
				else{
					$result = TRUE;
				}
			}
		}
		else {
			return FALSE;
		}
		
		return $result;
	}
	
	
	/**
	 * Remove chars that are not allowed by check_string to check options
	 * @param $path path to sanitize
	 */
	private function check_string($string){
		$string = preg_replace('/'.VDM_ASTR.'/', '', $string);
		return $this->check_aplhanum($string);	
	}
	
	private function check_file($file_path){
		$file_path = preg_replace('/('.VDM_AFILE.')/', '', $file_path);
		$file_path = preg_replace('/('.VDM_ADIR.')/', '', $file_path);
		return $this->check_string($file_path);
	}
	
	/**
	 * Checks dir path for correctness
	 * @param $dir_path directory path to check
	 */
	private function check_dir($dir_path){
		$dir_path = preg_replace('/('.VDM_ADIR.')/', '', $dir_path);
		return $this->check_string($dir_path);
	}
	
	private function check_url($url){
		
		if($this->basic_check($url)){
			return TRUE;
		}
		else {
			return FALSE;
		}
	}
	
	private function check_json($json){
		$json_string = preg_replace('/('.VDM_AJSON.')/', '', $json);
		$json_string = preg_replace('/('.VDM_AURL.')/', '', $json_string);
		$json_string = preg_replace('/('.VDM_AFILE.')/', '', $json_string);
		$json_string = preg_replace('/('.VDM_ADIR.')/', '', $json_string);
		
		return $this->check_string($json_string);
	}
}
?>