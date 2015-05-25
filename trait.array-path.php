<?php
namespace VDM\Lib\DataTypes;

trait ArrayPath {
	
	private $path_value;
	private $path_to_;
	/**
	 * Callback for array_walk to set path names in $var_names
	 * @param $endpoint path endpoint to append to $item
	 */
	private function set_paths(&$item,$index,$endpoint=null){
		$item = "${item}/${endpoint}";
	}
	
	
	
	
	protected function arraypath(array $array_to_map,$map){
		array_walk($array_to_map,array($this,'walk_path'));
	}
	
	/**
	 * Converts array keys to paths
	 * @param $var_names array of names to set as root path
	 * @param $paths array of names to append to each root path
	 */
	public function to_path(array $var_names,array $paths){
		$vars = array();
		
		foreach ($paths as $key => $path_name) {
			$var_name = $var_names;
			array_walk($var_name,array($this,'set_paths'),$path_name);
			$vars = array_merge($vars,$var_name);	
		}
		
		$array_to_path = array_fill_keys($vars, "path");
		
		return $array_to_path;
	}
	
}
?>