<?php

/**
 * 
 * A minimalist php sdk for GITHUB SOAP API v3 
 * 
 * Classname : Github
 * Filename  : github.php
 * Author    : Vignesh
 * 
 */
 
class Github {
	
	//Client ID provided by github
	protected $app_id;
	
	//Client Secret provided by github
	protected $app_secret;
	
	//Access Token provided by github after authorization
	protected $access_token;
	
	//Permission list the access token has
	protected $scope;
	
	//An arbit string to prevent CSRF
	protected $state;
	
	//Oauth code provided by github for fetching accesstoken
	protected $code;
	
	
	/*
	 * 
	 * */
	function __construct($config) {
		$this->getSession();
	}
	
	/*
	 * Starts session if not started
	 * */
	protected function getSession(){
		if(session_id()==''){
			session_start();
		}
	}
	
	/*
	 * Fetches accesstoken from code
	 * */
	protected function fetchAccessToken(){
		
	}
	
	/*
	 * 
	 * */
	public function getUser(){
		
	}
	
	/*
	 * Call to api
	 * */
	public function api($path, $method, $params){
		
	}
	
	/*
	 * Returns the url for authenticating the user
	 * */
	public function getLoginUrl(){
		return "https://github.com/login/oauth/authorize?client_id=".$this->app_id."&scope=".$this->scope;
	}
	
	public function getLogoutUrl(){
		
	}
	
	/*
	 * Getter functions
	 * 
	 * */
	 
	public function getAccessToken(){
		return $this->access_token;
	}
	
	public function getAppSecret(){
		return $this->app_secret;
	}
	
	public function getAppId(){
		return $this->app_id;
	}
	
	/*
	 * Setter functions
	 * 
	 * */
	 
	public function setAccessToken($token){
		$this->access_token = $token;
	}
	
	public function setAppId($appid){
		$this->app_id = $appid;
	}
	
	public function setAppSecret($secret){
		$this->app_secret = $secret;
	}
}

?>