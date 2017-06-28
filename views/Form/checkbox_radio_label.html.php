<?	// Do not display the label if widget is not defined in order to prevent double label rendering
if(isset($widget)) {
	if($required) {
		$label_attr['class'] = trim((isset($label_attr['class']) ? $label_attr['class'] : '') . ' required');
	}
	if (isset($parent_label_class)) {
		$label_attr['class'] = trim((isset($label_attr['class']) ? $label_attr['class'] : '') . ' ' . $parent_label_class);
	}
	if($label !== false && !$label) {
		$label = $view['form']->humanize($name);
	}
?>
<label<? foreach($label_attr as $attrname => $attrvalue) { ?> <?= $view->escape($attrname) ?>="<?= $view->escape($attrvalue) ?>"<? } ?>>
<?= $widget ?> <?= $view->escape(($label !== false ? ($translation_domain === false ? $label : $view['translator']->trans($label, array(), $translation_domain)) : '')) ?>
</label>
<? } ?>