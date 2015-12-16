<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 16/12/2015
 * Time: 12:40 PM
 */

namespace SymfonySmartyStandaloneForms\Type;

use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

trait FormTypeTrait
{
	public function buildView(FormView $view, FormInterface $form, array $options)
	{
		parent::buildView($view, $form, $options);

		if(!array_key_exists('help', $options)) {
			echo get_called_class() . ' not configured';
			print_r(array_keys($options));
		}
		$view->vars['help'] = $options['help'];
		$view->vars['input_icon'] = $options['input_icon'];
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		parent::configureOptions($resolver);

		$resolver->setDefaults(array(
			'help' => null,
			'input_icon' => null,
		));
	}
}