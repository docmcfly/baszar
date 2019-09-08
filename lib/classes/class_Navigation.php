<?php

class Navigation {

  const PAGE = 0;
  const LABEL = 'LABEL';
  const ACTION = 'action';

  private $logged_out;
  private $user;
  private $root;

  private $outputter;

  public function __construct(){
    $this->outputter = Outputter::get_instance();
  }


  public function generate(){

    $user = User::get_instance();
    $nav = array();
    // Tools::debug($user);
    switch($user->get_user_type()){
      case User::USER:
   		  if($user->is_root()){
					$nav[] =  'display_user';
					$nav[] =  'display_bazaars';
					$nav[] =  'display_evaluation';
					$nav[] =  'backup';
        } else {
						$nav[] =  'display_till';
				}
		$nav[] = 'logout';
        break;
      default:
        $nav[] = 'login';
    }
    $this->outputter->register('links', $this->render_links($nav));
  }


  private function render_links($navigation) {
    $result = array();
    $_page = $this->outputter->get_data('_page', true);
    // Tools::debug($_page);
    foreach($navigation as $page => $params) {
      // Tools::debug('_____________________________');

      if(is_string($params)){
        $tmp = array();
        $tmp[] = $params;
        $params = $tmp;
      }

      if(is_array($params)){

        if(!array_key_exists(self::ACTION, $params)){
          $explode_page = explode("_", $params[self::PAGE], 2);
          $params[self::ACTION] = $explode_page[0];
        }

        if($params[self::ACTION] === 'display'){
          $explode_page = explode("_", $params[self::PAGE], 2);
          $params['target'] =  $explode_page[1];
        }

        $page = $params[self::PAGE];
        $label = isset($params[self::LABEL]) ? $params[self::LABEL] : $page; ;
        $action =$params[self::ACTION];

        unset($params[self::PAGE]);
        unset($params[self::LABEL]);
      }
      // Tools::debug($params);

       
      if(trim($_page) == trim($page)  ) {
        $a_start = '';
        $a_end = '';
      } else {
        $a_start = '<a href="index.php';
        $p = array();
        foreach($params as $key => $value) {
          $p[] = $key.'='.$value;
        }

        if(count($p) > 0 ) {
          $a_start .= '?'.implode('&', $p);
        }
        if($page === 'help'){
          if(!User::get_instance()->is_logged_in() && $_page === 'edit_mailbox') {
            $a_start .= '#change_password_mailbox';
          } else {
            $a_start .= '#'.$_page;
          }
        }
        $a_start .= '" >';
        $a_end = '</a>';
      }
      $result[ $a_start.$this->outputter->get_text($label).$a_end ] = 'navigation'. (($_page === $page) ? ' current' : '');
    }
    //Tools::debug($result);
    return $result;
  }

  private function render_linksOld($navigation) {
    $result = array();
    $_page = $this->outputter->get_data('_page', true);
    // Tools::debug($_page);
    foreach($navigation as $page => $params) {



      if(is_int($page)){
        $page = $params;
        $explode_page = explode("_", $page, 2);
        $explode_page = explode("_", $page, 2);
        $params = array();
        $params['action'] = $explode_page[0];
        if($params['action'] === 'display'){
          $params['target'] = $explode_page[1];
        }
      }

      // Tools::debug($navigation);
      if(trim($_page) == trim($page)  ) {
        $a_start = '';
        $a_end = '';
      } else {
        $a_start = '<a href="index.php';
        $p = array();
        foreach($params as $key => $value) {
          if($key !== 'LABEL'){
            $p[] = $key.'='.$value;
          }
        }

        if(count($p) > 0 ) {
          $a_start .= '?'.implode('&', $p);
        }
        if($page === 'help'){
          if(!User::get_instance()->is_logged_in() && $_page === 'edit_mailbox') {
            $a_start .= '#change_password_mailbox';
          } else {
            $a_start .= '#'.$_page;
          }
        }
        $a_start .= '" >';
        $a_end = '</a>';
      }
      $text = isset($params['LABEL']) ? $params['LABEL'] : $page;
      $result[ $a_start.$this->outputter->get_text($text).$a_end ] =  'navigation'. (($_page === $page) ? ' current' : '');

    }
    return $result;
  }

  private static function generate_default_display_link($target){
    $result = [ 'display_'.$target => ['action' => 'display', 'target' => $target]];
    return $result;
  }


}

?>
