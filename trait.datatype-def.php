<?php
namespace VDM\Lib\DataTypes;

/* These traits Handle all property related function
 * 
 * -checking type
 * -checking len/size
 * -setting values
 * */

/* Brings all Property traits together*/
trait DataTypeDef {
		
	private $data_types;
	
	
	private function init_DataTypeDef(){
		$this->data_types = array();
		$this->set_datatypes();
	}
	
	/**
	 * Sets properties of data types
	 */
	protected function set_properties($max_length,$data_check,$phptype="string"){
		
		$properties['length'] = $max_length;
		$properties['data_check'] = $data_check;
		
		
		if(in_array($phptype, $this->php_types)){
			$properties['php_type'] = $phptype;
		}
		else {
			$properties['php_type'] = FALSE;
		}
		
		return $properties;
	}
	
	/**
	 * Sets sub type for path data types, aka arrays
	 * @param $sub_type identifies the data type the array key will hold
	 */
	protected function set_path_properties($sub_type){
		$properties['sub_type'] = $sub_type;
		return $properties; 
	}
	
	protected function set_filefolder_properties(){
		$properties['write'] = 0;
		$properties['read'] = 0;
		$properties['execute'] = 0;
		
		return $properties;
	}
	
	/**
	 * String data types
	 */
	private function str_datatypes(){
		
		$strings = array(
			'data_check' => 'check_string',
			'string' => $this->set_properties(STRING_SIZE,'check_string'),
			'varchar' => $this->set_properties(VARCHAR_SIZE,'check_string'),
			'text' => $this->set_properties(TEXT_SIZE,'check_string'),
		);
		
		$this->data_types = array_merge($this->data_types,$strings);
	}
	
	private function int_datatypes(){
		$ints = array(
			'int' => $this->set_properties(INT_SIZE,'check_int',"int"),
			'medint' => $this->set_properties(MEDINT_SIZE,'check_int',"int"),
			'smint' => $this->set_properties(SMINT_SIZE,'check_int',"int"),
			'tinint' => $this->set_properties(TININT_SIZE,'check_int',"int")
		);
		
		$this->data_types = array_merge($this->data_types,$ints);
	}
	
	private function bool_datatypes(){
		$bools = array(
			'true' => $this->set_properties(4,'check_bool'),
			'false' => $this->set_properties(5,'check_bool')
		);
		$this->data_types = array_merge($this->data_types,$bools);
	}
	
	private function filefolder_datatypes(){
		$dir_properties = $this->set_properties(MAXLEN_VAR,'check_dir');
		$path_properties = $this->set_path_properties('string');
		$file_properties = $this->set_properties(MAXLEN_VAR,'check_file');
		
		$files_folders = array(
			'dir' => array_merge($dir_properties,$path_properties),
			'file' => array_merge($file_properties,$path_properties),
		);
		
		$this->data_types = array_merge($this->data_types,$files_folders);
	}
	
	private function path_datatypes(){
		$properties = $this->set_properties(PATH_SIZE,'check_path');
		$path_properties = $this->set_path_properties('variable');
		
		$paths = array(
			'path' => array_merge($properties,$path_properties)
		);
		
		$this->data_types = array_merge($this->data_types,$paths);
	}
	
	private function url_datatypes(){
		$urls = array(
			'url' => $this->set_properties(URL_SIZE,'check_url')
		);
		$this->data_types = array_merge($this->data_types,$urls);
	}
	
	private function json_datatypes(){
		$json = array(
			'json' => $this->set_properties(20000,'check_json')
		);
		$this->data_types = array_merge($this->data_types,$json);
	}
	
	private function set_datatypes(){
		$this->str_datatypes();
		$this->int_datatypes();
		$this->bool_datatypes();
		$this->filefolder_datatypes();
		$this->path_datatypes();
		$this->url_datatypes();
		$this->json_datatypes();
	}

}




?>