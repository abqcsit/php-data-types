<?php
/**
 * This class implements the PHP ArrayAccess interface. It provides additional functionality for hiding
 * and protecting values from being changed. Extending classes must implement a set, get, unsetprop and 
 * clean up methods
 * 
 * Properties names should be defined in child classes.
 * 
 * offsetGet and offsetExists will return a value if the $hide property is set to false. if the $hide 
 * property is set to true, the functions will clear the function param and return false
 * 
 * offsetUnset offsetSet will set/unset the property "value". value is can be a variable or an array 
 * key or anything else you cal think of as long as it's called value.
 */
namespace VDM\Lib\DataTypes;

abstract class AbstArrayAccess implements \ArrayAccess{
		
	#this allows data to be read but not changed.
	protected $lock = array(); 
	
	#if this is set, all the function will simply return displaying nothing
	protected $hide = array();
	
	#holds status of var
	protected $dtstatus;
	
	#set the value of an property
	abstract protected function set($name, $value);
	
	#returns the value of a property
	abstract protected function get($name);
	
	#returns the name of a property
	abstract protected function getname($name);
	
	#unset the value of the property
	abstract protected function unsetprop($name);
	
	#used to clear any arrays and vars with uneeded data
    abstract protected function clean_up();

	/* Calls function that implements logic for getting values*/	
    public final function offsetGet($offset) {
    	return $this->get($offset);
    }

	/* Calls function that implements logic for getting property names*/
	public final function offsetExists($name) {
		if($this->hide == FALSE){
         	return $this->getname($name);
		}
		else if($this->hide == TRUE){
			$name = null;
			unset($name);
			return FALSE;	
		}
		
    }

	/* Calls method for unsetting property values*/
    public final function offsetUnset($offset) {
    	if($this->lock == FALSE){
    		$this->unsetprop($offset);
		}
		else if($this->lock == TRUE){
    		$offset = null;
			unset($offset);
			return FALSE;
    	}
    		
    }
	
	/* Sets the value of a property*/
	public final function offsetSet($offset, $value) {
		$this->set($offset, $value);
    }
}
?>