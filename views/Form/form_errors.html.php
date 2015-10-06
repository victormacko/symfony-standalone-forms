<?php if (count($errors) > 0): ?>
<?	if (isset($form['parent']) && $form['parent']) { ?><span class="help-block"><? } else { ?><div class="alert alert-danger"><? } ?>
	<ul class="list-unstyled">

		<?php foreach ($errors as $error): ?>
			<li><span class="glyphicon glyphicon-exclamation-sign"></span> <?php echo $error->getMessage() ?></li>
		<?php endforeach; ?>
	</ul>
<?	if (isset($form['parent']) && $form['parent']) { ?></span><? } else { ?></div><? } ?>
<?php endif ?>
