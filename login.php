<?php

  /**
   * Demo Class for API Single Sign On
   * @class Demo
   * @license apache license 2.0, code is distributed "as is", use at own risk, all rights reserved
   * @copyright 2013 Tracy Mazelin
   * @author Tracy Mazelin tracy.mazelin@activenetwork.com.
   * @requires PHP PECL OAuth, http://php.net/oauth
   *
   */

session_start();
require_once('lib/FellowshipOne.php');


class Demo extends FellowshipOne{


  public static $f1;
  public $settings;
  
  public $redirectTo = array(
    "6" => "https://staging-www.fellowshipone.com/home.aspx",
    "626" => "weblink address to redirect to",
    "237" => "https://churchcode.staging.infellowship.com/"
  );

  /**
   * Instantiate FellowshipOne Class
   * @param array $settings 
   */
  public function __construct($settings){
     $this->settings = $settings;
     self::$f1 = new FellowshipOne($settings);
     return $this->test_credentials();
  }

  /**
   * Check credentials passed
   * @return buildUrl method
   */
  public function test_credentials(){ 
   
    if((($r = self::$f1->login($this->settings['username'],$this->settings['password'])) === false) || (!isset(self::$f1->accessToken->oauth_token))){
      header('Location:index.php?login=failed');
      session_destroy();
      exit;      
     } 
     return $this->buildUrl();    
  }

  /**
   * Construct the url to be redirected to
   * @return Redirect Method
   */
  public function buildUrl(){
      $params = array(
        "applicationID" => $_POST['appId'],
        "accessToken" => self::$f1->accessToken->oauth_token,
        "redirectURL" => $this->redirectTo[$_POST['appId']],
        );
      $url =  $this->settings['baseUrl'].self::$f1->paths['sso'];
      $url .= "?" . http_build_query($params);
      return $this->Redirect($url);
  }

  /**
   * Perform the redirection
   * @param string  $url       
   * @param boolean $permanent 
   */
  public function Redirect($url, $permanent = true){
    session_destroy();     
    return header('Location: ' . $url, true, $permanent ? 301 : 302);
  }
   
}

$settings = array(
   'key'=>'enter your api key here (found in F1->Admin->Application Keys)',
   'secret'=>'enter your api secret here (found in F1->Admin->Application Keys)',
   'username'=>$_POST['username'],
   'password'=>$_POST['password'],
   'baseUrl'=>'https://churchcode.staging.fellowshiponeapi.com',
   'debug'=>false,
  );

$api = new Demo($settings);
