# Symfony standalone forms
Implementation of Symfony2 forms component with different templating engines

The 'views/Form' directory contains a bootstrap implementation (horizontal) of the symfony2 bootstrap created in Twig (https://github.com/symfony/symfony/blob/master/src/Symfony/Bridge/Twig/Resources/views/Form/bootstrap_3_layout.html.twig & https://github.com/symfony/symfony/blob/master/src/Symfony/Bridge/Twig/Resources/views/Form/bootstrap_3_horizontal_layout.html.twig)

The 'ControllerSymfonyFormTrait.php' file contains a trait to include in your base controller, which adds the 'createForm' and 'createFormBuilder' functions, as detailed here; http://symfony.com/doc/current/forms.html

## Smarty
web/index.php contains a 'demo' controller to pull together the various components, create a Smarty instance and then output it.

## Volt
Volt support is included

In the register-engine block (in services.php), include the following line;

```PHP
$view->registerEngines(array(
	'.volt' => function ($view, $di) use ($config) {
	
		$volt = new VoltEngine($view, $di);
		
		$volt->setOptions(array(
			'compiledPath' => $config->application->cacheDir,
			'compiledSeparator' => '_',
			'compileAlways' => true
		));
		
		$compiler = $volt->getCompiler();
		SymfonyFormHelper::registerFormPluginsWithVolt($compiler);
		
		return $volt;
	},
	'.phtml' => 'Phalcon\Mvc\View\Engine\Php'
));
```

Within your controller, to create the form, you just need to include the following;
```PHP
$form = $this
	->createFormBuilder()
	->add('testField', \SymfonyStandaloneForms\Type\TextType::class, [
		'constraints' => [
			new \Symfony\Component\Validator\Constraints\Length(['min' => 2])
		]
	])
	->add('submit', \Symfony\Component\Form\Extension\Core\Type\SubmitType::class)
	->getForm();
	
$form->handleRequest(\Symfony\Component\HttpFoundation\Request::createFromGlobals());
if($form->isSubmitted()) {
	if($form->isValid()) {
		// get data from field;
		$data = $form->get('testField')->getData();
	}
}

$this->view->form2 = $form->createView();
```

Your volt code will then need to include the standard template code to render forms - eg;
```
{{ form_start(form, {'attr': {'novalidate': 'novalidate'} }) }}
{{ form_row(form['testField']) }}
{{ form_rest(form) }}
{{ form_end(form) }}

```


## Plain PHP
There's also a plain php form rendering option also if smarty isn't your thing.