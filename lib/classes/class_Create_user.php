<?php
  class Create_user extends Modify_data {

    private $outputter;
    private $nick;
    private $password;



    public function __construct(){
      parent::__construct();
    }
    protected function init(){
      $this->outputter = Outputter::get_instance();
      $this->password = Tools::read_arg('password');
      $this->nick = Tools::read_arg('nick');
    }

    public function run(){
//			Tools::debug("cu_run");
      
      if($this->validate()){
        $this->create_user();
        $this->outputter->register('status', ['m_user_created', t('till').' '.$this->nick]);
				$d = new Display_users();
				$d->reset_new_user();
				$d->run();
      } else {
				$d = new Display_users();
				$new['nick'] = 	Tools::read_arg('nick');
				$new['password'] = '';
				$this->outputter->register('new_user', $new);
			  $d->run();
			}
      
    }

    private function create_user(){
      $config = Config::get_instance();
      $db = $config->get_db();

      $db->insert('users', [
        'password' => sha1($this->password),
        'nick' =>  $this->nick
         ]
        );
    }


    protected function validate(){
      $config = Config::get_instance();
      $user = User::get_instance();

      $db = $config->get_db();
      $result = true;

			if(!$user->is_root()){
				$error	[] = 'e_you_are_not_root';
			}	else { 
				if($db->has('users', ['AND' =>['nick'=> $this->nick]] ) ){
					$error[] = 'e_user_exists';
				}
			//	Tools::debug($this->nick);
				if(strlen($this->password) < Config::MIN_PASSWORD_LENGTH ) {
					$error[] =  'e_password_to_short';
				}
			}
      if(isset($error)) {
        $this->outputter->register('error', $error);
        $result = false;
      }
      return $result;
    }


  }


?>
