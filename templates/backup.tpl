<? include 'templates/header.tpl' ?>
<h1><?=t('b_headline')?></h1>
<ul>
	<?
	$c = Config::get_instance();
	?>
	<li><a target="_blank" href="database/phpliteadmin.php"><?=t('b_database_admin_tool')?></a></li>
	<li><a href="<?=$c->get_db_filename()?>"><?=t('b_database')?></a></li>
	<li><?=t('b_important_keys')?>:	<pre><? 
	
	$r = print_r($c->get_accesses(), true);
	echo
	str_replace(')','', 
	str_replace( '(
', '',
	str_replace( '
        )
','',
		str_replace('
        (', '', str_replace("Array", "", $r))))) ?></pre></li>

</ul>

 
<? include 'templates/footer.tpl' ?>
