<!DOCTYPE html>
<html>

<head>

  <title>[<?=t('application')?>] - <?=t('title_'.d('_page'))?></title>
  <link rel="stylesheet" type="text/css" href="assets/main.css">
 <!-- <link rel="stylesheet" type="text/css" href="assets/main.css"> -->
  <script src="assets/jquery.js"></script>
 
  
</head>
<body >
	<!-- onload="init('<?=d('_page')?>');" > -->
  <div class="body">
    <div class="center">
      <a name="top">&nbsp;</a>
  <?php include 'templates/navigation.tpl' ?>
  <div class="content">
  <?php include 'templates/list_messages.tpl' ?>
  <div class="<?= d('_page').' '.str_replace('_', ' ', d('_page')) ?>">

