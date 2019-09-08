<?php

class Tools {

  public static function read_arg($key){
      if(array_key_exists($key, $_GET)) {
        $result = $_GET[$key];
      }
      
      if(array_key_exists($key, $_POST)) {
        $result = $_POST[$key];
      }  
      if( isset($result) ) {
				if(Tools::starts_with($key, 'is_')) {
				  return $result === 'on' || $result === 1 ? true : false;
				} else {
				  return $result;
				}
			} else {
				return false;
			}
  }

  public static function is_set_args(){
    $args = func_get_args();
    $count = func_num_args();
    foreach($args as $arg) {
	  //	Tools::debug($arg."-".array_key_exists($arg, $_POST));
      if(!array_key_exists($arg, $_POST) && !array_key_exists($arg, $_GET)) {
        return false;
      }
    }
    return true;
  }


  public static function array_column($array, $key){
    $result = array();
    if(is_array($array)){
      foreach($array as $entry){
        $result[] = $entry[$key];
      }
    }
    return $result;
  }

  public static function debug($obj){
    echo "<pre>";
    if(is_string($obj)){
      $out = $obj;
    } else {
      ob_start();
      var_dump($obj);
      $out=htmlspecialchars(ob_get_contents(),ENT_QUOTES);
      ob_end_clean();
    }
    echo $out;
    echo "</pre>";
  }

  public static function generate_password($length = 10){
      $alphabet = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-=~!@#$%&*()_+,.<>?;:[]{}";
      $pass = array(); //remember to declare $pass as an array
      $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
      for ($i = 0; $i < $length; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
      }
      //Tools::debug($pass);
      return implode($pass);
    }


  public static function starts_with($big_string, $small_string) {
    return !strncmp($big_string, $small_string, strlen($small_string));
  }

  public static function ends_with($big_string, $small_string) {
    if (strlen($small_string) == 0) {return true;}
    return (substr($big_string, -strlen($small_string)) === $small_string);
  }


}



?>
