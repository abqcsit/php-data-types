<?php
namespace VDM\Lib\DataTypes;
/**
 * Trait to handle parsing and checking of urls
 */
 
 trait DataTypeUrl{
 	
	private $url;
	private $parsed_url;
	
	private function basic_check($url){
		$this->url = $url;
		
		if($this->parse_url()){
			if($this->url_scheme()){
				if($this->host()){
					return TRUE;
				}
			}
		}
		return FALSE;
	}
	
	
	private function parse_url(){
		$this->parsed_url = parse_url($this->url);
		if($this->parsed_url !== FALSE){
			return TRUE;
		}
		return FALSE;
		
	}
	
	private function url_scheme(){
		if(isset($this->parsed_url['scheme'])){
			$scheme = $this->parsed_url['scheme'];
			if($scheme == 'http' || $scheme == 'https'){
				return TRUE;
			}
		}
		
		
		return FALSE;
	}
	
	private function host(){
		if(isset($this->parsed_url['host'])){
			return TRUE;
		}
		return FALSE;
	}
 }
?>