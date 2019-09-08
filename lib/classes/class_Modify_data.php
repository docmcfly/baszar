<?php
  abstract class Modify_data extends Action{

    protected $detail_validation;

    abstract protected function init();

    abstract protected function validate();

    public function __construct(){
      $this->_init();
    }

    public function _init(){
      $this->detail_validation = Tools::read_arg('detail_validation') !== false;
     // Tools::debug($this->detail_validation);
      $this->init();
      if(!$this->detail_validation){
        $this->apply_defaults();
      }
    }

    // hook
    protected function apply_defaults(){
    }

  }
