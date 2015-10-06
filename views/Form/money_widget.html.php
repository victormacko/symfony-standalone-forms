<div class="input-group">
	<?	$prepend = substr($money_pattern, 0, 2) == '{{';	?>
	<? 	if (!$prepend) {		?>
	<span class="input-group-addon"><?= $view->escape(str_replace('{{ widget }}', '', $money_pattern)) ?></span>
	<? 	}	?>
	<?php echo $view['form']->block($form, 'form_widget_simple') ?>
	<? 	if ($prepend) {		?>
	<span class="input-group-addon"><?= str_replace('{{ widget }}', '', $money_pattern) ?></span>
	<? 	}	?>
</div>


