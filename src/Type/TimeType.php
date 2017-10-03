<?php

namespace SymfonyStandaloneForms\Type;

use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\TimeType as ParentTimeType;
use Symfony\Component\Form\FormBuilderInterface;

class TimeType extends ParentTimeType
{
	use FormTypeTrait;
	
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		parent::buildForm($builder, $options);
		
		$transform = function ($strFromModel) {
			if($strFromModel === '') {
				return null;
			}
			
			return $strFromModel;
		};
		
		$reverseTransform = function ($time) use ($options) {
			if($time === '' || $time == null) {
				return '';
			}
			
			$time = str_replace('.', ':', $time);
			
			// handling & conversion of hh:mm am|pm format
			if(preg_match('/^([0-9]{1,2})[:.,\s]([0-9]{2})\s*(am|pm)$/i', $time, $matches) > 0) {
				if(strtolower($amPm) == 'am') {
					if($matches[1] == '12') {
						$matches[1] = 0;
					}
				} else if(strtolower($matches[3]) == 'pm') {
					if ($matches[1] != 12) {
						$matches[1] += 12;
					}
				}
				
				$time = $matches[1] . ':' . $matches[2];
			}
			
			return (string)$time;
		};
		
		$builder
			->addViewTransformer(new CallbackTransformer(
				$transform,
				$reverseTransform,
				true
			))
		;
	}
}