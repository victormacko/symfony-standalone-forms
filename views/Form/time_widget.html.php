<?php if ($widget == 'single_text'): ?>
	<?php echo $view['form']->block($form, 'form_widget_simple'); ?>
<?php else: ?>
	<?php $vars = $widget == 'text' ? array('attr' => array('size' => 1)) : array() ?>
	<? $attr['class'] = trim((isset($attr['class']) ? $attr['class'] : '') . ' form-inline')	?>
	<?	if(!isset($datetime) || $datetime === false) {	?>
	<div <?php echo $view['form']->block($form, 'widget_container_attributes', ['attr' => $attr]) ?>>
	<?	}	?>
		<?php
		// There should be no spaces between the colons and the widgets, that's why
		// this block is written in a single PHP tag
		echo $view['form']->widget($form['hour'], $vars);

		if ($with_minutes) {
			echo ':';
			echo $view['form']->widget($form['minute'], $vars);
		}

		if ($with_seconds) {
			echo ':';
			echo $view['form']->widget($form['second'], $vars);
		}
		?>
	<?	if(!isset($datetime) || $datetime === false) {	?>
	</div>
	<?	}	?>
<?php endif ?>
