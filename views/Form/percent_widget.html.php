<div class="input-group">
	<?php echo $view['form']->block($form, 'form_widget_simple',  ['help' => $help, 'type' => (isset($type) ? $type : 'text'), 'help' => null]) ?>
	<span class="input-group-addon">%</span>
</div>

<?php if (isset($help)) : ?>
	<span class="help-block"><?php echo $view->escape($help) ?></span>
<?php endif ?>