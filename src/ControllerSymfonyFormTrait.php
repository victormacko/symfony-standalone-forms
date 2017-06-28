<?php

namespace SymfonyStandaloneForms;

use Symfony\Component\Security\Csrf\CsrfTokenManager;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\Extension\Csrf\CsrfExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;

/**
 * Trait ControllerSymfonyFormTrait
 *
 * This can be used in MVC controllers to include symfony create-form/create-form-builder methods
 *
 * @package SymfonyStandaloneForms
 */
trait ControllerSymfonyFormTrait {
	/**
	 * Create a form builder to use for pages that need it.
	 * @param $type
	 * @param null $data
	 * @param array $options
	 * @return \Symfony\Component\Form\FormInterface
	 */
	protected function createForm($type, $data = null, array $options = []) {
		$formFactory = $this->getFormFactory($options);
		
		$builder = $formFactory->create($type, $data, $options);
		
		return $builder;
	}
	
	/**
	 * @param null $data
	 * @param array $options
	 * @return \Symfony\Component\Form\FormBuilderInterface
	 */
	protected function createFormBuilder($data = null, array $options = [])
	{
		return $this->getFormFactory($options)->createBuilder(FormType::class, $data, $options);
	}
	
	/**
	 * @param array $options
	 * @return \Symfony\Component\Form\FormFactoryInterface
	 */
	private function getFormFactory(array $options = []) {
		// Set up the CSRF Token Manager
		$csrfTokenManager = new CsrfTokenManager();
		
		// Set up the Validator component
		$validator = Validation::createValidator();
		
		$formFactoryBuilder = Forms::createFormFactoryBuilder();
		$formFactoryBuilder->addExtension(new HttpFoundationExtension());
		$formFactoryBuilder->addExtension(new ValidatorExtension($validator));
		$formFactoryBuilder->addExtension(new CsrfExtension($csrfTokenManager));
		
		$formFactory = $formFactoryBuilder->getFormFactory();
		
		return $formFactory;
	}
}