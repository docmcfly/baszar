<? include 'templates/header.tpl' ?>
 <div class="table">
	<form action='index.php' method="post" >
	  <input type="hidden" name="form_key" value="<?=d('_form_key')?>">
	  <input type="hidden" name="action" value="login">
		<div class="tr">
			<div class="td">
				<label for="nick"><?=t('user') ?></label>
			</div>	
			<div class="td">
				<select name="nick">
					<option value="admin"><?=t('admin')?></option>
					<? foreach(d('users') AS $user) {?>
					<option value="<?=$user['nick']?>"><?=t('till')?> <?=$user['nick']?></option>
					<? } ?>
				</select>
			</div>
		</div>
		<div class="tr">
			<div class="td">
				<label for="password"><?=t('password')?></label>
			</div>
			<div class="td">
				<input type="password"  class="input" name="password">
			</div>
		</div>
		<div class="tr">
			<div class="td">
				<label class="submit" for="login"><?=t('login')?></label>
			</div>
			<div class="td">
				<button><?=t('login')?></button>
			</div>
		</div>
	</form>
	<a href="ca-root.pem"><?=t('ca_rootCert')?></a>	
</div>

<? include 'templates/footer.tpl' ?>
