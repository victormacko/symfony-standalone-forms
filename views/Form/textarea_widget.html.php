<?
$class = isset($class) ? $class : '';
$class .= (!empty($attr['class']) ? ' ' . $attr['class'] : '');

if(!isset($type) || 'file' != $type) {
	$attr['class'] = trim($class . ' ' . $view['form']->block($form, 'form_widget_class'));
}
//print_r($attr);
?>
<textarea <?php echo $view['form']->block($form, 'widget_attributes', ['attr' => $attr]) ?>><?php echo $view->escape($value) ?></textarea>
<?php if (isset($help)) : ?>
	<span class="help-block"><?php echo $view->escape($help) ?></span>
<?php endif ?>
