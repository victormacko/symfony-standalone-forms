<?php

namespace SymfonySmartyStandaloneForms\Type;

use Symfony\Component\Form\Extension\Core\Type\DateType as ParentDateType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class DateType extends ParentDateType
{
	use FormTypeTrait;
}