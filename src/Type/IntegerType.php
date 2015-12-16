<?php

namespace SymfonySmartyStandaloneForms\Type;

use Symfony\Component\Form\Extension\Core\Type\IntegerType as ParentIntegerType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class IntegerType extends ParentIntegerType
{
	use FormTypeTrait;
}