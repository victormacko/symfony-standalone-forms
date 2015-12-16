<?php

namespace SymfonySmartyStandaloneForms\Type;

use Symfony\Component\Form\Extension\Core\Type\TextType as ParentTextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class TextType extends ParentTextType
{
	use FormTypeTrait;
}