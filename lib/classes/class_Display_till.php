<?php
class Display_till extends Action {

  public function __construct(){

  }

  public function run(){

    $outputter = Outputter::get_instance();
    $user = User::get_instance();
    $outputter->register('till', $user->get_id());
    
    $db = Config::get_instance()->get_db();
    $sellers_count = $db->query('SELECT sellers FROM "bazaars" ORDER BY id DESC LIMIT 1')->fetchAll(PDO::FETCH_NUM);
    // Tools::debug($sellers_count);
    
    $current_till_sum = $db->query('SELECT sum(voucher_details.amount) FROM voucher_details
       JOIN vouchers ON vouchers.id = voucher_details.voucher_id 
       WHERE vouchers.bazaar_id IN (SELECT max(bazaars.id) FROM bazaars )
						 AND vouchers.till_id ='.$db->quote($user->get_id()))->fetchAll(PDO::FETCH_NUM);
    // Tools::debug($current_till_sum);
    $outputter->register('sellers_count', count($sellers_count) == 0 ? 0 : $sellers_count[0][0]); 
    $outputter->register('current_till_sum', count($current_till_sum) == 0 ? 0 : number_format($current_till_sum[0][0], 2, ',', '.')); 
	  $outputter->register('seller', array()); 
 
    $outputter->show('display_till');
    
  }

}


?>

