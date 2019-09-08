<?php

define ('RELEASE', '0.1');
define ('SOFTWARE', 'bazaarcash (all rights by Clemens Gogolin 2017) ');
function __autoload($class_name) {
  Initializer::autoload($class_name);
}
  
class Initializer {

	public static function autoload($class_name) {
	
		include 'lib/classes/class_'.$class_name .'.php';
	}
	
}



?>
