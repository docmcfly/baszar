<?php

class Login extends Action {
	
	
	public function run(){
		$db = Config::get_instance()->get_db();
		$outputter = Outputter::get_instance();
		//$db->debug();
		$u = $db->count('bazaars',[]) > 0 ? $db->select('users', ['nick'], ['AND' => ['id[!]' => 0]]) : array();
		$outputter->register('users',  $u);
		$outputter->show('login'); 
	}


}
?>

