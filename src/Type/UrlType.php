<?php

namespace SymfonyStandaloneForms\Type;

use Symfony\Component\Form\Extension\Core\Type\UrlType as ParentUrlType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class UrlType extends ParentUrlType
{
	use FormTypeTrait;
}