<?php

namespace SymfonyStandaloneForms\Type;

use Symfony\Component\Form\Extension\Core\Type\NumberType as ParentNumberType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class NumberType extends ParentNumberType
{
	use FormTypeTrait;
}