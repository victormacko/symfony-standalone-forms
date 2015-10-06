<?
$parent_label_class = isset($parent_label_class) ? $parent_label_class : '';

$parent = '<input type="checkbox" ' . $view['form']->block($form, 'widget_attributes') .
	(strlen($value) > 0 ? ' value="' . $view->escape($value) . '"' : '') .
	($checked ? ' checked="checked"' : '') .
	' />';

if(strpos($parent_label_class, 'checkbox-inline') !== false) {	?>
	<?= $view['form']->block($form, 'checkbox_label', ['widget' => $parent])	?>
<?	} else {	?>
	<div class="checkbox">
		<?= $view['form']->block($form, 'checkbox_label', ['widget' => $parent])	?>
	</div>
<?	}
