<?php
class Display_evaluation extends Action {

  public function __construct(){

  }
	
	public function run(){
	  $outputter = Outputter::get_instance();
		$db = Config::get_instance()->get_db();
		$outputter->register('bazaars', 
			$db->select('bazaars', ['id','year','name'], ['ORDER' => ['id' => 'DESC' ]]));
    
    $option = Tools::read_arg('option');
		$outputter->register('option', $option ===false ? 0 : $option);

    $id = Tools::read_arg('id');
		$outputter->register('id', $id);

    $bazaar = Tools::read_arg('bazaar');
		$outputter->register('bazaar', $bazaar);

    $outputter->register('options', ['de_accounting', 'de_sellers', 'de_vouchers', 'de_tills']);
    
    
    
    $bazaarCondition = '';
    if( !Tools::is_set_args('bazaar')) {
			$bazaarCondition = 'vouchers.bazaar_id IN 
																		(SELECT id FROM bazaars 
																		ORDER BY create_time DESC LIMIT 1) ';
		}  else {
			$bazaarCondition = 'vouchers.bazaar_id = '.$db->quote( intval($bazaar)).' ';
		
		}	
			
		switch($option){
			
			case 0:
				$data = $db->query('SELECT seller_id, count(*) AS sales_volume, sum(amount) as take, sum(amount)*0.8 as payoff, sum(amount)*0.2 as deduction
												FROM voucher_details
												JOIN vouchers ON vouchers.id = voucher_details.voucher_id
												WHERE '.$bazaarCondition.' AND voucher_details.seller_id <> 50 
												GROUP BY seller_id')->fetchAll(PDO::FETCH_ASSOC);
				$d50 = $db->query('SELECT seller_id, count(*) AS sales_volume, sum(amount) as take, 0 as payoff, sum(amount) as deduction
												FROM voucher_details
												JOIN vouchers ON vouchers.id = voucher_details.voucher_id
												WHERE '.$bazaarCondition.' AND voucher_details.seller_id = 50 
												GROUP BY seller_id')->fetchAll(PDO::FETCH_ASSOC);
//				Tools::debug($data);
//				Tools::debug($d);
				$dataOut = array();
				
				foreach($data AS $x){
					$dataOut[$x['seller_id']] = $x; 
				}
				foreach($d50 AS $x){
					$dataOut[$x['seller_id']] = $x; 
				}
				ksort($dataOut);
				
				$outputter->register('data', $dataOut);

				$sum = array();
				$sum['take'] = 0.0;
				$sum['payoff'] = 0.0;
				$sum['deduction'] = 0.0;
				
				foreach($dataOut AS $x){
					$sum['take'] += $x['take'];
					$sum['payoff'] += number_format(floatval($x['payoff']),2);
					$sum['deduction'] += number_format(floatval($x['deduction']),2);
					
				}
				$outputter->register('sum', $sum);
				break;
				
			case 1: 
				$id = intval(Tools::read_arg('id'));
			//	Tools::debug($seller_id);
				
				$id = empty($id ) ? '' : 'AND voucher_details.seller_id = '.$db->quote($id);
				// $db->debug();
				$data = $db->query('SELECT  voucher_details.seller_id AS seller_id , voucher_details.voucher_id as voucher_id, amount, till.nick as till FROM "voucher_details"  
														JOIN vouchers ON vouchers.id = voucher_details.voucher_id
														JOIN users as till ON till.id = vouchers.till_id
														WHERE '.$bazaarCondition.$id.'
														ORDER BY voucher_details.seller_id, voucher_details.voucher_id ')->fetchAll(PDO::FETCH_ASSOC);
			  // Tools::debug($data);
				
				$dataOut = array();
				foreach($data AS $d) {
					$s = $d['seller_id'];
					$dataOut[$s]['details'][] = $d;
					if( isset($dataOut[$s]['sum'])) {
						 $dataOut[$s]['sum'] += $d['amount'];
					} else {
						 $dataOut[$s]['sum'] = $d['amount'];
					}
				}
				// Tools::debug($dataOut);
				
				$outputter->register('data', $dataOut);
				$outputter->register('id', Tools::read_arg('id'));

				break; 
			case 2: 
				$id = intval(Tools::read_arg('id'));
				
				$id = empty($id ) ? '' : 'AND voucher_details.voucher_id = '.$db->quote($id);
				// $db->debug();
				$sumQuery = $db->query('SELECT voucher_details.voucher_id as voucher_id, 
				                    sum(amount) as sum, 
				                    till.nick as till  
														FROM "voucher_details"  
														JOIN vouchers ON vouchers.id = voucher_details.voucher_id
														JOIN users as till ON till.id = vouchers.till_id
														WHERE '.$bazaarCondition.$id.'
														GROUP BY voucher_details.voucher_id 
														ORDER BY voucher_details.seller_id, voucher_details.voucher_id ');
				// print_r($sumQuery);
				$sum = $sumQuery->fetchAll(PDO::FETCH_ASSOC);
				$data = array();
        foreach($sum AS $s) {
						$data[$s['voucher_id']] = array( 'sum' => $s);
				}

				$details = $db->query('SELECT voucher_details.voucher_id as voucher_id, voucher_details.seller_id, amount FROM "voucher_details"  
														JOIN vouchers ON vouchers.id = voucher_details.voucher_id
														JOIN users as till ON till.id = vouchers.till_id
														WHERE '.$bazaarCondition.$id.'
														ORDER BY voucher_details.seller_id, voucher_details.voucher_id ')->fetchAll(PDO::FETCH_ASSOC);
				foreach($details AS $d) {
					 $data[$d['voucher_id']]['details'][] = $d;
				}
				ksort($data);		
		    // Tools::debug($data);	
				$outputter->register('data', $data);				
				$outputter->register('id', Tools::read_arg('id'));

				break; 
			case 3: 
				// $db->debug(); 
				$id = intval(Tools::read_arg('id'));
				
				$id = empty($id ) ? '' : 'AND till = '.$db->quote($id);

				$data = $db->query('SELECT voucher_details.voucher_id as voucher_id, sum(amount) AS take_sum, till.nick AS till FROM "voucher_details"  
														JOIN vouchers ON vouchers.id = voucher_details.voucher_id
														JOIN users as till ON till.id = vouchers.till_id
														WHERE '.$bazaarCondition.$id.'
														GROUP BY till_id, voucher_id 
														ORDER BY till_id, voucher_id ')->fetchAll(PDO::FETCH_ASSOC);
			 // Tools::debug($data);
				$dataOut = array();
					
				foreach($data AS $d) {
					$dataOut[$d['till']]['details'][] = $d;
					if( isset($dataOut[$d['till']]['sum'])) {
						 $dataOut[$d['till']]['sum'] += $d['take_sum'];
					} else {
						 $dataOut[$d['till']]['sum'] = $d['take_sum'];
					}
				}
			//  Tools::debug($dataOut);
				$outputter->register('data', $dataOut);		
				$outputter->register('id', Tools::read_arg('id'));
			break; 

		}
    $outputter->show('display_evaluation');
    
  }

}


?>

