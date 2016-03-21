<?php

namespace SymfonySmartyStandaloneForms\Type;

use Symfony\Component\Form\Extension\Core\Type\PercentType as ParentPercentType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class PercentType extends ParentPercentType
{
	use FormTypeTrait;
}