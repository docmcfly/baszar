<?php
	$errors = d('error', false); 
	if($errors) { ?>
  <ul class="error_list"><?php
		foreach($errors as $error){
		?><li><?=t('error')?>: <?=t($error)?></li>
		<?php 
		}?>
  </ul>
<?php	} ?>

  <?php
  $status = d('status', false); 
  if($status) { ?>
  <ul class="status">
    <li><?=t('status')?>: <?=t($status)?></li>
  </ul>
<?php	} ?>
