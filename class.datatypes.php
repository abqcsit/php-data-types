<?php
namespace VDM\Lib\DataTypes;

class DataTypes extends AbstArrayAccess {
	use DataTypeDef,DataTypeChkVars,DataTypeChkVals,DataChecks,DataTypePath,DataTypeUrl,ArrayPath;
	
	/**
	 * The vars this class will control. This is an array with the key
	 * being the name of the var and vale being the var type
	 */
	private $vars;
	protected $values=[];
	
	protected $allowed_types;			//array to hold list of allowed data types
	
	/**
	 * These allow inheriting classes to set callbacks to perform
	 * actions on getting and setting data
	 */
	protected $get_hook;
	protected $set_hook;
	
	private $php_types;
	
	
	function __construct(){
		$this->vars = array();
		$this->allowed_types = array();
		$this->get_hook = null;
		$this->set_hook = null;
		$this->php_types = explode(",", VDM_PHPTYPES);
		
		$this->init();
	}
	
	
	private function init(){
		$this->load_allowed_types();
		$this->init_DataTypeDef();
		$this->init_DataChecks();
	}
	
	/**
	 * Add vars to the $vars array
	 * @param $vars array of vars to add to the internal vars array
	 */
	protected function add_vars_public(array $vars){
		
		
		if($this->chkvar($vars)){
			$this->vars = array_merge($this->vars,$vars);
			return TRUE;
		}
		else {
			return FALSE;
		}
		
	}
	
	protected function load_allowed_types(){
		$this->allowed_types = explode(',', ALLOWED_DATATYPES);
	}
	
	private function do_callbacks($hook_name,$name,$value=null){
		
		if(is_null($value)){
			return call_user_func(array($this,$hook_name),$name);	
		}
		else {
			call_user_func(array($this,$hook_name),$name,$value);
		}
	}
	
	/**
	 * Check if the var name has been locked.
	 * Meaning it cannot be changed
	 */
	private function check_lock($name){
		if(in_array($name, $this->lock)){
			$this->dtstatus = "Var IS locked";
			return TRUE;
		}
		else{
			$this->dtstatus = "Var IS NOT locked";
			return false;
		}
	}
	
	/**
	 * Check if the var name has been hidden.
	 * Meaning it cannot be seen
	 */
	private function check_hide($name){
		if(in_array($name, $this->hide)){
			$this->dtstatus = "Var IS hidden";
			return TRUE;
		}
		else{
			$this->dtstatus = "Var IS NOT hidden";
			return false;
		}
	}
	
	/* Abstract methods from AbstArrayAcess*/
	protected final function set($name, $value){
		
		//check that vars has been set
		if(count($this->vars > 0)){
			
			//check if value can be changes
			if((!$this->check_lock($name)) && (!$this->check_hide($name))){
				//check the name and value
				if($this->chkvals($name,$value)){
					if(!is_null($this->set_hook)){
						$this->do_callbacks($this->set_hook,$name,$value);
					}
					
					$this->values[$name] = $value;
				}
				else{
					$this->values[$name] = null;
				}
			}
			else {
				return FALSE;
			}
			
		}
		else{
			$this->values[$name] = null;
		}
		
		
	}
	
	
	/* Get the value of the data type object*/
	protected final function get($name){
		if(!$this->check_hide($name)){
			if(!is_null($this->get_hook)){
				return $this->do_callbacks($this->get_hook,$name);
			}
			else {
				//if the datatype was create
				if(array_key_exists($name, $this->vars)){
					//check if the datatype has a value
					if(array_key_exists($name, $this->values)){
						return $this->values[$name];
					}
					else {
						return null;
					}
				}
			}
		}
		else {
			return null;
		}
		
	}
	
	/* unsets values */
	protected final function unsetprop($name){
		unset($this->$name);
	}
	
	protected final function getname($name){
		if(array_key_exists($name, $this->vars)){
			return true;
		}
		else {
			return false;
		}
	}
	
	protected final function clean_up(){}
	
}

?>