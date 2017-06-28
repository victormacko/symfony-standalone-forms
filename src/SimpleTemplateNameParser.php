<?php

namespace SymfonyStandaloneForms;

use Symfony\Component\Templating\TemplateReference;
use Symfony\Component\Templating\TemplateNameParserInterface;

/**
 * Class SimpleTemplateNameParser
 *
 * @package SymfonyStandaloneForms
 */
class SimpleTemplateNameParser implements TemplateNameParserInterface
{
	private $root;
	
	/**
	 * SimpleTemplateNameParser constructor.
	 *
	 * @param string $root
	 */
	public function __construct($root)
	{
		$this->root = $root;
	}
	
	/**
	 * @param string $name
	 * @return TemplateReference
	 */
	public function parse($name)
	{
		if (false !== strpos($name, ':')) {
			$path = str_replace(':', '/', $name);
		} else {
			$path = $this->root . '/' . $name;
		}
//echo " - " . $path . "<br />";
		return new TemplateReference($path, 'php');
	}
}