<?php
  class Display extends Action {

    private $delegate;

    public function __construct(){
      if(Tools::is_set_args('target')){
        switch(Tools::read_arg('target')) {
          case 'bazaars':
            $this->delegate = new Display_bazaars();
          break;
          case 'user':
            $this->delegate = new Display_users();
          break;
          case 'evaluation':
            $this->delegate = new Display_evaluation();
          break;
          default:
            $this->delegate = $this->get_target();
        }
      } else {
					$this->delegate = $this->get_target();
      }
    }

	private function get_target(){
		$user = User::get_instance();
		
		return 
	     Config::get_instance()->get_db()->has('bazaars' ,[]) 
					? ($user->is_root() ? new Display_bazaars() : new Display_till())
	        : new Display_bazaars();
	}


    public function run(){
      $this->delegate->run();
    }

  }


?>
