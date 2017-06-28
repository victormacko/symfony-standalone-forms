<?php if ($widget == 'single_text'): ?>
	<?php echo $view['form']->block($form, 'form_widget_simple'); ?>
<?php else: ?>
	<? $attr['class'] = trim((isset($attr['class']) ? $attr['class'] : '') . ' form-inline')	?>
	<div <?php echo $view['form']->block($form, 'widget_container_attributes', ['attr' => $attr]) ?>>
		<?php echo $view['form']->errors($form['date']).' '.$view['form']->errors($form['time']) ?>
		<?php echo $view['form']->widget($form['date'], ['datetime' => true]).' '.
			$view['form']->widget($form['time'], ['datetime' => true]) ?>
	</div>
<?php endif ?>
