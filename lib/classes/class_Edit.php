<?php
  class Edit {

    private $delegate;

    public function __construct(){
//		 Tools::debug($_POST);

      if(Outputter::get_instance()->is_form_key_valid()){
        if(Tools::is_set_args('sellers') ){
          $this->delegate = new Edit_sellers();
        } else if(Tools::is_set_args('id','password') ){
          $this->delegate = new Edit_users();
				} else {
          $this->delegate = new Home();
        }
      } else {
        $this->delegate = new Home();
      }
    }

    public function run(){
      $this->delegate->run();
    }

  }


?>
