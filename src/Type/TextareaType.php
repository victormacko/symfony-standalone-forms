<?php

namespace SymfonyStandaloneForms\Type;

use Symfony\Component\Form\Extension\Core\Type\TextareaType as ParentTextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class TextareaType extends ParentTextareaType
{
	use FormTypeTrait;
}