<?php
  class Create extends Action {

    private $delegate;

    public function __construct(){
      
      if(Outputter::get_instance()->is_form_key_valid()) {
    //  Tools::debug($_POST);
        if(Tools::is_set_args('name','year','sellers')){
          $this->delegate = new Create_bazaar();
//		  Tools::debug($this->delegate);
				} else  if(Tools::is_set_args('seller','amount')){
          $this->delegate = new Create_voucher();
				} else  if(Tools::is_set_args('nick','password')){
          $this->delegate = new Create_user();
				} else  {
          $this->delegate = new Home();
        }
      } else  {
        $this->delegate = new Display();
      }
    }

    public function run(){
      $this->delegate->run();
    }

  }


?>
