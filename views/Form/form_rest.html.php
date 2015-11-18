<?php foreach ($form as $child): ?>
	<?php if (!$child->isRendered()): ?>
		<?php echo $view['form']->row($child, ['form_group_class' => (isset($form_group_class) ? $form_group_class : ''), 'form_label_class' => (isset($form_label_class) ? $form_label_class : '')]) ?>
	<?php endif; ?>
<?php endforeach; ?>
