<?php

namespace SymfonySmartyStandaloneForms;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormView;
use Symfony\Bundle\FrameworkBundle\Templating\Helper\FormHelper;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class FormErrorsTrait
 * Helper trait to get form error messages
 * @package SymfonySmartyStandaloneForms
 */
trait FormErrorsTrait
{
	/**
	 * @param Form $form
	 * @return JsonResponse
	 */
	protected function getFormErrorJsonResponse(Form $form) {
		return new JsonResponse(['error' => true, 'errors' => $this->getFormErrorMessages($form)], Response::HTTP_UNPROCESSABLE_ENTITY);
	}
	
	/**
	 * @param Form $form
	 * @return array
	 */
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
	
	/**
	 * @param Form $form
	 * @param FormHelper $formHelper
	 * @return array
	 */
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

	/**
	 * @param Form $form
	 * @param FormHelper $formHelper
	 * @return array
	 */
	public function getFormErrorMessagesAsStrings(Form $form, FormHelper $formHelper) {
		$errors = $this->getFormErrorMessagesWithLabels($form, $formHelper);
		$errors = $this->getFormErrorMessagesAsSingleLevelArray($errors);
		
		return $errors;
	}

	/**
	 * @param Form $form
	 * @param FormHelper $formHelper
	 * @return string
	 */
	public function getFormErrorMessagesAsString(Form $form, FormHelper $formHelper) {
		$str = '';
		foreach($this->getFormErrorMessagesAsStrings($form, $formHelper) as $fieldName => $message) {
			$message = trim($message, '.');
			$str .= $fieldName . ' - ' . $message . ', ';
		}

		return trim($str, ', ');
	}
	
	/**
	 * @param array $arr
	 * @param int $depth
	 * @return array
	 */
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

		$arr = array_filter($arr, function($val) {
			return $val != '' || is_array($val);
		});

		return $arr;
	}
	
	/**
	 * @param Form $form
	 * @param FormHelper $formHelper
	 * @param FormView $formView
	 * @param array $variables
	 * @return string
	 */
	public function getFormErrorMessagesAsHtml(Form $form, FormHelper $formHelper, FormView $formView, array $variables = array()) {
		$errors = $this->getFormErrorMessagesAsStrings($form, $formHelper);
		$variables['errors'] = $errors;

		return $formHelper->block($formView, 'form_all_errors', $variables);
	}
}