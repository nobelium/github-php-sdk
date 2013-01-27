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

 
require __DIR__.'/base_github.php';

class Github extends base_github{
	
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
	
	//User details are stored if the user has authorized
	protected $user;
	
	//the uri to which the user has to be redirected after authorization
	protected $redirect_uri;

	/*
	 * constructor - checks if any of the data members r available and aims at obtaining an access token
	 * */
	function __construct($config) {
		$this->getSession();
		
		$this->user = FALSE;
		//Sets scope for the access token
		if(isset($config['SCOPE'])){
			$this->scope = $config['SCOPE'];
		} else {
			$this->scope = "repo";
		}
		
		if(isset($config['REDIRECT_URI'])){
			$this->redirect_uri = $config['REDIRECT_URI']; 
		} else {
			$here = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			$next = preg_replace('~#.*$~s', '', $here);
			$next = preg_replace('~\?.*$~s', '', $next);
			$next = preg_replace('~/[^/]*$~s', '', $next);
			$this->redirect_uri = $next;
		}
		
		//Sets app id and app secret
		$this->app_id = $config['APP_ID'];
		$this->app_secret = $config['APP_SECRET'];
		
		//if code is set - check for state and obtain accesstoken and store it in session.
		//if not set obtain it from session
		if(isset($_GET['code'])){
			if(isset($_SESSION[$this->app_id.'GITHUB_STATE']) && !empty($_SESSION[$this->app_id.'GITHUB_STATE'])){
				if($_SESSION[$this->app_id.'GITHUB_STATE'] == $_GET['state']){
					$this->code = $_GET['code'];
					$this->fetchAccessToken();
					$this->fetchUser();
				} else {
					echo "CSRF activity";
				}
			}
		} else {
			if(isset($_SESSION[$this->app_id.'GIT_ACCESS_TOKEN']))
			$this->access_token = $_SESSION[$this->app_id.'GIT_ACCESS_TOKEN'];
			$this->fetchUser();
		}
		
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
	 * Sets user as soon as an access token is obtained
	 * */
	 protected function fetchUser(){
		$out = $this->api('/user', 'GET', array('access_token'=>$this->access_token));
		$out = json_decode($out);
		$this->user = $this->objectToArray($out);
	 }
	 
	/*
	 * Fetches access token from code
	 * */
	protected function fetchAccessToken(){

		$url = "https://github.com/login/oauth/access_token?client_id=".$this->app_id."&redirect_uri=".$this->redirect_uri."&client_secret=".$this->app_secret."&code=".$this->code."&state=".$_SESSION[$this->app_id."GITHUB_STATE"];
		$result = $this->curl($url, "POST");
		parse_str($result,$result1);
		$this->access_token = $result1['access_token'];
		$_SESSION[$this->app_id.'GIT_ACCESS_TOKEN'] = $this->access_token;
	}
	
	/*
	 * 
	 * */
	public function getUser(){
		return $this->user;
	}
	
	/*
	 * Call to api
	 * */
	public function api($path, $method, $params, $postdata=NULL ){
		$url = "https://api.github.com".$path;
		if(is_array($params)){
			$i = 0;
			foreach ($params as $key => $value) {
				if(!$i){
					$url = $url."?_a=1";
					$i++;
				}
				$url = $url."&".$key."=".$value;
			}
		}
		if($method == "POST")return $this->curl($url, $method, $postdata);
		return $this->curl($url, $method);
	}
	
	/*
	 * Returns the url for authenticating the user
	 * */
	public function getLoginUrl(){
		$_SESSION[$this->app_id."GITHUB_STATE"] = md5(uniqid(rand(), true));
		return "https://github.com/login/oauth/authorize?client_id=".$this->app_id."&redirect_uri=".$this->redirect_uri."&scope=".$this->scope."&state=".$_SESSION[$this->app_id."GITHUB_STATE"];
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