<?php

namespace SymfonyStandaloneForms\Type;

use Symfony\Component\Form\Extension\Core\Type\DateTimeType as ParentDateTimeType;

class DateTimeType extends ParentDateTimeType
{
	use FormTypeTrait;
}