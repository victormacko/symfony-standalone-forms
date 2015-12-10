<?

$input_icon = isset($input_icon) ? $input_icon : null;

// if an array is passed in, extract the values from it
if(is_array($input_icon)) {
	if(isset($input_icon['size'])) {
		$inputIconSize = $input_icon['size'];
	}
	if(isset($input_icon['position'])) {
		$inputIconPosition = $input_icon['position'];
	}
	if(isset($input_icon['tooltip'])) {
		$input_icon_tooltip = $input_icon['tooltip'];
	}

	$input_icon = isset($input_icon['icon']) ? $input_icon['icon'] : $input_icon[0];
}

// icon sizing
if(!isset($input_icon_size)) {
	if(isset($attr['class']) && strpos($attr['class'], 'sm') !== false) {
		$inputIconSize = 'input-icon-sm';
	} else if(strpos($attr['class'], 'lg') !== false) {
		$inputIconSize = 'input-icon-lg';
	}
}

// tooltip for icon
if(isset($input_icon_tooltip)) {
	$input_icon_tooltip = ' data-toggle="tooltip" title="' . $view->escape($input_icon_tooltip) . '"';
} else {
	$input_icon_tooltip = null;
}
$inputIconPosition = isset($inputIconPosition) ? $inputIconPosition : 'right';

if($input_icon) {

?>
<div class="input-icon <?= $inputIconSize ?> <?= $inputIconPosition ?>"><i class="<?= $input_icon ?>"<?= $input_icon_tooltip ?>></i>
<?
}

?>