 <?php include 'templates/header.tpl' ; ?>



 <?php
 $mibi = 1024 * 1024;
 $bazaars = d('bazaars');
 $bazaar = d('bazaar');
 
 $options = d('options');
 $option = d('option');
 $id = d('id');
 ?>
    	<div class="table">	
			<form action='index.php' method="post" class="tr">
				<input type="hidden" name="form_key" value="<?=d('_form_key')?>">
				<input type="hidden" name="action" value="display">
				<input type="hidden" name="target" value="evaluation">
				<div class="td">	
					<select class="input" name="bazaar">
						<? foreach(d('bazaars') AS $i => $b) { ?>
							<option value="<?=$b['id'] ?>" <?= $bazaar == $b['id'] ? 'selected' : ''?>><?=$b['name'].' - '.$b['year'] ?></option>
						<? } ?>	
					</select>
				</div>
				<div class="td">	
					<select  class="input" name="option">
						<? foreach(d('options') AS $k => $v) { ?>
							<option value="<?=$k ?>" <?= $option == $k ? 'selected' : ''?>><?=t($v)?></option>
						<? } ?>	
					</select>
				</div>
				<div class="td">
					<input type="number" class="input" name="id" value="<?=$id?>" placeholder="<?=t('de_id')?>..." >
				</div>
				<div class="td">
					<button><?=t('de_refresh') ?></button>
				</div>
			</form>	
    </div>
		<br>
		<br>
		

		<? switch(d('option')) { 
		 case 3: ?>
			<div class="table">
				<div class="tr">
					<div class="th till"><?=t('till')?></div>
					<div class="th voucher_id"><?=t('de_voucher_id')?></div>
					<div class="th amount"><?=t('de_take_sum')?></div>
				</div>
			<?  $c = 0; 
				$data = d('data');
				foreach($data AS $t) { 
					$first = true;
					$c = ($c + 1)  % 2;
				// Tools::debug($data);n 
				?>
				<div class="tr <?=$c==0 ?'light':'dark'?>">
					<div class="td_ " style="height:1ex;"></div>
					<div class="td_ "></div>
					<div class="td_ "></div>
				</div>
				<?
					foreach($t['details'] AS $d) { 
					?>
			<div class="tr <?=$c==0 ?'light':'dark'?>">
				<div class="td till"><?=$first ? $d['till'] : ''?></div>
				<div class="td voucher_id"><?=$d['voucher_id']?></div>
				<div class="td amount"><?=number_format($d['take_sum'],2)?> <?=t('currency')?></div>
			</div>
			
			<? 
			$first = false;
			} ?>
				<div class="tr  <?=$c==0 ?'light':'dark'?>">
					<div class="td till"></div>
					<div class="td voucher_id"></div>
					<div class="td sum amount"><?=number_format($t['sum'],2)?> <?=t('currency')?></div>
				</div>
				<div class="tr <?=$c==0 ?'light':'dark'?>">
					<div class="td_ " style="height:1ex;"></div>
					<div class="td_ "></div>
					<div class="td_ "></div>
				</div>
			<? } ?>
		</div>
		
		<? break;


			 case 2: ?>
    <div class="table">
			<div class="tr">
				<div class="th voucher_id"><?=t('de_voucher_id')?></div>
				<div class="th seller"><?=t('de_seller_id')?></div>
				<div class="th amount"><?=t('de_amount')?></div>
				<div class="th till"><?=t('de_till')?></div>
			</div>
			<? 
		  $c = 1; 
			foreach(d('data') AS $k => $s) { 
				$v = $s['sum'];
				$c = ($c + 1)  % 2;
				$first = true;

			?> 
		  <div class="tr <?=$c==0 ?'light':'dark'?>">
				<div class="td_ " style="height:1ex;"></div>
				<div class="td_ "></div>
				<div class="td_ "></div>
				<div class="td_ "></div>
			</div>
			<?	foreach($s['details'] AS $d) {	?>
			<div class="tr <?=$c==0 ?'light':'dark'?>">
				<div class="td_ voucher_id"><?=$first ? $k : ''?></div>
				<div class="td_ seller"><?=$d['seller_id']?></div>
				<div class="td_ amount"><?=str_replace('.',',', strval(number_format(floatval( str_replace(',','.',$d['amount'])) ,2)))?> <?=t('currency')?></div>
				<div class="td_ till"><?=$first ? t('till').' '.$v['till'] : ''?></div>
			</div>
			
			<? 
			  $first = false;
			} ?>
			<div class="tr <?=$c==0 ?'light':'dark'?>">
				<div class="td seller"></div>
				<div class="td sum amount"><?=t('de_sum')?></div>
				<div class="td sum amount"><?=str_replace('.',',', strval(number_format(floatval( str_replace(',','.',$v['sum'])) ,2)))?> <?=t('currency')?></div>
				<div class="td till" ></div>
			</div>

			<div class="tr <?=$c==0 ?'light':'dark'?>">
				<div class="td_ " style="height:1ex;"></div>
				<div class="td_ "></div>
				<div class="td_ "></div>
				<div class="td_ "></div>
			</div>

			<? } ?>
		</div>
		<? break;
		 case 1: ?>
    <div class="table">
			<div class="tr">
				<div class="th seller"><?=t('de_seller')?></div>
				<div class="th voucher_id"><?=t('de_voucher_id')?></div>
				<div class="th amount"><?=t('de_amount')?></div>
				<div class="th till"><?=t('de_till')?></div>
			</div>
			<?  $c = 0; 
				foreach(d('data') AS $v) { 
					$c = ($c + 1)  % 2;
					foreach($v['details'] AS $d) {	?>
					<div class="tr <?=$c==0 ?'light':'dark'?>">
						<div class="td seller"><?=$d['seller_id']?></div>
						<div class="td voucher_id"><?=$d['voucher_id']?></div>
						<div class="td amount"><?=number_format($d['amount'],2)?> <?=t('currency')?></div>
						<div class="td till"><?=$d['till']?></div>
					</div>
					<? } 
						$sum = $v['sum'];
					?>
					<div class="tr <?=$c==0 ?'light':'dark'?>">
						<div class="td seller"></div>
						<div class="td voucher_id"></div>
						<div class="td amount sum" style="font-weight:bold;"><?=number_format($sum,2)?> <?=t('currency')?> <br>
																			<span style="font-size: 80%">(<?=t('de_payoff')?>: <?=$d['seller_id'] == 50  ? '0,00' : number_format($sum * .8 ,2) ?> <?=t('currency')?> )</span>
																			</div>
						<div class="td till"></div>
					</div>
					<div class="tr <?=$c==0 ?'light':'dark'?>">
						<div class="td_ " style="height:1ex;"></div>
						<div class="td_ "></div>
						<div class="td_ "></div>
						<div class="td_ "></div>
					</div>
					
				<? } ?>
			</div>
		
		<? break;
			
			case 0: 
			default:
			?>
    <div class="table">
			<div class="tr">
				<div class="th seller"><?=t('de_seller')?></div>
				<div class="th sales_volume"><?=t('de_sales_volume')?></div>
				<div class="th take"><?=t('de_take')?></div>
				<div class="th payoff"><?=t('de_payoff')?></div>
				<div class="th deduction"><?=t('de_deduction')?></div>
			</div>
			<?  $c = 0;
			foreach(d('data') AS $d) { 
					$c = ($c + 1)  % 2;
				?>
			<div class="tr <?=$c==0 ?'light':'dark'?>" >
				<div class="td seller"><?=$d['seller_id']?></div>
				<div class="td sales_volume"><?=$d['sales_volume']?></div>
				<div class="td take"><?=number_format($d['take'],2)?> <?=t('currency')?></div>
				<div class="td payoff"><?=number_format($d['payoff'],2)?> <?=t('currency')?></div>
				<div class="td deduction"><?=number_format($d['deduction'],2)?> <?=t('currency')?></div>
			</div>
			<? } 
			
			$sum = d('sum');
			?>
			<div class="tr">
				<div class="td sum seller"></div>
				<div class="td sum sales_volume"></div>
				<div class="td sum take"><?=number_format($sum['take'],2)?> <?=t('currency')?></div>
				<div class="td sum payoff"><?=number_format($sum['payoff'],2)?> <?=t('currency')?></div>
				<div class="td sum deduction"><?=number_format($sum['deduction'],2)?> <?=t('currency')?></div>
			</div>
		</div> 		
			 
			 
			  	
		<?  } ?> 


<?php include 'templates/footer.tpl' ?>
