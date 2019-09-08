<?php
  class Edit_users extends Modify_data {

    private $outputter;
		private $id;
		private $password;
		
		
    public function __construct(){
      parent::__construct();
    }

    public function init(){
			$this->outputter = Outputter::get_instance();
			$this->id = Tools::read_arg('id');
			$this->password = Tools::read_arg('password');
    }



    public function run(){
      $db = Config::get_instance()->get_db();
      if($this->validate()){
        try{
          $db->begin_transaction();
					
					if( !empty($this->password)) {
						$set = array();
						$set['password'] = sha1($this->password); 					
						$db->update('users', $set, ['id' => $this->id]);
					}
          
					// Tools::debug($db->last());
					$db->commit();
        } catch( Exception $e) {
          $db->rollback();
        }
        $user = User::get_instance();
        $user->restore();
        $nick = $db->select('users', ['nick'], ['id' => $this->id]);
        
        $this->outputter->register('status', ['m_user_updated', t('till').' '.$nick[0]['nick']]);
        //Tools::debug('$this->apply_defaults()');
      } 
	    $d = new Display_users();
	    $d->run();		
    }



    protected function validate(){
      $config = Config::get_instance();
      $db = $config->get_db();
      $user = User::get_instance();
      $result = true;
		  // Tools::debug($user);
			if(!$user->is_root()){
				$error[] = 'e_you_are_not_root';
			}	
			//	Tools::debug($error);
      if(isset($error)) {
        $this->outputter->register('error', $error);
        $result = false;
      }
      return $result;
    }




  }


?>
