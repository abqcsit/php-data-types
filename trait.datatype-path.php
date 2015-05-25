<?php
namespace VDM\Lib\DataTypes;

trait DataTypePath {
	protected $array_paths;
	protected $get_val;
	
	/**
	 * Gets an array path from param
	 * @param $paths Array or string that contains path name/s
	 */
	protected function get_path(){
		$path = null;
		
		if(is_array($this->paths)){
			$path = array_shift($this->paths);
		}
		elseif(is_string($this->paths)) {
			$path = $paths;
		}
		
		return $path;
	}
	
	/**
	 * Walks an array based on a path
	 * @param $path_array reference to an array that will be walked
	 * @param $values optional arg to set values for the end element
	 */
	protected function walk_path(&$path_array,$values=null){
		$path = $this->get_path();
		
		//continue until end of array path is reached
		if(count($this->paths)>0){
			//don't recreate the array if it already exists
			if(! array_key_exists($path, $path_array)){
				$path_array[$path]=array();
			}
			else {
				if(! is_array($path_array[$path])){
					$path_array[$path]=array();
				}
			}
			
			$this->walk_path($path_array[$path],$values);
		}
		//set end of array path to value
		else {
			
			//if array key does not exists create and set to null
			if(! array_key_exists($path, $path_array)){
				$path_array[$path] = null;
			}
			
			//if values is set update the setting
			if(! is_null($values)){
				$path_array[$path] = $values;		
			}
			//if values is not set, return the value of the array element
			elseif(is_null($values)) {
				$this->get_val = $path_array[$path];
			}
			
		}
	}
}
?>