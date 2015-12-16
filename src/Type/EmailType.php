<?php

namespace SymfonySmartyStandaloneForms\Type;

use Symfony\Component\Form\Extension\Core\Type\EmailType as ParentEmailType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class EmailType extends ParentEmailType
{
	use FormTypeTrait;
}