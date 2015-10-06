<?php

namespace SymfonySmartyStandaloneForms;

use \Smarty;
use \Smarty_Internal_Template;
use Symfony\Bundle\FrameworkBundle\Templating\Helper\FormHelper;

/**
 * Designed to be instantiated and registered with the main smarty variable
 */
class SmartyFormPlugins
{
	protected $formHelper = null;

	public function __construct(FormHelper $formHelper) {
		$this->formHelper = $formHelper;
	}

	public function formStart(array $params, Smarty_Internal_Template $smartyTemplate) {
		return $this->formCall('start', $params, $smartyTemplate);
	}

	public function formEnd(array $params, Smarty_Internal_Template $smartyTemplate) {
		return $this->formCall('end', $params, $smartyTemplate);
	}

	public function formRest(array $params, Smarty_Internal_Template $smartyTemplate) {
		return $this->formCall('rest', $params, $smartyTemplate);

	}

	public function formLabel(array $params, Smarty_Internal_Template $smartyTemplate) {
		return $this->formCall('label', $params, $smartyTemplate);
	}

	public function formWidget(array $params, Smarty_Internal_Template $smartyTemplate) {
		return $this->formCall('widget', $params, $smartyTemplate);
	}

	public function formRow(array $params, Smarty_Internal_Template $smartyTemplate) {
		return $this->formCall('row', $params, $smartyTemplate);
	}

	public function formErrors(array $params, Smarty_Internal_Template $smartyTemplate) {
		return $this->formHelper->errors($params['form']);
	}

	public function formCall($fnName, array $params, Smarty_Internal_Template $smartyTemplate) {
		$form = $params['form'];
		unset($params['form']);

		return call_user_func([$this->formHelper, $fnName], $form, $params);
	}

	public function registerFormPluginsWithSmarty(Smarty $smarty) {
		$smarty->registerPlugin('function', 'form_start', array($this, 'formStart'));
		$smarty->registerPlugin('function', 'form_errors', array($this, 'formErrors'));
		$smarty->registerPlugin('function', 'form_row', array($this, 'formRow'));
		$smarty->registerPlugin('function', 'form_label', array($this, 'formLabel'));
		$smarty->registerPlugin('function', 'form_widget', array($this, 'formWidget'));
		$smarty->registerPlugin('function', 'form_rest', array($this, 'formRest'));
		$smarty->registerPlugin('function', 'form_end', array($this, 'formEnd'));
	}
}