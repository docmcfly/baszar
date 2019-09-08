<?php
class Display_bazaars extends Action {

  
  public function run(){

    $outputter = Outputter::get_instance();
		$db = Config::get_instance()->get_db();
		$outputter->register('bazaars', 
		$db->select('bazaars', ['id','year','name', 'sellers'], ['ORDER' => ['id' => 'DESC' ]]));
		
    $outputter->register('year', getdate()['year']);
    $outputter->register('sellers', 1);
    $outputter->register('current_year', getdate()['year']);
    $outputter->show('display_bazaars');
    
  }

}


?>

