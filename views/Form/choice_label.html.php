<?
	$label_attr['class'] = isset($label_attr['class']) ? $label_attr['class'] : '';
	$label_attr['class'] = str_replace('checkbox-inline', '', $label_attr['class']);
	$label_attr['class'] = str_replace('radio-inline', '', $label_attr['class']);
	$label_attr['class'] = trim($label_attr['class']);
?>
<?= $view['form']->block($form, 'form_label', ['label_attr' => $label_attr]) ?>