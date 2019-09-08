<?php
  class Backup extends Action {

    public function __construct(){
    }


    public function run(){
			$o = Outputter::get_instance();
			$o->show('backup');
    }

  }


?>
