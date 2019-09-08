<?php
class Display_users extends Action {

	private $users; 
	private $new_user;
	
  public function __construct(){
			$db = Config::get_instance()->get_db();
			$this->users = $db->select('users', ['id','nick','password']);
			
			if(Tools::is_set_args('id','password')){
				$id = Tools::read_arg('id');
				foreach($this->users as &$user){
					if($user['id'] === $id) {
						$user['password'] = '';
					}
				}
			}
			
			if(Tools::is_set_args( 'nick','password')){
				$new['nick'] = 	Tools::read_arg('nick');
				$new['password'] = '';
				$this->new_user = $new;
			} else {
				$this->reset_new_user();
			}
  }
	
	public function reset_new_user(){
		$new['nick'] = '';
		$new['password'] = '';
		$this->new_user = $new;		
	}

	
  public function run(){
    $outputter = Outputter::get_instance();
    $outputter->register('users', $this->users);
    $db = Config::get_instance()->get_db();
		$max = $this->users = $db->max('users', ['nick'] ,['AND' => ['id[!]' => 0 ]]);
    $outputter->register('new_nick', $max + 1);
    
   // Tools::debug($this->new_user);
    $outputter->register('new_user', $this->new_user);
    $outputter->show('display_users');
  }

}


?>

