<?php

  function t($key){
    return Outputter::get_instance()->get_text($key);
  }

  function d($key, $outputterKey = true){
    return Outputter::get_instance()->get_data($key, $outputterKey);
  }

  function f($number){
    return Outputter::get_instance()->format_number($number);
  }

  class Outputter {

    private static $instance;

    public static function get_instance() {
      if(!isset(Outputter::$instance)){
        Outputter::$instance = new Outputter();
      }
      return Outputter::$instance;
    }


    private $mlSupport;
    private $data = array();
    private $update_ml_support = false;
    private $language;

    private function __construct(){
      $outputter = $this;
      $this->language = 'de';
      $ml_support_global = &Config::get_instance()->get_ml_support();

      if($ml_support_global[$this->language]){
        $this->ml_support = &$ml_support_global['de'];
      } else {
        $l_support_global[de] = array();
        $this->ml_support = &$ml_support_global['de'];
      }
    }

    public function register($key, $value){
      $this->data[$key] = $value;
      //  Tools::debug($this->data);
    }

    public function deregister($name){
      unset($this->data[$name]);
    }

    public function deregister_all(){
      $this->data = array();
    }

    public function get_language(){
      return $this->language;
    }

    public function is_form_key_valid(){
      // return true;
      if(Tools::is_set_args('form_key') && $_SESSION['form_key'] !==  Tools::read_arg('form_key' )) {
        $this->register('status', ['m_invalid_form_key' ]);
        return false;
      }
      return true;
    }

    public function show($page){
      $_SESSION['form_key'] = sha1(time().'#$%&$%');
      $this->register('_form_key', $_SESSION['form_key']);
      $this->register('_page',$page);
      $this->register('_page_classes',$page.' '.str_replace('_', ' ', $page));
      $this->register('_user', User::get_instance());
      $this->register('_language', $this->language);
      $this->register('_navigation_links', $this->get_navigation_links());
      // Tools::debug($this->data);
      include 'templates/'.$page.'.tpl';
      
      //Tools::debug($this->update_ml_support);
      if($this->update_ml_support) {
        $config = Config::get_instance();
        $config->update_ml_support();
      }
    }

    private function get_navigation_links(){
      $navigation = new Navigation();
      return $navigation->generate();
    }


    public function get_text($key){
	//	Tools::debug($key);
      if(is_array($key)){
        $array = $key;
        $template = $this->get_text($array[0]);
        unset($array[0]);

        foreach($array as $key => $value){
          $template = str_replace('{'.((string)$key).'}', $value, $template);
        }
        return str_replace('\n', "\n", $template);
      } else {
        $key = trim((string) $key);
        // Tools::debug($this->ml_support);
        if(array_key_exists($key, $this->ml_support)) {
          return $this->ml_support[$key];
        } else {
          $this->update_ml_support = true;
          $this->ml_support[$key] = $key;
          return $key;
        }
      }
    }

    public function get_data($key, $outputter_key ,  $_data = array()){
      if(empty($_data)) {
        $_data = $this->data;
      }
      if(array_key_exists($key, $_data)) {
        $value = $_data[$key];
        return  $this->format_data($value) ;
      } else {
        $x = explode('.', $key, 2);
        if(array_key_exists($x[0], $_data)){
          $y = $_data[$x[0]];
          if(count($x) == 2 && is_array($y)){
            return $this->get_data($x[1],$outputter_key, $y);
          } else {
            return $this->format_data($key) ;
          }
        } else {
          return $outputter_key ? $this->format_data($key) : false;
        }
      }
    }

    public function format_number($number) {
      return number_format($number, 1, $this->get_text('decimal_point'), $this->get_text('tousands_seperator'));
    }

    private function format_data($data){

      // Tools::debug($data);
      switch (gettype($data)) {
        case 'integer':
        case 'double':
        case 'float':
        case 'NULL':
        case 'object':
        case 'boolean':
          return $data;

        case 'array':
          $result = array();
          foreach( $data as $key => $value) {
            $result[$key] = $this->format_data($value);
          }
          return $result;
          break;

        case 'string':
          return htmlspecialchars(htmlspecialchars_decode($data));
          break;
      }
    }
 }

?>
