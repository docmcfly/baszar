<?php
  class Create_bazaar extends Modify_data {

    private $outputter;
    private $name;
    private $year;
    private $sellers;



    public function __construct(){
      parent::__construct();
    }
    protected function init(){
	   $this->outputter = Outputter::get_instance();
       $this->name = Tools::read_arg('name');
       $this->year = Tools::read_arg('year');
       $this->sellers = Tools::read_arg('sellers');
    }

    public function run(){
      if($this->validate()){
        $this->create_bazaar();
        $this->outputter->register('status', 'm_bazaar_created');
        $display_accounts = new Display_bazaars();
        $display_accounts->run();
      } else {
		    $config = Config::get_instance();
		    $db = $config->get_db();
        $this->outputter->register('name', $this->name);
        $this->outputter->register('sellers', $this->sellers);
        $this->outputter->register('year', $this->year);

        $this->outputter->register('bazaars', 
		    $db->select('bazaars', ['id','year','name', 'sellers'], ['ORDER' => ['id' => 'DESC' ]]));
        
        $this->outputter->show('display_bazaars');
      }
    }

    private function create_bazaar(){
      $config = Config::get_instance();
      $user = User::get_instance();
      $db = $config->get_db();

      $db->insert('bazaars', [
        'name' => $this->name,
        'year' => $this->year,
         'sellers' => $this->sellers]
        );
    }

    protected function validate(){
      $config = Config::get_instance();
      $db = $config->get_db();
      $current_year = getdate()['year'];
      
      $result = true;
		
      if(strlen($this->name) < 3 ){
        $error[] = 'e_bazaar_name_to_short';
      }

      if($db->has('bazaars', ['AND' =>['name'=> $this->name, 'year' => $this->year]] ) ){
        $error[] = ['e_bazaar_exists', $this->name, $this->year];
      }

      if($current_year > $this->year ){
        $error[] = 'e_bazaar_in_the_past';
      }

      if($this->sellers < 1){
        $error[] = 'e_sellers_not_enough';
      }


     if($current_year > $this->year ){
        $error[] = 'e_bazaar_in_the_past';
      }

      if(isset($error)) {
        $this->outputter->register('error', $error);
        $result = false;
      }
      return $result;
    }


  }


?>
