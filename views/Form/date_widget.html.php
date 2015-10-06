<?php if ($widget == 'single_text'): ?>
	<?php echo $view['form']->block($form, 'form_widget_simple'); ?>
<?php else: ?>
	<? $attr['class'] = trim((isset($attr['class']) ? $attr['class'] : '') . ' form-inline')	?>
	<?	if(!isset($datetime) || $datetime === false) {	?>
	<div <?php echo $view['form']->block($form, 'widget_container_attributes', ['attr' => $attr]) ?>>
	<?	}	?>
		<?php echo str_replace(array('{{ year }}', '{{ month }}', '{{ day }}'), array(
			$view['form']->widget($form['year'], ['attr' => $attr]),
			$view['form']->widget($form['month'], ['attr' => $attr]),
			$view['form']->widget($form['day'], ['attr' => $attr]),
		), $date_pattern) ?>
	<?	if(!isset($datetime) || $datetime === false) {	?>
	</div>
	<?	}	?>
<?php endif ?>
