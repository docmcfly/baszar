<?php
class Workflow {

  const ACTION = 'action';

  private $action ;

  private $user = '';

  public function __construct() {
    $this->user = User::get_instance();
  }

  public function is_logged_in(){
    return  $this->user->is_logged_in();
  }

  private function get_action(){
    if(!isset($this->action)){
      if(Tools::is_set_args(self::ACTION)) {
        $this->action = Tools::read_arg(self::ACTION);
      } else {
        $this->action = '';
      }
    }
    return $this->action;
  }



  public function next(){
      //   Tools::debug(['getaction' ,$this->get_action()]);
    if($this->is_logged_in()) {
      switch ($this->get_action()){
        case 'logout':
          $this->user->logout();
          $this->next();
          break;
        case 'create':
          $create = new Create();
          $create->run();
          break;
        case 'edit':
          $edit = new Edit();
          $edit->run();
          break;
        case 'backup':
          $backup = new Backup();
          $backup->run();
          break;
        case 'display':
        default:
            $display = new Display(); // "list" is not allowed. :-(
            $display->run();
          break;
      }
    } else {
      switch ($this->get_action()){
       case 'login':
          $this->user->login();
          if($this->user->is_logged_in()){
            $this->action = 'home';
            $this->next();
            break;
          }
        default:
          $login = new Login();
          $login->run();
          break;
      }
    }
  }
}

?>
