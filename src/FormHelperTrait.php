<?php

namespace SymfonySmartyStandaloneForms;

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
use Symfony\Component\Form\Form;


/**
 * Class FormHelperTrait
 * Designed to be attached to a controller or Smarty itself.
 * @package SymfonyStandaloneForms
 */
trait FormHelperTrait
{
	protected $form_helper;

	public function getFormHelper() {
		if(!$this->form_helper) {
			// Set up requirements - hopefully we can facilitate this more in 2.2
			$engine = new PhpEngine(new SimpleTemplateNameParser(realpath(__DIR__ . '/../views/Form')), new FilesystemLoader(array()));

//set helpers
			$vendorDir = __DIR__ . '/../vendor';
			$formDir = $vendorDir . '/symfony/framework-bundle/Resources/views/Form';
			$defaultThemes = [$formDir, __DIR__ . '/../views/Form'];

			$form_helper = new FormHelper(new FormRenderer(new TemplatingRendererEngine($engine, $defaultThemes), null));

			$translator = new Translator('en');
			$translator->addLoader('xlf', new XliffFileLoader());
			$translator->addResource('xlf', realpath($vendorDir . '/symfony/form/Resources/translations/validators.en.xlf'), 'en', 'validators');
			$translator->addResource('xlf', realpath($vendorDir . '/symfony/validator/Resources/translations/validators.en.xlf'), 'en', 'validators');

			$engine->addHelpers(array($form_helper, new TranslatorHelper($translator)));

			$this->form_helper = $form_helper;
		}

		return $this->form_helper;
	}

	public function getFormErrorMessages(Form $form) {
		$errors = array();

		foreach ($form->getErrors() as $key => $error) {
			if ($form->isRoot()) {
				$errors['#'][] = $error->getMessage();
			} else {
				$errors[] = $error->getMessage();
			}
		}

		foreach ($form->all() as $child) {
			if (!$child->isValid()) {
				$errors[$child->getName()] = $this->getFormErrorMessages($child);
			}
		}

		return $errors;
	}
}