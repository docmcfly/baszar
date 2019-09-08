<?php
  class Create_voucher extends Modify_data {

    private $outputter;
    private $amounts;
    private $sellers;
		private $db;
		private $bazaar_id;
		private $till;

    public function __construct(){
      parent::__construct();
    }
    protected function init(){
      $config = Config::get_instance();
      $this->db = $config->get_db();

			$this->outputter = Outputter::get_instance();
      $this->till = Tools::read_arg('till');
       $this->amounts = Tools::read_arg('amount');
       $this->sellers = Tools::read_arg('seller');
//       Tools::debug($_POST);
    }



    public function run(){
	  $this->db->begin_transaction();
      if($this->validate()){
        $id = $this->create_voucher();
				$this->db->commit();
        $this->outputter->register('status', [ 'm_voucher_created', $id]);
        $d = new Display_till();
        $d->run();
      } else {
				$this->db->rollback();
				$d->run();

      }
    }

    private function create_voucher(){

      $user = User::get_instance();
			$this->db->insert('vouchers', [
				'bazaar_id' => $this->bazaar_id,
				'till_id' => $user->get_id()]
					);
			// Tools::debug($this->db->last()); 
			$voucher_id = $this->db->id();
  	
// 	Tools::debug($this->sellers);
// 	Tools::debug($this->amounts);
			foreach($this->sellers AS $key => $s) {
				$this->db->insert('voucher_details', [
					'voucher_id' => $voucher_id,
					'seller_id' => $s,
					'amount' => str_replace(',', '.', $this->amounts[$key]) ]
						); 
			// 	Tools::debug($this->db->last());
			}
			return $voucher_id;	
    }

    protected function validate(){
      $user = User::get_instance();
			$this->bazaar_id = $this->db->select('bazaars', ['id'], ['ORDER' => ['id' => 'DESC' ], 'LIMIT' => 1])[0]['id'];
	// 	Tools::debug($this->sellers);
      $sellers_count = $this->db->get('bazaars', 'sellers');
      $result = true;

			foreach($this->sellers as $key => $seller) {
				$seller = intval($seller);
				if( $seller < 1 && $seller > $sellers_count ){
				$error[] = ['e_invalid_seller', $seller];
				}
			}

			foreach($this->amounts as $key => $amount) {
				if( floatval($amount) < 0  ){
				$error[] = ['e_invalid_amount', $amount];
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
