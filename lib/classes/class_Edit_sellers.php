<?php
  class Edit_sellers extends Modify_data {

    private $outputter;
		private $bazaar_id;
		private $sellers;
		
		
    public function __construct(){
      parent::__construct();
    }

    public function init(){
			$this->outputter = Outputter::get_instance();
			$this->sellers = Tools::read_arg('sellers');
			$db = Config::get_instance()->get_db();
			$this->bazaar_id = $db->query('SELECT max(id) FROM "bazaars"')->fetchAll(PDO::FETCH_NUM)[0][0];
    }

    protected function apply_defaults(){
    }




    public function run(){
      $db = Config::get_instance()->get_db();
      if($this->validate()){
        try{
          $db->begin_transaction();
          $db->update('bazaars', ['sellers' => $this->sellers], ['id' => $this->bazaar_id]);
          $db->commit();
        } catch( Exception $e) {
          $db->rollback();
        }
        $this->outputter->register('status', 'm_sellers_updated');
        //Tools::debug('$this->apply_defaults()');
      } 
     $d = new Display_bazaars();
     $d->run();
    }



    protected function validate(){
      $config = Config::get_instance();
      $db = $config->get_db();
      $user = User::get_instance();
      $result = true;

			$max_seller = $db->query('
					SELECT max(seller_id) FROM voucher_details 
					JOIN vouchers ON vouchers.id = voucher_details.voucher_id
					WHERE vouchers.bazaar_id = '. $this->bazaar_id )->fetchAll(PDO::FETCH_NUM)[0][0];
	   
	   
	//   Tools::debug($max_seller); 
	//   Tools::debug($this->sellers); 
			if($this->sellers < 1 || $this->sellers < $max_seller){
				$error	[] = ['e_seller_not_smaller', $max_seller];
			}

			
      if(isset($error)) {
        $this->outputter->register('error', $error);
        $result = false;
      }
      return $result;
    }




  }


?>
