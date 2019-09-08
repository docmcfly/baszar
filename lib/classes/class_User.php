<?php

class User {

  const USER_ID = 'user_id';
  const INVALID_ID = -1;

  const UNKNOWN = 0;
  const USER = 1;

  private static $instance;

  public static function get_instance() {
    if(!isset(User::$instance)){
      User::$instance = new User();
      User::$instance->restore();
     // Tools::debug( User::$instance);
    }
    return User::$instance;
  }

  public static function create_instance($name) {
    $user = new User();
    $user->user_type = self::USER; 
    $user->load($name);
    return $user;
  }

  private static function get_session_key(){
    return  $_SERVER['SCRIPT_FILENAME'].'#'.self::USER_ID;
  }

  private $config;
  private $id;
  private $nick;
  private $password ;
  private $user_type = self::UNKNOWN;

  private function __construct(){
    $this->config = Config::get_instance();
    $this->reset();
  }

  public function is_logged_in(){
    $data = $this->restore_user();
    return  $this->is_valid() && $this->id === $data['id'];
  }

  public function is_valid(){
    return  $this->id != self::INVALID_ID;
  }

  public function get_user_type(){
    return  $this->user_type ;
  }

  public function is_root(){
    return  $this->id == 0;
  }
  
  public function get_id(){
    return $this->id;
  }

  public function get_nick(){
    return $this->nick;
  }


  public function reset(){
    $this->id = self::INVALID_ID;
    $this->nick = null;
    $this->password = null;
    $this->user_type = self::UNKNOWN;
  }

  public function restore() {
    $data = $this->restore_user();
    $this->id = $data['id'];
    $this->user_type = $data['user_type'];
    // Tools::debug($data);
    $this->load();
  }

  public function reload(){
    $this->load( $this->get_name());
  }


  protected function load($name = null){
    switch($this->get_user_type()){
      case self::USER:
        $db = $this->config->get_db();
        if( isset($name) ) {
          $where = ['name' => $name ];
        } else {
          $where = ['id' => $this->id ];
        }
        $result = $db->get('users', 
                            ['id', 'nick', 'password'], 
                             $where );
        // Tools::debug($where);
//         Tools::debug($result);
        if($result !== false){
          $this->reset();
          $this->id = $result['id'];
          $this->nick = $result['nick'];
          $this->password = $result['password'];
          $this->user_type = self::USER;
          $user_session_data = $this->restore_user();
          // Tools::debug($user_session_data);
          // Tools::debug($this);
         
          return true;
        }
        break;
      default:
        $this->reset();
        break;
    }
    return false;
  }


  public function logout(){
    $this->reset();
    session_destroy();
  }

  public function login(){
    $this->reset();
    //Tools::debug(Tools::is_set_args('nick', 'password'));
    if(Tools::is_set_args('nick', 'password')) {
      $this->_login(Tools::read_arg('nick'), Tools::read_arg('password') );
    }
  }

  private function _login($name, $password){
    $db = $this->config->get_db();
    $result = $db->get('users', ['id'], ['AND' => 
       ['nick' => $name,'password' => sha1($password)]]);
   // Tools::debug($db->last());
    if($result !== false){
      if($result['id'] != 0 && $db->count('bazaars', []) == 0){
				Outputter::get_instance()->register('error', [ 'e_login_failed_no_bazaars']);
				$this->reset();
			} else {
				$this->id = $result['id'];
				$this->user_type = self::USER;
				$this->store_user(['id' => $this->id, 'user_type' => self::USER]);
				$this->load();
			}
    } else {
			Outputter::get_instance()->register('error', [ 'e_login_failed']);
			$this->reset();
    }
  }

  private function store_user($user_session_data){
    $_SESSION[self::get_session_key()] = json_encode($user_session_data);
  }

  private function restore_user(){
    $template = ['id' => self::INVALID_ID, 'user_type' => self::UNKNOWN ];
    $key = self::get_session_key(); 
//    Tools::debug($key);
    if(array_key_exists($key, $_SESSION)) {
      return array_merge($template, 
         json_decode($_SESSION[self::get_session_key()], true));
    } else  {
		return $template;
	}
  }




  public function validate_password($password){
    // Tools::debug($this->password);
    return md5($password) == $this->password;
  }




}
