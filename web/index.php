<?php

require __DIR__ . '/../vendor/autoload.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

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
use \SymfonySmartyStandaloneForms\FormErrorsTrait;
use SymfonySmartyStandaloneForms\SmartyFormPlugins;

// setup a class of some-sort which will include the form-helper-trait.
// This could in-theory be a class which extends smarty itself if needed too.
class FormController {
	use FormHelperTrait {
		getFormThemePaths as getFormThemePathsDefault;
	}
	use FormErrorsTrait;

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

use SymfonySmartyStandaloneForms\Type\TextType;
use SymfonySmartyStandaloneForms\Type\ChoiceType;
use SymfonySmartyStandaloneForms\Type\YesNoChoiceType;
use SymfonySmartyStandaloneForms\Type\CheckboxType;
use SymfonySmartyStandaloneForms\Type\EmailType;
use SymfonySmartyStandaloneForms\Type\MoneyType;
use SymfonySmartyStandaloneForms\Type\PercentType;

// Create our first form!
$formBuilder = $formFactory->createBuilder('form', null, ['method' => 'POST', 'extra_fields_message' => 'This form should not contain extra fields - "{{ extra_fields }}"'])
	->add('firstName', TextType::class, array(
		'constraints' => array(
			new NotBlank(),
			new Length(['min' => 4]),
		),
	))
	->add('lastName', TextType::class, array(
		'label' => 'My last name',
		'constraints' => array(

		),
		'help' => 'last here please',
	))
	->add('like_chocolate', YesNoChoiceType::class, array(
		'label' => 'Like chocolate?',
		'help' => 'this is some help',
		'constraints' => array(

		),
	))
	->add('phone', TextType::class, array(
			'input_icon' => 'fa fa-phone',
			'help' => 'This is your preferred phone number.',
			'constraints' => array(

			),
	))
	->add('phone2', TextType::class, array(
			'input_icon' => 'fa fa-phone',
			'help' => 'This is your preferred phone number.',
			'constraints' => array(

			),
	))
	->add('money_box', MoneyType::class, array(
		'input_icon' => 'fa fa-phone',
		'help' => 'This is your preferred phone number.',
		'constraints' => array(

		),
	))
	->add('percent_box', PercentType::class, array(
		'help' => 'This is your preferred phone number.',
		'constraints' => array(

		),
	))
	->add('complex', 'collection', ['compound' => true, 'inherit_data' => true])
	->add('email', EmailType::class, array(
		'help' => 'Email address here please',
		'constraints' => array(
			new NotBlank(),
			new \Symfony\Component\Validator\Constraints\Email(),
			new Length(['max' => 4]),
			new Length(['max' => 5]),
		),
	))
	->add('gender', ChoiceType::class, array(
		'choices' => array('m' => 'Male', 'f' => 'Female'),
		'help' => 'Gender here please',
	))
	->add('gender_checkbox_inline', ChoiceType::class, ['expanded' => true, 'multiple' => true, 'choices' => [
		'm' => 'Boy', 'f' => 'Girl'], 'label_attr' => ['class' => 'checkbox-inline']])
	->add('gender_inline', ChoiceType::class, ['expanded' => true, 'choices' => [
		'm' => 'Boy', 'f' => 'Girl'], 'label_attr' => ['class' => 'radio-inline']])
	->add('gender_inline_no_label', ChoiceType::class, ['expanded' => true, 'choices' => [
		'm' => 'Boy', 'f' => 'Girl'], 'label_attr' => ['class' => 'radio-inline'], 'label' => false])
	->add('newsletter', CheckboxType::class, array(
		'empty_data' => '0',
		'required' => false,
		'help' => 'Tick to get candy'
	))
	->add('my_long_temp_field', TextType::class, array(
		'label' => 'Abcd',
		'help' => 'Fav colour?',
		'empty_data' => '0',
		'required' => false,
	))
	->add('go', 'submit');
$formBuilder->get('complex')->add('my_name', 'text', ['constraints' => [new NotBlank()]])->add('lName', 'text');

$form = $formBuilder->getForm();

$request = Request::createFromGlobals();

$form->handleRequest($request);

if ($form->isValid()) {
	echo 'Form is valid - data: ';
	var_dump($form->getData());
} else {
	//print_r(getFormErrorMessages($form));
}

$formView = $form->createView();

$form2 = clone $form;
$formView2 = $form2->createView();

$form3 = clone $form;
$formView3 = $form3->createView();

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
$smarty->assign(['form' => $formView, 'form2' => $formView2, 'form3' => $formView3, 'isValid' => $form->isValid(), 'isSubmitted' => $form->isSubmitted()]);

// show the form as it should be.
$smarty->display('test.tpl');



echo "<hr />\n\n\n";

// alternatively, we can also generate the form using raw PHP instead too;
$formView = $form->createView();

$form_helper = $formController->getFormHelper();
echo 'Start: ' . $form_helper->start($formView) . "\n";
echo 'Fields: ' . $form_helper->rest($formView) . "\n";
echo 'End: ' . $form_helper->end($formView) . "<br />\n";


echo 'Label: ' . $form_helper->humanize('break_') . "<br />\n";
echo 'errors (array): ' . print_r($formController->getFormErrorMessagesAsStrings($form, $form_helper), true) . "<hr />\n";
echo 'errors (html): ' . $formController->getFormErrorMessagesAsHtml($form, $form_helper, $formView, ['include_container' => false, 'list_item_icon' => false]) . "<hr />\n";
echo 'errors (str): ' . $formController->getFormErrorMessagesAsString($form, $form_helper, $formView, ['include_container' => false, 'list_item_icon' => false]) . "<hr />\n";