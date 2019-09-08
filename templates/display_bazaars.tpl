 <?php include 'templates/header.tpl' ; ?>



 <?php
 $mibi = 1024 * 1024;
 $bazaars = d('bazaars');
 $options = d('options');
 
?>
    <script>
		var t_remove = "<?=t('t_remove')?>";  
    </script>
    <div class="table">

		<div class="tr">
		<div class="th"><?=t('b_name')?></div>
		<div class="th"><?=t('b_year')?></div>
		<div class="th"><?=t('b_sellers')?></div>
		<div class="th"></div>
		</div>


		<form action='index.php' method="post" class="tr">
			<input type="hidden" name="form_key" value="<?=d('_form_key')?>">
			<input type="hidden" name="action" value="create">
			<div class="td"><input type="text strong" class="input" name="name" value="" placeholder="<?=t('b_spring_bazaar')?>" pattern=".{3,40}" <?=d('name')?>></div>
			<div class="td"><input type="number"  class="input" name="year" min="<?=d('current_year')?>" max="2100" step="1" value="<?=d('year')?>"></div>
			<div class="td"><input type="number"  class="input" name="sellers" min="1" max="100" step="1" value="<?=d('sellers')?>"></div>
			<div class="td"><button ><?=t('b_create')?></button></div>	
		</form>

		<? if( isset($bazaars)  && !empty($bazaars)) { ?>
		<form action='index.php' method="post"  class="tr">
			<input type="hidden" name="form_key" value="<?=d('_form_key')?>">
			<input type="hidden" name="action" value="edit">
			<div class="td strong"><?=$bazaars[0]['name']?></div>
			<div class="td strong"><?=$bazaars[0]['year']?></div>
			<div class="td"><input type="number" name="sellers" class="input" value="<?=$bazaars[0]['sellers']?>" /></div>
			<div class="td"><button><?=t('b_set_sellers')?></button></div>
		</form>

    <? unset($bazaars[0]);
    foreach($bazaars as $bazaar) {?>
		
		<div class="tr">
			<div class="td"><?=$bazaar['name']?></div>
			<div class="td"><?=$bazaar['year']?></div>
			<div class="td"><?=$bazaar['sellers']?></div>
			<div class="td"></div>
		</div>	
		
		
    <? }} ?>


</div> 
<?php include 'templates/footer.tpl' ?>
