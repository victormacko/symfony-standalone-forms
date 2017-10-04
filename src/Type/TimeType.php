<?php

namespace SymfonyStandaloneForms\Type;

use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\TimeType as ParentTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use SymfonyStandaloneForms\DataTransformer\StrToTimeTransformer;

class TimeType extends ParentTimeType
{
	use FormTypeTrait;
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		parent::buildForm($builder, $options);
		
		$builder->addViewTransformer(new StrToTimeTransformer());
	}
}