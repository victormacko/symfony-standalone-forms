<?php
/**
 * Created by PhpStorm.
 * User: victor
 * Date: 26/08/15
 * Time: 12:22 AM
 */

namespace SymfonyStandaloneForms\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class YesNoChoiceType extends ChoiceType
{
	use FormTypeTrait {
		configureOptions as configureFormTypeOptions;
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$this->configureFormTypeOptions($resolver);
		parent::configureOptions($resolver);

		$yesNoList = ['Yes', 'No'];

		$resolver->setDefaults([
			'choices' => array_combine($yesNoList, $yesNoList),
			'expanded' => true,
		]);
	}
}