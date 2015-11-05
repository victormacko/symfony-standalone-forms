<?php

require __DIR__ . '/../vendor/autoload.php';

/**
 * This is a demo of the 'controller', which sets up some backend vars first,
 * then creates a form, then outputs it.
 */

use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\Extension\Csrf\CsrfExtension;
use Symfony\Component\Form\Extension\Csrf\CsrfProvider\DefaultCsrfProvider;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\HttpFoundation\Request;

use \SymfonySmartyStandaloneForms\FormHelperTrait;
use SymfonySmartyStandaloneForms\SmartyFormPlugins;

// setup a class of some-sort which will include the form-helper-trait.
// This could in-theory be a class which extends smarty itself if needed too.
class FormController {
	use FormHelperTrait {
		getFormThemePaths as getFormThemePathsDefault;
	}

	// example of adding in your own paths...
	protected function getFormThemePaths() {
		$res = $this->getFormThemePathsDefault();

		//$res[] = __DIR__ . '/path/to/views/';

		return $res;
	}
}

// create ourselves a form....;
$validator = Validation::createValidator();

// Overwrite this with your own secret
$csrfSecret = '123456';

// Set up the form factory with all desired extensions
$formFactory = Forms::createFormFactoryBuilder()
	->addExtension(new HttpFoundationExtension())
	->addExtension(new CsrfExtension(new DefaultCsrfProvider($csrfSecret)))
	//->addExtension(new TemplatingExtension($engine, null, $defaultThemes))
	->addExtension(new ValidatorExtension($validator))
	->getFormFactory();

Request::enableHttpMethodParameterOverride();

// Create our first form!
$form = $formFactory->createBuilder('form', null, ['method' => 'POST', 'extra_fields_message' => 'This form should not contain extra fields - "{{ extra_fields }}"'])
	->add('firstName', 'text', array(
		'constraints' => array(
			new NotBlank(),
			new Length(['min' => 4]),
		),
	))
	->add('lastName', 'text', array(
		'label' => 'My last name',
		'constraints' => array(

		),
	))
	->add('email', 'email', array(
		'constraints' => array(
			new NotBlank(),
			new \Symfony\Component\Validator\Constraints\Email(),
			//        new MinLength(4),
		),
	))
	->add('gender', 'choice', array(
		'choices' => array('m' => 'Male', 'f' => 'Female'),
	))
	->add('gender_checkbox_inline', 'choice', ['expanded' => true, 'multiple' => true, 'choices' => [
		'm' => 'Boy', 'f' => 'Girl'], 'label_attr' => ['class' => 'checkbox-inline']])
	->add('gender_inline', 'choice', ['expanded' => true, 'choices' => [
		'm' => 'Boy', 'f' => 'Girl'], 'label_attr' => ['class' => 'radio-inline']])
	->add('gender_inline_no_label', 'choice', ['expanded' => true, 'choices' => [
		'm' => 'Boy', 'f' => 'Girl'], 'label_attr' => ['class' => 'radio-inline'], 'label' => false])
	->add('newsletter', 'checkbox', array(
		'empty_data' => '0',
		'required' => false,
	))
	->add('my_long_temp_field', 'text', array(
		'label' => 'Abcd',
		'empty_data' => '0',
		'required' => false,
	))
	->add('go', 'submit')
	->getForm();

$request = Request::createFromGlobals();

$form->handleRequest($request);

if ($form->isValid()) {
	echo 'Form is valid - data: ';
	var_dump($form->getData());
} else {
	//print_r(getFormErrorMessages($form));
}

$formView = $form->createView();

// ------------------------------------------------------------------

// initiate smarty & set basic stuff to get it going
$smarty = new Smarty();
$smarty->setTemplateDir(__DIR__ . '/../views/');
$smarty->setCompileDir('/tmp/test-standalone-forms-templates_c/');

// initiate our 'controller' (which is just a temp class which will hold our helper function)
$formController = new FormController();
$formController->setSymfonyVendorDir(__DIR__ . '/../vendor/symfony');

// register the form plugins with smarty, passing in the form helper which it talks to
$plugins = new SmartyFormPlugins($formController->getFormHelper());
$plugins->registerFormPluginsWithSmarty($smarty);

// give smarty some variables to play with to demonstrate everything works
$smarty->assign(['form' => $formView, 'isValid' => $form->isValid(), 'isSubmitted' => $form->isSubmitted()]);

// show the form as it should be.
$smarty->display('test.tpl');

echo "<hr />\n\n\n";

// alternatively, we can also generate the form using raw PHP instead too;
$formView = $form->createView();

$form_helper = $formController->getFormHelper();
echo 'Start: ' . $form_helper->start($formView);
echo 'Fields: ' . $form_helper->rest($formView);
echo 'End: ' . $form_helper->end($formView);
