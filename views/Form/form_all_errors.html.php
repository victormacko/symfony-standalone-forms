<?php if (count($errors) > 0): ?>
<?	$includeContainer = (!isset($include_container) || $include_container === true);	?>
<?	$list_item_icon = (isset($list_item_icon) ? $list_item_icon : 'glyphicon glyphicon-exclamation-sign');	?>
<?	$list_class = (isset($list_class) ? $list_class : 'list-unstyled');	?>

<?	if($includeContainer) {
		if (isset($form['parent']) && $form['parent']) { ?><span class="help-block"><? } else { ?><div class="alert alert-danger"><? }
	}	?>
	<ul class="<?= $list_class ?>">

		<?php foreach ($errors as $fieldName => $errorMsg): ?>
			<li><? if($list_item_icon !== false) { ?><span class="<?= $list_item_icon ?>"></span> <? } ?><?php echo $fieldName ?> - <?php echo $errorMsg ?></li>
		<?php endforeach; ?>
	</ul>
<?	if($includeContainer) {
		if (isset($form['parent']) && $form['parent']) { ?></span><? } else { ?></div><? }
	}	?>
<?php endif ?>
