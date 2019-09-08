 <?php include 'templates/header.tpl' ; ?>
  <div class="table">
		<div class="tr">
			<div class="th w15"><?=t('u_nick')?></div>
			<div class="th w25"><?=t('u_password')?></div>
			<div class="th w5"><?=t('u_root')?>&nbsp;</div>
			<div class="th w20"></div>
		</div>
		<? foreach(d('users') as $user) { 
	 // print_r(d('users'));
			?> 
			<form action='index.php' method="post" class="tr" autocomplete="off">
				<input type="hidden" name="form_key" value="<?=d('_form_key')?>">
				<!-- no auto fill workaround BEGIN -->
				<input id="username" style="display:none" type="text" name="name">
				<input id="password" style="display:none" type="password" name="password">
				<!-- no auto fill workaround END -->
				<input type="hidden" name="action" value="edit">
				<input type="hidden" name="id" value="<?=$user['id']?>">
				<div class="td">&nbsp;&nbsp;<?=$user['id'] == 0 ? t($user['nick']) : t('till').' '.$user['nick']?></div>
				<div class="td"><input type="password"  class="input" name="password"  value=""></div>
				<div class="td"><input type="checkbox"  class="input"  name="is_root" <?=$user['id'] == 0  ? 'checked' :'' ?>  disabled readonly ></div>
				<div class="td"><button ><?=t('u_edit')?></button></div>	
			</form>

	  <? } 
	  
	  $new = d('new_user');
	 //  print_r($new);
	  ?>
			<form action='index.php' method="post" class="tr" autocomplete="off">
				<input type="hidden" name="form_key" value="<?=d('_form_key')?>">
				<input type="hidden" name="action" value="create">
				<input type="hidden"  class="input" name="nick" value="<?=d('new_nick')?>" >
				<!-- no auto fill workaround BEGIIN-->
				<input id="password" style="display:none" type="password" name="password">
				<!-- no auto fill workaround END-->
				<div class="td"><input type="text" class="input" readonly value="<?=t('till')?> <?=d('new_nick')?>" ></div>
				<div class="td"><input type="password" autocorrect="off" autocomplete="off" class="input" name="password" value=""></div>
				<div class="td"><input type="checkbox" class="input" name="is_root" readonly disabled ></div>
				<div class="td"><button ><?=t('u_add')?></button></div>	
			</form>


	</div> 
<?php include 'templates/footer.tpl' ?>
