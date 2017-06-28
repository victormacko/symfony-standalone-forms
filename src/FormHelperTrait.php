<?php

namespace SymfonyStandaloneForms;

use Smarty;

use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\Loader\FilesystemLoader;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\XliffFileLoader;
use Symfony\Bundle\FrameworkBundle\Templating\Helper\TranslatorHelper;


//form helpers
use Symfony\Bundle\FrameworkBundle\Templating\Helper\FormHelper;
use Symfony\Component\Form\Extension\Templating\TemplatingRendererEngine;
use Symfony\Component\Form\FormRenderer;
use \Exception;

/**
 * Class FormHelperTrait
 * Designed to be attached to a controller or Smarty itself.
 * @package SymfonyStandaloneForms
 */
trait FormHelperTrait
{
	protected $form_helper;
	protected $symfonyVendorDir = null;
	
	/**
	 * @param $dir
	 * @throws Exception
	 */
	public function setSymfonyVendorDir($dir) {
		if(realpath($dir) === false) {
			throw new Exception('Symfony directory "' . $dir . '" doesnt exist');
		}
		$this->symfonyVendorDir = $dir;
	}

	/**
	 * Get a list of paths to the form themes
	 **/
	protected function getFormThemePaths() {
		$vendorDir = $this->symfonyVendorDir;

		$formDir = $vendorDir . '/framework-bundle/Resources/views/Form';
		$defaultThemes = [$formDir, __DIR__ . '/../views/Form'];

		return $defaultThemes;
	}
	
	/**
	 * @return FormHelper
	 */
	public function getFormHelper() {
		if(!$this->form_helper) {
			// Set up requirements - hopefully we can facilitate this more in 2.2
			$engine = new PhpEngine(new SimpleTemplateNameParser(realpath(__DIR__ . '/../views/Form')), new FilesystemLoader(array()));

			//set helpers
			$vendorDir = $this->symfonyVendorDir;

			$defaultThemes = $this->getFormThemePaths();

			$form_helper = new FormHelper(new FormRenderer(new TemplatingRendererEngine($engine, $defaultThemes), null));

			$translator = new Translator('en');
			$translator->addLoader('xlf', new XliffFileLoader());
			$translator->addResource('xlf', realpath($vendorDir . '/form/Resources/translations/validators.en.xlf'), 'en', 'validators');
			$translator->addResource('xlf', realpath($vendorDir . '/validator/Resources/translations/validators.en.xlf'), 'en', 'validators');

			$engine->addHelpers(array($form_helper, new TranslatorHelper($translator)));

			$this->form_helper = $form_helper;
		}

		return $this->form_helper;
	}
}