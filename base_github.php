<?php

/**
 * 
 * Base class for github
 * 
 * Classname : base_github
 * Filename  : base_github.php
 * Author    : Vignesh
 * 
 */

class base_github {
	
	/*
	 * curls the given url
	 * */
	protected function curl($url, $method){
		$ch = curl_init();
	
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		$output = curl_exec($ch);
		curl_close($ch);
		
		if($output){
			return $output;
		} else {
			return FALSE;
		}
	}
	
	/*
	 * converts stdobject to array
	 * */
	protected function objectToArray($data){
		if (is_object($data)) {
			$data = get_object_vars($data);
		}
	 
		if (is_array($data)) {
			return array_map(__FUNCTION__, $data);
		}
		else {
			return $data;
		}
	}
	
}

?>