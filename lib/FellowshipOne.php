<?php 

	
	/**
	 * Helper Class for the FellowshipOne.com API.
	 * @class FellowshipOne
	 * @license apache license 2.0, code is distributed "as is", use at own risk, all rights reserved
	 * @copyright 2012 Daniel Boorn
	 * @author Daniel Boorn daniel.boorn@gmail.com
	 * @author Tracy Mazelin tracy.mazelin@activenetwork.com.  Methods added, removed and adapted for PHPUnit Tests
	 * @requires PHP PECL OAuth
	 *
	 */

	class FellowshipOne{

		const TOKEN_CACHE_SESSION = 1;
		
		
		public $settings;
		
		public $paths = array( 
			'sso' => "/v1/SSO/Index",
			'accessToken'=>'/v1/weblinkUser/AccessToken',
			);
	
		
		/**
		 * contruct fellowship one class with settings array that contains
		 * @param unknown_type $settings
		 */
		public function __construct($settings){
			$this->settings = (object) $settings;
		}
					
		/**
		 * Generic HTTP GET function
		 * @param string $endpoint 
		 * @return object
		 */
		public function get($endpoint){
			$url = $this->settings->baseUrl . $endpoint;
			return $this->fetchJson($url);
		}

		/**
		 * Generic HTTP POST function
		 * @param object $model 
		 * @param string $endpoint 
		 * @return object
		 */
		public function post($model, $endpoint){
			$url = $this->settings->baseUrl . $endpoint;
			$model = json_encode($model);
			return $this->fetchJson($url,$model,OAUTH_HTTP_METHOD_POST);
		}
		
		/**
		 * Generic HTTP PUT function
		 * @param object $model 
		 * @param string $endpoint 
		 * @return object
		 */
		public function put($model, $endpoint){
			$url = $this->settings->baseUrl . $endpoint;
			$model = json_encode($model);
			return $this->fetchJson($url,$model,OAUTH_HTTP_METHOD_PUT);
		}
		
		/**
		 * Generic HTTP DELETE function
		 * @param string $endpoint 
		 * @return object
		 */
		public function delete($endpoint){
			$url = $this->settings->baseUrl . $endpoint;
			return $this->fetchJson($url,$model=null,OAUTH_HTTP_METHOD_DELETE);
		}

		/* Generic HTTP GET IMAGE function
		 * @param string $endpoint 
		 * @return object
		 */
		public function get_img($endpoint){
			$url = $this->settings->baseUrl . $endpoint;
			return $this->fetchJson($url, $model=null, OAUTH_HTTP_METHOD_GET, $contentType='image/jpg');
		}


		/**
		 * Generic HTTP POST IMAGE function
		 * @param stream $img
		 * @param string $endpoint 
		 * @return object
		 */
		public function post_img($file, $endpoint){
			$url = $this->settings->baseUrl . $endpoint;
			return $this->fetchJson($url,$file,OAUTH_HTTP_METHOD_POST, $contentType='image/jpg');
		}

		/**
		 * Generic HTTP PUT IMAGE function
		 * @param stream $img
		 * @param string $url
		 * @return object
		 */
		public function put_img($file, $url){
			return $this->fetchJson($url,$file,OAUTH_HTTP_METHOD_PUT, $contentType='image/jpg');
		}

		
		/**
		 * BEGIN: OAuth Functions
		 */
		
		/**
		 * directly set access token. e.g. 1st party token based authentication
		 * @param array $token
		 */
		public function setAccessToken($token){
			$this->accessToken = (object) $token;
		}
		
		/**
		 * fetches JSON request on F1, parses and returns response
		 * @param string $url
		 * @param string|array $data
		 * @param const $method
		 * @return void
		 */
		public function fetchJson($url,$data=null,$method=OAUTH_HTTP_METHOD_GET){
			try{
				$o = new OAuth($this->settings->key, $this->settings->secret, OAUTH_SIG_METHOD_HMACSHA1);
				$o->setToken($this->accessToken->oauth_token, $this->accessToken->oauth_token_secret);
				$headers = array(
						'Content-Type' => 'application/json',
				);
				
				if($o->fetch($url, $data, $method, $headers)){
						if($this->settings->debug) 
						return array(
							'headers'=>self::http_parse_headers($o->getLastResponseHeaders()), 
							'response'=>json_decode($o->getLastResponse(),true)
						);
						return json_decode($o->getLastResponse(),true);
					}
				
			}catch(OAuthException $e){
				$this->error = array(
					'method'=>$method,
					'url'=>$url,
					'response'=>self::http_parse_headers($o->getLastResponseHeaders())
					
				);
				return $this->error;
			}
		}	
		
		

		/**
		 * parse header string to array
		 * @source http://www.php.net/manual/en/function.http-parse-message.php
		 * @param string $header
		 * @return array $retVal
		 */
		public static function http_parse_headers($header) {
	      $retVal = array();
	      $fields = explode("\r\n", preg_replace('/\x0D\x0A[\x09\x20]+/', ' ', $header));
	      foreach ($fields as $field) {

	        // Do not process empty cubrid_num_fields(result)
	        if (empty($field)) {
	          continue;
	        }

		        if (preg_match('/([^:]+): (.+)/m', $field, $match)) {
		          $match[1] = preg_replace('/(?<=^|[\x09\x20\x2D])./e', 'strtoupper("\0")', strtolower(trim($match[1])));
		          if( isset($retVal[$match[1]]) ) {
		            if (!is_array($retVal[$match[1]])) {
		              $retVal[$match[1]] = array($retVal[$match[1]]);
		            }
		            $retVal[$match[1]][] = $match[2];
		          }
		          else {
		            $retVal[$match[1]] = trim($match[2]);
		          }
		        }
		        else {
		          if (preg_match('/HTTP\//', $field)) {
		            // Following HTTP standards which are space-separated
		            preg_match('/(.*?) (.*?) (.*)/', $field, $matches);
		            $retVal['HTTP']['version'] = $matches[1];
		            $retVal['HTTP']['code'] = $matches[2];
		            $retVal['HTTP']['reason'] = $matches[3];
		          }
		          else {
		            $retVal['Content'][] = $field;
		          }
		        }
		      }
		      return $retVal;
	  	}
		
		/**
		 * get access token from session by username
		 * @param string $username
		 * @return array|NULL
		 */
		protected function getAccessToken($username){
			if(isset($_SESSION['F1AccessToken'])){
				return (object) $_SESSION['F1AccessToken'];
			}
			return false;
		}
		
		
		
		
		/**
		 * save access token to session
		 * @param array $token
		 */
		protected function saveSessionAccessToken($token){
			$_SESSION['F1AccessToken'] = (object) $token;
		}
		
				
		/**
		 * 2nd Party credentials based authentication
		 * @param string $username
		 * @param string $password
		 * @param const $cacheType
		 * @return boolean
		 */
		public function login($username,$password,$cacheType=self::TOKEN_CACHE_SESSION,$custoHandlers=NULL){
			$token = $this->getAccessToken($username,$cacheType,$custoHandlers);
								
			if(!$token){
				$token = $this->obtainCredentialsBasedAccessToken($username,$password);
				$this->saveSessionAccessToken($token);
			}
			
			$this->accessToken = $token;
			
			return true;
		
		}

		/**
		 * obtain credentials based access token from API
		 * @param string $username
		 * @param string $password
		 * @return array
		 */
		protected function obtainCredentialsBasedAccessToken($username,$password){
			try{
				$message = urlencode(base64_encode("{$username} {$password}"));
				$url = "{$this->settings->baseUrl}{$this->paths['accessToken']}?ec={$message}";
				$o = new OAuth($this->settings->key, $this->settings->secret, OAUTH_SIG_METHOD_HMACSHA1);
				return (object) $o->getAccessToken($url);
			}catch(OAuthException $e){
				return false;
			}
		}
		
			
	}