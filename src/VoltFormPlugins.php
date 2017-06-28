<?php

namespace SymfonyStandaloneForms;

use \Symfony\Bundle\FrameworkBundle\Templating\Helper\FormHelper;
use Exception;

/**
 * Designed to be instantiated and registered with the Volt compiler
 *
 * See the following for more info on Volt; https://olddocs.phalconphp.com/en/latest/reference/volt.html
 */
class VoltFormHelper
{
	use FormHelperTrait;
	
	/**
	 * @var FormHelper
	 */
	static protected $formHelper = null;
	
	static public function setFormHelper(FormHelper $formHelper) {
		self::$formHelper = $formHelper;
	}
	
	static public function formStart($form, $params = []) {
		return static::formCall('start', $form, $params);
	}
	
	static public function formEnd($form, array $params = []) {
		return static::formCall('end', $form, $params);
	}
	
	static public function formRest($form, array $params = []) {
		return static::formCall('rest', $form, $params);
		
	}
	
	static public function formLabel($widget, array $params = []) {
		
		$label = null;
		if(array_key_exists('label', $params)) {
			$label = $params['label'];
			unset($params['label']);
		}
		
		return static::$formHelper->label($widget, $label, $params);
	}
	
	static public function formWidget($form, array $params = []) {
		return self::formCall('widget', $form, $params);
	}
	
	static public function formRow($form, array $params = []) {
		return self::formCall('row', $form, $params);
	}
	
	static public function formErrors($form) {
		return self::$formHelper->errors($form);
	}
	
	static public function formCall($fnName, $form, array $params) {
		if(!self::$formHelper) {
			throw new Exception('Form helper not set');
		}
		
		return call_user_func([self::$formHelper, $fnName], $form, $params);
	}
	
	/**
	 * @param $compiler
	 * @param string $symfonyVendorDir
	 */
	static public function registerFormPluginsWithVolt($compiler, $symfonyVendorDir = null) {
		if(!self::$formHelper) {
			$helperObj = new static();
			
			if(!$symfonyVendorDir) {
				$symfonyVendorDir = __DIR__ . '/../../../../vendor/symfony';
			}
			
			$helperObj->setSymfonyVendorDir($symfonyVendorDir);
			self::$formHelper = $helperObj->getFormHelper();;
		}
		
		// the compiler needs to have statically callable functions (or an anonymous function which
		// itself then returns a statically callable function)
		
		$compiler->addFunction('form_start', static::class . '::formStart');
		$compiler->addFunction('form_errors', static::class . '::formErrors');
		$compiler->addFunction('form_row', static::class . '::formRow');
		$compiler->addFunction('form_label', static::class . '::formLabel');
		$compiler->addFunction('form_widget', static::class . '::formWidget');
		$compiler->addFunction('form_rest', static::class . '::formRest');
		$compiler->addFunction('form_end', static::class . '::formEnd');
	}
}