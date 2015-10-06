<?php

namespace SymfonySmartyStandaloneForms;

use Symfony\Component\Form\Form;

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
}