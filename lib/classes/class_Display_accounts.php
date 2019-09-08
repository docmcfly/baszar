<?php
class Display_accounts extends Action {

  public function __construct(){
  }

  public function run(){
    if(User::get_instance()->is_root()) {
      $outputter = Outputter::get_instance();
      $outputter->register('users', $this->get_users());
      $outputter->show('display_accounts');
    } else {
      $home = new Home();
      $home->run();
    }
  }

  private function get_users(){
      $config = Config::get_instance();
      $at_db = $config->get_admintoy_db();
      return $at_db->select('users',['name','is_root', 'is_enabled']);

  }
}


?>
