<?php
class Home extends Action {

  private $delegate;

  public function __construct(){
    $user = User::get_instance();
    if($user->is_logged_in()){
      $this->delegate =  new Display_till();
    } else {
      $this->delegate = new Login();
    }
  }

  public function run(){
    //    Tools::debug("run");
    $this->delegate->run();
  }

}

?>
