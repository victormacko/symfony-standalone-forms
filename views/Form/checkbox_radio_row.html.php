<div class="form-group<?= !$valid ? ' has-error' : '' ?>">
	<div class="<?= $view['form']->block($form, 'form_label_class') ?>"></div>
	<div class="<?= $view['form']->block($form, 'form_group_class') ?>">
		<?= $view['form']->widget($form) ?>
		<?= $view['form']->errors($form) ?>
	</div>
</div>
