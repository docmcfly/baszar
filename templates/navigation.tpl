<?php
  $links = d('links');
?>
<?php if($links !== false) { ?>
<div class="navigation">
  <ul class="navigation">
    <?php
      $count = count($links);
      $i = 1 ;
        foreach ($links as $link => $class) { ?><li class="<?=$class?> <?=$count === $i ? 'last': '' ?>"><?=$link?></li><?php $i++;  } ?>
  </ul>
<div style="clear:both;"></div>
</div>
<?php } ?>


