<?php

namespace SymfonyStandaloneForms\Type;

use Symfony\Component\Form\Extension\Core\Type\PasswordType as ParentPasswordType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class PasswordType extends ParentPasswordType
{
	use FormTypeTrait;
}