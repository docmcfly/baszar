 <?php include 'templates/header.tpl' ; ?>



 <?php
 $mibi = 1024 * 1024;
 $user = d('_user');
 $sellers_count = d('sellers_count');
 $seller = d('seller');
 $amount = d('amount');
 $current_till_sum = d('current_till_sum');
 
 ?>
     <script >
		var t_remove = "<?=t('t_remove')?>";  
		var t_valid_seller_from_until = "<?=t('t_valid_seller_from_until')?>";  
		var t_valid_amount_from_until = "<?=t('t_valid_amount_from_until')?>";  
	</script>	
     <script src="assets/till.js">
    </script>
	<form id="voucher" action='index.php' method="post" >	
		<input type="hidden" name="form_key" value="<?=d('_form_key')?>">
		<input type="hidden" name="action" value="create">
	<div class="table">
		<div class="tr space ">
			<div class="td"><?=t('till')?> <?=$user->get_nick()?>	</div>
			<div class="td current_till_sum_title"><?=t('t_current_till_sum')?></div>
			<div class="td"><?=$current_till_sum?> <?=t('currency')?></div>
	</div>		
		<div class="tr">
			<div class="th"><?=t('t_seller')?></div>
			<div class="th"><?=t('t_amount')?></div>
			<div class="th"></div>
		</div>


		<div class="tr entry" id="<?=$i?>">
			<div class="td"><input id="seller" type="number" class="input" min="1" max="<?=$sellers_count?>" step="1" placeholder="0"></div>
			<div class="td amount"><input id="amount" class="input" type="text" min="0.01" max="1000" step="0.01"  placeholder="0,00" > <?=t('currency')?></div>
			<div class="td"><button id="enter" value="enter"><?=t('t_enter')?></button></div>
		</div>		
		<div class="tr subtotal" >
			<div class="td"><?=t('t_subtotal')?>:</div>
			<div class="td" id="subtotal"><input id="subtotal" type="text" placeholder="0,00" readonly > <?=t('currency')?></div>
			<div class="td"></div>
		</div>		
		<div class="tr cash" >
			<div class="td"><?=t('t_cash')?>:</div>
			<div class="td" id="sum"><input id="cash" class="input" type="text"  placeholder="0,00" > <?=t('currency')?></div>
			<div class="td"></div>
		</div>		
		<div class="tr refund" >
			<div class="td"><?=t('t_refund')?>:</div>
			<div class="td" id="sum"><input id="refund" type="text" min="0" max="9999" step="0.01"  placeholder="0,00" readonly > <?=t('currency')?></div>
			<div class="td"><button id="book" value="book"><?=t('t_book')?></button></div>
		</div>		
		<div class="tr details space" >
			<div class="td"></div>
			<div class="td"></div>
			<div class="td"></div>
		</div>		

		<? $i= 0; 
		
		  if( isset($seller)) {
     		for($i = 0, $c = count($seller); $i < $c ; $i++){  ?>

		<div class="tr entry" id="<?=$i?>">
			<div class="td"><input id="seller[<?=$i?>]" class="seller set" name="seller[<?=$i?>]" type="number" min="1" max="<?=$sellers_count?>" step="1" value="<?=$seller[$i]?>"></div>
			<div class="td amount"><input id="amount[<?=$i?>]"  name="amount[<?=$i?>]" class="amount set" type="text" min="0.01" max="1000" step="0.01"  value="<?=$amount[$i]?>" > <?=t('currency')?></div>
			<div class="td"><button id="enter" value="enter"><?=t('t_remove')?></button></div>
		</div>		
		<? }} ?>

		
	</div>	
		
	</form>
	

<?php include 'templates/footer.tpl' ?>
