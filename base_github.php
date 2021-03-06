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


if (!function_exists('curl_init')) {
  throw new Exception('Github needs the CURL PHP extension.');
}
if (!function_exists('json_decode')) {
  throw new Exception('Github needs the JSON PHP extension.');
}

class base_github {
	
	/*
	 * curls the given url
	 * */
	protected function curl($url, $method, $postdata=NULL ){
		$ch = curl_init();
	
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		if($method == "POST" && $postdata!=NULL)
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
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
			return array_map(array($this, __FUNCTION__) , $data);
		}
		else {
			return $data;
		}
	}
	
}

?>