<?php

namespace SymfonySmartyStandaloneForms;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormView;
use Symfony\Bundle\FrameworkBundle\Templating\Helper\FormHelper;

/**
 * Class FormErrorsTrait
 * Helper trait to get form error messages
 * @package SymfonySmartyStandaloneForms
 */
trait FormErrorsTrait
{
	public function getFormErrorMessages(Form $form) {
		$errors = array();

		foreach ($form->getErrors() as $key => $error) {
			if ($form->isRoot()) {
				$errors['#'][] = $error->getMessage();
			} else {
				$errors[] = $error->getMessage();
			}
		}

		foreach ($form->all() as $child) {
			if (!$child->isValid()) {
				$errors[$child->getName()] = $this->getFormErrorMessages($child);
			}
		}

		return $errors;
	}

	public function getFormErrorMessagesWithLabels(Form $form, FormHelper $formHelper) {
		$errors = array();

		foreach ($form->getErrors() as $key => $error) {
			if ($form->isRoot()) {
				$errors['#'][] = $error->getMessage();
			} else {
				$errors[] = $error->getMessage();
			}
		}

		foreach ($form->all() as $child) {
			if (!$child->isValid()) {
				$label = $child->getConfig()->getOption('label');
				if(!$label) {
					$label = $formHelper->humanize($child->getName());
				}
				$errors[$label] = $this->getFormErrorMessagesWithLabels($child, $formHelper);
			}
		}

		return $errors;
	}

	public function getFormErrorMessagesAsStrings(Form $form, FormHelper $formHelper) {
		$errors = $this->getFormErrorMessagesWithLabels($form, $formHelper);
		$errors = $this->getFormErrorMessagesAsSingleLevelArray($errors);
		
		return $errors;
	}

	private function getFormErrorMessagesAsSingleLevelArray(array $arr, $depth = 0) {
		$depth++;
		foreach($arr as $key => $arrVal) {
			if(is_array($arrVal)) {
				$arrVal = array_filter($arrVal, function($val) {
					return $val != '' || is_array($val);
				});

				$arr[$key] = join(', ', $this->getFormErrorMessagesAsSingleLevelArray($arrVal, $depth));
				if($depth > 1) {
					$arr[$key] = $key . ' - ' . $arr[$key];
				}
			} else {
				$arr[$key] = $arrVal;
			}
		}

		return $arr;
	}

	public function getFormErrorMessagesAsHtml(Form $form, FormHelper $formHelper, FormView $formView, array $variables = array()) {
		$errors = $this->getFormErrorMessagesAsStrings($form, $formHelper);
		$variables['errors'] = $errors;

		return $formHelper->block($formView, 'form_all_errors', $variables);
	}
}